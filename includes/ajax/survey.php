<?php 
  require_once("../helper.php");
  require_once("db.php");

  session_start();
  @header('Content-type: application/json');

  $data = array();
  $dataKeys = array('gender', 'age', 'ethnicity', 'numberIATs', 'countries',
      'field', 'background');

  // The sanitization is probably not necessary with prepared statements
  foreach($dataKeys as $key) {
    if (isset($_POST[$key])) {
      $value = $_POST[$key];
      $value = trim($value);
      //$value = striptags($value);
      $value = $mysqli->real_escape_string($value); // use inplace of addslashes
      $value = htmlentities($value);
      $data[$key] = $value;
    } else {
      $data[$key] = null;
    }
  }

  $result = insertSurvey($mysqli, $data);
  if ($result == -1) {
    $response_array['status'] = false;  
  } else {
    $_SESSION['subjectId'] = $result;
    $response_array['status'] = true; 
  }

  $mysqli->close();
  echo json_encode($response_array);
  exit;
?>
