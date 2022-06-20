<?php
    require_once("use_session.php");
	
    require_once("../../../../config_vp_s2021.php");
	require_once("fnc_project.php");
    require_once("fnc_general.php");
    //fotode üleslaadimise klass
    require_once("classes/Photoupload.class.php");
    
    
    $project_notice = null;
    $project_error = null;
	$project_title = null;
	$project = null;
    //uudise aegumine
    $expire = new DateTime("now");
    $expire->add(new DateInterval("P7D"));
    
    $expire_date = date_format($expire, "Y-m-d");
    //echo $expire_date;
	$photo_file = null;
    
    $normal_photo_max_width = 600;
    $normal_photo_max_height = 400;
	$thumbnail_width = $thumbnail_height = 100;
    
    $photo_filename_prefix = "vpproject_";
    $photo_upload_size_limit = 1024 * 1024;
	$allowed_photo_types = ["image/jpeg", "image/png"];
        
    if(isset($_POST["project_submit"])){
		//uudise tekst sisaldab nüüd html märgendeid (näiteks <b> ...).
        //Kindlasti tuleks kasutada meie funktisooni test_input()
        //selles on ka htmlspecialchars(uudis) funktsioon, mis kodeerib html erimärgid ringi, ohutks ("<" -> &lt;
        //pärast, uudise näitamisel, et html taastuks, on vaja: htmlspecialchars_decode(uudis_andmebaasist)
        //kui on ka foto valitud, salvestage see esimesena, ka andmetabelisse. Siis saate kohe ka tema id kätte: $photo_id = $conn->insert_id;
        //uudsie näitamisel tuleb arvestada ka aegumist
        //$today = date("Y-m-d");
        //SQL lauses   WHERE added >= ?
		if(empty($_POST["title_input"])){
			$project_error = "Uudise pealkiri on puudu!";
		} else {
			$project_title = test_input($_POST["title_input"]);
		}
		if(empty($_POST["project_input"])){
			$project_error .= " Uudise sisu on puudu!";
		} else {
			$project = test_input($_POST["project_input"]);
		}
		
		if(!empty($_POST["expire_input"])){
			$expire_date = $_POST["expire_input"];
			//echo $expire_date;
		} else {
			$project_error .= " Palun vali Aegumistähtaja päev!";
		}
		if($expire_date < date("Y-m-d")){
			$project_error .= " Aegumistähtaeg on minevikus!";
		}
		
		//kas foto on valitud
        if(isset($_FILES["photo_input"]["tmp_name"]) and !empty($_FILES["photo_input"]["tmp_name"])){
			$photo_upload = new Photoupload($_FILES["photo_input"]);
			if(empty($photo_upload->error)){
				$photo_upload->check_alowed_type($allowed_photo_types);
				if(empty($photo_upload->error)){
					$photo_upload->check_size($photo_upload_size_limit);
					if(empty($photo_upload->error) and empty($project_error)){
						$photo_upload->create_filename($photo_filename_prefix);
						$photo_upload->resize_photo($normal_photo_max_width, $normal_photo_max_height);
						$project_notice = "Uudise pildi " .$photo_upload->save_image($photo_project_upload_dir .$photo_upload->file_name);
						$photo_file .= $photo_upload->file_name;
					}
				}
			}
			$project_error .= $photo_upload->error;
			
			unset($photo_upload);
		}
		if(empty($project_error)){
			$project_notice .= save_project($project_title, $project, $expire_date, $photo_file);
		}

    }
    
    $to_head = '<script src="javascript/checkFileSize.js" defer></script>' ."\n";
    $to_head .= '<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>';
    
    require("page_header.php");
?>

	<h1><?php echo $_SESSION["first_name"] ." " .$_SESSION["last_name"]; ?>, veebiprogrammeerimine</h1>
	<p>See leht on valminud õppetöö raames ja ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p>Õppetöö toimus <a href="https://www.tlu.ee/dt">Tallinna Ülikooli Digitehnoloogiate instituudis</a>.</p>
	<hr>
    <ul>
        <li><a href="?logout=1">Logi välja</a></li>
		<li><a href="home.php">Avaleht</a></li>
    </ul>
	<hr>
    <h2>Uudise lisamine</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
        <label for="title_input">Uudise pealkiri</label>
        <input type="text" id="title_input" name="title_input" value="<?php echo $project_title; ?>">
        <br>
        <label for="project_input">Uudis</label>
        <textarea id="project_input" name="project_input"><?php echo htmlspecialchars_decode($project); ?></textarea>
        <script>CKEDITOR.replace( 'project_input' );</script>
        <br>
        <label for="expire_input">Viimane kuvamine kuupäev</label>
        <input id="expire_input" name="expire_input" type="date" value="<?php echo $expire_date; ?>">
        <br>
        <label for="photo_input"> Vali pildifail! </label>
        <input type="file" name="photo_input" id="photo_input">
        
        <br>
        <input type="submit" name="project_submit" id="project_submit" value="Salvesta uudis"><span id="notice"><?php echo $project_error; ?></span>
    </form>
    <span><?php echo $project_notice; ?></span>
</body>
</html>