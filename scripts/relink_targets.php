<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;

$targets = [
    'PK PERUBAHAN MATEUS DA SILVA CASINDA.pdf',
    'PK PERUBAHAN MUNADI.pdf',
    'PK PERUBAHAN NADELIA.pdf',
    'PK PERUBAHAN NOPENDI.pdf',
    'PK PERUBAHAN NURUL FITRI.pdf',
    'PK PERUBAHAN RACHMI RINI.pdf',
    'PK PERUBAHAN SYARIEF HIDAYAT.pdf',
    'PK PERUBAHAN SYARIFUDIN.pdf',
    'PK PERUBAHAN TAJUDDIN.pdf',
    'PK PERUBAHAN TARMUJI.pdf',
];

$rootStorage = storage_path('app/public');
$publicStorage = public_path('storage');
$storageFiles = [];

$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootStorage));
foreach ($iter as $file) {
    if ($file->isFile()) {
        $rel = ltrim(str_replace($rootStorage, '', $file->getPathname()), '\\\/');
        $basename = $file->getBasename();
        $storageFiles[$rel] = $basename;
    }
}
if (is_dir($publicStorage)) {
    $iter2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($publicStorage));
    foreach ($iter2 as $file) {
        if ($file->isFile()) {
            $rel = ltrim(str_replace($publicStorage, '', $file->getPathname()), '\\\/');
            $relNorm = ltrim('public/' . $rel, '\\\/');
            $basename = $file->getBasename();
            $storageFiles[$relNorm] = $basename;
        }
    }
}

function topCandidates($target, $storageFiles, $limit = 5) {
    $scores = [];
    $tnoext = pathinfo($target, PATHINFO_FILENAME);
    foreach ($storageFiles as $rel => $fname) {
        $fnameNoExt = pathinfo($fname, PATHINFO_FILENAME);
        similar_text(strtolower($tnoext), strtolower($fnameNoExt), $pct);
        $scores[] = ['rel'=>$rel,'fname'=>$fname,'score'=>$pct];
    }
    usort($scores, function($a,$b){ return $b['score'] <=> $a['score']; });
    return array_slice($scores,0,$limit);
}

foreach ($targets as $t) {
    echo "\n== Target: {$t} ==\n";
    $rows = MonitoringPelaporan::where('nama_file',$t)->get();
    if ($rows->isEmpty()) {
        echo "DB: no exact row found for this filename.\n";
        // try LIKE
        $rows = MonitoringPelaporan::where('nama_file','like','%'.str_replace('.pdf','',$t).'%')->get();
        if ($rows->isEmpty()) {
            echo "DB: no like match either.\n";
        }
    }
    foreach ($rows as $row) {
        echo "DB ID: {$row->id_monitoring} | file_path: {$row->file_path} | link: {$row->link} | created: {$row->created}\n";
        // prepare numeric token from file_path if present
        $token = null;
        if (!empty($row->file_path)) {
            if (preg_match('/(\d{9,})/', $row->file_path, $m)) $token = $m[1];
        } elseif (!empty($row->link)) {
            if (preg_match('/(\d{9,})/', $row->link, $m)) $token = $m[1];
        }
        if ($token) echo "Detected token from DB path: {$token}\n";
        $cands = topCandidates($t, $storageFiles, 10);
        foreach ($cands as $c) {
            $mark = '';
            if ($token && strpos($c['fname'],$token)!==false) $mark = ' [token match]';
            echo sprintf("%3d%%  %s  -> %s%s\n", round($c['score']), $c['fname'], $c['rel'], $mark);
        }
    }
}

echo "\nDone.\n";
