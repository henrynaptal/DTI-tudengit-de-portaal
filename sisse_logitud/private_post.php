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
        header("Location: ../avaleht.html");
    }
	
	require_once ("fnc_project.php");
	//require_once "../database/fnc_subjects.php";
	require_once "../database/config.php";
	
	$post_data = [];
	
	if(isset($_GET["postitus"]) and !empty($_GET["postitus"])){
		$post_data = private_project_post($_GET["postitus"]);
		//var_dump($post_data);
    } else {
        header("Location: sees_avaleht.php");
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="private_post.css">
    <script defer src="indexs.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>DTI tudengitööde portaal</title>
</head>
<body>
    
    <div class="container">

        <div class="row">

            <div class="col-md-12 text-center">

                <h1 class="animate-character"></h1>

            </div>

        </div>

    </div>
	
	<div class="container">

        <div class="mina">

            <div class="minust">

                <div class="pic">

                    <img src="../pics/profpic.jpg" alt="pilt">

                </div>

                <div class="content">
				 
				    <?php 
					
					
						/* if($post_data[0] == true){
							echo '<h3>' .$post_data[1] .'</h3>';
							if(empty($post_data[2])){
								echo "postitus yleval";
							} else {
								echo $post_data[2];
						    }
						} */
						
						echo '<h3>' .$post_data[1] .'</h3>';
						echo '<br>';
						echo '<p style="background-color: white; color: black; font-size: 20px;">' .$post_data[2] .'</p>';
						echo '<br>';
						echo '<p name="title">' .$post_data[3] .'</p>' ."\n";
						
					
					?>
				 
				</div>

            </div>

        </div>
		
    </div>

    </div>

    <header>

        <a href="#" class="logo"><img src="../pics/tlü.png" alt="pilt"></a>

        <div class="search">

          <form action="#">

              <input type="text" placeholder=" Otsing..." name="search">

              <button>

                  <i class="fa fa-search"></i>

              </button>

          </form>

      </div>

        <nav class="navbar">

            <a href="portfolio.php">Minu portfoolio</a>
            <a href="sees_avaleht.php">Avaleht</a>
            <a href="sees_erialad.php">Erialad</a>
            <a href="sees_contact.php">Kontakt</a>
            <a href="?logout=1">Logi välja</a>

        </nav>

        <div class="follow">

            <a href="https://www.instagram.com/tallinnuniversity/" class="fab fa-instagram"></a>
            <a href="https://www.facebook.com/tallinna.ylikool/" class="fab fa-facebook"></a>
            <a href="https://www.tlu.ee/" class="fa-solid fa-house"></a>

        </div>

    </header>

</body>
</html>