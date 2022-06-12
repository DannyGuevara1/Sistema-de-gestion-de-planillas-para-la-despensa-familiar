<?php
define('DB_HOST','sql110.epizy.com');
define('DB_USER','epiz_31941384');
define('DB_PASS','tnzw01Mx1FAKZx5');
define('DB_NAME','epiz_31941384_sistemasplanillas');
// Ahora, establecemos la conexión.
try
{
// Ejecutamos las variables y aplicamos UTF8
$connect = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,
array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>