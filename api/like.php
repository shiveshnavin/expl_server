<?php
 
	require_once(dirname(__FILE__)."/api_social.php");

    //error_reporting($GLOBALS["error"]);
 	
 	like($_GET["vid"],$_GET["user_id"]);


 	$video=getvideo($_GET["vid"]);

 	echo json_encode($video);


	?>