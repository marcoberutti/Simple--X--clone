<?php
    require_once 'models/tweet.php';
    $res = findAllTweets(getUserId());

    // Verifica se 'data' esiste
    if(isset($res['data']) && $res['data']) : 
        require 'Controllers/tweetsController.php';
        foreach($res['data'] as $value) :
            echo getTweetTpl($value);
        endforeach;
    endif;