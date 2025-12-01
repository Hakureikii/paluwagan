<?php
session_start();
include_once "../../connection.php";
date_default_timezone_set('Asia/Singapore');

$amount = $_POST["amount"];
$member_id = $_SESSION["member_id"];
$date_time = date("Y-m-d H:i:s");
$group_id = $_SESSION["member_group"];

$fetch = $conn->prepare("SELECT to_withdraw FROM rotation_schedule 
WHERE group_id = :group_id AND status = 'pending' AND member_id =:member_id");
$fetch->execute([
    ":group_id" => $group_id,
    ":member_id" => $member_id,
]);
$total_pot = $fetch->fetch(PDO::FETCH_COLUMN);

$group_rotation = $conn->prepare("SELECT total_pot FROM group_rotation WHERE rotation_status = 'Ongoing' AND group_id = :group_id");
$group_rotation->execute([
    ":group_id" => $group_id
]);
$group_pot = $group_rotation->fetch(PDO::FETCH_COLUMN);

if ($total_pot !== false) {
    if ($total_pot >= $amount) {

        // withdraw
        $stmt = $conn->prepare("INSERT INTO transactions(transaction_type, transaction_date_time, amount, member_id, group_id) VALUES(:transaction_type, :transaction_date_time, :amount, :member_id, :group_id)");
        $stmt->execute([
            ":transaction_type" => "Withdrawal",
            ":transaction_date_time" => $date_time,
            ":amount" => $amount,
            ":member_id" => $member_id,
            ":group_id" => $group_id,
        ]);

        $update = $conn->prepare("UPDATE rotation_schedule SET to_withdraw = :new_amount, status =:status WHERE group_id = :group_id AND status = 'pending' AND member_id =:member_id");
        $update->execute([
            ":new_amount" => $total_pot - $amount,
            ":status" => "Ended",
            ":group_id" => $group_id,
            ":member_id" => $member_id,
        ]);

        // deduct to total pot
        $deduct = $conn->prepare("UPDATE group_rotation SET total_pot = :new_pot WHERE rotation_status = 'Ongoing' AND group_id = :group_id");
        $deduct->execute([
            ":new_pot" => $group_pot - $amount,
            ":group_id" => $group_id
        ]);


        //activity log
        $log = $conn->prepare("INSERT INTO activity_logs(title, description, date_time_created, member_id) VALUES(:title, :description, :date_time, :member_id)");
        $log->execute([
            ":title" => "Transaction: Withdrawal",
            ":description" => "You Withdraw: ₱" . $amount,
            ":date_time" => $date_time,
            ":member_id" => $member_id,
        ]);

        echo "complete";
    } else {
        echo "dalok dalok";
    }

}

?>