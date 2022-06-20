<?php
	$database = "if21_dti_portaal";
	function save_project($project_title, $project_content, $project_privacy){
		//echo $GLOBALS["server_host"];
		$project_id = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO project (userid, title, content, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		echo "Kasutaja: " .$_SESSION["user_id"];
		$stmt->bind_param("issi", $_SESSION["user_id"], $project_title, $project_content, $project_privacy);
		if($stmt->execute()){
			$project_id = $conn->insert_id;
			echo "Õnnestus ".$project_id;
		} else {
			echo "Ei õnnestunud" .$stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $project_id;
	}
	
	function save_files($project_id, $files, $target){
		$notice = null;
		$file_id = null;
		echo "Faile leiti kokku: " .count($files["name"]) ." tükki!";
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt=$conn->prepare("INSERT INTO files (filename) VALUES(?)");
		$stmt_link=$conn->prepare("INSERT INTO link_project_files (files_id, project_id) VALUES(?, ?)");
		for($i = 0; $i < count($files["name"]); $i++){
			echo " Ajutise faili nimi: " .$files["tmp_name"][$i] ." faili originaalnimi: " .$files["name"][$i];
			if(move_uploaded_file($files["tmp_name"][$i], $target .$files["name"][$i])){
				$stmt->bind_param("s", $files["name"][$i]);
				if($stmt->execute()){
					$file_id = $conn->insert_id;
					$stmt_link->bind_param("ii", $file_id, $project_id);
					if($stmt_link->execute()){
						$notice = "Kõik õnnestus!";
					} else {
						echo "Seoste andmebaasi kirjutamisel viga: " .$stmt_link->error;
					}
				} else {
					echo "Failide andmebaasi kirjutamisel viga: " .$stmt->error;
				}
			}
		}
		
		$stmt->close();
		$stmt_link->close();
		$conn->close();
		return $notice;

	}
	
	function save_project_original($project_title, $project_content, $project_privacy, $file_name){
		$response = null;
		$project_id = null;
		//kõigepealt foto!
		//echo "SALVESTATAKSE UUDIST!";
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		if(!empty($file_name)){
			$stmt = $conn->prepare("INSERT INTO add_project (userid, filename) VALUES(?, ?)");
			echo $conn->error;
			$stmt->bind_param("is", $_SESSION["userid"], $file_name);
			if($stmt->execute()){
				$project_id = $conn->insert_id;
			}
			$stmt->close();
		}
		
		//nüüd uudis ise
		$stmt = $conn->prepare("INSERT INTO add_project (userid, title, privacy, content) VALUES (?, ?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isiis", $_SESSION["userid"], $project_title, $privacy, $project, $project_id);
		if($stmt->execute()){
			$response = 1;
		} else {
			$response = $stmt->error;
		}
		$stmt->close();
		$conn->close();
		return $response;
	}
	
	function latest_projects($limit = 10){
		$project_html = null;
		$privacy = 1;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, title, content, added FROM project WHERE privacy = ? AND deleted IS NULL ORDER BY id DESC LIMIT ?");
		echo $conn->error;
		$stmt->bind_param("ii", $privacy, $limit );
		$stmt->bind_result($id_from_db, $title_from_db, $content_from_db, $added_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$project_html .= '<div class="projectblock">'."\n";
			$project_html .= '<a href="post.php?postitus=' .$id_from_db .'">';
			if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 30, "...") .'</h3>';
			} else {
				$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
			}
			$added_time = new DateTime($added_from_db);
			$project_html .= "\t <p>Lisatud: " .$added_time->format("d.m.Y") ."</p> \n";
			
			//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";		
			if(strlen($content_from_db) > 50){
				$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
			} else {
				$project_html .= "\t <p>" .$content_from_db ."</p> \n";
			}
			//$project_html .= '<p>' .grapheme_strlen($content_from_db) .'<p>';
			$project_html .= '</a>';
			$project_html .= "<hr>";
			$project_html .= "</div> \n";		
		}
		
		$stmt->close();
		$conn->close();
		return $project_html;
	}
	
	function latest_projects_public($limit = 3){
		$project_html = null;
		$privacy = 1;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, title, content, added FROM project WHERE privacy = ? AND deleted IS NULL ORDER BY id DESC LIMIT ?");
		echo $conn->error;
		$stmt->bind_param("ii", $privacy, $limit );
		$stmt->bind_result($id_from_db, $title_from_db, $content_from_db, $added_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$project_html .= '<div class="projectblock">'."\n";
			$project_html .= '<a href="avaleht_post.php?postitus=' .$id_from_db .'">';
			if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 30, "...") .'</h3>';
			} else {
				$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
			}
			$added_time = new DateTime($added_from_db);
			$project_html .= "\t <p>Lisatud: " .$added_time->format("d.m.Y") ."</p> \n";
			
			//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";		
			if(strlen($content_from_db) > 50){
				$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
			} else {
				$project_html .= "\t <p>" .$content_from_db ."</p> \n";
			}
			//$project_html .= '<p>' .grapheme_strlen($content_from_db) .'<p>';
			$project_html .= '</a>';
			$project_html .= "<hr>";
			$project_html .= "</div> \n";		
		}
		
		$stmt->close();
		$conn->close();
		return $project_html;
	}
	
	function show_own_projects($limit = 100){
		$project_html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, title, content, added, privacy FROM project WHERE userid = ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION['user_id']);
		$stmt->bind_result($id_from_db, $title_from_db, $content_from_db, $added_from_db, $privacy_from_db);
		$stmt->execute();		
		while ($stmt->fetch()){
			if($privacy_from_db < 3){
				$project_html .= '<div class="projectblock">';
				$project_html .= '<a href="post.php?postitus=' .$id_from_db .'">';
				if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 15, "...") .'</h3>';
				} else {
					$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
				}
				$added_time = new DateTime($added_from_db);
				$project_html .= "<h5>Lisatud: " .$added_time->format("d.m.Y") ."</h5>";
				if(strlen($content_from_db) > 50){
					$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
				} else {
					$project_html .= "\t <p>" .$content_from_db ."</p> \n";
				}
				//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";
				//$project_html .= "<p>" .$content_from_db ."</p>";
				$project_html .= '</a>';
				$project_html .= '<a id = "edit" href="edit.php?postitus=' .$id_from_db .'"><i id="edit2" class="fa-solid fa-pencil"></i>Muuda</a>';
				$project_html .= "<hr>";
				$project_html .= "</div> \n";
			} elseif($privacy_from_db == 3){
				$project_html .= '<div class="projectblock">';
				$project_html .= '<a href="private_post.php?postitus=' .$id_from_db .'">';
				if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 15, "...") .'</h3>';
				} else {
					$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
				}
				$added_time = new DateTime($added_from_db);
				$project_html .= "<h5>Lisatud: " .$added_time->format("d.m.Y") ."</h5>";
				if(strlen($content_from_db) > 50){
					$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
				} else {
					$project_html .= "\t <p>" .$content_from_db ."</p> \n";
				}
				//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";
				//$project_html .= "<p>" .$content_from_db ."</p>";
				$project_html .= '</a>';
				$project_html .= '<a id = "edit" href="edit.php?postitus=' .$id_from_db .'"><i id="edit2" class="fa-solid fa-pencil"></i>Muuda</a>';
				$project_html .= "<hr>";
				$project_html .= "</div> \n";
			}		
		}

		
		$stmt->close();
		$conn->close();
		return $project_html;
	}
	
	
	function show_subject_projects_informatics($limit = 100){
		$level = 1;
		$project_html = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT id, subjects_id, project_id FROM project_subjects WHERE userid = ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION['user_id']);
		$stmt->bind_result($id_from_db, $title_from_db, $content_from_db, $added_from_db, $privacy_from_db);
		$stmt->execute();		
		while ($stmt->fetch()){
			if($privacy_from_db == 2){
				$project_html .= '<div class="projectblock">';
				$project_html .= '<a href="post.php?postitus=' .$id_from_db .'">';
				if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 15, "...") .'</h3>';
				} else {
					$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
				}
				$added_time = new DateTime($added_from_db);
				$project_html .= "<p>Lisatud: " .$added_time->format("d.m.Y") ."</p><br>";
				if(strlen($content_from_db) > 50){
					$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
				} else {
					$project_html .= "\t <p>" .$content_from_db ."</p> \n";
				}
				//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";
				//$project_html .= "<p>" .$content_from_db ."</p>";
				$project_html .= '</a>';
				$project_html .= "<hr>";
				$project_html .= "</div> \n";
			} elseif($privacy_from_db == 3){
				$project_html .= '<div class="projectblock">';
				$project_html .= '<a href="post.php?postitus=' .$id_from_db .'">';
				if(strlen($title_from_db) > 50){
				$project_html .= '<h3>' .mb_strimwidth($title_from_db, 0, 15, "...") .'</h3>';
				} else {
					$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
				}
				$added_time = new DateTime($added_from_db);
				$project_html .= "<p>Lisatud: " .$added_time->format("d.m.Y") ."</p><br>";
				if(strlen($content_from_db) > 50){
					$project_html .= '<p>' .mb_strimwidth($content_from_db, 0, 50, "...") .'<p>';
				} else {
					$project_html .= "\t <p>" .$content_from_db ."</p> \n";
				}
				//$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";
				//$project_html .= "<p>" .$content_from_db ."</p>";
				$project_html .= '</a>';
				$project_html .= "<hr>";
				$project_html .= "</div> \n";
			}		
		}

		
		$stmt->close();
		$conn->close();
		return $project_html;
	}
	
	function project_post($postitus){
		$post_data = [];
		$privacy = 1;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT title, content, added FROM project WHERE id = ? AND privacy = ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("ii", $postitus, $privacy);
		$stmt->bind_result($title_from_db, $content_from_db, $added_from_db);
		$stmt->execute();
		if ($stmt->fetch()){
			array_push($post_data, true);
			array_push($post_data, $title_from_db);
			array_push($post_data, $content_from_db);
			array_push($post_data, $added_from_db);
        } else {
			array_push($post_data, false);
		}
		
		$stmt->close();
		$conn->close();
		return $post_data;
	}
	
	function private_project_post($postitus){
		$post_data = [];
		$privacy = 3;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT title, content, added FROM project WHERE id = ? AND userid = ? AND privacy = ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("iii", $postitus, $_SESSION['user_id'], $privacy);
		$stmt->bind_result($title_from_db, $content_from_db, $added_from_db);
		$stmt->execute();
		if ($stmt->fetch()){
			array_push($post_data, true);
			array_push($post_data, $title_from_db);
			array_push($post_data, $content_from_db);
			array_push($post_data, $added_from_db);
        } else {
			array_push($post_data, false);
		}
		
		$stmt->close();
		$conn->close();
		return $post_data;
	}
	
	function edit_project_post($postitus){
		$post_data = [];
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT title, content, privacy FROM project WHERE id = ? AND userid = ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("ii", $postitus, $_SESSION['user_id']);
		$stmt->bind_result($title_from_db, $content_from_db, $privacy_from_db);
		$stmt->execute();
		if ($stmt->fetch()){
			array_push($post_data, true);
			array_push($post_data, $title_from_db);
			array_push($post_data, $content_from_db);
			array_push($post_data, $privacy_from_db);
        } else {
			array_push($post_data, false);
		}
		
		$stmt->close();
		$conn->close();
		return $post_data;
	}
	
	function post_data_update($title, $content , $privacy ,$postitus){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        $stmt = $conn->prepare("UPDATE project SET title = ?, content = ?, privacy = ? WHERE id = ? AND userid = ?");
		echo $conn->error;
        $stmt->bind_param("ssiii", $title, $content, $privacy, $postitus, $_SESSION["user_id"]);
        if($stmt->execute()){
			$notice = "Andmete muutmine õnnestus!";
		} else {
			$notice = "Andmete muutmisel tekkis tõrge!";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
	
	function delete_project($postitus){
		$notice = null;
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
        $stmt = $conn->prepare("UPDATE project SET deleted = NOW() WHERE id = ? AND userid = ?");
		echo $conn->error;
        $stmt->bind_param("ii", $postitus, $_SESSION["user_id"]);
        if($stmt->execute()){
			$notice = "ok";
		} else {
			$notice = "Projekti kustutamisel tekkis tõrge!";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}