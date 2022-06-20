<?php
session_start();
	
    if(!isset($_SESSION["user_id"])){
        header("Location: portfolio.php");
    }
	
    if(isset($_GET["logout"])){
        session_destroy();
        header("Location: ../avaleht.html");
    }



    require_once("../database/config.php");
	require_once("../database/fnc_user.php");
	require_once("../database/fnc_general.php");
	
	$notice = null;
	$description = read_user_description();
	
	if(isset($_POST["profile_submit"])){
		$description = test_input(filter_var($_POST["description_input"], FILTER_SANITIZE_STRING));
		$notice = store_user_profile($description);
	}
	
	include "../database/config.php";

    $images_sql = "SELECT userid, name, image FROM dti_userprofiles ORDER BY id desc limit 1";

    $result = mysqli_query($conn,$images_sql);

    $row = mysqli_fetch_array($result);

    $filename = $row['name'];
    $image = $row['image'];
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
        <link href="portfolio.css" rel="stylesheet" type="text/css"/>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<link rel=”stylesheet” href=”https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css”>
        <script crossorigin="anonymous" src="https://kit.fontawesome.com/6f06b18aec.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script defer src=""></script>
        <title>Postitused</title>
  </head>
<body>

    <div class="user">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="animate-character"><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?> portfoolio</h1>
            </div>
        </div>
    </div>

    <header>

        <a href="sees_avaleht.php" class="logo"><img src="../pics/tlü.png" alt="pilt"></a>

        <div class="search">

          <form action="#">

              <input type="text" placeholder=" Otsing..." name="search">

              <button>

                  <i class="fa fa-search"></i>

              </button>
   
          </form>

      </div>

        <nav class="navbar">

            <a href="avaleht.html">Avaleht</a>
            <a href="erialad.html">Erialad</a>
            <a href="contact.html">Kontakt</a>
            <a href="?logout=1">Logi välja</a>
			<a href="user_settings.php">Sätted</a>

        </nav>

        <div class="follow">
		
            <a href="https://www.instagram.com/tallinnuniversity/" class="fab fa-instagram"></a>
            <a href="https://www.facebook.com/tallinna.ylikool/" class="fab fa-facebook"></a>
            <a href="https://www.tlu.ee/" class="fa-solid fa-house"></a>
			
        </div>

    </header>

</body>
</html>