<?php
include 'db.php';

$result = $conn->query("SELECT id, email FROM users");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode(['users' => $users]);

$conn->close();
?>
