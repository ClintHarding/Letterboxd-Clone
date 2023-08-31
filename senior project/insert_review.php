<?php
session_start();
define("IN_CODE",1);
include "dbconfig.php";
$conn = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error());
// Get the form data
$filmid = $_POST['movie_id_from_url'];
$user_id = $_SESSION['user_id'];
$rating = isset($_POST['starscore']) ? intval($_POST['starscore']) : 0;
$review_text = $_POST['reviewcommenttext'];

// Insert the data into the database
$sql = "INSERT INTO reviews (review, score, movie_id, user_id)
        VALUES ('$review_text', '$rating', '$filmid', '$user_id')";

if ($conn->query($sql) === TRUE) {
  echo '<script>';
	echo 'alert("Review Logged");';
	echo 'window.location = "movie-details.php?filmname='.$filmid.'";';
	echo '</script>';
} else {
  echo '<script>';
	echo 'alert("Error: ' . $conn->error . '");';
	echo 'window.location = "movie-details.php?filmname='.$filmid.'";';
	echo '</script>';
}

// Close the database connection
$conn->close();
?>
