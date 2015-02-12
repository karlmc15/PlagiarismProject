<html>
	<head>
		<title>Plagiarism Detector</title>
	</head>

	<body>
		<h1>Please Log In</h1>
<?php
	// If submit button was not clicked ignore whole script and load original login page
	if (isset($_POST['submit'])){
	
	// Start session
	session_start();
	
	// Get username and password from post
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	// Check if username and password have been set
	if ((empty($username)) || (empty($password))) {
		echo "<span style='color:#ff0000'>Please enter a username and password</span>";
	}
	else {
		// Connect to mysql
		@ $conn = mysqli_connect('localhost', 'root', 'password','csc440'); // your username and password here

		// Check if connection was successful
		if (!$conn) {
			echo "<span style='color:#ff0000'>Could not connect to database: ".mysqli_connect_error().". Please try again later.</span>";
			exit;
		}

		// Query the database to see if there is a record which matches
		$query = "select count(*) from users where username = '".$username."' and password = '".sha1($password)."'";

		// Check if query was successful
		$result = $conn->query($query);
		if(!$result) {
			echo "<span style='color:#ff0000'>Cannot run query.</span>";
			exit;
		}
	
		// Get query result
		$row = mysqli_fetch_row($result);
		$count = $row[0];

		// Username and password are correct
		if ($count > 0) {
			// Set session variable and load home page
			$_SESSION['valid_user'] = $username;
			header('Location: index.php');
		}
		else {
			// Username and password are not correct
			echo "<span style='color:#ff0000'>Your username and password were incorrect.</span>";
		}
		$conn->close();
	}
	}
?>
		
		<form method="post" action="login.php">
			<p>Username: <input type="text" name="username"></p>
			<p>Password: <input type="password" name="password"></p>
			<p><input type="submit" name="submit" value="Login"></p>
		</form>
		<a href="insert_user.php" >Create a New Account</a>
	</body>
</html>