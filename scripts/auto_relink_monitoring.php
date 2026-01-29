<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Build file map from storage/app/public and public/storage
$rootStorage = storage_path('app/public');
$publicStorage = public_path('storage');
$files = [];

$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootStorage));
foreach ($iter as $file) {
    if ($file->isFile()) {
        $rel = ltrim(str_replace($rootStorage, '', $file->getPathname()), '\\/');
        $basename = $file->getBasename();
        $files[$basename][] = $rel;
    }
}
// also include public/storage in case some files exist only there
if (is_dir($publicStorage)) {
    $iter2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($publicStorage));
    foreach ($iter2 as $file) {
        if ($file->isFile()) {
            $rel = ltrim(str_replace($publicStorage, '', $file->getPathname()), '\\/');
            // normalize to storage relative path (same as storage/app/public)
            $rel = ltrim('public/' . $rel, '\\/');
            $basename = $file->getBasename();
            $files[$basename][] = $rel;
        }
    }
}

// Candidates: monitoring rows where file_path missing or file doesn't exist
$items = MonitoringPelaporan::orderBy('created','desc')->get();

$changes = [];
$unmatched = [];

foreach ($items as $item) {
    $currentPath = $item->file_path;
    $link = $item->link;

    // Determine target basename: prefer file_path basename, else link basename
    $basename = null;
    if (!empty($currentPath)) {
        $basename = basename($currentPath);
    } elseif (!empty($link)) {
        $basename = basename($link);
    }
    if (!$basename) continue;

    // If file_path exists and storage has it, skip
    $exists = false;
    if (!empty($currentPath) && Storage::disk('public')->exists(ltrim($currentPath, '/')) ) {
        $exists = true;
    }
    if ($exists) continue;

    if (!isset($files[$basename])) {
        $unmatched[] = [
            'id' => $item->id_monitoring,
            'nama_file' => $item->nama_file,
            'file_path' => $item->file_path,
            'link' => $item->link,
            'reason' => 'no-file-found'
        ];
        continue;
    }

    // Only update when there's exactly one candidate path
    $candidates = array_unique($files[$basename]);
    if (count($candidates) !== 1) {
        $unmatched[] = [
            'id' => $item->id_monitoring,
            'nama_file' => $item->nama_file,
            'file_path' => $item->file_path,
            'link' => $item->link,
            'candidates' => $candidates,
            'reason' => 'multiple-candidates'
        ];
        continue;
    }

    $newRel = $candidates[0];
    // if newRel starts with 'public/', strip that prefix to match storage/app/public
    $newRelNormalized = preg_replace('#^public/#', '', $newRel);

    // Backup original
    $changes[] = [
        'id' => $item->id_monitoring,
        'nama_file' => $item->nama_file,
        'old_file_path' => $item->file_path,
        'old_link' => $item->link,
        'new_file_path' => $newRelNormalized,
        'new_link' => '/storage/' . $newRelNormalized
    ];

    // Apply update
    $item->file_path = $newRelNormalized;
    $item->link = '/storage/' . $newRelNormalized;
    $item->save();
}

$timestamp = date('Ymd_His');
$backupCsv = __DIR__ . "/relink_backup_{$timestamp}.csv";
$fh = fopen($backupCsv, 'w');
if ($fh) {
    fputcsv($fh, ['id','nama_file','old_file_path','old_link','new_file_path','new_link']);
    foreach ($changes as $r) fputcsv($fh, $r);
    fclose($fh);
}

$unmatchedCsv = __DIR__ . "/relink_unmatched_{$timestamp}.csv";
$fh2 = fopen($unmatchedCsv, 'w');
if ($fh2) {
    // detect keys
    foreach ($unmatched as $i => $row) {
        if ($i===0) {
            fputcsv($fh2, array_keys($row));
        }
        // flatten candidates if present
        if (isset($row['candidates']) && is_array($row['candidates'])) {
            $row['candidates'] = implode('|', $row['candidates']);
        }
        fputcsv($fh2, $row);
    }
    fclose($fh2);
}

echo "Done. Updated: " . count($changes) . " rows. Unmatched: " . count($unmatched) . "\n";
echo "Backup: {$backupCsv}\n";
echo "Unmatched: {$unmatchedCsv}\n";
