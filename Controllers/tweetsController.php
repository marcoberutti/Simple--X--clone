<?php

function toggleFollow() {
    $result = [
        'success' => 0,
        'msg' => 'Invalid data',
    ];

    if (!isValidToken($_POST['csrf'] ?? '')) {
        $result['msg'] = 'Invalid token';
        return $result;
    }

    if (!($_POST['userId'] ?? '')) {
        $result['msg'] = 'Invalid user ID';
        return $result;
    }

    $following = $_POST['following'] ?? 0;

    try {
        $conn = dbConnect();
        $sql = 'REPLACE INTO followers (follower, followed, following) VALUES (?, ?, ?)';
        $stm = $conn->prepare($sql);
        $res = $stm->execute([getUserId(), $_POST['userId'], (int)!$following]);

        if ($res) {
            $result['success'] = 1;
            $result['msg'] = $following ? 'User is not followed anymore' : 'User followed';
            $result['following'] = $following ? 0 : 1;
        }

    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
    }

    return $result;
}

function postTweet() {
    $result = [
        'success' => 0,
        'msg' => 'Invalid data',
        'tweet' => ''
    ];

    if (!isValidToken($_POST['csrf'] ?? '')) {
        $result['msg'] = 'Invalid token';
        return $result;
    }

    if (!($_POST['tweetpost'] ?? '')) {
        $result['msg'] = 'Invalid tweet';
        return $result;
    }

    try {
        $conn = dbConnect();
        $sql = 'INSERT INTO tweets (user_id, tweet, datetime) VALUES (?, ?, NOW())';
        $stm = $conn->prepare($sql);
        $res = $stm->execute([getUserId(), strip_tags($_POST['tweetpost'])]);

        if ($res) {
            $result['success'] = 1;
            $result['msg'] = 'Tweet posted';
            $result['tweet'] = getTweetHtml($_POST['tweetpost']);
        } else {
            $result['msg'] = 'Tweet not posted';
        }

    } catch (Exception $e) {
        $result['msg'] = $e->getMessage();
    }

    return $result;
}

function filterTweets() {
    $result = [
        'success' => 1,
        'msg' => '',
        'tweets' => '',
    ];

    try {
        $filter = $_GET['filter'] ?? null;
        $tweets = findAllTweets(getUserId(), $filter);

        if ($tweets['data']) {
            foreach ($tweets['data'] as $tweet) {
                $result['tweets'] .= getTweetTpl($tweet);
            }
        }
        
    } catch (Exception $e) {
        $result['success'] = 0;
        $result['msg'] = $e->getMessage();
    }

    return $result;
}
