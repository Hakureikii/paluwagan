<?php
session_start();
include_once("../../connection.php");

$members = $_POST["members"];
$sender_id = $_SESSION["member_id"];
$date_time = date("Y-m-d H:i:s");

//retrieve sender's group id
$fetch = $conn->prepare("SELECT * FROM member WHERE member_id = :sender_id");
$fetch->execute([
   ":sender_id" => $sender_id
]);
$results = $fetch->fetch(PDO::FETCH_ASSOC);

// send invitations to members
foreach ($members as $member_id) {
   $stmt = $conn->prepare("INSERT INTO group_invitations(sender_id, reciever_id, group_id) VALUES(:sender_id, :reciever_id, :group_id)");
   $stmt->execute([
      ":sender_id" => $sender_id,
      ":reciever_id" => $member_id,
      ":group_id" => $results['group_id']
   ]);

}


foreach ($members as $member_id) {
   $notify = $conn->prepare("INSERT INTO notifications(member_id, description, is_read, date_time_created) VALUES(:user_id, :description, :is_read, :date_time)");
   $notify->execute([
      ":user_id" => $member_id,
      ":description" => "You are invited to join a group!",
      ":is_read" => 0,
      ":date_time" => $date_time
   ]);
}
echo "invitations sent!";

?>