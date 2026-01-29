<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;

$rootStorage = storage_path('app/public');
$publicStorage = public_path('storage');
$files = [];

$iter = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootStorage));
foreach ($iter as $file) {
    if ($file->isFile()) {
        $rel = ltrim(str_replace($rootStorage, '', $file->getPathname()), '\\/');
        $basename = $file->getBasename();
        $files[$rel] = $basename; // map rel->basename
    }
}
if (is_dir($publicStorage)) {
    $iter2 = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($publicStorage));
    foreach ($iter2 as $file) {
        if ($file->isFile()) {
            $rel = ltrim(str_replace($publicStorage, '', $file->getPathname()), '\\/');
            $relNorm = ltrim('public/' . $rel, '\\/');
            $basename = $file->getBasename();
            $files[$relNorm] = $basename;
        }
    }
}

$items = MonitoringPelaporan::orderBy('created','desc')->get();
$proposals = [];
$applied = [];

foreach ($items as $item) {
    // skip existing
    $exists = false;
    if (!empty($item->file_path) && Storage::disk('public')->exists(ltrim($item->file_path,'/'))) {
        continue;
    }
    $basename = null;
    if (!empty($item->file_path)) $basename = basename($item->file_path);
    elseif (!empty($item->link)) $basename = basename($item->link);
    if (!$basename) continue;

    $scores = [];
    foreach ($files as $rel => $fname) {
        // compute similarity percent based on similar_text
        $len = max(strlen($basename), strlen($fname));
        if ($len == 0) continue;
        $matched = 0;
        similar_text(strtolower($basename), strtolower($fname), $matchedPercent);
        // similar_text percentage already
        $score = $matchedPercent; // 0..100
        if ($score > 40) { // filter low scores early
            $scores[] = ['rel'=>$rel,'fname'=>$fname,'score'=>$score];
        }
    }
    if (empty($scores)) continue;
    usort($scores, function($a,$b){return $b['score'] <=> $a['score'];});
    $best = $scores[0];
    $second = $scores[1] ?? null;
    $gap = $second ? ($best['score'] - $second['score']) : $best['score'];

    // acceptance thresholds: score >= 75 and gap >= 12
    if ($best['score'] >= 75 && $gap >= 12) {
        $newRel = preg_replace('#^public/#','',$best['rel']);
        $proposals[] = [
            'id'=>$item->id_monitoring,
            'nama_file'=>$item->nama_file,
            'old_file_path'=>$item->file_path,
            'old_link'=>$item->link,
            'candidate_rel'=>$newRel,
            'candidate_score'=>$best['score'],
            'candidate_fname'=>$best['fname']
        ];
        // apply update
        $item->file_path = $newRel;
        $item->link = '/storage/' . $newRel;
        $item->save();
        $applied[] = $proposals[count($proposals)-1];
    }
}

$ts = date('Ymd_His');
$backup = __DIR__ . "/relink_aggressive_backup_{$ts}.csv";
$fh = fopen($backup,'w');
if ($fh) {
    fputcsv($fh,['id','nama_file','old_file_path','old_link','new_file_path','new_link','score','matched_filename']);
    foreach ($applied as $c) fputcsv($fh,[$c['id'],$c['nama_file'],$c['old_file_path'],$c['old_link'],$c['candidate_rel'],'/storage/'.$c['candidate_rel'],$c['candidate_score'],$c['candidate_fname']]);
    fclose($fh);
}

$proposalFile = __DIR__ . "/relink_aggressive_proposals_{$ts}.csv";
$fh2 = fopen($proposalFile,'w');
if ($fh2) {
    fputcsv($fh2,['id','nama_file','old_file_path','old_link','candidate_rel','candidate_fname','score']);
    foreach ($proposals as $p) fputcsv($fh2,[$p['id'],$p['nama_file'],$p['old_file_path'],$p['old_link'],$p['candidate_rel'],$p['candidate_fname'],$p['candidate_score']]);
    fclose($fh2);
}

echo "Aggressive run complete. Applied: " . count($applied) . ", Proposals: " . count($proposals) . "\n";
echo "Backup saved: {$backup}\n";
echo "Proposals saved: {$proposalFile}\n";
