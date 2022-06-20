<?php
    session_start();
    require_once("database/config.php");
    require_once ("database/fnc_user.php");

	//Sisselogimine
	$notice = null;
	if(isset($_POST["login_submit"])){
		$notice = sign_in($_POST["email_input"], $_POST["password_input"]);
	}
	
	
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="mdb.min.css">
  <link rel="stylesheet" id="roboto-subset.css-css" href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/mdb5/fonts/roboto-subset.css?ver=3.9.0-update.5" type="text/css" media="all">
</head>
<body>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <section class="vh-100" style="background-color: #d41d47;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-2-strong" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">
  
              <h3 class="mb-5">Logi sisse</h3>
  
              <div class="form-outline mb-3" >
                <input type="email" name="email_input" id="email" class="form-control form-control-lg"/>
                <label class="form-label" for="email">Email</label>
              </div>
              <div class="form-outline mb-4">
                <input type="password" name="password_input" id="parool" class="form-control form-control-lg"/>
                <label class="form-label" for="parool">Parool</label>
              </div>
              <div class="row mb-4">
                <div class="col-md-6 d-flex justify-content-center">
                  <div class="form-check mb-3 mb-md-0">
                    <input class="form-check-input" type="checkbox" value="" id="loginCheck" checked />
                    <label class="form-check-label" for="loginCheck"> Jäta mind meelde </label>
                  </div>
                </div>
              </div>
              <button class="btn btn-primary btn-lg btn-block" type="submit" name="login_submit">Logi sisse</button><span><?php echo $notice; ?></span>
              <hr class="my-4">
              <div>
                <p class="mb-0">Pole kasutajat? <a href="rega.php" class="text-black-50 fw-bold">Loo kasutaja</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </form>
  <script type="text/javascript" src="login.js"></script>
</body>
</html>