<?php
ini_set('display_errors', '1');
session_start();
$_SESSION = [];

include "../../model/database.php";
include "../../model/check.php";
include "../../model/accounts.php";
include "../../model/users.php";

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
            $_SESSION = $_POST;
            $_SESSION['error_message'] =  $err;
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
            $_SESSION = $_POST;
            $_SESSION['error_message'][] = 'Can not create new account caught exception: '.  $e->getMessage(). "\n";
            header('Location: ../../view/register.php');
            exit;
        }

        $_SESSION['register'][] = 'Create account successful!';
        $_SESSION['register'][] = $_POST['username'];
        header('Location: ../../view/login.php');
        exit;

    }
} catch (Exception $e) {
    $_SESSION = $_POST;
    $_SESSION['error_message'] = $e;
    header('Location: ../../view/register.php');
    exit;
}