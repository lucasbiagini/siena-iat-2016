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
 * Returns the insert_id as the subject_id if successful
 */
function insertSurvey($mysqli, $data) {
  //insert the data of the survey into the database
  // The person ID should be auto_incremented by the database
  $stmt = $mysqli->prepare(
      "INSERT INTO subjects (gender, age, ethnicity, number_iats, country, field, background)
      VALUES(?,?,?,?,?,?,?)");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    error_log($mysqli->error);
    return -1;
  }
  $stmt->bind_param('sisissi', $data['gender'], $data['age'], $data['ethnicity'],
      $data['number_iats'], $data['country'], $data['field'], $data['background']);
  $stmt->execute();
  return $mysqli->insert_id;
}

/**
 * Returns the insert_id as the iad_id if successful
 */
function insertIat($mysqli, $subjectId, $cheatType){
  $stmt = $mysqli->prepare(
      "INSERT INTO iats (subject_id, cheat_type)
      VALUES(?,?)");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    error_log($mysqli->error);
    return -1;
  }
  $stmt->bind_param('ii', $subjectId, $cheatType);
  $stmt->execute();
  return $mysqli->insert_id;
}

function insertTrials($mysqli, $iatId, $data) {
  // The shape of the matrix is (block number,
  // [word shown, respone time, correct, word's con/attr], trial number]

  $stmt = $mysqli->prepare("INSERT INTO trials
      (iat_id, trial_number, response_time, item, category, error, block) 
      VALUES (?,?,?,?,?,?,?)");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    error_log($mysqli->error);
    return -1;
  }
  $numBlocks = count($data);
  for ($i = 0; $i < $numBlocks; $i++) {
    $numTrials = count($data[$i][0]);
    for ($j = 0; $j < $numTrials; $j++) {
      // Blocks are 1 indexed in the DB
      $blockNum = $i + 1;
      $stmt->bind_param('iidssii',
          $iatId, $j, $data[$i][1][$j], $data[$i][0][$j], $data[$i][3][$j], $data[$i][2][$j], $blockNum);
      $stmt->execute();
      if ($mysqli->error) {
        error_log($mysqli->error);
      }
    }
  }
  return 0;
}
?>
