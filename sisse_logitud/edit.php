<?php
session_start();
	
if(!isset($_SESSION["user_id"])){
    header("Location: portfolio.php");
}

if(isset($_GET["logout"])){
    session_destroy();
    header("Location: ../avaleht.php");
}

require_once "../database/config.php";
require_once "../database/fnc_user.php";
require_once "../database/fnc_general.php";
require_once "fnc_project.php";
require_once "../database/fnc_subjects.php";


$notice = null;
	
    
	
	$post_data = [];
	$post_data_update_notice = null;
	
	if(isset($_POST["post_data_submit"])){
		$privacy = 1;
		if(isset($_POST["privacy_input"])){
			if(!empty(filter_var($_POST["privacy_input"], FILTER_VALIDATE_INT))){
				$privacy = filter_var($_POST["privacy_input"], FILTER_VALIDATE_INT);
			}
		}
		$post_data_update_notice = post_data_update(test_input(filter_var($_POST['title_input'], FILTER_SANITIZE_STRING)), test_input(filter_var($_POST["description_input"], FILTER_SANITIZE_STRING)), $privacy, $_POST["project_input"]);
		if($post_data_update_notice == "Andmete muutmine õnnestus!"){
			header("Location: gallery.php");
		}
	}
	
	if(isset($_POST["delete_submit"])){
		$post_data_update_notice = delete_project($_POST["project_input"]);
		if($post_data_update_notice == "ok"){
			header("Location: gallery.php");
		}
	}
	
	if(isset($_GET["postitus"]) and !empty($_GET["postitus"])){
		$post_data = edit_project_post($_GET["postitus"]);
		//var_dump($post_data);
    } else {
        //header("Location: sees_avaleht.php");
    }

	
    
    $to_head = '<script src="javascript/checkFileSize.js" defer></script>' ."\n";
    $to_head .= '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Muuda postitust</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/standard/core.min.css">
  <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
  <link rel="stylesheet" href="edit.css" type="text/css"/>
  <script crossorigin="anonymous" src="https://kit.fontawesome.com/6f06b18aec.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script defer src="project.js"></script>

</head>
<body>
    
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
                    <a class="dropdown-item" href="#">Teated</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">Teated</a>
                  </li>
                </ul>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#"
                  id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <img src="https://mdbcdn.b-cdn.net/img/posts/Avatars/img (31).webp" class="rounded-circle"
                    height="22" alt="Avatar" loading="lazy" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="#">Minu portfoolio</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">Sätted</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">Logi välja</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
    </header>
    
    <main style="margin-top: 58px;">
            
    
            
        

    </main>
    <div class="containerS">

<div class="row">

    <div class="col-md-12 text-center">

        <h1 class="animate-character">Muuda projekti postitust</h1>
		

    </div>

</div>

</div> 

<div class="container1" id="container1"> 

<form method="POST" id="project-form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
		<?php
		  /* if(empty($post_data[2])){
                echo "Redigeeri projekti";
            } else {
                echo $post_data[2];
            } */
				echo '<form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"]) ."?postitus=" .$_GET["postitus"] .'" enctype="multipart/form-data">' ."\n";
				echo '<br>';
				echo '<input type="hidden" name="project_input" value="' .$_GET["postitus"] .'">' ."\n";
				echo '<label for="title_input">Pealkiri </label>' . "\n";
				echo '<input type="text" name="title_input" id="title_input" placeholder="pealkiri" value="' .$post_data[1] .'">' ."\n";
				echo '<br>';
				
				echo "<br> \n";
				echo '<input type="radio" name="privacy_input" id="privacy_input_1" value="3"';
				if($post_data[3] == 3){
					echo " checked";
				}
				echo "> \n";
				echo '<label for="privacy_input_1">Privaatne</label>';
				echo "<br> \n";
				echo '<input type="radio" name="privacy_input" id="privacy_input_2" value="2"';
				if($post_data[3] == 2){
					echo " checked";
				}
				echo "> \n";
				echo '<label for="privacy_input_2">Sisseloginud kasutajatele</label>';
				echo "<br> \n";
				echo '<input type="radio" name="privacy_input" id="privacy_input_3" value="1"';
				if($post_data[3] == 1){
					echo " checked";
				}
				echo "> \n";
				echo '<label for="privacy_input_3">Avalik</label>';
				echo "<br> \n";
				
				echo '<br>';
                echo '<label for="description_input">Sisu</label><br>';
                echo '<textarea name="description_input" id="description_input" rows="10" cols="80">' .$post_data[2] .'</textarea><br>';
				
				
				echo '<input type="submit" id = "save-button" name="post_data_submit" value="Salvesta">' ."\n";
				echo "</form> \n";
				echo "<br> \n";
				
				echo '<form method="POST" action="' .htmlspecialchars($_SERVER["PHP_SELF"])."?postitus=" .$_GET["postitus"] .'" >' ."\n";
				echo '<input type="hidden" name="project_input" value="' .$_GET["postitus"] .'">' ."\n";
				echo '<input type="submit" id = "delete-button" name="delete_submit" value="Kustuta">' ."\n";
				echo "</form> \n";			
		
		?>
		
</form>

<br>
</div>  

  <script type="text/javascript" src="../login.js"></script>

</body>
</html>
   