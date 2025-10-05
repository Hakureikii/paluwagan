<?php
include_once("../../connection.php");

$group_name = $_POST["group_name"];
$capacity = $_POST["capacity"];

if (
   !empty($group_name) &&
   !empty($capacity)
) {
$stmt = $conn->prepare("INSERT INTO groups(group_name, group_capacity) VALUES(:group_name, :capacity)");
$stmt->execute([
   ":group_name"=> $group_name,
   ":capacity"=> $capacity,
]);

echo "success";
} else {
   echo "err";
}

?>