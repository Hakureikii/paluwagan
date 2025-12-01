<?php
session_start();
include_once "../../connection.php";
$group_id = $_SESSION["member_group"];

$stmt = $conn -> prepare("SELECT COUNT(*) as invites FROM group_invitations WHERE group_id =:group_id");
$stmt -> execute([
    ":group_id" => $group_id,
]);
$count = $stmt -> fetch(PDO::FETCH_COLUMN);
echo json_encode($count);

?>