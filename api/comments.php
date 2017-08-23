<?php



	require_once(dirname(__FILE__)."/api_social.php");

    error_reporting($GLOBALS["error"]);
 
	echo json_encode(getcomments($_GET["vid"]));




	?>