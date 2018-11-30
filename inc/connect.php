<?php
/*
$host = '27.254.220.7'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = 'Tobpt21092528';*/
$host = 'ec2-54-243-150-10.compute-1.amazonaws.com';
$dbname = 'd7u6khk8sokcak';
$user = 'idiwrkfrvcfnjp';
$pass = '35274bd0032f592a8ba7acfd4cef0bd3fdd2b230ae3c460dc457b32aed25eca5';
$port = '5432';
$option = '--client_encoding=UTF8';
//$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass options=$option");
//$connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
$connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
if (!$connection) {
  echo "An error occurred.\n";
  exit;
}
?>