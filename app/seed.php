<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Ejecuta las migraciones y seeders
$kernel->call('migrate --seed');

echo "Migraciones y seeders ejecutados.";
