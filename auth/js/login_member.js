function login_member(email, password) {
    $.post("auth/php/login_member.php", 
        {
            email: email,
            password: password
        }, 
        function(response) {
            if (response === "login") {
                window.location.href="../../templates/members/member_dashboard.php";
            } else {
                alert("negro");
            }
    })
}
