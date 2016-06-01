<?php 
require_once('includes/helper.php');
session_start(); 
/* Changed for DEBUGGING
if (empty($_SESSION['idIat']) || empty($_SESSION['idPerson']	)) {
	header( 'Location: /');
}
 */
?>
<!DOCTYPE html>
<html>
<head>
	<title>Implicit Association Test Example</title>
	<meta charset="utf-8">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="includes/js/iat.js"></script>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" id="bootstrapCSS">
	<link rel="stylesheet" type="text/css" href="includes/css/theme.css">
	<script>

    function startCheatIAT() {
      $('#proceedButton').hide();
      startIAT($('#cheatType').html());
    }

    function startIAT(cheatType) {
      $('#proceedButton').hide();
      var concept1   = ["Apps", "Computer", "Algorithm", "Database", "Internet", "Programming", "Software", "Technology"];
      var concept2   = ["Nature", "Life", "Photosynthesis", "Habitat", "Organs", "Plants", "Species", "Protein"];
      var attribute1 = ["James", "John", "Robert", "Michael", "William", "David", "Richard", "Joseph"];
      var attribute2 = ["Mary", "Patricia", "Jennifer", "Elizabeth", "Linda", "Barbara", "Susan", "Margaret"];
    
      var isMobile = ($('#isMobile').html() === '1');
      //$(document).ready(function(){
        iat({1:"Computer Science", 2:"Biology"},
            {1:"Male", 2:"Female"},
            {concept1:concept1, concept2:concept2, attribute1:attribute1, attribute2:attribute2},
            cheatType,
            isMobile);		
      //});	
    }
	</script>
</head>
<body onload="startIAT(0)">
  <?php
    $cheatType = rand(1,3);
    echo "<div id='cheatType' style='display: none;'>$cheatType</div>";
    if (isset($_GET['mobile']))
      echo "<div id='isMobile' style='display: none;'>$_GET[mobile]</div>";
  ?>
  <div id="leftTouchPanel"  class="touchPanel"></div>
  <div id="rightTouchPanel" class="touchPanel"></div>

	<p id="directions"></p>
	
	<div id="associate">
		<div id="left"></div>
		<div id="right"></div>
	</div>
	<div style="clear:both"></div>
	<p id="console"></p>
	<p id="error" style="display: none"><img src="media/error.png" width="100" height="100" alt="Incorrect Answer"></p>
	<div id="results" style="display: none"></div>
	<p id="start">Press the spacebar to begin.</p>
  <button id="proceedButton" class="btn" style="display: none" onclick="startCheatIAT()">Proceed</button>
	<div id="return"></div>


</body>
</html>
