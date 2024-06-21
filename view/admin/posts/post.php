<?php
ini_set('display_errors', '1');

include_once "../../../model/database.php";
include_once "../../../model/blogs.php";
include_once "../../../model/users.php";
session_start();
use model\Database;
use model\Blogs;
use model\Users;

$author_name = '';
$author_id = '';
$error = '';
$title = '';
$content = '';
$updated_at = '';
if (isset($_GET['clear_mess'])){
    unset($_SESSION['admin']['error_message']);
    unset($_SESSION['admin']['message']);
}
$message = $_SESSION['message'] ?? '';
$_SESSION['admin']['searchable'] = false;

if (isset($_GET['id']) && isset($_SESSION['admin']['admin_id']) && isset($_SESSION['admin']['login_admin'])){
    try {
        $pdo = new Database();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $post = Blogs::getById($pdo,$_GET['id']);
        $author = Users::getById($pdo, $post->getAuthorId());
        $author_id = $author->getId();
        $author_name = $author->getFullName();
        $title = $post->getTitle();
        $content = $post->getContent();
        $updated_at = $post->getUpdatedAt();
    } catch (Exception $e) {
        $error = 'Can not get list posts: '.  $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Post - <?= $title?></title>

    <!-- Bootstrap Core CSS -->
    <link href="../../resource/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="../../resource/css/clean-blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../resource/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php include_once '../header.php'?>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading" style="text-align: center">
                    <h1><?= $title?></h1>
                    <span class="meta">Posted by <a href="list_by_author.php?author_id=<?= $author_id ?>"><?= $author_name ?></a> at <?= $updated_at ?></span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <p><?= $content ?></p>
            </div>
        </div>
    </div>
</article>

<hr>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <ul class="list-inline text-center">
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="../../resource/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../resource/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="../../resource/js/jqBootstrapValidation.js"></script>
<script src="../../resource/js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="../../resource/js/clean-blog.min.js"></script>

</body>

</html>

