<html>
	<head>
		<title>Plagiarism Detector</title>
	</head>
	<body>
		<h1>Results</h1>
<?php
	// Start session
	session_start();
	
	// Check if user is logged in before loading page
	if(isset($_SESSION['valid_user'])){
		$from = $_GET['from'];
		if($from == "upload"){
			echo "File was uploaded. Check it for plagiarism";
		}
		else if($from == "text"){
			echo "Text was entered. Check it for plagiarism.";
		}
		
	}
	// User not logged in redirect to login page
	else {
		header('Location: login.php');
	}
	
?>

	</body>
</html>