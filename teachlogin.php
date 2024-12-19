<?php
session_start(); // Start the session

include("config_json.php");
include("function_room.php");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if input is properly set
if (isset($data['login'], $data['password'])) {
  $login = $data['login'];
  $password = hashString($data['password']);

  // Prepare a statement to check if login exists
  $check_stmt = mysqli_prepare($conn, "SELECT id FROM teacher WHERE email = ? OR mobilenumber = ?");
  if ($check_stmt) {
    // Bind parameters to placeholders
    mysqli_stmt_bind_param($check_stmt, "ss", $login, $login);

    // Execute the statement
    mysqli_stmt_execute($check_stmt);

    // Store the result to check if any row matched
    mysqli_stmt_store_result($check_stmt);

    if (mysqli_stmt_num_rows($check_stmt) > 0) {
      // Close the check statement
      mysqli_stmt_close($check_stmt);

      // Prepare SQL statement with placeholders to validate password
      $stmt = mysqli_prepare($conn, "SELECT id FROM teacher WHERE (email = ? OR mobilenumber = ?) AND `password` = ?");
      if ($stmt) {
        // Bind parameters to placeholders
        mysqli_stmt_bind_param($stmt, "sss", $login, $login, $password);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Bind the result to a variable
        mysqli_stmt_bind_result($stmt, $teacher_id);

        // Store the result and check if any row matched
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
          // Fetch the user ID
          mysqli_stmt_fetch($stmt);

          // Store the user ID in session
          $_SESSION['teacher_id'] = $teacher_id;

          if (getClassCount($conn, $teacher_id) > 1) {
            echo json_encode(["selectclass" => true, "message" => "Login successful!"]);
          } else if (getClassCount($conn, $teacher_id) == 1) {
            echo json_encode(["success" => true, "message" => "Login successful!"]);
            // Store the user ID in session
            $_SESSION['teach_classid'] = getClassId($conn, $teacher_id);
          }
        } else {
          echo json_encode(["failure" => true, "message" => "Incorrect password for this account!", "ww" => "password"]);
        }

        // Free resources and close the statement
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
      } else {
        echo json_encode(["failure" => true, "message" => "Database error!", "ww" => "both"]);
      }
    } else {
      echo json_encode(["failure" => true, "message" => "No account exists with this login!", "ww" => "both"]);
    }
  } else {
    echo json_encode(["failure" => true, "message" => "Database error!", "ww" => "both"]);
  }
} else {
  echo json_encode(["failure" => true, "message" => "Invalid input!", "ww" => "both"]);
}

// Close the database connection
mysqli_close($conn);
