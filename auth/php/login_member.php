<?php
session_start();
include_once("../../connection.php");
$email = $_POST["email"];
$password = $_POST["password"];


// for retrieveing the password
$stmt = $conn->prepare("SELECT * FROM member WHERE email = :email");
$stmt->execute([
    ":email" => $email
]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);


if (password_verify($password, $account["password"])) {
    $_SESSION["member_name"] = $account["first_name"];
    $_SESSION["member_id"] = $account["member_id"];
    $_SESSION["member_group"] = $account["group_id"];
    echo "login";
} else {
    echo "err";
};

?>