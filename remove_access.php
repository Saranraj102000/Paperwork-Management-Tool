<?php
// Database connection
require "db.php";

// Get JSON data from POST request
$data = json_decode(file_get_contents('php://input'), true);
$userId = intval($data['userId']);
$assignedUserId = intval($data['assignedUserId']);

// Validate input
if (!$userId || !$assignedUserId) {
    echo json_encode(['success' => false, 'message' => 'Invalid user data']);
    exit;
}

// Fetch current access_list for the user_id
$sql = "SELECT access_list FROM user_access WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $accessList = explode(',', $row['access_list']);

    // Remove the assignedUserId from access_list if it exists
    $updatedAccessList = array_filter($accessList, function($id) use ($assignedUserId) {
        return $id != $assignedUserId;
    });

    // Update the access_list in the database
    $newAccessList = implode(',', $updatedAccessList);
    $sqlUpdate = "UPDATE user_access SET access_list = ? WHERE user_id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("si", $newAccessList, $userId);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update access list']);
    }
    $stmtUpdate->close();
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
