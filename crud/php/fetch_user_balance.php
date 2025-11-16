<!-- <?php 
session_start();
require("../../connection.php");

$member_id = $_SESSION["member_id"];

$stmt = $conn->prepare("SELECT current_balance FROM user_balance WHERE member_id = :member_id");
$stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);

$stmt->execute();

$user_balance = $stmt-> fetch(PDO::FETCH_ASSOC);

if (!$user_balance || $user_balance["current_balance"] === null){
    $current_balance = 0;
} else{
    $current_balance = $user_balance["current_balance"];
}


$formatted_balance = "₱" . number_format($current_balance, 2);


?> -->


<!-- IKAW PADAYON DAWG -->