<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup</title>
    <link rel="stylesheet" href="styles/css/bootstrap.min.css">
</head>

<body>
    <form id="form-login-member">
        <input type="email" placeholder="email" id="email">
        <input type="password" placeholder="password" id="password">
        <button type="submit" class="btn btn-primary"> Login </button>
        <a href="templates/members/signup_member.php"> No account? Sign Up! </a>
    </form>

</body>

</html>

<script src="jquery.js"></script>
<script src="auth/js/login_member.js"></script>


<script>
    $("#form-login-member").submit(function (e) {
        e.preventDefault();
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();
        login_member(email, password);
    })
</script>