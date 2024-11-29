<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Dashboard - BD Adventures';
include 'components/header.php';

// Initialize default values
$stats = [
    'total_bookings' => 0,
    'confirmed_bookings' => 0,
    'paid_bookings' => 0,
    'new_messages' => 0,
    'total_destinations' => 0
];

try {
    $userId = $_SESSION['user_id'];
    
    // Get booking summary
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_bookings,
            COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_bookings,
            COUNT(CASE WHEN payment_status = 'completed' THEN 1 END) as paid_bookings
        FROM bookings 
        WHERE user_id = ?
    ");
    $stmt->execute([$userId]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    // Get new messages count
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as new_messages
        FROM contact_messages
        WHERE status = 'new'
    ");
    $stmt->execute();
    $stats['new_messages'] = $stmt->fetchColumn();

    // Get total destinations count
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as total_destinations
        FROM destinations
    ");
    $stmt->execute();
    $stats['total_destinations'] = $stmt->fetchColumn();

    // Get recent bookings
    $stmt = $pdo->prepare("
        SELECT 
            b.*,
            p.title,
            p.image_url,
            p.tour_type,
            p.duration,
            p.price
        FROM bookings b
        JOIN packages p ON b.package_id = p.id
        WHERE b.user_id = ?
        ORDER BY b.created_at DESC
        LIMIT 5
    ");
    $stmt->execute([$userId]);
    $recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
    $recentBookings = [];
}
?>

<?php include 'components/nav.php'; ?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h2>Welcome to Your Travel Dashboard</h2>
        <p>Track your bookings, upcoming tours, and travel history</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-suitcase"></i>
            </div>
            <div class="stat-info">
                <h3>Total Bookings</h3>
                <p><?= number_format((int)$stats['total_bookings']) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>Confirmed Bookings</h3>
                <p><?= number_format((int)$stats['confirmed_bookings']) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stat-info">
                <h3>Paid Bookings</h3>
                <p><?= number_format((int)$stats['paid_bookings']) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <h3>New Messages</h3>
                <p><?= number_format((int)$stats['new_messages']) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Total Destinations</h3>
                <p><?= number_format((int)$stats['total_destinations']) ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="recent-bookings">
        <h3>Recent Bookings</h3>
        <?php if (empty($recentBookings)): ?>
            <div class="no-bookings">
                <i class="fas fa-calendar-times"></i>
                <p>No bookings found. Start planning your next adventure!</p>
                <a href="destination.php" class="btn-explore">Explore Packages</a>
            </div>
        <?php else: ?>
            <div class="bookings-grid">
                <?php foreach ($recentBookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-image">
                            <img src="<?= htmlspecialchars($booking['image_url']) ?>" alt="<?= htmlspecialchars($booking['title']) ?>">
                            <span class="tour-type"><?= htmlspecialchars($booking['tour_type']) ?></span>
                        </div>
                        <div class="booking-details">
                            <h4><?= htmlspecialchars($booking['title']) ?></h4>
                            <div class="booking-info">
                                <p><i class="fas fa-calendar-alt"></i> Travel Date: <?= htmlspecialchars($booking['travel_date']) ?></p>
                                <p><i class="fas fa-clock"></i> Duration: <?= htmlspecialchars($booking['duration']) ?></p>
                                <p><i class="fas fa-users"></i> Persons: <?= htmlspecialchars($booking['number_of_persons']) ?></p>
                                <p><i class="fas fa-money-bill-wave"></i> Total: ৳<?= number_format((float)$booking['total_amount'], 2) ?></p>
                            </div>
                            <div class="booking-status">
                                <span class="status-badge <?= $booking['status'] == 'confirmed' ? 'status-confirmed' : 'status-pending' ?>">
                                    <?= ucfirst($booking['status']) ?>
                                </span>
                                <span class="payment-badge <?= $booking['payment_status'] == 'completed' ? 'payment-completed' : 'payment-pending' ?>">
                                    Payment: <?= ucfirst($booking['payment_status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.dashboard-container {
    padding: 90px;
    background-color: #f8f9fa;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: var(--dark-orange);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.stat-icon i {
    color: white;
    font-size: 20px;
}

.bookings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

.booking-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.booking-image {
    position: relative;
    height: 200px;
}

.booking-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tour-type {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--dark-orange);
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
}

.booking-details {
    padding: 20px;
}

.booking-info {
    margin: 15px 0;
}

.booking-info p {
    margin: 5px 0;
    color: #666;
}

.booking-info i {
    width: 20px;
    color: var(--dark-orange);
}

.status-badge,
.payment-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    margin-right: 10px;
}

.status-confirmed {
    background: #10B981;
    color: white;
}

.status-pending {
    background: #F59E0B;
    color: white;
}

.payment-completed {
    background: #10B981;
    color: white;
}

.payment-pending {
    background: #F59E0B;
    color: white;
}
</style>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php include 'components/footer.php'; ?>
