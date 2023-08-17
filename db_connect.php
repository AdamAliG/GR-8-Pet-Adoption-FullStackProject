<?php
$host = '127.0.0.1';
$user = 'root'; 
$pass = '';
$db = 'gr 8 - pet adoption - fullstackproject';


$connection = new mysqli($host, $user,$pass , $db);


if ($connection->connect_error) {
    die("No Connection" . $connection->connect_error);
}