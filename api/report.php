<?php



	require_once(dirname(__FILE__)."/api_social.php");

    error_reporting($GLOBALS["error"]);

 	report($_GET);
	//echo json_encode(getreports());

 	echo "Thanks ! We will look into it .";



	?>