<?php
$sql_server = '127.0.0.1';
$username = 'anis';
$password = 'nothing1297@';
$database = 'Ships Manager';

//$db = mysqli_connect($sql_server,$username,$password,$database);
$db = new mysqli($sql_server,$username,$password,$database);
if (!$db) {
    die("Connection failed: " . mysqli_connect_error($db));
}
?>