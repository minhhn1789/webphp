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
            if($_POST['type'] == 'posts'){
                $postIds = explode(',',$_POST['post_id']);
                if($_POST['post_id']){
                    $combine = (!empty($_POST['title']) || !empty($_POST['author']) || !empty($_POST['status'])) ? 'OR' : null;
                    if(count($postIds) > 1){
                        $filter_array[] = [
                            Blogs::TABLE.'.'.Blogs::ID,
                            "IN",
                            "(".$_POST['post_id'].")",
                            $combine
                        ];
                    }else{
                        $filter_array[] = [
                            Blogs::TABLE.'.'.Blogs::ID,
                            "=",
                            $_POST['post_id'],
                            $combine
                        ];
                    }
                }
                if($_POST['title']){
                    $combine = (!empty($_POST['author']) || !empty($_POST['status'])) ? 'OR' : null;
                    $filter_array[] = [
                        Blogs::TITLE,
                        "LIKE",
                        "'%".$_POST['title']."%'",
                        $combine
                    ];
                }
                if($_POST['author']){
                    $combine = (!empty($_POST['status'])) ? 'OR' : null;
                    $filter_array[] = [
                        'users.full_name',
                        "LIKE",
                        "'%".$_POST['author']."%'",
                        $combine
                    ];
                }
                if($_POST['status']){
                    $filter_array[] = [
                        Blogs::TABLE.'.'.Blogs::STATUS,
                        "LIKE",
                        "'".$_POST['status']."'",
                        null
                    ];
                }
                if(empty($filter_array)){
                    $_SESSION['admin']['error_message'] = 'Please enter value for filter!';
                    header('Location: /blog/view/admin/home.php');
                    exit;
                }
                $_SESSION['admin']['filter']['posts'] = $filter_array;
                $_SESSION['admin']['filter_value']['posts'] = $_POST;
                unset($_SESSION['admin']['error_message']);
                header('Location: /blog/view/admin/home.php?filter=true');

            }else{
                $postIds = explode(',', $_POST['user_id']);
                if ($_POST['user_id']) {
                    $combine = (!empty($_POST['name']) || !empty($_POST['username']) || !empty($_POST['status'])) ? 'OR' : 'AND';
                    if (count($postIds) > 1) {
                        $filter_array[] = [
                            Users::TABLE . '.' . Users::ID,
                            "IN",
                            "(" . $_POST['user_id'] . ")",
                            $combine
                        ];
                    } else {
                        $filter_array[] = [
                            Users::TABLE . '.' . Users::ID,
                            "=",
                            $_POST['user_id'],
                            $combine
                        ];
                    }
                }
                if ($_POST['name']) {
                    $combine = (!empty($_POST['username']) || !empty($_POST['status'])) ? 'OR' : 'AND';
                    $filter_array[] = [
                        Users::FULL_NAME,
                        "LIKE",
                        "'%" . $_POST['name'] . "%'",
                        $combine
                    ];
                }
                if ($_POST['username']) {
                    $combine = (!empty($_POST['status'])) ? 'OR' : 'AND';
                    $filter_array[] = [
                        Accounts::USERNAME,
                        "LIKE",
                        "'%" . $_POST['username'] . "%'",
                        $combine
                    ];
                }
                if ($_POST['status']) {
                    $filter_array[] = [
                        Users::TABLE . '.' . Users::STATUS,
                        "LIKE",
                        "'" . $_POST['status'] . "'",
                        'AND'
                    ];
                }
            }
            if($_POST['type'] == 'users'){
                if(empty($filter_array)){
                    $_SESSION['admin']['error_message'] = 'Please enter value for filter!';
                    header('Location: /blog/view/admin/list_users.php');
                    exit;
                }
                $filter_array[] = [
                    Users::ROLE,
                    "=",
                    "'".Users::ROLE_USER."'",
                    null
                ];
                $_SESSION['admin']['filter']['users'] = $filter_array;
                $_SESSION['admin']['filter_value']['users'] = $_POST;
                unset($_SESSION['admin']['error_message']);
                header('Location: /blog/view/admin/list_users.php?filter=true');
            }else if($_POST['type'] == 'admin') {
                if(empty($filter_array)){
                    $_SESSION['admin']['error_message'] = 'Please enter value for filter!';
                    header('Location: /blog/view/admin/list_admin.php');
                    exit;
                }
                $filter_array[] = [
                    Users::ROLE,
                    "=",
                    "'".Users::ROLE_ADMIN."'",
                    null
                ];
                $_SESSION['admin']['filter']['admin'] = $filter_array;
                $_SESSION['admin']['filter_value']['admin'] = $_POST;
                unset($_SESSION['admin']['error_message']);
                header('Location: /blog/view/admin/list_admin.php?filter=true');
            }
            exit;

        }catch (Exception $e){
            $_SESSION['admin']['error_message'] = 'Can not filter cause exception: '.  $e->getMessage(). "\n";
            if($_POST['type'] == 'posts'){
                $_SESSION['admin']['filter_value']['posts'] = $_POST;
                header('Location: /blog/view/admin/home.php?filter=true');
            }else if($_POST['type'] == 'users'){
                $_SESSION['admin']['filter_value']['users'] = $_POST;
                header('Location: /blog/view/admin/list_users.php?filter=true');
            }else if($_POST['type'] == 'admin'){
                $_SESSION['admin']['filter_value']['admin'] = $_POST;
                header('Location: /blog/view/admin/list_admin.php?filter=true');
            }
            exit;
        }
    }
} catch (Exception $e) {
    $_SESSION['admin']['error_message'] = $e->getMessage();
    if($_POST['type'] == 'posts'){
        $_SESSION['admin']['filter_value']['posts'] = $_POST;
        header('Location: /blog/view/admin/home.php?filter=true');
    }else if($_POST['type'] == 'users'){
        $_SESSION['admin']['filter_value']['users'] = $_POST;
        header('Location: /blog/view/admin/list_users.php?filter=true');
    }else if($_POST['type'] == 'admin'){
        $_SESSION['admin']['filter_value']['admin'] = $_POST;
        header('Location: /blog/view/admin/list_admin.php?filter=true');
    }
    exit;
}