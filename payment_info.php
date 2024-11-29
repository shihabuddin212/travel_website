<?php
session_start();
require 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch payment data
try {
    $stmt = $pdo->prepare("SELECT b.id, p.title, b.total_amount, b.payment_status, b.created_at 
                           FROM bookings b 
                           JOIN packages p ON b.package_id = p.id 
                           WHERE b.user_id = ?");
    $stmt->execute([$user_id]);
    $payments = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $payments = [];
}

?>

<?php include 'components/header.php'; ?>
<?php include 'components/nav.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Payment Information</h2>
    <?php if (empty($payments)): ?>
        <p>No payment information found.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Package</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($payment['title']); ?></td>
                        <td><?php echo htmlspecialchars($payment['total_amount']); ?></td>
                        <td><?php echo htmlspecialchars($payment['payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($payment['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
.container {
    max-width: 800px;
    background-color: #f8f9fa;
    padding: 90px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.table th, .table td {
    vertical-align: middle;
}

h2 {
    color: #446A46; /* Dark green */
}
</style>

<?php include 'components/footer.php'; ?> 