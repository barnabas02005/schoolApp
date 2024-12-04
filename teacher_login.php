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
  <title>Login | Teacher</title>
</head>

<body>
  <form id="loginForm">
    <label>Mobilenumber | Email: <input type="text" id="login" required /></label><br />
    <label>Password: <input type="password" id="password" required /></label><br />
    <button type="submit">Log in</button>
  </form>

  <script>
    document.getElementById("loginForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const login = document.getElementById("login").value;
      const password = document.getElementById("password").value;

      // Hash the password client-side
      const passwordHash = await hashPassword(password);

      // Send the first name and hashed password to the server for verification
      fetch("teachlogin.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            login: login,
            password_hash: passwordHash
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
              alert(data.message);
            }
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
  </script>
</body>

</html>