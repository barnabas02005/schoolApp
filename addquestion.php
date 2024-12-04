<?php
include("config.php");

$dataQuestionFormat = [];
$selectQuestionFormat = "SELECT * from question_formats WHERE `status` = 1";
$selectQuestionFormatResult = mysqli_query($conn, $selectQuestionFormat);
while ($row = mysqli_fetch_assoc($selectQuestionFormatResult)) {
  $dataQuestionFormat[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Add Questions</title>
</head>

<body>
  <form id="addQuestionForm">
    <br><br><br><br><br><br><br><br>
    <label for="formatoption">Select question format:
      <select id="format">
        <?= $dataQuestionFormat['id']; ?>
        <?php foreach ($dataQuestionFormat as $format): ?>
          <option value="<?= htmlspecialchars($format['id']); ?>"><?= htmlspecialchars($format['type']); ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <br><br><br><br>
    <label>Question: <textarea id="question"></textarea></label><br /><br><br>
    <button type="submit">Submit</button>
  </form>

  <script>
    document
      .getElementById("addQuestionForm")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const format = document.getElementById("format").value;
        const question = document.getElementById("question").value;


        // Send the class name and hashed password to the server
        fetch("save_question.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              format: format,
              question: question
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log(data.message);
            alert(data.message);
            document.getElementById("addQuestionForm").reset();
          })
          .catch((error) => console.error("Error:", error));
      });
  </script>
</body>

</html>