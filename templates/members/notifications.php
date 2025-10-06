<?php
session_start();
if (!isset($_SESSION["member_name"], $_SESSION["member_id"])) { header("Location: ../../index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Notifications</title>
<link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
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
.main-content{margin-left:250px;margin-right:15px;flex:1;padding:30px;display:flex;flex-direction:column;gap:20px;transition:margin .3s ease;width:100%;box-sizing:border-box;}
.top-bar{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;}
.welcome{margin-right:auto;font-weight:500;}
.sidebar-toggler{display:none;font-size:1.5rem;border:none;background:none;color:var(--text);cursor:pointer;}
.balance-container{display:flex;align-items:center;gap:10px;flex-wrap:wrap;}
.balance-badge{background:var(--card);padding:6px 14px;border-radius:25px;box-shadow:0 2px 6px var(--shadow);font-weight:600;display:flex;align-items:center;gap:6px;}
.balance-eye{cursor:pointer;font-size:1rem;color:var(--text);}
.card-box{background:var(--card);box-shadow:0 6px 16px var(--shadow);border-radius:12px;padding:25px;overflow-x:auto;}
.list-group-item{display:flex;flex-direction:column;justify-content:space-between;padding:12px 14px;border-radius:10px;margin-bottom:10px;box-shadow:0 2px 6px var(--shadow);background:var(--card);transition:.2s;}
.list-group-item:hover{transform:translateY(-2px);box-shadow:0 4px 12px var(--shadow);}
.item-info{display:flex;flex-direction:column;gap:2px;}
.item-info strong{font-size:.95rem;}
.item-info span{font-size:.85rem;color:rgba(0,0,0,0.65);}
.item-footer{display:flex;justify-content:flex-end;gap:8px;margin-top:10px;}
.action-btn{border:2px solid transparent;border-radius:8px;padding:8px 14px;font-size:.9rem;cursor:pointer;background:transparent;transition:.3s;font-weight:500;text-align:center;}
.deposit-btn{color:#198754;border-color:#198754;}
.deposit-btn:hover{background:#198754;color:#fff;}
.withdraw-btn{color:#dc3545;border-color:#dc3545;}
.withdraw-btn:hover{background:#dc3545;color:#fff;}
.nav-links .action-btn{display:none;}
@media(max-width:991px){.sidebar{left:-250px;}.sidebar.active{left:0;}.sidebar-close{display:block;}.sidebar-toggler{display:block;}.main-content{margin-left:0;margin-right:10px;width:100%;}.overlay.active{display:block;}}
@media(max-width:576px){.sidebar{width:220px;padding:15px;}.top-bar{flex-direction:row;justify-content:space-between;align-items:center;text-align:left;gap:8px;flex-wrap:nowrap;}.welcome{font-size:.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;flex-shrink:1;}.balance-container{flex-direction:row;align-items:center;gap:8px;flex-shrink:0;}.top-bar .action-btn{display:none;}.nav-links .action-btn{display:block;width:100%;margin-top:10px;font-size:.85rem;padding:8px 12px;}.nav-links .action-btn:first-of-type{margin-top:15px;}.balance-badge{font-size:.8rem;padding:5px 12px;}}
.item-footer .action-btn{padding:5px 10px;font-size:.8rem;}
</style>
</head>
<body>
<aside class="sidebar" id="sidebar"><i class="fa-solid fa-xmark sidebar-close" id="sidebarClose"></i><div><h4><i class="fa-solid fa-wallet me-2"></i>Paluwagan</h4><nav class="nav-links"><a href="member_dashboard.php"><i class="fa-solid fa-chart-line"></i>Dashboard</a><a href="form_group.php"><i class="fa-solid fa-pen-to-square"></i>Form Group</a><a href="#"><i class="fa-solid fa-users"></i>Join Group</a><a href="view_group.php"><i class="fa-solid fa-eye"></i>View My Group</a><a href="notifications.php" class="active"><i class="fa-solid fa-bell"></i>Notifications</a><button class="action-btn deposit-btn">Deposit</button><button class="action-btn withdraw-btn">Withdraw</button></nav></div><div class="sidebar-footer"><div class="mb-2"><button class="theme-toggle" id="themeToggle"><i class="fa-solid fa-sun"></i></button></div><div><a href="../../auth/php/logout.php" class="text-decoration-none text-danger"><i class="fa-solid fa-right-from-bracket me-1"></i>Logout</a></div></div></aside>
<div class="overlay" id="overlay"></div>
<div class="main-content">
<div class="top-bar"><button class="sidebar-toggler" id="sidebarToggle"><i class="fa-solid fa-bars"></i></button><div class="welcome">Welcome, <strong><?php echo htmlspecialchars($_SESSION['member_name']); ?></strong></div><div class="balance-container"><button class="action-btn deposit-btn">Deposit</button><button class="action-btn withdraw-btn">Withdraw</button><div class="balance-badge"><i class="fa-solid fa-wallet"></i><span id="navBalance">₱12,450.00</span><i class="fa-solid fa-eye balance-eye" id="toggleBalance"></i></div></div></div>
<div class="card-box"><h2>Group Invitations</h2><ul class="list-group" id="group_invitations_list"></ul></div>
</div>
<script src="../../jquery.js"></script>
<script src="../../styles/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar=document.getElementById("sidebar"),sidebarToggle=document.getElementById("sidebarToggle"),sidebarClose=document.getElementById("sidebarClose"),overlay=document.getElementById("overlay");sidebarToggle.addEventListener("click",()=>{sidebar.classList.toggle("active");overlay.classList.toggle("active");});sidebarClose.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});overlay.addEventListener("click",()=>{sidebar.classList.remove("active");overlay.classList.remove("active");});
const themeToggle=document.getElementById("themeToggle"),icon=themeToggle.querySelector("i");if(localStorage.getItem("theme")==="dark"){document.body.classList.add("dark-mode");icon.classList.replace("fa-sun","fa-moon");}themeToggle.addEventListener("click",()=>{document.body.classList.toggle("dark-mode");localStorage.setItem("theme",document.body.classList.contains("dark-mode")?"dark":"light");});
const balance=document.getElementById("navBalance"),eye=document.getElementById("toggleBalance");let visible=true;eye.addEventListener("click",()=>{visible=!visible;if(visible){balance.textContent="₱12,450.00";eye.classList.replace("fa-eye-slash","fa-eye");}else{balance.textContent="••••••••";eye.classList.replace("fa-eye","fa-eye-slash");}});
function display_group_invitations(){const list=document.getElementById("group_invitations_list");const invitations=[{no:1,group:"Savings Group",sender:"John Doe",receiver:"Jane Smith"},{no:2,group:"Paluwagan Team",sender:"Alice",receiver:"Bob"}];list.innerHTML="";invitations.forEach(inv=>{const li=document.createElement("li");li.className="list-group-item";li.innerHTML=`<div class="item-info"><strong>${inv.group}</strong><span>From: ${inv.sender}</span><span>To: ${inv.receiver}</span></div><div class="item-footer"><button class="action-btn deposit-btn btn-sm">Accept</button><button class="action-btn withdraw-btn btn-sm">Decline</button></div>`;list.appendChild(li);});}
display_group_invitations();
window.addEventListener("pageshow",function(event){if(event.persisted){window.location.reload();}});
</script>
</body>
</html>
