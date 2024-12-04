<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="route.js" defer></script>
</head>
<?php
include("config.php");
$getallClass = "SELECT * FROM class";
$getallClassResult = mysqli_query($conn, $getallClass);
while ($row = mysqli_fetch_assoc($getallClassResult)) {
?>
  <a href="/classhelp/manageclass/class/<?php echo $row['id']; ?>">Manage <?php echo $row['classname']; ?></a>
  <br />
  <br />
<?php
}
?>

<body></body>



</html>