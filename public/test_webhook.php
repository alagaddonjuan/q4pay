<?php
// Q4I / 9PSB Webhook Simulator
// Drop this file in your public/ directory on the sandbox and visit it in your browser.

$webhookUrl = 'https://sandboxpay.q4iltd.com/api/webhooks/9psb-inflow';

// The keys from your .env
$publicKey = '462C470A998A42F28B272B14C9E289EE';
$privateKey = 'dO9cWmLCZo8gSeVBjJ36SPTnRPs-QO5tLz2kdKWrsjNKBy2cV6_322Cs87hMT7a0';

// CHANGE THIS to the actual account number you generated during testing!
$testAccountNumber = '1234567890'; 
$amount = '5000.00';

$payloadArray = [
    "transaction" => [
        "reference" => "TEST_REF_" . time(),
        "linkedreference" => "9PSB_" . time()
    ],
    "order" => [
        "amount" => $amount,
        "currency" => "NGN",
        "description" => "Test Webhook Transfer",
        "amounttype" => "ANY"
    ],
    "customer" => [
        "account" => [
            "name" => "Sandbox Tester",
            "number" => $testAccountNumber,
            "bank" => "9PSB"
        ]
    ],
    "source" => [
        "account" => [
            "name" => "Jane Smith",
            "number" => "9876543210",
            "bank" => "GTBank",
            "bankcode" => "058",
            "sessionid" => "999999" . time()
        ]
    ]
];

$payloadJson = json_encode($payloadArray);

// Generate the SHA512 hash exactly how 9psb does it
$hash = hash('sha512', $publicKey . $privateKey . $payloadJson);

// Send the cURL request
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'auth: ' . $hash
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h3>Webhook Simulation Sent!</h3>";
echo "<b>URL:</b> " . $webhookUrl . "<br>";
echo "<b>Payload:</b> <pre>" . json_encode($payloadArray, JSON_PRETTY_PRINT) . "</pre>";
echo "<b>Auth Hash Header:</b> " . $hash . "<br><br>";
echo "<b>HTTP Response Code:</b> " . $httpCode . "<br>";
echo "<b>Response Body:</b> " . $response . "<br>";
?>
