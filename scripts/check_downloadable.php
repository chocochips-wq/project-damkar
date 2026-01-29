<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;
use Illuminate\Support\Facades\Storage;

$f = MonitoringPelaporan::orderBy('created', 'desc')->first();
if (!$f) {
    echo "No monitoring records\n";
    exit(0);
}

$localPath = null;
if (!empty($f->file_path)) {
    $localPath = ltrim($f->file_path, '/');
} elseif (!empty($f->link)) {
    $candidate = ltrim(preg_replace('#^/storage/#', '', $f->link), '/');
    $candidate = ltrim(preg_replace('#^storage/#', '', $candidate), '/');
    if ($candidate) $localPath = $candidate;
}

echo "ID: {$f->id_monitoring}\n";
echo "link: " . ($f->link ?? 'NULL') . "\n";
echo "file_path: " . ($f->file_path ?? 'NULL') . "\n";
echo "resolved localPath: " . ($localPath ?? 'NULL') . "\n";
if ($localPath) {
    echo "Storage exists: " . (Storage::disk('public')->exists($localPath) ? 'yes' : 'no') . PHP_EOL;
    echo "Full storage path: " . storage_path('app/public/' . $localPath) . PHP_EOL;
}
