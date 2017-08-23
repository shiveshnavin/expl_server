<?php



	require_once(dirname(__FILE__)."/api_videos.php");

    error_reporting($GLOBALS["error"]);

 	addvideo($_GET);
	echo json_encode(getvideos());




	?>