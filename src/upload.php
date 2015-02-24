<form id="resultsForm" action="results.php?from=upload" method="post"></form>

<form method="post" enctype="multipart/form-data" width="500">
	<fieldset style="width: 650px;">
		<legend>Upload file to check for plagiarism here: </legend>
		<table width="350" border="0" cellpadding="0" cellspacing="0" class="box">
			<tr>
				<td width="270">
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input name="userfile" type="file" id="userfile">
				</td>
				<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload ">
				</td>
			</tr>
		</table>

<?php
	// Check if file uploaded successfully
	if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
		// Get file data
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
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

		echo "<p>File $fileName uploaded<p>";
	}
	
?>
		<input type="submit" name="submit" value="Check" form="resultsForm" style="margin: 20px 0px 0px 0px;"/>
	</fieldset>
</form>