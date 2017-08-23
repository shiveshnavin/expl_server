<?php



	require_once(dirname(__FILE__)."/api_videos.php");

    error_reporting($GLOBALS["error"]);
$range='10';
$unit='K';

$line = $_GET["location"]; 
list ($lat2, $lon2 )=explode(',', $line); 



	$res=(getvideos());
	$videos=array();


	if(!empty($_GET["location"]))
	{


		foreach ($res as $key => $v) {
			$line2 = $v["location"]; 
list ($lat1, $lon1 )=explode(',', $line2); 

//echo $lat1.'-'. $lon1.'<br>'.$lat2.'-'.$lon2.'<br>Range----'.distance($lat1, $lon1, $lat2, $lon2, $unit);

			if(distance($lat1, $lon1, $lat2, $lon2, $unit)<$range)	
				array_push($videos, $v);


			# code...
		}


	}
	else
	{
	$videos=(getvideos());
	}

	if(empty($_GET["query"]))
	{
			echo json_encode($videos);
			die;

	}
	foreach ($videos as $key => $v) {

		if(strstr( strtolower(json_encode($v)), strtolower($_GET["query"]))==false)
		{

		}
		else
		{
			array_push($res, $v);
		}

	}



	echo json_encode($res);



	?>