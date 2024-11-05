<?php

// require 'db.php'; // Assuming this contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Database connection
    $conn = new mysqli("localhost", "formdata", "formdata@123", "formdata");

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate token and expiration time (1 hour from now)
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store the token in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $token, $expiry, $email);
        if ($stmt->execute()) {
            // Send reset email
            $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
            $subject = "Password Reset Request";
            $message = "Click the link below to reset your password:\n\n" . $reset_link;
            
            // Set email headers
            $headers = "From: noreply@yourdomain.com\r\n";
            $headers .= "Reply-To: noreply@yourdomain.com\r\n";
            $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

            // Send the email
            if (mail($email, $subject, $message, $headers)) {
                echo "A password reset link has been sent to your email.";
            } else {
                echo "Failed to send the email. Please try again later.";
            }
        } else {
            echo "Failed to update the database.";
        }
    } else {
        echo "No account found with that email.";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
