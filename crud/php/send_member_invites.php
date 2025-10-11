<?php
session_start();
include_once("../../connection.php");

$members = $_POST["members"];
$sender_id = $_SESSION["member_id"];

//retrieve sender's group id
$fetch = $conn ->prepare("SELECT * FROM member WHERE member_id = :sender_id");
$fetch->execute([
   ":sender_id"=> $sender_id
]);
$results = $fetch->fetch(PDO::FETCH_ASSOC);

// send invitations to members
foreach ($members as $member_id) {
   $stmt = $conn->prepare("INSERT INTO group_invitations(sender_id, reciever_id, group_id) VALUES(:sender_id, :reciever_id, :group_id)");
   $stmt->execute([
      ":sender_id"=> $sender_id,
      ":reciever_id"=> $member_id,
      ":group_id"=> $results['group_id']
   ]);

}
echo "invitations sent!";


?>