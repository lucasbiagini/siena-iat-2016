<?php 
session_start();
include ("../db.php");

$data = json_decode($_POST['matrix']);
$iatType = $_POST['type'];
$categories_order = $_POST['categories_order'];
/*
//if the user did not insert a valid ID, it generates a random ID
if (empty($idPerson)) {
	$idPerson = rand(100000,999999);
	$result = $mysqli->query($sql);
	while ($mysqli->query("SELECT idsurvey FROM survey WHERE idperson = " . $idPerson)->num_rows > 0) {
	   $idPerson = rand(100000,999999);
	}
}
	
//insert the data of the survey into the database
$insert_row = $mysqli->query("INSERT INTO survey (idperson) VALUES(".$idPerson.")");

if($insert_row){
    $idSurvey = $mysqli->insert_id ;
}else{
    echo "Error to save the survey. Please, try again.";
    exit;
}
*/
$idIat = $_SESSION['idIat'];
$idPerson = $_SESSION['idPerson'];

//prepare the data of the iat before save it
$values_mysql = "";
$array_csv = array();
$array_csv[] = array("Seq Number", "Trial Number", "Response Time", "Item", "Category", "Error","Block");
$seq_number = 1;
$trial_number = 1;
foreach ($data as $key => $block) {
	for ($i=0; $i < count($block[0]); $i++) {
		$item = $block[0][$i];
		$responseTime = $block[1][$i];
		$error = $block[2][$i];
		$category = $block[3][$i];

		//create the array to save the data into the csv file
		$array_csv[] = array($seq_number, $trial_number, $responseTime, $item, $category, $error, ($key+1));

		//create the string to do the insert into the database
		if ($seq_number == 1) {
			$values_mysql .= "(" . $idIat  . "," . $seq_number . "," . $trial_number . "," . $responseTime . ",'" . $item . "','"  . $category . "'," . $error . "," . ($key + 1) . ")" ;
		} else {
			$values_mysql .= ",(" . $idIat . "," . $seq_number . "," . $trial_number . "," . $responseTime . ",'" . $item . "','"  . $category . "'," . $error . "," . ($key + 1) . ")" ;
		}
		if ($error == 0) {
			$trial_number++;
		}
		$seq_number++;
	}
}

//insert the data of the iat into the database
if (!$mysqli->query("INSERT INTO trials (idiat, trial_seq, trial_number, response_time, item, category, error, block) VALUES ".$values_mysql."")) {
    echo "Multi-INSERT failed: (" . $mysqli->errno . ") " . $mysqli->error;
} else {
	//echo "Success! The data was saved in the database and in the csv file. Do not forget to save your ID ".$idPerson.".";
	echo "Do not forget to save your ID ".$idPerson.".";
}

//functions used for scoring algorithm

//finds average of given array
function findAvg($array){
	$size = count($array);

	$sum = 0;
	foreach($array as $val){
		$sum = $sum + $val;
	}

	$avg = $sum / $size;
	
	return $avg;
}



//finds the standard deviation of a given array
function findSD($array, $size){
	$mean = findAvg($array);

	$sum = 0;
	foreach($array as $val){
		$sub = $val - $mean;
		$sq = $sub * $sub;
		$sum = $sum + $sq;
	}

	$div = $sum / $size;

	$sD = sqrt($div);

	return $sD;
}



// find the pooled standard deviation given two SDs and the size of the groups
function findPooledSD($rtsNum1, $rtsNum2, $sD1, $sD2){
	$num1 = ($rtsNum1 - 1) * ($sD1 * $sD1);
	$num2 = ($rtsNum2 - 1) * ($sD2 * $sD2);
	$num3 = ($rtsNum1 + $rtsNum2) - 2;

	$num4 = ($num1 + $num2) / $num3;
	$pooledSD = sqrt($num4);

	return $pooledSD;

}


//throw out iat where 12 or more response times > 10 and where 12 or more response times < 0.3

//calculate number of response times > 10.0
$greaterRT = $mysqli->query("SELECT response_time, sum(error) as number_errors FROM trials as A where idiat = " . $idIat . " and (block = 3 or block = 4 or block = 6 or block = 7) and response_time > 10.0 group by trial_number");
$tooLong = array();
while($gTimes = mysqli_fetch_array($greaterRT, MYSQLI_ASSOC)){
	$tooLong[] = $gTimes['response_time'];
}
$numGreater = count($tooLong);


//calculate the number of response times < 0.3
$lessRT = $mysqli->query("SELECT response_time, sum(error) as number_errors FROM trials as A where idiat = " . $idIat . " and (block = 3 or block = 4 or block = 6 or block = 7) and response_time < 0.3 group by trial_number");
$tooShort = array();
while($lTimes = mysqli_fetch_array($lessRT, MYSQLI_ASSOC)){
	$tooShort[] = $lTimes['response_time'];
}
$numLess = count($tooShort);


if ($numGreater >= 12) {
	echo " Your response times were too slow to calculate a score.";  
} elseif ($numLess >= 12) {
	echo " Your response times were too fast to calculate a score.";
} else {
	

//testing arrays for scoring algorithm
/*
$arr3 = array(9.988889999, 9.988889999, 9.999999999, 9.889999999, 9.999999999, 9.999999999, 8.999999999, 9.999999999, 9.999999999, 9.889999999, 9.999988899, 9.999999999, 9.997779999, 9.999999999, 9.999999999, 9.977779999, 9.999999999, 9.999999999, 9.999999999, 9.999999999);
$arr4 = array(8.999999999, 9.999888899, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.888889999, 9.999999999, 9.999999999, 9.999999999, 8.999988899, 9.999999888, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.999999999, 9.99889999, 9.999999999, 9.999999999, 9.999999999);
$arr6 = array(0.3000110001, 0.4000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3008740001, 0.3000000001, 0.3000111001, 0.4000000001, 0.3000111111, 0.3000000001, 0.3000000001,0.3008501111,0.3000000001);
$arr7 = array(0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001,0.3000000001,0.3011111001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3999900001, 0.3000000001, 0.3004251001, 0.3000111111, 0.4826000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3000000001, 0.3986540001,0.3000000001,0.3000000001);

*/


//$result = $mysqli->query("SELECT block, sum(response_time) as sum_response_time FROM trials where idiat = " . $idIat . " and (block = 3 or block = 4 or block = 6 or block = 7) group by trial_number having sum_response_time < 10.0 and sum_response_time > 0.3");
//$result = $mysqli->query("SELECT block, response_time, (select sum(error) from trials as B where B.trial_number = A.trial_number and B.idiat = A.idiat) as number_errors FROM trials as A where idiat = " . $idIat . " and error = 0 and (block = 3 or block = 4 or block = 6 or block = 7) and response_time < 10.0 and response_time > 0.3");

$result = $mysqli->query("SELECT block, response_time, sum(error) as number_errors FROM trials as A where idiat = " . $idIat . " and (block = 3 or block = 4 or block = 6 or block = 7) and response_time < 10.0 and response_time > 0.3 group by trial_number");


$arr3cRT = array();
$arr4cRT = array();
$arr6cRT = array();
$arr7cRT = array();

$errorSum3 = 0;
$errorSum4 = 0;
$errorSum6 = 0;
$errorSum7 = 0;

$arr3 = array();
$arr4 = array();
$arr6 = array();
$arr7 = array();



while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	//add correct response times to an array for each block
	
	if($row['number_errors'] == 0){
		switch ($row['block']) {
			case 3: 
				$arr3cRT[] = $row['response_time'];
				break;
			case 4:
				$arr4cRT[] = $row['response_time'];
				break;
			case 6:	
				$arr6cRT[] = $row['response_time'];
				break;	

			case 7:
				$arr7cRT[] = $row['response_time'];
				break;
		}
	
	
	//add up number of errors in each block
	}else{
		switch ($row['block']) {
			case 3: 
				$errorSum3++;
				break;
			case 4:
				$errorSum4++;
				break;
			case 6:	
				$errorSum6++;
				break;	

			case 7:
				$errorSum7++;
				break;
		}
	}
	//add all response times to an array for each block
	switch ($row['block']) {
		case 3: 
			$arr3[] = $row['response_time'];
			break;			
		case 4:
			$arr4[] = $row['response_time'];
			break;
		case 6:	
			$arr6[] = $row['response_time'];
			break;	

		case 7:
			$arr7[] = $row['response_time'];
			break;
	}
	
}

//calculating correct mean
$corAvgB3 = findAvg($arr3cRT);
$corAvgB6 = findAvg($arr6cRT);
$corAvgB4 = findAvg($arr4cRT);
$corAvgB7 = findAvg($arr7cRT);

//find pooled standard deviation for block 3 and block 6
$size3 = count($arr3);
$size6 = count($arr6);
$sD3 = findSD($arr3, $size3);
//echo "sD3". $sD3 ."";
$sD6 = findSD($arr6, $size6);
//echo "sD6". $sD6 ."";
$pooledSDB36 = findPooledSD($size3, $size6, $sD3, $sD6);
//echo "pSB36". $pooledSDB36."";

//find pooled standard deviation for block 7 and 4
$size4 = count($arr4);
$size7 = count($arr7);
$sD4 = findSD($arr4, $size4);
$sD7 = findSD($arr7, $size7);
$pooledSDB47 = findPooledSD($size4, $size7, $sD4, $sD7);

//calculate error penalty for each block
$penalty3 = $corAvgB3 + 0.6;
$penalty4 = $corAvgB4 + 0.6;
$penalty6 = $corAvgB6 + 0.6;
$penalty7 = $corAvgB7 + 0.6;


//replace errors with penalty for each block
$newArr3 = $arr3cRT;
$newArr4 = $arr4cRT;
$newArr6 = $arr6cRT;
$newArr7 = $arr7cRT;


$i=0;
while($i < $errorSum3){
	$newArr3[] = $penalty3;
	$i++;
}

$i=0;
while($i < $errorSum4){
	$newArr4[] = $penalty4;
	$i++;
}

$i=0;
while($i < $errorSum6){
	$newArr6[] = $penalty6;
	$i++;
}

$i=0;
while($i < $errorSum7){
	$newArr7[] = $penalty7;
	$i++;
}



//find averages of response times in blocks
$avgB6 = findAvg($newArr6);
$avgB3 = findAvg($newArr3);
$avgB7 = findAvg($newArr7);
$avgB4 = findAvg($newArr4);


//calculations before finding final score
$q1 = ($avgB6 - $avgB3) / $pooledSDB36;
$q2 = ($avgB7 - $avgB4) / $pooledSDB47;


//final score
$finalScore = ($q1 + $q2) / 2;


$finalScoreUpdated = $finalScore;
if ($iatType == 2 || $iatType == 3) {
	$finalScoreUpdated = $finalScore * (-1);
}


echo "<br>Score: ".$finalScoreUpdated.".";
echo "<br>Positive (+) score indicates a tendency to associate Female and Computer Science.
Negative (-) score indicates a tendency to associate Male and Computer Science.<br>
Values greater than 1 or less than -1 indicate moderately strong associations";

//update the score in the iat table
if (!$mysqli->query("UPDATE iat SET score_original = " . $finalScore . ", score = " . $finalScoreUpdated . ", iat_type = '" . $iatType . "', categories_order = '" . $categories_order . "' where idiat = " . $idIat . "")) {
    echo "UPDATE failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

}
$mysqli->close();

//insert the data of the iat into the csv file
$fp = fopen('../report_csv/'.$idPerson.'_'.$idIat.'.csv', 'w');
foreach ($array_csv as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

session_destroy();

exit;
?>