<?php
// Include the database connection file
include 'db.php'; // Ensure this path points to your actual database connection file
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);
    
    $recordId = !empty($data['id']) ? intval($data['id']) : null;
    $status = !empty($data['status']) ? $data['status'] : null;
    $reason = !empty($data['reason']) ? $data['reason'] : '';
    $changedBy = $_SESSION['email'] ?? 'Unknown User'; // Get the user email from the session

    // Check if status is 'started' and format reason to include the start date
    if ($status === 'started' && $reason) {
        $formattedStartDate = DateTime::createFromFormat('Y-m-d', trim(str_replace('Start Date: ', '', $reason)));
        if ($formattedStartDate) {
            $reason = "Start Date: " . $formattedStartDate->format('Y-m-d'); // Format as required
        }
    }

    // Check if both record ID and status are provided
    if ($recordId && $status) {
        // Retrieve the current status from the database before updating
        $currentStatus = '';
        $selectQuery = "SELECT status FROM paperworkdetails WHERE id = ?";
        if ($stmt = $conn->prepare($selectQuery)) {
            $stmt->bind_param("i", $recordId);
            $stmt->execute();
            $stmt->bind_result($currentStatus);
            $stmt->fetch();
            $stmt->close();
        }

        // Prepare the SQL query to update the status and reason in the database
        $updateQuery = "UPDATE paperworkdetails SET status = ?, reason = ? WHERE id = ?";
        if ($stmt = $conn->prepare($updateQuery)) {
            // Bind parameters: 's' for strings, 'i' for integers
            $stmt->bind_param('ssi', $status, $reason, $recordId);

            // Execute the statement
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    // Prepare the log insertion query for status_change_log
                    $logQuery = "INSERT INTO status_change_log (record_id, old_status, new_status, changed_by, reason) VALUES (?, ?, ?, ?, ?)";
                    if ($logStmt = $conn->prepare($logQuery)) {
                        $logStmt->bind_param("issss", $recordId, $currentStatus, $status, $changedBy, $reason);
                        $logStmt->execute();
                        $logStmt->close();
                    }
                    echo json_encode(['status' => 'success']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No rows affected']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Update failed']);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
