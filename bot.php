<?php
require('./inc/setting.php');

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
 // Loop through each event
 foreach ($events['events'] as $event) {
  // Reply only when message sent is in 'text' format
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
				
		  		
				$statement = "INSERT INTO appointment (id,userID,time,content) VALUES(NULL,:userID,:time,:content)";
				/*$statement->bindParam(':userID',$event['source']['userId']);
				$statement->bindParam(':time',$appointments[0]);
				$statement->bindParam(':time',$appointments[1]);*/
				$result = $connection->query($statement);
		  		if($result){
					$respMessage = 'ข้อความของคุณได้ถูกบันทึกไว้แล้ว';						
				}else{
					$respMessage = 'ไม่สามารถบันทึกข้อมูลได้กรุณาลองอีกครั้ง';
				}			
			}else{
				$respMessage = 'กรุณาแจ้งเหตุการณ์ด้วย format ดังนี้เช่น "12:00,เรือใหญ่จับปลาเล็ก"';
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
  }
 }
}
echo "OK";