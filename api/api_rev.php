<?php



	require_once(dirname(__FILE__)."/api.php");

function alert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}
function br($n=1)
{
  for($i=0;$i<$n;$i++)
    echo "<br>";
}

function setuseravail($user_name,$avail=0)
{
  # code...

  $sql="UPDATE `dist`.`users` SET avail=".$avail." WHERE user_name='".$user_name."'";;
  execute($sql);
}

function getscript($id)
{

$sql='SELECT * FROM scripts where  id='.$id;
  $results =( execute($sql)); 
 
 $scr= $results->fetch_object(); 
 return $scr;
}



	
function updatescript($REQUEST)
{
 $date = date_create();
$filename= sanitize($REQUEST["name"]).'_'.date_timestamp_get($date);

  
	$REQUEST["path"]=save_script($filename,$REQUEST["commands"]);
  if(!empty($REQUEST["name"])&&!empty($REQUEST["path"]))
 {


	$sql = 'UPDATE `dist`.`scripts` SET `name` = "'.$REQUEST["name"].'", `path` =  "'.$REQUEST["path"].'" WHERE `scripts`.`id` =  '.$REQUEST["id"].';';
  	execute($sql);

  
}


}



function getscripts()
{

$sql='SELECT * FROM scripts where  1;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

	
function createscript($REQUEST)
{
 $date = date_create();
$filename= sanitize($REQUEST["name"]).'_'.date_timestamp_get($date);
	$cmds=str_replace('"', '\'', $REQUEST["commands"]);

	$REQUEST["path"]=save_script($filename,$cmds);
  if(!empty($REQUEST["name"])&&!empty($REQUEST["path"]))
 {

$sql='INSERT INTO  `dist`.`scripts` (
`id` ,
`name` ,
`path` ,
`user_id`
)
VALUES (
NULL ,  "'.$REQUEST["name"].'",  "'.$REQUEST["path"].'",  "'.$REQUEST["user_id"].'"
);';
 execute($sql);
}


}



function save_script($filename,$log)
{

	 $folder=dirname(__FILE__).'/scripts';


 $old = umask(0);
mkdir( $folder, 0777,true);
umask($old);
$file=$folder.'/'.$filename. ".sh";
$wait=exec('rm -r -f '.$file);



 file_put_contents( $file,$log,"0777");

$wait2=exec('chmod 777 '.$file);

 return $file;

}





function bind_script_group($script,$group_id)
{

	$scr =getscript($script->id);
 
   	$script->groups=str_replace($group_id.':', '', $script->groups);
   $groups=  $script->groups.$group_id.':';

	$sql = "UPDATE `dist`.`scripts` SET `groups` =  '$groups'   WHERE `scripts`.`id` =   $script->id ;";
  	execute($sql);
 	 

}


function remove_script_group($script,$group_id)
{

	$scr =getscript($script->id);
 
   	$script->groups=str_replace($group_id.':', '', $script->groups);
 
	$sql = "UPDATE `dist`.`scripts` SET `groups` =  '$groups'   WHERE `scripts`.`id` =   $script->id ;";
  	execute($sql);
 	 

}



function getgroupscripts($group_id)
{

$sql='SELECT * FROM scripts where  `groups` LIKE ("%'.$group_id.'%");';
  $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }   
return $groups;
}


function getrole($id)
{

$sql='SELECT * FROM roles where  id='.$id;
  $results =( execute($sql)); 
 
 return $results->fetch_object();  
}


function getroles( )
{ 

$sql = "SELECT * FROM `roles` WHERE 1";

 
  $results =( execute($sql)); 
  $requests=array();
 while($row = $results->fetch_assoc()) {
     array_push($requests, $row);
 }   
return $requests; 
}
function getcus($id)
{

$sql='SELECT * FROM customers where  id='.$id;
  $results =( execute($sql)); 
   return $results->fetch_object();  
}



function getcuss( )
{ 

$sql = "SELECT * FROM `customers` WHERE 1";

 
  $results =( execute($sql)); 
  $requests=array();
 while($row = $results->fetch_assoc()) {
     array_push($requests, $row);
 }   
return $requests; 
}
function get_role_request($id)
{

$sql='SELECT * FROM role_request where  id='.$id;
  $results =( execute($sql)); 
  return $results->fetch_object();  
}



function get_role_requests( )
{ 

$sql = "SELECT * FROM `role_request` "
    . "ORDER BY `role_request`.`status` DESC  ";

 
  $results =( execute($sql)); 
  $requests=array();
 while($row = $results->fetch_assoc()) {
     array_push($requests, $row);
 }  


return $requests;





}
function bind_user_role($user_name,$role_id,$cus_id,$mess)
{
   $user=getuser($user_name,"");
 
 
$sql = "INSERT INTO `dist`.`role_request` (  `user_name`, `roleid`, `cusid`, `message`, `when`, `status`) VALUES (  '".$user_name."', '".$role_id."', '".$cus_id."', '".$mess."', NOW(),  'PENDING');";
 
 	
   execute($sql);

}



function bind_user_role_and_approve($user_name,$roleid, $cusid)
{
   $user=getuser($user_name); 
   $role  =getrole($roleid);
    $cus=getcus($cusid); 
    

   $user_role=$user->user_role;
   $roles=json_decode($user_role);

   if($roles==null)
   {
    $roles=array(); 
   }  
   $new_role = array(); 
   $new_role["cus"]=$cus;
   $new_role["role"]=$role;
   array_push($roles, $new_role);
   //$roles=remove_duplicate($roles);
   $js= json_encode($roles);
   $js=str_replace('"', '\"', $js);
 
    


  
   $sql='UPDATE  `dist`.`users` SET  `user_role` =  "'. $js.'" WHERE  `users`.`user_name` ="'.$user_name.'";';
  //echo $sql;
  execute($sql);

  

}

function bind_user_role_approve($user_name,$role_req_id )
{
   $user=getuser($user_name);
   $role_req=get_role_request($role_req_id);
   $role  =getrole($role_req->roleid);
    $cus=getcus($role_req->cusid); 
    

   $user_role=$user->user_role;
   $roles=json_decode($user_role);

   if($roles==null)
   {
   	$roles=array(); 
   }  
   $new_role = array(); 
   $new_role["cus"]=$cus;
   $new_role["role"]=$role;
   array_push($roles, $new_role);
   //$roles=remove_duplicate($roles);
   $js= json_encode($roles);
   $js=str_replace('"', '\"', $js);
 
    


  
   $sql='UPDATE  `dist`.`users` SET  `user_role` =  "'. $js.'" WHERE  `users`.`user_name` ="'.$user_name.'";';
 	//echo $sql;
  execute($sql);

 
   $sql='UPDATE  `dist`.`role_request` SET  `status` =  "APPROVED" WHERE  `role_request`.`id` = '.$role_req_id.'  ;';
   execute($sql);


}

function remove_duplicate($array)
{

	$ar2=array();
	$arj=array();

	foreach ($array as $key => $value) {
		
			$str=json_encode( $value);
			array_push($arj,$str);

	}

	$arj2=array_unique($arj);

	foreach ($arj2 as $key => $value) {
		# code...
		array_push($ar2, json_encode($value));


	}
	return $arj2;

}
function checkrole($user_name,$roleid,$cusid)
{

	$flag=0;

	$user=getuser($user_name,"");
	$role=getrole($roleid);
	$cus=getcus($cusid);


$roles=json_decode($user->user_role); 
foreach ($roles as $key => $value) {
	
 	$role=getrole($value->role->id);
    $cus=getcus($value->cus->id);
	$role_id=$role->id;
	$cus_id=$cus->id;
 	if($roleid==$role_id&&$cus_id==$cusid)
	{
		$flag=1;
		return $flag;
	}

}
 
 return $flag; 
}

 
function getcgroups($id)
{

$sql='SELECT * FROM groups where  cusid='.$id;
  $results =( execute($sql)); 
 
 
  $results =( execute($sql)); 
  $requests=array();
 while($row = $results->fetch_assoc()) {
     array_push($requests, $row);
 }  


return $requests;
}



function getusersc($cusid)
{

  $susers=array();
  $users=getusers( );

      $groups = getcgroups($cusid) ;


  foreach ($groups as $key => $group) {

  foreach ($users as $key => $user) {
    /*echo "USER : ".$user["user_group"];
    br();
    echo "Grp : ".$group["id"];
    br();*/
     if(strstr($user["user_group"], $group["id"]) )

        {
            array_push($susers,  $user );
           
        }

}

  }

$users=array();
foreach ($susers as $key => $value) {
  $found=0;
  foreach ($users as $key => $user) {
    if($value["user_id"]==$user["user_id"])
    {
      $found=1;
    }
    # code...
  }
      if(!$found)
      {
                      array_push($users,  $value) ;

      }

}




return $users;


}


function parse_role($jstr)
{
$values='';
  $roles=json_decode($jstr); 
$arrayName = array();
foreach ($roles as $key => $value) {
  
  $role=getrole($value->role->id);
 
  
     
 

  $cus=getcus($value->cus->id);
 
$roleid=$role->id;

array_push($arrayName,  $cus->name.' \'s ----> '.$role->name);
 
 
}
$ros=array_unique($arrayName);
foreach ($ros as $key => $value) {
  # code...
   $values=$values.'<br><br>'.$value;
}

return $values;

}



function getage($fromdate)
{
  // /2017-07-18 16:32:09 
 
$date2 = date('Y-m-d h:i:s', time());

$date1 = $fromdate; 
$diff = abs(strtotime($date2) - strtotime($date1)); 
 //echo $date2.'  -  '.$date1.' = '.$diff;

 $years   = floor($diff / (365*60*60*24)); 
$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60)); 

$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 

$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60)); 

 return $days;
}

 
function deletegrpreq($id)
{

$sql='DELETE FROM group_request where  id='.$id;
  $results =( execute($sql)); 
 
 echo $sql;
}












?>