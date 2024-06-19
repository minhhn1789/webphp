<?php

session_start();

include_once "../../model/database.php";
include_once "../../model/users.php";

use model\Database;
use model\Users;

if (isset($_GET['id']) && isset($_SESSION['admin']['admin_id']) && isset($_SESSION['admin']['login_admin'])){
    $message = '';
    $delete_type = $_GET['type'];
    try {
        if($_SESSION['admin']['admin_id'] == $_GET['id']){
            $message = 'You cannot delete your account!';
        } else if($_SESSION['admin']['login_admin'] && $_SESSION['admin']['is_admin']) {
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $users = Users::getById($pdo, $_GET['id']);
            $current_admin = Users::getById($pdo, $_SESSION['admin']['admin_id']);
            if($current_admin->getRole() == Users::ROLE_ADMIN){
                $users->delete();
                $message = 'Delete successfully!';
            }else{
                $message = 'Can not delete user id: '.$_GET['id'];
            }
        }
    } catch (Exception $e) {
        $message = 'Can not delete user cause: '.  $e->getMessage();
    }

    $_SESSION['admin'][$delete_type]['message'] = $message;
    header('Location: ../../view/admin/list_'.$delete_type.'.php');
    exit;
}