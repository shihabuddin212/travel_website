<?php
session_start();
require 'config/db.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$pageTitle = "Admin Panel - BD Adventures";
include 'components/header.php';
include 'components/nav.php';

// Fetch data for admin view
try {
    // Fetch total bookings
    $stmt = $pdo->query("SELECT COUNT(*) as total_bookings FROM bookings");
    $totalBookings = $stmt->fetchColumn();

    // Fetch total income
    $stmt = $pdo->query("SELECT SUM(total_amount) as total_income FROM bookings WHERE payment_status = 'completed'");
    $totalIncome = $stmt->fetchColumn();

    // Fetch all bookings with user details
    $stmt = $pdo->query("
        SELECT b.id, u.first_name, u.last_name, u.email, u.phone, p.title, b.booking_date, b.travel_date, b.total_amount, b.status
        FROM bookings b
        JOIN users u ON b.user_id = u.id
        JOIN packages p ON b.package_id = p.id
    ");
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    $totalBookings = 0;
    $totalIncome = 0;
    $bookings = [];
}
?>

<div class="admin-panel">
    <h2>Admin Panel</h2>
    <div class="stats">
        <div class="stat-item">
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings; ?></p>
        </div>
        <div class="stat-item">
            <h3>Total Income</h3>
            <p><?php echo number_format($totalIncome, 2); ?> BDT</p>
        </div>
    </div>

    <h3>All Bookings</h3>
    <table class="bookings-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Package</th>
                <th>Booking Date</th>
                <th>Travel Date</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking['id'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars(($booking['first_name'] ?? '') . ' ' . ($booking['last_name'] ?? '')); ?></td>
                    <td><?php echo htmlspecialchars($booking['email'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['phone'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['title'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['booking_date'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['travel_date'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['total_amount'] ?? ''); ?></td>
                    <td><?php echo htmlspecialchars($booking['status'] ?? ''); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.admin-panel {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.stats {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.stat-item {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    text-align: center;
    flex: 1;
    margin: 0 10px;
}

.stat-item h3 {
    margin-bottom: 10px;
    color: #333;
}

.bookings-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.bookings-table th, .bookings-table td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

.bookings-table th {
    background-color: #f4f4f4;
    color: #333;
}

.bookings-table tr:nth-child(even) {
    background-color: #f9f9f9;
}
</style>

<?php include 'components/footer.php'; ?> 