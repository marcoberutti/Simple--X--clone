<?php

function dbConnect() {

$dsn = "mysql:host=127.0.0.1;dbname=twitter";  //localhost è uguale a 127.0.0.1
$user = "root";
$password = "marco";

$dbh = new PDO($dsn, $user, $password);
return $dbh;
}