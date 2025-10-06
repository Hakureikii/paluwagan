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
   <title> View Group </title>
   <link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
</head>

<body>
   <h1>Welcome <?php echo $_SESSION['member_name'] ?></h1>
   <a href="member_dashboard.php"> Home </a>
   <a href="form_group.php"> Form Group </a>
   <a href=""> Join Group </a>
   <a href="view_group.php"> View My Group </a>
   <a href="notifications.php"> Notifications </a>
   <a href="../../auth/php/logout.php"> Logout </a>

   <h1 id="group_name"></h1>
   <!-- Button for Modal -->
   <button type="button" id="invite_members"> Invite Members </button>

   <!-- Modal -->
   <div class="form_invite_members">
      <form id="form-invite-members">
         <input type="text" placeholder="Search Members" id="search_members">
         <div id="search_results"></div>
         <div id="selected_members"> Invite members: </div>

         <button type="button" id="send_invites"> Send Invites </button>
         <button type="button" id="close_modal"> Close </button>
      </form>
   </div>

   <button type="button" id="leave_group"> Leave Group </button>

   <div class="pending_invites_table">
      <h1>PENDING INVITES</h1>
      <table>
         <tr>
            <th> No. </th>
            <th>Group Name</th>
            <th>Sender</th>
            <th>Reciever</th>
            <th>Status</th>
         </tr>
         <tbody id="pending_invites_table"></tbody>
      </table>
   </div>

   <div class="group_members_table">
      <h1>Group Members</h1>
      <table>
         <tr>
            <th> No. </th>
            <th> Name </th>
         </tr>
         <tbody id="group_members_table"></tbody>
      </table>
   </div>

</body>

</html>

<script src="../../jquery.js"></script>
<script src="../../crud/js/create.js"></script>
<script src="../../crud/js/fetch.js"></script>

<script>
   $(".form_invite_members").hide();

   //array for multiple member invites
   let selected_members = []

   //search suggestions
   $(document).on('keyup', '#search_members', function () {
      let search = $("#search_members").val().trim();

      if (search.length > 0) {
         $.post("../../crud/php/search_members.php",
            {
               search: search
            },
            function (response) {
               let results = JSON.parse(response);
               let result = '';

               for (let i = 0; i < results.length; i++) {
                  result +=
                     `<div class="member_results" data-id="${results[i].member_id}">${results[i].full_name}<div>`;
               }
               $("#search_results").html(result)
            })


      } else {
         $("#search_results").html("");
      }
   })

   //select members to invite
   $(document).on('click', '.member_results', function () {
      let member_id = $(this).data("id");
      let member_name = $(this).text();

      if (!selected_members.some(m => m.member_id === member_id)) {
         selected_members.push({ member_id, member_name });
         $("#selected_members").append(`
            <div class="selected-member">
                ${member_name}
                <button class="remove" data-id="${member_id}">x</button>
            </div>
        `);
        $("#search_members").val("");
      }

   })


   //remove members on invite list
   $(document).on('click', '.remove', function () {
      let member_id = $(this).data("id");
      selected_members = selected_members.filter(m => m.member_id !== member_id);
      $(this).parent().remove();
   });

   //send invites 
   $(document).on('click', '#send_invites', function () {
      if (selected_members.length > 0) {
         send_member_invites(selected_members.map(m => m.member_id));
         $("#search_results").html("");
         $("#selected_members").html("");
      } else {
         alert("Bai wala man members");
      }

   });

   //leave group function
   $(document).on('click', '#leave_group', function () {

      let member_id = <?php echo $_SESSION['member_id'] ?>

      if (!confirm("Do you wish to leave this group?")) {
         return;
      } else {
         $.post("../../crud/php/leave_group.php",
            {
               member_id: member_id
            },
            function (response) {
               if (response === "leave") {
                  window.location.href = "member_dashboard.php";
               } else {
                  alert("Wala kaw group bai")
               }
            })
      }
   })

   //display group members
   display_group_members();

   //display group name
   display_group_name();

   //display pending invites
   display_pending_invites();

   //show Modal
   $(document).on('click', '#invite_members', function () {
      $(".form_invite_members").fadeIn(200);
   })

   //close Modal
   $(document).on('click', '#close_modal', function () {
      $(".form_invite_members").fadeOut(200);
   })

   //prevents page access while using back button
   window.addEventListener("pageshow", function (event) {
      if (event.persisted) {
         window.location.reload();
      }
   });
</script>