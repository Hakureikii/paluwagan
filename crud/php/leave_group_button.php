<?php
session_start();
include_once "../../connection.php";
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];

$rotation = $conn ->prepare("SELECT rotation_status FROM group_rotation WHERE rotation_status = 'Ongoing' AND group_id = :group_id");
$rotation->execute([
    ":group_id"=> $group_id,
]);
$status = $rotation->fetch(PDO::FETCH_COLUMN);

if ($status === false) {
        echo "enable";
    } else {
        if ($status === "Ongoing") {
            echo "disable";
        } else {
            echo "enable";
        }
    }
?>