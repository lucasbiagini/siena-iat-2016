<?php 
	session_start();
  require_once('../helper.php');
	include ("db.php");
	$idPerson = $_SESSION['idPerson'];

	$query = "INSERT INTO iat (idperson) VALUES(".$idPerson.")";
	$insert_row = $mysqli->query($query);

	if($insert_row){
		$idIat = $mysqli->insert_id;
		$_SESSION['idIat'] = $idIat;
	    echo "success";
	}else {
	    echo "error";
	}
	$mysqli->close();

	exit;
?>
