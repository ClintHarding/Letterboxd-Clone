
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
            <link rel="stylesheet" href="searchmovies.css">
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <div class="container" id="myNav">
        <nav class="navbar navbar-expand-lg" id="customNav">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"><img src="/images/logo6.png" alt="" width="30" height="24" id="brandlog" class="d-inline-block align-text-top">
                CINE/SCORE</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">SIGN IN</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">CREATE ACCOUNT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">FILMS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">MEMBERS</a>
                  </li>
                </ul>
            </div>
             <!-- old form <form id="search-form">
                <input type="text" id="search-movies" name="search" class="nav-link searchBar" placeholder="Search for movie...">
                <button type="submit">Search</button>
              </form> -->


              
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
          <div id="backdrop" class="cool-image">
         <img id="backdrop-image" alt="Backdrop Image">
        </div>
          <div id="results"></div>
          <script src="movieinfo.js"></script>
            </section>
            <section>
            <div id="rate-movie" class="movie-item">
            <?php
$filmname = $_POST['filmname'];
$user_id = $_POST['user_id'];
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

echo "Filmname: " . $filmname . "<br>";
echo "User ID: " . $user_id . "<br>";
echo "Rating: " . $rating . "<br>";
?>
            rate movie here hehe
        </div>

        </section>
 
              <div class="footer">
                <div class="footertext">
                  <span class="footertitle">CINE/SCORE</span>
                </div>

              </div>
    </body>
</html>