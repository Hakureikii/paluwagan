<?php
include_once "../../connection.php";

$stmt = $conn->prepare("DELETE FROM groups
WHERE group_id IN (
  SELECT g.group_id
  FROM groups AS g
  LEFT JOIN member AS m ON g.group_id = m.group_id
  WHERE g.date_created < (NOW() - INTERVAL 7 DAY)
  GROUP BY g.group_id
  HAVING COUNT(m.member_id) = 0)
  ");
$stmt->execute();

echo "delete";


?>