<?php
echo "<html>\n";
define("IN_CODE",1);
include "dbconfig.php";
$conn = mysqli_connect($host, $username, $password, $dbname) 
      or die("<br>Cannot connect to DB:$dbname on $host. Error:" . 
      mysqli_connect_error());
// Get the form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];



// Escape special characters to prevent SQL injection attacks
$username = mysqli_real_escape_string($conn, $username);
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);



if (!preg_match("/\b@kean.edu\b/i", $email, $match))
        {
		echo '<script>';
                echo 'alert("Must be a Kean University Student");';
                echo 'window.location = "create_account.php";';
                echo '</script>';

        }
else {

// Insert the data into the database
$sql = "INSERT INTO users (id, email, username, password)
        VALUES (NULL, '$email', '$username', '$password')";

if ($conn->query($sql) === TRUE) {
	$sqlCheck = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$resultchk = mysqli_query($conn, $sqlCheck);
	
	if (mysqli_num_rows($resultchk) > 0) {
		while ($row = mysqli_fetch_assoc($resultchk)) {
		$userid = $row['id'];
		$sqlImg = "INSERT INTO profileimg (userid, status) VALUES ('$userid', 1)";
     $sqlfav = "INSERT INTO favmovie (user_id) VALUES ('$userid')";
		if ($conn->query($sqlImg) === TRUE && $conn->query($sqlfav) === TRUE) {

  echo '<script>';
	echo 'alert("Account Created, Please Sign In");';
	echo 'window.location = "signin.php";';
	echo '</script>';
} else {
  echo '<script>';
	echo 'alert("Error: ' . $conn->error . '");';
	echo 'window.location = "create_account.php";';
	echo '</script>';
}}} else {
	 echo '<script>';
        echo 'alert("Error: ' . $conn->error . '");';
	echo 'window.location = "create_account.php";';
	echo '</script>';
}
} else {
	 echo '<script>';
        echo 'alert("Error: ' . $conn->error . '");';
	echo 'window.location = "create_account.php";';   
	echo '</script>';
}
}
// Close the database connection
$conn->close();
?>
