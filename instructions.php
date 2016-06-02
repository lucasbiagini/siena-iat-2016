<?php 
  session_start(); 
  if (empty($_SESSION['started']	)) {
    header( 'Location: /');
  }
  require_once('includes/helper.php');
  $_SESSION['cheatType'] = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Instructions to IAT </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="includes/css/form.css">
		
	</head>
	<body>
		<div class="container">
		<div id="instructions">
			<h2> Instructions </h2>
			<p>	In the next task, you will be presented with a set of words to classify into groups. This task requires that you classify items as quickly as you can while making as few mistakes as possible. Going too slow or making too many mistakes will result in an uninterpretable score. This part of the study will take about 5 minutes. The following is a list of category labels and the items that belong to each of those categories. </p>
			
			<table class="table">
				<thead>
					<tr> 
						<th> Category </th>
						<th> Items </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Computer Science</td>
						<td> Apps, Computer, Algorithm, Hacking, Internet, Programming, Software, Technology</td>
					</tr>
					<tr>
						<td>Biology</td>
						<td> Nature, Life, Photosynthesis, Habitat, Organs, Plants, Species, Protein</td>
					</tr>
					<tr> 
						<td> Male </td>
						<td> James, John, Robert, Michael, William, David, Richard, Joseph</td>
					</tr>
					<tr> 
						<td> Female </td>
						<td> Mary, Patricia, Jennifer, Elizabeth, Linda, Barbara, Susan, Margaret</td>
					</tr>
				</tbody>
			</table>
			<h3>Keep in mind</h3>
			<ul>
				<li>Keep your index fingers on the 'e' and 'i' keys to enable rapid response.</li>
				<li>Two labels at the top will tell you which words or images go with each key.</li>
				<li>Each word or image has a correct classification. Most of these are easy.</li>
				<li>The test gives no results if you go slow -- Please try to go as fast as possible.</li>
				<li>Expect to make a few mistakes because of going fast. That's OK.</li>
				<li>For best results, avoid distractions and stay focused.</li>
			</ul>
			
      <form action="iat.php">
        <button type="submit" class="btn btn-block" id="cont"> I am ready to begin</button>
      </form>
		</div>
		</div>
	</body>
</html>


	
