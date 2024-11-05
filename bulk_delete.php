<?php
session_start();
require 'db.php'; // Your database connection file

// Check if the user is an admin
$userEmail = $_SESSION['email'] ?? '';
$isAdmin = ($userEmail == 'saranraj.s@vdartinc.com'); // Replace with your admin check

if (!$isAdmin) {
    echo 'error'; // Non-admin users are not allowed to delete records
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids = $_POST['ids'] ?? [];

    if (empty($ids)) {
        echo 'error'; // No records selected
        exit;
    }

    // Prepare the SQL query to delete records by their IDs
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM paperworkdetails WHERE id IN ($placeholders)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($ids)), ...$ids);

    if ($stmt->execute()) {
        echo 'success'; // Deletion was successful
    } else {
        echo 'error'; // Failed to delete the records
    }

    $stmt->close();
}

$conn->close();
?>
