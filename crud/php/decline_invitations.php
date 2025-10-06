<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];
$group_id = $_POST["group_id"];

//delete invitation after declining
$delete = $conn ->prepare("DELETE FROM group_invitations WHERE reciever_id = :reciever_id AND group_id = :group_id");
$delete->execute([
   ":reciever_id"=> $member_id,
   ":group_id"=> $group_id
]);

echo "invitation declined";

?>