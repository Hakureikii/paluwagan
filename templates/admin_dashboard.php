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
<title>Admin Dashboard</title>
<link rel="stylesheet" href="../styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../styles/css/admin-panel-style.css">

</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button id="sidebarClose" class="sidebar-close">&times;</button>
    <h2>Admin Panel</h2>
    <a href="#"><i class="fa-solid fa-users"></i> Manage Users</a>
    <a href="#"><i class="fa-solid fa-diagram-project"></i> View Groups</a>
    <a href="#"><i class="fa-solid fa-credit-card"></i> View Transactions</a>
    <a href="../auth/php/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>

<!-- Overlay for mobile -->
<div id="overlay"></div>

<!-- Main Content -->
<div class="main-content">
    <nav class="navbar navbar-expand-lg mb-4">
        <div class="container-fluid">
            <button class="sidebar-toggle" id="sidebarToggle">
                <span class="bar top"></span>
                <span class="bar middle"></span>
                <span class="bar bottom"></span>
            </button>

            <span class="navbar-text ms-auto">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION["admin_user"]); ?></strong>
            </span>

            <button class="theme-toggle" id="themeToggle" title="Toggle Light/Dark Mode">
                <i class="fa-solid fa-moon"></i>
            </button>
        </div>
    </nav>

    <div class="container">
        <h1 class="welcome mb-4">Dashboard Overview</h1>
        <div class="row">
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-users fa-3x text-primary"></i>
                        <h5 class="card-title mt-3">Manage Users</h5>
                        <p class="card-text text-muted">View, edit, or delete user accounts.</p>
                        <button class="btn btn-primary icon-btn" data-bs-toggle="tooltip" title="Go to Manage Users">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-diagram-project fa-3x text-success"></i>
                        <h5 class="card-title mt-3">View Groups</h5>
                        <p class="card-text text-muted">Check and manage user groups.</p>
                        <button class="btn btn-success icon-btn" data-bs-toggle="tooltip" title="Go to View Groups">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-credit-card fa-3x text-warning"></i>
                        <h5 class="card-title mt-3">Transactions</h5>
                        <p class="card-text text-muted">Review recent transactions.</p>
                        <button class="btn btn-warning text-white icon-btn" data-bs-toggle="tooltip" title="Go to Transactions">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../styles/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById("sidebar");
const sidebarToggle = document.getElementById("sidebarToggle");
const sidebarClose = document.getElementById("sidebarClose");
const overlay = document.getElementById("overlay");
const themeToggle = document.getElementById("themeToggle");
const icon = themeToggle.querySelector("i");
const body = document.body;

sidebarToggle.addEventListener("click", () => {
    sidebar.classList.add("active");
    overlay.classList.add("active");
    sidebarToggle.classList.add("active");
});

sidebarClose.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    sidebarToggle.classList.remove("active");
});

overlay.addEventListener("click", () => {
    sidebar.classList.remove("active");
    overlay.classList.remove("active");
    sidebarToggle.classList.remove("active");
});

// Initialize tooltips
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));

// Theme toggle
const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
const savedTheme = localStorage.getItem("theme");
if(savedTheme === "dark" || (!savedTheme && systemDark)){
    body.classList.add("dark-mode");
    icon.classList.replace("fa-moon","fa-sun");
}

themeToggle.addEventListener("click", ()=>{
    body.classList.toggle("dark-mode");
    const isDark = body.classList.contains("dark-mode");
    localStorage.setItem("theme", isDark ? "dark" : "light");
    icon.classList.toggle("fa-moon");
    icon.classList.toggle("fa-sun");
});

// Prevent back button cache
window.addEventListener("pageshow", event => { if(event.persisted) window.location.reload(); });
</script>
</body>
</html>
