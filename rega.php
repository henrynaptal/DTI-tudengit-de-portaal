<?php
    require_once("database/config.php");
    require_once("database/fnc_general.php");
    require_once("database/fnc_user.php");

    $notice = null;
    $firstname = null;
    $surname = null;
    $email = null;

    //muutujad võimalike veateadetega
    $firstname_error = null;
    $surname_error = null;
    $email_error = null;
    $password_error = null;
    $confirm_password_error = null;

    //kontrollime sisestust
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["user_data_submit"])){
			//kontrollin sisestusi
			//eesnimi
			if(isset($_POST["first_name_input"]) and !empty($_POST["first_name_input"])){
				$firstname = test_input(filter_var($_POST["first_name_input"], FILTER_SANITIZE_STRING));
				if(empty($firstname)){
					$firstname_error = " Palun sisesta oma eesnimi!";
				}
			} else {
				$firstname_error = " Palun sisesta oma eesnimi!";
			}
			//perekonnanimi
			
			if(isset($_POST["surname_input"]) and !empty($_POST["surname_input"])){
				$surname = test_input(filter_var($_POST["surname_input"], FILTER_SANITIZE_STRING));
				if(empty($surname)){
					$surname_error = " Palun sisesta oma perekonnanimi!";
				}
			} else {
				$surname_error = " Palun sisesta oma perekonnanimi!";
			}
			//email
			
			if(isset($_POST["email_input"]) and !empty($_POST["email_input"])){
				$email = test_input(filter_var($_POST["email_input"], FILTER_VALIDATE_EMAIL));
				if(empty($email)){
					$email_error = " Palun sisesta oma email!";
				}
			} else {
				$email_error = " Palun sisesta oma email!";
			}
			//parool
			
			if(isset($_POST["password_input"]) and !empty($_POST["password_input"])){
				if(strlen($_POST["password_input"]) < 8){
					$password_error = " Siestatud salsõna on liiga lühike!";
				}
			} else {
				$password_error = " Palun sisesta salasõna!";
			}
			//parooli kordus
			
			if(isset($_POST["confirm_password_input"]) and !empty($_POST["confirm_password_input"])){
				if($_POST["confirm_password_input"] != $_POST["password_input"]){
					$confirm_password_error = " Salasõnad on erinevad!";
				}
			} else {
				$confirm_password_error = " Palun sisesta salasõna kaks korda!";
			}
			//Kui kõik korras, salvestame uue kasutaja
	
            if(empty($firstname_error) and empty($surname_error) and empty($email_error) and empty($password_error) and empty($confirm_password_error)){
				$notice = sign_up($firstname, $surname, $email, $_POST["password_input"]);
			}	
			
        }//if isset lõppeb
    }//if request_method lõppeb
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registerStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <title>DTI tudengitööde portaal</title>
</head>
<body>
	<div class="register">
   	 <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  	<label for="first_name_input">Eesnimi:</label><br>
	  	<input name="first_name_input" placeholder="Eesnimi" id="first_name_input" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstname_error; ?></span><br>
	  	<br>
      	<label for="surname_input">Perekonnanimi:</label><br>
	  	<input name="surname_input" placeholder="Perekonnanimi" id="surname_input" type="text" value="<?php echo $surname; ?>"><span><?php echo $surname_error; ?></span><br>
	  	<br>
	  	<label for="email_input">E-mail (kasutajatunnus):</label><br>
	  	<input type="email" placeholder="Email" name="email_input" id="email_input" value="<?php echo $email; ?>"><span><?php echo $email_error; ?></span><br>
	  	<br>
	  	<label for="password_input">Salasõna (min 8 tähemärki):</label><br>
	  	<input name="password_input" placeholder="Salasõna" id="password_input" type="password"><span><?php echo $password_error; ?></span><br>
	  	<br>
	  	<label for="confirm_password_input">Korrake salasõna:</label><br>
	  	<input name="confirm_password_input" placeholder="Salasõna" id="confirm_password_input" type="password"><span><?php echo $confirm_password_error; ?></span><br>
	  	<input name="user_data_submit" class="user_data_submit" type="submit" value="Loo kasutaja"><span><?php echo $notice; ?></span>
	 </form>
	</div>
      
      <header>

        <a href="#" class="logo"><img src="pics/tlü.png" alt="pilt"></a>

        <div class="search">

          <form action="#">

              <input type="text" placeholder=" Otsing..." name="search">

              <button>

                  <i class="fa fa-search"></i>

              </button>

          </form>

      </div>

        <nav class="navbar">

            <a href="avaleht.php">Avaleht</a>
            <a href="erialad.php">Erialad</a>
            <a href="contact.html">Kontakt</a>
            <a href="login.php">Logi sisse</a>
			<a href="rega.php"> Loo konto</a>

        </nav>

        <div class="follow">

            <a href="https://www.instagram.com/tallinnuniversity/" class="fab fa-instagram"></a>
            <a href="https://www.facebook.com/tallinna.ylikool/" class="fab fa-facebook"></a>
            <a href="https://www.tlu.ee/" class="fa-solid fa-house"></a>

        </div>

    </header>

</body>
</html>