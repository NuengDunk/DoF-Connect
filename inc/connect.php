<?php
$host = '27.254.220.7'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = 'Tobpt21092528';
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