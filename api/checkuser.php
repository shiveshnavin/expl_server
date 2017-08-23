<?php


error_reporting(E_ERROR | E_PARSE);
$user_name= $_GET["user_name"];
$user_email= $_GET["user_email"];
$user_password= $_GET["user_password"];

 
	require_once(dirname(__FILE__)."/api.php");
	if(userExist($user_name,$user_email)==false)
{
		err("User Not Exists");

}
else{
	
		err("User Already Exists");

}






?>