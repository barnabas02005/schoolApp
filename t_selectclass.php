<?php
session_start();
include("config.php");
include("function_room.php");

$teacherData = null;
$subjectData = [];

if (isset($_SESSION['teacher_id'])) {
  $teacher_id = $_SESSION['teacher_id'];
  $allClasses = getClass($conn, $teacher_id);
} else {
  // echo "Please log in.";
  header("Location: teacher_login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Select Class</title>
</head>

<body>
  <h1>Select one of your classes</h1>
  <?php foreach ($allClasses as $class): ?>
    <li class="setSessionClassId" data-classid="<?= $class['id']; ?>"><?= htmlspecialchars($class['classname']) ?></li>
  <?php endforeach; ?>

  <script>
    const items = document.querySelectorAll('.setSessionClassId');

    items.forEach(item => {
      item.addEventListener('click', function() {
        const classId = this.getAttribute('data-classid');
        submtiData(classId);
      });
    })

    function submtiData(classId) {
      fetch('setClassSession.php', {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            classId: classId
          })
        })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert(data.message);
            window.location.href = "teacher_dashboard.php";
          } else {
            if (!data.success) {
              alert(data.message);
            }
          }
        })
        .then((error) => {
          console.error(error);
        })
    }
  </script>
</body>

</html>