<?php

    require_once "SessionManager.class.php";

    if(!isset($_SESSION["user_id"])){
        header("Location: ../sisse_logitud/sees_avaleht.php");
    }
	//Lehelt väljalogimine
	if(isset($_GET["logout"])){
        session_destroy();
        header("Location: ../avaleht.html");
    }