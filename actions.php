<?php

session_start();
require_once 'functions.php';
require_once 'DB/connection.php';
require_once 'Controllers/loginSignupController.php';
require 'Controllers/tweetsController.php';
require 'models/tweet.php';
$action = $_REQUEST['action'] ?? '';

if(function_exists($action)){
    echo json_encode($action());
    exit;
}






// if ($_POST['action'] === 'deleteTweet') {
//     echo deleteTweet();
// }


