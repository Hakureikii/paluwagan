<?php
session_start();
if (!isset($_SESSION["member_name"], $_SESSION["member_id"])) {
    header("Location: ../../index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>

<body>


    <h1>Welcome <?php echo $_SESSION['member_name'] ?></h1>

    <a href="member_dashboard.php"> Home </a>
    <a href="form_group.php"> Form Group </a>
    <a href=""> Join Group </a>
    <a href=""> View My Group </a>
    <a href=""> Notifications </a>
    <a href="../../auth/php/logout.php"> Logout </a>

</body>

</html>


<script src="../../jquery.js"></script>


<script>
    //prevents page access while using back button
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>