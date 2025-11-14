<?php
session_start();
include_once "../../connection.php";
date_default_timezone_set('Asia/Singapore');

$amount = $_POST["amount"];
$member_id = $_SESSION["member_id"];
$date_time = date("Y-m-d H:i:s");

//deposit
$stmt = $conn -> prepare("INSERT INTO transactions(transaction_type, transaction_date_time, amount, member_id) VALUES(:transaction_type, :transaction_date_time, :amount, :member_id)");
$stmt -> execute([
    ":transaction_type" => "Deposit",
    ":transaction_date_time" => $date_time,
    ":amount" => $amount,
    ":member_id" => $member_id,
]);

//activity log
$log = $conn -> prepare("INSERT INTO activity_logs(title, description, date_time_created, member_id) VALUES(:title, :description, :date_time, :member_id)");
$log -> execute([
    ":title" => "Transaction: Deposit",
    ":description" => "You Deposited: ₱" . $amount,
    ":date_time" => $date_time,
    ":member_id" => $member_id,
]);

echo "complete";

?>