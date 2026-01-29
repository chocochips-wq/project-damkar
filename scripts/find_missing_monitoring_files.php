<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;

$items = MonitoringPelaporan::where(function($q){
    $q->where('link', 'like', '/storage/%')->orWhereNotNull('file_path');
})->orderBy('created', 'desc')->limit(200)->get();

if ($items->isEmpty()) {
    echo "No candidate monitoring records found.\n";
    exit(0);
}

foreach ($items as $f) {
    $status = [];
    $exists = false;
    $localPath = null;
    if (!empty($f->file_path)) {
        $localPath = ltrim($f->file_path, '/');
        $exists = Storage::disk('public')->exists($localPath);
        $status[] = "file_path: {$f->file_path} (exists: " . ($exists ? 'yes' : 'no') . ")";
    }
    if (!$exists && !empty($f->link) && str_starts_with($f->link, '/storage')) {
        $candidate = ltrim(preg_replace('#^/storage/#', '', $f->link), '/');
        $candidate = ltrim(preg_replace('#^storage/#', '', $candidate), '/');
        $exists = Storage::disk('public')->exists($candidate);
        $status[] = "link: {$f->link} (resolved: {$candidate}, exists: " . ($exists ? 'yes' : 'no') . ")";
        if ($exists) $localPath = $candidate;
    }

    if (!$exists) {
        echo "MISSING => ID: {$f->id_monitoring} | {$f->nama_file} | ";
        echo implode(' | ', $status) . PHP_EOL;
    }
}
