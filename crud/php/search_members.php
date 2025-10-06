<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];
$search = $_POST["search"];
$stmt = $conn->prepare("SELECT *, CONCAT(m.first_name, ' ',m.middle_name, ' ', m.last_name) as full_name 
FROM member as m WHERE member_id != :member_id AND CONCAT(m.first_name, ' ',m.middle_name, ' ', m.last_name) LIKE :search LIMIT 5");
$stmt->execute([
   ":member_id"=> $member_id,
   ":search"=> "%$search%"
]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
?>