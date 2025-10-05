<?php
session_start();
if (!isset($_SESSION["participant_name"], $_SESSION["participant_id"])) {
    header("Location: ../../index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
</head>
<body>


    <h1>Welcome <?php echo $_SESSION['participant_name']?></h1>

    <a href="form_group.php"> Form Group </a>
    <a href=""> Join Group </a>
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