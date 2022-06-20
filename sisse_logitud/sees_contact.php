<?php
//Sessioon algab
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mdb.min.css">
    <link rel="stylesheet" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
    <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
    <link rel="stylesheet" href="test2.css">
    <script defer src=""></script>
    <script src="https://kit.fontawesome.com/d90f70bb05.js" crossorigin="anonymous"></script>
    <title>Kontakt</title>
</head>
<body>
    <header>
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse background: white;">
          <div class="position-sticky">
            <div class="navbar1">
                <a href="#" class="logo"><img src="../pics/tlü.png" alt="pilt"></a>
                <a href="portfolio.php">Minu portfolio</a>
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
                  <span class="badge rounded-pill badge-notification bg-danger">1</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="sees_uuedteated.php">Teated</a>
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
                    <a class="dropdown-item" href="portfolio.php">Minu portfolio</a>
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
     
      <div class="header">
          <h1>Kontaktid</h1>
      </div>
      
      
      <container id="container">

          <div class="contacts">

              <div class="col">
                  <p class="i-address"><i class="fa-solid fa-location-dot" style="color:#D41D47"></i> Digitehnoloogiate instituut <br> Narva mnt 29, 10120 Tallinn</p>
                  <br><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2028.6606087515524!2d24.769194915493053!3d59.43873480928843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4692935c7ed21b5b%3A0x34ce7211e853036f!2sTallinna%20%C3%9Clikool!5e0!3m2!1set!2see!4v1654685516066!5m2!1set!2see" width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
              <br>

              <div class="col">
                  <p class="i-phone"><i class="fa-solid fa-phone" style="color:#D41D47"></i> Telefon <br> (+372) 640 9421</p>
              </div>
              <br>

              <div class="col">
                  <p class="i-email" ><i class="fa-solid fa-envelope" style="color:#D41D47"></i> E-post <br><a href="mailto:dti@tlu.ee" style="color:#D41D47">dti@tlu.ee</a></p>
              </div>
          </div>
      </container>
   
  <script type="text/javascript" src="../login.js"></script>
    
</body>
</html>