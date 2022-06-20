<?php
        session_start();
	    require_once "../../database/fnc_user.php";

		require_once "../../sisse_logitud/fnc_project.php";
		require_once "../../database/config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="informaatika.css">
    <script defer src="indexs.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>DTI tudengitööde portaal</title>
</head>
<body>

    <div class="container">

        <div class="row">

            <div class="col-md-12 text-center">

                <h1 class="animate-character">Informaatika</h1>

            </div>

        </div>

    </div>
	<div class="posts">

          <h2 class="title">Viimati tehtud postitused</h2>
          <?php 
		  echo ("tere");
		  echo show_subject_projects_informatics(); ?>
        </div>

    <header>

    <header>

        <a href="../../avaleht.php" class="logo"><img src="../../pics/tlü.png" alt="pilt"></a>

        <div class="search">

          <form action="#">

              <input type="text" placeholder=" Otsing..." name="search">

              <button>

                  <i class="fa fa-search"></i>

              </button>

          </form>

      </div>

        <nav class="navbar">

            <a href="../../avaleht.php">Avaleht</a>
            <a href="../../erialad.html">Erialad</a>
            <a href="../../contact.html">Kontakt</a>
            <a href="../../login.html">Logi sisse</a>
            <a href="../../register.html">Loo konto</a>

        </nav>

        <div class="follow">

            <a href="https://www.instagram.com/tallinnuniversity/" class="fab fa-instagram"></a>
            <a href="https://www.facebook.com/tallinna.ylikool/" class="fab fa-facebook"></a>
            <a href="https://www.tlu.ee/" class="fa-solid fa-house"></a>

        </div>

    </header>

</body>
</html>