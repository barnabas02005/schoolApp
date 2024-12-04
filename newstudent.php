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
  <form id="studentForm">
    <label>First Name: <input type="text" id="firstname" required /></label><br />
    <label>Last Name: <input type="text" id="lastname" required /></label><br />
    <label for="classoption">Select class:
      <select id="class">
        <?php while ($row = mysqli_fetch_assoc($selectClassResult)) { ?>
          <option value="<?php echo $row['id']; ?>"><?php echo $row['classname']; ?></option>
        <?php } ?>
      </select>
    </label>
    <label for="genderoption">Select your gender:
      <select id="gender">
        <option value="0">Male</option>
        <option value="1">Female</option>
      </select>
    </label>
    <label>Password: <input type="password" id="password" required /></label><br />
    <button type="submit">Submit</button>
  </form>

  <script>
    document
      .getElementById("studentForm")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const firstname = document.getElementById("firstname").value;
        const lastname = document.getElementById("lastname").value;
        const classs = document.getElementById("class").value;
        console.log("Here: ", classs);
        const gender = document.getElementById("gender").value;
        const password = document.getElementById("password").value;

        // Send the class name and hashed password to the server
        fetch("save_student.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              firstname: firstname,
              lastname: lastname,
              classs: classs,
              gender: gender,
              password: password,
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log(data.message);
            alert(data.message);
            document.getElementById("studentForm").reset();
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