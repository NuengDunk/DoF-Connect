<?php 
require_once('./vendor/autoload.php')
//Namespace
use \LINE\LINEBot\HTTPClient\CurlhttpClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'glWWbmCy8qeIGPfdzNIz1Ydt1QUgJig5ZMS85R+5FCDSZtqUqPktppGlzEsPhowroCa77gdZR5Cyz8NtGpeQ1WhXuR4PMhl37MZ7CM/ScePTBISg3tahx5e9Xe8NZHsqVftG7FOyiwS6juZz4xPVtQdB04t89/1O/w1cDnyilFU=
';
$channel_secret = 'e616ea5c4234eec43f2c453319c9cc0c';

//Get content from LINE API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if(!is_null($events['events'])){
	//Loop through each event
	foreach($events['events'|as $event]){
		//Line API Send a lot of event type
		if ($event['type'] == 'message') {
			
			// Get replyToken 
			$replyToken = $event['replyToken'];
			
			switch($event['message']['type']) {
				case 'text':
					
					// Reply message 
					$respMessage = 'Hello, your message is '. $event['message']['text']; 
					
				break;
				case 'image':
					$messageID = $event['message']['id']; 
					$respMessage = 'Hello, your image ID is '. $messageID;
					
				break;
				
					
			}
			$httpClient = new CurlHTTPClient($channel_token); 
			$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret)); 
			$textMessageBuilder = new TextMessageBuilder($respMessage); 
			$response = $bot->replyMessage($replyToken, $textMessageBuilder);
		}
	}
}
//Insert to DB
$params = array( 
	'type' => $event['type'],
	'userID' => $event['source']['userId'] , 
	'time' => $event['timestamp"'], 
	'message_id' => $event['message']['id'],
	'message_type' => $event['message']['type'],
	'message_text' => $event['message']['text'], 
	'replytoken' => $event['replyToken']
); 
$statement = $connection->prepare('INSERT INTO chatlogs (type, userID, time, message_id, message_type, message_text, replytoken) VALUES (:type, :userID, :time, :message_id, :message_type, :message_text, :repltoken)'); 
$statement->execute($params);

