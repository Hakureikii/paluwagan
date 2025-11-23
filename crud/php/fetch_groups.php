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
$groups = $conn->prepare("SELECT
    g.group_id,
    g.group_name,
    g.group_capacity,
    COALESCE(t.total_contributions, 0) AS total_contributions,
    COALESCE(m.total_members, 0) AS total_members
FROM groups AS g
LEFT JOIN (
    SELECT 
        group_id,
        SUM(
            CASE 
                WHEN transaction_type = 'Deposit' THEN amount
                WHEN transaction_type = 'Withdrawal' THEN -amount
                ELSE 0
            END
        ) AS total_contributions
    FROM transactions
    GROUP BY group_id
) AS t ON g.group_id = t.group_id
LEFT JOIN (
    SELECT group_id, COUNT(*) AS total_members
    FROM member
    GROUP BY group_id
) AS m ON g.group_id = m.group_id
ORDER BY total_contributions DESC;


");

$groups->execute();
$display_groups = $groups->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($display_groups);
?>