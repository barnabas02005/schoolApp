<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header("Location: student_dashboard.php?access=granted");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
  <div class="container">
    <header>
      <div class="webApp_logo">
        <img src="assets/img/logo_text_r.png" alt="">
      </div>
    </header>
    <main>
      <div class="welcome_txt">
        <span>Welcome Back</span>
      </div>
      <form action="#" id="loginForm" method="post">
        <div class="error-box">
          <span id="errorMessage">
            You've entered an invalid password.
          </span>
        </div>
        <div class="input-box active">
          <input type="text" name="" id="login" autocomplete="off">
          <span>Student ID*</span>
        </div>
        <div class="input-box">
          <input type="password" name="" id="password" autocomplete="off">
          <span>Password*</span>
        </div>
        <div class="submit-btn">
          <button type="button">Log In</button>
        </div>
      </form>
      <div class="cta_refrence">
        <span>Don't have an account?<span class="cta_active">Contact an administrator</span></span>
      </div>

      <div class="foot_content">
        <div class="cont">
          <span>Terms of use</span>
        </div>
        <span>|</span>
        <div class="cont">
          <span>Privacy policy</span>
        </div>
      </div>
    </main>
  </div>

  <script src="assets/js/form-step.js"></script>
  <script src="assets/js/resetForm.js"></script>
  <script>
    resetForm("loginForm");
    const formLogin = document.getElementById('loginForm');

    async function submitForm(e) {
      e.preventDefault();

      const login = document.getElementById("login").value;
      const password = document.getElementById("password").value;
      // Send the first name and hashed password to the server for verification
      fetch("stdntlogin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            login: login,
            password: password
          })
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // alert("Login successful!");
            window.location.href = "student_dashboard.php";
          } else {
            errorMessage.textContent = data.message;
            errorMessage.parentElement.classList.add('active');

            if (data.ww === "both") {
              allInputBox.forEach(input => {
                input.classList.add('error');
              });
            } else if (data.ww === "password") {
              allInputBox[1].classList.add('error');
            }
          }
        })
        .catch((error) => console.error("Error:", error));
    }
  </script>
</body>

</html>

<!-- <form id="loginForm">
    <label>First Name: <input type="text" id="firstname" required /></label><br />
    <label>Password: <input type="password" id="password" required /></label><br />
    <button type="submit">Login</button>
  </form>

  <script>
    document.getElementById("loginForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const firstname = document.getElementById("firstname").value;
      const password = document.getElementById("password").value;

      // Hash the password client-side
      const passwordHash = await hashPassword(password);

      // Send the first name and hashed password to the server for verification
      fetch("stdntlogin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            firstname: firstname,
            password_hash: passwordHash
          })
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Login successful!");
            window.location.href = "student_dashboard.php";
          } else {
            alert("Invalid credentials!");
          }
        })
        .catch((error) => console.error("Error:", error));
    });

    // Basic client-side password hashing function (SHA-256)
    async function hashPassword(password) {
      const encoder = new TextEncoder();
      const data = encoder.encode(password);
      const hashBuffer = await crypto.subtle.digest("SHA-256", data);
      const hashArray = Array.from(new Uint8Array(hashBuffer));
      return btoa(String.fromCharCode(...hashArray));
    }
  </script> -->