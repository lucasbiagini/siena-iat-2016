<?php 
session_start();
require_once('../helper.php');
require_once ("db.php");
require_once ("math_helper.php");

$data = json_decode($_POST['matrix']);
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
  echo round($score, 2);
  insertScore($mysqli, $iatId, $score);
}

$mysqli->close();
?>
