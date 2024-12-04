<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $studentId = $_POST['studentid'];
  $subjectId = $_POST['subjectid'];
  $topicid = $_POST['topicid'];
  $formats = $_POST['format'];
  $questionids = $_POST['questionid'];
  $reviews = $_POST['review'];

  include("config.php");

  // Prepare SQL statement with placeholders
  $sql = "INSERT INTO review (student_id, subject_id, question_format, question_id, review, `status`, date_added) VALUES (?, ?, ?, ?, ?, 1, Now())";
  $stmt = mysqli_prepare($conn, $sql);

  if (!$stmt) {
    die("Preparation failed: " . mysqli_error($conn));
  }

  // Bind parameters and loop through each question-review pair
  mysqli_stmt_bind_param($stmt, "iiiis", $studentId, $subjectId, $format, $questionid, $review);

  // Adjust to process the associative `review` array
  foreach ($questionids as $index => $questionid) {
    $format = $formats[$index];
    $review = $reviews[$questionid] ?? null;  // Use question ID as the key to get the review value

    if ($review === null) {
      echo "Warning: Review for question ID $questionid is missing.";
      continue; // Skip this entry if no review is provided
    }

    // Execute the prepared statement for each question-review pair
    mysqli_stmt_execute($stmt);
  }

  // Close statement and connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

  echo "Data submitted successfully!";
}
