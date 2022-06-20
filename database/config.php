<?php
    $server_host = "localhost";
    $server_user_name = "if21";
    $server_password = "if21";
	$dbname = "if21_dti_portaal";
	
	$conn = mysqli_connect($server_host, $server_user_name, $server_password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }