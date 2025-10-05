<?php
include_once("../../connection.php");
$last_name = $_POST["last_name"];
$first_name = $_POST["first_name"];
$middle_name = $_POST["middle_name"];
$brgy = $_POST["brgy"];
$municipality = $_POST["municipality"];
$province = $_POST["province"];
$contact_number = $_POST["contact_number"];
$email = $_POST["email"];
$password = $_POST["password"];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$credentials = $_POST["credentials"];


if (
    !empty($last_name) &&
    !empty($first_name) &&
    !empty($middle_name) &&
    !empty($brgy) &&
    !empty($municipality) &&
    !empty($province) &&
    !empty($contact_number) &&
    !empty($email) &&
    !empty($password) &&
    !empty($credentials)

) {
    $stmt = $conn->prepare("INSERT INTO member(last_name, first_name, middle_name, barangay, municipality, province, contact_number, email, password, credentials) VALUES(:last_name, :first_name, :middle_name, :brgy, :municipality, :province, :contact_number, :email, :hashed_password, :credentials)");

    $stmt->execute([
        ":last_name" => $last_name,
        ":first_name" => $first_name,
        ":middle_name" => $middle_name,
        ":brgy" => $brgy,
        ":municipality" => $municipality,
        ":province" => $province,
        ":contact_number" => $contact_number,
        ":email" => $email,
        ":hashed_password" => $hashed_password,
        ":credentials" => $credentials,
    ]);

    echo "ok";
} else {
    echo "err";
}
;

?>