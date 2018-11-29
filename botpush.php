<?php



require "vendor/autoload.php";

$access_token = 'F05gp6P3RhMJNxfEMd2q8+eT1EDydapR5e+WlMd4PtD2TrqyP7tVSJRLfMlgUCHzoCa77gdZR5Cyz8NtGpeQ1WhXuR4PMhl37MZ7CM/SceNzKp7FB9FktKc95cId1yoUvJYR02KB85texe9ZzQ3Q1gdB04t89/1O/w1cDnyilFU=';

$channelSecret = 'e616ea5c4234eec43f2c453319c9cc0c';

$pushID = 'Ud2418f311e6d6296461e4b14770984f7';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







