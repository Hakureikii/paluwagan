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
</head>

<body>
   
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