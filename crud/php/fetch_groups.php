<?php
session_start();
include_once("../../connection.php");

$member_id = $_SESSION["member_id"];


//retrieve group id of member
$stmt = $conn->prepare("SELECT * FROM member WHERE member_id = :member_id");
$stmt->execute([
    ":member_id" => $member_id,
]);
$member_group_id = $stmt->fetch(PDO::FETCH_ASSOC);


//exclude joined group of the member
$groups = $conn->prepare("SELECT *, COUNT(*) AS member_count
FROM groups as g
INNER JOIN member as m ON g.group_id = m.group_id
GROUP BY m.group_id");

$groups->execute();

// $groups->execute([
//     ":group_id" => $member_group_id["group_id"],
// ]);
$display_groups = $groups->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($display_groups);

?>