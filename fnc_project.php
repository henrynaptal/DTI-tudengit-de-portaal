<?php
	$database = "if21_dti_portaal";
	function save_project($project_title, $project_content, $project_privacy){
		$response = null;
	
		//nüüd Projekt ise
		$stmt = $conn->prepare("INSERT INTO add_project (userid, title, privacy, content) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("isis", $_SESSION["user_id"], $project_title, $project_content, $project_privacy);
		if($stmt->execute()){
			$response = "Projekt on salvestatud!";
		} else {
			$response = "Projekti salvestamine ebaõnnestus!";
		}
		$stmt->close();
		$conn->close();
		return $response;
	}
	
	function latest_project($limit){
		$project_html = null;
		$today = date("Y-m-d");
		$conn = new mysqli($GLOBALS["server_host"], $GLOBALS["server_user_name"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("SELECT title, content, vp_project.added, filename FROM vp_project LEFT JOIN vp_projectphotos on vp_projectphotos.id = vp_project.photoid WHERE vp_project.expire >= ? AND vp_project.deleted IS NULL GROUP BY vp_project.id ORDER By vp_project.id DESC LIMIT ?");
		echo $conn->error;
		$stmt->bind_param("si", $today, $limit);
		$stmt->bind_result($title_from_db, $content_from_db, $added_from_db, $privacy_from_db);
		$stmt->execute();
		while ($stmt->fetch()){
			$project_html .= '<div class="projectblock';
			
			$project_html .= "\t <h3>" .$title_from_db ."</h3> \n";
			$addedtime = new DateTime($added_from_db);
			$project_html .= "\t <p>(Lisatud: " .$addedtime->format("d.m.Y H:i:s") .")</p> \n";
			
			$project_html .= "\t <div>" .htmlspecialchars_decode($content_from_db) ."</div> \n";
			$project_html .= "</div> \n";
		}
		if($project_html == null){
			$project_html = "<p>Kahjuks projekte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $project_html;
	}
?>