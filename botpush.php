<?php



require "vendor/autoload.php";

$access_token = 'lDKBIJ7XzO3irl7hhbt/11Lca3AMyDVIoKZmUV3i2KhiqtAJXvgsmcZx1qgpWBN5oCa77gdZR5Cyz8NtGpeQ1WhXuR4PMhl37MZ7CM/SceNP8fkfTXBYFgxiSbKeiDvTX4UoT1gAM4nx955vzB/DVwdB04t89/1O/w1cDnyilFU=';

$channelSecret = 'e616ea5c4234eec43f2c453319c9cc0c';

$pushID = 'Ud2418f311e6d6296461e4b14770984f7';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







