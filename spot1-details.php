<?php 
session_start();
$pageTitle = "Cox's Bazar Beach - BD Adventures";
include 'components/header.php';
include 'components/nav.php';

require_once 'config/db.php';

// Add this near the top of the file after including db.php
$destination_id = 1; // Cox's Bazar destination ID
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
            <img src="images/coxs-bazar.png" alt="Cox's Bazar Beach" class="hero-image">
            <div class="hero-overlay">
                <h1>Cox's Bazar Beach</h1>
                <p>World's Longest Natural Sea Beach</p>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <div class="info-box">
                <h2>About Cox's Bazar</h2>
                <p>Cox's Bazar is the longest natural sea beach in the world, stretching over 120 kilometers along the Bay of Bengal. This unbroken stretch of golden sandy beach is a paradise for beach lovers and adventure seekers alike.</p>
            </div>
            
            <div class="info-box">
                <div class="highlights">
                    <h3>Highlights</h3>
                    <ul>
                        <li><i class="fas fa-umbrella-beach"></i> 120km of unbroken sandy beach</li>
                        <li><i class="fas fa-sun"></i> Stunning sunrise and sunset views</li>
                        <li><i class="fas fa-water"></i> Various water sports activities</li>
                        <li><i class="fas fa-fish"></i> Fresh seafood restaurants</li>
                        <li><i class="fas fa-store"></i> Local handicraft markets</li>
                    </ul>
                </div>
            </div>
            
            <div class="activities">
                <h3>Things to Do</h3>
                <div class="activities-grid">
                    <div class="activity-card">
                        <i class="fas fa-swimming-pool"></i>
                        <h4>Beach Activities</h4>
                        <p>Swimming, sunbathing, and beach sports</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-ship"></i>
                        <h4>Boat Rides</h4>
                        <p>Traditional boat tours along the coast</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-shopping-bag"></i>
                        <h4>Shopping</h4>
                        <p>Local markets and souvenir shops</p>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="location-info">
                    <h3>Location & How to Reach</h3>
                    <p class="location-desc"><i class="fas fa-map-marker-alt"></i> Cox's Bazar is located in southeastern Bangladesh, about 150 kilometers south of Chittagong.</p>
                    
                    <div class="transport-options">
                        <div class="transport-item">
                            <i class="fas fa-plane"></i>
                            <div class="transport-details">
                                <strong>By Air:</strong>
                                <p>Direct flights from Dhaka to Cox's Bazar Airport</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-bus"></i>
                            <div class="transport-details">
                                <strong>By Bus:</strong>
                                <p>Regular bus services from major cities</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-train"></i>
                            <div class="transport-details">
                                <strong>By Train:</strong>
                                <p>Train service available up to Chittagong</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update the Booking Section -->
        <div class="info-box">
            <div class="plan-visit">
                <h3>Plan Your Visit</h3>
                <div class="visit-info">
                    <div class="visit-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="visit-details">
                            <strong>Best Time to Visit</strong>
                            <p>November to March (Winter Season)</p>
                        </div>
                    </div>
                    
                    <div class="visit-item">
                        <i class="fas fa-clock"></i>
                        <div class="visit-details">
                            <strong>Recommended Duration</strong>
                            <p>3-4 days</p>
                        </div>
                    </div>
                    
                    <div class="visit-item book-now">
                        <i class="fas fa-ticket-alt"></i>
                        <div class="visit-details">
                            <strong>Ready to Go?</strong>
                            <a href="booking.php?destination=coxs-bazar" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="info-box">
            <h3>Reviews & Ratings</h3>
            <div class="reviews-container">
                <?php if (empty($reviews)): ?>
                    <p class="text-muted">No reviews yet. Be the first to review!</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <strong><?= htmlspecialchars($review['first_name']) ?> <?= htmlspecialchars($review['last_name']) ?></strong>
                                </div>
                                <div class="rating">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="star <?= $i <= $review['rating'] ? 'filled' : '' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="review-comment"><?= htmlspecialchars($review['comment']) ?></p>
                            <small class="text-muted">Posted on <?= date('M d, Y', strtotime($review['created_at'])) ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

       

<style>
.destination-details {
    background-color: var(--light-beige);
    padding: 20px 0;
}

.hero-section {
    position: relative;
    margin-bottom: 40px;
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
    padding: 40px;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    border-radius: 0 0 15px 15px;
}

.description-section {
    background: transparent;
    padding: 0;
    border-radius: 15px;
    margin-bottom: 30px;
}

.info-box {
    background: white;
    padding: 30px;
    border-radius: 20px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    border: 1px solid rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.info-box:hover {
    transform: translateY(-5px);
}

.info-box h2, .info-box h3 {
    color: var(--dark-green);
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid var(--light-orange);
}

.highlights ul {
    list-style-type: none;
    padding-left: 0;
}

.highlights li {
    padding: 15px 0;
    border-bottom: 1px solid rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    color: #446A46;
}

.highlights li:last-child {
    border-bottom: none;
}

.highlights li i {
    color: var(--dark-orange);
    margin-right: 15px;
    font-size: 1.2em;
    width: 25px;
    text-align: center;
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
    border-radius: 10px;
    text-align: center;
}

.activity-card i {
    font-size: 2em;
    color: var(--dark-orange);
    margin-bottom: 10px;
}

.booking-section {
    background: white;
    padding: 30px;
    border-radius: 15px;
}

.booking-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.btn-primary {
    background-color: var(--dark-orange);
    border: none;
    padding: 10px 30px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--light-orange);
}

@media (max-width: 768px) {
    .hero-image {
        height: 300px;
    }
    
    .hero-overlay {
        padding: 20px;
    }
    
    .booking-info {
        grid-template-columns: 1fr;
    }
}

:root {
    --dark-green: #446A46;
    --light-beige: #FFF3E4;
    --light-orange: #FFB085;
    --dark-orange: #FF8038;
}

/* Location Info Styles */
.location-desc {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    color: #446A46;
    font-size: 1.1em;
}

.location-desc i {
    color: var(--dark-orange);
    margin-right: 15px;
    font-size: 1.2em;
}

.transport-options {
    display: flex;
    flex-direction: column;
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

@media (max-width: 768px) {
    .transport-item {
        padding: 12px;
    }
    
    .transport-item i {
        font-size: 1.2em;
        margin-right: 15px;
    }
}

/* Plan Visit Styles */
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

.list-group-item {
    margin-bottom: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.reviews-container {
    display: grid;
    gap: 20px;
    margin-top: 20px;
}

.review-card {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.star {
    color: #ddd;
    font-size: 18px;
}

.star.filled {
    color: #ffd700;
}

.review-comment {
    margin: 10px 0;
    line-height: 1.6;
}
</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php include 'components/footer.php'; ?> 