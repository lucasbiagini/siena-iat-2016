<?php
  if (session_id() != '')
    session_destroy();
  session_start();
  require_once('includes/helper.php');
  $_SESSION['started'] = true;
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
			<h2>You have opted to complete the Computer Science/Biology IAT.</h2>
			<br>
			<p>You will complete two tasks: a short survey about yourself and an IAT in which you will sort words into categories as quickly as possible. You should be able to complete the tasks in less than 10 minutes total. When you finish, you will receive your results as well as more information about the test and the performance of others.</p>
		</div>
    <form action="survey.php">
      <button type="submit" class="btn btn-block" id="cont">Continue to survey</button>
    </form>
		</div>
	</body>
</html>
