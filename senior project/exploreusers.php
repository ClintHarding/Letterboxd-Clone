<?php
// Function to retrieve the 5 movie IDs with the highest ID value from the database
function getMovieIdsWithHighestId() {
  include("dbconfig.php");
  $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";

  $conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); 

  $query = "SELECT DISTINCT movie_id FROM reviews ORDER BY id DESC LIMIT 5";
  $result = mysqli_query($conn, $query);
  $movieIds = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $movieIds[] = $row['movie_id'];
  }
  return $movieIds;
}

// Function to display the movie posters given the movie IDs
function displayMoviePosters($movieIds) {
  $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
  foreach ($movieIds as $movieId) {
    $url = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}";
    $response = json_decode(file_get_contents($url), true);
    $posterPath = $response['poster_path'];
    if ($posterPath) {
      $imageUrl = "https://image.tmdb.org/t/p/w200{$posterPath}";
      $movieTitle = $response['title'];
      echo "<a href='movie-details.php?filmname={$movieId}' style='link'>";
      echo "<img src='{$imageUrl}' alt='{$movieTitle} movie poster' width='173' height='260'>";
      echo "</a>";
    }
  }
}

function getMovieIdsWithHighestScore() {
    include("dbconfig.php");
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
  
    $conn = mysqli_connect($host, $username, $password, $dbname)
      or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
      mysqli_connect_error()); 
  
    $query = "SELECT DISTINCT movie_id FROM reviews ORDER BY score DESC LIMIT 5";
    $result = mysqli_query($conn, $query);
    $movieIds = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $movieIds[] = $row['movie_id'];
    }
    return $movieIds;
  }

function displayMoviePostersWithHighestScore() {
    $movieIds = getMovieIdsWithHighestScore();
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
    foreach ($movieIds as $movieId) {
      $url = "https://api.themoviedb.org/3/movie/{$movieId}?api_key={$apiKey}";
      $response = json_decode(file_get_contents($url), true);
      $posterPath = $response['poster_path'];
      if ($posterPath) {
        $imageUrl = "https://image.tmdb.org/t/p/w200{$posterPath}";
        $movieTitle = $response['title'];
        echo "<a href='movie-details.php?filmname={$movieId}' style='link'>";
        echo "<img src='{$imageUrl}' alt='{$movieTitle} movie poster' width='173' height='260'>";
        echo "</a>";
      }
    }
  }



// Call the function to display the movie posters
$movieIds = getMovieIdsWithHighestId();
$moviehighest = getMovieIdsWithHighestScore();

?>