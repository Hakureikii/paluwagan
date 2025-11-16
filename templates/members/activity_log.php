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

<link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>
:root { --bg:#f8f9fa; --text:#212529; --side:#fff; --card:#fff; --shadow:rgba(0,0,0,0.1); }
body.dark-mode { --bg:#181a1b; --text:#f8f9fa; --side:#212529; --card:#2c3034; --shadow:rgba(0,0,0,0.5); }
body { background:var(--bg); color:var(--text); font-family:"Segoe UI",sans-serif; transition:.3s; display:flex; min-height:100vh; overflow-x:hidden; margin:0; }
.sidebar { width:250px; background:var(--side); box-shadow:2px 0 10px var(--shadow); display:flex; flex-direction:column; justify-content:space-between; position:fixed; top:0; bottom:0; left:0; padding:20px 15px; transition:left .3s ease; z-index:200; }
.sidebar h4 { font-weight:700; margin-bottom:20px; text-align:center; }
.nav-links { display:flex; flex-direction:column; gap:6px; }
.nav-links a { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:8px; text-decoration:none; color:var(--text); font-weight:500; transition:.2s; }
.nav-links a:hover, .nav-links a.active { background:rgba(13,110,253,0.1); color:#0d6efd; }
.nav-links .action-btn { display:none; }
.sidebar-footer { border-top:1px solid rgba(0,0,0,0.1); padding-top:10px; text-align:center; font-size:.9rem; }
.theme-toggle { background:none; border:none; font-size:1.3rem; cursor:pointer; color:var(--text); transition:.3s; }
.sidebar-close { position:absolute; top:10px; right:15px; font-size:1.3rem; cursor:pointer; display:none; color:var(--text); }

.main-content { margin-left:250px; flex:1; padding:30px; display:flex; flex-direction:column; gap:20px; width:100%; box-sizing:border-box; transition:.3s; }
.top-bar { display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; }
.welcome { margin-right:auto; font-weight:500; }
.sidebar-toggler { display:none; font-size:1.5rem; border:none; background:none; color:var(--text); cursor:pointer; }

.balance-container { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.action-btn { border-radius:8px; padding:8px 14px; font-size:.9rem; font-weight:500; cursor:pointer; text-align:center; border:2px solid transparent; background:transparent; transition:.3s; }
.deposit-btn { color:#198754; border-color:#198754; }
.deposit-btn:hover { background:#198754; color:#fff; }
.withdraw-btn { color:#dc3545; border-color:#dc3545; }
.withdraw-btn:hover { background:#dc3545; color:#fff; }

.balance-badge { background:var(--card); padding:6px 14px; border-radius:25px; box-shadow:0 2px 6px var(--shadow); font-weight:600; display:flex; align-items:center; gap:6px; }
.balance-eye { cursor:pointer; font-size:1rem; color:var(--text); }

.card-box, .log-container { background:var(--card); box-shadow:0 6px 16px var(--shadow); border-radius:12px; padding:25px; }
.log-container { max-height:450px; overflow-y:auto; }

body.dark-mode .card-box, body.dark-mode .log-container, body.dark-mode table, body.dark-mode table th, body.dark-mode table td { background:var(--card); color:var(--text); border-color:rgba(255,255,255,.1); }

@media(max-width:991px){ .sidebar{left:-250px;} .sidebar.active{left:0;} .sidebar-close{display:block;} .sidebar-toggler{display:block;} .main-content{margin-left:0;width:100%;} .overlay.active{display:block;} }
@media(max-width:576px){ .sidebar{width:220px;padding:15px;} .top-bar{flex-direction:row; justify-content:space-between; align-items:center; gap:8px; flex-wrap:nowrap;} .welcome{font-size:.85rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;} .balance-container{flex-direction:row; align-items:center; gap:8px;} .top-bar .action-btn{display:none;} .nav-links .action-btn{display:block; width:100%; margin-top:10px; font-size:.85rem; padding:8px 12px;} .nav-links .action-btn:first-of-type{margin-top:15px;} }
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
            <a href="activity_log.php" class="active"><i class="fa-solid fa-clock-rotate-left"></i> Activity Log </a>
            <button class="action-btn deposit-btn" data-bs-toggle="modal" data-bs-target="#deposit_money">Deposit</button>
            <button class="action-btn withdraw-btn">Withdraw</button>
        </nav>
    </div>
    <div class="sidebar-footer">
        <button class="theme-toggle" id="themeToggle"><i class="fa-solid fa-sun"></i></button>
        <div><a href="../../auth/php/logout.php" class="text-decoration-none text-danger"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a></div>
    </div>
</aside>

<div class="overlay" id="overlay"></div>

<div class="main-content">
    <div class="top-bar">
        <button class="sidebar-toggler" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
        <div class="welcome">Welcome, <strong><?php echo htmlspecialchars($_SESSION['member_name']); ?></strong></div>
        <div class="balance-container">
            <button class="action-btn deposit-btn" data-bs-toggle="modal" data-bs-target="#deposit_money">Deposit</button>
            <button class="action-btn withdraw-btn">Withdraw</button>
            <div class="balance-badge">
                <i class="fa-solid fa-wallet"></i>
                <span id="navBalance">₱12,450.00</span>
                <i class="fa-solid fa-eye balance-eye" id="toggleBalance"></i>
            </div>
        </div>
    </div>

    <div class="card-box">
        <h2 class="mb-3"><i class="fa-solid fa-clock-rotate-left me-2"></i>Activity Log</h2>
        <div class="log-container">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody id="activity-log-table"></tbody>
            </table>
        </div>
    </div>
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
            <input type="number" class="form-control form-control-lg" id="amount" placeholder="₱0.00" required>
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
            <input type="number" class="form-control form-control-lg" id="withdraw_amount" placeholder="₱0.00" required>
          </div>
          <div class="mb-3">
            <label for="wallet_number" class="form-label fw-semibold">GCash / Wallet Number</label>
            <input type="text" class="form-control form-control-lg" id="wallet_number" placeholder="09XXXXXXXXX" required>
          </div>
          <button type="submit" class="btn btn-danger w-100 fw-semibold">Withdraw</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="../../jquery.js"></script>
<script src="../../crud/js/create.js"></script>
<script src="../../crud/js/fetch.js"></script>
<script src="../../crud/js/delete.js"></script>
<script src="../../crud/js/update.js"></script>
<script src="../../styles/js/bootstrap.bundle.min.js"></script>

<script>
$("#form-deposit-money").submit(function(e){
    e.preventDefault();
    let amount = $("#amount").val().trim();

    // Call your deposit function
    deposit(amount);

    // Close the modal
    var depositModal = bootstrap.Modal.getInstance(document.getElementById('deposit_money'));
    depositModal.hide();

    // Optional: clear input field after deposit
    $("#amount").val('');
});


// Sidebar toggle
const sidebar=document.getElementById("sidebar"), sidebarToggle=document.getElementById("sidebarToggle"), sidebarClose=document.getElementById("sidebarClose"), overlay=document.getElementById("overlay");
sidebarToggle.addEventListener("click",()=>{sidebar.classList.toggle("active");overlay.classList.toggle("active");});
sidebarClose.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});
overlay.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});

// Theme toggle
const themeToggle=document.getElementById("themeToggle"), icon=themeToggle.querySelector("i");
if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark-mode"); icon.classList.replace("fa-sun","fa-moon");}
themeToggle.addEventListener("click",()=>{document.body.classList.toggle("dark-mode"); localStorage.setItem("theme", document.body.classList.contains("dark-mode")?"dark":"light");});

// Balance toggle
const balance=document.getElementById("navBalance"), eye=document.getElementById("toggleBalance");
let visible=true; eye.addEventListener("click",()=>{visible=!visible;if(visible){balance.textContent="₱12,450.00"; eye.classList.replace("fa-eye-slash","fa-eye");}else{balance.textContent="••••••••"; eye.classList.replace("fa-eye","fa-eye-slash");}});

// Fetch activity logs
fetch_activity_logs();

// Reload page on browser back
window.addEventListener("pageshow", function(event){if(event.persisted){window.location.reload();}});

// Show withdraw modal when withdraw button is clicked
$(".withdraw-btn").click(function(){
    var withdrawModal = new bootstrap.Modal(document.getElementById('withdraw_money'));
    withdrawModal.show();
});

// Handle form submission
$("#form-withdraw-money").submit(function(e){
    e.preventDefault();

    let amount = $("#withdraw_amount").val().trim();
    let wallet = $("#wallet_number").val().trim();

    // Call your withdraw function
    withdraw(amount, wallet); // <-- implement this function

    // Close the modal after withdraw
    var withdrawModal = bootstrap.Modal.getInstance(document.getElementById('withdraw_money'));
    withdrawModal.hide();

    // Clear inputs
    $("#withdraw_amount").val('');
    $("#wallet_number").val('');
});

</script>

</body>
</html>
