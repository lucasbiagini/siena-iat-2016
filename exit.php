<?php
  session_start();
  if (!isset($_SESSION['started'])) {
    header('Location: /');
  }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Implicit Association Test </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="includes/css/form.css">
		
	</head>
	<body>
		<div class="container">
		<div id="directions">
			<h2>Thank you for your participation. You may now close this window.</h2>
		</div>
		</div>
	</body>
</html>
