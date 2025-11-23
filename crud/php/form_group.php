<?php
session_start();
include_once("../../connection.php");

$creator_id = $_SESSION["member_id"];
$group_name = $_POST["group_name"];
$capacity = $_POST["capacity"];
$date = date("Y/m/d");

//fetch member data to identify if the member have existing groups
$fetch = $conn->prepare("SELECT * FROM member WHERE member_id = :creator_id");
$fetch->execute([
   ":creator_id" => $creator_id
]);
$member_group_status = $fetch->fetch(PDO::FETCH_ASSOC);

if ($member_group_status["group_id"] == null) {
   if (
      !empty($group_name) &&
      !empty($capacity) &&
      !empty($creator_id)
   ) {

      //insert the group to DB
      $stmt = $conn->prepare("INSERT INTO groups(group_name, group_capacity, creator_id, date_created) VALUES(:group_name, :capacity, :creator_id, :date_created)");
      $stmt->execute([
         ":group_name" => $group_name,
         ":capacity" => $capacity,
         ":creator_id" => $creator_id,
         ":date_created" => $date,
      ]);

      //retrieve recent group id inserted from DB
      $group_id = $conn->lastInsertId();

      //update null value on member column
      $update = $conn->prepare("UPDATE member SET group_id = :group_id WHERE member_id = :member_id");
      $update->execute([
         ":group_id" => $group_id,
         ":member_id" => $creator_id
      ]);

      $_SESSION["member_group"] = $group_id;

      echo "success";

   } else {
      echo "err";
   }
} else {
   echo "You are currently on a group!";
}

?>