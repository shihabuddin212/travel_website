<?php
session_start();
require 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch booking data
try {
    $stmt = $pdo->prepare("SELECT b.id, p.title, b.booking_date, b.travel_date, b.number_of_persons, b.total_amount, b.status, b.payment_status 
                           FROM bookings b 
                           JOIN packages p ON b.package_id = p.id 
                           WHERE b.user_id = ?");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $bookings = [];
}

?>

<?php include 'components/header.php'; ?>
<?php include 'components/nav.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Booking History</h2>
    <?php if (empty($bookings)): ?>
        <p>No bookings found.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Booking Date</th>
                    <th>Travel Date</th>
                    <th>Persons</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['title']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['travel_date']); ?></td>
                        <td><?php echo htmlspecialchars($booking['number_of_persons']); ?></td>
                        <td><?php echo htmlspecialchars($booking['total_amount']); ?></td>
                        <td><?php echo htmlspecialchars($booking['status']); ?></td>
                        <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.container {
    max-width: 1000px;
    background-color: #f8f9fa;
    padding: 90px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-top: 50px;
}

.table th, .table td {
    vertical-align: middle;
}

h2 {
    color: #446A46; /* Dark green */
    font-size: 2rem; /* Adjust font size if needed */
    word-wrap: break-word; /* Ensure text wraps properly */
}
</style>

<?php include 'components/footer.php'; ?> 