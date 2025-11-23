<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];
$date = date("Y-m-d");

$fetch = $conn->prepare("SELECT * FROM rotation_schedule 
WHERE group_id = :group_id 
AND member_id = :member_id 
AND status = 'pending'
AND assigned_month = :date");

$fetch->execute([
    ":group_id" => $group_id,
    ":member_id" => $member_id,
    ":date" => $date,
]);
$enable = $fetch->fetch(PDO::FETCH_ASSOC);

//RETRIEVE TO WITHDRAW OF MEMBER
$pot = $conn->prepare("SELECT total_pot FROM group_rotation 
WHERE group_id = :group_id AND rotation_status = 'Ongoing'");
$pot->execute([
    ":group_id" => $group_id,
]);
$total_pot = $pot->fetch(PDO::FETCH_COLUMN);


// transfer the current money to the current user of the rotation
if ($enable === false) {
    echo "disable";
} else {
    $store = $conn->prepare("UPDATE rotation_schedule SET to_withdraw = :to_withdraw 
    WHERE member_id = :member_id AND group_id = :group_id AND status = 'pending' AND assigned_month = :date");
    $store->execute([
        ":to_withdraw" => $total_pot,
        ":member_id" => $member_id,
        ":group_id" => $group_id,
        ":date" => $date,
    ]);
    echo "enable";
}
?>