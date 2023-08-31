<?php
session_start();
define("IN_CODE",1);
include "dbconfig.php";
$conn = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error());
// Get the form data
$filmid = $_GET['filmname'];
$tile = $_GET['tile'];
$user_id = $_SESSION['user_id'];

// Insert the data into the database

//check which div was clicked on
if ($tile == 1) {
$sql = "UPDATE favmovie SET favmov1 = '$filmid'
        WHERE user_id = $user_id";
}

elseif ($tile == 2) {
$sql = "UPDATE favmovie SET favmov2 = '$filmid'
        WHERE user_id = $user_id";
}

elseif ($tile == 3) {
$sql = "UPDATE favmovie SET favmov3 = '$filmid'
        WHERE user_id = $user_id";
}

elseif ($tile == 4) {
$sql = "UPDATE favmovie SET favmov4 = '$filmid'
        WHERE user_id = $user_id";
}

elseif ($tile == 5) {
$sql = "UPDATE favmovie SET favmov5 = '$filmid'
        WHERE user_id = $user_id";
}




if ($conn->query($sql) === TRUE) {
  echo '<script>';
	echo 'window.location = "edit_profile.php"';
	echo '</script>';
} else {
  echo '<script>';
	echo 'alert("Error: ' . $conn->error . '");';
	echo 'window.location = "edit_profile.php"';
	echo '</script>';
}

// Close the database connection
$conn->close();
?>
