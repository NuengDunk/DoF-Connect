<?php 
require"inc/setting.php";

$content = file_get_contents('php://input');
$arrayJson = json_decode($content,true);

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$channel_token}";

//รับข้อความจาก user
$message = $arrayJson['events'][0]['message']['text'];

//get userID
$id = $arrayJson['events'][0]['source']['userId'];

//Get Message from user type Text+sticker
if($message == "สวัสดี"){
	$arrayPostData['to'] = $id;
	$arrayPostData['messages'][0]['type'] = "text";
	$arrayPostData['messages'][0]['text'] = "สวัสดีค่ะ";
	$arrayPostData['messages'][1]['type'] = "sticker";
	$arrayPostData['messages'][1]['packageId'] = "2";
	$arrayPostData['messages'][1]['stickerId'] = "34";
	pushMsg($arrayHeader,$arrayPostData);
}
function pushMsg($arrayHeader,$arrayPostData){
	$strUrl = "https://api.line.me/v2/bot/message/push";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$strUrl);
	curl_setopt($ch, CURLOPT_HEADER,false);
	curl_setopt($ch, CURLOPT_POST,true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch);
	curl_close($ch);
}
echo "Hello LINE BOT";
