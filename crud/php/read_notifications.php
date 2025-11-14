<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("UPDATE notifications SET is_read =:is_read WHERE member_id = :member_id AND is_read = 0");
$stmt->execute([
    ":is_read" => 1,
    ":member_id" => $member_id,
]);


?>