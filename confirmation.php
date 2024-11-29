<?php
session_start();
$pageTitle = "Booking Confirmation - BD Adventures";
include 'components/header.php';
include 'components/nav.php';

// Check for success message
$successMessage = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>

<div class="confirmation-container">
    <?php if ($successMessage): ?>
        <h2>Booking Confirmed!</h2>
        <p><?php echo htmlspecialchars($successMessage); ?></p>
        <a href="index.php" class="btn">Back to Home</a>
    <?php else: ?>
        <h2>No Booking Found</h2>
        <p>It seems there was an issue with your booking. Please try again.</p>
        <a href="index.php" class="btn">Back to Home</a>
    <?php endif; ?>
</div>

<style>
.confirmation-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.confirmation-container h2 {
    color: #28a745;
}

.confirmation-container p {
    margin: 20px 0;
}

.confirmation-container .btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

.confirmation-container .btn:hover {
    background-color: #218838;
}
</style>

<?php include 'components/footer.php'; ?> 