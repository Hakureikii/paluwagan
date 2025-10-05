<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Signup</title>
    <link rel="stylesheet" href="styles/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>

<body>
    <form id="form-login-user">
        <input type="email" placeholder="email" id="email">
        <input type="password" placeholder="password" id="password">
        <button type="submit" class="btn btn-primary"> Login </button>
        <a href="templates/signup_participant.php"> No account? Sign Up! </a>
    </form>

</body>

</html>

<script src="jquery.js"></script>
<script src="auth/js/login_participant.js"></script>


<script>
    $("#form-login-user").submit(function (e) {
        e.preventDefault();
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();
        login_participant(email, password);
    })
</script>