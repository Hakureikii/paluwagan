function signup_members(last_name, first_name, middle_name, brgy, municipality, province, contact_number, email, password, credentials) {
    $.post("../../auth/php/signup_member.php", 
        {
            last_name: last_name,
            first_name: first_name,
            middle_name: middle_name,
            brgy: brgy,
            municipality: municipality,
            province: province,
            contact_number: contact_number,
            email: email,
            password: password,
            credentials: credentials, 
        }, 
        function(response) {
            if (response === "ok") {
                window.location.href="../../index.php";
            } else {
                alert("bai");
            }
    })
}