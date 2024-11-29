<?php
require __DIR__ . '/vendor/autoload.php';

header('Content-Type: application/json');

try {
    // Get the token from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $idToken = $data->token;

    // Start session and store user data
    session_start();
    $_SESSION['user_id'] = $idToken; // Or store specific user data
    
    echo json_encode([
        'success' => true,
        'message' => 'Authentication successful'
    ]);

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 