<?php
	

	require_once(dirname(__FILE__)."/config.inc.php");


/*
http://127.0.0.1/users/api/createuser.php?user_name=shiveshnavin&user_fname=shivesh%20navin&user_password=pass&user_email=shiveshnavin@gmail.com&user_role=ADMIN&user_group=1002&user_status=PENDING 
fields
user_name
user_fname
user_password
user_email
user_created
user_role
user_group
user_status
*/


function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
      return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
  } else {
      return $miles;
  }
}


function isloggedin()
{
	if(isset($_SESSION['username'])&&isset($_SESSION['password']))
	{
		return true;
	}
	else

	{
		return false;;
	}
}
function err($msg)
{
	echo '{"error":"'.$msg.'"}';
}
function mysqlc()
{



$mysqli = new mysqli($GLOBALS["mysql_hostname"], $GLOBALS["mysql_username"], $GLOBALS["mysql_password"], $GLOBALS["mysql_database"]);
			if( $mysqli->connect_error )
				throw new Exception("MySQL connection could not be established: ".$mysqli->connect_error);


  return $mysqli;

}

function execute($q){
	$mysqli=mysqlc();
   
$query = $mysqli->query( $q); 
$mysqli->close();
return $query;



}
 

function login($user_name,$user_email,$user_password,$auth)
{
 
  return true;
 die;
 if(isset($user_password)!=0){
$sql='SELECT * FROM users where  `user_password`="'.$user_password.'" AND (`user_name`="'.$user_name.'" OR `user_email`="'.$user_email.'");';
$results =( execute($sql)); 

if($results->num_rows == 0){
    return false;
}
else{
	$sql = 'INSERT INTO `'.$GLOBALS["mysql_database"].'`.`log` (`user_name`, `type`, `description`, `time` ) VALUES ("'.$user_name.'",   \'USER_LOGIN\', \'User logged in\', NOW() );';
	 
execute($sql);


 return $results->fetch_object(); 
}
}
else 
 if( isset($auth)!=0){
$sql='SELECT * FROM users where  `auth`="'.$auth.'" AND (`user_name`="'.$user_name.'" OR `user_email`="'.$user_email.'");';
 $results =( execute($sql)); 

if($results->num_rows == 0){
     return false;
}
else{


$res=$results->fetch_object(); 
 $user_name=$res->user_name;
	$sql2 = 'INSERT INTO `'.$GLOBALS["mysql_database"].'`.`log` (`user_name`, `type`, `description`, `time` ) VALUES ("'.$user_name.'",   \'USER_LOGIN\', \'User logged in\', NOW() );';
 execute($sql2);
 return $res;
}

 	}

}
function get_group_requests($user_name)
{
if(!empty($user_name)){
$sql='SELECT * from group_request where user_name ="'.$user_name.'";';
}
else{

$sql = "SELECT * FROM `group_request` "
    . "ORDER BY `group_request`.`status` DESC  ";

}
  $results =( execute($sql)); 
  $requests=array();
 while($row = $results->fetch_assoc()) {
     array_push($requests, $row);
 }  


return $requests;





}


function getgroup($id)
{

$sql='SELECT * FROM groups where  id='.$id;
  $results =( execute($sql)); 
 
 return $results->fetch_object();  
}




function getgroups()
{

$sql='SELECT * FROM groups where  1;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

	 

function getusers( )
{
$sql='SELECT * FROM users where  1;';
 $results =( execute($sql)); 
  $users=array();
 while($row = $results->fetch_assoc()) {
     array_push($users, $row);
 }  
return $users;
}




function getlastactivity($user_name,$type)
{
$sql='SELECT * FROM `'.$GLOBALS["mysql_database"].'`.`log` WHERE `'.$GLOBALS["mysql_database"].'`.`log`.`time` = (SELECT MAX(`time`) FROM `'.$GLOBALS["mysql_database"].'`.`log` WHERE `user_name`="'
.$user_name.'" AND `type`="'.$type.'");';

 
 
$results =( execute($sql)); 
if( mysqli_num_rows($results)<1 ){
    return false;
}
 return $results->fetch_object(); 


}
function getuser($user_name,$user_email)
{
 
$sql='SELECT * FROM users where  `user_name`="'.$user_name.'" OR `user_email`="'.$user_email.'";';


$results =( execute($sql)); 
 return $results->fetch_object(); 

}

function getuserbyid($user_id)
{
 
$sql='SELECT * FROM users where  `uid`="'.$user_id.'";';


$results =( execute($sql)); 
 return $results->fetch_object(); 

}

function display($user)
{
    echo json_encode($user);
}

function userExist($user_name,$user_email)
{
 
$sql='SELECT * FROM users where  `user_name`="'.$user_name.'" OR `user_email`="'.$user_email.'";';

$results =( execute($sql));
if($results->num_rows > 0){
    return true;
}
 
return false;
 

}



function updateuser($GET){  

error_reporting($GLOBALS["error"]);
$user_name=$GET["user_name"];
$user_fname=$GET["user_fname"];
$user_password=$GET["user_password"];
$user_email=$GET["user_email"];
$user_role=$GET["user_role"];
$user_group=$GET["user_group"];
$user_status=$GET["user_status"];
$auth=$GET["auth"];
$user_image=$GET["user_image"];
$extra0=$GET["extra0"];
$extra1=$GET["extra1"];
$extra2=$GET["extra2"];

$keys=array(
"user_name",
"user_fname",
"user_password",
"auth",
"user_email",
"user_image");
 

//(empty($user_fname)?$user["user_fname"]:$user_fname)

  $user=getUser($user_name,0); 
 
$sql='INSERT INTO `'.$GLOBALS["mysql_database"].'`.`users` (`user_name`, `user_fname`, `user_password`,`auth`, `user_email`,`user_image`, `user_created`, `extra0`, `extra1`, `extra2`) VALUES ("'.$user_name.'", "'.$user_fname.'", "'.$user_password.'", "'.$auth.'", "'.$user_email.'", "'.$user_image.'", NOW(), "'.$extra0.'", "'.$extra1.'", "'.$extra2.'");';
 
   $sql='UPDATE  `'.$GLOBALS["mysql_database"].'`.`users` SET  
   `user_fname` =  "'.(empty($user_fname)?$user->user_fname:$user_fname).'" ,
   `user_email` =  "'.(empty($user_email)?$user->user_email:$user_email).'" ,
   `user_image` =  "'.(empty($user_image)?$user->user_image :$user_image).'" ,
   `user_name` =  "'.(empty($user_name)?$user->user_name :$user_name).'" ,
   `user_password` =  "'.(empty($user_password)?$user->user_password :$user_password).'" ,
   `extra0` =  "'.(empty($extra0)?$user->extra0 :$extra0).'" ,
   `extra1` =  "'.(empty($extra1)?$user->extra1 :$extra1).'" ,
   `extra2` =  "'.(empty($extra2)?$user->extra2 :$extra2).'" 
    WHERE `users`.`auth` ="'.$auth.'" OR `users`.`user_password` ="'.$user_password.'";';
  
 
  
 return execute($sql);


}

  $GLOBALS["types"] = "USER_LOGIN,USER_CREATED,COMMAND_RUN,GROUP_CREATE,USER_DELETE,GROUP_DELETE,USER_UPGRADE";


function loge($user_name,$type,$desc)
{
  $sql = 'INSERT INTO `'.$GLOBALS["mysql_database"].'`.`log` (`user_name`, `type`, `description`, `time` ) VALUES ("'.$user_name.'","'.$type.'",
  "'.$desc.'", NOW() );';
   
execute($sql);

}


function createUser($GET){  

error_reporting(0);
$user_name=$GET["user_name"];
$user_fname=$GET["user_fname"];
$user_password=$GET["user_password"];
$user_email=$GET["user_email"];
$user_role=$GET["user_role"];
$user_group=$GET["user_group"];
$user_status=$GET["user_status"];
$auth=$GET["auth"];
$user_image=$GET["user_image"];
$extra0=$GET["extra0"];
$extra1=$GET["extra1"];
$extra2=$GET["extra2"];

$keys=array(
"user_name",
"user_fname",
"user_password",
"auth",
"user_email",
"user_image");

/**/

foreach ($keys as $key ) {
	# code...
 if( !isset($GET[$key]) || $GET[$key] == "")
{

err( "ERROR EMPTY ".$key);
	return false;

}
}


  
if(userExist($user_name,$user_email)){
   err( "ERR USER ALREADY EXISTS");
 
   return false;
}




$sql='INSERT INTO `'.$GLOBALS["mysql_database"].'`.`users` (`user_name`, `user_fname`, `user_password`,`auth`, `user_email`,`user_image`, `user_created`, `extra0`, `extra1`, `extra2`) VALUES ("'.$user_name.'", "'.$user_fname.'", "'.$user_password.'", "'.$auth.'", "'.$user_email.'", "'.$user_image.'", NOW(), "'.$extra0.'", "'.$extra1.'", "'.$extra2.'");';
  
 return execute($sql);


}

	$GLOBALS["types"] = "USER_LOGIN,USER_CREATED,COMMAND_RUN,GROUP_CREATE,USER_DELETE,GROUP_DELETE,USER_UPGRADE";

 
function getuserlogs($user_name)
{


 $folder=dirname(__FILE__).'/logs/'.$user_name;

$log='';
$files = scandir($folder);
sort($files); // this does the sorting
foreach($files as $file){

	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";




$actual_link=str_replace(basename(__FILE__) , "", $actual_link);
if($file=='..'||$file=='.')
	;
else{
   
$log=$log."".mess('<br><a href="'.$actual_link.'api/logs/'.$user_name.'/'.$file.'">'.$file.'</a>',0,16); 
}
}
 return $log;

}
function mes($message,$success,$color)
{
	
	if(empty($color))
		{ 
			if ($success==1) {

              $color="#18bf18";
   		}
   		else{
   			$color="#f01212";
   		}
	}

return  '<div style ="font:17px/24px Arial,tahoma,sans-serif;color:'.$color.'"> '.$message.' </div>';

}

function mess($message,$success,$size,$color)
{
	
	if(empty($size))
		{ 
			$size=17;
		}
	if(empty($color))
		{ 
			if ($success==1) {

              $color="#18bf18";
   		}
   		else{
   			$color="#f01212";
   		}
	}

return  '<div style ="font:'.$size.'px Arial,tahoma,sans-serif;color:'.$color.'"> '.$message.' </div>';

}


function bind_user_group($user_name,$group_id)
{
   $user=getuser($user_name);

if (strpos($user->user_group, $group_id) !== false) {
   return;
}


if($user->user_role=="ADMIN"){
   $groups=$user->user_group.' '.$group_id;

   $sql='UPDATE  `'.$GLOBALS["mysql_database"].'`.`users` SET  `user_group` =  "'.$groups.'" WHERE  `users`.`user_name` ="'.$user_name.'";';
 
}
else{
$sql = 'INSERT INTO `'.$GLOBALS["mysql_database"].'`.`group_request` (  `user_name`, `groupid`, `when`, `status`) VALUES (  "'.$user_name.'", "'.$group_id.'", NOW(),  "PENDING");';
 
}
   execute($sql);

}





function bind_user_group_approve($user_name,$group_id)
{
   $user=getuser($user_name);

if (strpos($user->user_group, $group_id) !== false) {
   return;
}

 
   $groups=$user->user_group.' '.$group_id;

   $sql='UPDATE  `'.$GLOBALS["mysql_database"].'`.`users` SET  `user_group` =  "'.$groups.'" WHERE  `users`.`user_name` ="'.$user_name.'";';
 
  execute($sql);

 
   $sql='UPDATE  `'.$GLOBALS["mysql_database"].'`.`group_request` SET  `status` =  "APPROVED" WHERE  `group_request`.`groupid` ="'.$group_id.'" AND `group_request`.`user_name` ="'.$user_name.'";';
   execute($sql);


}

 function get_user_commands($user_name)
{
	 
$user=getuser($user_name);
$groups = explode(" ", $user->user_group);

$commands="";

 foreach ($groups as $key) {
  if($key==" "||empty($key))
  {
  	break;
  }
       
 $sql = "SELECT `commands` FROM `groups` WHERE id=".$key;
 $res=execute($sql);
 $commands=$commands." ".$res->fetch_object()->commands ; 
 

 }
    
if(getuser($user_name)->user_role=="ADMIN")
	return "ALL";

  return $commands; 
}

function check_command_access($user_name,$command)
{ 

if(getuser($user_name)->user_role=="ADMIN")
	return true;



$a = get_user_commands($user_name);
 
$found=false;
 $words = explode(" ", $command);
foreach ($words as $key) {

	 }

if (preg_match('/'.$words[0].'/',$a))
    $found=true;
 


 	return $found;;






}


function createPath($dirpath,$mode) {

     return is_dir($dirpath) || mkdir($dirpath,$mode, true);

 

}

function save_log($user_name,$log,$id)
{

	 $folder=dirname(__FILE__).'/logs/'.$user_name;


 $old = umask(0);
mkdir( $folder, 0777,true);
umask($old);
$file=$folder.'/'.$id. ".html";
$wait=exec('rm -r -f '.$file);



 file_put_contents( $file,$log,"0777");

}

?>