<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];

$stmt = $conn -> prepare("SELECT COUNT(*) as deposits FROM transactions WHERE member_id =:member_id AND group_id =:group_id");
$stmt -> execute([
    ":member_id" => $member_id,
    ":group_id" => $group_id,
]);
$count = $stmt -> fetch(PDO::FETCH_COLUMN);
echo json_encode($count);

?>