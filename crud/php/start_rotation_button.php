<?php
session_start();
include_once("../../connection.php");
$member_id = $_SESSION["member_id"];
$group_id = $_SESSION["member_group"];

// handler if current user is the leader
$fetch = $conn->prepare("SELECT creator_id FROM groups WHERE creator_id =:creator_id");
$fetch->execute([
    ":creator_id" => $member_id,
]);
$fetch = $fetch->fetch(PDO::FETCH_COLUMN);


// retrieve rotation status
$rotation = $conn ->prepare("SELECT rotation_status FROM group_rotation WHERE rotation_status = 'Ongoing' AND group_id = :group_id");
$rotation->execute([
    ":group_id"=> $group_id,
]);
$status = $rotation->fetch(PDO::FETCH_COLUMN);

if ($fetch === false) {
    echo "disable";
} else {
    if ($status === false) {
        echo "enable";
    } else {
        if ($status === "Ongoing") {
            echo "disable";
        } else {
            echo "enable";
        }
    }
}

?>