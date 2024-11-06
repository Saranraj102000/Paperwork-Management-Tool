<?php
include 'db.php';

$data = json_decode(file_get_contents("php://input"), true);
$userId = $data['userId'];
$selectedUserIds = array_map('intval', $data['selectedUserIds']);

$conn->begin_transaction();

try {
    // Get current access list
    $stmt = $conn->prepare("SELECT access_list FROM user_access WHERE user_id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentAccess = $result->fetch_assoc();
    
    $currentUserIds = $currentAccess ? 
        array_map('intval', explode(',', $currentAccess['access_list'])) : 
        [];

    // Find removed users
    $removedUsers = array_diff($currentUserIds, $selectedUserIds);
    
    // Update access_history for removed users
    if (!empty($removedUsers)) {
        $endDate = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("
            UPDATE user_access_history 
            SET access_end_date = ?, status = 'Inactive'
            WHERE user_id = ? AND assigned_user_id IN (" . implode(',', $removedUsers) . ")
            AND status = 'Active'
        ");
        $stmt->bind_param('si', $endDate, $userId);
        $stmt->execute();
    }
    
    // Add new access history records
    $newUsers = array_diff($selectedUserIds, $currentUserIds);
    if (!empty($newUsers)) {
        $stmt = $conn->prepare("
            INSERT INTO user_access_history 
            (user_id, assigned_user_id, created_by) 
            VALUES (?, ?, ?)
        ");
        foreach ($newUsers as $newUserId) {
            $stmt->bind_param('iii', $userId, $newUserId, $_SESSION['user_id']);
            $stmt->execute();
        }
    }
    
    // Update current access list
    $selectedUserIdsString = implode(',', $selectedUserIds);
    $stmt = $conn->prepare("
        INSERT INTO user_access (user_id, access_list) 
        VALUES (?, ?) 
        ON DUPLICATE KEY UPDATE access_list = ?
    ");
    $stmt->bind_param('iss', $userId, $selectedUserIdsString, $selectedUserIdsString);
    $stmt->execute();

    $conn->commit();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?>
Improve
Ex