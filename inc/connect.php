<?php
$host = '127.0.0.1'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = '21092528'; 
$port = '5432';
$option = '--client_encoding=UTF8';
//$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass option=$option");
$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
if (!$connection) {
  echo "An error occurred.\n";
  exit;
}
?>