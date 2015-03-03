<html>
	<head>
		<title>Plagiarism Detector - New User</title>
		<link rel="stylesheet" type="text/css" href="style/stylesheet.css">
	</head>
	<body>
		<div class="center">
			<h1>Create a New Account</h1>
<?php
	// If submit button was not clicked ignore whole script and load original page
	if (isset($_POST['submit'])){
	
	// Get username, password, usertype from post
	$username = $_POST['username'];
	$password = $_POST['password'];
	$usertype = $_POST['usertype'];
	
	// Check if username and password have been set
	if ((empty($username)) || (empty($password))) {
		echo "<span style='color:#ff0000'>Please enter username, password, and usertype.</span>";
	}
	else {
		// Connect to mysql
		@ $conn = mysqli_connect('localhost', 'root', 'password','csc440'); // your username and password here

		// Check if connection was successful
		if (!$conn) {
			echo "<span style='color:#ff0000'>Could not connect to database: ".mysqli_connect_error().". Please try again later.</span>";
			exit;
		}
		
		// Query the database to see if username exists
		$query = "select count(*) from users where username = '".$username."'";

		// Check if query was successful
		$result = $conn->query($query);
		if(!$result) {
			echo "<span style='color:#ff0000'>Cannot run query.</span>";
			exit;
		}
	
		// Get query result
		$row = mysqli_fetch_row($result);
		$count = $row[0];

		// Check if username exists in db already
		if ($count == 0) {
			// Prepare query
			$query = "insert into users values ('".$username."', '".$usertype."', '".sha1($password)."')";
			$result = $conn->query($query);
  
			// Check if query was successful
			if ($result) {
				header('Location: login.php');
			}
			else {
				echo "<span style='color:#ff0000'>An error has occurred.  The user was not added.</span>";
			}
		}
		else {
			// Username and password are not correct
			echo "<span style='color:#ff0000'>Username already exists.</span>";
		}

		$conn->close();
	}
	}
?>

			<form action="new_user.php" method="post">
			<form method="post" action="new_user.php">
				<p>Username: <input id="textInput" type="text" name="username"></p>
				<p>Password: <input id="textInput" type="password" name="password"></p>
				<p>User Type: <select name="usertype">
					<option value="Student">Student</option>
					<option value="Faculty">Faculty</option>
				</select></p>
				<p><input id="submitButton" type="submit" name="submit" value="Create"></p>
			</form>
		</div>
	</body>
</html>

