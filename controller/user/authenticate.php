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

    $account = new Accounts($pdo);
    $account->setUserName($_POST['username']);
    $results = $account->getByUserName();
    if (count($results) == 1){
        $account_data = $results[0];
        if (password_verify($_POST['password'], $account_data['password'])){
            $_SESSION['name'] =  $account_data['user_name'];
            $_SESSION['login'] = TRUE;
            header('Location: /blog');
            exit;
        }else{
            $_SESSION['error_mess'] =  'Incorrect password!';
        }
    }else{
        $_SESSION['error_mess'] =  'Incorrect username!';
    }
    $_SESSION= $_POST;
    header('Location: ../view/login.php');
    exit;
} catch (Exception $e){
    $_SESSION = $_POST;
    $_SESSION['error_mess'] =  'Cannot login!';
    header('Location: ../view/login.php');
    exit;
}


