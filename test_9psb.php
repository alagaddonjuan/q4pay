<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = app(\App\Services\NinePsbVasService::class);

echo "--- TRYING TO FIND THE REAL 'GET BILLER INPUT FIELDS' ENDPOINT ---\n";
// The client method is protected, so we'll use Reflection to access it
$reflection = new ReflectionClass($service);
$method = $reflection->getMethod('client');
$method->setAccessible(true);
$client = $method->invoke($service);
$baseUrl = $reflection->getProperty('baseUrl');
$baseUrl->setAccessible(true);
$url = $baseUrl->getValue($service);

$pathsToTest = [
    "/vas/api/v1/billspayment/biller/items/BP-ENUGU",
    "/vas/api/v1/billspayment/items/BP-ENUGU",
    "/vas/api/v1/billspayment/biller/BP-ENUGU/items",
    "/vas/api/v1/billspayment/billerinputfields/BP-ENUGU"
];

foreach ($pathsToTest as $path) {
    echo "Testing: {$path}\n";
    $response = $client->get("{$url}{$path}");
    $json = $response->json();
    if (isset($json['status']) && $json['status'] !== 404) {
        echo "SUCCESS! Found it: ";
        print_r($json);
    } else {
        echo "FAILED (404)\n";
    }
}

echo "\n--- TESTING VALIDATION WITHOUT ITEM ID ---\n";
// Passing null for itemId to see if 9PSB will accept it without one
$validation = $service->validateBiller("45038886748", "BP-ENUGU", null, "1000");
print_r($validation);
