<?php 
  require_once('includes/helper.php');
  session_start(); 
  if (!isset($_SESSION['started'])) {
    header('Location: /');
  } else if (!isset($_SESSION['subjectId'])) {
    header('Location: /survey.php');
  }

  if (isset($_SESSION['iatTaken']) && $_SESSION['cheatType'] == 0) {
    header('Location: /cheat_instructions.php');
  } else if ($_SESSION['cheatType'] == 0) {
    $_SESSION['iatTaken'] = true;
  } else if (isset($_SESSION['cheatIatTaken'])) {
    header('Location: /exit.php');
  } else {
    $_SESSION['cheatIatTaken'] = true;
  }
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

    function startIAT(cheatType) {
      $('#proceedButton').hide();
      console.log('Cheat Type: ' + cheatType);
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
<body onload="startIAT($('#cheatType').html())">
  <?php
    echo "<div id='cheatType' style='display: none;'>$_SESSION[cheatType]</div>";
    if (isset($_GET['mobile']))
      echo "<div id='isMobile' style='display: none;'>$_GET[mobile]</div>";
  ?>
  <div id="leftTouchPanel"  class="touchPanel" style="display:none"></div>
  <div id="rightTouchPanel" class="touchPanel" style="display:none"></div>

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
  <form action="cheat_instructions.php">
    <br>
    <button id="proceedButton" type="submit" class="btn" style="display: none">Proceed</button>
  </form>
	<div id="return"></div>


</body>
</html>
