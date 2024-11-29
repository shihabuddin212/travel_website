<?php
require_once __DIR__ . '/vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51QLLqbJcVq5mfW9UcfkUMQE5rZ1Co5Q3wPMA2NoD1XtkdHze6oJvVq9l7VDs0lKLcxupPq54Q2fpM9U9XC09zxrU00FDoeS8g6');

header('Content-Type: application/json');

try {
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr);

    // Convert amount to cents
    $amount = round($jsonObj->amount * 100);

    $intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'bdt',
        'metadata' => [
            'transport_type' => $jsonObj->transport_type,
            'travel_class' => $jsonObj->travel_class,
            'passengers' => $jsonObj->passengers,
            'travel_date' => $jsonObj->travel_date
        ]
    ]);

    echo json_encode([
        'clientSecret' => $intent->client_secret
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 