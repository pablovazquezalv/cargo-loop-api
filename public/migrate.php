<?php

echo (__DIR__);

use Illuminate\Contracts\Console\Kernel;

// Ir una carpeta arriba desde /public para llegar a la raíz
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$status = $kernel->call('migrate', [
    '--force' => true,
]);

echo nl2br($kernel->output());
