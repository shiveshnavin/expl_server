<?php

    // error_reporting($GLOBALS["error"]);


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

        $host = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'];
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
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
      echo json_encode($arr);
?>
