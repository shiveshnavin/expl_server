<?php

	require_once(dirname(__FILE__)."/api_fcm.php");
    error_reporting($GLOBALS["error"]);
	$userid=$_GET["userid"];
	$username=$_GET["username"];
	$fcmtoken=$_GET["fcmtoken"];


	registerfcm($userid,$username,$fcmtoken);  


?>