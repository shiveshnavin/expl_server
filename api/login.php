<?php


	require_once(dirname(__FILE__)."/api.php");

	 error_reporting(0);

$user_name= $_GET["user_name"];
$user_email= $_GET["user_email"];
$user_password= $_GET["user_password"];
$auth= $_GET["auth"];

 


	 
	if(isset($user_password)){ 
	if(login($user_name,$user_email,$user_password,$auth)==false)
{
		err("Invalid Credentials !");

}
else{
	display(login($user_name,$user_email,$user_password,$auth));


}}

else if(isset($auth)){
if(login($user_name,$user_email,$user_password,$auth)==false)
{
		err("Invalid Auth !");

}
else{
	display(login($user_name,$user_email,$user_password,$auth));


} 

}
 





?>