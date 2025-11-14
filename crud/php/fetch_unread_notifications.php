<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("SELECT * FROM notifications WHERE member_id =:member_id AND is_read = 0");
$stmt -> execute([
    ":member_id" => $member_id
]);
$unread = $stmt -> fetchAll(PDO::FETCH_ASSOC);
echo json_encode($unread);

?>