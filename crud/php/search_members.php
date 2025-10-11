<?php
include_once("../../connection.php");
session_start();

$search = $_POST['search'];
$current_member = $_SESSION['member_id'];

// Get current member’s group_id
$stmt = $conn->prepare("SELECT group_id FROM member WHERE member_id = :member_id");
$stmt->execute(['member_id' => $current_member]);
$group = $stmt->fetch(PDO::FETCH_ASSOC);

if ($group && $group['group_id']) {
    $group_id = $group['group_id'];

    // Members already in group
    $excludeQuery = $conn->prepare("SELECT member_id FROM member WHERE group_id = :group_id");
    $excludeQuery->execute(['group_id' => $group_id]);
    $excluded = $excludeQuery->fetchAll(PDO::FETCH_COLUMN);

    // Members already invited
    $inviteQuery = $conn->prepare("SELECT reciever_id FROM group_invitations WHERE group_id = :group_id");
    $inviteQuery->execute(['group_id' => $group_id]);
    $invited = $inviteQuery->fetchAll(PDO::FETCH_COLUMN);

    $excluded_ids = array_merge($excluded, $invited, [$current_member]);
    if (empty($excluded_ids)) $excluded_ids = [0];

    $placeholders = implode(',', array_fill(0, count($excluded_ids), '?'));

    // Final search (exclude already grouped or invited)
    $stmt = $conn->prepare("
        SELECT member_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name
        FROM member
        WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?
        AND member_id NOT IN ($placeholders)
        LIMIT 5
    ");
    $params = array_merge(["%$search%"], $excluded_ids);
    $stmt->execute($params);

} else {
    // If no group yet, search normally (exclude self)
    $stmt = $conn->prepare("
        SELECT member_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name
        FROM member
        WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?
        AND member_id != ?
        LIMIT 5
    ");
    $stmt->execute(["%$search%", $current_member]);
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);

?>