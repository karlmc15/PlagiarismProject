<html>
	<head>
		<title>Plagiarism Detector</title>
	</head>
	<body>
		<h1>Check for Plagarism</h1>
<?php
	// Start session
	session_start();
	
	// Check if user is logged in before loading page
	if(isset($_SESSION['valid_user'])){
		echo "
		<form method='post' action='results.php'>
			<p>Enter text to check here: </p>
			<textarea id='textInput' name='textInput' cols='100' rows='20'></textarea>
			<p><input type='submit' name='submit' value='Check'></p>
		</form>
		";
	}
	// User not logged in redirect to login page
	else {
		header('Location: login.php');
	}
	
?>

	</body>
</html>