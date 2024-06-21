<?php

ini_set('display_errors', '1');
session_start();
include_once "../../model/blogs.php";
include_once "../../model/users.php";
include_once "../../model/accounts.php";
use model\Blogs;
use model\Users;
use model\Accounts;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $filter_array = [];
            $postIds = explode(',',$_POST['post_id']);
            if($_POST['post_id']){
                $combine = !empty($_POST['title']) ? 'OR' : ') AND';
                if(count($postIds) > 1){
                    $filter_array[] = [
                        '(' . Blogs::TABLE.'.'.Blogs::ID,
                        "IN",
                        "(".$_POST['post_id'].")",
                        $combine
                    ];
                }else{
                    $filter_array[] = [
                        '(' . Blogs::TABLE.'.'.Blogs::ID,
                        "=",
                        $_POST['post_id'],
                        $combine
                    ];
                }
            }
            if($_POST['title']){
                $filter_array[] = [
                    (!empty($_POST['post_id'])) ? Blogs::TITLE : '(' . Blogs::TITLE,
                    "LIKE",
                    "'%".$_POST['title']."%'",
                    ') AND'
                ];
            }
            if($_POST['status']){
                $filter_array[] = [
                    Blogs::TABLE.'.'.Blogs::STATUS,
                    "=",
                    "'".$_POST['status']."'",
                    'AND'
                ];
            }
            $filter_array[] = [
                Blogs::AUTHOR_ID,
                "=",
                "'".$_POST['author_id']."'",
                null
            ];
            if(empty($filter_array)){
                $_SESSION['users']['error_message'] = 'Please enter value for filter!';
                header('Location: /blog/view/posts/list.php');
                exit;
            }
            $_SESSION['users']['filter'] = $_POST;
            $_SESSION['users']['filter']['filter_array'] = $filter_array;
            unset($_SESSION['users']['error_message']);
            header('Location: /blog/view/posts/list.php?filter=true');
            exit;

        }catch (Exception $e){
            $_SESSION['users']['error_message'] = 'Can not filter cause exception: '.  $e->getMessage(). "\n";
            $_SESSION['users']['filter'] = $_POST;
            header('Location: /blog/view/posts/list.php?filter=true');
            exit;
        }
    }
} catch (Exception $e) {
    $_SESSION['users']['error_message'] = $e->getMessage();
    $_SESSION['users']['filter'] = $_POST;
    header('Location: /blog/view/posts/list.php?filter=true');
    exit;
}