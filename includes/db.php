<?php 
require_once('helper.php');

function getMYSQLI() {
  // The file path needs to be fixed here
  $credJSON = file_get_contents(get_include_path() . "credentials.json");
  $vals = json_decode($credJSON, true);
  $mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

  if ($mysqli->connect_errno) {

    // Using an absolute path can cause problems from server to server
    $script_path = $_SERVER['DOCUMENT_ROOT'] . "/" . "includes/db_setup.sql";
    $command = "mysql -u{$vals['db_user']} -p{$vals['db_pass']} "
        . "-h {$vals['db_host']} < {$script_path}";

    //error_log("Executing " . $command);
    exec($command . " 2>&1", $output);
    $mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

    if ($mysqli->connect_errno) {
      exit();
    }
  }
  return $mysqli;
}

$mysqli = getMYSQLI();

/**
 * Returns the insert_id if successful
 */
function insertSurvey($mysqli, $data) {
  //insert the data of the survey into the database
  // The person ID should be auto_incremented by the database
  $stmt = $mysqli->prepare(
      "INSERT INTO subjects (gender, age, ethnicity, number_iats, country, field, background)
      VALUES(?,?,?,?,?,?,?)");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    return -1;
  }
  $stmt->bind_param('sisissi', $data['gender'], $data['age'], $data['ethnicity'],
      $data['number_iats'], $data['country'], $data['field'], $data['background']);
  $stmt->execute();
  return $mysqli->insert_id;
}

?>
