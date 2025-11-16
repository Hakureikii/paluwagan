<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("SELECT *, DATE(date_time_created) as date
FROM notifications WHERE member_id =:member_id
ORDER BY notification_id DESC");
$stmt->execute([
    ":member_id" => $member_id
]);

$notifications = $stmt -> fetchAll(PDO::FETCH_ASSOC);
echo json_encode($notifications);


?>