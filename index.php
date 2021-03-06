<?php
//require_once('./vendor/autoload.php');
require('./inc/setting.php');

//Namespace เพื่อเวลาเรียกใช้งานคลาส คำสั่งจะได้สั้นลง
/*use \LINE\LINEBot\HTTPclient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;*/

//Get message from Line API
$content = file_get_contents('php://input');
$evetns = json_decode($content, true);

if(!is_null($events['events'])){
	
	// Loop through each event 
	foreach ($events['events'] as $event) { 
		// Line API send a lot of event type, we interested in message only. 
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') { 
			
			// Get text sent
   			$text = $event['message']['text'];
			
			// Get replyToken 
			$replyToken = $event['replyToken'];
			
			//Split message then keep it in database
			$appointments = explode(',',$event['message']['text']);
			
			if(count($appointments)==2){
				require_once('./inc/connect.php');
				$params = array(
					'uerID' => $event['source']['userId'],
					'time' => $appointments[0],
					'content' => $appointments[1],
				);
				
				$statement = $connection->prepare("INSERT INTO appointment (id,userID,time,content) VALUES(NULL,:userID,:time,:content)");
				/*$statement->bindParam(':userID',$event['source']['userId']);
				$statement->bindParam(':time',$appointments[0]);
				$statement->bindParam(':time',$appointments[1]);*/
				$result = $statement->excute($statement);
				
				$respMessage = 'Your appointment has saved';			
			}else{
				$respMessage = 'You can send appointment like this "12:00, Run always"';
			}
			
			// Build message to reply back
		   	$messages = [
			'type' => 'text',
			'text' => $respMessage
		   ];

		   // Make a POST Request to Messaging API to reply to sender
		   $url = 'https://api.line.me/v2/bot/message/reply';
		   $data = [
			'replyToken' => $replyToken,
			'messages' => [$messages],
		   ];
		   $post = json_encode($data);
		   $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $channel_token);

		   $ch = curl_init($url);
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		   $result = curl_exec($ch);
		   curl_close($ch);

		   echo $result . "\r\n";
			/*
			$httpClient = newCurlHTTPClient($channel_token);
			$bot = newLineBot($httpClient,array('chanelSecret' => $channel_secret));
			
			$textMessageBuilder = newTextMessageBuilder($respMessage);
			$response = $bot -> replyMessage($replyToken, $textMessageBuilder);*/
		}
	}	
}

echo "Ok";