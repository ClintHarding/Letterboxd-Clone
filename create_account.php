
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
        <link rel="stylesheet" href="signin.css">
        <script src="searchscript.js"></script>
        <style>
          body {
            font-family: 'Roboto'; font-size: 12px;
          }
        </style>
    </head>
    <body id="main">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <div class="container" id="myNav">
        <nav class="navbar navbar-expand-lg" id="customNav">
            <div class="container-fluid">
              <a class="navbar-brand" href="index.php"><img src="images/logo6.png" alt="" width="30" height="24" id="brandlog" class="d-inline-block align-text-top">
                CINE/SCORE</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="signin.php">SIGN IN</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="create_account.php">CREATE ACCOUNT</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">FILMS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link">MEMBERS</a>
                  </li>
                </ul>

                <div class="nav-link searchBar" id="search">
                  <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="" value="" />
                  <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="rgb(196, 239, 215)" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </nav>
          </div>
          <!-- Outside Nav bar-->

          <section>
            <div class="container">
                <span class="acc_create">CREATE AN ACCOUNT</span><hr class="accountline">
              <div class="createaccdetails">
                <form class="sign" action="insert_account.php" method="POST">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="formlabel">Email</label>
                    <input type="text" class="form-control emaillength" name="email" id="exampleInputEmail1" placeholder="" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="formlabel">Username</label>
                <input type="text" class="form-control emaillength" name="username" id="exampleInputEmail1" placeholder="" required>
          </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="formlabel">Password</label>
                <input type="text" class="form-control" name="password" id="exampleInputPassword1" required>
               </div>
                <button type="submit" class="btn btn-success">Submit</button>
              </form>
              </div>
              </div>
              </div>
          </section>

           <section>
              <div class='footer'>
		        <div class='footertext'>
	          <nav class="navbar navbar-expand-lg" id='customNav2'>
  		  <a class="footbrand" href="#">CINE/SCORE</a>
  		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
   		  	<span class="navbar-toggler-icon"></span>
  		  </button>
  		  <div class="collapse navbar-collapse" id="navbarNav"`>
    		  <ul class="navbar-nav">
      			<li class="nav-item active">
        			<a class="footbrand" href="#">ABOUT</a>
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
    <script src="scripts.js"></script>
</html>
