<?php

	require_once(dirname(__FILE__)."/api_rev.php");
 /******************GUIDE****************/
function getguide($id)
{

$sql='SELECT * FROM guides where  id='.$id;
  $results =( execute($sql)); 
 
 return $results->fetch_object();  
}



function getguides()
{

$sql='SELECT * FROM guides where  1;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}
function guide($POST)
{


	$id = trim($POST["id"]);
	$mode = trim($POST["mode"]);
	$del_id = trim($POST["del_id"]);

	$name = trim($POST["name"]);
	$desc = trim($POST["desc"]);
	$lat = trim($POST["lat"]);
	$rate = trim($POST["rate"]);
	$lng = trim($POST["lng"]);
	$address = trim($POST["address"]);
	$images = trim($POST["images"]);
	$rating = trim($POST["rating"]);
	$place_id = trim($POST["place_id"]);


$rating=empty($rating)?4:$rating;

	
	
if($id) {
	/// UPDATE

//echo $id;
$iarrj= ((getplace($id)->images));
 
if($iarrj==null)
{
	$iarrj="[]";
}
$iarr=json_decode($iarrj);
array_push($iarr, $POST["image"]);  

$images=json_encode($iarr);


	$result =  ("UPDATE guides
	SET  name = '$name',  `desc` = '$desc',  lat = $lat,  lng = $lng,  address = '$address',  images = '$images' ,rating=$rating,  rate = $rate,place_id=$place_id
	WHERE id = '$id' "); 
} elseif($del_id) {
	/// DELETE
	$result =  ("DELETE FROM guides WHERE id = '".$del_id."' ");
} elseif($mode == "add") {
	/// ADD


$iarrj="[]";
$iarr=json_decode($iarrj);
if(!empty($POST["image"]))
array_push($iarr, $POST["image"]);  

$images=json_encode($iarr);
 

	$result =  ("INSERT INTO guides (id, name, `desc`, place_id, lat, lng, rate, address, images, rating)
	VALUES ('', '$name', '$desc',$place_id, $lat, $lng ,$rate, '$address', '$images', $rating)");
}	
;
 //echo $result;
 if(execute($result)) { alert( "Successful"); } else {  alert(  "There has been an error!"); }
 
}



/******************PLACE****************/
function getplace($id)
{

$sql='SELECT * FROM places where  id='.$id;
  $results =( execute($sql)); 
 
 return $results->fetch_object();  
}


function nearbyplaces($lat,$lon,$miles = 5)
{
 if(empty($miles))
 {
 	$miles=5;
 }

$sql = "SELECT *, 
( 3959 * acos( cos( radians('$lat') ) * 
cos( radians( lat ) ) * 
cos( radians( lng ) - 
radians('$lon') ) + 
sin( radians('$lat') ) * 
sin( radians( lat ) ) ) ) 
AS distance FROM `places` HAVING distance < '$miles' ORDER BY distance ASC LIMIT 0, 100";


 //echo $sql;
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

function searchplaces($query)
{

$sql="SELECT * FROM `places` where  `name` LIKE '%$query%' OR `desc` LIKE '%$query%' OR `address` LIKE '%$query%' ;";
//echo $sql;
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}

function getplaces()
{

$sql='SELECT * FROM places where  1;';
 $results =( execute($sql)); 
  $groups=array();
 while($row = $results->fetch_assoc()) {
     array_push($groups, $row);
 }  
return $groups;
}
function place($POST)
{


	$id = trim($POST["id"]);
	$mode = trim($POST["mode"]);
	$del_id = trim($POST["del_id"]);

	$name = trim($POST["name"]);
	$desc = trim($POST["desc"]);
	$lat = trim($POST["lat"]);
	$lng = trim($POST["lng"]);
	$address = trim($POST["address"]);
	$images = trim($POST["images"]);
	$rating = trim($POST["rating"]);
	 
	if(empty($rating))
		$rating=4;
	
if($id) {
	/// UPDATE

//echo $id;
$iarrj= ((getplace($id)->images));
 
if($iarrj==null)
{
	$iarrj="[]";
}
$iarr=json_decode($iarrj);
if(!empty($POST["image"]))
array_push($iarr, $POST["image"]);  

$images=json_encode($iarr);




	$result =  ("UPDATE places
	SET  name = '$name',  `desc` = '$desc',  lat = $lat,  lng = $lng,  address = '$address',  images = '$images' , `rating`=$rating
	WHERE id = '$id' "); 
} elseif($del_id) {
	/// DELETE
	$result =  ("DELETE FROM places WHERE id = '".$del_id."' ");
} elseif($mode == "add") {
	/// ADD


$iarrj="[]";
$iarr=json_decode($iarrj);
array_push($iarr, $POST["image"]);  

$images=json_encode($iarr);
$rating=0;


	$result =  ("INSERT INTO places (id, name, `desc`, lat, lng, address, images, rating)
	VALUES ('', '$name', '$desc', $lat, $lng, '$address', '$images', $rating)");
}	
;
//echo $result;
 if(execute($result)) { alert( "Successful"); } else {  alert(  "There has been an error!"); }
 
}





 
function addplace($GET)
{

	if(empty($GET["name"])||empty($GET["lat"])||empty($GET["lng"]))
	{
		echo '{"error":"Empty Name or LAT LNG"}';
		die;
	}


$name=$GET["name"];
$desc=$GET["desc"];
$lat=$GET["lat"];
$lng=$GET["lng"];
$address=$GET["address"];
$iarrj="[]";
$iarr=json_decode($iarrj);
array_push($iarr, $GET["image"]);  

$images=json_encode($iarr);
 

$sql = "INSERT INTO `exploman`.`places` (  `name`, `desc`, `lat`, `lng`, `address`, `images` ) VALUES ('$name', '$desc', $lat, $lng, '$address', "
.'\''.$images.'\''." );";

 echo $sql;
execute($sql);


}


















	function uploadfile($FILES)
	{

    	 $arr = array( 'message' => "Upload Failed");

$target_dir = "files/";
$fname=date("Y_m_d_H_i_s").basename($_FILES["file"]["name"]);
$target_file = $target_dir .$fname;
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_FILES["file"])) {
    $check = filesize($_FILES["file"]["tmp_name"]);
     
       // echo "File Size is- " . $check  . ".";
        $uploadOk = 1;


     if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
      //  echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";

$curdir = dirname($_SERVER['REQUEST_URI'])."/";

        $host = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'];
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$curdir";

      //  echo $actual_link;
       // echo "<br><br>";

        $dir=str_replace(basename(__FILE__), "", $actual_link);
        chmod($target_file, 0777);
       // echo $dir.$target_file;
        $stream_link=$dir.'stream.php?file='.$fname;
        
        $arr = array('name' => basename($_FILES["file"]["name"]), 'link' =>$dir.$target_file ,'stream_link' =>$stream_link ,'size' =>  $check,'message' => "Upload Success");
 
        if($check<2)
        {
    	 $arr = array( 'message' => "Upload Failed");

        }



    }
    
}
      return ($arr);
	}



?>