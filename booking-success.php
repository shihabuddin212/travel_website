<?php
session_start();
require 'config/db.php';

$pageTitle = "Booking Successful - BD Adventures";
include 'components/header.php';
include 'components/nav.php';

// Get booking details if available
$booking = null;
if (isset($_SESSION['last_booking_id'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT b.*, p.title as package_title 
            FROM bookings b 
            JOIN packages p ON b.package_id = p.id 
            WHERE b.id = ? AND b.user_id = ?
        ");
        $stmt->execute([$_SESSION['last_booking_id'], $_SESSION['user_id']]);
        $booking = $stmt->fetch();
        
        // Clear the booking ID from session
        unset($_SESSION['last_booking_id']);
    } catch (PDOException $e) {
        error_log("Error fetching booking: " . $e->getMessage());
    }
}
?>

<div class="success-page">
    <div class="container">
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <h2>Payment Successful!</h2>
            <?php if ($booking): ?>
            <div class="booking-details">
                <h3>Booking Details</h3>
                <p>Booking Reference: #<?php echo $booking['id']; ?></p>
                <p>Package: <?php echo htmlspecialchars($booking['package_title']); ?></p>
                <p>Travel Date: <?php echo date('F d, Y', strtotime($booking['travel_date'])); ?></p>
                <p>Number of Persons: <?php echo $booking['number_of_persons']; ?></p>
                <p>Total Amount: <?php echo number_format($booking['total_amount'], 2); ?> BDT</p>
            </div>
            <?php endif; ?>
            <p>Your booking has been confirmed. Thank you for choosing BD Adventures.</p>
            <div class="action-buttons">
                <a href="dashboard.php" class="btn btn-primary">View in Dashboard</a>
                <a href="index.php" class="btn btn-secondary">Return to Home</a>
            </div>
        </div>
    </div>
</div>

<style>
.success-page {
    margin-top: 80px;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.success-message {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.success-message i {
    font-size: 4em;
    color: #28a745;
    margin-bottom: 20px;
}

.booking-details {
    margin: 20px 0;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    text-align: left;
}

.booking-details h3 {
    margin-bottom: 15px;
    color: #446A46;
}

.booking-details p {
    margin: 8px 0;
    color: #666;
}

.action-buttons {
    margin-top: 20px;
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}
</style>

<?php include 'components/footer.php'; ?> 