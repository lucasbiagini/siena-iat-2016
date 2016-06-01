<?php 
require_once('helper.php');
// The file path needs to be fixed here
//$credJSON = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/includes/' . "credentials.json");
$credJSON = file_get_contents(get_include_path() . "credentials.json");
//error_log($credJSON);
$vals = json_decode($credJSON, true);
//error_log($vals);
$mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

if ($mysqli->connect_errno) {
  //echo "Connect failed: ".$mysqli->connect_error;

  // Using an absolute path can cause problems from server to server
  $script_path = $_SERVER['DOCUMENT_ROOT'] . "/" . "includes/db_setup.sql";
  $command = "mysql -u{$vals['db_user']} -p{$vals['db_pass']} "
      . "-h {$vals['db_host']} < {$script_path}";

  error_log("Executing " . $command);
  //$output = shell_exec($command . " 2>&1");
  exec($command . " 2>&1", $output);
  error_log("Output: " . implode($output));
  $mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

  if ($mysqli->connect_errno) {
    exit();
  }
}
?>
