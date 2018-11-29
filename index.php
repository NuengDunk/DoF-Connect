<?php 
require('vendor/autoload.php'); 
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
require('inc/connect.php');
require('inc/setting.php');

// Namespace 
use \LINE\LINEBot\HTTPClient\CurlHTTPClient; 
use \LINE\LINEBot; 
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder; 

// Get message from Line API 
$content = file_get_contents('php://input'); 
$events = json_decode($content, true); 
if (!is_null($events['events'])) { 
	// Loop through each event 
	foreach ($events['events'] as $event) 
	{ 
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
echo "Hello LINE BOT";
