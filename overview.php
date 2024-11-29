<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug: Print session info
echo "<!-- Session User ID: " . ($_SESSION['user_id'] ?? 'Not set') . " -->";

require_once __DIR__ . '/../../config/db.php';

try {
    $userId = $_SESSION['user_id'];
    
    // Debug: Print user ID
    echo "<!-- Current User ID: " . $userId . " -->";
    
    // Get user details
    $userStmt = $pdo->prepare("
        SELECT first_name, last_name, email, phone 
        FROM users 
        WHERE id = ?
    ");
    $userStmt->execute([$userId]);
    $userData = $userStmt->fetch(PDO::FETCH_ASSOC);
    
    // Debug: Print user data
    echo "<!-- User Data: " . print_r($userData, true) . " -->";

    // Get booking statistics
    $statsStmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_bookings,
            SUM(CASE WHEN travel_date >= CURDATE() AND status != 'cancelled' THEN 1 ELSE 0 END) as upcoming_tours,
            SUM(CASE WHEN travel_date < CURDATE() OR status = 'cancelled' THEN 1 ELSE 0 END) as completed_tours,
            COALESCE(SUM(total_amount), 0) as total_spent
        FROM bookings 
        WHERE user_id = ?
    ");
    
    // Debug: Print SQL query
    echo "<!-- SQL Query: " . str_replace(['?'], [$userId], $statsStmt->queryString) . " -->";
    
    $statsStmt->execute([$userId]);
    $stats = $statsStmt->fetch(PDO::FETCH_ASSOC);
    
    // Debug: Print stats
    echo "<!-- Booking Stats: " . print_r($stats, true) . " -->";

    // Get recent bookings
    $bookingsStmt = $pdo->prepare("
        SELECT 
            b.*,
            p.title as package_title,
            p.image_url,
            p.tour_type,
            p.duration
        FROM bookings b
        JOIN packages p ON b.package_id = p.id
        WHERE b.user_id = ?
        ORDER BY b.booking_date DESC, b.id DESC
        LIMIT 3
    ");
    
    $bookingsStmt->execute([$userId]);
    $recentBookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Print recent bookings
    echo "<!-- Recent Bookings: " . print_r($recentBookings, true) . " -->";

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo "<!-- Database Error: " . $e->getMessage() . " -->";
    $userData = ['first_name' => 'User'];
    $stats = [
        'total_bookings' => 0,
        'upcoming_tours' => 0,
        'completed_tours' => 0,
        'total_spent' => 0
    ];
    $recentBookings = [];
}

// Debug: Print final variables
echo "<!-- Final Stats: " . print_r($stats, true) . " -->";
echo "<!-- Final Recent Bookings: " . print_r($recentBookings, true) . " -->";
?>

<div class="overview-container">
    <!-- Welcome Section -->
    <div class="welcome-card">
        <div class="profile-section">
            <div class="profile-image">
                <img src="images/default-avatar.png" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h2>Welcome back, <?php echo htmlspecialchars($userData['first_name'] ?? '') . ' ' . 
                                          htmlspecialchars($userData['last_name'] ?? ''); ?>!</h2>
                <p class="user-email"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($userData['email'] ?? ''); ?></p>
                <?php if (!empty($userData['phone'])): ?>
                    <p class="user-phone"><i class="fas fa-phone"></i> <?php echo htmlspecialchars($userData['phone']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-info">
                <h3>Total Bookings</h3>
                <p class="stat-number"><?php echo (int)($stats['total_bookings'] ?? 0); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🗓️</div>
            <div class="stat-info">
                <h3>Upcoming Tours</h3>
                <p class="stat-number"><?php echo (int)($stats['upcoming_tours'] ?? 0); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-info">
                <h3>Completed Tours</h3>
                <p class="stat-number"><?php echo (int)($stats['completed_tours'] ?? 0); ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <h3>Total Spent</h3>
                <p class="stat-number"><?php echo number_format((float)($stats['total_spent'] ?? 0), 2); ?> BDT</p>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Section -->
    <div class="recent-bookings-section">
        <h3><i class="fas fa-clock"></i> Recent Bookings</h3>
        <div class="bookings-grid">
            <?php if (!empty($recentBookings)): ?>
                <?php foreach ($recentBookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-image">
                            <img src="<?php echo htmlspecialchars($booking['image_url'] ?? 'images/default-tour.jpg'); ?>" 
                                 alt="<?php echo htmlspecialchars($booking['package_title']); ?>">
                        </div>
                        <div class="booking-details">
                            <h4><?php echo htmlspecialchars($booking['package_title']); ?></h4>
                            <div class="booking-meta">
                                <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($booking['duration']); ?></span>
                                <span><i class="fas fa-users"></i> <?php echo htmlspecialchars($booking['number_of_persons']); ?> persons</span>
                            </div>
                            <div class="booking-dates">
                                <p><i class="fas fa-calendar-check"></i> Travel Date: 
                                   <?php echo date('M d, Y', strtotime($booking['travel_date'])); ?></p>
                            </div>
                            <div class="booking-status">
                                <span class="status-badge <?php echo strtolower($booking['status']); ?>">
                                    <?php echo ucfirst($booking['status']); ?>
                                </span>
                                <span class="payment-badge <?php echo strtolower($booking['payment_status']); ?>">
                                    <?php echo ucfirst($booking['payment_status']); ?>
                                </span>
                            </div>
                            <div class="booking-price">
                                <strong>Total: <?php echo number_format($booking['total_amount'], 2); ?> BDT</strong>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-bookings">
                    <p>No recent bookings found.</p>
                    <a href="../destinations.php" class="btn btn-primary">Explore Tours</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
/* Add your existing CSS styles here */
.dashboard-container {
    padding: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    font-size: 24px;
    background: #f0f4f8;
    padding: 15px;
    border-radius: 50%;
}

.stat-info h3 {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.stat-number {
    margin: 5px 0 0;
    font-size: 24px;
    font-weight: bold;
    color: #2c5282;
}

.bookings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.booking-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.booking-card:hover {
    transform: translateY(-5px);
}

.booking-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.booking-details {
    padding: 20px;
}

.booking-meta {
    display: flex;
    gap: 15px;
    margin: 10px 0;
    color: #666;
}

.booking-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-badge, .payment-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    margin-right: 5px;
}

.status-pending { background: #fff3cd; color: #856404; }
.status-confirmed { background: #d4edda; color: #155724; }
.status-cancelled { background: #f8d7da; color: #721c24; }

.payment-pending { background: #fff3cd; color: #856404; }
.payment-completed { background: #d4edda; color: #155724; }
.payment-refunded { background: #f8d7da; color: #721c24; }

.booking-price {
    margin-top: 15px;
    font-size: 18px;
    color: #2c5282;
}
</style> 