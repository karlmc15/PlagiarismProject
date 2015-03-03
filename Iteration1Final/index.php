<?php
	// Start session
	session_start();
	
	// Check if user is logged in before loading page
	if(isset($_SESSION['valid_user'])){
		
	}
	// User not logged in redirect to login page
	else {
		header('Location: login.php');
	}
?>

<html>
	<head>
		<title>Plagiarism Detector - Home Page</title>
		<link rel="stylesheet" type="text/css" href="style/stylesheet.css">
	</head>
	<body>
		<div class="logoutDiv">
			<form method='post' action='logout.php' >
				<input id='submitButton' type='submit' name='submit' value='Log Out' >
			</form>
		</div>
		<div id="indexCenter">
			<h1>Check for Plagiarism</h1>
			
			<form id="resultsForm" action="results.php?from=upload" method="post"></form>

			<form method="post" enctype="multipart/form-data" width="500">
				<div class="plainCenter">
					<h2>Upload file to check for plagiarism here: </h2>
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td>
								<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
								<div id='file_browse_wrapper'><input name="file_browse" type='file' id='file_browse'></div>
								<script>
									document.getElementById("file_browse").onchange = function () {
									document.getElementById("fileDisplay").innerHTML = file_browse.value;
									};
								</script>
							</td>
							<td>
								<p id="fileDisplay">No file Selected...</p>
							</td>
							<td><input id="submitButton" name="upload" type="submit" value="Upload">
							</td>
						</tr>
					</table>
					
					<input id="submitButton" type="submit" name="submit" value="Check" form="resultsForm" style="margin: 40px 0px 0px -570px;"/>
				</div>
			</form>
			
			<form method='post' action='results.php?from=text' >
				<div class='plainCenter'>
					<h2>Enter text to check for plagiarism here: </h2>
					<textarea name='textInput' cols='75' rows='20'></textarea>
					<p><input id='submitButton' type='submit' name='submit' value='Check' style='margin: 40px 5px 0px -570px;' ></p>
				</div>
			</form>
		</div>
	</body>
</html>

<?php
	// Check if file uploaded successfully
	if(isset($_POST['upload']) && $_FILES['file_browse']['size'] > 0) {
		// Get file data
		$fileName = $_FILES['file_browse']['name'];
		$tmpName  = $_FILES['file_browse']['tmp_name'];
		$fileSize = $_FILES['file_browse']['size'];
		$fileType = $_FILES['file_browse']['type'];
		$userName = $_SESSION['valid_user'];
		
		// Open and read file content
		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);
		
		if(!get_magic_quotes_gpc()) {
			$fileName = addslashes($fileName);
		}

		// Connect to mysql
		@ $conn = mysqli_connect('localhost', 'root', 'password','csc440');

		// Check if connection was successful
		if (!$conn) {
			echo "<span style='color:#ff0000'>Could not connect to database: ".mysqli_connect_error().". Please try again later.</span>";
			exit;
		}
	
		// Prepare insert query
		$query = "INSERT INTO uploads ( name, size, type, content, username ) "."VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$userName')";

		// Check if query was successful
		$result = $conn->query($query);
		if(!$result) {
			echo "<span style='color:#ff0000'>Cannot run query.</span>";
			exit;
		}
			
		$conn->close();

		echo '<script language="javascript">';
		echo 'alert("File '.$fileName.' uploaded. Press \"Check\" to detect plagiarism.")';
		echo '</script>';
	}
	
?>