<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
if (is_dir($publicStorage)) {
    $iter2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($publicStorage));
    foreach ($iter2 as $file) {
        if ($file->isFile()) {
            $rel = ltrim(str_replace($publicStorage, '', $file->getPathname()), '\\/');
            $rel = ltrim('public/' . $rel, '\\/');
            $basename = $file->getBasename();
            $files[$basename][] = $rel;
        }
    }
}

$changes = [];
$skipped = [];

$items = MonitoringPelaporan::orderBy('created','desc')->get();
foreach ($items as $item) {
    $currentPath = $item->file_path;
    $link = $item->link;

    $basename = null;
    if (!empty($currentPath)) $basename = basename($currentPath);
    elseif (!empty($link)) $basename = basename($link);
    if (!$basename) continue;

    // skip if already exists
    if (!empty($currentPath) && Storage::disk('public')->exists(ltrim($currentPath, '/'))) continue;

    // exact
    if (isset($files[$basename]) && count(array_unique($files[$basename])) === 1) {
        $candidate = array_values(array_unique($files[$basename]))[0];
        $newRel = preg_replace('#^public/#','',$candidate);
        $changes[] = [
            'id'=>$item->id_monitoring,'nama_file'=>$item->nama_file,'old_file_path'=>$item->file_path,'old_link'=>$item->link,'new_file_path'=>$newRel,'new_link'=>'/storage/'.$newRel
        ];
        $item->file_path = $newRel;
        $item->link = '/storage/'.$newRel;
        $item->save();
        continue;
    }

    // fuzzy: find files whose basename contains DB basename (case-insensitive)
    $matches = [];
    foreach ($files as $fname => $rels) {
        if (stripos($fname, $basename) !== false) {
            foreach ($rels as $r) $matches[] = $r;
        }
    }
    $matches = array_values(array_unique($matches));
    if (count($matches) === 1) {
        $newRel = preg_replace('#^public/#','',$matches[0]);
        $changes[] = [
            'id'=>$item->id_monitoring,'nama_file'=>$item->nama_file,'old_file_path'=>$item->file_path,'old_link'=>$item->link,'new_file_path'=>$newRel,'new_link'=>'/storage/'.$newRel,'match_type'=>'fuzzy'
        ];
        $item->file_path = $newRel;
        $item->link = '/storage/'.$newRel;
        $item->save();
        continue;
    }

    $skipped[] = ['id'=>$item->id_monitoring,'nama_file'=>$item->nama_file,'candidates'=>implode('|', $matches)];
}

$ts = date('Ymd_His');
$backup = __DIR__ . "/relink_fuzzy_backup_{$ts}.csv";
$fh = fopen($backup,'w');
if ($fh) {
    fputcsv($fh, ['id','nama_file','old_file_path','old_link','new_file_path','new_link','match_type']);
    foreach ($changes as $c) fputcsv($fh, [$c['id'],$c['nama_file'],$c['old_file_path'],$c['old_link'],$c['new_file_path'],$c['new_link'],($c['match_type']??'exact')]);
    fclose($fh);
}

$skipfile = __DIR__ . "/relink_fuzzy_skipped_{$ts}.csv";
$fh2 = fopen($skipfile,'w');
if ($fh2) {
    fputcsv($fh2, ['id','nama_file','candidates']);
    foreach ($skipped as $s) fputcsv($fh2, [$s['id'],$s['nama_file'],$s['candidates']]);
    fclose($fh2);
}

echo "Fuzzy run done. Updated: " . count($changes) . " rows. Skipped: " . count($skipped) . "\n";
echo "Backup: {$backup}\n";
echo "Skipped: {$skipfile}\n";
