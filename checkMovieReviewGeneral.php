<?php
function checkMovieReviewGeneral($conn) {
    // Check for matching reviews
    $query = "SELECT reviews.*, profileimg.status FROM reviews JOIN users ON reviews.user_id = users.id LEFT JOIN profileimg ON users.id = profileimg.userid  LIMIT 3";
    $result = mysqli_query($conn, $query);

    // Print row information if matching review found
    if (mysqli_num_rows($result) > 0) {
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Get username from users table based on id
            $user_id = $row['user_id'];
            $query_user = "SELECT username FROM users WHERE id = '$user_id'";
            $result_user = mysqli_query($conn, $query_user);
            $row_user = mysqli_fetch_assoc($result_user);
            $username = $row_user['username'];

            // Get movie information from API
            $movie_id = $row['movie_id'];
            $movie_url = "https://api.themoviedb.org/3/movie/" . $movie_id . "?api_key=7f0e42ab052fbd09ee9ddc86b625600a";
            $movie_json = file_get_contents($movie_url);
            $movie_data = json_decode($movie_json, true);
            $movie_name = $movie_data['title'];
            $movie_poster_path = $movie_data['poster_path'];

            // Print user review container
            echo "<div class='containerReview" . $i . "'>";

            // Print movie information
            echo "<div class='ratedMovieTitle'>" . $movie_name . "</div>";

            // Print user information
            echo "<div class='user1'>" . $username . "</div>";
            echo "<div class='container'>";
            echo "</div>";

            // Print user review text
            echo "<div class='user1review'>" . $row['review'] . "</div>";

            // Print movie poster
            echo "<a href='movie-details.php?filmname=${movie_id}'><img class='ratedMovie' src='https://image.tmdb.org/t/p/w500" . $movie_poster_path . "'></a>";

            // Print user rating stars
            echo "<div class='user1stars'>";
            for ($j = 0; $j < $row["score"]; $j++) {
                echo "&#9733;";
            }
            echo "</div>";

            // Print horizontal line separator
            echo "<hr class='hrLine2'>";

            // Close user review container
            echo "</div>";

            $i++;
        }
        echo "</div>";
    } 
}
?>