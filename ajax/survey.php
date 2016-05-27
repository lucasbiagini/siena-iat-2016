<?php 
  require_once("../includes/helper.php");
  require_once("../db.php");

  session_start();
  @header('Content-type: application/json');

  $data = array();
  $dataKeys = array('gender', 'age', 'ethnicity', 'numberIATs', 'countries',
      'field', 'background');

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

  //insert the data of the survey into the database
  // The person ID should be auto_incremented by the database
  $query = "INSERT INTO survey (gender,age,ethnicity,numberIATs,
      country,field,background) VALUES('".$data['gender']."','".$data['age']."','"
      .$data['ethnicity']."','".$data['numberIATs']."','".$data['countries']."','"
      .$data['field']."','".$data['background']."')";
  $insert_row = $mysqli->query($query);

  if($insert_row){
    $_SESSION['idPerson'] = $mysqli->insert_id;
      $response_array['status'] = true; 
  } else {
      $response_array['status'] = false;  
  }

  $mysqli->close();

  // Not sure why this is here
  echo json_encode($response_array);

  exit;
?>
