<?php

function getClassCount($conn, $teacherId)
{
  $query = "SELECT COUNT(*) AS count_class FROM class_teacher WHERE teacher_id = $teacherId AND `status` = '1'";
  $response = mysqli_query($conn, $query);
  if ($response && mysqli_num_rows($response) > 0) {
    $row = mysqli_fetch_assoc($response);
    return $row['count_class'];
  }
  // Return 0 if there was an issue with the query or no rows were found
  return -1;
}

function getClassId($conn, $teacherId)
{
  $query = "SELECT * FROM class_teacher WHERE teacher_id = $teacherId AND `status` = '1'";
  $response = mysqli_query($conn, $query);
  if ($response && mysqli_num_rows($response) > 0) {
    $row = mysqli_fetch_assoc($response);
    return $row['class_id'];
  }
  // Return 0 if there was an issue with the query or no rows were found
  return -1;
}

function getClass($conn, $teacherId, $flag = "non")
{
  if ($flag === "all") {
    $data = [];
    $query = "SELECT * FROM `class` WHERE `status` = '1'";
    $response = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($response)) {
      $data[] = $row;
    }
    return $data;
  } else {
    $data = [];
    $query = "SELECT * FROM `class_teacher` WHERE teacher_id = $teacherId AND `status` = '1'";
    $response = mysqli_query($conn, $query);

    if ($response) {
      while ($row = mysqli_fetch_assoc($response)) {
        $classId = $row['class_id'];

        // Run the inner query to get details from `class`
        $query2 = "SELECT * FROM `class` WHERE id = $classId AND `status` = '1'";
        $response2 = mysqli_query($conn, $query2);

        // Fetch all rows from the `class` table matching the class ID
        if ($response2) {
          while ($row2 = mysqli_fetch_assoc($response2)) {
            $data[] = $row2;
          }
        }
      }
    }
    // Check the collected data
    return $data;
  }
  // Return 0 if there was an issue with the query or no rows were found
  return -1;
}

function getStudents($conn, $classId, $flag = "non")
{
  if ($flag === "count") {
    $query = "SELECT COUNT(*) AS count_student FROM student WHERE class = $classId AND `status` = '1'";
    $response = mysqli_query($conn, $query);
    if ($response && mysqli_num_rows($response) > 0) {
      $row = mysqli_fetch_assoc($response);
      return $row['count_student'];
      echo $row['count_student'];
    } else {
      return -1;
    }
  } else {
    $data = [];
    $query = "SELECT * FROM `student` WHERE class = '$classId' AND `status` = '1'";
    $response = mysqli_query($conn, $query);
    if ($response) {
      while ($row = mysqli_fetch_assoc($response)) {
        $data[] = $row;
      }
      return $data;
    }
  }
  return -1;
}

// Function to retrieve all subjects from the database
function getSubjects($conn)
{
  $data = [];
  $query = "SELECT * FROM `subject` WHERE `status` = '1'";
  $response = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($response)) {
    $data[] = $row;
  }
  return $data;
}

// Function to retrieve all teachers from the database
function getTeachers($conn)
{
  $data = [];
  $query = "SELECT * FROM `teacher` WHERE `status` = '1'";
  $response = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($response)) {
    $data[] = $row;
  }
  return $data;
}


// Function to retrieve all student review from the database
function getReview($conn)
{
  $data = [];
  $query = "SELECT * FROM `review` WHERE student_id `status` = '1'";
  $response = mysqli_query($conn, $query);
  while ($row = mysqli_fetch_assoc($response)) {
    $data[] = $row;
  }
  return $data;
}



function hashString($string)
{
  return hash('sha256', $string);
}
