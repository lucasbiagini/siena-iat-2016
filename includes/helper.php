<?php
set_include_path($_SERVER['DOCUMENT_ROOT'] . "/" . "includes/");

function get_path($arg) {
  $PATHS =  json_decode(file_get_contents("paths.json", true), true);
  return $PATHS[$arg];
}

?>
