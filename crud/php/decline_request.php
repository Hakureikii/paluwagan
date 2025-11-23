<?php
session_start();
include_once "../../connection.php";

date_default_timezone_set('Asia/Singapore');
$member_id = $_POST["member_id"];
$group_id = $_SESSION["member_group"];
$date_time = date("Y-m-d H:i:s");

$delete = $conn->prepare("DELETE FROM join_requests WHERE member_id =:member_id AND group_id =:group_id");
$delete->execute([
    ":member_id" => $member_id,
    ":group_id" => $group_id
]);


// notify member after declining
// $notify = $conn->prepare("INSERT INTO notifications(member_id, description, is_read, date_time_created) 
// VALUES(:member_id, :description, :is_read, :date_time)");
// $notify->execute([
//     ":member_id" => $member_id,
//     ":description" => "The leader declined your join request",
//     ":is_read" => 0,
//     ":date_time" => $date_time
// ]);

echo "request declined";
?>