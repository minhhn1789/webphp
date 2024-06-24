<?php

ini_set('display_errors', '1');
session_start();

include_once "../../../model/database.php";
include_once "../../../model/blogs.php";


use model\Database;
use model\Blogs;


try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!$_POST['author_id']){
            throw new Exception("Please login before create new post!");
        }
        $image = [];
        $pdo = new Database();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {

            if($_FILES['image_upload']['name']){
                $image = $_FILES["image_upload"];
            }

            $post = Blogs::create(
                $pdo,
                $_POST['author_id'],
                $_POST['title'],
                trim($_POST['content']),
                $image,
                $_POST['status']
            );

            if($post->getId() == null) {
                throw new Exception("Cannot create post!");
            }
        }catch (Exception $e){
            $_SESSION['admin']['error_message'] = $e->getMessage(). "\n";
            $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
            header('Location: /blog/view/admin/posts/create.php');
            exit;
        }

        $_SESSION['admin']['message'] = 'Create post successful!';
        header('Location: /blog/view/admin/posts/detail.php?id='.$post->getId());
        exit;

    }
} catch (Exception $e) {
    $_SESSION['admin']['error_message'] = $e->getMessage();
    $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
    header('Location: /blog/view/admin/posts/create.php');
    exit;
}