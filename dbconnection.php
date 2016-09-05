<?php

$servername = "xxx";
$username = "xxx"; //Add the username on line 13
$password = "xxx";

// Create connection
$conn = new mysqli($servername, $username, $password);
echo "Connected successfully";


//add limit of results
$getUserResults = mysqli_query($conn, "select userid,topic,score,entry_date from <USERNAME_HERE>.RESULTS where userid = $user[id]");


?>
