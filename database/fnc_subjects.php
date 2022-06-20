<?php
    $database = "if21_dti_portaal";

    function list_subjects_baka(){
		$subject_html = null;
		$level = 1;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name FROM subjects WHERE level = ? AND deleted IS NULL ORDER BY id");
		echo $conn->error;
		$stmt->bind_param("i", $level);
		$stmt->bind_result($id_from_db, $name_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$subject_html .= '<a href="#">'.$name_from_db ."</a> <br><br>";
		}
		$stmt->close();
		$conn->close();
		return $subject_html;
	}
	
	function list_subjects_magister(){
		$subject_html = null;
		$level = 2;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name FROM subjects WHERE level = ? AND deleted IS NULL ORDER BY id");
		echo $conn->error;
		$stmt->bind_param("i", $level);
		$stmt->bind_result($id_from_db, $name_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$subject_html .= '<a href="#">'.$name_from_db ."</a> <br><br>";
		}
		$stmt->close();
		$conn->close();
		return $subject_html;
	}
	
	function show_subjects(){
		$subject_html = null;
		//$level = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, name FROM subjects WHERE level = 1 OR level = 2 AND deleted IS NULL ORDER BY id");
		echo $conn->error;
		//$stmt->bind_param("i", $level);
		$stmt->bind_result($id_from_db, $name_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$subject_html .= '<div class ="tags" >';
			$subject_html .= "<option>" .$name_from_db ."</option>";
			$subject_html .= "</div>";
		}
		$stmt->close();
		$conn->close();
		return $subject_html;
	}
	