<?php
require 'db.php';

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $userId = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    $role = $data['role'];

    // Update user details in the database
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $userId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating user']);
    }
    $stmt->close();
}
$conn->close();
?>
