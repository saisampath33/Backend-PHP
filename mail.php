<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
 
header("Access-Control-Allow-Origin: http://localhost:3000"); // Allow requests from localhost:3000
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Specify allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email']?? null;
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["message" => "Invalid email address."]);
    http_response_code(400);
    exit();
}

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'sampathmay10@gmail.com';               // SMTP username
    $mail->Password   = 'fppvpzarhuglelzb';                // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption
    $mail->Port       = 587;                                   // TCP port to connect to
    // Recipients
    $mail->setFrom('your_email@gmail.com', 'Soft Street');
    $mail->addAddress($email);                   // Add a recipient
    // Content
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = 'Subscription Confirmation';
    $mail->Body    = '<h1>Thank You for Subscribing!</h1><p>You have successfully subscribed to our newsletter. Stay tuned for exclusive offers!</p>';
   

    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
