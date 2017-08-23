<?php


	require_once(dirname(__FILE__)."/api_exploman.php");
    error_reporting($GLOBALS["error"]);

if($_GET["mode"]=="search")
	echo json_encode(searchplaces($_GET["query"]));

if($_GET["mode"]=="coor")
	echo json_encode(nearbyplaces($_GET["lat"],$_GET["lng"],$_GET["range"]));





?>