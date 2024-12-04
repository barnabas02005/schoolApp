<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$classId = $data['classId'];
$teacher = $data['teacher'];

$sql = "INSERT INTO `class_teacher` (class_id, `teacher_id`, `status`, date_added) VALUES (?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $classId, $teacher);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Class teacher Mapped class successfully."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
