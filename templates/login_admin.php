<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
</head>

<body>
    <form id="form-login-admin">
        <input type="text" placeholder="username" id="username">
        <input type="password" placeholder="password" id="password">
        <button type="submit"> Login </button>
    </form>

</body>

</html>

<script src="../jquery.js"></script>
<script src="../auth/js/login_admin.js"></script>


<script>
    $("#form-login-admin").submit(function (e) {
        e.preventDefault();
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();
        login_admin(username, password);
    });
</script>