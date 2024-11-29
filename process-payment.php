<?php
require_once 'config/stripe-config.php';
require_once 'vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

try {
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    if ($jsonObj->request_type == 'create_payment_intent') {
        // Calculate amount based on transport type
        $amount = calculateAmount($jsonObj->transport_type);
        
        // Create a PaymentIntent
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => 'bdt',
            'metadata' => [
                'destination' => $jsonObj->destination,
                'transport_type' => $jsonObj->transport_type,
                'travel_date' => $jsonObj->travel_date,
                'passengers' => $jsonObj->passengers
            ]
        ]);

        $output = [
            'clientSecret' => $paymentIntent->client_secret,
        ];

        echo json_encode($output);
    }
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

function calculateAmount($transportType) {
    // Base prices for different transport types
    $prices = [
        'bus' => 800,
        'air' => 3500,
        'train' => 1200
    ];
    
    return $prices[$transportType] ?? 0;
}
?> 