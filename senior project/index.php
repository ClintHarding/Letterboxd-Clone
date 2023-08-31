<?php
// API CONNECTION 

$ch = curl_init();

$apikey = "7f0e42ab052fbd09ee9ddc86b625600a";
$url = "https://api.themoviedb.org/3/trending/movie/day?api_key=$apikey";

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$resp = curl_exec($ch);

if($e = curl_error($ch)) {
	echo $e;
}
else {
	$decoded = json_decode($resp, true);

}

curl_close($ch);
?>

<?php
//DATABASE CONNECTION
define("IN_CODE",1);
include("dbconfig.php"); //Change all php files to define dbconfig
include('checkMovieReviewGeneral.php');

session_start();


$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

error_reporting(E_ALL | E_STRICT); //turn on error display


$sql = "SELECT users.*, profileimg.status FROM users inner join profileimg on users.id = profileimg.userid LIMIT 5";
$result = mysqli_query($conn,$sql);


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
        <link rel='stylesheet' href='css.css'>
        <style>
          body {
            font-family: 'Roboto'; font-size: 12px;
          }
        </style>
    </head>
    <body>

	<?php if(!isset($_SESSION["user_id"])) {
	echo "
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
        <link rel='stylesheet' href='css.css'>
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
              <a class='navbar-brand' href='#'><img src='images/logo6.png' alt='' width='30' height='24' id='brandlog' class='d-inline-block align-text-top'>
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
        <script src='https://unpkg.com/react-dom@18/umd/react-dom.development.js' crossorigin></script>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href='indexlog.css'>
    </head>
    <body>


	<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
        <div class='container' id='myNav'>
        <nav class='navbar navbar-expand-lg' id='customNav'>
            <div class='container-fluid'>
              <a class='navbar-brand' href='#'><img src='images/logo6.png' alt='' width='30' height='24' id='brandlog' class='d-inline-block align-text-top'>
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
                      <a class='dropdown-item' href='#'>Reviews</a>
                      <a class='dropdown-item' href='recommendations.php'>Recommendations</a>
                      <hr>
                      <a class='dropdown-item' href='logout.php'>Log Out</a>
                    </div><li class='nav-item'>
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
          </div>";

	}
	
	?>

          <section>
          <!-- Outside Nav bar-->
	 <?php if(!isset($_SESSION["user_id"])) {
	   echo "
            <div id='homeImage'>
              <div class='homeText text-center fw-bold'>Track films your favorite films!<br>
							      See what your friends are watching<br>
                                                              Tell your friends what's good. <br></div>
                                                              <button type='button' class='button-18' id='regButt'>GET STARTED!</button>
							      <br><span class='descweb'>A Film Social Network For Kean Alumni!</span>
            </div>
		";
		} else {
		echo "<div class='home-container'><div class='homeText text-center fw-bold'>Welcome, $user!<br>
                                                              Track your favorite films! <br></div>
                                                              <button type='button' class='button-18' id='regButt'>PROFILE</button></div>
                                                              <br><span class='descmovs'>Trending Movies</span><hr class='homeline'>
		";
}
 ?>
		<div class='container'>	
              <div class='recentMovs'>
		<?php
		$movie_in = 0;
		for ($x=0; $x < 5; $x++) {
		echo "<div class='mov1'><a href='movie-details.php?filmname=".$decoded['results'][$movie_in]['id']."'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['results'][$movie_in]['poster_path'] . "'></a></div>";
		$movie_in++;
		}
		?>
	   </div>
           </div>
          </section>

            <section>
	 <section>
            <?php
            echo "

              <div class='reviews'>
                <span class='reviewHeader'>RECENT REVIEWS</span><hr class='line1'>
                <div class='userReviews'>
                ";
                checkMovieReviewGeneral($conn);
                echo "</div></div>";
          ?>

</section>


	</div>
	</div>
	</div>

	 <?php if(isset($_SESSION["user_id"])) {
	echo "<div class='members'>
        <span class='memberHeader'>RECENT MEMBERS</span><hr class='linemov'>
        <div class='recentmembers'>";


	$sqlMember = "SELECT users.id, users.username, profileimg.status from users inner join profileimg on users.id = profileimg.userid LIMIT 8";
	$resultMembers = mysqli_query($conn, $sqlMember);
	while ($row = mysqli_fetch_assoc($resultMembers)) {
	echo "<div class='box'>";
		 if ($row['status'] == 0) {
		echo "<a href='profile.php?id=".$row['id']."'><img class='memberpic' src='uploads/profile".$row['id'].".jpg?'".mt_rand()."></a><br>";
                }
                else {
                        echo "<a href='profile.php?id=".$row['id']."'><img class='memberpic' src='uploads/profiledefault.jpg'></a><br>";
                } echo "
		<span class='membername'><a class='nav-link2' href='profile.php?id=".$row['id']."'>".$row['username']."</a></span>
		</div>";
}} ?>

	   </div>
	   </div>
            </section>

      
              <section>
              <div class='footer'>
		<div class='footertext'>
	          <nav class="navbar navbar-expand-lg" id='customNav2'>
  		  <a class="navbar-link2 footbrand" href="#">CINE/SCORE</a>
  		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
   		  	<span class="navbar-toggler-icon"></span>
  		  </button>
  		  <div class="collapse navbar-collapse" id="navbarNav">
    		  <ul class="navbar-nav">
      			<li class="nav-item active">
        			<a class="nav-link2 footbrand" href="#">ABOUT</a>
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
