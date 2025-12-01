<?php
session_start();
include_once "../../connection.php";
date_default_timezone_set('Asia/Singapore');

$amount = $_POST["amount"];
$member_id = $_SESSION["member_id"];
$date_time = date("Y-m-d H:i:s");
// $group_id = $_SESSION["member_group"];

$group = $conn -> prepare("SELECT group_id FROM member WHERE member_id = :member_id");
$group -> execute([
    ":member_id" => $member_id,
]);

$group_id = $group -> fetch(PDO::FETCH_COLUMN);

//deposit
$stmt = $conn->prepare("INSERT INTO transactions(transaction_type, transaction_date_time, amount, member_id, group_id) VALUES(:transaction_type, :transaction_date_time, :amount, :member_id, :group_id)");
$stmt->execute([
    ":transaction_type" => "Deposit",
    ":transaction_date_time" => $date_time,
    ":amount" => $amount,
    ":member_id" => $member_id,
    ":group_id" => $group_id,
]);

$fetch = $conn->prepare("SELECT total_pot FROM group_rotation WHERE group_id = :group_id AND rotation_status = 'Ongoing'");
$fetch->execute([
    ":group_id" => $group_id
]);
$total_pot = $fetch->fetch(PDO::FETCH_COLUMN);

if ($total_pot !== false) {
    $update = $conn->prepare("UPDATE group_rotation SET total_pot = :new_amount WHERE group_id = :group_id AND rotation_status = 'Ongoing'");
    $update->execute([
        ":new_amount" => $total_pot + $amount,
        ":group_id" => $group_id,
    ]);
}

//activity log
$log = $conn->prepare("INSERT INTO activity_logs(title, description, date_time_created, member_id) VALUES(:title, :description, :date_time, :member_id)");
$log->execute([
    ":title" => "Transaction: Deposit",
    ":description" => "You Deposited: ₱" . $amount,
    ":date_time" => $date_time,
    ":member_id" => $member_id,
]);

echo "complete";

?>