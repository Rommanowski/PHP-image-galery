<?php
    include_once 'static/partials/options.php';
?>

<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8">
  <title>PHP_Register</title>
</head>
 <body>
 
  <form  method="POST" action = "front_controller.php?action=/register">
   <label for="login">Login:</label><br>
   <input type="text" name="login" required /><br />
   <label for="pass">Password:</label><br>
   <input type="password" name="pass" required /><br />
   <label for="repeat_pass">Repeat password:</label><br>
   <input type="password" name="repeat_pass" required /><br />
   <input type="submit" value="Submit">
  </form>

  <?php 
    $blad = isset($_GET['error']) ? urldecode($_GET['error']) : "";
    echo "<p style='color:red'>$blad</p>";
  ?>
 </body>
</html>