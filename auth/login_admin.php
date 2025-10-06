<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login</title>
<link rel="stylesheet" href="../styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../styles/css/admin-login-style.css">

</head>
<body>

<div class="login-card">
    <h3>Admin Login</h3>
    <form id="form-login-admin">
        <div class="mb-3">
            <input type="text" id="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="mb-3 password-wrapper">
            <input type="password" id="password" class="form-control" placeholder="Password" required>
            <i class="fa-solid fa-eye toggle-password"></i>
        </div>
        <button type="submit" class="btn btn-primary"><span class="btn-text">Login</span></button>
    </form>
</div>

<script src="../jquery.js"></script>
<script src="../styles/js/bootstrap.bundle.min.js"></script>
<script src="js/login_admin.js"></script>
<script>
// Toggle password visibility
$(".toggle-password").on("click", function() {
    const passwordField = $("#password");
    const type = passwordField.attr("type") === "password" ? "text" : "password";
    passwordField.attr("type", type);
    $(this).toggleClass("fa-eye fa-eye-slash");
});

// Form submission (example)
$("#form-login-admin").submit(function(e) {
    e.preventDefault();
    let username = $("#username").val().trim();
    let password = $("#password").val().trim();
    const btn = $(".btn-primary");
    btn.addClass("loading").html('<div class="spinner-border text-light" role="status"></div>');
    setTimeout(() => {
        btn.removeClass("loading").html('<span class="btn-text">Login</span>');
        login_admin(username, password); // your function
    }, 1000);
});
</script>

</body>
</html>
