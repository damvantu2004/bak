<?php

require_once  'vendor/autoload.php';

use PayOS\PayOS;

// Keep your PayOS key protected by including it by an env variable
$payOSClientId = '355718b7-5f38-44ea-b31e-3e269705aa5b';
$payOSApiKey = '06eac658-bada-4cee-92a3-48626b520aab';
$payOSChecksumKey = '91e022cb0777e5700cfe57d541e778bf9c744170c957423ac53cbf8e4d40448a';

$payOS = new PayOS($payOSClientId, $payOSApiKey, $payOSChecksumKey);

$YOUR_DOMAIN = 'http://localhost:3000/';

$data = [
    "orderCode" => intval(substr(strval(microtime(true) * 10000), -6)),
    "amount" => 2000,
    "description" => "Thanh toán đơn hàng",
    "items" => [
        0 => [
            'name' => 'Mì tôm Hảo Hảo ly',
            'price' => 2000,
            'quantity' => 1
        ]
    ],
    "returnUrl" => $YOUR_DOMAIN + "success",
    "cancelUrl" => $YOUR_DOMAIN + "cancel"
];

$response = $payOS->createPaymentLink($data);

header("HTTP/1.1 303 See Other");
header("Location: " . $response['checkoutUrl']);
