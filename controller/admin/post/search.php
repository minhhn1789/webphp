<?php

ini_set('display_errors', '1');
session_start();
include_once "../../../model/blogs.php";
include_once "../../../model/users.php";
use model\Blogs;

try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $_SESSION['admin']['search'] = $_POST;
            $filter_array = [];
            if(!empty($_POST['value'])){
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
                        Blogs::AUTHOR_ID,
                        "=",
                        "'" . $_POST['author_id'] . "'",
                        null
                    ]];
            }
            if(empty($filter_array)){
                header('Location: /blog/view/admin/posts/list_by_author.php?author_id='. $_POST['author_id']);
                exit;
            }
            $_SESSION['admin']['search'] = $_POST;
            $_SESSION['admin']['search']['filter'] = $filter_array;
            header('Location: /blog/view/admin/posts/list_by_author.php?search=true&author_id='. $_POST['author_id']);
            exit;

        }catch (Exception $e){
            $_SESSION['admin']['error_message'] = 'Can not search cause exception: '.  $e->getMessage(). "\n";
            $_SESSION['admin']['search'] = $_POST;
            header('Location: /blog/view/admin/posts/list_by_author.php?author_id='. $_POST['author_id']);
            exit;
        }
    }
} catch (Exception $e) {
    $_SESSION['admin']['error_message'] = 'Can not search cause exception: '.  $e->getMessage(). "\n";
    $_SESSION['admin']['search'] = $_POST;
    header('Location: /blog/view/admin/posts/list_by_author.php?author_id='. $_POST['author_id']);
    exit;
}