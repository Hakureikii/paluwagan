<?php
session_start();
include_once("../../connection.php");
$email = $_POST["email"];
$password = $_POST["password"];


// for retrieveing the password
$stmt = $conn->prepare("SELECT * FROM participant WHERE email = :email");
$stmt->execute([
    ":email" => $email
]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);


if (password_verify($password, $account["password"])) {
    $_SESSION["participant_name"] = $account["first_name"];
    $_SESSION["participant_id"] = $account["participant_id"];
    echo "login";
} else {
    echo "err";
};

?>