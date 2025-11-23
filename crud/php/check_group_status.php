<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];

$check = $conn -> prepare("SELECT group_id FROM member WHERE member_id = :member_id");
$check -> execute([
    ":member_id" => $member_id
]);
$status = $check->fetch(PDO::FETCH_COLUMN);
if ($status === null) {
    echo "false";
} else {
    echo "true";
}
?>