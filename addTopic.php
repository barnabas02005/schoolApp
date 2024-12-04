<?php
include("config.php");
error_reporting(0);
ini_set('display_errors', '0');

// Get the subject and class names from the URL and decode them
$subjectId = isset($_GET['subject']) ? urldecode(htmlspecialchars($_GET['subject'])) : '';
$class_Id = isset($_GET['class']) ? urldecode(htmlspecialchars($_GET['class'])) : '';

$dataSubject = null;
$dataClass = null;


$getSubject = "SELECT * FROM `subject` WHERE id = $subjectId";
$getSubjectResult = mysqli_query($conn, $getSubject);
if ($getSubjectResult && mysqli_num_rows($getSubjectResult) > 0) {
  $dataSubject = mysqli_fetch_assoc($getSubjectResult);
}

// Fetch the class data
$getClass = "SELECT * FROM `class` WHERE id = $class_Id";
$getClassResult = mysqli_query($conn, $getClass);
if ($getClassResult && mysqli_num_rows($getClassResult) > 0) {
  $dataClass = mysqli_fetch_assoc($getClassResult);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Topic | <?php echo $dataSubject['subject_name']; ?></title>
  <script src="http://localhost/classhelp/route.js" defer></script>
</head>

<body>
  <h1>Add a Topic for <?php echo htmlspecialchars($dataSubject['subject_name']); ?> in <?php echo htmlspecialchars($dataClass['classname']); ?></h1>
  <!-- You can add your form or topic input logic here -->
  <form id="addTopicForm">
    <input type="hidden" id="subjectId" value="<?php echo htmlspecialchars($dataSubject['id']); ?>" />
    <input type="hidden" id="classId" value="<?php echo htmlspecialchars($dataClass['id']); ?>" />

    <label>Topic Title: <input type="text" id="title" required /></label><br /><br />
    <label>Description: <textarea id="description"></textarea></label><br /><br />
    <button type="submit">Submit</button>
  </form>

  <script>
    document.getElementById("addTopicForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const subjectId = document.getElementById("subjectId").value;
      const classId = document.getElementById("classId").value;
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;

      // Send the class name and hashed password to the server
      let baseUrl = "http://localhost/classhelp/";
      fetch(baseUrl + "save_topic.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            subjectId: subjectId,
            classId: classId,
            title: title,
            description: description,
          }),
        })
        .then((response) => response.json())
        .then((data) => {
          console.log(data.message);
          alert(data.message);
          document.getElementById("addTopicForm").reset();
        })
        .catch((error) => console.error("Error:", error));
    });
  </script>
</body>

</html>