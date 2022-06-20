<?php
$database = "if21_dti_portaal";

function sign_up($firstname, $surname, $email, $password){
	$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	$conn->set_charset("utf8");
	$stmt = $conn->prepare("INSERT INTO dti_users (firstname, lastname, email, password) values(?,?,?,?)");
	echo $conn->error;
	//krüpteerime parooli
	$option = ["cost" => 12];
	$pwd_hash = password_hash($password, PASSWORD_BCRYPT, $option);
	$stmt->bind_param("ssss", $firstname, $surname, $email, $pwd_hash);
	if($stmt->execute()){
		$notice = " Uus kasutaja edukalt loodud!";
	} else {
		$notice = "Tekkis viga uue kasutaja loomisega!" .$stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

    function sign_in($email, $password){
        $notice = null;
        $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt = $conn->prepare("SELECT id, firstname, lastname, password FROM dti_users WHERE email = ?");
        echo $conn->error;
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id_from_db, $firstname_from_db, $lastname_from_db, $password_from_db);
        $stmt->execute();
        if($stmt->fetch()){
            if(password_verify($password, $password_from_db)){
                $_SESSION["user_id"] = $id_from_db;
                $_SESSION["first_name"] = $firstname_from_db;
                $_SESSION["last_name"] = $lastname_from_db;
				$stmt->close();
                $conn->close();
                header("Location: sisse_logitud/portfolio.php");
                exit();
            } else {
                $notice = "Kasutajanimi voi parool on vale!";
            }
        } else {
            $notice = "Kasutajanimi voi parool on vale!";
        }
        
        $stmt->close();
        $conn->close();
        return $notice;
    }
	
	function read_user_description(){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT description FROM dti_userprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["user_id"]);
		$stmt->bind_result($description_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $description_from_db;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function store_user_profile($description){
	    $notice = null;
	    $conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
	    $stmt = $conn->prepare("SELECT id FROM dti_userprofiles WHERE userid = ?");
	    echo $conn->error;
	    $stmt->bind_param("i", $_SESSION["user_id"]);
	    $stmt->bind_result($id_from_db);
	    $stmt->execute();
	    if($stmt->fetch()){
		    $stmt->close();
		    $stmt= $conn->prepare("UPDATE dti_userprofiles SET description = ? WHERE userid = ?");
		    echo $conn->error;
		    $stmt->bind_param("si", $description, $_SESSION["user_id"]);
	    } else {
		    $stmt->close();
		    $stmt = $conn->prepare("INSERT INTO dti_userprofiles (userid, description) VALUES(?,?)");
		    echo $conn->error;
		    $stmt->bind_param("is", $_SESSION["user_id"], $description);
	    }
	    if($stmt->execute()){
		    $notice = "Salvestatud!";
	    } else {
		    $notice = "Profiili salvestamisel tekkis viga: " .$stmt->error;
	    }
	    $stmt->close();
	    $conn->close();
	    return $notice;
	}