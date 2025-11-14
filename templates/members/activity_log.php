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
    <title>Activity Log</title>
    <link rel="stylesheet" href="../../styles/css/bootstrap.min.css" />
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
    <aside class="sidebar" id="sidebar">
        <i class="fa-solid fa-xmark sidebar-close" id="sidebarClose"></i>

        <div>
            <h4><i class="fa-solid fa-wallet me-2"></i>Paluwagan</h4>

            <nav class="nav-links">
                <a href="member_dashboard.php"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
                <a href="form_group.php"><i class="fa-solid fa-pen-to-square"></i>Form Group</a>
                <a href="join_group.php"><i class="fa-solid fa-users"></i>Join Group</a>
                <a href="view_group.php"><i class="fa-solid fa-eye"></i>My Groups</a>
                <a href="notifications.php"><i class="fa-solid fa-bell"></i>Notifications</a>
                <a href="activity_log.php" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Activity Log
                </a>
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

    <div class="main-content">
        <table>
            <tr>
                <th> Activity </th>
                <th> Description </th>
                <th> Date </th>
            </tr>
            <tbody id="activity-log-table"></tbody>
        </table>
    </div>
</body>

</html>

<script src="../../jquery.js"></script>
<script src="../../crud/js/fetch.js"></script>
<script>

    // Fetch activity logs
    fetch_activity_logs();

    // Sidebar toggle
    const sidebar = document.getElementById("sidebar");
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebarClose = document.getElementById("sidebarClose");
    const overlay = document.getElementById("overlay");

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

    // Theme toggle
    const themeToggle = document.getElementById("themeToggle");
    const icon = themeToggle.querySelector("i");

    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
        icon.classList.replace("fa-sun", "fa-moon");
    }

    themeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        localStorage.setItem("theme",
            document.body.classList.contains("dark-mode") ? "dark" : "light"
        );
    });

    // Balance visibility toggle
    const balance = document.getElementById("navBalance");
    const eye = document.getElementById("toggleBalance");
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


    window.addEventListener("pageshow", function (event) {
        if (event.persisted) window.location.reload();
    });
</script>