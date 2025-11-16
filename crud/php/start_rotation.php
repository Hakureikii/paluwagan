<?php
session_start();
include_once "../../connection.php";

$group_id = $_SESSION["member_group"];
$start_date = date("Y-m-d");
$status = $_POST["status"];

// retrieve total pot
$contributions = $conn->prepare("
    SELECT SUM(t.amount) as total_contributions
    FROM transactions as t
    INNER JOIN member as m ON m.member_id = t.member_id
    INNER JOIN groups as g ON g.group_id = m.group_id
    WHERE g.group_id = :group_id
");
$contributions->execute([":group_id" => $group_id]);
$total_pot = $contributions->fetch(PDO::FETCH_COLUMN);

// retrieve all member ids
$stmt = $conn->prepare("SELECT member_id FROM member WHERE group_id = :group_id ORDER BY member_id ASC");
$stmt->execute([":group_id" => $group_id]);
$rotation_members = $stmt->fetchAll(PDO::FETCH_COLUMN);

// compute end date (last month in rotation)
$total_members = count($rotation_members);
$end_date = date("Y-m-d", strtotime("+".($total_members)." months", strtotime($start_date))); // +1 more month since first member starts after start_date

// insert master rotation record
$rotation = $conn->prepare("
    INSERT INTO group_rotation(group_id, start_date, end_date, current_member_id, rotation_status, total_pot)
    VALUES(:group_id, :start_date, :end_date, :current_member_id, :rotation_status, :total_pot)
");

$rotation->execute([
    ":group_id" => $group_id,
    ":start_date" => $start_date,
    ":end_date" => $end_date,
    ":current_member_id" => $rotation_members[0],
    ":rotation_status" => $status,
    ":total_pot" => $total_pot,
]);

// generate rotation schedule for every member
$assigned_month = date("Y-m-d", strtotime("+1 month", strtotime($start_date))); // first member starts one month after rotation start

$schedule = $conn->prepare("
    INSERT INTO rotation_schedule (group_id, member_id, assigned_month, status)
    VALUES (:group_id, :member_id, :assigned_month, 'pending')
");

foreach ($rotation_members as $member_id) {
    $schedule->execute([
        ":group_id" => $group_id,
        ":member_id" => $member_id,
        ":assigned_month" => $assigned_month
    ]);

    // move to next month for the next member
    $assigned_month = date("Y-m-d", strtotime("+1 month", strtotime($assigned_month)));
}

echo "rotation started!";
?>
