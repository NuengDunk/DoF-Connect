<?php
$host = '127.0.0.1'; 
$dbname = 'dof_connect'; 
$user = 'nuengdunk'; 
$pass = '21092528'; 
//$connection = new PDO("pgsql:host=$host;dbname=$dbname, $user, $pass");
$connection = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$pass");
if (!$connection) {
  echo "An error occurred.\n";
  exit;
}
?>