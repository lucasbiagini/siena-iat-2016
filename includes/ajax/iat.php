<?php 
session_start();
require_once('../helper.php');
require_once ("db.php");
require_once ("math_helper.php");


if (get_magic_quotes_gpc())
  $json = stripslashes($_POST['matrix']);
else
  $json = $_POST['matrix'];
$data = json_decode($json);
$cheatType = $_POST['cheatType'];
$subjectId = $_SESSION['subjectId'];

$iatId = insertIat($mysqli, $subjectId, $cheatType);
insertTrials($mysqli, $iatId, $data);

// Eventually, we will need to make sure they cannot retake the IAT
if ($cheatType == 0) {
  $_SESSION['normalIatTaken'] = true;
} else {
  $_SESSION['cheatIatTaken'] = true;
}


$score = getScore($mysqli, $iatId);
if ($score == null) {
  echo "";
} else {
  // Maybe the rounding should be done client-side
  $_SESSION['score'] = $score;
  echo round($score, 2);
  insertScore($mysqli, $iatId, $score);
}

$mysqli->close();
?>
