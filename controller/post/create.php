<?php

ini_set('display_errors', '1');
session_start();

include_once "../../model/database.php";
include_once "../../model/blogs.php";


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
                $_POST['content'],
                $image,
                $_POST['status']
            );

            if(!$post->getId()) {
                throw new Exception("Cannot create post!");
            }
        }catch (Exception $e){
            $_SESSION = array_merge($_SESSION, $_POST);
            $_SESSION['error_message'][] = 'Can not create new post caught exception: '.  $e->getMessage(). "\n";
            header('Location: ../../view/posts/create.php');
            exit;
        }

        $_SESSION['message'][] = 'Create post successful!';
        header('Location: ../../view/posts/detail.php?id='.$post->getId());
        exit;

    }
} catch (Exception $e) {
    $_SESSION = array_merge($_SESSION, $_POST);
    $_SESSION['error_message'] = $e->getMessage();
    header('Location: ../../view/posts/create.php');
    exit;
}