<?php
ini_set('display_errors', '1');

include_once "../../model/database.php";
include_once "../../model/blogs.php";
session_start();
use model\Database;
use model\Blogs;

$author_id = '';
$username = 'User';
$status = '';
$title = '';
$content = '';
$image = '';
$error = 'Please Login!';
$id = '';
$_SESSION['users']['searchable'] = false;

if (isset($_GET['clear_mess'])){
    unset($_SESSION['users']['error_message']);
    unset($_SESSION['users']['message']);
}
$message = $_SESSION['users']['message'] ?? '';


if (isset($_GET['id']) && isset($_SESSION['users']['user_id']) && isset($_SESSION['users']['login'])){
    try {
        if($_SESSION['users']['login']) {
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $post = Blogs::getById($pdo, $_GET['id']);
            $username = $_SESSION['users']['name'];
            $error = $_SESSION['users']['error_message'] ?? '';
            if($_SESSION['users']['user_id'] == $post->getAuthorId()){
                $id = $post->getId();
                $author_id = $post->getAuthorId();
                $title = $post->getTitle();
                $content = $post->getContent();
                $image = $post->getImagePath();
                $status = $post->getStatus();
            }else{
                $error = 'Can not get post with user id: '.$_SESSION['users']['user_id'];
            }
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

    <title>Post - <?= $title ?></title>

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


<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<div class="popup">
    <div class="popuptext" id="popupContent">
        <div id="myPopup"><h1>Error message</h1><a href="create.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if(is_array($error)){
                foreach ($error as $err) {
                    echo "<li>".$err."</li>";
                }
            }else{
                echo "<p>".$error."</p>";
            }
            ?>
        </div>
    </div>
</div>

<div class="popup">
    <div class="popuptextSuccess" id="popupContentSuccess">
        <div id="myPopupSuccess"><h1>Message</h1><a href="create.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if(isset($_SESSION['users']['message'])){
                echo "<p>".$_SESSION['users']['message']."</p>";
            }
            ?>
        </div>
    </div>
</div>
<header class="intro-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="page-heading">
                    <h1>Post Detail</h1>
                    <hr class="small">
                    <h2><?= $title ?></h2>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <form action="../../controller/post/detail.php" method="post" id="create_post" enctype="multipart/form-data">
                <input type="hidden" value="<?= $id ?>" id="id" name="id">
                <input type="hidden" value="<?= $author_id ?>" id="author_id" name="author_id">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-with-value controls">
                        <label for="title">Title</label>
                        <input value="<?= $title ?>" type="text" class="form-control" placeholder="Title" id="title" name="title" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required><?= htmlspecialchars($content); ?>
                        </textarea>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <div class="preview">
                            <img id="img_preview" src="../..//uploads/<?= $image ?>" alt=""/>
                            <label for="image_upload">Upload Image</label>
                            <input accept="image/*" type="file" id="image_upload" name="image_upload"/>
                        </div>
                        <div>
                            <br>
                            <input type="checkbox" id="delete_image" name="delete_image" value="delete_image">
                            <label for="delete_image">Delete image</label><br>
                        </div>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">--Please choose an option--</option>
                            <option value="<?= Blogs::STATUS_ACTIVE ?>">Publish</option>
                            <option value="<?= Blogs::STATUS_INACTIVE ?>">Hidden</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button id="save_form_button" type="submit" class="btn btn-default" form="create_post" value="update" role="button" name="button">Save</button>
                        <button id="delete_form_button" type="submit" class="btn btn-default" form="create_post" value="delete" role="button" name="button">Delete</button>
                    </div>
                </div>
            </form>
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
    const input = document.getElementById('image_upload');
    const image = document.getElementById('img_preview');

    input.addEventListener('change', (e) => {
        if (e.target.files.length) {
            image.src = URL.createObjectURL(e.target.files[0]);
        }
    });
    const temp = value = "<?= $status ?? '' ?>" ;
    const mySelect = document.getElementById('status');
    if (temp !== null){
        for (let i in mySelect) {
            if (mySelect[i].value === temp) {
                mySelect.selectedIndex = i;
                break;
            }
        }
    }

    const error =  "<?php
        if(is_array($error)) {
            echo !empty($error) ? 1 : 0;
        }else{
            echo $error ? 1 : 0;
        }
        ?>" ;

    const mess =  "<?= $message ? 1 : 0 ?>" ;
    if (mess === "1"){
        const popup = document.getElementById("popupContentSuccess");
        popup.style.visibility = "visible";
    }
    if (error === "1"){
        const popup = document.getElementById("popupContent");
        popup.style.visibility = "visible";
    }

    const login = <?= isset($_SESSION['users']['login']) ? 1 : 0?>;
    if(login === 0) {
        const saveButton = document.getElementById("save_form_button");
        saveButton.disabled = true;
        const deleteButton = document.getElementById("delete_form_button");
        deleteButton.disabled = true;
    }
</script>

</body>

</html>
