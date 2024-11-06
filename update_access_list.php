<?php
require "db.php";

// Get JSON data from the POST request
$data = json_decode(file_get_contents('php://input'), true);
$userId = intval($data['userId']);
$remainingUserIds = $data['remainingUserIds'];

// Validate input
if (!$userId || !is_array($remainingUserIds)) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

// Convert remainingUserIds to a comma-separated list
$newAccessList = implode(',', array_map('intval', $remainingUserIds));

// Update the access_list in the database
$sql = "UPDATE user_access SET access_list = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newAccessList, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update access list']);
}

$stmt->close();
$conn->close();
?>
