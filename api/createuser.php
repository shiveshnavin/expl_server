<?php



	require_once(dirname(__FILE__)."/api.php");
//error_reporting(E_ERROR | E_PARSE); 
error_reporting($GLOBALS["error"]);
	if(!userExist($_GET["user_name"],$_GET["user_email"]))
{
	createUser($_GET);
	$user=getUser($_GET["user_name"],0);
	 display($user);
}
else{

	 updateuser($_GET);
	 $user=getUser($_GET["user_name"],0);
	 display($user);
	
} 

?>