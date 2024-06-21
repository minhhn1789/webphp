<?php
ini_set('display_errors', '1');
session_start();
$_SESSION['users'] = [];

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
            $_SESSION['users']['error_message'] =  $err;
            $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
            header('Location: ../../view/register.php');
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
                $_POST['password']
            );

            if(!$user->getId()) {
                throw new Exception("Cannot create user!");
            }
        }catch (Exception $e){
            $_SESSION['users']['error_message'][] = 'Can not create new account caught exception: '.  $e->getMessage(). "\n";
            $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
            header('Location: ../../view/register.php');
            exit;
        }

        $_SESSION['users']['register'][] = 'Create account successful!';
        $_SESSION['users']['register'][] = $_POST['username'];
        header('Location: ../../view/login.php');
        exit;

    }
} catch (Exception $e) {
    $_SESSION['users']['error_message'][] = $e->getMessage();
    $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
    header('Location: ../../view/register.php');
    exit;
}