<?php
session_start();
if (!isset($_SESSION["admin_user"], $_SESSION["admin_id"])) {
    header("Location: ../index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/css/bootstrap.min.css">
</head>
<body>
    <h1>WELCOME <?php echo ($_SESSION["admin_user"])?></h1>
    <a href=""> Manage Users </a>
    <a href=""> View Groups </a>
    <a href=""> View Transactions </a>
    <a href="../auth/php/logout.php"> logout </a>
</body>
</html>

<script>
    //prevents page access while using back button
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>