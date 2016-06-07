<?php 
  require_once("../helper.php");
  require_once("db.php");

  session_start();
  @header('Content-type: application/json');

  $data = array();
  $dataKeys = array('gender', 'age', 'ethnicity', 'number_iats', 'country',
      'education', 'field', 'background');

  foreach($dataKeys as $key) {
    if (isset($_POST[$key])) {
      $data[$key] = $_POST[$key];
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
