<?php

	/**
	* Configuration file
	*
	* This should be the only file you need to edit in, regarding the original script.
	* Please provide your MySQL login information below.
	


	$GLOBALS["mysql_hostname"] = "localhost";
	$GLOBALS["mysql_username"] = "id183614_hoproject";
	$GLOBALS["mysql_password"] = "mahanraja1919";
	$GLOBALS["mysql_database"] = "id183614_hoproject";

	
	*/

if(function_exists('date_default_timezone_set'))
{
    date_default_timezone_set("Asia/Kolkata");
}

	$GLOBALS["mysql_hostname"] = "127.0.0.1";
	$GLOBALS["mysql_username"] = "root";
	$GLOBALS["mysql_password"] = "pass";
	$GLOBALS["mysql_database"] = "exploman";

	//E_ALL , 0
	$GLOBALS["error"] = 0;//E_ALL & ~E_NOTICE;


	$GLOBALS["fcm_key_legacy"] = 'AIzaSyCYRtqdteKDrXH62gu7MQLHhbYcCWX9yzM';

	$GLOBALS["fcm_key"] = "AAAAE8cpdsY:APA91bEl8EVlBG2W5jIAtD1FedvqDVzu5elPsDC5k3aRNUKdPI3H8kkuhXj-3qd9RVo-LnY0ey8hAnFXnROrbDTj9_PAikxtf6ur9SaBVBDjoBOQeF3qp6xa-Gu20YrkKsvTIrOWvOO_";

?>