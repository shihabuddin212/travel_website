<?php
session_start();
require 'config/db.php';

// Debug logging
error_log("Save booking endpoint hit");

// Function to get user ID from database using email
function getUserIdByEmail($pdo, $email) {
    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error getting user ID: " . $e->getMessage());
        return null;
    }
}

// Check authentication
if (!isset($_SESSION['user_id']) && !isset($_SESSION['google_user']['email'])) {
    error_log("No user authentication found");
    http_response_code(401);
    exit(json_encode(['error' => true, 'message' => 'Not authenticated']));
}

// Get the correct user ID
$user_id = null;
if (isset($_SESSION['user_id']) && is_numeric($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else if (isset($_SESSION['google_user']['email'])) {
    $user_id = getUserIdByEmail($pdo, $_SESSION['google_user']['email']);
}

if (!$user_id) {
    error_log("Could not determine valid user ID");
    http_response_code(400);
    exit(json_encode(['error' => true, 'message' => 'Invalid user ID']));
}

// Get POST data and log it
$data = json_decode(file_get_contents('php://input'), true);
error_log("Received data: " . print_r($data, true));

try {
    // Start transaction
    $pdo->beginTransaction();
    
    // First, insert into packages
    $stmt = $pdo->prepare("
        INSERT INTO packages 
        (title, description, price, duration, tour_type) 
        VALUES 
        (?, ?, ?, ?, ?)
    ");
    
    $packageTitle = ucfirst($data['transport_type']) . " to " . ucfirst($_SESSION['destination'] ?? 'Unknown');
    $packageDescription = "Travel package via " . $data['transport_type'];
    
    $stmt->execute([
        $packageTitle,
        $packageDescription,
        $data['total_amount'],
        '1 day',
        $data['transport_type']
    ]);
    
    $package_id = $pdo->lastInsertId();
    error_log("Created package with ID: " . $package_id);

    // Then create booking
    $stmt = $pdo->prepare("
        INSERT INTO bookings 
        (user_id, package_id, booking_date, travel_date, number_of_persons, total_amount, status, payment_status) 
        VALUES 
        (?, ?, CURDATE(), ?, ?, ?, 'confirmed', 'completed')
    ");

    $stmt->execute([
        $user_id, // Using the properly retrieved user_id
        $package_id,
        $data['travel_date'],
        $data['number_of_persons'],
        $data['total_amount']
    ]);

    $booking_id = $pdo->lastInsertId();
    error_log("Created booking with ID: " . $booking_id);

    // Store booking ID in session
    $_SESSION['last_booking_id'] = $booking_id;
    
    // Commit transaction
    $pdo->commit();
    
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'booking_id' => $booking_id,
        'message' => 'Booking saved successfully'
    ]);

} catch (PDOException $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    
    error_log("Booking Error: " . $e->getMessage());
    error_log("SQL State: " . $e->getCode());
    
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
} 