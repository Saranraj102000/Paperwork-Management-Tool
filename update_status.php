<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $new_status = $_POST['status'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;

    // Prepare your query based on the status
    if ($reason && in_array($new_status, ['candidate_drop', 'client_drop', 'rehired', 'project_extension'])) {
        // Status that requires a reason
        $stmt = $conn->prepare("UPDATE paperworkdetails SET status = ?, reason = ? WHERE id = ?");
        $stmt->bind_param("ssi", $new_status, $reason, $id);
    } else if ($new_status === 'starts' && $start_date) {
        // Store start_date in both 'start_date' and 'reason' column
        $stmt = $conn->prepare("UPDATE paperworkdetails SET status = ?, start_date = ?, reason = ? WHERE id = ?");
        $stmt->bind_param("sssi", $new_status, $start_date, $start_date, $id); // Store start date in both columns
    } else {
        // General status update without reason or start date
        $stmt = $conn->prepare("UPDATE paperworkdetails SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $id);
    }

    // Execute the query and handle the response
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
