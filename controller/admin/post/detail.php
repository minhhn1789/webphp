<?php

ini_set('display_errors', '1');
session_start();

include_once "../../../model/database.php";
include_once "../../../model/blogs.php";


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
                $_SESSION['admin']['message'] = 'Update post successful!';
            }elseif ($_POST['button'] == 'delete'){
                $post = Blogs::getById($pdo,$_POST['id']);
                $post->delete();
                $_SESSION['admin']['message'] = 'Delete post successful!';
                header('Location: /blog/view/admin/');
                exit;
            }

        }catch (Exception $e){
            $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
            $_SESSION['admin']['error_message'] = 'Can not update post cause exception: '.  $e->getMessage(). "\n";
            header('Location: /blog/view/admin/posts/detail.php?id='.$_POST['id']);
            exit;
        }

        header('Location: /blog/view/admin/posts/detail.php?id='.$_POST['id']);
        exit;

    }
} catch (Exception $e) {
    $_SESSION['admin'] = array_merge($_SESSION['admin'], $_POST);
    $_SESSION['admin']['error_message'] = $e->getMessage();
    header('Location: ../../view/admin/posts/detail.php?id='.$_POST['id']);
    exit;
}