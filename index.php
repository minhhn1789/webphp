<?php
session_start();
include_once "model/database.php";
include_once "model/blogs.php";
session_start();
use model\Database;
use model\Blogs;
$results = [];
$default_number_posts = 5;
$total_page = 1;
try {
    $page = $_GET['page'] ?? 1;
    $start = ($page - 1) * $default_number_posts;
    $end = $page * $default_number_posts;

    $pdo = new Database();
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $posts = new Blogs($pdo);
    $results = $posts->filterByAttributes([[
        Blogs::TABLE.".".Blogs::STATUS,
        "=",
        "'".Blogs::STATUS_ACTIVE."'",
        null
    ]]);
    $total_page = floor(count($results) / $default_number_posts);
    $total_page = (count($results) % $default_number_posts) == 0 ? $total_page : $total_page + 1;
} catch (Exception $e) {
    $error = 'Can not get post information: '.  $e->getMessage();
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

    <title>Blog</title>

    <!-- Bootstrap Core CSS -->
    <link href="view/resource/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="view/resource/css/clean-blog.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="view/resource/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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

<?php include_once 'view/header.php'?>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="site-heading">
                    <h1>Blog</h1>
                    <hr class="small">
                    <span class="subheading">The trick in life is learning how to solve it</span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <?php
            if(!empty($results)){
                foreach ($results as $key => $result){
                    if($key > $end){
                        break;
                    }
                    if( $start <= $key && $key < $end) {
                        if (strlen($result['content']) > 50) {
                            $shortDes = substr($result['content'], 0, 50) . "...";
                        } else {
                            $shortDes = $result['content'];
                        }
                        echo "
                        <div class='post-preview'>
                            <a href='view/posts/post.php?id=" . $result['id'] . "'>
                                <h2 class='post-title'>
                                    " . $result['title'] . "
                                </h2>
                                <h3 class='post-subtitle'>
                                    " . $shortDes . "
                                </h3>
                            </a>
                            <p class='post-meta'>Posted by <a href='view/posts/list_by_author.php?author_id=" . $result['author_id'] . "'>" . $result['full_name'] . "</a> at " . $result['updated_at'] . "</p>
                                </div>
                        <hr> ";
                    }
                }
            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <?php
                if($page > 1){
                    echo '<li class="next previous"><a href="/blog/?page=' . ($page - 1) . '">&larr; Newer Posts</a></li>';
                }
                if ($total_page > $page){
                    echo '<li class="next"><a href="/blog/?page=' . ($page + 1) . '">Older Posts &rarr;</a> </li>';
                }
                ?>
            </ul>
        </div>
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
                <p class="copyright text-muted">Copyright &copy; Your Website 2016</p>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="view/resource/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="view/resource/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="view/resource/js/jqBootstrapValidation.js"></script>
<script src="view/resource/js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="view/resource/js/clean-blog.min.js"></script>

</body>

</html>
