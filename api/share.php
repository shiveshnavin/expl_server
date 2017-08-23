
<?php

  require_once(dirname(__FILE__)."/api_videos.php");
    error_reporting($GLOBALS["error"]);
  $v=getvideo($_GET["vid"]);

?>
<html>
<head>
<title><?php echo $v->title ?></title>
<link rel="icon" type="image/gif/png" href="<?php echo $v->artwork_url ?>">

</head>
  

<?php
 

function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}

if(isMobileDevice()){

$link='market://details?id=nf.co.hoptec.ayi&url=thehoproject.co.nf://thehoproject.co.nf?encoded(p1=v1&p2=v2)';
$link='intent://thehoproject.co.nf#Intent;scheme=nf.co.hopproject.mcloud;action=my_action;end';
$link='http://thehoproject.co.nf';
$link='ppower://thehoproject.co.nf/share?id='.$v->id;

 

header("Location: $link");
 


}
else{

echo "<a href='http://thehoproject.co.nf/apps.html'>DOWNLOAD APP FIRST</a>";
 
}


?> 
</html>