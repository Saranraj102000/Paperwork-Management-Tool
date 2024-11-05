<?php
include 'db.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // No hashing

    // List of allowed domains
    $allowedDomains = ['@vdartinc.com', '@dimiour.com', '@trustpeople.com'];

    // Get the domain part of the email
    $emailDomain = substr($email, strpos($email, '@'));

    // Validate that the email ends with one of the allowed domains
    if (!in_array($emailDomain, $allowedDomains)) {
        // Respond with an error if the email is not from the correct domain
        echo json_encode(['status' => 'error', 'message' => 'Email must end with @vdartinc.com, @dimiour.com, or @trustpeople.com']);
        exit();
    }


    // Check if the email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        // Respond with a JSON message for email existence
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    } else {
        // Insert new user into the database without hashing the password
        $sql = "INSERT INTO users (name, email, password) VALUES ('$fullname', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Respond with a success message
            echo json_encode(['status' => 'success', 'message' => 'Signup successful!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Signup failed. Please try again.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>



