<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$vas = app(\App\Services\NinePsbVasService::class);
header('Content-Type: application/json');
echo json_encode($vas->getCategories(), JSON_PRETTY_PRINT);
