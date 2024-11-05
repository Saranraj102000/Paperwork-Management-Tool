<?php
// Include the required SwiftMailer files
require_once 'swiftmailer-5.4.12/lib/swift_required.php';

try {
    // Create the Transport for your mail server (Gmail's SMTP server in this case)
    $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')  // Use TLS encryption
        ->setUsername('saranraj50540@gmail.com')  // Your Gmail address
        ->setPassword('duxaotaxptdtniez');  // Your Gmail app-specific password (if 2FA is enabled, use app password)

    // Create the Mailer using the created Transport
    $mailer = Swift_Mailer::newInstance($transport);

    // Create an email message
    $message = Swift_Message::newInstance('Test Email from SwiftMailer')  // Set email subject
        ->setFrom(['saranraj50540@gmail.com' => 'saranraj'])  // Sender's email and name
        ->setTo(['thesharanraj2000@gmail.com' => 'sharanraj'])  // Recipient's email and name
        ->setBody('This is a test email sent using SwiftMailer!')  // Plain text body
        ->addPart('<p>This is a <strong>test email</strong> sent using SwiftMailer!</p>', 'text/html');  // HTML body

    // Send the message
    $result = $mailer->send($message);

    if ($result) {
        echo 'Test email sent successfully!';
    } else {
        echo 'Failed to send the test email.';
    }

} catch (Exception $e) {
    // Display any caught exceptions
    echo 'Failed to send the test email: ' . $e->getMessage();
}
