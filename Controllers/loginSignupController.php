<?php

function logout(){
    session_destroy();
    return 1;
}
function verifyData()
{
    $result = [
        'success' => 1,
        'msg' => ''
    ];
    $token = $_POST['csrf'] ?? '';
    if(!isValidToken( $token)){
        $result['success'] = 0;
        $result['msg'] = 'Invalid request';
        return $result;
    }
    $email = $_POST['email'] ?? '';
    if ($email) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    if (!$email) {

        $result['success'] = 0;
        $result['msg'] .=  ' An email address is required<br>';
    }

    $password = $_POST['password'] ?? '';

    if (!$password || strlen($password) < 6) {
        $result['success'] = 0;
        $result['msg'] .=  ' Password is required and length greater than 6 <br>';
    }

    $result['password'] = $password;
    $result['email'] = $email;
    return $result;
}
function login()
{

    $result = verifyData();

    if ($result['success']) {
        $res =  verifyUserLogin($result['email'], $result['password']);
        if($res['success']){
            $_SESSION['userloggedin'] = 1;
            unset($_SESSION['csrf']);
            $_SESSION['email'] = $result['email'];
            $_SESSION['id'] = $res['data'] ['id'];
            
        }
        return $res;
    } else {
        return $result;
    }
}
function verifyUserLogin($email, $password)
{
    $result = [
        'success' => 1,
        'msg' => 'User loggedin correctly',
        'data' => []
    ];

    try {
        $conn = dbConnect();
     
        $sql = 'select * from users where email=:email';
        $stm = $conn->prepare($sql);
        $res = $stm->execute([':email' => $email]);
        if($res && $stm->rowCount()){
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $row;
           if(!password_verify($password, $row['password'])){
            $result['success'] = 0;
            $result['msg'] = 'Passwords mismatch';
           }
        } else {
            $result['success'] = 0;
            $result['msg'] = 'No user found with this email';
        }
    } catch(Exception $e){
        $result['success'] =0;
        $result['msg'] = $e->getMessage();
    }

    return $result;
}
function signup()
{

    $result = verifyData();

    if ($result['success']) {
        $res =  insertUser($result['email'], $result['password']);
        if($res['success']){
            $_SESSION['userloggedin'] = 1;
            $_SESSION['email'] = $result['email'];
            unset($_SESSION['csrf']);
        }
        return $res;
    } else {
        return $result;
    }
}

function insertUser($email, $password)
{
    $result = [
        'success' => 1,
        'msg' => ''
    ];
 try {
    $conn = dbConnect();
    //$sql = 'select email from users where email=?';
    $sql2 = 'select email from users where email=:email';
    $stm = $conn->prepare($sql2);
    $res = $stm->execute([':email' => $email]);
    if ($res) {
        if ($stm->rowCount() > 0) {
            $result['msg'] = ' Email has already been taken';
            $result['success'] = 0;
            return $result;
        }
    } else {
        $result['msg'] = ' Error reading users table';
        $result['success'] = 0;
        return $result;
    }
    $sql = 'INSERT INTO users (email, password) values(:email, :password) ';
    $stm = $conn->prepare($sql);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $res = $stm->execute([':email' => $email, ':password' => $password]);
    if ($res && $stm->rowCount()) {
        $result['msg'] = ' User registered correctly';
        return $result;
    } else {
        $result['msg'] = ' Problem inserting user';
        $result['success'] = 0;
    }
} catch(Exception $e){
    $result['success'] =0;
    $result['msg'] = $e->getMessage();
}
    return $result;
}
