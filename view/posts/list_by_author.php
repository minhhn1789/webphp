<?php
ini_set('display_errors', '1');

include_once "../../model/database.php";
include_once "../../model/blogs.php";
include_once "../../model/users.php";
session_start();
use model\Database;
use model\Blogs;
use model\Users;

$author_name = '';
$user_id = '';
$username = 'User';
$error = $_SESSION['users']['error_message'] ?? '';
$_SESSION['users']['searchable'] = true;

$results = [];
$default_number_posts = 5;
$total_page = 1;

$page = $_GET['page'] ?? 1;
$start = ($page - 1) * $default_number_posts;
$end = $page * $default_number_posts;

if (isset($_GET['clear_mess'])){
    unset($_SESSION['users']['error_message']);
}

if(!isset($_GET['search'])){
    unset($_SESSION['users']['search']);
}

if (isset($_GET['author_id'])){
    try {
            $user_id = $_SESSION['users']['user_id'] ?? '';
            $username = $_SESSION['users']['name'] ?? '';
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $author = Users::getById($pdo, $_GET['author_id']);
            $author_name = $author->getFullName();
            $posts = new Blogs($pdo);
            if(isset($_GET['search']) && !empty($_SESSION['users']['search']['filter'])){
                $results = $posts->filterByAttributes($_SESSION['users']['search']['filter']);
            }else {
                $results = $posts->filterByAttributes([[
                    Blogs::AUTHOR_ID,
                    "=",
                    "'" . $_GET['author_id'] . "'",
                    null
                ]]);
            }
            $total_page = count($results) ? floor(count($results) / $default_number_posts) : $total_page;
            $total_page = (count($results) % $default_number_posts) == 0 ? $total_page : $total_page + 1;
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

    <title>Posts by <?= $author_name ?></title>

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

<?php include_once '../header.php'?>

<div class="popup">
    <div class="popuptext" id="popupContent">
        <div id="myPopup"><h1>Error message</h1><a href="index.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if($error){
                echo "<p>".$error."</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- Page Header -->
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="page-heading">
                    <h1>List Posts By</h1>
                    <hr class="small">
                    <h1><?= $author_name ?></h1>
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
                            <a href='post.php?id=" . $result['id'] . "'>
                                <h2 class='post-title'>
                                    " . $result['title'] . "
                                </h2>
                                <h3 class='post-subtitle'>
                                    " . $shortDes . "
                                </h3>
                            </a>
                            <p class='post-meta'>Posted by <a href='#'>" . $result['full_name'] . "</a> at " . $result['updated_at'] . "</p>
                                </div>
                        <hr>
                    ";
                    }
                }
            }else{
                echo "
                        <div class='post-preview' style='text-align: center'>
                            <h3>No result</h3>
                        </div>";
            }
            ?>

            <!-- Pager -->
            <ul class="pager">
                <?php
                if(isset($_GET['search'])){
                    if($page > 1){
                        echo '<li class="next previous"><a href="list_by_author.php?search=true&author_id=' . $_GET['author_id'] . '&page=' . ($page - 1) . '">&larr; Newer Posts</a></li>';
                    }
                    echo '<li>'.$page.'/'.$total_page.'</li>';
                    if ($total_page > $page){
                        echo '<li class="next"><a href="list_by_author.php?search=true&author_id=' . $_GET['author_id'] . '&page=' . ($page + 1) . '">Older Posts &rarr;</a> </li>';
                    }
                }else{
                    if($page > 1){
                        echo '<li class="next previous"><a href="list_by_author.php?author_id=' . $_GET['author_id'] . '&page=' . ($page - 1) . '">&larr; Newer Posts</a></li>';
                    }
                    echo '<li>'.$page.'/'.$total_page.'</li>';
                    if ($total_page > $page){
                        echo '<li class="next"><a href="list_by_author.php?author_id=' . $_GET['author_id'] . '&page=' . ($page + 1) . '">Older Posts &rarr;</a> </li>';
                    }
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

<script>
    const error =  "<?= !empty($error) ? 1 : 0 ?>" ;
    if (error === "1"){
        const popup = document.getElementById("popupContent");
        popup.style.visibility = "visible";
    }
</script>

<!-- jQuery -->
<script src="../resource/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../resource/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Contact Form JavaScript -->
<script src="../resource/js/jqBootstrapValidation.js"></script>
<script src="../resource/js/contact_me.js"></script>

<!-- Theme JavaScript -->
<script src="../resource/js/clean-blog.min.js"></script>

</body>

</html>


