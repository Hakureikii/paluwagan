<?php
session_start();
include_once "../../connection.php";

date_default_timezone_set('Asia/Singapore');
$member_id = $_POST["member_id"];
$group_id = $_SESSION["member_group"];
$date_time = date("Y-m-d H:i:s");

$stmt = $conn->prepare("UPDATE member SET group_id =:group_id WHERE member_id =:member_id");
$stmt->execute([
    ":group_id" => $group_id,
    ":member_id" => $member_id
]);


// delete join request after approval
$delete = $conn->prepare("DELETE FROM join_requests WHERE member_id =:member_id AND group_id =:group_id");
$delete->execute([
    ":member_id" => $member_id,
    ":group_id" => $group_id
]);


// notify member after approval
$notify = $conn->prepare("INSERT INTO notifications(member_id, description, is_read, date_time_created) 
VALUES(:member_id, :description, :is_read, :date_time)");
$notify->execute([
    ":member_id" => $member_id,
    ":description" => "The leader accepted your join request",
    ":is_read" => 0,
    ":date_time" => $date_time
]);

echo "accepted request";

?>