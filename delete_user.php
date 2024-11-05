<?php
session_start();
require 'db.php'; // Ensure you have your database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the raw POST data
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if ID is set
    if (isset($data['id'])) {
        $userId = intval($data['id']);

        // Prepare a SQL statement to delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            // User deleted successfully
            echo json_encode(['success' => true]);
        } else {
            // Error deleting user
            echo json_encode(['success' => false, 'message' => 'Could not delete user.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'User ID is required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
$conn->close();
