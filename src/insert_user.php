<html>
	<head>
		<title>Plagiarism Detector</title>
	</head>
	<body>
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
		
		// Query the database to see if there is username exists
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

		<form action="insert_user.php" method="post">
			<table border="0">
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" maxlength="20" size="20"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td> <input type="password" name="password" maxlength="40" size="20"></td>
				</tr>
				<tr>
					<td>User Type</td>
					<td>
						 <select name="usertype">
							<option value="Student">Student</option>
							<option value="Faculty">Faculty</option>
							<option value="Admin">Admin</option>
						</select> 
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Create"></td>
				</tr>
			</table>
		</form>
	</body>
</html>

