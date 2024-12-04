<?php
include("config_json.php");

$data = json_decode(file_get_contents("php://input"), true);

$format = $data['format'];
$option = $data['option'];
$sentiment = $data['sentiment'];

$sql = "INSERT INTO `options` (question_format, `option`, sentiment, `status`, date_added) VALUES (?, ?, ?, 1, NOW())";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isi", $format, $option, $sentiment);

if (mysqli_stmt_execute($stmt)) {
  echo json_encode(["message" => "Option added successfully."]);
} else {
  echo json_encode(["message" => "Error: " . mysqli_error($conn)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
