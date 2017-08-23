<?php


	require_once(dirname(__FILE__)."/api.php");

	function registerfcm($userid,$username,$fcmtoken)
	{

	$sql='UPDATE  `'.$GLOBALS["mysql_database"].'`.`users` SET  `extra0` =  "'.$fcmtoken.'" WHERE `users`.`uid` ="'.$userid.'" OR `users`.`user_name` ="'.$username.'";';
 
   execute($sql);
   echo json_encode(getuserbyid($userid));


	} 



	function sendfcm($message, $id) {


    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = array (
            'registration_ids' => array (
                    $id
            ),
            'data' => array (
                    "message" => $message
            )
    );
    $fields = json_encode ( $fields );

    $headers = array (
            'Authorization: key=' . $GLOBALS["fcm_key"],
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
   // echo $result;
    curl_close ( $ch );
}



   // sendfcmtotopic("title","text","message", "allDevices");
    function sendfcmtotopic($title,$text,$message, $topic) {


$ch = curl_init("https://fcm.googleapis.com/fcm/send");
$header=array('Content-Type: application/json',
'Authorization: key='.$GLOBALS["fcm_key"]);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

curl_setopt($ch, CURLOPT_POST, 1);


        $body='{"data": {
                "click_action":"ChatActivity",
                "message": "'.$message.'",
                "title": "'.$title.'",
                "text": "'.$text.'"},
                "to" : "/topics/'.$topic.'"}';




curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

$result = curl_exec ( $ch );
//echo $result;
curl_close($ch);


}

?>



  