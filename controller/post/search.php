<?php

ini_set('display_errors', '1');
session_start();
include_once "../../model/blogs.php";
include_once "../../model/users.php";
use model\Blogs;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $_SESSION['users']['search'] = $_POST;
            $filter_array = [];
            if(!empty($_POST['author_id']) && !empty($_POST['value'])){
                $filter_array = [
                    [
                        '('.Blogs::TITLE,
                        "LIKE",
                        "'%".$_POST['value']."%'",
                        'OR'
                    ],
                    [
                        Blogs::CONTENT,
                        "LIKE",
                        "'%".$_POST['value']."%'",
                        ') AND'
                    ],
                    [
                        Blogs::TABLE.".".Blogs::STATUS,
                        "=",
                        "'".Blogs::STATUS_ACTIVE."'",
                        'AND'
                    ],
                    [
                        Blogs::AUTHOR_ID,
                        "=",
                        "'" . $_POST['author_id'] . "'",
                        null
                    ]];
                if(empty($filter_array)){
                    header('Location: /blog/view/posts/list_by_author.php?author_id='. $_POST['author_id']);
                    exit;
                }
                $_SESSION['users']['search'] = $_POST;
                $_SESSION['users']['search']['filter'] = $filter_array;
                header('Location: /blog/view/posts/list_by_author.php?search=true&author_id='. $_POST['author_id']);
            }else if(empty($_POST['author_id']) && !empty($_POST['value'])){
                $filter_array = [
                    [
                        '('.Blogs::TITLE,
                        "LIKE",
                        "'%".$_POST['value']."%'",
                        'OR'
                    ],
                    [
                        Blogs::CONTENT,
                        "LIKE",
                        "'%".$_POST['value']."%'",
                        'OR'
                    ],
                    [
                        'users.full_name',
                        "LIKE",
                        "'%".$_POST['value']."%'",
                        ') AND'
                    ],
                    [
                        Blogs::TABLE.".".Blogs::STATUS,
                        "=",
                        "'".Blogs::STATUS_ACTIVE."'",
                        null
                    ]];
                if(empty($filter_array)){
                    header('Location: /blog');
                    exit;
                }
                $_SESSION['users']['search'] = $_POST;
                $_SESSION['users']['search']['filter'] = $filter_array;
                header('Location: /blog/?search=true');
            }else if(!empty($_POST['author_id']) && empty($_POST['value'])){
                header('Location: /blog/view/posts/list_by_author.php?author_id='. $_POST['author_id']);
            }else{
                header('Location: /blog');
            }
            exit;
        }catch (Exception $e){
            $_SESSION['users']['error_message'] = 'Can not search cause exception: '.  $e->getMessage(). "\n";
            $_SESSION['users']['search'] = $_POST;
            if(empty($_POST['author_id'])){
                header('Location: /blog/view/posts/list_by_author.php?author_id='. $_POST['author_id']);
            }else{
                header('Location: /blog');
            }
            exit;
        }
    }
} catch (Exception $e) {
    $_SESSION['users']['error_message'] = 'Can not search cause exception: '.  $e->getMessage(). "\n";
    $_SESSION['users']['search'] = $_POST;
    if(empty($_POST['author_id'])){
        header('Location: /blog/view/posts/list_by_author.php?author_id='. $_POST['author_id']);
    }else{
        header('Location: /blog');
    }
    exit;
}