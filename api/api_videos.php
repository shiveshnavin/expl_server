<?php







	require_once(dirname(__FILE__)."/api.php");
   

 





function getvideo($vid )
{
$sql='SELECT * FROM videos where  `id`="'.$vid.'";';
 $results =( execute($sql)); 
  
 return $results->fetch_object();  
}



function getuservideos($user_id )
{
$sql='SELECT * FROM videos where  `user_id`="'.$user_id.'";';
 $results =( execute($sql)); 
  $users=array();
 while($row = $results->fetch_assoc()) {
     array_push($users, $row);
 }  
return $users;
}




function getallvideos()
{

$sql='SELECT * FROM videos where  1 ORDER BY created_at DESC;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

function getvideos()
{

$sql='SELECT * FROM videos where  `approved`=1 ORDER BY created_at DESC;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

function addvideo($GET)
{

	if(empty($GET["title"])||empty($GET["stream_url"]))
	{
		echo '{"error":"Empty title or stream url"}';
		die;
	}


$title=$GET["title"];
$description=$GET["description"];
$duration=$GET["duration"];
$user=$GET["user"];
$user_image=$GET["user_image"];
$user_id=$GET["user_id"];
//$likes=0;$GET["likes"]; 
//$created_at=$GET["created_at"];
$artwork_url=$GET["artwork_url"];
$stream_url=$GET["stream_url"];
$location=$GET["location"];
//$tag_list=$tag_list;
 


 $sql='INSERT INTO  `videos` (`title`, `description`, `duration`, `user`, `user_image`, `user_id`, `created_at`, `artwork_url`,`stream_url`,`location`) VALUES ( "'.$title.'", "'.$description.'", '.$duration.', "'.$user.'", "'.$user_image.'",'.$user_id.',NOW(), "'.$artwork_url.'","'.$stream_url.'","'.$location.'")';
execute($sql);


}


function approve($vid )
{ 

$sql='UPDATE `videos` SET `approved`=1 WHERE `id`="'.$vid.'";';

$results =( execute($sql)); 
 

}

function disapprove($vid )
{ 

$sql='UPDATE `videos` SET `approved`=0 WHERE `id`="'.$vid.'";';

$results =( execute($sql)); 
 

}





?>