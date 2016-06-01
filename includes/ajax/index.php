<?php 
	session_start();
  require_once('../helper.php');
	include ("db.php");
	$idPerson = $_POST['idPerson'];

	if ($mysqli->query("SELECT idperson FROM survey WHERE idperson = " . $idPerson)->num_rows > 0) {
		$_SESSION['idPerson'] = $idPerson;
	   echo "success";
	} else {
		echo "error";
	}

	$mysqli->close();

	exit;
?>
