<?php 
require_once(dirname(__FILE__) . '/' . 'helper.php');

function getMYSQLI() {
  $credJSON = file_get_contents(get_path("home"). ".iat/"  . "credentials.json");
  $vals = json_decode($credJSON, true);
  $mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

  if ($mysqli->connect_errno) {

    // Using an absolute path can cause problems from server to server
    $script_path = get_path('root') . "includes/db_setup.sql";
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
  $stmt = $mysqli->prepare(
      "INSERT INTO subjects (gender, age, ethnicity, number_iats, country, education, field, background)
      VALUES(?,?,?,?,?,?,?,?)");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    error_log($mysqli->error);
    return -1;
  }
  $stmt->bind_param('sisisiii', $data['gender'], $data['age'], $data['ethnicity'],
      $data['number_iats'], $data['country'], $data['education'], $data['field'], $data['background']);
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

function insertTrialsPrepared($mysqli, $iatId, $data) {
  // The shape of the matrix is (block number,
  // [word shown, respone time, correct, word's con/attr], trial number)

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

function insertTrials($mysqli, $iatId, $data) {

  $sqlString = "INSERT INTO trials "
      . " (iat_id, trial_number, response_time, item, category, error, block)"
      . " VALUES ";

  $numBlocks = count($data);
  for ($i = 0; $i < $numBlocks; $i++) {
    $numTrials = count($data[$i][0]);
    for ($j = 0; $j < $numTrials; $j++) {
      // Blocks are 1 indexed in the DB
      $blockNum = $i + 1;
      $time = $data[$i][1][$j];
      $item = $data[$i][0][$j];
      $cat = $data[$i][3][$j];
      $err = $data[$i][2][$j];
      $sqlString .= "($iatId, $j, $time, '$item', '$cat', $err, $blockNum),";
    }
  }
  $sqlString = trim($sqlString, ",");
  $mysqli->query($sqlString);
  if ($mysqli->error) {
    error_log($sqlString);
    error_log($mysqli->error);
  }
  

  return 0;
}

function getScore($mysqli, $iatId) {
  $query = sqlFinalScore($iatId, array(3,6), array(4,7), false);  
  $result = $mysqli->query($query);
  if ($result) {
    $array = $result->fetch_row();
    return $array[0]; 
  } else {
    return null;
  }
}

function insertScore($mysqli, $iatId, $score) {
  $stmt = $mysqli->prepare(
      "UPDATE iats SET score = ? WHERE iat_id = ?");
  if ($stmt == false) {
    error_log('The statement was not able to be prepared.');
    error_log($mysqli->error);
    return -1;
  }
  $stmt->bind_param('di', $score, $iatId);
  $stmt->execute();
}

// Future query
// DELETE FROM subjects WHERE NOT EXISTS (SELECT * FROM iats WHERE subjects.subject_id = iats.subject_id);

?>
