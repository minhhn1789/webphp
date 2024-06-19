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
$default_number_posts = 5;
$total_page = 1;

$page = $_GET['page'] ?? 1;
$start = ($page - 1) * $default_number_posts;
$end = $page * $default_number_posts;

if (isset($_GET['clear_mess'])){
    unset($_SESSION['user']['message']);
}


if (isset($_SESSION['user']['user_id']) && isset($_SESSION['user']['login'])){
    try {
        if($_SESSION['user']['login']) {
            $author_id = $_SESSION['user']['user_id'];
            $username = $_SESSION['user']['name'];
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $posts = new Blogs($pdo);
            $results = $posts->filterByAttributes([[
                Blogs::AUTHOR_ID,
                "=",
                "'".$_SESSION['user']['user_id']."'",
                null
            ]]);
            $total_page = floor(count($results) / $default_number_posts);
            $total_page = (count($results) % $default_number_posts) == 0 ? $total_page : $total_page + 1;
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

    <title>List Posts</title>

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
    <div class="popuptextSuccess" id="popupContentSuccess">
        <div id="myPopupSuccess"><h1>Message</h1><a href="list.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if(isset($_SESSION['user']['message'])){
                echo "<p>".$_SESSION['user']['message']."</p>";
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
                <th scope="col" style="width: 35%">Title</th>
                <th scope="col" style="width: 20%">Created At</th>
                <th scope="col" style="width: 20%">Updated At</th>
                <th scope="col" style="width: 20%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(!empty($results)){
                foreach ($results as $key => $result){
                    if($key > $end){
                        break;
                    }
                    if( $start <= $key && $key < $end) {
                        echo "
                         <tr>
                            <th class='posts_list'>" . $result['id'] . "</th>
                            <th class='posts_list'><a href='detail.php?id=" . $result['id'] . "'>" . $result['title'] . "</a></th>
                            <th class='posts_list'>" . $result['created_at'] . "</th>
                            <th class='posts_list'>" . $result['updated_at'] . "</th>
                            <th class='posts_list'>
                            <span>
                            <a href='post.php?id=" . $result['id'] . "'>View</a> | 
                            <a href='detail.php?id=" . $result['id'] . "'>Edit</a> | 
                            <a href='../../controller/post/delete.php?id=" . $result['id'] . "'>Delete</a>
                            </span>
                            </th>
                        </tr>
                        ";
                    }
                }
            }
            ?>
            </tbody>
        </table>
        <ul class="pager">
            <?php
            if($page > 1){
                echo '<li class="next previous"><a href="list.php?page=' . ($page - 1) . '">&larr; Previous</a></li>';
            }
            echo '<li>'.$page.'/'.$total_page.'</li>';
            if ($total_page > $page){
                echo '<li class="next"><a href="list.php?page=' . ($page + 1) . '">Next &rarr;</a> </li>';
            }
            ?>
        </ul>
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

<script>
    const mess =  "<?= isset($_SESSION['user']['message']) ? 1 : 0 ?>" ;
    if (mess === "1"){
        const popup = document.getElementById("popupContentSuccess");
        popup.style.visibility = "visible";
    }
</script>

</body>

</html>

