<?php
//DATABASE CONNECTION
define("IN_CODE",1);
include("dbconfig.php"); //Change all php files to define dbconfig

session_start();


$conn = mysqli_connect($host, $username, $password, $dbname)
    or die("<br>Cannot connect to DB $dbname on $servername ERROR:" .
    mysqli_connect_error()); //create dbname variable and dbconfig

error_reporting(E_ALL | E_STRICT); //turn on error display


$sql = "SELECT users.id, users.username, profileimg.status FROM users inner join profileimg on users.id = profileimg.userid LIMIT 20";
$result = mysqli_query($conn,$sql);

$users = array();

while ($row = mysqli_fetch_assoc($result)) {
  $users[] = $row;
  }


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
          .container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			padding: 20px;
		}

		.user {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin: 10px;
			cursor: pointer;
		}

		.user img {
			border-radius: 50%;
			width: 100px;
			height: 100px;
			object-fit: cover;
		}

		.user p {
			margin: 10px 0 0 0;
		}

		#user_search {
			font-size: 16px;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			margin-bottom: 20px;
			width: 100%;
			max-width: 500px;
      color: black;
      margin: 0 auto;
		}

    h1 {
      color: #b6decb;
    }

    .ourusers {
      color: #b6decb;
    }
    
    .mysearch {
      text-align: center;
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
                    <a class='nav-link' href='#'>FILMS</a>
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
        <style>
        .container {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
			align-items: center;
			padding: 20px;
		}

		.user {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin: 10px;
			cursor: pointer;
		}

		.user img {
			border-radius: 50%;
			width: 100px;
			height: 100px;
			object-fit: cover;
		}

		.user p {
			margin: 10px 0 0 0;
		}

		#user_search {
			font-size: 16px;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			margin-bottom: 20px;
			width: 100%;
			max-width: 500px;
      color: black;
      margin: 0 auto;
		}

    h1 {
      color: #b6decb;
    }

    .ourusers {
      color: #b6decb;
    }
    
    .mysearch {
     text-align: center;
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
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDarkDropdownMenuLink' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>$user</a>
                    <div class='dropdown-options' aria-labelledby='navbarDropdown'>
                      <a class='dropdown-item' href='index.php'>Home</a>
                      <a class='dropdown-item' href='profile.php'>Profile</a>
                      <a class='dropdown-item' href='#'>Reviews</a>
                      <a class='dropdown-item' href='#'>Recommendations</a>
                      <hr>
                      <a class='dropdown-item' href='logout.php'>Log Out</a>
                    </div><li class='nav-item'>
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
          </div>";

	}
	
	?>

          <!-- Outside Nav bar-->
          <section>
            <h1 class="text-center">Search Members</h1>
            <div class='mysearch'>
	<input type="text" id="user_search" placeholder="">
 </div>
	<div class="container" id="users"></div>

          
<script>
		// Example users data
   const users = <?php echo json_encode($users); ?>;

		// Display users
		function displayUsers(users) {
			const container = document.getElementById('users');
			container.innerHTML = '';
			for (let i = 0; i < users.length; i++) {
				const user = users[i];
				const userEl = document.createElement('div');
				userEl.classList.add('user');
        <?php 
        $result->data_seek(0);
        while ($row = mysqli_fetch_assoc($result)) {
        if ($row['status'] == 0) {
        echo 'userEl.innerHTML = `
					<a href="profile.php?id=${user.id}"><img src="uploads/profile${user.id}.jpg?"></a>
						<a href="profile.php?id=${user.id}"><p class="ourusers">${user.username}</p></a>
				`;';}
        else {
          echo 'userEl.innerHTML = `
					<a href="profile.php?id=${user.id}"><img src="uploads/profiledefault.jpg" alt="${user.username}"></a>
					<a href="profile.php?id=${user.id}"><p class="ourusers">${user.username}</p></a>
				`;';}
        } ?>
        container.appendChild(userEl);
			}
		}

		// Search users
		function searchUsers() {
			const searchValue = document.getElementById('user_search').value.toLowerCase();
			const filteredUsers = users.filter(user => user.username.toLowerCase().includes(searchValue));
			displayUsers(filteredUsers);
		}

		// Initial display
		displayUsers(users);

		// Search on input change
		document.getElementById('user_search').addEventListener('input', searchUsers);
	</script>
            
           
                
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
</html>
