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
  <title>Add Options</title>
</head>

<body>
  <form id="addOptionForm">
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
    <label>Option: <textarea id="option"></textarea></label><br /><br><br>
    <span>1 -- positive</span><br>
    <span>0 -- Negative</span><br>
    <span>2 -- Neutral</span>
    <br /><br />
    <label>Sentiment: <input type="number" id="sentiment"></label><br /><br><br>
    <button type="submit">Submit</button>
  </form>

  <script>
    document
      .getElementById("addOptionForm")
      .addEventListener("submit", async function(e) {
        e.preventDefault();

        const format = document.getElementById("format").value;
        const option = document.getElementById("option").value;
        const sentiment = document.getElementById("sentiment").value;


        // Send the class name and hashed password to the server
        fetch("save_option.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
              format: format,
              option: option,
              sentiment: sentiment
            }),
          })
          .then((response) => response.json())
          .then((data) => {
            console.log(data.message);
            alert(data.message);
            document.getElementById("addOptionForm").reset();
          })
          .catch((error) => console.error("Error:", error));
      });
  </script>
</body>

</html>