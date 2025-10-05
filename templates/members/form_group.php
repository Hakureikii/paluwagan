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
    <link rel="stylesheet" href="../../styles/bootstrap-5.3.8-dist/css/bootstrap.min.css">
   <title>Form Group</title>
</head>

<body>
   <h1>Welcome <?php echo $_SESSION['member_name']?></h1>
   <a href="member_dashboard.php"> Home </a>
   <a href="form_group.php"> Form Group </a>
   <a href=""> Join Group </a>
    <a href=""> View My Group </a>
    <a href=""> Notifications </a>
   <a href="../../auth/php/logout.php"> Logout </a>

   <form id="form-add-group">
      <input type="text" placeholder="Group Name" id="group_name">
      <input type="number" placeholder="Capacity" id="group_capacity">
      <button type="submit"> Save </button>
   </form>

</body>

</html>

<script src="../../jquery.js"></script>
<script src="../../crud/js/create.js"></script>
<script>

   //Form Group
   $("#form-add-group").submit(function(e) {
      e.preventDefault();

      let group_name = $("#group_name").val().trim();
      let capacity = $("#group_capacity").val().trim();

      form_group(group_name, capacity);
   })

   //prevents page access while using back button
   window.addEventListener("pageshow", function (event) {
      if (event.persisted) {
         window.location.reload();
      }
   });
</script>