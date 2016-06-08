<?php
  session_start();
  if (!isset($_SESSION['started'])) { 
    header('Location: /');
  } else if (!isset($_SESSION['subjectId'])) {
    header('Location: /survey.php');
  }
  require_once('includes/helper.php');
  $_SESSION['cheatType'] = rand(1,3);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cheating Instructions</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="includes/css/form.css">
		
	</head>
	<body>
		<div class="container">
		<div id="directions">
			<h2>Instructions on Cheating</h2>
			<br>
      <?php
        echo "Cheat type: " . $_SESSION['cheatType'];
      ?>
      ( ͡° ͜ʖ ͡°)
		</div>
    <form action="iat.php">
      <button type="submit" class="btn btn-block" id="cont">Continue to IAT</button>
    </form>
		</div>
	</body>
</html>
