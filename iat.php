<?php 
session_start(); 
if (empty($_SESSION['idIat']) || empty($_SESSION['idPerson']	)) {
	header( 'Location: /');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Implicit Association Test Example</title>
	<meta charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="iat.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>

	var male = ["James", "John", "Robert", "Michael", "William", "David", "Richard", "Joseph"];
	var female = ["Mary", "Patricia", "Jennifer", "Elizabeth", "Linda", "Barbara", "Susan", "Margaret"];
	var compsci = ["Apps", "Computer", "Algorithm", "Database", "Internet", "Programming", "Software", "Technology"];
	var bio = ["Nature", "Life", "Photosynthesis", "Habitat", "Organs", "Plants", "Species", "Protein"];
	
	$(document).ready(function(){
		iat("Computer Science", "Biology", "Female", "Male", compsci, bio, female, male);		
	});	
	</script>
</head>
<body>
	<p id="directions"></p>
	
	<div id="associate">
		<div id="left"></div>
		<div id="right"></div>
	</div>
	<div id="results"></div>
	<div style="clear:both"></div>
	<p id="console"></p>
	<p id="error"><img src="images/error.png" width="200" height="200" alt="Error"></p>
	<p id="start">Press 'spacebar' to begin.</p>
	<div id="return"></div>


</body>
</html>
