<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

// Ejecutar todos los seeders registrados en DatabaseSeeder
$status = $kernel->call('db:seed', [
    '--force' => true,
]);

echo nl2br($kernel->output());
