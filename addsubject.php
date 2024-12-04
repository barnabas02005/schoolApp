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
  <script src="route.js" defer></script>
</head>

<body>
  <form id="addSubjectForm">
    <label>Subject Name: <input type="text" id="subjectname" required /></label><br />
    <button type="submit">Submit</button>
  </form>

  <a href="student_dashboard.php">Back to student dashboard (JESUS IS LORD)</a>

  <script src="assets/js/randomHexCode.js" defer></script>
  <script>
    document.getElementById("addSubjectForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const subjectname = document.getElementById("subjectname").value;
      const hexCode = generateRandomColor('white');

      // Send the class name and hashed password to the server
      fetch("save_subject.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            subjectname: subjectname,
            theme: hexCode
          }),
        })
        .then((response) => response.json())
        .then((data) => {
          console.log(data.message);
          alert(data.message);
          document.getElementById("addSubjectForm").reset();
        })
        .catch((error) => console.error("Error:", error));
    });
  </script>
</body>

</html>