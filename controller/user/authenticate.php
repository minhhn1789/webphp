<?php
session_start();
$_SESSION = [];
ini_set('display_errors', '1');

include "../../model/database.php";
include "../../model/accounts.php";

use model\Database;
use model\Accounts;

try{
    $pdo = new Database();
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $account = Accounts::getByUserName(
        $pdo,
        $_POST['username']
    );
    if ($account->getUserId()){
        if (password_verify($_POST['password'], $account->getPassword())){
            $_SESSION['name'] =  $account->getUsername();
            $_SESSION['user_id'] = $account->getUserId();
            $_SESSION['login'] = TRUE;
            header('Location: /blog');
            exit;
        }else{
            $_SESSION['error_mess'] =  'Incorrect password!';
        }
    }else{
        $_SESSION['error_mess'] =  'Incorrect username!';
    }
    $_SESSION = array_merge($_SESSION, $_POST);
    header('Location: ../../view/login.php');
    exit;
} catch (Exception $e){
    $_SESSION = $_POST;
    $_SESSION['error_mess'] =  'Cannot login!';
    header('Location: ../../view/login.php');
    exit;
}


