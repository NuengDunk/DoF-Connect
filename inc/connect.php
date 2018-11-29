<?php
$host = '127.0.0.1'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = '21092528'; 
$option = '--client_encoding=UTF8';
$connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;option=$option", $user, $pass);
if (!$connection) {
  echo "An error occurred.\n";
  exit;
}
?>