<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

header('Content-Type: application/json');
$user = App\Models\MerchantTeamMember::orderBy('id', 'desc')->first();
if (!$user) {
    echo json_encode(["error" => "No users"]);
} else {
    echo json_encode([
        "id" => $user->id,
        "email" => $user->email,
        "password" => $user->password,
        "status" => $user->status,
        "pin" => $user->transaction_pin
    ]);
}
