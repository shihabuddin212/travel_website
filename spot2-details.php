<?php 
session_start();
$pageTitle = "Saint Martin Island - BD Adventures";
include 'components/header.php';
include 'components/nav.php';
require_once 'config/db.php';

// Add review fetching
$destination_id = 2; // Saint Martin destination ID
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
            <img src="images/saint-martin.jpg" alt="Saint Martin Island" class="hero-image">
            <div class="hero-overlay">
                <h1>Saint Martin Island</h1>
                <p>Only Coral Island of Bangladesh</p>
            </div>
        </div>

        <!-- Description Section -->
        <div class="description-section">
            <div class="info-box">
                <h2>About Saint Martin</h2>
                <p>Saint Martin is Bangladesh's only coral island, offering pristine beaches, crystal clear waters, and rich marine life. This tropical paradise is located in the northeastern part of the Bay of Bengal, about 9 km south of Cox's Bazar-Teknaf peninsula.</p>
            </div>
            
            <div class="info-box">
                <div class="highlights">
                    <h3>Highlights</h3>
                    <ul>
                        <li><i class="fas fa-water"></i> Crystal clear blue waters</li>
                        <li><i class="fas fa-fish"></i> Rich coral reef ecosystem</li>
                        <li><i class="fas fa-umbrella-beach"></i> Pristine sandy beaches</li>
                        <li><i class="fas fa-drumstick-bite"></i> Fresh seafood cuisine</li>
                        <li><i class="fas fa-moon"></i> Beautiful sunset views</li>
                    </ul>
                </div>
            </div>
            
            <div class="activities">
                <h3>Things to Do</h3>
                <div class="activities-grid">
                    <div class="activity-card">
                        <i class="fas fa-swimming-pool"></i>
                        <h4>Water Activities</h4>
                        <p>Snorkeling, swimming, and coral viewing</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-hiking"></i>
                        <h4>Island Exploration</h4>
                        <p>Beach walking and island hopping</p>
                    </div>
                    <div class="activity-card">
                        <i class="fas fa-camera"></i>
                        <h4>Photography</h4>
                        <p>Stunning sunset and landscape shots</p>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <div class="location-info">
                    <h3>Location & How to Reach</h3>
                    <p class="location-desc"><i class="fas fa-map-marker-alt"></i> Located in the Bay of Bengal, 9 km south of Cox's Bazar-Teknaf peninsula</p>
                    
                    <div class="transport-options">
                        <div class="transport-item">
                            <i class="fas fa-plane"></i>
                            <div class="transport-details">
                                <strong>By Air:</strong>
                                <p>Flight to Cox's Bazar, then boat to Saint Martin</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-ship"></i>
                            <div class="transport-details">
                                <strong>By Sea:</strong>
                                <p>Regular ferry service from Teknaf to Saint Martin</p>
                            </div>
                        </div>
                        
                        <div class="transport-item">
                            <i class="fas fa-bus"></i>
                            <div class="transport-details">
                                <strong>By Road + Sea:</strong>
                                <p>Bus to Teknaf, then ferry to the island</p>
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
                            <p>November to February (Winter Season)</p>
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

        <!-- Add this before the closing container div -->
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
    z-index: 2;
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
    border-radius: 15px;
    margin-bottom: 30px;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.highlights ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.highlights li {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    color: #446A46;
    font-size: 1.1em;
}

.highlights li i {
    color: var(--dark-orange);
    margin-right: 15px;
    font-size: 1.2em;
}

.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 20px;
}

.activity-card {
    background: var(--light-beige);
    padding: 25px;
    border-radius: 12px;
    text-align: center;
    transition: transform 0.3s ease;
}

.activity-card:hover {
    transform: translateY(-10px);
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

.activity-card p {
    color: #446A46;
    margin: 0;
}

@media (max-width: 768px) {
    .activities-grid {
        grid-template-columns: 1fr;
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

/* Add these carousel styles at the beginning of your style section */
.hero-section {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.carousel {
    border-radius: 15px;
}

.carousel-item {
    height: 500px;
}

.carousel-item img {
    object-fit: cover;
    height: 100%;
    width: 100%;
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
    z-index: 2;
}

.carousel-indicators {
    z-index: 3;
}

.carousel-control-prev,
.carousel-control-next {
    z-index: 3;
}

.reviews-container {
    display: grid;
    gap: 20px;
    margin-top: 20px;
}

.review-card {
    background: var(--light-beige);
    padding: 20px;
    border-radius: 12px;
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
    color: #446A46;
}

</style>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?php include 'components/footer.php'; ?> 