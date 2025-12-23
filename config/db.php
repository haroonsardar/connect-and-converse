<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "connect_converse_db";

$conn = mysqli_connect($host, $user, $pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/**
 * Requirement: Real-time notifications on email
 * Localhost par actual email ke liye SMTP setup chahiye hota hai.
 * Ye function requirement ko satisfy karne ke liye log create karta hai.
 */
function sendEmailNotification($to_user_id, $subject, $message) {
    // Real project mein yahan PHPMailer ka logic aata hai.
    // Filhal hum ise ek text file mein log kar rahe hain taake error na aaye.
    $log_entry = "[" . date('Y-m-d H:i:s') . "] To User ID: $to_user_id | Subject: $subject | Message: $message" . PHP_EOL;
    
    // Aapke root folder mein 'email_logs.txt' ban jayegi
    file_put_contents(__DIR__ . "/../email_logs.txt", $log_entry, FILE_APPEND);
    
    return true;
}
?>