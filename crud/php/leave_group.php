<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];


//identify if current member is on a group
$fetch = $conn->prepare("SELECT * FROM member WHERE member_id = :member_id");
$fetch->execute([
   ":member_id" => $member_id
]);
$member_group_status = $fetch->fetch(PDO::FETCH_ASSOC);

//prevent leaving without a group
if ($member_group_status['group_id'] === null) {
   echo "no group!";
} else {
   $leave = $conn->prepare("UPDATE member SET group_id = null WHERE member_id = :member_id");
   $leave->execute([
      ":member_id" => $member_id
   ]);

   echo "leave";
}


?>