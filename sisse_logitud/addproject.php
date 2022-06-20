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
$description = read_user_description();

if(isset($_POST["profile_submit"])){
    $description = test_input(filter_var($_POST["description_input"], FILTER_SANITIZE_STRING));
    $notice = store_user_profile($description);
}



	
    $project_notice = null;
    $project_error = null;
	$project_title = null;
	$project_content = null;
	$project_added = null;
	$project_privacy = null;
	$project_id = null;
	$doc_folder = "docs/";

    if(isset($_POST["project_submit"])){
		//var_dump($_FILES);
		//echo "Filename: " .$_FILES["file_input"]["name"][0];
		//echo "Faile: " .count($_FILES["file_input"]["name"]);
        //$project_notice .= save_files($project_id, $_FILES["file_input"]);
        //seal ...
        //function save_files($project_id, $files){
            //file_count = count($files["name"]);
            //for tsükkel kus iga fail salvestatakse, kantakse andmetabelisse ja seosetabelisse
        //}
			
		//uudise tekst sisaldab nüüd html märgendeid (näiteks <b> ...).
        //Kindlasti t$_POST["title_input"]uleks kasutada meie funktisooni test_input()
        //selles on ka htmlspecialchars(uudis) funktsioon, mis kodeerib html erimärgid ringi, ohutks ("<" -> &lt;
        //pärast, uudise näitamisel, et html taastuks, on vaja: htmlspecialchars_decode(uudis_andmebaasist)
        //kui on ka foto valitud, salvestage see esimesena, ka andmetabelisse. Siis saate kohe ka tema id kätte: $photo_id = $conn->insert_id;
        //uudsie näitamisel tuleb arvestada ka aegumist
        //$today = date("Y-m-d");
        //SQL lauses   WHERE added >= ?
		if(isset($_POST["title_input"]) and !empty($_POST["title_input"])){
			$project_title = test_input($_POST["title_input"]);
		} else {
			$project_error = "Projekti pealkiri on puudu!";
		}
		
		if(isset($_POST["description_input"]) and !empty($_POST["description_input"])){
			$project_content = test_input($_POST["description_input"]);
		} else {
			$project_error .= " Projekti sisu on puudu!";
		}
		
		if(isset($_POST["privacy_input"]) and !empty($_POST["privacy_input"])){
			$project_privacy = $_POST["privacy_input"];
		} else {
			$project_error .= " Projekti privaatsussäte on puudu!";
		}
		
		if(empty($project_error)){
			echo "Alustame projekti salvestamist!";
			$project_id = save_project($project_title, $project_content, $project_privacy);
			if(!empty($project_id)){
				//failide salvestamine
				echo "Projekt salvestati : ".$project_id ."! ";
				$project_notice .= save_files($project_id, $_FILES["file_input"], $doc_folder);

				//if(failid salvestatud){
					//header("Location: gallery.html");//vüib ka gallery lehele.
				//}
			} else {
				$project_notice = "Tekkis viga: " .$project_notice;
			}
		}

    }
    
    $to_head = '<script src="javascript/checkFileSize.js" defer></script>' ."\n";
    $to_head .= '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Uus projekt</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="mdb.min.css">
  <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
  <link rel="stylesheet" href="addproject.css" type="text/css"/>
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
    
    <main style="margin-top: 58px;">
            
    
            
        

    </main>
    <div class="containerS">

<div class="row">

    <div class="col-md-12 text-center">

        <h1 class="animate-character">Uus projekt</h1>

    </div>

</div>

</div> 

<div class="container1" id="container1"> 

<form method="POST" id="project-form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="project-title">Pealkiri</label>
    <input style="border-radius: 15px;" id="title_input" name="title_input" type="text"/><br>
    <br>
        <label> Märksõnad </label>  <br>
        <select name="tags" id="tags" multiple>>  
            
            <?php echo show_subjects(); ?>
            
        </select>  
    <br>
    <br>
    <label>Privaatsus</label>
	<br>
    <input type="radio" name="privacy_input" id="privacy_input_1" value="1" <?php if($project_privacy == "1"){echo " checked";} ?>><label for="privacy_input_1">Avalik</label>
	<br>
    <input type="radio" name="privacy_input" id="privacy_input_2" value="2" <?php if($project_privacy == "2"){echo " checked";} ?>><label for="privacy_input_2">Nähtav kasutajatele</label>
	<br>
    <input type="radio" name="privacy_input" id="privacy_input_3" value="3" <?php if($project_privacy == "3"){echo " checked";} ?>><label for="privacy_input_3">Privaatne</label>
    
    <span><?php echo $project_error; ?></span>
    <br>
    <br>
    <label for="description_input">Sisu</label><br>
        <textarea name="description_input" id="description_input"></textarea><br>

            <input type="file" id="myFile" name="file_input[]" multiple>

        <input class="button" id="save-button" name="project_submit" type="submit" value="Postita">
</form>

<br>
</div>  

  <script type="text/javascript" src="../login.js"></script>

</body>
</html>
   