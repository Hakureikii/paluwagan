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

//display group name
if ($result['group_id'] === null) {
   echo 'no group';
} else {
   $fetch = $conn->prepare('SELECT * FROM groups WHERE group_id = :group_id');
   $fetch->execute([
      'group_id'=> $result['group_id']
   ]);
   $group_name = $fetch->fetch(PDO::FETCH_ASSOC);
   echo json_encode($group_name['group_name']);
}
?>