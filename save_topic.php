<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$subjectId = isset($data['subjectId']) ? (int)$data['subjectId'] : null;
$classId = isset($data['classId']) ? (int)$data['classId'] : null;
$title = isset($data['title']) ? htmlspecialchars($data['title'], ENT_QUOTES, 'UTF-8') : null;
$description = isset($data['description']) ? htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8') : null;


$sql = "INSERT INTO topic (`subject_id`, `class_id`, `title`, `description`, `status`, `date_added`) VALUES (?, ?, ?, ?, '1', NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $subjectId, $classId, $title, $description);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Topic added successfully."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
