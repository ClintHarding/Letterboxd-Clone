<?php
//DATABASE CONNECTION
define("IN_CODE",1);
include("dbconfig.php"); //Change all php files to define dbconfig
SESSION_START();
$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

error_reporting(E_ALL | E_STRICT);

$uid = $_SESSION['user_id'];

$query = "SELECT * FROM users WHERE id = $uid";
$results = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($results);

$queryImg = "SELECT * FROM profileimg WHERE userid='$uid'";
$resultImg = mysqli_query($conn, $queryImg);

$queryFav = "SELECT * FROM favmovie WHERE user_id='$uid'";
$resultFav = mysqli_query($conn, $queryFav);
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>
        <link rel='stylesheet' href='edit_profile.css'>
        <style>
          body {
            font-family: 'Roboto'; font-size: 12px;
          }
          .popup {
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              background-color: rgba(0, 0, 0, 0.5);
              display: none;
            }
            
            .popup-content {
              background-color: #fff;
              width: 50%;
              margin: 10% auto;
              padding: 20px;
              border-radius: 5px;
              box-shadow: 0px 0px 10px #000;
            }
            
            .popup-content h2 {
              margin-top: 0;
            }
            
            .popup-content form label {
              display: block;
              margin-bottom: 10px;
            }
            
            .popup-content form input[type="text"] {
              width: 100%;
              padding: 10px;
              border-radius: 5px;
              border: 1px solid #ccc;
              margin-bottom: 10px;
            }
            
            .popup-content form button[type="submit"] {
              background-color: #4CAF50;
              color: #fff;
              border: none;
              padding: 10px 20px;
              border-radius: 5px;
              cursor: pointer;
            }
            
            .dropdown-content {
                display: none;
                position: absolute;
                z-index: 1;
                background-color: #f1f1f1;
                width: 40%;
                border: 1px solid #ddd;
                max-height: 200px;
                overflow-y: scroll;
              }
              
              .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
              }
              
              .dropdown-content a:hover {
                background-color: #ddd;
              }
              
              .popup.open { display: block; }

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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?php echo $user['username']; ?></a>
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
                <span class="settings">Account Settings</span><hr class="accountline">
		<div class="profiledetails">
		<?php 
		while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                        if ($rowImg['status'] == 0) {
			echo "<img class='settingspic' src='uploads/profile".$uid.".jpg?'".mt_rand().">";
		}
		else {
			echo "<img class='settingspic' src='uploads/profiledefault.jpg'>";
		}} ?>
                  <form class="pic-edit" action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <button type="submit" name="submit">UPLOAD</button>
                  </form>

                <form class="editform">
                  <div class="mb-3">
                    <label for="disabledTextInput" class="formlabel">Username</label>
                    <input type="text" class="form-control" id="disabledTextInput" placeholder="hardingc" disabled>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="formlabel">First Name</label>
                <input type="text" class="form-control" id="exampleInputPassword1">
               </div>
               <div class="mb-3">
                <label for="exampleInputPassword1" class="formlabel">Last Name</label>
                <input type="text" class="form-control" id="exampleInputPassword1">
               </div>
               <div class="mb-3">
                <label for="exampleInputPassword1" class="formlabel">Location</label>
                <input type="text" class="form-control" id="exampleInputPassword1">
               </div>
                <button type="submit" class="btn btn-success">Update</button>
              </form>
              </div>
              <div class="favoritefilms">
                <span class="favheader">Favorite Films</span>
                <span class="favheader2">Click to Change</span>
                <div class="favmov">
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
                    <div class='favMovPic' id='favmov1'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovPic' id='favmov1'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
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
                    <div class='favMovPic' id='favmov2'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovPic' id='favmov2'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
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
                    <div class='favMovPic' id='favmov3'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovPic' id='favmov3'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
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
                    <div class='favMovPic' id='favmov4'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovPic' id='favmov4'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
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
                    <div class='favMovPic' id='favmov5'><img class='homeMovies' src='https://image.tmdb.org/t/p/w500" . 
		$decoded['poster_path'] . "' onclick='showPopup()'></a></div>
                    ";
                    }
                    else {
                    echo "
                    <div class='favMovPic' id='favmov5'><img class='homeMovies' src='images/missing_mov.jpg' onclick='showPopup()'></a></div>
                    ";
                    }
                    } curl_close($ch); ?>
                </div>
              </div>
              </div>
              
              <div id="popup" class="popup">
                <div class="popup-content">
                  <h2>Search for your favorite movie</h2>
                  <form id="search-form">
                    <label for="search-input">Enter your search term:</label>
                    <input type="text" id="search-input" name="search-input">
                    <button type="submit" onclick="hidePopup()">Close</button>

                    
                    <div id="search-results" class="dropdown-content"></div>
                    
                  </form>
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
  
    <script>
    var movieTile;
    var favmovie1 = document.getElementById('favmov1');
    var favmovie2 = document.getElementById('favmov2');
    var favmovie3 = document.getElementById('favmov3');
    var favmovie4 = document.getElementById('favmov4');
    var favmovie5 = document.getElementById('favmov5');
    
    favmovie1.style.cursor = 'pointer';
    favmovie2.style.cursor = 'pointer';
    favmovie3.style.cursor = 'pointer';
    favmovie4.style.cursor = 'pointer';
    favmovie5.style.cursor = 'pointer';
    
    
    
    const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');
const popup = document.getElementById('popup');
const searchForm = document.getElementById('search-form');

function showPopup() {
  popup.style.display = 'block';
};
function hidePopup() {
  popup.style.display = 'none';
};

favmovie1.addEventListener('click', () => {
    movieTile = 1
    console.log(movieTile);
});

favmovie2.addEventListener('click', () => {
    movieTile = 2
    console.log(movieTile);
});

favmovie3.addEventListener('click', () => {
    movieTile = 3
    console.log(movieTile);
});

favmovie4.addEventListener('click', () => {
    movieTile = 4
    console.log(movieTile);
});

favmovie5.addEventListener('click', () => {
    movieTile = 5
    console.log(movieTile);
});

searchInput.addEventListener('input', () => {
  // Get search query
  const query = searchInput.value.trim().toLowerCase();

  // Clear previous search results
  searchResults.innerHTML = '';

  // Perform search
  const apiUrl = 'https://api.themoviedb.org/3/search/movie?api_key=7f0e42ab052fbd09ee9ddc86b625600a&query=';
  const url = new URL(apiUrl + query);

  fetch(url)
    .then(response => response.json())
    .then(data => {
      // Handle the search results
      console.log(data);
      if (data.results.length > 0) {
        data.results.forEach(result => {
          const link = document.createElement('a');
          link.href = "addfavorite.php?filmname=" + result.id + "&tile=" + movieTile;
          link.textContent = result.title;
          searchResults.appendChild(link);
        });
        searchResults.style.display = 'block';
      } else {
        searchResults.style.display = 'none';
      }
    })
    .catch(error => {
      // Handle any errors
      console.error(error);
    });
});

    </script>

    </body>
    <script src='scripts.js'></script>
</html>
