<?php
include("config.php");

$selectClass = "SELECT * from class WHERE `status` = 1";
$selectClassResult = mysqli_query($conn, $selectClass);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Class Submission with Password Hash</title>
</head>

<body>
  <form id="addTeacherForm">
    <label>First Name: <input type="text" id="firstname" required /></label><br />
    <label>Last Name: <input type="text" id="lastname" required /></label><br />
    <label for="genderoption">Select your gender:
      <select id="gender">
        <option value="0">Male</option>
        <option value="1">Female</option>
      </select>
    </label>
    <label for="titleoption">Select a courtsey title:
      <select id="title">
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Master">Master</option>
        <option value="Miss">Miss</option>
      </select>
    </label>
    <label>Password: <input type="password" id="password" required /></label><br />
    <label>Email Address: <input type="email" id="email" required /></label><br />
    <label>Mobile number: <input type="number" id="mobilenumber" required /></label><br />
    <button type="submit">Submit</button>
  </form>

  <script>
    document
      .getElementById("addTeacherForm")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const firstname = document.getElementById("firstname").value;
        const lastname = document.getElementById("lastname").value;
        const gender = document.getElementById("gender").value;
        const title = document.getElementById("title").value;
        const password = document.getElementById("password").value;
        const email = document.getElementById("email").value;
        const mobilenumber = document.getElementById("mobilenumber").value;

        // Hash the password client-side
        const passwordHash = await hashPassword(password);

        // Send the class name and hashed password to the server
        fetch("save_teacher.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              firstname: firstname,
              lastname: lastname,
              gender: gender,
              title: title,
              password_hash: passwordHash,
              email: email,
              mobilenumber: mobilenumber,
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log(data.message);
            alert(data.message);
            document.getElementById("addTeacherForm").reset();
          })
          .catch((error) => console.error("Error:", error));
      });

    // Basic client-side password hashing function (SHA-256)
    async function hashPassword(password) {
      const encoder = new TextEncoder();
      const data = encoder.encode(password);
      const hashBuffer = await crypto.subtle.digest("SHA-256", data);
      const hashArray = Array.from(new Uint8Array(hashBuffer)); // Convert buffer to byte array
      return btoa(String.fromCharCode(...hashArray)); // Convert bytes to base64
    }
  </script>
</body>

</html>