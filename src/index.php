<html>
	<head>
		<title>Plagiarism Detector</title>
	</head>
	<body>
		<h1>Check for Plagiarism</h1>
<?php
	// Start session
	session_start();
	
	// Check if user is logged in before loading page
	if(isset($_SESSION['valid_user'])){
		// Allow user to upload files and check for plagiarism
		include 'upload.php';
		
		// Allow user to enter text and check for plagiarism
		echo "
		<form method='post' action='results.php?from=text' >
			<fieldset style='width: 650px;'>
				<legend>Enter text to check for plagiarism here: </legend>
				<textarea id='textInput' name='textInput' cols='75' rows='20'></textarea>
				<p><input type='submit' name='submit' value='Check'></p>
			</fieldset>
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