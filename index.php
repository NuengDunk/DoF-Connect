<?php 
require('inc/setting.php');
require('inc/connect.php');

$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);

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

if (!is_null($events['events'])) { 
	// Loop through each event 
	foreach ($events['events'] as $event) { 
		// Line API send a lot of event type, we interested in message only. 
		if ($event['type'] == 'message') { 
			switch($event['message']['type']) { 
			case 'text': 
				// Get replyToken 
				$replyToken = $event['replyToken']; 
				// Reply message 
				$respMessage = 'Hello, your message is '. $event['message']['text']; 
				$httpClient = new CurlHTTPClient($channel_token); 
				$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
				$textMessageBuilder = new TextMessageBuilder($respMessage); 
				$response = $bot->replyMessage($replyToken, $textMessageBuilder); 
			break; 
			} 
		} 
	} 
}

//insert message from Line API to DB
$params = array( 
	'userId' => $event['source']['userId'], 
	'time' => $event['timestamp'],
	'type' => $event['type'], 
	'msgId' => $event['message']['id'],
	'msgType' => $event['message']['type'],
	'msgText' => $event['message']['text'],
	'replyToken' => $event['replyToken']
); 
$SQL = "INSERT INTO chatlogs (userId, time, type, msgId, msgType, msgText, replyToken) 
	VALUES ($params[0],$params[1],$params[2],$params[3],$params[4],$params[5],$params[6])";
$QUERY = pg_query($SQL);
/*
$statement = $connection->prepare(
	'INSERT INTO chatlogs (userId, time, type, msgId, msgType, msgText, replyToken) 
	VALUES 
	(:userId, :time, :type, :msgId, :msgType, :msgText, :replyToken)'); 
$statement->execute($params);*/
error_log($message);

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
