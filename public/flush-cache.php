<?php
require __DIR__.'/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->call('cache:clear');
$kernel->call('config:clear');
$kernel->call('view:clear');
echo 'Cache flushed at '.date('Y-m-d H:i:s');