<?php
$host = '127.0.0.1'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = '21092528'; 
$connection = new PDO("pgsql:host=$host;dbname=$dbname", $user, $pass);
if (!$connection) {
  echo "An error occurred.\n";
  exit;
}
?>