<?php
ini_set('display_errors', '1');
session_start();

include_once "../../model/database.php";
include_once "../../model/check.php";
include_once "../../model/users.php";

use model\Database;
use model\Check;
use model\Users;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['user_id'])) {
            $self_update = $_POST['user_id'] == $_SESSION['admin']['admin_id'];
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                $user = USERS::getById($pdo, $_POST['user_id']);
                $check = new Check(
                    $pdo,
                    $_POST['full_name'],
                    $_POST['email'],
                    $_POST['age'],
                    $_POST['username'],
                    $_POST['phone_number'],
                    $_POST['new_password'],
                    $_POST['re_password']
                );
                if ($self_update){
                    if(!$_POST['current_password']){
                        $_SESSION['admin']['error_message'] =  'Please enter password before save!';
                    }else if (password_verify($_POST['current_password'], $user->getPassword())){
                        if($user->getUsername() != $_POST['username']){
                            $check->checkUserName();
                        }
                        if($user->getEmail() != $_POST['email']){
                            $check->checkEmail();
                        }
                        if($_POST['new_password'] && $_POST['re_password']){
                            $check->checkPassword();
                        }
                        $err = $check->checkAge()->checkName()->checkPhoneNumber()->getErrorMessage();
                        if (!empty($err)) {
                            $_SESSION['admin']['error_message'] = $err;
                            header('Location: ../../view/admin/detail.php?id='.$_POST['user_id']);
                            exit;
                        }
                        $user->setFullName($_POST['full_name'])
                            ->setSex($_POST['sex'])
                            ->setAge($_POST['age'])
                            ->setPhoneNumber($_POST['phone_number'])
                            ->setEmail($_POST['email'])
                            ->setAddress($_POST['address'])
                            ->setUsername($_POST['username'])
                            ->setStatus($_POST['status'])
                            ->setPassword($_POST['new_password']);
                        $user->update();
                        $_SESSION['admin']['message'] =  'Update successful!';
                    }else{
                        $_SESSION['admin']['error_message'] =  'Incorrect password!';
                    }
                }else{
                    $current_admin = USERS::getById($pdo, $_SESSION['admin']['admin_id']);
                    if($current_admin->getRole() == Users::ROLE_ADMIN){
                        if(!$_POST['your_password']){
                            $_SESSION['admin']['error_message'] =  'Please enter password before save!';
                        }else if(password_verify($_POST['your_password'], $current_admin->getPassword())){
                            if($user->getEmail() != $_POST['email']){
                                $check->checkEmail();
                            }
                            $err = $check->checkAge()->checkName()->checkPhoneNumber()->getErrorMessage();
                            if (!empty($err)) {
                                $_SESSION['admin']['error_message'] = $err;
                                header('Location: ../../view/admin/detail.php?id='.$_POST['user_id']);
                                exit;
                            }
                            $user->setFullName($_POST['full_name'])
                                ->setSex($_POST['sex'])
                                ->setAge($_POST['age'])
                                ->setPhoneNumber($_POST['phone_number'])
                                ->setEmail($_POST['email'])
                                ->setAddress($_POST['address'])
                                ->setStatus($_POST['status'])
                                ->setPassword(null);
                            $user->update();
                            $_SESSION['admin']['message'] =  'Update successful!';
                        }else{
                            $_SESSION['admin']['error_message'] =  'Incorrect password!';
                        }
                    }else{
                        $_SESSION['admin']['error_message'] =  'Permission denied!';
                    }
                }
            } catch (Exception $e) {
                $_SESSION['admin']['error_message'][] = 'Can not update user information caught exception: ' . $e->getMessage() . "\n";
            }
            header('Location: ../../view/admin/detail.php?id='.$_POST['user_id']);
            exit;
        }

    }
} catch (Exception $e) {
    $_SESSION['admin']['error_message'] = $e->getMessage();
    header('Location: ../../view/admin/detail.php?id='.$_POST['user_id']);
    exit;
}