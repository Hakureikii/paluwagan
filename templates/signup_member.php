<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../styles/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>


<body>
    <form id="form-signup-member">
        <input type="text" placeholder="Last name" id="last-name">
        <input type="text" placeholder="First name" id="first-name">
        <input type="text" placeholder="Middle name" id="middle-name">
        <input type="text" placeholder="Brgy." id="brgy">
        <input type="text" placeholder="Municipality" id="municipality">
        <input type="text" placeholder="Province" id="province">
        <input type="text" placeholder="Contact number" id="contact-number">
        <input type="text" placeholder="Email" id="email">
        <input type="text" placeholder="Password" id="password"> <br>
        Credentials: <input type="file" id="credentials">
        <button type="submit" class="btn btn-primary"> Sign Up </button>
        <a href="../index.php"> Already have an account? Sign in now </a>
    </form>
</body>


</html>


<script src="../jquery.js"></script>
<script src="../auth/js/signup_member.js"></script>
<script>
    $("#form-signup-member").submit(function (e) {
        e.preventDefault();
        let last_name = $("#last-name").val().trim();
        let first_name = $("#first-name").val().trim();
        let middle_name = $("#middle-name").val().trim();
        let brgy = $("#brgy").val().trim();
        let municipality = $("#municipality").val().trim();
        let province = $("#province").val().trim();
        let contact_number = $("#contact-number").val().trim();
        let email = $("#email").val().trim();
        let password = $("#password").val().trim();
        let credentials = $("#credentials").val().trim();
        signup_members(last_name, first_name, middle_name, brgy, municipality, province, contact_number, email, password, credentials);
    })
</script>