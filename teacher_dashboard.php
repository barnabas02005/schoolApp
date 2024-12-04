<?php
session_start();
include("config.php");
include("function_room.php");

$teacherData = null;
$subjectData = [];

// CHECK IF teach_classid is not set as a session yet
if (!isset($_SESSION['teach_classid'])) {
  header("Location: t_selectclass.php");
}

if (isset($_SESSION['teacher_id']) && isset($_SESSION['teach_classid'])) {
  $teacher_id = $_SESSION['teacher_id'];
  $class_id = $_SESSION['teach_classid'];

  // Fetch student data
  $getTeacherData = "SELECT * FROM teacher WHERE id = $teacher_id AND `status` = '1'";
  $getTeacherDataResult = mysqli_query($conn, $getTeacherData);
  if ($getTeacherDataResult && mysqli_num_rows($getTeacherDataResult) > 0) {
    $teacherData = mysqli_fetch_assoc($getTeacherDataResult);
  }

  $allStudents = getStudents($conn, $class_id);


  // Fetch subjects
  $getSubjectData = "SELECT * FROM subject WHERE `status` = '1'";
  $getSubjectDataResult = mysqli_query($conn, $getSubjectData);
  while ($row = mysqli_fetch_assoc($getSubjectDataResult)) {
    $subjectData[] = $row;
  }
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
  <title>Teacher | Dashboard</title>
</head>

<body>
  Total class count for this teacher <?= getClassCount($conn, $teacher_id); ?>
  <br />
  <br />
  Total number of student in this class <?= getStudents($conn, $class_id, "count"); ?>
  <br />
  <br />
  <?php foreach ($allStudents as $student): ?>
    <span><?= htmlspecialchars($student['firstname']); ?></span>&nbsp; <span><?= htmlspecialchars($student['lastname']); ?></span>
    <br />
    <br />
  <?php endforeach; ?>

  <h1>Students review</h1>
</body>

</html>