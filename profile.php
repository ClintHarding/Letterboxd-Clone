<?php
define("IN_CODE", 1);
include("dbconfig.php");

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
    mysqli_connect_error()); //create dbname variable and dbconfig

error_reporting(E_ALL | E_STRICT);

$chkUser = mysqli_real_escape_string($conn, $_GET['id']);

$thisuser = $_SESSION['user'];
$query = "SELECT * FROM users WHERE id = $chkUser";
$results = mysqli_query($conn, $query);

$user = mysqli_fetch_assoc($results);

$queryImg = "SELECT * FROM profileimg WHERE userid='$chkUser'";
$resultImg = mysqli_query($conn, $queryImg);

$queryFav = "SELECT * FROM favmovie WHERE user_id='$chkUser'";
$resultFav = mysqli_query($conn, $queryFav);

$uid = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
         <!-- Load React. -->
         <!-- Note: when deploying, replace 'development.js' with 'production.min.js'. -->
        <script src='https://unpkg.com/react@18/umd/react.development.js' crossorigin></script>
        <script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js' crossorigin></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href='profile.css'>
        <style>
          body {
            font-family: 'Roboto'; font-size: 12px;
          }
        </style>
    </head>
    <body>
      
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
        <div class='container' id='myNav'>
        <nav class='navbar navbar-expand-lg' id='customNav'>
            <div class='container-fluid'>
              <a class='navbar-brand' href='index.php'><img src='images/logo6.png' alt='' width='30' height='24' id='brandlog' class='d-inline-block align-text-top'>
                CINE/SCORE</a>
              <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
              </button>
	<div class='collapse navbar-collapse dropdown' id='navbarNavDarkDropdown'>
                <ul class='navbar-nav mr-auto'>
                  <li class='nav-item dropdown'>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $thisuser ?></a>
                    <div class="dropdown-options" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="index.php">Home</a>
                      <a class="dropdown-item" href="profile.php">Profile</a>
                      <a class="dropdown-item" href="#">Reviews</a>
                      <a class="dropdown-item" href="#">Recommendations</a>
                      <hr>
                      <a class="dropdown-item" href="logout.php">Log Out</a>
                    </div>
                  <li class='nav-item'>
                    <a class='nav-link' href='#'>FILMS</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link'>MEMBERS</a>
                  </li>
                </ul>

		<form id='search-form' action='results.php' method='get'>
                <div class='nav-link searchBar' id='search'>
                  <input id='searchQueryInput' type='text' name='query' placeholder='Search for movie..' value='' />
                  <button id='searchQuerySubmit' type='submit' name='searchQuerySubmit'>
                    <svg style='width:24px;height:24px' viewBox='0 0 24 24'><path fill='rgb(196, 239, 215)' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
                    </svg>
                  </button>
                </div>
		</form>
              </div>
            </div>
          </nav>
          </div>
          <!-- Outside Nav bar-->
          <section>
            <div class="container">
              <div class="profileinfo">
		<?php 
		while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
			echo "<span><img class='profilepic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
		}
		else {
			echo "<span><img class='profilepic' src='uploads/profiledefault.jpg'>";
		}} ?>
                </span>
                <span class="profilename"><?php echo $user['username']; ?></span>
                <span class="profileloc">United States</span>
                <span class="favheader">FAVORITE FILMS</span><hr class="linefav">
                <div class="favmovs">
                  <?php
                // API CONNECTION 

                  $ch = curl_init();
                  
                  $apikey = "7f0e42ab052fbd09ee9ddc86b625600a";
                
                while ($rowFav = mysqli_fetch_assoc($resultFav)) {
                        if (!empty($rowFav['favmov1'])) {
                          $url = "https://api.themoviedb.org/3/movie/" . $rowFav['favmov1'] . "?api_key=$apikey&language=en-US";
                  
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          
                          $resp = curl_exec($ch);
                          
                          if($e = curl_error($ch)) {
                          	echo $e;
                          }
                          else {
                          	$decoded = json_decode($resp, true);
                            
                          }
                          
                        echo "
                    <div class='favMovDes'><a href='movie-details.php?filmname=".$decoded['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovDes' id='favmov1'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    if (!empty($rowFav['favmov2'])) {
                          $url = "https://api.themoviedb.org/3/movie/" . $rowFav['favmov2'] . "?api_key=$apikey&language=en-US";
                  
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          
                          $resp = curl_exec($ch);
                          
                          if($e = curl_error($ch)) {
                          	echo $e;
                          }
                          else {
                          	$decoded = json_decode($resp, true);
                            
                          }
                          
                        echo "
                    <div class='favMovDes' id='favmov2'><a href='movie-details.php?filmname=".$decoded['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovDes' id='favmov2'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    
                    if (!empty($rowFav['favmov3'])) {
                          $url = "https://api.themoviedb.org/3/movie/" . $rowFav['favmov3'] . "?api_key=$apikey&language=en-US";
                  
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          
                          $resp = curl_exec($ch);
                          
                          if($e = curl_error($ch)) {
                          	echo $e;
                          }
                          else {
                          	$decoded = json_decode($resp, true);
                            
                          }
                          
                        echo "
                    <div class='favMovDes' id='favmov3'><a href='movie-details.php?filmname=".$decoded['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovDes' id='favmov3'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    
                    if (!empty($rowFav['favmov4'])) {
                          $url = "https://api.themoviedb.org/3/movie/" . $rowFav['favmov4'] . "?api_key=$apikey&language=en-US";
                  
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          
                          $resp = curl_exec($ch);
                          
                          if($e = curl_error($ch)) {
                          	echo $e;
                          }
                          else {
                          	$decoded = json_decode($resp, true);
                            
                          }
                          
                        echo "
                    <div class='favMovDes' id='favmov4'><a href='movie-details.php?filmname=".$decoded['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovDes' id='favmov4'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    
                    if (!empty($rowFav['favmov5'])) {
                          $url = "https://api.themoviedb.org/3/movie/" . $rowFav['favmov5'] . "?api_key=$apikey&language=en-US";
                  
                          curl_setopt($ch, CURLOPT_URL, $url);
                          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                          
                          $resp = curl_exec($ch);
                          
                          if($e = curl_error($ch)) {
                          	echo $e;
                          }
                          else {
                          	$decoded = json_decode($resp, true);
                            
                          }
                          
                        echo "
                    <div class='favMovDes' id='favmov5'><a href='movie-details.php?filmname=".$decoded['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovDes' id='favmov5'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    } curl_close($ch); ?>
                </div>
		<?php
		if ($uid == $chkUser) {
		echo " <a href='edit_profile.php'><div class='editprofile'>
                  <span class='edittext'>EDIT PROFILE</span>
                </div></a>";
		} ?>
              </div>
            </div>

            <div class="container">
              <div class="profilenav">
                <a href='' class="navlink"><span class="navprof" id='testrev'>REVIEWS</span></a>
                <a href='' class="navlink"><span class="navprof">RECOMMENDATIONS</span></a>
              </div>
            </div>

            <div class='container'>
              <div class='reviews'>
                <span class='reviewHeader'>RECENT REVIEWS</span><hr class='line1'>
                <div class='userReviews'>
                  <div class='containerReview1'>
                    <div class='ratedMovieTitle'>Babylon</div>
                    <div class='ratedMovieYear'>2022</div>
                    <div class='user1'><?php echo $user["username"]; ?></div>
                    <div class='container'>
			<?php
				$resultImg->data_seek(0);
				while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
                        		echo "<img class='user1pic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
                		}	
                		else {
	                        echo "<img class='user1pic' src='uploads/profiledefault.jpg'>";
        	        	}	} ?>
                    </div>
                    <div class='user1review'>My mind is blown by every facet of this film. 
                      The acting. The script. The story. The directing. All of it was awful.
                       The worst movie I’ve seen in years</div>
                    <a href=''><img class='ratedMovie' src='images/babylon.jpg'></a>
                    <div class='user1stars'>
                      &#9733 &#9733 &#9733 &#9733
                    </div>
                    <hr class='hrLine2'>
                  </div>

                  <div class='containerReview2'>
                    <div class='ratedMovieTitle'>Babylon</div>
                    <div class='ratedMovieYear'>2022</div>
                    <div class='user1'><?php echo $user["username"]; ?></div>
                    <div class='container'>
			<?php
                                $resultImg->data_seek(0);
                                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
                                        echo "<img class='user1pic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
                                }
                                else {
                                echo "<img class='user1pic' src='uploads/profiledefault.jpg'>";
                                }       } ?>
                    </div>
                    <div class='user1review'>My mind is blown by every facet of this film. 
                      The acting. The script. The story. The directing. All of it was awful.
                       The worst movie I’ve seen in years</div>
                    <a href=''><img class='ratedMovie' src='images/babylon.jpg'></a>
                    <div class='user1stars'>
                      &#9733 &#9733 &#9733 &#9733
                    </div>
                    <hr class='hrLine2'>
                  </div>

                  <div class='containerReview3'>
                    <div class='ratedMovieTitle'>Babylon</div>
                    <div class='ratedMovieYear'>2022</div>
                    <div class='user1'><?php echo $user["username"]; ?></div>
                    <div class='container'>
			<?php
                                $resultImg->data_seek(0);
                                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
                                        echo "<img class='user1pic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
                                }
                                else {
                                echo "<img class='user1pic' src='uploads/profiledefault.jpg'>";
                                }       } ?>
                    </div>
                    <div class='user1review'>My mind is blown by every facet of this film. 
                      The acting. The script. The story. The directing. All of it was awful.
                       The worst movie I’ve seen in years</div>
                    <a href=''><img class='ratedMovie' src='images/babylon.jpg'></a>
                    <div class='user1stars'>
                      &#9733 &#9733 &#9733 &#9733
                    </div>
                    <hr class='hrLine2'>
                  </div>

                  <div class='containerReview4'>
                    <div class='ratedMovieTitle'>Babylon</div>
                    <div class='ratedMovieYear'>2022</div>
                    <div class='user1'><?php echo $user["username"]; ?></div>
                    <div class='container'>
			<?php
                                $resultImg->data_seek(0);
                                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
                                        echo "<img class='user1pic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
                                }
                                else {
                                echo "<img class='user1pic' src='uploads/profiledefault.jpg'>";
                                }       } ?>
                    </div>
                    <div class='user1review'>My mind is blown by every facet of this film. 
                      The acting. The script. The story. The directing. All of it was awful.
                       The worst movie I’ve seen in years</div>
                    <a href=''><img class='ratedMovie' src='images/babylon.jpg'></a>
                    <div class='user1stars'>
                      &#9733 &#9733 &#9733 &#9733
                    </div>
                    <hr class='hrLine2'>
                  </div>

                  <div class='containerReview5'>
                    <div class='ratedMovieTitle'>Babylon</div>
                    <div class='ratedMovieYear'>2022</div>
                    <div class='user1'><?php echo $user["username"]; ?></div>
                    <div class='container'>
			<?php
                                $resultImg->data_seek(0);
                                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
                                        echo "<img class='user1pic' src='uploads/profile".$chkUser.".jpg?'".mt_rand().">";
                                }
                                else {
                                echo "<img class='user1pic' src='uploads/profiledefault.jpg'>";
                                }       } ?>
                    </div>
                    <div class='user1review'>My mind is blown by every facet of this film. 
                      The acting. The script. The story. The directing. All of it was awful.
                       The worst movie I’ve seen in years</div>
                    <a href=''><img class='ratedMovie' src='images/babylon.jpg'></a>
                    <div class='user1stars'>
                      &#9733 &#9733 &#9733 &#9733
                    </div>
                    <hr class='hrLine2'>
                  </div>
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
    <script src='scripts.js'></script>
</html>
