<?php
include 'db.php'; // Include the database connection
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // Store the password as plain text

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Compare the plain text password with the stored password
        if ($password === $row['password']) {
            $_SESSION['email'] = $email; // Store email in session
            // Send success response with redirection URL
            echo json_encode(['status' => 'success', 'redirect' => 'dashboard.php']);
        } else {
            // Password is incorrect
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        }
    } else {
        // No user found with that email
        echo json_encode(['status' => 'error', 'message' => 'No user found with this email']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}
?>
