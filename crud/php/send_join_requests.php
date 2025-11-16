<?php
session_start();
include_once "../../connection.php";

date_default_timezone_set('Asia/Singapore');
$member_id = $_SESSION["member_id"];
$group_id = $_POST["group_id"];
$date_time = date("Y-m-d H:i:s");

// retrieve group creator/leader id 
$fetch = $conn -> prepare("SELECT creator_id FROM groups WHERE group_id =:group_id");
$fetch -> execute([
    ":group_id" => $group_id
]);
$creator_id = $fetch -> fetch(PDO::FETCH_COLUMN);

/// send join request to group
$stmt = $conn -> prepare("INSERT INTO join_requests(creator_id, member_id, group_id, date_time_requested, message) 
VALUES(:creator_id, :member_id, :group_id, :date_time_requested, :message)");
$stmt -> execute([
    ":creator_id" => $creator_id,
    ":member_id" => $member_id,
    ":group_id" => $group_id,
    ":date_time_requested" => $date_time,
    ":message" => "I would like to join your group",
]);

//send notification for request
$notify = $conn -> prepare("INSERT INTO notifications(member_id, description, is_read, date_time_created) 
VALUES(:member_id, :description, :is_read, :date_time_created)");

$notify -> execute([
    ":member_id" => $creator_id,
    ":description" => "Someone wants to join your group",
    ":is_read" => 0,
    ":date_time_created" => $date_time,
]);

echo "request sent";

?>