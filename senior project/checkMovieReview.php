<?php 
function checkMovieReview($movie_id, $conn) {
    // Check for matching reviews
    $query = "SELECT reviews.*, profileimg.status FROM reviews JOIN users ON reviews.user_id = users.id LEFT JOIN profileimg ON users.id = profileimg.userid WHERE movie_id = '$movie_id' LIMIT 3";
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

        // Print user review container
        echo "<div class='containerReview" . $i . "'>";

        // Print user information
        echo "<div class='user1'>";
        echo "<span class='username'>" . $username . "</span>";
        echo "<span class='user1stars'>";
        for ($j = 0; $j < $row["score"]; $j++) {
            echo "&#9733;";
        }
        echo "</span>";
        echo "</div>";

        // Print user profile picture
        echo "<div class='container'><a href='profile.php?id=".$row['user_id']."'><img src='";
        if ($row['status'] == 0) {
          echo "uploads/profile".$row['user_id'].".jpg?" . mt_rand();
        } else {
          echo "uploads/profiledefault.jpg";
        }
        echo "' class='user1pic'></a></div>";

        // Print user review text
        echo "<div class='user1review'>" . $row['review'] . "</div>";

        // Print horizontal line separator
        echo "<hr class='hrLine2'>";

        // Close user review container
        echo "</div>";

        $i++;
      }
      echo "</div>";
    } else {
      echo "No reviews found for movie ";
    }
}
?>