<?php
// Assume database connection is established as $conn
require "db.php";

// Retrieve user ID from the GET request
$userId = intval($_GET['user_id']);

// Query to get access_list for the provided user_id
$sql = "SELECT access_list FROM user_access WHERE user_id = $userId";
$result = $conn->query($sql);

$assignedUsers = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $accessList = $row['access_list'];

    // Check if access_list is not empty
    if (!empty($accessList)) {
        // Fetch user details from `users` table for all IDs in access_list
        $sqlUsers = "SELECT name, email FROM users WHERE id IN ($accessList)";
        $resultUsers = $conn->query($sqlUsers);

        while ($userRow = $resultUsers->fetch_assoc()) {
            $assignedUsers[] = $userRow;
        }
    }
}

echo json_encode(['assignedUsers' => $assignedUsers]);
?>
