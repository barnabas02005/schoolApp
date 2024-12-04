<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$subjectname = $data['subjectname'];
$theme = $data['theme'];

$sql = "INSERT INTO `subject` (subject_name, theme, `status`, date_added) VALUES (?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $subjectname, $theme);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Subject added successfully."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
