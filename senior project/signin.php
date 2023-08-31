i<?php
// Start the session
define("IN_CODE", 1);
session_start();
include("dbconfig.php"); //includes the dbconfig

// Check if the user is already logged in, redirect to home page if true
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

    // Sanitize and validate the user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email_err = "";
    $password_err = "";
    if (empty($email)) {
        $email_err = 'Email is required';
	die;
    }
    if (empty($password)) {
        $password_err = 'Password is required';
	die;
    }

    // Check if the user exists in the database
    $query = "SELECT id, email, username, password FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
	$query_pass = "SELECT * from users WHERE email = '$email' AND password = '$password'";
	$pass_result = mysqli_query($conn, $query_pass);
	$row = mysqli_fetch_array($pass_result);
	
        if ($row) {
            // Login successful, store user ID in session and redirect to home page
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user'] = $user['username'];
	    if(isset($_SESSION['user_id'])) {
	            header("Location: profile.php");
	    }
        } else {
            // Invalid password
            $password_err = 'Invalid password';
        }
    } else {
        // Invalid email
        $email_err = 'Invalid email';
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
         <!-- Load React. -->
         <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
        <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
        <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="signin.css">
        <script src="searchscript.js"></script>
        <style>
          body {
            font-family: 'Roboto'; font-size: 12px;
          }
        </style>
    </head>
    <body id="main">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <div class="container" id="myNav">
        <nav class="navbar navbar-expand-lg" id="customNav">
            <div class="container-fluid">
              <a class="navbar-brand" href="index.php"><img src="images/logo6.png" alt="" width="30" height="24" id="brandlog" class="d-inline-block align-text-top">
                CINE/SCORE</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="signin.php">SIGN IN</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="create_account.php">CREATE ACCOUNT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">FILMS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">MEMBERS</a>
                  </li>
                </ul>

                <div class="nav-link searchBar" id="search">
                  <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="" value="" />
                  <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="rgb(196, 239, 215)" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </nav>
          </div>
          <!-- Outside Nav bar-->

          <section>
            <div class="container">
                <span class="signin">SIGN IN</span><hr class="accountline">
              <div class="signindetails">
                <form class="sign" method="POST">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="formlabel">Email</label>
                    <input type="text" class="form-control emaillength" id="exampleInputEmail1" name="email"  placeholder="" required>
		    <?php if (isset($email_err)) {
			echo '<span id="errormsg">' . $email_err . '</span>';
		    }
	 	    ?>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="formlabel">Password</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="password" required>
		<?php if (isset($email_err)) {
                     echo '<span id="errormsg">' . $password_err . '</span>';
		}
                 ?>
               </div>
                <button type="submit" class="btn btn-success">Submit</button>
              </form>
              </div>
              </div>
              </div>
          </section>

           <section>
              <div class='footer'>
		        <div class='footertext'>
	          <nav class="navbar navbar-expand-lg" id='customNav2'>
  		  <a class="footbrand" href="#">CINE/SCORE</a>
  		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
   		  	<span class="navbar-toggler-icon"></span>
  		  </button>
  		  <div class="collapse navbar-collapse" id="navbarNav"`>
    		  <ul class="navbar-nav">
      			<li class="nav-item active">
        			<a class="footbrand" href="#">ABOUT</a>
      			</li>
    		</ul>
  		</div>
		</nav>
			<div class='footerDesc'>
			Created By: Kimberly, Clinton, Demetri, Jared<br>
			A Kean Film Social Network
			</div>
		</div>
              </section>
    </body>
    <script src="scripts.js"></script>
</html>
