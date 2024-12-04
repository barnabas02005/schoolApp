<?php
include("config.php");
include("function_room.php");

// Get the query string from the URL
$queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

// Parse the query string into an associative array
parse_str($queryString, $params);
$classId = isset($params['class']) ? urldecode($params['class']) : '';



// Get all subjects from the database
$getallSubjects = getSubjects($conn);
$getallTeachers = getTeachers($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mamage Class</title>
  <script src="route.js" defer></script>
</head>

<body>
  <?php
  // Display subject links dynamically
  foreach ($getallSubjects as $subject) {
    $a_subject = urlencode($subject['id']); // URL-encode subject name
    echo "<a href='/classhelp/addTopic/subject/$a_subject/class/$classId'>" . $subject['subject_name'] . "<br></a>";
  }
  ?>
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <form id="mapTeacherClass" action="#" method="post">
    <input type="hidden" id="class_id" value="<?= $classId ?>">
    <label for="mapteacher">
      Choose a class teacher:
      <select id="teacher">
        <?php foreach ($getallTeachers as $teacher): ?>
          <option value="<?= htmlspecialchars($teacher['id']); ?>"><?= htmlspecialchars($teacher['title']); ?>&nbsp;<?= htmlspecialchars($teacher['firstname']); ?>&nbsp;<?= htmlspecialchars($teacher['lastname']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <br />
    <br />
    <button type="submit">Submit</button>
  </form>
  <script>
    document
      .getElementById("mapTeacherClass")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const classId = document.getElementById("class_id").value;
        const teacher = document.getElementById("teacher").value;


        // Send the class name and hashed password to the server
        let baseUrl = "http://localhost/classhelp/";
        fetch(baseUrl + "map_class_teacher.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              classId: classId,
              teacher: teacher
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log(data.message);
            alert(data.message);
            document.getElementById("mapTeacherClass").reset();
          })
          .catch((error) => console.error("Error:", error));
      });
  </script>
</body>

</html>