<?php
session_start();
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = $_POST['package_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $number_of_persons = $_POST['number_of_persons'];
    $user_id = $_SESSION['user_id']; // Assuming user is logged in

    // Calculate total amount (example calculation, adjust as needed)
    $stmt = $pdo->prepare("SELECT price FROM packages WHERE id = ?");
    $stmt->execute([$package_id]);
    $package = $stmt->fetch();
    $total_amount = $package['price'] * $number_of_persons;

    try {
        $stmt = $pdo->prepare("
            INSERT INTO bookings (user_id, package_id, booking_date, travel_date, number_of_persons, total_amount, status, payment_status)
            VALUES (?, ?, ?, ?, ?, ?, 'pending', 'pending')
        ");
        $stmt->execute([$user_id, $package_id, $check_in, $check_out, $number_of_persons, $total_amount]);

        $_SESSION['success'] = "Your booking has been successfully processed!";
        header('Location: confirmation.php');
        exit();
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again.";
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?> 