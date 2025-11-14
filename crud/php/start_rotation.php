<?php
session_start();
include_once "../../connection.php";

$group_id = $_SESSION["member_group"];
$start_date = date("Y-m-d");
$end_date = "";
$status = $_POST["status"];

// retrieve all member ids
$stmt = $conn->prepare("SELECT member_id FROM member WHERE group_id = :group_id ORDER BY member_id ASC");
$stmt->execute([
    ":group_id" => $group_id
]);

$members = $stmt->fetchAll(PDO::FETCH_COLUMN);

// array of member ids
$rotation_members = $members;

$rotation = $conn->prepare("INSERT INTO group_rotation(group_id, start_date, end_date, current_member_id, rotation_status, total_pot) VALUES(:group_id, :start_date, :end_date, :current_member_id, :rotation_status, :total_pot)");
$rotation->execute([
    ":group_id" => $group_id,
    ":start_date" => $start_date,
    ":end_date" => $end_date,
    ":current_member_id" => $rotation_members[0],
    ":rotation_status" => $status,
    ":total_pot" => $total_pot,
]);

?>