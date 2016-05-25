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

	var concept1   = ["Apps", "Computer", "Algorithm", "Database", "Internet", "Programming", "Software", "Technology"];
	var concept2   = ["Nature", "Life", "Photosynthesis", "Habitat", "Organs", "Plants", "Species", "Protein"];
	var attribute1 = ["Mary", "Patricia", "Jennifer", "Elizabeth", "Linda", "Barbara", "Susan", "Margaret"];
	var attribute2 = ["James", "John", "Robert", "Michael", "William", "David", "Richard", "Joseph"];
	
	$(document).ready(function(){
    iat({1:"Computer Science", 2:"Biology"},
        {1:"Female", 2:"Male"},
        {concept1:concept1, concept2:concept2, attribute1:attribute1, attribute2:attribute2});		
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
	<p id="error"><img src="images/error.png" width="100" height="100" alt="Error"></p>
	<p id="start">Press the spacebar to begin.</p>
	<div id="return"></div>


</body>
</html>
