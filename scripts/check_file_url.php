<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\MonitoringPelaporan;

$f = MonitoringPelaporan::orderBy('created', 'desc')->first();
if (!$f) {
    echo "No monitoring records\n";
    exit(0);
}

echo "ID: " . $f->id_monitoring . PHP_EOL;
echo "Nama: " . $f->nama_file . PHP_EOL;
echo "Link: " . ($f->link ?? 'NULL') . PHP_EOL;
echo "File path: " . ($f->file_path ?? 'NULL') . PHP_EOL;
echo "file_url (accessor): " . ($f->file_url ?? 'NULL') . PHP_EOL;
