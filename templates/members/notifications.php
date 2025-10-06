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
   <title>Notifications</title>
   <link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
</head>
<body>
   <h1>Welcome <?php echo $_SESSION['member_name'] ?></h1>
   <h1> Group Invitations </h1>
   
   <a href="member_dashboard.php"> Home </a>
   <a href="form_group.php"> Form Group </a>
   <a href=""> Join Group </a>
   <a href="view_group.php"> View My Group </a>
   <a href="notifications.php"> Notifications </a>
   <a href="../../auth/php/logout.php"> Logout </a>

   <table>
      <tr>
         <th>No.</th>
         <th>Group Name</th>
         <th>Sender</th>
         <th>Reciever</th>
         <th>Action</th>
      </tr>
      <tbody id="group_invitations"></tbody>
   </table>

</body>
</html>

<script src="../../jquery.js"></script>
<script src="../../crud/js/fetch.js"></script>
<script src="../../crud/js/delete.js"></script>
<script src="../../crud/js/update.js"></script>
<script>

//show group invitations
display_group_invitations();

//prevents page access while using back button
   window.addEventListener("pageshow", function (event) {
      if (event.persisted) {
         window.location.reload();
      }
   });
</script>
