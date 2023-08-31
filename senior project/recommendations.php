<?php
define("IN_CODE", 1);
include("dbconfig.php");
include("similarfunction.php"); 

    session_start();
        if(!isset($_GET['id'])){
	    if(!isset($_SESSION['user_id'])){
            echo '<script>';
            echo 'alert("Please log in first");';
            echo "window.location = 'signin.php';";
            echo '</script>';
	        } else {
 	        $uid = $_SESSION['user_id'];
	        header("Location: ?id=".$uid);      
	        }
            }

    $conn = mysqli_connect($host, $username, $password, $dbname)
        or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
        mysqli_connect_error()); 

        error_reporting(E_ALL | E_STRICT);

            $chkUser = mysqli_real_escape_string($conn, $_GET['id']);
            $thisuser = $_SESSION['user'];
            $query = "SELECT * FROM users WHERE id = $chkUser";
            $results = mysqli_query($conn, $query);
            $user = mysqli_fetch_assoc($results);

            $queryImg = "SELECT * FROM profileimg WHERE userid='$chkUser'";
            $resultImg = mysqli_query($conn, $queryImg);

            $uid = $_SESSION['user_id'];
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
            <style>
              body {
                font-family: 'Roboto'; font-size: 12px;
                  }
            </style>
                <!-- Load React.  <script type="text/javascript" src="SearchCombined.js"></script> -->  
            <link rel="stylesheet" href="recstyling.css">
    </head>
    
        <body>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
            <div class="container" id="myNav">
                <nav class="navbar navbar-expand-lg" id="customNav">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php"><img src="/images/logo6.png" alt="" width="30" height="24" id="brandlog" class="d-inline-block align-text-top">
                        CINE/SCORE</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" aria-current="page" href="profile.php">PROFILE</a></li>
                                <li class="nav-item"><a class="nav-link" href="search_users.php">MEMBERS</a></li>
                                <li class="nav-item"><a class="nav-link" href="http://eve.kean.edu/~borgeski/SeniorProject/April25/explore.php">EXPLORE</a></li>
                                <li class="nav-item"><a class="nav-link" href="http://eve.kean.edu/~borgeski/SeniorProject/April25/recommendations.php">RECOMMENDATIONS</a>
                            </ul>
                        </div>
                    </div>
                        <form id="search-form" action="results.php" method="get">
                            <input type="text" id="search-movies" name="query" class="nav-link searchBar cuteyBar-input" placeholder="Search for movie...">
                            <button type="submit" class="cuteyBar-button">
                            <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                            </svg>
                            </button>
                        </form>
                </nav>
            </div>
   
            <section>
                
            <div class='section-label-thing'>
                <h4>RECOMMENDATIONS BASED ON YOUR REVIEWS </h4>
                </div>
                    <div class="line-thing"></div>
                    <div class='section-label-thing'>
                    <h4>BECAUSE YOU WATCHED <?php
                    $top_movie_name = getTopMovieTitle($uid, $conn);
                    echo $top_movie_name; ?> .... </h4>
                    </div>
                <div id="poster-container">  
                <?php 
                $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a"; 
                $posters = getTopMovieAndSimilar($uid, $apiKey);
                echo $posters;
                ?> 
                </div>
                <div class="line-thing"></div>
                <div class='section-label-thing'>
                <h4>BECAUSE YOU LIKE THE GENRE <?php
                $top_genre_name = getTopGenreName($uid, $conn);
                echo $top_genre_name; ?> .... </h4></div>
                
                <div id="poster-container">  
                <?php 
                $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a"; 
                $posters = getTopGenre($uid, $apiKey, $conn);
                echo $posters;
                ?> 
                </div>
                <div class="line-thing"></div>

                <div class='section-label-thing'>
                <h4>BECAUSE YOU LIKE THE GENRE <?php
                $second_top_genre_name = get2ndTopGenreName($uid, $conn);
                echo $second_top_genre_name; ?> .... </h4></div>
                
                <div id="poster-container">  
                <?php 
                $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a"; 
                $posters = get2ndTopGenre($uid, $apiKey, $conn);
                echo $posters;
                ?> 
                </div>
                <div class="line-thing"></div>

        
                <script>
                // api key - 7f0e42ab052fbd09ee9ddc86b625600a
                </script>
            </section>

                <div class="footer">
                    <div class="footertext">
                    <span class="footertitle">CINE/SCORE</span>
                    </div>
                </div>
        </body>
</html>