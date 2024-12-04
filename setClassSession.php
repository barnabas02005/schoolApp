<?php
session_start();
include("config_json.php");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if input is properly set
if (isset($data['classId'])) {
  $classId = $data['classId'];

  // Check if a session variable already exists and destroy it
  if (isset($_SESSION['teach_classid'])) {
    unset($_SESSION['teach_classid']);
  }

  // Set session variable
  $_SESSION['teach_classid'] = $classId;

  // Verify if session variable is actually set
  if (isset($_SESSION['teach_classid']) && $_SESSION['teach_classid'] === $classId) {
    echo json_encode(["success" => true, "message" => "Session set successful!"]);
  } else {
    echo json_encode(["success" => false, "message" => "Failed to set session!"]);
  }
} else {
  echo json_encode(["success" => false, "message" => "Invalid input!"]);
}
