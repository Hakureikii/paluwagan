function login_participant(email, password) {
    $.post("auth/php/login_participant.php", 
        {
            email: email,
            password: password
        }, 
        function(response) {
            if (response === "login") {
                window.location.href="templates/participant_dashboard.php";
            } else {
                alert("negro");
            }
    })
}
