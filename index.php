<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
	    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Implicit Association Test </title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="form.css">
		
	</head>
	<body>
		<div class="container">
		<div id="directions">
			<h2>You have opted to complete the Computer Science/Biology IAT.</h2>
			<br>
			<p>You will complete two tasks: a short survey about yourself and an IAT in which you will sort words into categories as quickly as possible. You should be able to complete the tasks in less than 10 minutes total. When you finish, you will receive your results as well as more information about the test and the performance of others.</p>
			<p>
			Paste your ID here if you have it, otherwise just leave it blank: <input type="text" name="idPerson" id="idPerson" maxlength="25"> <span id="error" style="color:red"></span>
			</p>
		</div>
		<button type="submit" class="btn btn-block" id="cont">Continue to survey</button>
		</div>
		<script>
			$("#cont").click(function() {
				personID = $("#idPerson").val();
				if (personID.length === 0) {
					window.location.href = 'survey.php';
				} else {
					var url = "ajax/index.php"; // the script where you handle the form input.
				    $.ajax({
				           type: "POST",
				           url: url,
				           data: {idPerson: personID}, // serializes the form's elements.
				           success: function(data) {
							    if (data == 'success') {
									window.location.href = 'instructions.php';
							    }else if(data == 'error'){
							        $("#error").html("ID not found, please try again.");
							    }
							},
				         });
				    return false; // avoid to execute the actual submit of the form.
				}
				
			});
		</script>
	</body>
</html>
