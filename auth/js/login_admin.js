function login_admin(username, password) {
    $.post("../auth/php/login_admin.php",
        {
            username: username,
            password: password
        },
        function (response) {
            if (response === "login") {
                window.location.href = "../templates/admin_dashboard.php";
            } else {
                alert("olol");
            };
        })
}
