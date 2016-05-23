<?php 
	session_start();
	$idPerson = $_POST['idPerson'];
	include ("../db.php");

	if ($mysqli->query("SELECT idperson FROM survey WHERE idperson = " . $idPerson)->num_rows > 0) {
		$_SESSION['idPerson'] = $idPerson;
	   echo "success";
	} else {
		echo "error";
	}

	$mysqli->close();

	exit;
?>