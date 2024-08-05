<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="description" content="Quiz" />
	<meta name="keywords" content="PHP, mysql" />
	<meta name="author" content="Anthony Burke" />
	<title> Quiz Results </title>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet" />
	<link href="styles/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<?php
	include_once "header&menu.inc";
	?>
	<?php

	// Some of the code in this document is based on code from a sample assignment from last semester (Fruit Shop)

	//sanitise data
	function sanitise_input($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// *********  if it is not submitted from quiz, redirection to quiz
	if (!isset($_POST["submit"])) {
		header("location:quiz.php");
		exit();
	}

	// ********* validate form  

	$err_msg = "";

	// first name
	if (isset($_POST["GivenName"])) {
		$firstName = $_POST["GivenName"];
		$firstName = sanitise_input($firstName);
		if ($firstName == "") {
			$err_msg .= "<p>Please enter first name</p>";
		} else if (!preg_match("/^[a-zA-Z- ]{2,20}$/", $firstName)) {
			$err_msg .= "<p>First name can only contain max 20 alpha characters, spaces, and hyphens</p>";
		}
	}


	// last name  	
	if (isset($_POST["FamName"])) {
		$lastName = $_POST["FamName"];
		$lastName = sanitise_input($lastName);
		if ($lastName == "") {
			$err_msg .= "<p>Please enter last name</p>";
		} else if (!preg_match("/^[a-zA-Z- ]{2,20}$/", $lastName)) {
			$err_msg .= "<p>Last name can only contain max 20 alpha characters, spaces, and hyphens</p>";
		}
	}



	// student id
	if (isset($_POST["stuID"])) {
		$stuID = $_POST["stuID"];
		$stuID = sanitise_input($stuID);
		if ($stuID == "") {
			$err_msg .= "<p>Please enter your Student ID</p>";
		} else if (!preg_match("/^(\d{7}|\d{10})$/", $stuID)) {
			$err_msg .= "<p>Student ID must contain 7 or 10 digits</p>";
		}
	}

	$score = 0;

	// q1 answer & score
	if (isset($_POST["q1Answer"])) {
		$q1Answer = $_POST["q1Answer"];
		$q1Answer = sanitise_input($q1Answer);
		if ($q1Answer == "Bridge") {
			$score += 1;
		}
	} else {
		$err_msg .= "<p>Please answer Question 1</p>";
	}





	// q2 answer & Score
	if (isset($_POST["Q2"])) {
		$q2Answer = $_POST["Q2"];
		$q2Answer = sanitise_input($q2Answer);
		if ($q2Answer == "Google Class") {
			$score += 1;
		}
		if ($q2Answer == "") {
			$err_msg .= "<p>Please answer Question 2</p>";
		}
	}
	// q3 answer
	if (isset($_POST["q3"])) {
		$q3Checked = $_POST['q3'];
		if (isset($q3Checked[0]) && isset($q3Checked[1]) && !isset($q3Checked[2])) {
			$score += 1;
		}
	} else {
		$err_msg .= "<p>Please answer Question 3</p>";
	}





	//q4 answer

	if (isset($_POST["Q4"])) {
		$q4Answer = $_POST["Q4"];
		$q4Answer = sanitise_input($q4Answer);
		$q4Answer = strtolower($q4Answer);
		if ($q4Answer == "learning management system") {
			$score += 1;
		}
		if ($q4Answer == "") {
			$err_msg .= "<p>Please answer Question 4</p>";
		}
	}


	//q5 answer

	if (isset($_POST["Q5"])) {
		$q5Answer = $_POST["Q5"];
		$q5Answer = sanitise_input($q5Answer);
		if ($q5Answer == "") {
			$err_msg .= "<p>Please answer Question 5</p>";
		} else if ($q5Answer == "2008") {
			$score += 1;
		} else if (!is_numeric($q5Answer)) {
			$err_msg .= "<p>Question 5's answer must be numerical</p>";
		}
	}


	//checks if user scores 0 on quiz
	if ($score == 0) {
		$err_msg .= "<p>You can't submit quiz with a score of 0</p>";
	}



	// ******* displays error, else connects to DB
	if ($err_msg != "") {
		echo "<p>$err_msg</p>";
	} else {
		require_once("settings.php");
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);

		if ($conn) {
			// create table if not exists
			$query = "CREATE TABLE IF NOT EXISTS attempts (
		Attempt_id INT AUTO_INCREMENT PRIMARY KEY, 
		Date_Time DATETIME,
		First_Name VARCHAR(20),
		Last_Name VARCHAR(20),
		S_Number INT(10),
		Attempts INT(11), 
		Score INT(11)
		);";
			$result = mysqli_query($conn, $query);
			if ($result) { //table creation successful

				$selectQuery = "SELECT * FROM attempts WHERE S_Number = '$stuID';"; 	//select users results
				$select_result = mysqli_query($conn, $selectQuery); //query for users results
				$attempts_made = mysqli_num_rows($select_result); //saves number of user attempts in a variable
				if ($attempts_made >= 3) {	//checks user attempts   
					echo "<p>You can't submit quiz if you've had 3 attempts.</p>";
					return;
				}
				$attempts_made += 1;
				$datetime = date('Y-m-d H:i:s');
				$insertQuery = "INSERT INTO attempts (Date_Time, First_Name, Last_Name, S_Number, Attempts, 	
				Score) 
				VALUES ('$datetime','$firstName', '$lastName', $stuID, $attempts_made, $score);";
				$insert_result = mysqli_query($conn, $insertQuery); //insert query to database

				if ($insert_result) {	//   insert successfully 
					echo "<p>Your results are saved in the database.</p>"
						. "<table border=\"1\">\n"
						. "<tr><th>Attempt ID</th><td>" . mysqli_insert_id($conn) . "</td></tr>"
						. "<tr><th>Date/Time</th><td>$datetime</td></tr>"
						. "<tr><th>First Name</th><td>$firstName</td></tr>"
						. "<tr><th>Last Name</th><td>$lastName</td></tr>"
						. "<tr><th>Student ID</th><td>$stuID</td></tr>"
						. "<tr><th>Attempts</th><td>$attempts_made</td></tr>"
						. "<tr><th>Score</th><td>$score</td></tr>"
						. "</table>";
					echo "<p>Try Again: <a href='markquiz.php'>Quiz</a></p>";
				} else {
					echo "<p>Insert Table unsuccessful.</p>";
				}
			} else {
				echo "<p>Create table unsuccessful.</p>";
			}
			mysqli_close($conn);
		} else {
			echo "<p>Unable to connect to the database.</p>";
		}
	}
	?>

	<?php
	include_once "footer.inc";
	?>

</body>

</html>