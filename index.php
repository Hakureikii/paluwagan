<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <link rel="stylesheet" href="styles/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            background: #f8f9fa;
        }

        .split-container {
            display: flex;
            flex-direction: row;
            height: 100vh;
            animation: fadeIn 1.2s ease;
        }

        /* LEFT SIDE (Carousel Section) */
        .split-left {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 40px;
            flex: 1;
            animation: slideInLeft 1s ease;
            overflow: hidden;
        }

        .carousel-item {
            text-align: center;
        }

        .carousel-item h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .carousel-item p {
            font-size: 1.1rem;
            max-width: 400px;
            margin: 0 auto 25px auto;
            line-height: 1.5;
        }

        .carousel-indicators {
            position: relative;
            bottom: 0;
            margin-top: 10px;
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            border: none;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .carousel-indicators .active {
            background-color: white;
            transform: scale(1.2);
        }

        /* RIGHT SIDE */
        .split-right {
            flex: 1;
            background: url('https://via.placeholder.com/800x1000?text=Placeholder+Background') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: slideInRight 1s ease;
            position: relative;
        }

        .split-right::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(6px);
            padding: 35px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transform: scale(0.95);
            opacity: 0;
            animation: popIn 0.8s ease forwards 0.8s;
            position: relative;
            z-index: 2;
        }

        .login-card h3 {
            font-size: 1.5rem;
        }

        .btn-primary {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-primary.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .spinner-border {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes popIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* 📱 Responsive Design */
        @media (max-width: 992px) {
            .split-container {
                flex-direction: column;
                height: auto;
            }

            .split-left {
                display: none; /* Hide carousel on tablets & phones */
            }

            .split-right {
                flex: none;
                width: 100%;
                min-height: 100vh;
                background-position: center;
            }

            .login-card {
                width: 85%;
                max-width: 340px;
                margin: 60px auto;
                padding: 30px 25px;
                background: rgba(255, 255, 255, 0.98);
            }

            .login-card h3 {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .login-card {
                width: 90%;
                padding: 25px 20px;
                margin: 40px auto;
            }

            .login-card h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <div class="split-container">
        <!-- LEFT SIDE with CAROUSEL -->
        <div class="split-left">
            <div id="leftCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <h1>Welcome to Bayawagan</h1>
                        <p>Manage your account, access exclusive tools, and grow your network.</p>
                    </div>
                    <div class="carousel-item">
                        <h1>Stay Connected</h1>
                        <p>Collaborate seamlessly with your team anytime, anywhere.</p>
                    </div>
                    <div class="carousel-item">
                        <h1>Powerful Insights</h1>
                        <p>Get data-driven analytics to make smarter, faster decisions.</p>
                    </div>
                    <div class="carousel-item">
                        <h1>Secure & Reliable</h1>
                        <p>Your data is always safe with our world-class encryption systems.</p>
                    </div>
                </div>

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="0" class="active"
                        aria-current="true"></button>
                    <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#leftCarousel" data-bs-slide-to="3"></button>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE (Login Form + Background) -->
        <div class="split-right">
            <div class="login-card">
                <h3 class="text-center mb-4">Login</h3>
                <form id="form-login-member">
                    <div class="mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3 password-wrapper">
                        <input type="password" id="password" class="form-control" placeholder="Password" required>
                        <i class="fa-solid fa-eye toggle-password"></i>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-text">Login</span>
                    </button>
                    <p class="text-center mt-3">No account? <a href="templates/members/signup_member.php">Sign up</a></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

            if (!email) {
                $("#email").addClass("is-invalid");
                valid = false;
            } else $("#email").removeClass("is-invalid");

            if (!password) {
                $("#password").addClass("is-invalid");
                valid = false;
            } else $("#password").removeClass("is-invalid");

            if (!valid) return;

            const btn = $(".btn-primary");
            btn.addClass("loading");
            btn.html('<div class="spinner-border text-light" role="status"></div>');

            setTimeout(() => {
                btn.removeClass("loading");
                btn.html('<span class="btn-text">Login</span>');
                login_member(email, password);
            }, 1200);
        });
    </script>
</body>

</html>
