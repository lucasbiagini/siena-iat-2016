<?php 
$vals['db_host'] = "localhost";
$vals['db_user'] = "sienasel_iat";
$vals['db_pass'] = "SienaIAT!";
$vals['db_name'] = "sienasel_iat";
$mysqli = new mysqli($vals['db_host'], $vals['db_user'], $vals['db_pass'], $vals['db_name']);

if ($mysqli->connect_errno) {
  //echo "Connect failed: ".$mysqli->connect_error;

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
