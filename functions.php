<?php
function isValidToken($token)
{
    return $token === $_SESSION['csrf'];
}

$strTimeAgo = '';
if (!empty($_POST['date-field'])) {
    $strTimeAgo = timeago($_POST['date-field']);
}
function timeago($date = '')
{
    $timestamp = strtotime($date);

    $strTime = ['second', 'minute', 'hour', 'day', 'month', 'year'];
    $length = ['60', '60', '24', '30', '12', '10'];
    $diff = 0;


    $diff = time() - $timestamp;
    if ($diff < 0) {
        return ' Just now';
    }
    for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
        $diff = $diff / $length[$i];
    }

    $diff = round($diff);


    return $diff . ' ' . $strTime[$i] . '(s) ago ';
}

function isUserLoggedIn()
{
    return  $_SESSION['userloggedin']  ?? 0;
}
function getUserEmail()
{
    return  $_SESSION['email']  ?? '';
}
function getUserId()
{
    return  $_SESSION['id']  ?? 0;
}

function getTweetHtml($tweet)
{
    $htmlTweet =  '<div class="card">
    <div class="card-body">
        <h5 class="card-title">' . getUserEmail() . '</h5>
        <h6 class="card-subtitle mb-2 text-muted">' . date('Y-m-d H:i:s') . '</h6>
        <p class="card-text">' . htmlentities(strip_tags($tweet)) . '</p>
    </div>
</div>';

    return $htmlTweet;
}
function getTweetTpl(array $tweet)
{
    $buttonLabel = $tweet['following'] ? 'Unfollow' : 'Follow';
    $btnClass = $tweet['following'] ? 'success' : 'primary';
    $htmlTweet =  '<div class="card">
    <div class="card-body">
        <h5 class="card-title">' . $tweet['email'] . '</h5>
        <h6 class="card-subtitle mb-2 text-muted">' . timeago($tweet['datetime']) . '</h6>
        <p class="card-text">' . htmlentities(strip_tags($tweet['tweet'])) . '</p>';

    if (isUserLoggedIn() && $tweet['user_id'] != getUserId()) {
        $htmlTweet .= '<a href="#" data-user="' . $tweet['user_id'];
        $htmlTweet .= '" data-following="' . $tweet['following'];
        $htmlTweet .= '" class="btn btn-' . $btnClass . '">' . $buttonLabel . '</a>';
    }
    $htmlTweet .= '</div></div>';
    return $htmlTweet;
}
