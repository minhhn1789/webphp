<?php
ini_set('display_errors', '1');
session_start();
$_SESSION['admin'] = [];

include_once "../../model/database.php";
include_once "../../model/check.php";
include_once "../../model/accounts.php";
include_once "../../model/users.php";

use model\Database;
use model\Check;
use model\Users;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdo = new Database();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $check = new Check(
            $pdo,
            $_POST['full_name'],
            $_POST['email'],
            $_POST['age'],
            $_POST['username'],
            $_POST['phone_number'],
            $_POST['password'],
            $_POST['re_password']
        );
        $err = $check->checkAll()->getErrorMessage();
        if(!empty($err)){
            $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
            $_SESSION['admin']['error_message'] =  $err;
            header('Location: ../../view/admin/register.php');
            exit;
        }

        try {
            $user = Users::create(
                $pdo,
                $_POST['full_name'],
                $_POST['address'],
                $_POST['age'],
                $_POST['sex'],
                $_POST['phone_number'],
                $_POST['email'],
                $_POST['username'],
                $_POST['password'],
                Users::ROLE_ADMIN,
                Users::STATUS_INACTIVE
            );

            if(!$user->getId()) {
                throw new Exception("Cannot create account!");
            }
        }catch (Exception $e){
            $_SESSION['admin']['error_message'][] = 'Can not create new account caught exception: '.  $e->getMessage(). "\n";
            $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
            header('Location: ../../view/admin/register.php');
            exit;
        }

        $_SESSION['admin']['register'] = 'Create account successfully and wait for active by administrator.';
        header('Location: ../../view/admin/index.php');
        exit;

    }
} catch (Exception $e) {
    $_SESSION['admin']['error_message'][] = $e->getMessage();
    $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
    header('Location: ../../view/admin/register.php');
    exit;
}