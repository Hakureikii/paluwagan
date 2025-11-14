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
   <title>Form Group</title>

   <link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

   <style>
      :root {
         --bg: #f8f9fa;
         --text: #212529;
         --side: #fff;
         --card: #fff;
         --shadow: rgba(0, 0, 0, 0.1);
      }

      body.dark-mode {
         --bg: #181a1b;
         --text: #f8f9fa;
         --side: #212529;
         --card: #2c3034;
         --shadow: rgba(0, 0, 0, 0.5);
      }

      body {
         background: var(--bg);
         color: var(--text);
         font-family: "Segoe UI", sans-serif;
         transition: .3s;
         display: flex;
         min-height: 100vh;
         overflow-x: hidden;
         margin: 0;
      }

      .sidebar {
         width: 250px;
         background: var(--side);
         box-shadow: 2px 0 10px var(--shadow);
         display: flex;
         flex-direction: column;
         justify-content: space-between;
         position: fixed;
         top: 0;
         bottom: 0;
         left: 0;
         padding: 20px 15px;
         transition: left .3s ease;
         z-index: 200;
      }

      .sidebar h4 {
         font-weight: 700;
         margin-bottom: 20px;
         text-align: center;
      }

      .notifications-link {
         position: relative;
         display: inline-block;
      }

      .notif-badge {
         position: absolute;
         top: -5px;
         right: -10px;
         background: red;
         color: white;
         font-size: 10px;
         font-weight: bold;
         padding: 2px 6px;
         border-radius: 50%;
         display: none;
      }

      .nav-links {
         display: flex;
         flex-direction: column;
         gap: 6px;
      }

      .nav-links a {
         display: flex;
         align-items: center;
         gap: 10px;
         padding: 10px 12px;
         border-radius: 8px;
         text-decoration: none;
         color: var(--text);
         font-weight: 500;
         transition: .2s;
      }

      .nav-links a:hover,
      .nav-links a.active {
         background: rgba(13, 110, 253, 0.1);
         color: #0d6efd;
      }

      .nav-links .action-btn {
         display: none;
      }

      .sidebar-footer {
         border-top: 1px solid rgba(0, 0, 0, 0.1);
         padding-top: 10px;
         text-align: center;
         font-size: .9rem;
      }

      .theme-toggle {
         background: none;
         border: none;
         font-size: 1.3rem;
         cursor: pointer;
         color: var(--text);
         transition: .3s;
      }

      .sidebar-close {
         position: absolute;
         top: 10px;
         right: 15px;
         font-size: 1.3rem;
         cursor: pointer;
         display: none;
         color: var(--text);
      }

      .main-content {
         margin-left: 250px;
         flex: 1;
         padding: 30px;
         display: flex;
         flex-direction: column;
         gap: 20px;
         transition: margin .3s ease;
         width: 100%;
      }

      .top-bar {
         display: flex;
         justify-content: space-between;
         align-items: center;
         flex-wrap: wrap;
      }

      .welcome {
         margin-right: auto;
         font-weight: 500;
      }

      .sidebar-toggler {
         display: none;
         font-size: 1.5rem;
         border: none;
         background: none;
         cursor: pointer;
      }

      .card-box {
         background: var(--card);
         box-shadow: 0 6px 16px var(--shadow);
         border-radius: 12px;
         padding: 25px;
      }

      @media (max-width: 991px) {
         .sidebar {
            left: -250px;
         }

         .sidebar.active {
            left: 0;
         }

         .sidebar-close {
            display: block;
         }

         .sidebar-toggler {
            display: block;
         }

         .main-content {
            margin-left: 0;
         }
      }
   </style>
</head>

<body>

   <!-- SIDEBAR -->
   <aside class="sidebar" id="sidebar">
      <i class="fa-solid fa-xmark sidebar-close" id="sidebarClose"></i>

      <div>
         <h4><i class="fa-solid fa-wallet me-2"></i>Paluwagan</h4>

         <nav class="nav-links">
            <a href="member_dashboard.php"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
            <a href="form_group.php" class="active"><i class="fa-solid fa-pen-to-square"></i>Form Group</a>
            <a href="join_group.php"><i class="fa-solid fa-users"></i>Join Group</a>
            <a href="view_group.php"><i class="fa-solid fa-eye"></i>My Groups</a>

            <a href="notifications.php" class="notifications-link">
               <i class="fa-solid fa-bell"></i>Notifications
               <span class="notif-badge" id="notifBadge">0</span>
            </a>

            <a href="activity_log.php"><i class="fa-solid fa-clock-rotate-left"></i> Activity Log </a>

            <button class="action-btn deposit-btn">Deposit</button>
            <button class="action-btn withdraw-btn">Withdraw</button>
         </nav>
      </div>

      <div class="sidebar-footer">
         <div class="mb-2">
            <button class="theme-toggle" id="themeToggle">
               <i class="fa-solid fa-sun"></i>
            </button>
         </div>
         <a href="../../auth/php/logout.php" class="text-decoration-none text-danger">
            <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
         </a>
      </div>
   </aside>

   <div class="main-content">
      <div class="top-bar">
         <button class="sidebar-toggler" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
         </button>

         <div class="welcome">
            Welcome, <strong><?php echo htmlspecialchars($_SESSION['member_name']); ?></strong>
         </div>
      </div>

      <div class="card-box">
         <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Form Group</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addGroupModal">
               <i class="fa-solid fa-plus me-1"></i> Add Group
            </button>
         </div>

         <p class="text-muted">Create and manage your Paluwagan groups easily.</p>
      </div>
   </div>

   <!-- ADD GROUP MODAL -->
   <div class="modal fade" id="addGroupModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><i class="fa-solid fa-users-gear me-2"></i>Create New Group</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form-add-group">
               <div class="modal-body">

                  <div class="mb-3">
                     <label class="form-label">Group Name</label>
                     <input type="text" id="group_name" class="form-control" required>
                  </div>

                  <div class="mb-3">
                     <label class="form-label">Capacity</label>
                     <input type="number" id="group_capacity" class="form-control" required>
                  </div>

                  <div id="error-message" class="text-danger small"></div>
               </div>

               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                     data-bs-target="#terms_and_conditions">Continue</button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- TERMS & CONDITIONS MODAL -->
   <div class="modal fade" id="terms_and_conditions" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">

            <div class="modal-header">
               <h5 class="modal-title"><i class="fa-solid fa-file-contract me-2"></i>Terms & Conditions</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
               <p class="text-muted small">
                  <h6>1. Membership Commitment</h6>
                  -Once you join the group, you are not allowed to leave until the group officially ends or until the group leader approves your exit. <br><br>
                  -Leaving the group without notice, permission, or valid reason may result in restrictions from joining future groups or participation in related activities. <br><br>

                  <h6> 2. Mandatory Contribution </h6>
                  -All members are required to contribute according to the agreed schedule, amount, or tasks set by the group. <br><br>
                  -Failure to contribute on time may result in penalties, delays, or removal of certain privileges within the group. <br><br>
                  -Consistent non-compliance may lead to administrative action determined by the group leader or system administrator. <br><br>

                  <h6> 3. Accuracy of Information </h6>
                  -Members must provide true, accurate, and updated information when joining or participating in any group activity. <br><br>
                  -Any form of misrepresentation may result in immediate removal and possible reporting to the system administrator. <br><br>

                  <h6> 4. Respect and Proper Conduct </h6>
                  -Members are expected to maintain respectful communication with other members and avoid disruptive behavior.<br><br>
                  -Any form of harassment, discrimination, or abusive conduct may result in disciplinary action.<br><br>

                  <h6> 5. Confidentiality </h6>
                  -All group-related information (member details, contribution amounts, schedules, and internal discussions) must remain confidential and cannot be shared outside the group without permission.<br><br>

                  <h6>6. System Monitoring </h6>
                  -The system may record logs of your activities, contributions, and group interactions for transparency, auditing, and security purposes.<br><br>

                  <h6>7. Acceptance of Terms </h6>
                  -By clicking "Confirm", joining the group, or continuing participation, you acknowledge and accept all the terms and conditions stated above.<br><br>
                  -Your confirmation serves as a binding agreement between you and the group/system.<br><br>
               </p>
            </div>

            <div class="modal-footer">
               <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

               <button type="button" id="confirmCreateGroup" class="btn btn-primary">
                  Confirm & Create
               </button>
            </div>

         </div>
      </div>
   </div>

   <script src="../../jquery.js"></script>
   <script src="../../styles/js/bootstrap.bundle.min.js"></script>
   <script src="../../crud/js/create.js"></script>

   <script>
      // Sidebar toggle
      const sidebar = document.getElementById("sidebar");
      const sidebarToggle = document.getElementById("sidebarToggle");
      const sidebarClose = document.getElementById("sidebarClose");

      sidebarToggle.onclick = () => sidebar.classList.add("active");
      sidebarClose.onclick = () => sidebar.classList.remove("active");

      // Theme toggle
      const themeToggle = document.getElementById("themeToggle");
      const themeIcon = themeToggle.querySelector("i");

      if (localStorage.getItem("theme") === "dark") {
         document.body.classList.add("dark-mode");
         themeIcon.classList.replace("fa-sun", "fa-moon");
      }

      themeToggle.onclick = () => {
         document.body.classList.toggle("dark-mode");
         localStorage.setItem("theme",
            document.body.classList.contains("dark-mode") ? "dark" : "light"
         );

         themeIcon.classList.toggle("fa-sun");
         themeIcon.classList.toggle("fa-moon");
      };

      // FINAL SUBMIT BUTTON
      $("#confirmCreateGroup").click(function () {
         let group_name = $("#group_name").val().trim();
         let capacity = $("#group_capacity").val().trim();

         if (group_name === "" || capacity === "") {
            $("#error-message").text("Please complete all fields.");
            $("#terms_and_conditions").modal("hide");
            $("#addGroupModal").modal("show");
            return;
         }

         form_group(group_name, capacity);

         $("#terms_and_conditions").modal("hide");
         $("#addGroupModal").modal("hide");
      });

      // FETCH NOTIFICATIONS BADGE
      function fetch_unread_notifications() {
         $.get("../../crud/php/check_unread_notifications.php", function (count) {
            if (count > 0) {
               $("#notifBadge").text(count).show();
            } else {
               $("#notifBadge").hide();
            }
         });
      }

      fetch_unread_notifications();

      $(".notifications-link").click(function () {
         $.get("../../crud/php/mark_notifications_read.php", function () {
            $("#notifBadge").hide();
         });
      });
   </script>

</body>
</html>
