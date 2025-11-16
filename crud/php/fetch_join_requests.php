<?php
session_start();
include_once "../../connection.php";

$creator_id = $_SESSION["member_id"];

$stmt = $conn -> prepare("SELECT *, CONCAT(m.first_name, ' ', m.last_name) as sender 
FROM join_requests as j
INNER JOIN member as m ON m.member_id = j.member_id
WHERE creator_id =:creator_id");
$stmt -> execute([
    ":creator_id" => $creator_id
]);
$request = $stmt -> fetchAll(PDO::FETCH_ASSOC);

if ($request !== []) {
    echo json_encode($request);
} else {
    echo "none";
}


?>