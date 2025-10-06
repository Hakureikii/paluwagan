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
<title>Member Dashboard</title>
<link rel="stylesheet" href="../../styles/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root{--bg:#f8f9fa;--text:#212529;--side:#fff;--card:#fff;--shadow:rgba(0,0,0,0.1);}
body.dark-mode{--bg:#181a1b;--text:#f8f9fa;--side:#212529;--card:#2c3034;--shadow:rgba(0,0,0,0.5);}
body{background:var(--bg);color:var(--text);font-family:"Segoe UI",sans-serif;transition:.3s;display:flex;min-height:100vh;overflow-x:hidden;margin:0;}
.sidebar{width:250px;background:var(--side);box-shadow:2px 0 10px var(--shadow);display:flex;flex-direction:column;justify-content:space-between;position:fixed;top:0;bottom:0;left:0;padding:20px 15px;transition:left .3s ease;z-index:200;}
.sidebar h4{font-weight:700;margin-bottom:20px;text-align:center;}
.nav-links{display:flex;flex-direction:column;gap:6px;}
.nav-links a{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:8px;text-decoration:none;color:var(--text);font-weight:500;transition:.2s;}
.nav-links a:hover,.nav-links a.active{background:rgba(13,110,253,0.1);color:#0d6efd;}
.sidebar-footer{border-top:1px solid rgba(0,0,0,0.1);padding-top:10px;text-align:center;font-size:.9rem;}
.theme-toggle{background:none;border:none;font-size:1.3rem;cursor:pointer;color:var(--text);transition:.3s;}
.theme-toggle:hover{transform:rotate(15deg);}
.sidebar-close{position:absolute;top:10px;right:15px;font-size:1.3rem;cursor:pointer;display:none;color:var(--text);}
.main-content{margin-left:250px;flex:1;padding:30px;display:flex;flex-direction:column;gap:20px;transition:margin-left .3s ease;width:100%;box-sizing:border-box;}
.top-bar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
.sidebar-toggler{display:none;font-size:1.5rem;border:none;background:none;color:var(--text);cursor:pointer;}
.balance-container{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.balance-badge{background:var(--card);padding:6px 14px;border-radius:25px;box-shadow:0 2px 6px var(--shadow);font-weight:600;display:flex;align-items:center;gap:6px;}
.balance-eye{cursor:pointer;font-size:1rem;color:var(--text);}
.dashboard-box{background:var(--card);box-shadow:0 6px 16px var(--shadow);border-radius:12px;padding:25px;}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:15px;margin-bottom:25px;}
.stat-box{background:var(--bg);border-radius:8px;box-shadow:0 4px 10px var(--shadow);padding:20px;text-align:center;}
.stat-box h3{margin:0;font-size:1.6rem;}
.stat-box p{font-size:.9rem;opacity:.8;margin:0;}
.analytics{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:15px;}
.chart-box{background:var(--bg);border-radius:8px;box-shadow:0 4px 10px var(--shadow);padding:20px;}
.chart-box h6{margin-bottom:10px;font-weight:600;}
.balance-box{background:var(--card);box-shadow:0 6px 16px var(--shadow);border-radius:12px;padding:15px;}
.transaction-history{max-height:230px;overflow-y:auto;margin-top:8px;}
.transaction-item{display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid rgba(0,0,0,0.1);font-size:.85rem;}
.credit{color:green;}.debit{color:red;}
.overlay{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.4);z-index:150;}

/* ===== Outlined buttons ===== */
.action-btn{
  border:2px solid transparent;
  border-radius:8px;
  padding:8px 14px;
  font-size:.9rem;
  cursor:pointer;
  background:transparent;
  transition:.3s;
  font-weight:500;
  text-align:center;
}
.deposit-btn{
  color:#198754;
  border-color:#198754;
}
.deposit-btn:hover{
  background:#198754;
  color:#fff;
}
.withdraw-btn{
  color:#dc3545;
  border-color:#dc3545;
}
.withdraw-btn:hover{
  background:#dc3545;
  color:#fff;
}

/* Hide sidebar buttons by default */
.nav-links .action-btn{display:none;}

/* ========= TABLET ========= */
@media(max-width:991px){
  .sidebar{left:-250px;}
  .sidebar.active{left:0;}
  .sidebar-close{display:block;}
  .sidebar-toggler{display:block;}
  .main-content{margin-left:0;width:100%;}
  .overlay.active{display:block;}
  .dashboard-box{padding:18px;}
  .stat-box h3{font-size:1.3rem;}
  .chart-box{padding:15px;}
}

/* ========= MOBILE ========= */
@media(max-width:576px){
  .sidebar{width:220px;padding:15px;}
  .top-bar{flex-direction:row;justify-content:space-between;align-items:center;text-align:left;gap:8px;}
  .welcome{font-size:.85rem;}
  .balance-container{flex-direction:row;align-items:center;gap:8px;}

  /* Hide Deposit/Withdraw on Navbar */
  .top-bar .action-btn{display:none;}

  /* Show Deposit/Withdraw in Sidebar only on mobile */
  .nav-links .action-btn{
    display:block;
    width:100%;
    margin-top:10px;
    font-size:.85rem;
    padding:8px 12px;
  }
  .nav-links .action-btn:first-of-type{margin-top:15px;}

  .balance-badge{font-size:.8rem;padding:5px 12px;}
  .dashboard-box{padding:12px;}
  .stats{display:flex;flex-direction:column;gap:10px;}
  .stat-box{display:flex;justify-content:space-between;align-items:center;text-align:left;padding:10px 12px;}
  .stat-box h3{font-size:1.2rem;}
  .stat-box p{font-size:.8rem;}
  .analytics{grid-template-columns:1fr;gap:10px;}
  .chart-box{padding:10px;}
  .chart-box h6{font-size:.85rem;}
  canvas{max-width:100%;height:auto;}
  .balance-box{padding:10px;}
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
      <a href="#" class="active"><i class="fa-solid fa-chart-line"></i>Dashboard</a>
      <a href="form_group.php"><i class="fa-solid fa-pen-to-square"></i>Form Group</a>
      <a href="#"><i class="fa-solid fa-users"></i>Join Group</a>
      <a href="view_group.php"><i class="fa-solid fa-eye"></i>My Groups</a>
      <a href="notifications.php"><i class="fa-solid fa-bell"></i>Notifications</a>

      <!-- Mobile-only buttons -->
      <button class="action-btn deposit-btn">Deposit</button>
      <button class="action-btn withdraw-btn">Withdraw</button>
    </nav>
  </div>
  <div class="sidebar-footer">
    <div class="mb-2"><button class="theme-toggle" id="themeToggle"><i class="fa-solid fa-sun"></i></button></div>
    <div><a href="../../auth/php/logout.php" class="text-decoration-none text-danger"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a></div>
  </div>
</aside>

<div class="overlay" id="overlay"></div>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="top-bar">
    <button class="sidebar-toggler" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button>
    <div class="welcome">Welcome, <strong><?php echo htmlspecialchars($_SESSION['member_name']); ?></strong></div>
    <div class="balance-container">
      <button class="action-btn deposit-btn">Deposit</button>
      <button class="action-btn withdraw-btn">Withdraw</button>
      <div class="balance-badge">
        <i class="fa-solid fa-wallet"></i>
        <span id="navBalance">₱12,450.00</span>
        <i class="fa-solid fa-eye balance-eye" id="toggleBalance"></i>
      </div>
    </div>
  </div>

  <div class="dashboard-box">
    <div class="stats">
      <div class="stat-box"><h3>5</h3><p>Groups Joined</p></div>
      <div class="stat-box"><h3>2</h3><p>Pending Invites</p></div>
      <div class="stat-box"><h3>4</h3><p>Notifications</p></div>
      <div class="stat-box"><h3>3</h3><p>Deposits Made</p></div>
    </div>

    <div class="analytics">
      <div class="chart-box">
        <h6><i class="fa-solid fa-chart-pie me-2"></i>Contribution Overview</h6>
        <canvas id="pieChart" height="180"></canvas>
      </div>
      <div class="chart-box">
        <h6><i class="fa-solid fa-arrow-trend-up me-2"></i>Monthly Growth</h6>
        <canvas id="barChart" height="180"></canvas>
      </div>
      <div class="chart-box">
        <h6><i class="fa-solid fa-line-chart me-2"></i>Activity Trend</h6>
        <canvas id="lineChart" height="180"></canvas>
      </div>
    </div>
  </div>

  <div class="balance-box">
    <h6><i class="fa-solid fa-clock-rotate-left me-2"></i>Recent Transactions</h6>
    <div class="transaction-history">
      <div class="transaction-item"><span>Deposit</span><span class="credit">+₱500.00</span></div>
      <div class="transaction-item"><span>Contribution</span><span class="debit">-₱200.00</span></div>
      <div class="transaction-item"><span>Withdrawal</span><span class="debit">-₱100.00</span></div>
      <div class="transaction-item"><span>Deposit</span><span class="credit">+₱1,000.00</span></div>
    </div>
  </div>
</div>

<script src="../../jquery.js"></script>
<script src="../../styles/js/bootstrap.bundle.min.js"></script>
<script>
// Sidebar toggle
const sidebar=document.getElementById("sidebar"),
      sidebarToggle=document.getElementById("sidebarToggle"),
      sidebarClose=document.getElementById("sidebarClose"),
      overlay=document.getElementById("overlay");
sidebarToggle.addEventListener("click",()=>{sidebar.classList.toggle("active");overlay.classList.toggle("active");});
sidebarClose.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});
overlay.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});

// Theme toggle
const themeToggle=document.getElementById("themeToggle"),icon=themeToggle.querySelector("i");
if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark-mode");icon.classList.replace("fa-sun","fa-moon");}
themeToggle.addEventListener("click",()=>{document.body.classList.toggle("dark-mode");const isDark=document.body.classList.contains("dark-mode");localStorage.setItem("theme",isDark?"dark":"light");icon.classList.toggle("fa-sun");icon.classList.toggle("fa-moon");updateChartColors();});

// Toggle balance visibility
const balance=document.getElementById("navBalance"),eye=document.getElementById("toggleBalance");
let visible=true;
eye.addEventListener("click",()=>{visible=!visible;if(visible){balance.textContent="₱12,450.00";eye.classList.replace("fa-eye-slash","fa-eye");}else{balance.textContent="••••••••";eye.classList.replace("fa-eye","fa-eye-slash");}});

// Chart.js Config
const chartColor=()=>getComputedStyle(document.body).getPropertyValue('--text').trim();
const gridColor=()=>getComputedStyle(document.body).getPropertyValue('--shadow').replace('0.5','0.2');
let pieChart,barChart,lineChart;
function renderCharts(){
  const textColor=chartColor(),grid=gridColor();
  if(pieChart) pieChart.destroy(); if(barChart) barChart.destroy(); if(lineChart) lineChart.destroy();
  pieChart=new Chart(document.getElementById('pieChart'),{type:'pie',data:{labels:['Contributions','Withdrawals','Deposits','Pending'],datasets:[{data:[40,20,30,10],backgroundColor:['#0d6efd','#dc3545','#198754','#ffc107']}]},options:{plugins:{legend:{labels:{color:textColor}}}}});
  barChart=new Chart(document.getElementById('barChart'),{type:'bar',data:{labels:['Jan','Feb','Mar','Apr','May'],datasets:[{label:'Deposits',data:[300,400,350,450,500],backgroundColor:'#198754'},{label:'Withdrawals',data:[100,150,80,120,90],backgroundColor:'#dc3545'}]},options:{scales:{x:{ticks:{color:textColor},grid:{color:grid}},y:{ticks:{color:textColor},grid:{color:grid}}},plugins:{legend:{labels:{color:textColor}}}}});
  lineChart=new Chart(document.getElementById('lineChart'),{type:'line',data:{labels:['Week 1','Week 2','Week 3','Week 4'],datasets:[{label:'Activity',data:[3,5,4,6],borderColor:'#0d6efd',backgroundColor:'rgba(13,110,253,0.2)',fill:true},{label:'Deposits',data:[2,4,3,5],borderColor:'#198754',backgroundColor:'rgba(25,135,84,0.2)',fill:true}]},options:{scales:{x:{ticks:{color:textColor},grid:{color:grid}},y:{ticks:{color:textColor},grid:{color:grid}}},plugins:{legend:{labels:{color:textColor}}}}});
}
function updateChartColors(){renderCharts();}
renderCharts();
</script>
</body>
</html>
