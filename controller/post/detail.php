<?php

ini_set('display_errors', '1');
session_start();

include_once "../../model/database.php";
include_once "../../model/blogs.php";


use model\Database;
use model\Blogs;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pdo = new Database();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try {
            if($_POST['button'] == 'update'){
                $post = Blogs::getById($pdo,$_POST['id']);
                $post->setTitle($_POST['title'])
                    ->setContent($_POST['content'])
                    ->setStatus($_POST['status'])
                    ->setDirectoryFileCall(dirname(__DIR__, 2));
                if(isset($_POST['delete_image'])){
                    unlink(dirname(__DIR__, 2).Blogs::IMAGE_UPLOAD_PATH.$post->getImagePath());
                    $post->setImagePath(null);
                }elseif($_FILES['image_upload']['name']){
                    $post->setImage($_FILES["image_upload"]);
                }
                $post->update();
                $_SESSION['users']['message'] = 'Update post successful!';
            }elseif ($_POST['button'] == 'delete'){
                $post = Blogs::getById($pdo,$_POST['id']);
                $post->delete();
                $_SESSION['users']['message'] = 'Delete post successful!';
                if($_POST['type'] == 'admin'){
                    header('Location: /blog/view/admin/');
                }else{
                    header('Location: /blog/view/posts/list.php');
                }
                exit;
            }

        }catch (Exception $e){
            $_SESSION['users']['error_message'] = 'Can not update post cause exception: '.  $e->getMessage(). "\n";
            $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
            header('Location: /blog/view/posts/detail.php?id='.$_POST['id']);
            exit;
        }

        header('Location: /blog/view/posts/detail.php?id='.$_POST['id']);
        exit;

    }
} catch (Exception $e) {
    $_SESSION['users']['error_message'] = $e->getMessage();
    $_SESSION['users'] = array_merge($_SESSION['users'], $_POST);
    header('Location: /blog/view/posts/detail.php?id='.$_POST['id']);
    exit;
}