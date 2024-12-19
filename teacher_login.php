<?php
session_start();
if (isset($_SESSION['teacher_id'])) {
  header("Location: teacher_dashboard.php?access=granted");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Teacher</title>
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
        <span>Hello, Teacher</span>
      </div>
      <form action="#" id="loginForm" method="post">
        <div class="error-box">
          <span id="errorMessage">
            You've entered an invalid password.
          </span>
        </div>
        <div class="input-box active">
          <input type="text" name="" id="login" autocomplete="off">
          <span>E-mail or Mobilenumber*</span>
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
  <!-- <form id="loginForm">
    <label>Mobilenumber | Email: <input type="text" id="login" required /></label><br />
    <label>Password: <input type="password" id="password" required /></label><br />
    <button type="submit">Log in</button>
  </form> -->

  <script src="assets/js/resetForm.js"></script>
  <script src="assets/js/form-step.js"></script>
  <script>
    resetForm("loginForm");

    async function submitForm(e) {
      e.preventDefault();

      const login = document.getElementById("login").value;
      const password = document.getElementById("password").value;


      // Send the first name and hashed password to the server for verification
      fetch("teachlogin.php", {
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
            alert("Login successful!");
            window.location.href = "teacher_dashboard.php";
          } else if (data.selectclass) {
            window.location.href = "t_selectclass.php";
          } else {
            if (data.failure) {
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
          }
        })
        .catch((error) => console.error("Error:", error));
    }

    // // Basic client-side password hashing function (SHA-256)
    // async function hashPassword(password) {
    //   const encoder = new TextEncoder();
    //   const data = encoder.encode(password);
    //   const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    //   const hashArray = Array.from(new Uint8Array(hashBuffer));
    //   return btoa(String.fromCharCode(...hashArray));
    // }
  </script>
</body>

</html>