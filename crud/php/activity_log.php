<?php
session_start();
include_once "../../connection.php";

$member_id = $_SESSION["member_id"];

$stmt = $conn -> prepare("SELECT *, DATE(date_time_created) as date
FROM activity_logs 
WHERE member_id =:member_id
ORDER BY date_time_created DESC");
$stmt -> execute([
    ":member_id" => $member_id
]);
$activity_logs = $stmt -> fetchAll(PDO::FETCH_ASSOC);
echo json_encode($activity_logs);

?>