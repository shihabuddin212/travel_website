<?php
session_start();
$pageTitle = "BD Adventures";
include 'components/header.php';
include 'components/nav.php';
?>

<!-- Hero Slider Section -->
<div class="hero-slider">
    <div class="slider-container">
        <div class="slide fade">
            <img src="images/screenshot_1.png" alt="Cox's Bazar">
            <div class="slide-content">
                <h1>Discover Cox's Bazar</h1>
                <p>Experience the world's longest natural sea beach</p>
                <a href="destinations.php" class="cta-button">Explore Now</a>
            </div>
        </div>
        <div class="slide fade">
            <img src="images/sundarban.webp" alt="Sundarbans">
            <div class="slide-content">
                <h1>Explore Sundarbans</h1>
                <p>Adventure through the world's largest mangrove forest</p>
                <a href="destinations.php" class="cta-button">Book Tour</a>
            </div>
        </div>
        <div class="slide fade">
            <img src="images/sajek-valley.jpg" alt="Sajek Valley">
            <div class="slide-content">
                <h1>Visit Sajek Valley</h1>
                <p>Touch the clouds in the queen of hills</p>
                <a href="destinations.php" class="cta-button">Plan Trip</a>
            </div>
        </div>
        
        <button class="slider-btn prev">❮</button>
        <button class="slider-btn next">❯</button>
        
        <div class="slider-dots">
            <span class="dot"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>
</div>

<!-- Booking Form Section -->
<div class="booking-section">
    <div class="container">
        <form class="booking-form" id="bookingForm" method="POST">
            <h2>Plan Your Adventure</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="destination">Destination</label>
                    <select id="destination" name="package_id" required>
                        <option value="">Select Destination</option>
                        <option value="1" data-url="spot1-details.php">Cox's Bazar</option>
                        <option value="2" data-url="spot2-details.php">Sundarbans</option>
                        <option value="3" data-url="spot3-details.php">Sajek Valley</option>
                        <option value="4" data-url="spot4-details.php">Bandarban</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="check-in">Check In</label>
                    <input type="date" id="check-in" name="check_in" required>
                </div>
                <div class="form-group">
                    <label for="check-out">Check Out</label>
                    <input type="date" id="check-out" name="check_out" required>
                </div>
                <div class="form-group">
                    <label for="guests">Guests</label>
                    <select id="guests" name="number_of_persons" required>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5+ Guests</option>
                    </select>
                </div>
            </div>
            <button type="button" class="submit-btn" id="submitButton">Check Availability</button>
        </form>
    </div>
</div>

<!-- Update the discount banner HTML -->
<div class="discount-banner">
    <div class="banner-background"></div>
    <div class="rolling-tags"></div>
    <div class="discount-content">
        <div class="discount-icon">🎉</div>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- Show for non-logged in users -->
            <div class="banner-text">
                <span class="highlight">10% OFF</span> 
                <span class="discount-details">on your first adventure!</span>
                <span class="discount-sub">Sign up now and start exploring</span>
                <a href="register.php" class="signup-btn">
                    Sign Up <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        <?php else: ?>
            <!-- Show for logged in users -->
            <div class="banner-text">
                <span class="welcome-text">Welcome back, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Explorer'); ?>!</span>
                <span class="discount-sub">Ready for your next adventure?</span>
                <a href="destinations.php" class="explore-btn">
                    Explore Now <i class="fas fa-compass"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Popular Destinations Section -->
<section class="destinations-section">
    <div class="container">
        <h2 class="section-title">Explore Destinations</h2>
        <div class="destinations-grid">
            <div class="destination-card">
                <img src="images/banglar-tajmohol.webp" alt="Banglar Taj Mahal">
                <div class="destination-content">
                    <h3>Banglar Taj Mahal</h3>
                    <p>Relax on the most stunning beaches around the world</p>
                    <a href="destinations.php?place=banglar-taj-mahal" class="learn-more">Learn More</a>
                </div>
            </div>

            <div class="destination-card">
                <img src="images/sonargaon-museum.webp" alt="Sonargaon Museum">
                <div class="destination-content">
                    <h3>Sonargaon Museum</h3>
                    <p>Embark on thrilling adventures in the mountains</p>
                    <a href="destinations.php?place=sonargaon-museum" class="learn-more">Learn More</a>
                </div>
            </div>

            <div class="destination-card">
                <img src="images/shishu-park.png" alt="National Shishu Park">
                <div class="destination-content">
                    <h3>National Shishu Park</h3>
                    <p>Discover the excitement of the world's greatest cities</p>
                    <a href="destinations.php?place=national-shishu-park" class="learn-more">Learn More</a>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="destination.php" class="see-more-btn">See more</a>
        </div>
    </div>
</section>

<!-- Add this CSS -->
<style>
/* Hero Slider Styles */
.hero-slider {
    position: relative;
    max-width: 100%;
    margin: auto;
    overflow: hidden;
}

.slide {
    display: none;
    position: relative;
}

.slide img {
    width: 100%;
    height: 600px;
    object-fit: cover;
}

.slide-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.slide-content h1 {
    font-size: 3em;
    margin-bottom: 20px;
}

.slide-content p {
    font-size: 1.5em;
    margin-bottom: 30px;
}

.slider-btn {
    cursor: pointer;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    padding: 16px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    background: rgba(0,0,0,0.5);
    border: none;
    border-radius: 50%;
}

.prev {
    left: 20px;
}

.next {
    right: 20px;
}

.slider-dots {
    text-align: center;
    position: absolute;
    bottom: 20px;
    width: 100%;
}

.dot {
    cursor: pointer;
    height: 12px;
    width: 12px;
    margin: 0 5px;
    background-color: rgba(255,255,255,0.5);
    border-radius: 50%;
    display: inline-block;
}

.dot.active {
    background-color: white;
}

.fade {
    animation: fade 0.5s ease-in-out;
}

@keyframes fade {
    from {opacity: 0.4}
    to {opacity: 1}
}

/* Booking Form Styles */
.booking-section {
    background-color: #f4f4f4;
    padding: 40px 0;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.booking-form h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 5px;
    color: #555;
}

.form-group input,
.form-group select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    .slide-content h1 {
        font-size: 2.5rem;
    }
    
    .slide-content p {
        font-size: 1.2rem;
    }
    
    .booking-form {
        margin: 20px;
    }
}

/* Destinations Section Styles */
.destinations-section {
    padding: 80px 0;
    background-color: #fff;
}

.section-title {
    text-align: center;
    color: #446A46;
    margin-bottom: 40px;
    font-size: 2.5rem;
}

.destinations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.destination-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.destination-card:hover {
    transform: translateY(-5px);
}

.destination-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.destination-content {
    padding: 20px;
}

.destination-content h3 {
    color: #446A46;
    margin-bottom: 10px;
    font-size: 1.5rem;
}

.destination-content p {
    color: #666;
    margin-bottom: 15px;
    line-height: 1.5;
}

.learn-more {
    display: inline-block;
    padding: 8px 20px;
    background-color: #F4A460;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.learn-more:hover {
    background-color: #E38B4F;
}

.text-center {
    text-align: center;
}

.see-more-btn {
    display: inline-block;
    padding: 12px 30px;
    background-color: #446A46;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    margin-top: 20px;
}

.see-more-btn:hover {
    background-color: #558B58;
}

/* Discount Banner Styles */
.discount-banner {
    position: relative;
    background-color: #446A46;
    background-image: linear-gradient(45deg, #446A46, #558B58);
    color: white;
    text-align: center;
    padding: 50px 0;
    overflow: hidden;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}

.banner-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: repeating-linear-gradient(
        45deg,
        #000,
        #000 20px,
        #222 20px,
        #222 40px
    );
    opacity: 0.05;
}

.rolling-tags {
    position: absolute;
    top: 0;
    left: 0;
    width: 200%;
    height: 100%;
    background: url('images/discount.png') repeat-x;
    background-size: auto 160px;
    animation: roll 25s linear infinite;
    opacity: 0.15;
    filter: contrast(150%);
}

.discount-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 30px;
}

.banner-text {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.welcome-text {
    font-size: 3rem;
    font-weight: bold;
    color: #FFD700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.signup-btn {
    display: inline-flex;
    align-items: center;
    gap: 15px;
    padding: 20px 40px;
    background-color: #F4A460;
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-size: 1.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 3px solid rgba(255,255,255,0.2);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 10px;
}

.explore-btn {
    display: inline-flex;
    align-items: center;
    gap: 1px;
    padding: 10px 20px;
    background-color: #F4A460;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid rgba(255,255,255,0.2);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 5px;
}

.explore-btn i {
    font-size: 0.9rem;
}

.explore-btn:hover {
    background-color: #E38B4F;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}

.highlight {
    font-size: 3.5rem;
    font-weight: bold;
    color: #FFD700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

.discount-details {
    font-size: 2.5rem;
    font-weight: 500;
}

.discount-sub {
    font-size: 2rem;
    font-weight: 300;
    opacity: 0.9;
}

.discount-icon {
    font-size: 4rem;
    animation: bounce 2s infinite;
}

@keyframes roll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-16px);
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .discount-content {
        flex-direction: column;
        padding: 0 20px;
    }
    
    .banner-text {
        gap: 15px;
    }
}

@media (max-width: 768px) {
    .discount-banner {
        height: auto;
        padding: 30px 0;
    }
    
    .banner-text {
        gap: 10px;
    }
}
</style>

<!-- Add this in your header or before closing body tag -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Update your JavaScript -->
<script>
let slideIndex = 0;
showSlides();

function showSlides() {
    const slides = document.getElementsByClassName("slide");
    const dots = document.getElementsByClassName("dot");
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.opacity = "0";
        dots[i].className = dots[i].className.replace(" active", "");
    }
    
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    
    slides[slideIndex-1].style.opacity = "1";
    dots[slideIndex-1].className += " active";
    
    setTimeout(showSlides, 5000); // Change slide every 5 seconds
}

// Add date validation
document.getElementById('check-in').addEventListener('change', function() {
    const checkIn = new Date(this.value);
    const checkOut = document.getElementById('check-out');
    
    checkOut.min = this.value;
    if(new Date(checkOut.value) <= checkIn) {
        checkOut.value = '';
    }
});

document.getElementById('submitButton').addEventListener('click', function() {
    const destinationSelect = document.getElementById('destination');
    const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
    const redirectUrl = selectedOption.getAttribute('data-url');

    if (redirectUrl) {
        window.location.href = redirectUrl;
    } else {
        alert('Please select a destination.');
    }
});
</script>

<?php include 'components/chatbot.php'; ?>

<?php include 'components/footer.php'; ?>
<script src="js/slider.js"></script>
</body>
</html> 
