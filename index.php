<?php
session_start();
require_once 'functions.php';
require_once 'models/tweet.php';
// questo per proteggere che nessuno faccia login o signup al di fuori della nostra finestra
if(empty($_SESSION['csrf'])){
    $bytes = random_bytes(32);
    $token = bin2hex($bytes);
    $_SESSION['csrf'] = $token;
}

require_once 'views/header.php';
require_once 'views/home.php';
require_once 'views/footer.php';