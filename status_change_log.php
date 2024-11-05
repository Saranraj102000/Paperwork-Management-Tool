<?php
session_start();
ob_start();

include 'db.php';

// Capture "Submitted By" from session
$recmail = $_SESSION['email'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordId = $_POST['record_id'];
    $newStatus = $_POST['status'];
    $reason = $_POST['reason'] ?? ''; // Optional reason

    // Retrieve current status before update
    $currentStatus = '';
    $query = "SELECT status FROM paperworkdetails WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $recordId);
        $stmt->execute();
        $stmt->bind_result($currentStatus);
        $stmt->fetch();
        $stmt->close();
    }

    // Update status in paperworkdetails
    $updateQuery = "UPDATE paperworkdetails SET status = ? WHERE id = ?";
    if ($updateStmt = $conn->prepare($updateQuery)) {
        $updateStmt->bind_param("si", $newStatus, $recordId);
        if ($updateStmt->execute()) {

            // Insert into status_change_log
            $logQuery = "INSERT INTO status_change_log (record_id, old_status, new_status, changed_by, reason) VALUES (?, ?, ?, ?, ?)";
            if ($logStmt = $conn->prepare($logQuery)) {
                $logStmt->bind_param("issss", $recordId, $currentStatus, $newStatus, $recmail, $reason);
                $logStmt->execute();
                $logStmt->close();
            }
            echo json_encode(['status' => 'success', 'message' => 'Status updated and logged']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
        }
        $updateStmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
    }

    $conn->close();
}
?>
