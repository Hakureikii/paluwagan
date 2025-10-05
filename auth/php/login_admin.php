<?php
session_start();
include_once("../../connection.php");
$username = $_POST["username"];
$password = $_POST["password"];


// for retrieveing the password
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username");
$stmt->execute([
    ":username" => $username
]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);


if (password_verify($password, $account["password_hash"])) {
    $_SESSION["admin_id"] = $account["admin_id"];
    $_SESSION["admin_user"] = $account["username"];
    echo "login";
} else {
    echo "err";
};

?>