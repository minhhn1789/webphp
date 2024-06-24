<?php

session_start();

include_once "../../model/database.php";
include_once "../../model/users.php";

use model\Database;
use model\Users;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['admin']['admin_id']) && isset($_SESSION['admin']['login_admin'])){
    $message = '';
    $delete_type = $_POST['type'];
    unset($_SESSION['admin']['error_message']);
    unset($_SESSION['admin'][$delete_type]['message']);
    $pdo = new Database();
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $current_admin = USERS::getById($pdo, $_SESSION['admin']['admin_id']);
        if($current_admin->getRole() == Users::ROLE_ADMIN) {
            if (!$_POST['password']) {
                $_SESSION['admin']['error_message'] = 'Please enter password before delete!';
            } else if (password_verify($_POST['password'], $current_admin->getPassword())) {
                if ($_SESSION['admin']['admin_id'] == $_POST['id_delete']) {
                    $_SESSION['admin']['error_message'] = 'You cannot delete your account!';
                } else if ($_SESSION['admin']['login_admin'] && $_SESSION['admin']['is_admin']) {
                    $users = Users::getById($pdo, $_POST['id_delete']);
                    $users->delete();
                    $_SESSION['admin'][$delete_type]['message'] = 'Delete successfully!';
                }
            }else{
                $_SESSION['admin']['error_message'] = 'Incorrect Password!';
            }
        }else {
            $_SESSION['admin']['error_message'] = 'Permission denied!';
        }
    } catch (Exception $e) {
        $_SESSION['admin']['error_message'] = 'Can not delete user cause: '.  $e->getMessage();
    }

    header('Location: ../../view/admin/list_'.$delete_type.'.php');
    exit;
}