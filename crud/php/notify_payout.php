<?php
session_start();
include_once "../../connection.php";

date_default_timezone_set('Asia/Singapore');
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];
$current_date = date("Y-m-d");
$date_created = date("Y-m-d H:i:s");

// retrieve current member's assigned month
$stmt = $conn->prepare("SELECT assigned_month FROM rotation_schedule WHERE member_id =:member_id AND group_id =:group_id");
$stmt->execute([
    ":member_id" => $member_id,
    ":group_id" => $group_id
]);
$date_assigned = $stmt->fetch(PDO::FETCH_COLUMN);

if ($date_assigned == $current_date) {
    $notify = $conn -> prepare("INSERT INTO notifications(member_id, description, is_read, date_time_created) VALUES(:member_id, :description, :is_read, :date_time_created)");
    $notify -> execute([
        ":member_id" => $member_id,
        ":description" => "Withdrawal ready",
        ":is_read" => 0,
        ":date_time_created" => $date_created,
    ]);
} else {
    echo "not yet";
}

?>