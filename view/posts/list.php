<?php
ini_set('display_errors', '1');

include_once "../../model/database.php";
include_once "../../model/blogs.php";
session_start();
use model\Database;
use model\Blogs;

$author_id = '';
$username = 'User';
$error = 'Please Login!';
$results = [];
if (isset($_GET['clear_mess'])){
    $_SESSION['error_message'] = '';
    $_SESSION['message'] = '';
}
$message = $_SESSION['message'] ?? '';


if (isset($_SESSION['user_id']) && isset($_SESSION['login'])){
    try {
        if($_SESSION['login']) {
            $author_id = $_SESSION['user_id'];
            $username = $_SESSION['name'];
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $posts = new Blogs($pdo);
            $results = $posts->filterByAttributes([[
                Blogs::AUTHOR_ID,
                "=",
                "'".$_SESSION['user_id']."'",
                null
            ]]);
        }
    } catch (Exception $e) {
        $error = 'Can not get post information: '.  $e->getMessage();
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

    <title>Clean Blog - Contact</title>

    <!-- Bootstrap Core CSS -->
    <link href="../resource/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="../resource/css/clean-blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../resource/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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

<!-- Navigation -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="../../index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['login']) && $author_id) {
                    echo "                
                            <li class='dropdown'>
                                <a class='dropbtn'> Welcome ".$username. "</a>
                                <div class='dropdown-content'>
                                    <a class='dropdown_item-1' href='../user/detail.php?id=".$author_id."'>Account</a>
                                    <a class='dropdown_item-2' href='../posts/create.php'>Create Posts</a>
                                    <a class='dropdown_item-3' href='../logout.php'>Logout</a>
                                </div>
                            </li>";
                }else{
                    echo "<li><a href='../login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Header -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="page-heading">
                    <h1>List Post</h1>
                    <hr class="small">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" style="width: 5%">ID</th>
                <th scope="col" style="width: 50%">Title</th>
                <th scope="col" style="width: 20%">Created At</th>
                <th scope="col" style="width: 20%">Updated At</th>
                <th scope="col" style="width: 5%"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!empty($results)){
                foreach ($results as $result){
                    echo "
                     <tr>
                        <th class='posts_list'>".$result['id']."</th>
                        <th class='posts_list'><a href='detail.php?id=".$result['id']."'>".$result['title']."</a></th>
                        <th class='posts_list'>".$result['created_at']."</th>
                        <th class='posts_list'>".$result['updated_at']."</th>
                        <th class='posts_list'><a href='detail.php?id=".$result['id']."'>View</a></th>
                    </tr>
                    ";
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

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
<script src="../resource/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../resource/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Theme JavaScript -->
<script src="../resource/js/clean-blog.min.js"></script>

</body>

</html>

