<?php
session_start();
unset($_SESSION['admin']);
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
        $account->getRole() == Users::ROLE_ADMIN &&
        $account->getUserStatus() == Users::STATUS_ACTIVE){
        if (password_verify($_POST['password'], $account->getPassword())){
            $_SESSION['admin']['name_admin'] =  $account->getUsername();
            $_SESSION['admin']['admin_id'] = $account->getUserId();
            $_SESSION['admin']['is_admin'] = TRUE;
            $_SESSION['admin']['login_admin'] = TRUE;
            header('Location: /blog/view/admin/home.php');
            exit;
        }else{
            $_SESSION['admin']['error_mess'] =  'Incorrect password!';
        }
    }else if($account->getUserStatus() == Users::STATUS_INACTIVE){
        $_SESSION['admin']['error_mess'] =  'Account not active!';
    } else{
        $_SESSION['admin']['error_mess'] =  'Incorrect username!';
    }
    $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
    header('Location: ../../view/admin');
    exit;
} catch (Exception $e){
    $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
    $_SESSION['admin']['error_mess'] =  'Cannot login!';
    header('Location: ../../view/admin');
    exit;
}


