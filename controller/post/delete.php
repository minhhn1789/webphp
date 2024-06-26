<?php

session_start();

include_once "../../model/database.php";
include_once "../../model/blogs.php";

use model\Database;
use model\Blogs;

if (isset($_GET['id']) && isset($_SESSION['users']['user_id']) && isset($_SESSION['users']['login'])){
    $message = '';
    try {
        if($_SESSION['users']['login']) {
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $post = Blogs::getById($pdo, $_GET['id']);
            if($_SESSION['users']['user_id'] == $post->getAuthorId()){
                $post->delete();
                $message = 'Delete successfully!';
            }else{
                $message = 'Can not delete post id: '.$_GET['id'];
            }
        }
    } catch (Exception $e) {
        $message = 'Can not delete post cause: '.  $e->getMessage();
    }

    $_SESSION['users']['message'] = $message;
    header('Location: /blog/view/posts/list.php');
    exit;
}