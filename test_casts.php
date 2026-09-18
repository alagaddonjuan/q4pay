<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$m = new App\Models\MerchantTeamMember();
echo json_encode($m->getCasts());
