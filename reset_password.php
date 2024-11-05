<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $new_password = $_POST['new_password'];

  // Sanitize inputs
  $email = $conn->real_escape_string($email);
  $new_password = $conn->real_escape_string($new_password);

  // Check if the email exists in the database
  $check_user = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($check_user);

  if ($result->num_rows > 0) {
    // Update the user's password (without hashing)
    $update_query = "UPDATE users SET password = '$new_password' WHERE email = '$email'";
    
    if ($conn->query($update_query) === TRUE) {
      echo "Password reset successfully!";
    } else {
      echo "Error updating password: " . $conn->error;
    }
  } else {
    echo "No user found with this email.";
  }

  $conn->close();
}
?>
