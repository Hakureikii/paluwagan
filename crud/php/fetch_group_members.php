<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];

//retrieve group of current member
$stmt = $conn->prepare("SELECT * FROM member WHERE member_id = :member_id");
$stmt->execute([
   ":member_id"=> $member_id
]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$display = $conn ->prepare("SELECT CONCAT(m.first_name, ' ', m.middle_name, ' ', m.last_name) as name 
FROM member as m WHERE group_id = :group_id");
$display->execute([
   ":group_id"=> $result["group_id"],
]);
$group_members = $display->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($group_members);

?>