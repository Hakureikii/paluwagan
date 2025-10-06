<?php
session_start();
include_once("../../connection.php");
$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("SELECT s.first_name as sender, r.first_name as reciever, g.group_name, g.group_id
FROM group_invitations as gi
INNER JOIN member as s ON gi.sender_id = s.member_id
INNER JOIN member as r ON gi.reciever_id = r.member_id
INNER JOIN groups as g ON gi.group_id = g.group_id
WHERE r.member_id = :reciever_id");

$stmt -> execute([
   ":reciever_id"=> $member_id
]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
?>