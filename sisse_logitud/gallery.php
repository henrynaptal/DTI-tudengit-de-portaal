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
	
	require_once "../database/config.php";
	
	require_once ("fnc_project.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" href="mdb.min.css">
  <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
	<link rel="stylesheet" href="gallery.css">
	<link rel="stylesheet" href="style.css">
    <script defer src="gallery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>Galerii</title>
</head>
<body>

	<div class="containerS" id="containerS">
		<h1 class="animate-character"><center>Projektide galerii<center></h1>
		
		<div class="new_project">
			<a id="new_project" href="addproject.php"><i class = "fa fa-plus-circle"><br><br><br></i></a>
        </div>

	</div>
	
    
		
	<gallery class="projectblock" id="projectblock">
		<?php echo show_own_projects(); ?>
	</gallery>

	<!-- <div>
		<section>
			<form id="project-form">
				<label for="project-title">Pealkiri</label>
				<input style="border-radius: 15px;" id="project-title" type="text" />
				<label for="project-author">Autor</label>
				<input style="border-radius: 15px;" id="project-author" type="text" />
				<label for="project-content">Lehekülgi raamatus</label>
				<input style="border-radius: 15px;" id="project-content" type="number" />
				<input class="btn btn-primary btn-block" id="add-project-button" type="submit" value="Lisa projekt galeriisse."/>
			</form>
		</section>

		<section>
			<table class="table" id="table">
				<thead>
					<tr>n
						<a href="avaleht.html"><i class="fa-solid fa-pencil"></i>Muuda</a>
						<i class="fas fa-trash delete"></i>
					</tr>
				</thead>
				<tbody id="project-list"></tbody>
			</table>
		</section>

	</div> -->

    

	<header>
        
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse background: white;">
          <div class="position-sticky">
            <div class="navbar1">
                <a href="#" class="logo"><img src="../pics/tlü.png" alt="pilt"></a>
				<a href="portfolio.php">Minu portfoolio</a>
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
        
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      
          <div class="container-fluid">
       
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
            
            <form class="d-none d-md-flex input-group w-auto my-auto">
              <input autocomplete="off" type="search" class="form-control rounded"
                placeholder='Otsing...' style="min-width: 225px;" />
              <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
            </form>
           
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
	<script type="text/javascript" src="../login.js"></script>
</body>
</html>