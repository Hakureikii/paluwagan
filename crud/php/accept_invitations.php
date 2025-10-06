<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];
$group_id = $_POST["group_id"];

//update member group null -> group_id
$stmt = $conn->prepare("UPDATE member SET group_id = :group_id WHERE member_id = :member_id");
$stmt->execute([
   ":group_id"=> $group_id,
   ":member_id"=> $member_id,
]);

echo "invite accepted";

//remove pending invite after accepting
$delete = $conn ->prepare("DELETE FROM group_invitations WHERE reciever_id = :reciever_id AND group_id = :group_id");
$delete->execute([
   ":reciever_id"=> $member_id,
   ":group_id"=> $group_id
]);

?>