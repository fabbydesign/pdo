<?php
require_once('db.php');
$conn = array(
    "host" => 'localhost',
    "db_name" => 'test',
    "user" => 'root',
    "password" => 'password',
);
$PDO = new db($conn);
$sql = "select * from class where idunu='0'";
$data = $PDO->fetch($sql);
echo "<pre>";
var_dump($data);
echo "</pre>";
?>
