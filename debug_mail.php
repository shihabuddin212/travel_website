<?php
require 'vendor/autoload.php';
require 'helpers/EmailHelper.php';

use PHPMailer\PHPMailer\SMTP;

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $emailHelper = new EmailHelper();
    $emailHelper->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
    $emailHelper->sendPasswordResetEmail('test@example.com', 'test-token');
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} 