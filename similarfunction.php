<?php

    function getTopMovieAndSimilar($uid, $apiKey) {
        // Connect to MySQL database
        include("dbconfig.php");
  
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

        // Prepare SQL statement to retrieve top rated movie for user
        $highest_rated_genre = mysqli_prepare($conn, "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1");
            mysqli_stmt_bind_param($highest_rated_genre, "i", $uid);
            mysqli_stmt_execute($highest_rated_genre);
            mysqli_stmt_bind_result($highest_rated_genre, $topMovieId);
            mysqli_stmt_fetch($highest_rated_genre);
            mysqli_stmt_close($highest_rated_genre);

            // Prepare API request URL
            $apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "/similar?api_key=" . $apiKey;

            // Send API request and get response
            $response = file_get_contents($apiUrl);
            $data = json_decode($response, true);

            // Get the first 5 similar movies
            $similarMovies = array_slice($data["results"], 0, 6);

            // Prepare the HTML output
            $output = "";
            foreach ($similarMovies as $movie) {
                $posterUrl = "https://image.tmdb.org/t/p/w200" . $movie["poster_path"];
                $output .= "<a href='movie-details.php?filmname={$movie["id"]}' style='link'>";
                $output .= "<img src='$posterUrl' alt='{$movie["title"]} movie poster' width='173' height='260'>";
                $output .= "</a>";
            }
            return $output;
            }

    function getTopMovieTitle($uid, $conn) {
        $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
        
        
        // Prepare SQL statement to retrieve top rated movie for user
        $highest_rated_movie = mysqli_prepare($conn, "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1");
        mysqli_stmt_bind_param($highest_rated_movie, "i", $uid);
        mysqli_stmt_execute($highest_rated_movie);
        mysqli_stmt_bind_result($highest_rated_movie, $topMovieId);
        mysqli_stmt_fetch($highest_rated_movie);
        mysqli_stmt_close($highest_rated_movie);
    
        // Prepare API request URL to get the movie details
        $apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "?api_key=" . $apiKey;
    
        // Send API request and get response
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
    
        // Get the title of the top rated movie
        $top_movie_name = $data['title'];
    
        // Return the movie title
        return $top_movie_name;
  }

  function getTopGenre($uid, $apiKey, $conn) {
    include("dbconfig.php");
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";

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

    // Get user's top rated genre
    $query = "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1";
$highest_rated_movie = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($highest_rated_movie, "i", $uid);
mysqli_stmt_execute($highest_rated_movie);
mysqli_stmt_bind_result($highest_rated_movie, $topMovieId);
mysqli_stmt_fetch($highest_rated_movie);
mysqli_stmt_close($highest_rated_movie);

// Get the genre for the top rated movie
$apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "?api_key=" . $apiKey;
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
$topGenre = $data['genres'][0]['id'];

    // Prepare API request URL
    $apiUrl = "https://api.themoviedb.org/3/discover/movie?api_key=" . $apiKey . "&sort_by=vote_average.desc&vote_count.gte=500&with_genres=" . $topGenre;

    // Send API request and get response
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Get the first 5 movies
    $topMovies = array_slice($data["results"], 0, 6);

    // Prepare the HTML output
    $output = "";
    foreach ($topMovies as $movie) {
        $posterUrl = "https://image.tmdb.org/t/p/w200" . $movie["poster_path"];
        $output .= "<a href='movie-details.php?filmname={$movie["id"]}' style='link'>";
        $output .= "<img src='$posterUrl' alt='{$movie["title"]} movie poster' width='173' height='260'>";
        $output .= "</a>";
    }
    return $output;
}

function getTopGenreName($uid, $conn) {
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
    
    // Prepare SQL statement to retrieve movie with highest rating for user
    $highest_rated_movie = mysqli_prepare($conn, "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1");
    mysqli_stmt_bind_param($highest_rated_movie, "i", $uid);
    mysqli_stmt_execute($highest_rated_movie);
    mysqli_stmt_bind_result($highest_rated_movie, $topMovieId);
    mysqli_stmt_fetch($highest_rated_movie);
    mysqli_stmt_close($highest_rated_movie);

    // Prepare API request URL to get the movie details
    $apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "?api_key=" . $apiKey;

    // Send API request and get response
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Get the genre of the top rated movie
    $top_genre_name = $data['genres'][0]['name'];

    // Return the genre name
    return $top_genre_name;
}

function get2ndTopGenre($uid, $apiKey, $conn) {
    include("dbconfig.php");
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";

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

    // Get user's top rated genre
    $query = "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1 OFFSET 4";
$highest_rated_movie = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($highest_rated_movie, "i", $uid);
mysqli_stmt_execute($highest_rated_movie);
mysqli_stmt_bind_result($highest_rated_movie, $topMovieId);
mysqli_stmt_fetch($highest_rated_movie);
mysqli_stmt_close($highest_rated_movie);

// Get the genre for the top rated movie
$apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "?api_key=" . $apiKey;
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
$topGenre = $data['genres'][0]['id'];

    // Prepare API request URL
    $apiUrl = "https://api.themoviedb.org/3/discover/movie?api_key=" . $apiKey . "&sort_by=vote_average.desc&vote_count.gte=500&with_genres=" . $topGenre;

    // Send API request and get response
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Get the first 5 movies
    $topMovies = array_slice($data["results"], 0, 6);

    // Prepare the HTML output
    $output = "";
    foreach ($topMovies as $movie) {
        $posterUrl = "https://image.tmdb.org/t/p/w200" . $movie["poster_path"];
        $output .= "<a href='movie-details.php?filmname={$movie["id"]}' style='link'>";
        $output .= "<img src='$posterUrl' alt='{$movie["title"]} movie poster' width='173' height='260'>";
        $output .= "</a>";
    }
    return $output;
}

function get2ndTopGenreName($uid, $conn) {
    $apiKey = "7f0e42ab052fbd09ee9ddc86b625600a";
    
    // Prepare SQL statement to retrieve movie with highest rating for user
    $highest_rated_movie = mysqli_prepare($conn, "SELECT movie_id FROM cinescore.reviews WHERE user_id = ? ORDER BY score DESC LIMIT 1 OFFSET 4");
    mysqli_stmt_bind_param($highest_rated_movie, "i", $uid);
    mysqli_stmt_execute($highest_rated_movie);
    mysqli_stmt_bind_result($highest_rated_movie, $topMovieId);
    mysqli_stmt_fetch($highest_rated_movie);
    mysqli_stmt_close($highest_rated_movie);

    // Prepare API request URL to get the movie details
    $apiUrl = "https://api.themoviedb.org/3/movie/" . $topMovieId . "?api_key=" . $apiKey;

    // Send API request and get response
    $response = file_get_contents($apiUrl);
    $data = json_decode($response, true);

    // Get the genre of the top rated movie
    $second_top_genre_name = $data['genres'][0]['name'];

    // Return the genre name
    return $second_top_genre_name;
}


function getMovieIds($userId, $conn) {
    $stmt = mysqli_prepare($conn, "SELECT movie_id FROM cinescore.reviews WHERE user_id = ?");
    if (!$stmt || !mysqli_stmt_bind_param($stmt, "i", $userId) || !mysqli_stmt_execute($stmt)) {
        die("Error preparing/executing statement: " . mysqli_error($conn));
    }
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die("Error getting result set: " . mysqli_error($conn));
    }
    $movieIds = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return array_column($movieIds, "movie_id");
}


function getTopDirectorFromUserReviews($userId, $apiKey, $conn) {
    $query = "SELECT movie_id FROM cinescore.reviews WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Error preparing statement: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "i", $userId);
    if (!mysqli_stmt_execute($stmt)) {
        die("Error executing statement: " . mysqli_stmt_error($stmt));
    }
    mysqli_stmt_bind_result($stmt, $movieId);
    $movieIds = array();
    while (mysqli_stmt_fetch($stmt)) {
        $movieIds[] = $movieId;
    }
    mysqli_stmt_close($stmt);
    $directors = array();
    $movieTitles = array();
    foreach ($movieIds as $movieId) {
        $apiUrl = "https://api.themoviedb.org/3/movie/" . $movieId . "?api_key=" . $apiKey;
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
        $movieTitle = $data['title'];
        $movieTitles[$movieId] = $movieTitle;
        $crew = $data['credits']['crew'];
        foreach ($crew as $member) {
            if ($member['job'] == "Director") {
                $directors[$member['name']] = isset($directors[$member['name']]) ? $directors[$member['name']] + 1 : 1;
            }
        }
    }
    arsort($directors);
    $topDirectors = array();
    $maxCount = reset($directors);
    foreach ($directors as $director => $count) {
        if ($count == $maxCount) {
            $topDirectors[] = $director;
        } else {
            break;
        }
    }
    $topDirector = isset($topDirectors[0]) ? $topDirectors[0] : '';
    $topDirectorMovies = array();
    foreach ($movieTitles as $movieId => $movieTitle) {
        $apiUrl = "https://api.themoviedb.org/3/movie/" . $movieId . "?api_key=" . $apiKey;
        $response = file_get_contents($apiUrl);
        $data = json_decode($response, true);
        $crew = $data['credits']['crew'];
        foreach ($crew as $member) {
            if ($member['job'] == "Director" && $member['name'] == $topDirector) {
                $topDirectorMovies[$movieId] = $movieTitle;
            }
        }
    }
    return $topDirectorMovies;
}

function getTopDirectorMovies($userId, $apiKey, $conn) {
    $topDirector = getTopDirectorFromUserReviews($userId, $apiKey, $conn);
    $apiUrl = "https://api.themoviedb.org/3/search/person?api_key={$apiKey}&query=" . urlencode($topDirector);
    $response = json_decode(file_get_contents($apiUrl), true);
    $directorId = $response['results'][0]['id'];
    $apiUrl = "https://api.themoviedb.org/3/discover/movie?api_key={$apiKey}&sort_by=release_date.desc&vote_count.gte=500&with_crew={$directorId}";
    $response = json_decode(file_get_contents($apiUrl), true);
    $topMovies = array_slice($response['results'], 0, 5);
    $output = "";
    foreach ($topMovies as $movie) {
        $posterUrl = "https://image.tmdb.org/t/p/w200" . $movie["poster_path"];
        $output .= "<a href='movie-details.php?filmname={$movie["id"]}' style='link'>";
        $output .= "<img src='" . $posterUrl . "' alt='" . $movie["title"] . " movie poster' width='173' height='260'>";
        $output .= "</a>";
    }
    return $output;
}