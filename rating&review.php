<?php
session_start();
require 'config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch booking data and check if review exists
try {
    $stmt = $pdo->prepare("
        SELECT 
            b.id, 
            p.title, 
            b.travel_date,
            CASE 
                WHEN r.id IS NOT NULL THEN 1 
                ELSE 0 
            END as has_review,
            r.rating as existing_rating,
            r.comment as existing_comment
        FROM bookings b 
        JOIN packages p ON b.package_id = p.id 
        LEFT JOIN reviews r ON r.package_id = p.id AND r.user_id = b.user_id
        WHERE b.user_id = ? AND b.status = 'confirmed'
    ");
    $stmt->execute([$user_id]);
    $bookings = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    $bookings = [];
}

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    try {
        // Check if review already exists
        $stmt = $pdo->prepare("
            SELECT r.id 
            FROM reviews r
            JOIN bookings b ON b.package_id = r.package_id
            WHERE b.id = ? AND r.user_id = ?
        ");
        $stmt->execute([$booking_id, $user_id]);
        $existing_review = $stmt->fetch();

        if ($existing_review) {
            $_SESSION['error_message'] = "You have already submitted a review for this booking.";
        } else {
            // Get package details and insert review
            $stmt = $pdo->prepare("
                SELECT p.id as package_id, 
                       CASE 
                           WHEN p.title LIKE '%Cox%' THEN 1
                           WHEN p.title LIKE '%Saint Martin%' THEN 2
                           WHEN p.title LIKE '%Kuakata%' THEN 3
                       END as destination_id
                FROM bookings b 
                JOIN packages p ON b.package_id = p.id 
                WHERE b.id = ?
            ");
            $stmt->execute([$booking_id]);
            $package = $stmt->fetch();

            if ($package) {
                $stmt = $pdo->prepare("
                    INSERT INTO reviews (user_id, package_id, destination_id, rating, comment) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $user_id, 
                    $package['package_id'],
                    $package['destination_id'],
                    $rating, 
                    $comment
                ]);
                
                $_SESSION['success_message'] = "Thank you for your review!";
            }
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['error_message'] = "Error submitting review. Please try again.";
    }
    
    header("Location: rating&review.php");
    exit();
}
?>

<?php include 'components/header.php'; ?>
<?php include 'components/nav.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4">Your Travel Reviews</h2>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success_message'] ?></div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error_message'] ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (empty($bookings)): ?>
        <div class="alert alert-info">No confirmed bookings found to review.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($bookings as $booking): ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($booking['title']) ?></h5>
                            <p class="text-muted">Travel Date: <?= htmlspecialchars($booking['travel_date']) ?></p>
                            
                            <?php if ($booking['has_review']): ?>
                                <div class="alert alert-info">
                                    <h6>Your Review</h6>
                                    <div class="rating-display mb-2">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <span class="star <?= $i <= $booking['existing_rating'] ? 'filled' : '' ?>">★</span>
                                        <?php endfor; ?>
                                    </div>
                                    <p><?= htmlspecialchars($booking['existing_comment']) ?></p>
                                </div>
                            <?php else: ?>
                                <form method="post" class="review-form">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <div class="star-rating">
                                            <?php for($i = 5; $i >= 1; $i--): ?>
                                                <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>_<?= $booking['id'] ?>" required>
                                                <label for="star<?= $i ?>_<?= $booking['id'] ?>">☆</label>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="comment" class="form-label">Your Review</label>
                                        <textarea name="comment" class="form-control" rows="3" required 
                                            placeholder="Share your experience..."></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 25px;
    color: #ddd;
    cursor: pointer;
    padding: 0 2px;
}

.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffd700;
}

.review-form {
    max-width: 100%;
}

.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}
</style>

<?php include 'components/footer.php'; ?> 