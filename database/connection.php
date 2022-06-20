<?php
$connection = mysqli_connect("localhost", "if21", "if21");
if(!$connection){
	echo "Failed to connect database" . die(mysqli_error($connection));;
}
$dbselect = mysqli_select_db($connection, "demo");
if(!$dbselect){
	echo "Failed to Select database" . die(mysqli_error($connection));
}
?>