<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="description" content="Manage DB" />
    <meta name="keywords" content="PHP, MySQL" />
    <meta name="author" content="Anthony Burke" />
    <title>Supervisor Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet" />
    <link href="styles/style.css" rel="stylesheet" type="text/css" />
    <script src="scripts/enhancements2.js"></script>
</head>



<body>

    <?php

    include_once "header&menu.inc";
    ?>

    <h2>Supervisor Page</h2>
    <?php

    // Some of the code in this document is based on code from a sample assignment from last semester (Fruit Shop)



    require_once "settings.php";    // Load MySQL log in credentials
    $conn = mysqli_connect($host, $user, $pwd, $sql_db);    // Log in and use database
    if ($conn) {
        // checks 'delete attempts' form data
        if (isset($_POST["deleteID"])) {
            $deleteAttempts = trim($_POST["deleteID"]);
            if ($deleteAttempts !== "") {
                $deleteQuery =  "DELETE FROM attempts WHERE S_Number LIKE '$deleteAttempts'";
                mysqli_query($conn, $deleteQuery); //Deletes attempts of Student ID on form submission 
                $deleteResult = mysqli_affected_rows($conn);
                if ($deleteResult > 0) { //checks if a valid query was made
                    echo "<p>Entry/s Deleted</p>";
                } else {
                    echo "<p>Failed to delete entry/s</p>";
                }
            }
        }

        //checks 'update score' form data
        if (isset($_POST["updateID"]) && isset($_POST["updateAttempt"]) && isset($_POST["updateScore"])) {
            $updateID = trim($_POST["updateID"]);
            $updateAttempt = trim($_POST["updateAttempt"]);
            $updateScore = trim($_POST["updateScore"]);
            $updateQuery = "UPDATE attempts SET Score='$updateScore' WHERE S_Number LIKE '$updateID' AND Attempts LIKE '$updateAttempt'";  //updates score 
            mysqli_query($conn, $updateQuery);
            $updateResult = mysqli_affected_rows($conn);
            if ($updateResult > 0) { //checks if a valid query was made
                echo "<p>Entry updated</p>";
            } else {
                echo "<p>Failed to update entry</p>";
            }
        }



        //checks if 'search form' data is empty
        if (!isset($_POST["firstname"]) && !isset($_POST["lastname"]) && !isset($_POST["stuID"]) && !isset($_POST["firstAttemptAce"]) && !isset($_POST["thirdAttempt"]))
            $query = "SELECT * FROM attempts;";

        else { //else Query DB based on inputs
            $firstname = trim($_POST["firstname"]);
            $lastname = trim($_POST["lastname"]);
            $stuID = trim($_POST["stuID"]);
            $firstattemptAce = isset($_POST["firstAttemptAce"]);
            $thirdAttempt = isset($_POST["thirdAttempt"]);
            $query = "SELECT * FROM attempts WHERE First_Name LIKE '%$firstname%' AND Last_Name LIKE '%$lastname%' AND S_Number LIKE '%$stuID%'";
            if ($firstattemptAce) {
                $query .= " AND Score = 5 AND Attempts = 1";
            }
            if ($thirdAttempt) {
                $query .=  " AND Score <= 2 AND Attempts = 3";
            }
        }

        // query DB  
        $result = mysqli_query($conn, $query);
        if ($result) {    //   query was successfully executed

            $record = mysqli_fetch_assoc($result);
            if ($record) {        //  if record exist, display
                echo "<table border='1'>";
                echo "<tr><th>Attempt_id</th><th>First Name</th><th>Last Name</th><th>Date/Time</th><th>Student ID</th><th>Attempts Made</th><th>Score</th></tr>";
                while ($record) {
                    echo "<tr><td>{$record['Attempt_id']}</td>";
                    echo "<td>{$record['First_Name']}</td>";
                    echo "<td>{$record['Last_Name']}</td>";
                    echo "<td>{$record['Date_Time']}</td>";
                    echo "<td>{$record['S_Number']}</td>";
                    echo "<td>{$record['Attempts']}</td>";
                    echo "<td>{$record['Score']}</td></tr>";
                    $record = mysqli_fetch_assoc($result);
                }
                echo "</table>";
                mysqli_free_result($result);    // Free resources
            } else {
                echo "<p>No record retrieved.</p>";
            }
        } else {
            echo "<p>No results found.</p>";
        }
        mysqli_close($conn);    // Close the database connection
    } else {
        echo "<p>Unable to connect to the database.</p>";
    }
    ?>



    <h2>Search Results</h2>
    <form action="manage.php" method="post">
        <p><label>First Name: <input type="text" name="firstname"></label></p>
        <p><label>Last Name: <input type="text" name="lastname"></label></p>
        <p><label>Student ID: <input type="text" name="stuID"></label></p>
        <p><label>100% on first attempt</label><input type="checkbox" name="firstAttemptAce"></p>
        <p><label>Less than 50% on third attempt</label><input type="checkbox" name="thirdAttempt"></p>
        <input type="submit" value="Search">
    </form>


    <h2>Delete Student Attempts</h2>
    <form action="manage.php" method="post">
        <p><label>Student ID: <input type="text" name="deleteID"></label></p>
        <input type="submit" value="Submit">
    </form>

    <h2>Update Results</h2>
    <form action="manage.php" method="post">
        <p><label>Student ID: <input type="text" name="updateID"></label></p>
        <p><label>Attempt (1-3): <input type="text" name="updateAttempt"></label></p>
        <p><label>New Score: <input type="text" name="updateScore"></label></p>
        <input type="submit" value="Submit">
    </form>

    <?php
    include_once "footer.inc";
    ?>


</body>

</html>