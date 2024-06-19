<?php

session_start();

include_once "../../../model/database.php";
include_once "../../../model/blogs.php";

use model\Database;
use model\Blogs;

if (isset($_GET['id']) && isset($_SESSION['admin']['admin_id']) && isset($_SESSION['admin']['login_admin'])){
    $message = '';
    try {
        if($_SESSION['admin']['login_admin']) {
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $post = Blogs::getById($pdo, $_GET['id']);
            $post->delete();
            $message = 'Delete successfully!';
        }
    } catch (Exception $e) {
        $message = 'Can not delete post cause: '.  $e->getMessage();
    }

    $_SESSION['admin']['message'] = $message;
    header('Location: /blog/view/admin/');
    exit;
}