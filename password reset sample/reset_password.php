<?php
require 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "formdata");

    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Token is valid
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Update password and clear token
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $new_password, $token);
            $stmt->execute();

            echo "Your password has been updated.";
        } else {
            // Show password reset form
            echo '<form action="" method="POST">
                    <label for="password">Enter your new password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Reset Password</button>
                  </form>';
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>
