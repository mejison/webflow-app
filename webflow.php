<?php
require_once './vendor/autoload.php';

header('Content-Type: application/json');

$require_props = [
    'amount',
    'secret',
    'plan',
    'callback_success',
    'callback_cancel',
    // 'email',
];

foreach($require_props as $prop) {
    if (empty($_GET[$prop])) {
        http_response_code(500);
        echo json_encode(['error' => ucfirst($prop) . ' is required!']);
        die;
    }
}

\Stripe\Stripe::setApiKey($_GET['secret']);

$amount = $_GET['amount'];
$plan = $_GET['plan'];
$email = $_GET['email'] ?? '';

try {
    \Stripe\Product::retrieve($plan, []);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Plan is wrong!']);
    die;
}

try {
  $prices = \Stripe\Price::all([
    'lookup_keys' => ['amount-' . $amount],
    'expand' => ['data.product']
  ]);

  [$price] = $prices->data ?: false;
  if ( ! $price) {
    $price = \Stripe\Price::create([
        'unit_amount' => $amount  * 100,
        'currency' => 'usd',
        'recurring' => ['interval' => 'month'],
        'product' => $plan,
        'lookup_key' => 'amount-' . $amount
      ]);
  }

    $data = [
        'line_items' => [
            [
                'price' => $price->id,
                'quantity' => 1,
            ]
        ],
        'mode' => 'subscription',
        'success_url' => $_GET['callback_success'],
        'cancel_url' => $_GET['callback_cancel'],
    ];

    if ($email) {
       $data['customer_email'] = $email;
    }

    $checkout_session = \Stripe\Checkout\Session::create($data);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $checkout_session->url);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}