<?php


$access_token = 'F05gp6P3RhMJNxfEMd2q8+eT1EDydapR5e+WlMd4PtD2TrqyP7tVSJRLfMlgUCHzoCa77gdZR5Cyz8NtGpeQ1WhXuR4PMhl37MZ7CM/SceNzKp7FB9FktKc95cId1yoUvJYR02KB85texe9ZzQ3Q1gdB04t89/1O/w1cDnyilFU=';

$userId = 'Ud2418f311e6d6296461e4b14770984f7';

$url = 'https://api.line.me/v2/bot/profile/'.$userId;

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

