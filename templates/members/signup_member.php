<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Enhanced Multi-Step Signup</title>
<link rel="stylesheet" href="../../styles/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
background:url('https://via.placeholder.com/1600x900?text=Signup+Background') center/cover no-repeat fixed;
position:relative;font-family:"Segoe UI",sans-serif;overflow:hidden;}
body::before {content:"";position:absolute;inset:0;background:rgba(0,0,0,0.55);backdrop-filter:blur(5px);z-index:1;}
.signup-container {position:relative;z-index:2;background:rgba(255,255,255,0.96);width:400px;max-width:90%;border-radius:12px;
box-shadow:0 8px 30px rgba(0,0,0,0.3);overflow:hidden;animation:fadeIn 0.8s ease;}
.progress-circles {display:flex;justify-content:space-around;padding:20px 10px;background:#e9ecef;}
.circle {width:35px;height:35px;border-radius:50%;background:#dee2e6;display:flex;align-items:center;justify-content:center;
color:#6c757d;font-weight:600;transition:all 0.3s ease;}
.circle.active {background:#0d6efd;color:#fff;}
.circle.completed {background:#198754;color:#fff;}
.step {display:none;padding:30px 25px;animation:slideIn 0.5s ease;}
.step.active {display:block;}
h3 {text-align:center;margin-bottom:20px;font-weight:600;color:#212529;}
.form-control {margin-bottom:15px;border-radius:8px;padding:10px 12px;}
.btn {border-radius:8px;width:48%;}
.btn-next {background:#0d6efd;color:#fff;border:none;}
.btn-prev {background:#e9ecef;color:#212529;border:none;}
.btn-submit {width:100%;background:#198754;color:#fff;border:none;}
.step-buttons {display:flex;justify-content:space-between;margin-top:10px;}
.step-indicator {text-align:center;margin-top:15px;font-size:0.9rem;color:#6c757d;}
.is-invalid {border-color:#dc3545;box-shadow:0 0 0 0.2rem rgba(220,53,69,0.25);}
@keyframes fadeIn {from{opacity:0;transform:scale(0.95);}to{opacity:1;transform:scale(1);}}
@keyframes slideInLeft {from{opacity:0;transform:translateX(-30px);}to{opacity:1;transform:translateX(0);}}
@keyframes slideInRight {from{opacity:0;transform:translateX(30px);}to{opacity:1;transform:translateX(0);}}
@media (max-width:480px){
  .signup-container{width:95%;}.btn{width:100%;margin-bottom:10px;}
  .step-buttons{flex-direction:column;align-items:stretch;}
}
</style>
</head>

<body>

<div class="signup-container">
  <div class="progress-circles">
    <div class="circle active" data-step="1">1</div>
    <div class="circle" data-step="2">2</div>
    <div class="circle" data-step="3">3</div>
    <div class="circle" data-step="4">4</div>
  </div>

  <!-- Step 1 -->
  <div class="step active" data-step="1">
    <h3>Personal Information</h3>
    <input type="text" id="last-name" class="form-control required" placeholder="Last Name" required>
    <input type="text" id="first-name" class="form-control required" placeholder="First Name" required>
    <input type="text" id="middle-name" class="form-control" placeholder="Middle Name">
    <div class="step-buttons">
      <button type="button" class="btn btn-next">Next</button>
    </div>
    <div class="step-indicator">Step 1 of 4</div>
    <p class="text-center mt-3 mb-0">
      <a href="../../index.php">Already have an account? Login</a>
    </p>
  </div>

  <!-- Step 2 -->
  <div class="step" data-step="2">
    <h3>Address</h3>
    <input type="text" id="brgy" class="form-control required" placeholder="Brgy." required>
    <input type="text" id="municipality" class="form-control required" placeholder="Municipality" required>
    <input type="text" id="province" class="form-control required" placeholder="Province" required>
    <div class="step-buttons">
      <button type="button" class="btn btn-next">Next</button>
      <button type="button" class="btn btn-prev">Back</button>
    </div>
    <div class="step-indicator">Step 2 of 4</div>
  </div>

  <!-- Step 3 -->
  <div class="step" data-step="3">
    <h3>Account Credentials</h3>
    <input type="text" id="contact-number" class="form-control required" placeholder="Contact Number" required>
    <input type="email" id="email" class="form-control required" placeholder="Email" required>
    <input type="password" id="password" class="form-control required" placeholder="Password" required>
    <div class="step-buttons">
      <button type="button" class="btn btn-next">Next</button>
      <button type="button" class="btn btn-prev">Back</button>
    </div>
    <div class="step-indicator">Step 3 of 4</div>
  </div>

  <!-- Step 4 -->
  <div class="step" data-step="4">
    <h3>Upload Credentials</h3>
    <input type="file" id="credentials" class="form-control required" required>
    <div class="step-buttons">
      <button type="submit" class="btn btn-submit" id="submitBtn">Sign Up</button>
      <button type="button" class="btn btn-prev">Back</button>
    </div>
    <div class="step-indicator">Step 4 of 4</div>
    <p class="text-center mt-3 mb-0">
      <a href="../../index.php">Already have an account? Sign in</a>
    </p>
  </div>
</div>

<script src="../../jquery.js"></script>
<script src="../../auth/js/signup_member.js"></script>

<script>
let currentStep = 1;
const totalSteps = 4;

function showStep(step, direction = 'right') {
  $(".step").removeClass("active").css("animation", "");
  const activeStep = $(`.step[data-step="${step}"]`);
  activeStep.addClass("active").css("animation", direction === 'right' ? "slideInRight 0.4s ease" : "slideInLeft 0.4s ease");

  $(".circle").removeClass("active completed");
  $(".circle").each(function(index) {
    const stepNum = index + 1;
    if (stepNum < step) $(this).addClass("completed");
    else if (stepNum === step) $(this).addClass("active");
  });
}

function validateStep(step) {
  let valid = true;
  $(`.step[data-step="${step}"] .required`).each(function() {
    if (!$(this).val().trim()) {
      $(this).addClass("is-invalid");
      valid = false;
    } else {
      $(this).removeClass("is-invalid");
    }
  });
  return valid;
}

function saveFormData() {
  $("input").each(function() {
    const id = $(this).attr("id");
    localStorage.setItem(id, $(this).val());
  });
}

$(document).ready(function() {
  $("input").each(function() {
    const id = $(this).attr("id");
    const saved = localStorage.getItem(id);
    if (saved) $(this).val(saved);
  });
});

$(document).on("input", "input", saveFormData);

$(document).on("click", ".btn-next", function () {
  if (validateStep(currentStep)) {
    if (currentStep < totalSteps) showStep(++currentStep, 'right');
  }
});

$(document).on("click", ".btn-prev", function () {
  if (currentStep > 1) showStep(--currentStep, 'left');
});

$("#submitBtn").on("click", function (e) {
  e.preventDefault();
  if (!validateStep(currentStep)) return;

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

  if (!last_name || !first_name || !brgy || !municipality || !province || !contact_number || !email || !password || !credentials) {
    alert("Please complete all required fields before submitting.");
    return;
  }

  signup_members(last_name, first_name, middle_name, brgy, municipality, province, contact_number, email, password, credentials);
});
</script>

</body>
</html>
