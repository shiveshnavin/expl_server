<?php







require_once(dirname(__FILE__)."/api.php");
	require_once(dirname(__FILE__)."/api_videos.php");
   

function report($GET)
{


$user_name=$GET["user"];
$user_id=$GET["user_id"];
$user_image=$GET["user_image"];
$comment=$GET["comment"];
$title=$GET["title"];
$reply='-';;//$GET["reply"];
$extra0=$GET["extra0"];
$extra1=$GET["extra1"];

$sql="INSERT INTO reports (user_name, user_id, user_image ,title, comment, reply, date, extra0,extra1) VALUES ('$user_name', $user_id, '$user_image', '$title', '$comment', '$reply', NOW(), '$extra0', '$extra1');";
 
execute($sql);

}


function reply_report($reply,$reportid)
{

$sql='UPDATE `reports` SET  `reply`="'.$reply.'"  WHERE id='.$reportid.';';
execute($sql);

}



function deletereport( $reportid)
{

$sql='DELETE FROM `reports`  WHERE id='.$reportid.';';
execute($sql);


}


function getreports( )
{
$sql='SELECT * FROM reports order by  `date` desc ;';
 $results =( execute($sql)); 
  $users=array();
 while($row = $results->fetch_assoc()) {
     array_push($users, $row);
 }  
return $users;
}


/*********************************/



function deletecomment( $commentid)
{

$sql='DELETE FROM `comments`  WHERE id='.$commentid.';';
execute($sql);


}

function comment($GET)
{


$user_name=$GET["user"];
$user_id=$GET["user_id"];
$user_image=$GET["user_image"];
$comment=$GET["comment"];
$reply='-';;//$GET["reply"];
$vid=$GET["vid"];

$sql="INSERT INTO comments (user_name, user_id, user_image, comment, reply, date, vid) VALUES ('$user_name', $user_id, '$user_image', '$comment', '$reply', NOW(), '$vid');";
 
execute($sql);

}


function reply($reply,$commentid)
{

$sql='UPDATE `comments` SET  `reply`="'.$reply.'"  WHERE id='.$commentid.';';
execute($sql);

}


function getallcomments( )
{
$sql='SELECT * FROM comments order by  `date` desc ;';
 $results =( execute($sql)); 
  $users=array();
 while($row = $results->fetch_assoc()) {
     array_push($users, $row);
 }  
return $users;
}




function getcomments($vid )
{
$sql='SELECT * FROM comments where  `vid`="'.$vid.'";';
 $results =( execute($sql)); 
  $users=array();
 while($row = $results->fetch_assoc()) {
     array_push($users, $row);
 }  
return $users;
}


function like($vid,$user_id)
{

	$video=getvideo($vid); 


	if(strstr($video->tag_list, ':'.$user_id)==false)
	{
		
		addlike($vid);
		$tag_list=$video->tag_list.':'.$user_id;

		$sql='UPDATE `videos` SET `tag_list`="'.$tag_list.'" WHERE `id`="'.$vid.'";';
 
		$results =( execute($sql)); 
		
	}
	else{

		removelike($vid);
		$tag_list=str_replace(':'.$user_id, '', $video->tag_list);

		$sql='UPDATE `videos` SET `tag_list`="'.$tag_list.'" WHERE `id`="'.$vid.'";';
 
		$results =( execute($sql));  
	}

}


function addlike($vid )
{ 

$sql='UPDATE `videos` SET `bpm`=`bpm`+1 WHERE `vid`="'.$vid.'";';

$results =( execute($sql)); 
 

}

 
function removelike($vid )
{
 
$sql='UPDATE `videos` SET `likes`=`likes`-1 WHERE `vid`="'.$vid.'" ;';

$results =( execute($sql)); 
 

}

 
 ?>