<?php
session_start();
include_once "../../connection.php";

date_default_timezone_set('Asia/Singapore');
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];
$current_date = date("Y-m-d");
$date_created = date("Y-m-d H:i:s");

// retrieve current member's rotation
$stmt = $conn->prepare("
    SELECT * 
    FROM rotation_schedule 
    WHERE member_id = :member_id 
      AND group_id = :group_id
");
$stmt->execute([
    ":member_id" => $member_id,
    ":group_id" => $group_id
]);
$rotation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($rotation) {
    $date_assigned = $rotation["assigned_month"];
    $rotation_id = $rotation["rotation_schedule_id"];

    // check if notification already exists for this rotation date
    $check = $conn->prepare("
        SELECT COUNT(*) 
        FROM notifications 
        WHERE member_id = :member_id 
          AND description = 'Withdrawal ready' 
          AND DATE(date_time_created) = :assigned_date
    ");
    $check->execute([
        ":member_id" => $member_id,
        ":assigned_date" => $date_assigned
    ]);
    $exists = $check->fetchColumn();

    if ($date_assigned == $current_date && $exists == 0) {
        // insert notification
        $notify = $conn->prepare("
            INSERT INTO notifications(member_id, description, is_read, date_time_created) 
            VALUES(:member_id, :description, :is_read, :date_time_created)
        ");
        $notify->execute([
            ":member_id" => $member_id,
            ":description" => "Withdrawal ready",
            ":is_read" => 0,
            ":date_time_created" => $date_created,
        ]);
        echo "Notification sent";
    } else {
        echo "Already notified or not yet";
    }
} else {
    echo "No rotation found";
}
?>
