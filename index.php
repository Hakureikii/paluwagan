<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Member Login</title>
<link rel="stylesheet" href="styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="styles/css/index-style.css">
<style>

</style>
</head>

<body>
<div class="split-container">
  <div class="split-left">
    <div id="leftCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">
        <div class="carousel-item active"><h1>Welcome to Bayawagan</h1><p>Manage your account, access exclusive tools, and grow your network.</p></div>
        <div class="carousel-item"><h1>Stay Connected</h1><p>Collaborate seamlessly with your team anytime, anywhere.</p></div>
        <div class="carousel-item"><h1>Powerful Insights</h1><p>Get data-driven analytics to make smarter, faster decisions.</p></div>
        <div class="carousel-item"><h1>Secure & Reliable</h1><p>Your data is always safe with our world-class encryption systems.</p></div>
      </div>
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="3"></button>
      </div>
    </div>
  </div>

  <div class="split-right">
    <div class="login-card">
      <h3 class="text-center mb-4">Login</h3>
      <form id="form-login-member">
        <div class="mb-3"><input type="email" id="email" class="form-control" placeholder="Email" required></div>
        <div class="mb-3 password-wrapper"><input type="password" id="password" class="form-control" placeholder="Password" required><i class="fa-solid fa-eye toggle-password"></i></div>
        <button type="submit" class="btn btn-primary"><span class="btn-text">Login</span></button>
        <p class="text-center mt-3">No account? <a href="templates/members/signup_member.php">Sign up</a></p>
      </form>
    </div>
  </div>
</div>

<script src="jquery.js"></script>
<script src="styles/js/bootstrap.bundle.min.js"></script>
<script src="auth/js/login_member.js"></script>
<script>
// Toggle password visibility
$(".toggle-password").on("click", function () {
  const passwordField = $("#password");
  const type = passwordField.attr("type") === "password" ? "text" : "password";
  passwordField.attr("type", type);
  $(this).toggleClass("fa-eye fa-eye-slash");
});

// Form validation + loading animation
$("#form-login-member").submit(function (e) {
  e.preventDefault();
  let email = $("#email").val().trim();
  let password = $("#password").val().trim();
  let valid = true;
  if (!email) { $("#email").addClass("is-invalid"); valid = false; } else $("#email").removeClass("is-invalid");
  if (!password) { $("#password").addClass("is-invalid"); valid = false; } else $("#password").removeClass("is-invalid");
  if (!valid) return;
  const btn = $(".btn-primary");
  btn.addClass("loading");
  btn.html('<div class="spinner-border text-light" role="status"></div>');
  setTimeout(() => { btn.removeClass("loading"); btn.html('<span class="btn-text">Login</span>'); login_member(email, password); }, 1200);
});
</script>
</body>
</html>
