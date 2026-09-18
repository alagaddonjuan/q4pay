<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'neergiver@gmail.com';
$password = 'test1234'; // Or whatever password they might be using. Let's just retrieve by email.

$member = \App\Models\MerchantTeamMember::where('email', $email)->first();
if (!$member) {
    echo "Member not found.\n";
    exit;
}
echo "Member found! ID: {$member->id}\n";
echo "Password hash: {$member->password}\n";

$check = \Illuminate\Support\Facades\Hash::check('test1234', $member->password);
echo "Hash check for 'test1234': " . ($check ? 'YES' : 'NO') . "\n";

$check2 = \Illuminate\Support\Facades\Hash::check('password123', $member->password);
echo "Hash check for 'password123': " . ($check2 ? 'YES' : 'NO') . "\n";

$check3 = \Illuminate\Support\Facades\Hash::check('neergiver@gmail.com', $member->password);
echo "Hash check for 'email': " . ($check3 ? 'YES' : 'NO') . "\n";

