<?php 
	session_start();
	@header('Content-type: application/json');
	/*foreach($_POST as $varname => $value)
    {
        $value = trim($value);
        $value = striptags($value);
        $value = mysql_real_escape_string($value); // use inplace of addslashes
        $value = htmlentities($value);
        $_POST[$varname] = $value;
    }  
    */

    $gender = $_POST['gender'];
    if ($gender == "other") {
    	$gender = $_POST['otherGender'];
    }
	$age = $_POST['age'];
	$ethnicity = $_POST['ethnicity'];
	$numberiats = $_POST['numberIATs'];
	$country = $_POST['countries'];
	$field = $_POST['field'];
	$background = $_POST['background'];

	include ("../db.php");

	$idPerson = $_SESSION['idPerson'];
	//if the user did not insert a valid ID, it generates a random ID
	if (empty($idPerson)) {
		$idPerson = rand(100000,999999);
		$result = $mysqli->query($sql);
		while ($mysqli->query("SELECT idsurvey FROM survey WHERE idperson = " . $idPerson)->num_rows > 0) {
		   $idPerson = rand(100000,999999);
		}
		$_SESSION['idPerson'] = $idPerson;
	}

	//insert the data of the survey into the database
	$query = "INSERT INTO survey (idperson,gender,age,ethnicity,numberiats,country,field,background) VALUES(".$idPerson.",'".$gender."','".$age."','".$ethnicity."','".$numberiats."','".$country."','".$field."','".$background."')";
	$insert_row = $mysqli->query($query);

	if($insert_row){
		$idSurvey = $mysqli->insert_id;
		$_SESSION['idSurvey'] = $idSurvey;

	    $response_array['status'] = 'success'; 
	    $response_array['msg'] = $idPerson;
	}else {
	    $response_array['status'] = 'error';  
	    $response_array['msg'] = "Error to save the survey. Please, try again. Error: ".$mysqli->error;
	}

	$mysqli->close();

	echo json_encode($response_array);

	exit;
?>