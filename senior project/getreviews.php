<?php

function display_reviews_for_film() {
    // Get the film name from the URL
    $filmname = $_GET['filmname'];
    
    // Import the database configuration parameters
    require 'dbconfig.php';
    
    // Create a database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
  
    // Check the connection
    if (!$conn) {
      die('Connection failed: ' . mysqli_connect_error());
    }
  
    // Select the reviews for the film with the given name
    $sql = "SELECT * FROM reviews WHERE movie_id = '$filmname'";
    $result = mysqli_query($conn, $sql);
    
    // Check if any reviews were found
    if (mysqli_num_rows($result) > 0) {
      // Output the reviews
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="review-item">';
        echo '<p><strong>Review:</strong> ' . $row['review'] . '</p>';
        echo '<p><strong>User:</strong> ' . $row['user_id'] . '</p>';
        echo '</div>';
      }
    } else {
      echo 'No reviews found.';
    }
    
    // Close the database connection
    mysqli_close($conn);
  }

?>