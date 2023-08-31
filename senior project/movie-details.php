
<?php
//DATABASE CONNECTION
define("IN_CODE",1);
include("dbconfig.php"); //Change all php files to define dbconfig
include('checkMovieReview.php');


session_start();


$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

error_reporting(E_ALL | E_STRICT); //turn on error display


$sql = "SELECT users.*, profileimg.status FROM users inner join profileimg on users.id = profileimg.userid LIMIT 5";
$result = mysqli_query($conn,$sql);

$movie_id = $_GET['filmname']; 

?>
<?php if(!isset($_SESSION["user_id"])) {
	echo "
	<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
         <!-- Load React. -->
         <!-- Note: when deploying, replace 'development.js' with 'production.min.js'. -->
        <script src='https://unpkg.com/react@18/umd/react.development.js' crossorigin></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js'></script>
        <script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js' crossorigin></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href='searchmovies.css'>
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
              <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav'>
                  <li class='nav-item'>
                    <a class='nav-link' aria-current='page' href='signin.php'>SIGN IN</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='create_account.php'>CREATE ACCOUNT</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='explore.php'>FILMS</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='search_users.php'>MEMBERS</a>
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

	   ";
	} else {
	$user = $_SESSION['user'];


	echo "
	<html lang='en'>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1, minimum-scale=1' />
         <!-- Load React. -->
         <!-- Note: when deploying, replace 'development.js' with 'production.min.js'. -->
        <script src='https://unpkg.com/react@18/umd/react.development.js' crossorigin></script>
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js'></script>
        <script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js' crossorigin></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href='searchmovies.css'>
	
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
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDarkDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$user</a>
                    <div class='dropdown-options' aria-labelledby='navbarDropdown'>
                      <a class='dropdown-item' href='index.php'>Home</a>
                      <a class='dropdown-item' href='profile.php'>Profile</a>
                      <a class='dropdown-item' href='explore.php'>Explore</a>
                      <a class='dropdown-item' href='recommendations.php'>Recommendations</a>
                      <hr>
                      <a class='dropdown-item' href='logout.php'>Log Out</a>
                    </div><li class='nav-item'>
                    <a class='nav-link' href='explore.php'>EXPLORE</a>
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
          </div>";

	}
	
	?>
          <section>
          <div id="backdrop" class="cool-image">
         <img id="backdrop-image" alt="Backdrop Image">
        </div>
          <div id="results"></div>
          <script src="movieinfo.js"></script>
            </section>

            <section>
            <div id="rate-movie" class="movie-item">
            Rate Movie
        </div>
		
	<div class="movie-item">
    <form action="insert_review.php?filmname="${movie_id}"" method="post">
    <input type="hidden" name="movie_id_from_url" value="<?php echo $_GET['filmname']; ?>">
    <input type="hidden" name="user_id_for_submit" value="<?php echo $user_id; ?>">
    <input type="hidden" id="starscore" name="starscore" value="">
    <input type="text" name="reviewcommenttext">
    <span class="star" data-value="1">&#9733;</span>
    <span class="star" data-value="2">&#9733;</span>
    <span class="star" data-value="3">&#9733;</span>
    <span class="star" data-value="4">&#9733;</span>
    <span class="star" data-value="5">&#9733;</span>
    <button type="submit">Submit</button>
  </form>
</div>

	 <section>
            <?php
            echo "

              <div class='reviews'>
                <span class='reviewHeader'>RECENT REVIEWS</span><hr class='line1'>
                <div class='userReviews'>
                ";
                checkMovieReview($movie_id, $conn);
                echo "</div></div>";
          ?>

</section>
<script>
  var stars = document.querySelectorAll(".star");
  var ratingInput = document.querySelector("#starscore");
  
  function highlightStars(value) {
    for (var i = 0; i < stars.length; i++) {
      if (i < value) {
        stars[i].classList.add("selected");
      } else {
        stars[i].classList.remove("selected");
      }
    }
  }
  
  function resetStars() {
    for (var i = 0; i < stars.length; i++) {
      stars[i].classList.remove("hover");
    }
  }
  
  for (var i = 0; i < stars.length; i++) {
    stars[i].addEventListener("mouseover", function() {
      highlightStars(parseInt(this.getAttribute("data-value")));
    });
    
    stars[i].addEventListener("mouseout", function() {
      resetStars();
    });
    
    stars[i].addEventListener("click", function() {
      var value = parseInt(this.getAttribute("data-value"));
	console.log(value);
	$("#starscore").val(value);
      highlightStars(value);
    });
  }
</script>        </section>
 
              <div class="footer">
                <div class="footertext">
                  <span class="footertitle">CINE/SCORE</span>
                </div>

              </div>
    </body>
</html>
