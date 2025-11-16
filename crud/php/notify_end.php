<?php
session_start();
include_once "../../connection.php";

$group_id = $_SESSION["member_group"];
$current_date = date("Y-m-d");

$stmt = $conn -> prepare("SELECT end_date FROM group_rotation WHERE group_id = :group_id");
$stmt -> execute([
    ":group_id" => $group_id
]);
$end_cycle = $stmt -> fetch(PDO::FETCH_COLUMN);

if ($end_cycle !== false) {
    if ($end_cycle === $current_date) {
        echo "end";
    }
}


?>