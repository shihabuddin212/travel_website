<?php 
session_start();
$pageTitle = "Kuakata Beach - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
require_once 'config/db.php';

// Add review fetching
$destination_id = 3; // Kuakata destination ID
try {
    $stmt = $pdo->prepare("
        SELECT r.*, u.first_name, u.last_name, r.created_at
        FROM reviews r
        JOIN users u ON r.user_id = u.id
        WHERE r.destination_id = ?
        ORDER BY r.created_at DESC
    ");
    $stmt->execute([$destination_id]);
    $reviews = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $reviews = [];
}
?>

<div class="destination-details" style="margin-top: 80px;">
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <img src="images/kuakata1.jpg" alt="Kuakata Beach" class="hero-image">
            <div class="hero-overlay">
                <h1>Kuakata Beach</h1>
                <p>The Daughter of the Sea</p>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <div class="info-box">
                <h2>About Kuakata</h2>
                <p>Kuakata, known as 'Sagar Kannya' (Daughter of the Sea), is a rare scenic beauty spot where you can witness both sunrise and sunset from the same beach. This 30km-long beach on the edge of the Bay of Bengal is known for its pristine beauty and unique location.</p>
            </div>
            
            <div class="info-box">
                <div class="highlights">
                    <h3>Highlights</h3>
                    <ul>
                        <li><i class="fas fa-sun"></i> View both sunrise and sunset</li>
                        <li><i class="fas fa-umbrella-beach"></i> 30km pristine beach</li>
                        <li><i class="fas fa-tree"></i> Mangrove forest nearby</li>
                        <li><i class="fas fa-pray"></i> Buddhist temples</li>
                        <li><i class="fas fa-fish"></i> Fresh seafood market</li>
                    </ul>
                </div>
            </div>
            
            <div class="activities">
                <h3>Things to Do</h3>
                <div class="activities-grid">
                    <div class="activity-card">
                        <i class="fas fa-camera"></i>
                        <h4>Photography</h4>
                        <p>Capture stunning sunrise and sunset views</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-bicycle"></i>
                        <h4>Beach Cycling</h4>
                        <p>Ride along the scenic beach road</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-landmark"></i>
                        <h4>Cultural Visit</h4>
                        <p>Explore temples and local communities</p>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="location-info">
                    <h3>Location & How to Reach</h3>
                    <p class="location-desc"><i class="fas fa-map-marker-alt"></i> Located in Patuakhali district, about 320 kilometers south of Dhaka</p>
                    
                    <div class="transport-options">
                        <div class="transport-item">
                            <i class="fas fa-bus"></i>
                            <div class="transport-details">
                                <strong>By Bus:</strong>
                                <p>Direct bus services from Dhaka to Kuakata</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-car"></i>
                            <div class="transport-details">
                                <strong>By Car:</strong>
                                <p>Private car journey via Barisal</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-ship"></i>
                            <div class="transport-details">
                                <strong>By Launch:</strong>
                                <p>Water route available via Barisal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Your Visit Section -->
        <div class="info-box">
            <div class="plan-visit">
                <h3>Plan Your Visit</h3>
                <div class="visit-info">
                    <div class="visit-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="visit-details">
                            <strong>Best Time to Visit</strong>
                            <p>October to March (Dry Season)</p>
                        </div>
                    </div>
                    
                    <div class="visit-item">
                        <i class="fas fa-clock"></i>
                        <div class="visit-details">
                            <strong>Recommended Duration</strong>
                            <p>2-3 days</p>
                        </div>
                    </div>
                    
                    <div class="visit-item book-now">
                        <i class="fas fa-ticket-alt"></i>
                        <div class="visit-details">
                            <strong>Ready to Go?</strong>
                            <a href="#" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.destination-details {
    background-color: var(--light-beige);
    padding: 20px 0;
}

.hero-section {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.hero-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 15px;
}

.hero-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
    color: white;
    padding: 30px;
    text-align: center;
}

.info-box {
    background: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.highlights ul {
    list-style: none;
    padding: 0;
}

.highlights li {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.highlights li i {
    color: var(--dark-orange);
    margin-right: 15px;
    font-size: 1.2em;
}

.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.activity-card {
    background: var(--light-beige);
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    transition: transform 0.3s ease;
}

.activity-card:hover {
    transform: translateY(-5px);
}

.activity-card i {
    color: var(--dark-orange);
    font-size: 2em;
    margin-bottom: 15px;
}

.activity-card h4 {
    color: var(--dark-green);
    margin-bottom: 10px;
}

.location-desc {
    margin-bottom: 20px;
}

.location-desc i {
    color: var(--dark-orange);
    margin-right: 10px;
}

.transport-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.transport-item {
    display: flex;
    align-items: flex-start;
    padding: 15px;
    background: var(--light-beige);
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.transport-item:hover {
    transform: translateX(10px);
}

.transport-item i {
    color: var(--dark-orange);
    font-size: 1.5em;
    margin-right: 20px;
    padding-top: 5px;
}

.transport-details {
    flex: 1;
}

.transport-details strong {
    display: block;
    color: var(--dark-green);
    margin-bottom: 5px;
    font-size: 1.1em;
}

.transport-details p {
    margin: 0;
    color: #446A46;
}

.visit-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.visit-item {
    display: flex;
    align-items: flex-start;
    padding: 20px;
    background: var(--light-beige);
    border-radius: 12px;
    transition: transform 0.3s ease;
}

.visit-item:hover {
    transform: translateX(10px);
}

.visit-item i {
    color: var(--dark-orange);
    font-size: 1.5em;
    margin-right: 20px;
    padding-top: 5px;
}

.visit-details {
    flex: 1;
}

.visit-details strong {
    display: block;
    color: var(--dark-green);
    margin-bottom: 8px;
    font-size: 1.1em;
}

.visit-details p {
    margin: 0;
    color: #446A46;
    font-size: 1.1em;
}

.book-now .btn-primary {
    margin-top: 10px;
    background-color: var(--dark-orange);
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.book-now .btn-primary:hover {
    background-color: var(--light-orange);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .visit-item {
        padding: 15px;
    }
    
    .visit-item i {
        font-size: 1.2em;
        margin-right: 15px;
    }
    
    .visit-details strong {
        font-size: 1em;
    }
    
    .visit-details p {
        font-size: 1em;
    }
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php include 'components/footer.php'; ?> 