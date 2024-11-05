<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_id'])) {
    $recordId = intval($_POST['record_id']);
    $query = "SELECT old_status, new_status, changed_by, change_date, reason FROM status_change_log WHERE record_id = ? ORDER BY change_date DESC";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $recordId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $logData = [];
        while ($row = $result->fetch_assoc()) {
            $logData[] = $row;
        }

        // Send JSON response
        echo json_encode($logData);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Query preparation failed']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
