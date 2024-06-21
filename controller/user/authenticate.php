<?php
session_start();
$_SESSION['users'] = [];
ini_set('display_errors', '1');

include_once "../../model/database.php";
include_once "../../model/accounts.php";
include_once "../../model/users.php";

use model\Database;
use model\Accounts;
use model\Users;

try{
    $pdo = new Database();
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $account = Accounts::getByUserName(
        $pdo,
        $_POST['username']
    );
    if ($account->getUserId() &&
        $account->getRole() == Users::ROLE_USER &&
        $account->getUserStatus() == Users::STATUS_ACTIVE){
        if (password_verify($_POST['password'], $account->getPassword())){
            $_SESSION['users']['name'] =  $account->getUsername();
            $_SESSION['users']['user_id'] = $account->getUserId();
            $_SESSION['users']['login'] = TRUE;
            header('Location: /blog');
            exit;
        }else{
            $_SESSION['users']['error_mess'] =  'Incorrect password!';
        }
    }else if($account->getUserStatus() == Users::STATUS_INACTIVE){
        $_SESSION['users']['error_mess'] =  'Account not active!';
    } else{
        $_SESSION['users']['error_mess'] =  'Incorrect username!';
    }
    $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
    header('Location: ../../view/login.php');
    exit;
} catch (Exception $e){
    $_SESSION['users']['error_mess'] =  'Cannot login cause:' . $e->getMessage();
    $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
    header('Location: ../../view/login.php');
    exit;
}


