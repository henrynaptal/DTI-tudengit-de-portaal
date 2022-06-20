<?php
session_start();
	    require ("../database/fnc_user.php");
	
	//Vaatab, kas on sisselogitud
	if(!isset($_SESSION["user_id"])){
        header("Location: portfolio.php");
    }
	//Lehelt väljalogimine
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: ../avaleht.php");
    }

    require_once("../database/config.php");
	require_once("../database/fnc_user.php");
	require_once("../database/fnc_general.php");
	require_once("../database/fnc_profilepics.php");
	
	$notice = null;
	$description = read_user_description();
	
	if(isset($_POST["profile_submit"])){
		$description = test_input(filter_var($_POST["description_input"], FILTER_SANITIZE_STRING));
		$notice = store_user_profile($description);
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Minu portfoolio</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="mdb.min.css">
  <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
  <link rel="stylesheet" href="portfolio.css" type="text/css"/>
  <script crossorigin="anonymous" src="https://kit.fontawesome.com/6f06b18aec.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

</head>
<body>
    
    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse background: white;">
          <div class="position-sticky">
            <div class="navbar1">
                <a href="sees_avaleht.php" class="logo"><img src="../pics/tlü.png" alt="pilt"></a>
                <a href="sees_avaleht.php">Avaleht</a>
                <a href="sees_erialad.php">Erialad</a>
                <a href="sees_contact.php">Kontakt</a>
                <a href="?logout=1">Logi välja</a>
            </div>
            <div class="follow">

                <a href="https://www.instagram.com/tallinnuniversity/" class="fab fa-instagram"></a>
                <a href="https://www.facebook.com/tallinna.ylikool/" class="fab fa-facebook"></a>
                <a href="https://www.tlu.ee/" class="fa-solid fa-house"></a>
    
            </div>
          </div>
          
        </nav>
        
        
        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
          <!-- Container wrapper -->
          <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
              aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
              <i class="fas fa-bars"></i>
            </button>

            
            <a class="navbar-brand me-2 mb-1 d-flex align-items-center0" href="#">
                <img
                  src="../pics/tlü.png"
                  height="50"
                  alt="Tl� logo"
                  loading="lazy"
                />
              </a>
            <!-- Search form -->
            <form class="d-none d-md-flex input-group w-auto my-auto">
              <input autocomplete="off" type="search" class="form-control rounded"
                placeholder='Otsing...' style="min-width: 225px;" />
              <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
            </form>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
              <li class="nav-item dropdown">
                <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink"
                  role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  <span class="badge rounded-pill badge-notification bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="sees_uuedteated.php">Teated</a>
                  </li>
                  
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                  id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img (31).webp" class="rounded-circle"
                    height="22" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="portfolio.php">Minu portfoolio</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="?logout=1">Logi välja</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>
    
    <main style="margin-top: 58px;">
            
    
            
        

    </main>
    <div class="user">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="animate-character"><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?> portfoolio</h1>
            </div>
        </div>
    </div>

	<div class="containerS" id="containerS">

        <div class="container1" id="container1">
		
            <h1 class="title" id="heading"><center>Portfoolio</center></h1>
            <br>

            <form id="portfolio-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			
                    <label for="portfolio"></label>
                    <textarea name="description_input" id="description_input"><?php echo $description; ?></textarea><br>
                    <input name="profile_submit" class="button" id="save-button" type="submit" value="Salvesta"/>
					<br>
					<span><?php echo $notice; ?></span>
					
            </form>
			
        </div>  
        
        <div class="container2" id="container2">

            <div class="user">
			
                <div class="profile_img">
				
		            <img src="../pics/profpic.jpg">
                
				</div>
				
				
                <h3><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?></h3>
                
                <p><center>Informaatika</center></p>
				
            </div>

            <form id="profile-form">
			
                <label for="profile"></label>
				
            </form>

                 <div class="gallery">
			
                     <a id="gallery" href="gallery.php" style="color: #FFFFFF; margin: auto;"><center>Projektide galerii</center></a>
				
                </div>

        </div> 

	</div>

  <script type="text/javascript" src="../login.js"></script>

</body>
</html>
   