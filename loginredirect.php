<?php
session_start();
define("IN_CODE",1);
include 'dbconfig.php';

if(!isset($_POST['signinbutton'])) {
	echo '<script>';
        echo 'alert("You must log in first!");';
        echo 'window.location = "signin.php";';
        echo '</script>';
}

else {

$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $host ERROR:" .
    mysqli_connect_error());

error_reporting(E_ALL | E_STRICT); //turn on error display

$error_message = '';

if(isset($_POST['username']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if(empty($email)){
        $error_message = "Please enter your email";
    } else if(empty($password)){
        $error_message = "Please enter a password.";
    } else {
      $sql = "SELECT COUNT(*) FROM users WHERE username='$email' AND password='$password'";
      $result = mysqli_query($conn, $sql);
      
      if(mysqli_fetch_array($result)[0] == 1){
          // authenticated
          $_SESSION['loggedin'] = true;
          $_SESSION['username'] = $username;
          header("Location: profile.php");
          exit();
      } else {
          // not authenticated
          $error_message = "Invalid username or password.";
      }
    }

if(!empty($error_message)){
    echo "<p>Error: $error_message</p>";
    echo "<p>Redirecting to to the SIGN IN page in 5 seconds...</p>";
    echo '<meta http-equiv="refresh" content="5;url=signin.php">';
}
}
}
?>