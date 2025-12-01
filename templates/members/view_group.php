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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Group</title>
    <link rel="stylesheet" href="../../styles/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <style>
        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
            background: transparent !important;
            color: #6c757d !important;
            border-color: #6c757d !important;
        }

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

        /* Sidebar */
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
            /* hide by default */
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

        .theme-toggle:hover {
            transform: rotate(15deg);
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
            transition: margin-left .3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
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
            color: var(--text);
            cursor: pointer;
        }

        .balance-container {
            display: flex;
            align-items: center;
            gap: 2px;
        }

        .balance-container .action-btn {
            margin-right: 8px;
        }

        .balance-badge {
            background: var(--card);
            padding: 6px 14px;
            border-radius: 25px;
            box-shadow: 0 2px 6px var(--shadow);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .balance-eye {
            cursor: pointer;
            font-size: 1rem;
            color: var(--text);
        }

        .dashboard-box,
        .balance-box {
            background: var(--card);
            box-shadow: 0 6px 16px var(--shadow);
            border-radius: 12px;
            padding: 25px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-box {
            background: var(--bg);
            border-radius: 8px;
            box-shadow: 0 4px 10px var(--shadow);
            padding: 20px;
            text-align: center;
        }

        .stat-box h3 {
            margin: 0;
            font-size: 1.6rem;
        }

        .stat-box p {
            font-size: .9rem;
            opacity: .8;
            margin: 0;
        }

        .analytics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }

        .chart-box {
            background: var(--bg);
            border-radius: 8px;
            box-shadow: 0 4px 10px var(--shadow);
            padding: 20px;
        }

        .chart-box h6 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        .transaction-history {
            max-height: 230px;
            overflow-y: auto;
            margin-top: 8px;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: .85rem;
        }

        .credit {
            color: green;
        }

        .debit {
            color: red;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 150;
        }

        .form_invite_members {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: var(--card);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px var(--shadow);
            z-index: 300;
            width: 300px;
        }

        .selected-member {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 5px;
        }

        .selected-member .remove {
            background: red;
            color: #fff;
            border: none;
            padding: 0 6px;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btn {
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: .9rem;
            cursor: pointer;
            background: transparent;
            transition: .3s;
            font-weight: 500;
            text-align: center;
        }

        .deposit-btn {
            color: #198754;
            border-color: #198754;
        }

        .deposit-btn:hover {
            background: #198754;
            color: #fff;
        }

        .withdraw-btn {
            color: #dc3545;
            border-color: #dc3545;
        }

        .withdraw-btn:hover {
            background: #dc3545;
            color: #fff;
        }

        /* Responsive: Tablet ≤991px */
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
                width: 100%;
            }

            .overlay.active {
                display: block;
            }

            .dashboard-box {
                padding: 18px;
            }

            .stat-box h3 {
                font-size: 1.3rem;
            }

            .chart-box {
                padding: 15px;
            }
        }

        /* Responsive: Mobile ≤576px - table cards */
        @media (max-width: 576px) {
            .sidebar {
                width: 220px;
                padding: 15px;
            }

            .top-bar {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                text-align: left;
                gap: 8px;
            }

            .welcome {
                font-size: .85rem;
            }

            .balance-container {
                flex-wrap: nowrap;
                gap: 6px;
            }

            .top-bar .action-btn {
                display: none;
            }

            .nav-links .action-btn {
                display: block;
                width: 100%;
                margin-top: 10px;
                font-size: .85rem;
                padding: 8px 12px;
            }

            .nav-links .action-btn:first-of-type {
                margin-top: 15px;
            }

            .balance-badge {
                font-size: .8rem;
                padding: 5px 12px;
            }

            .dashboard-box {
                padding: 12px;
            }

            .stats {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .stat-box {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: left;
                padding: 10px 12px;
            }

            .stat-box h3 {
                font-size: 1.2rem;
            }

            .stat-box p {
                font-size: .8rem;
            }

            .analytics {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .chart-box {
                padding: 10px;
            }

            .balance-box {
                padding: 10px;
            }

            /* Mobile table to cards */
            table.table-sm thead {
                display: none;
            }

            table.table-sm tbody tr {
                display: block;
                margin-bottom: 12px;
                background: var(--card);
                padding: 12px;
                border-radius: 8px;
                box-shadow: 0 2px 6px var(--shadow);
            }

            table.table-sm tbody tr td {
                display: flex;
                justify-content: space-between;
                padding: 6px 0;
                border: none;
                font-size: .85rem;
            }

            table.table-sm tbody tr td::before {
                content: attr(data-label);
                font-weight: 600;
                text-transform: capitalize;
            }
        }

        body.dark-mode table {
            background: #2c3034;
            color: var(--text);
        }

        body.dark-mode table th {
            color: var(--text);
            background: #3a3f44;
            border-color: rgba(255, 255, 255, 0.1);
        }

        body.dark-mode table td {
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.1);
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
                <a href="form_group.php"><i class="fa-solid fa-pen-to-square"></i>Form Group</a>
                <a href="join_group.php"><i class="fa-solid fa-users"></i>Join Group</a>
                <a href="view_group.php" class="active"><i class="fa-solid fa-eye"></i>My Groups</a>
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
            <div>
                <a href="../../auth/php/logout.php" class="text-decoration-none text-danger">
                    <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                </a>
            </div>
        </div>
    </aside>

    <div class="overlay" id="overlay"></div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="sidebar-toggler" id="sidebarToggle">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="welcome">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION['member_name']); ?></strong>
            </div>
            <div class="balance-container">
                <button class="action-btn deposit-btn" data-bs-toggle="modal"
                    data-bs-target="#deposit_money">Deposit</button>
                <button class="action-btn withdraw-btn">Withdraw</button>
                <div class="balance-badge">
                    <i class="fa-solid fa-wallet"></i>
                    <span id="navBalance">₱12,450.00</span>
                    <i class="fa-solid fa-eye balance-eye" id="toggleBalance"></i>
                </div>
            </div>
        </div>

        <!-- Group Stats -->
        <div class="dashboard-box">
            <div class="stats">
                <div class="stat-box">
                    <h3 id="total_members"></h3>
                    <p>Group Members</p>
                </div>
                <div class="stat-box">
                    <h3 id="pending_invites_count"></h3>
                    <p>Pending Invites</p>
                </div>
            </div>
            <div class="analytics">
                <div class="chart-box">
                    <h6 id="group_name">
                        <i class="fa-solid fa-users me-2" id="group_name"></i>Group Name
                    </h6>
                    <button type="button" id="start_rotation" class="btn btn-success btn-sm mt-2 start-rotation-btn"><i
                            class="fa-solid fa-sync"></i>
                        Start Rotation </button>
                    <button type="button" id="invite_members" class="btn btn-primary btn-sm mt-2"><i
                            class="fa-solid fa-envelope-open-text"></i>
                        Invite Members</button>
                    <button type="button" id="leave_group" class="btn btn-danger btn-sm mt-2 leave-group-btn"><i
                            class="fa-solid fa-right-from-bracket"></i>
                        Leave Group</button>
                </div>
            </div>
        </div>

        <!-- Pending Invites Table -->
        <div class="balance-box">
            <h6><i class="fa-solid fa-clock-rotate-left me-2"></i>Pending Invites</h6>
            <div class="transaction-history">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Group Name</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="pending_invites_table"></tbody>
                </table>
            </div>
        </div>

        <!-- Group Members Table -->
        <div class="balance-box">
            <h6><i class="fa-solid fa-users me-2"></i>Group Members</h6>
            <div class="transaction-history">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody id="group_members_table"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Invite Modal -->
    <div class="form_invite_members">
        <form id="form-invite-members">
            <input type="text" placeholder="Search Members" id="search_members" class="form-control mb-2">
            <div id="search_results"></div>
            <div id="selected_members">Invite members:</div>
            <button type="button" id="send_invites" class="btn btn-success btn-sm mt-2">Send Invites</button>
            <button type="button" id="close_modal" class="btn btn-secondary btn-sm mt-2">Close</button>
        </form>
    </div>

    <!-- Deposit Modal -->
    <div class="modal fade" id="deposit_money" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-wallet me-2"></i>Deposit Funds
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-deposit-money">
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-semibold">Amount</label>
                            <input type="number" class="form-control form-control-lg" id="amount" placeholder="₱0.00"
                                required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-semibold">Deposit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Withdraw Modal -->
    <div class="modal fade" id="withdraw_money" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Withdraw Funds
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-withdraw-money">
                        <div class="mb-3">
                            <label for="withdraw_amount" class="form-label fw-semibold">Amount</label>
                            <input type="number" class="form-control form-control-lg" id="withdraw_amount"
                                placeholder="₱0.00" required>
                        </div>
                        <div class="mb-3">
                            <label for="wallet_number" class="form-label fw-semibold">GCash / Wallet Number</label>
                            <input type="text" class="form-control form-control-lg" id="wallet_number"
                                placeholder="09XXXXXXXXX" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 fw-semibold">Withdraw</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rotation Start Modal -->
    <div class="modal fade" id="rotationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Rotation Started</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>The rotation has been successfully initialized. All members now have their schedules!</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success" data-bs-dismiss="modal">Okay</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Rotation Start Modal Fail -->
    <div class="modal fade" id="rotationModalFail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">No Amount Deposited Yet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>Please have an initial deposit first!</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-dismiss="modal">Okay</button>
                </div>

            </div>
        </div>
    </div>


    <script src="../../jquery.js"></script>
    <script src="../../styles/js/bootstrap.bundle.min.js"></script>
    <script src="../../crud/js/create.js"></script>
    <script src="../../crud/js/fetch.js"></script>
    <script src="../../crud/js/update.js"></script>

    <script>
        $("#form-deposit-money").submit(function (e) {
            e.preventDefault();

            let amount = $("#amount").val().trim();
            deposit(amount);
        });

        $(document).on('click', '#start_rotation', function () {
            let status = "Ongoing";
            start_rotation(status);
        });

        const sidebar = document.getElementById("sidebar"),
            sidebarToggle = document.getElementById("sidebarToggle"),
            sidebarClose = document.getElementById("sidebarClose"),
            overlay = document.getElementById("overlay");

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        });

        sidebarClose.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });

        const themeToggle = document.getElementById("themeToggle"),
            icon = themeToggle.querySelector("i");

        if (localStorage.getItem("theme") === "dark") {
            document.body.classList.add("dark-mode");
            icon.classList.replace("fa-sun", "fa-moon");
        }

        themeToggle.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            const isDark = document.body.classList.contains("dark-mode");
            localStorage.setItem("theme", isDark ? "dark" : "light");
        });

        const balance = document.getElementById("navBalance"),
            eye = document.getElementById("toggleBalance");
        let visible = true;

        eye.addEventListener("click", () => {
            visible = !visible;
            if (visible) {
                balance.textContent = "₱12,450.00";
                eye.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                balance.textContent = "••••••••";
                eye.classList.replace("fa-eye", "fa-eye-slash");
            }
        });

        $(".form_invite_members").hide();
        let selected_members = [];

        $(document).on('keyup', '#search_members', function () {
            let search = $(this).val().trim();
            if (search.length > 0) {
                $.post("../../crud/php/search_members.php", { search: search }, function (response) {
                    let results = JSON.parse(response);
                    let html = '';
                    results.forEach(r => {
                        html += `<div class="member_results" data-id="${r.member_id}">${r.full_name}</div>`;
                    });
                    $("#search_results").html(html);
                });
            } else {
                $("#search_results").html("");
            }
        });

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
        });

        $(document).on('click', '.remove', function () {
            let member_id = $(this).data("id");
            selected_members = selected_members.filter(m => m.member_id !== member_id);
            $(this).parent().remove();
        });

        $(document).on('click', '#send_invites', function () {
            if (selected_members.length > 0) {
                send_member_invites(selected_members.map(m => m.member_id));
                $("#search_results").html("");
                $("#selected_members").html("");
            } else {
                alert("Select members first.");
            }
        });

        $(document).on('click', '#invite_members', function () {
            $(".form_invite_members").fadeIn(200);
        });

        $(document).on('click', '#close_modal', function () {
            $(".form_invite_members").fadeOut(200);
        });

        $(document).on('click', '#leave_group', function () {
            let member_id = <?php echo $_SESSION['member_id']; ?>;
            if (confirm("Do you want to leave this group?")) {
                $.post("../../crud/php/leave_group.php", { member_id: member_id }, function (response) {
                    if (response === "leave") {
                        window.location.href = "member_dashboard.php";
                    } else {
                        alert("You are not part of any group.");
                    }
                });
            }
        });

        // Load group data with data-labels for mobile
        function renderPendingInvites(data) {
            $("#pending_invites_table").html('');
            data.forEach((row, i) => {
                $("#pending_invites_table").append(`
                <tr>
                    <td data-label="No.">${i + 1}</td>
                    <td data-label="Group Name">${row.group_name}</td>
                    <td data-label="Sender">${row.sender_name}</td>
                    <td data-label="Receiver">${row.receiver_name}</td>
                    <td data-label="Status">${row.status}</td>
                </tr>
            `);
            });
        }

        function renderGroupMembers(data) {
            $("#group_members_table").html('');
            data.forEach((row, i) => {
                $("#group_members_table").append(`
                <tr>
                    <td data-label="No.">${i + 1}</td>
                    <td data-label="Name">${row.member_name}</td>
                </tr>
            `);
            });
        }


        //count members and pending invites
        // member_count();
        display_pending_invites();

        //display notification badge
        fetch_unread_notifications();

        // Call existing functions and pass render functions
        display_group_members(renderGroupMembers);
        display_group_name();
        display_pending_invites(renderPendingInvites);

        // check if member is in a group
        check_group_status();

        // notify end of rotation
        ongoing_rotation();

        // send payout notification
        notify_payout();

        enable_withdrawal();

        leave_group_button();

        // Prevent back navigation
        window.addEventListener("pageshow", function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        window.addEventListener("pageshow", function (event) {
            if (event.persisted) window.location.reload();
        });
    </script>

</body>

</html>