<?php
include("config_json.php");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if subject_id is provided
if (isset($data['subject_id'])) {
  $subject_id = intval($data['subject_id']);
  $class_id = intval($data['class_id']);

  // Fetch topics related to the subject_id
  $query = "SELECT * FROM topic WHERE subject_id = ? AND class_id = ? AND `status` = '1'";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ii", $subject_id, $class_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $topics = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $topics[] = [
      "name" => $row['title'],
      "id" => $row['id']
    ];
  }

  echo json_encode($topics);

  mysqli_stmt_close($stmt);
} else {
  echo json_encode(["error" => "Invalid subject ID"]);
}

mysqli_close($conn);
