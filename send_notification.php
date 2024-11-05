<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include Composer's autoloader

function sendNotification($toEmail, $subject, $body) {
    $mail = new PHPMailer(true);  // Create a new PHPMailer instance

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                 // Enable SMTP authentication
        $mail->Username   = 'saranraj50540@gmail.com';  // SMTP username
        $mail->Password   = 'duxaotaxptdtniez';      // SMTP password
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption
        $mail->Port       = 465;                  // TCP port to connect to

        // Recipients
        $mail->setFrom('saranraj50540@gmail.com');
        $mail->addAddress('saranraj102000@gmail.com');  // Add a recipient

        // Content
        $mail->isHTML(true);         // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $toEmail = 'admin@example.com';
    $subject = 'Form Submitted Successfully';
    $body = '<p>A new form has been submitted successfully.</p>';

    if (sendNotification($toEmail, $subject, $body)) {
        echo "Notification sent.";
    } else {
        echo "Failed to send notification.";
    }
}
?>
