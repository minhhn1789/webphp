<?php
ini_set('display_errors', '1');

include_once "../../../model/blogs.php";
session_start();
use model\Blogs;

if (isset($_GET['clear_mess'])){
    unset($_SESSION['admin']['error_message']);
    unset($_SESSION['admin']['message']);
}

$author_id = '';
$status = '';
$title = '';
$content = '';
$error = $_SESSION['admin']['error_message'] ?? '';
$_SESSION['admin']['searchable'] = false;

$message = $_SESSION['admin']['message'] ?? '';


if (isset($_SESSION['admin']['admin_id']) && isset($_SESSION['admin']['login_admin'])){
    try {
        if($_SESSION['admin']['login_admin']) {
            $author_id = $_SESSION['admin']['admin_id'];
            $title = $_SESSION['admin']['title'] ?? '';
            $content = $_SESSION['admin']['content'] ?? '';
            $status = $_SESSION['admin']['status'] ?? '';
            $error = $_SESSION['admin']['error_message'] ?? '';
        }
    } catch (Exception $e) {
        $error = 'Something wrong when load: '.  $e->getMessage();
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

    <title>Create Post</title>

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
            if(isset($_SESSION['message'])){
                echo "<p>".$_SESSION['message']."</p>";
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
                    <h1>Create New Post</h1>
                    <hr class="small">
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <form action="/blog/controller/admin/post/create.php" method="post" id="create_post" enctype="multipart/form-data">
                <input type="hidden" value="<?= $author_id ?>" id="author_id" name="author_id">
                <input type="hidden" value="admin" id="type" name="type">
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
                            <img id="img_preview" src="" alt=""/>
                            <label for="image_upload">Upload Image</label>
                            <input accept="image/*" type="file" id="image_upload" name="image_upload" />
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
                        <button id="save_form_button" type="submit" class="btn btn-default" form="create_post" value="update" role="button">Save</button>
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
<script src="../../resource/vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../../resource/vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Theme JavaScript -->
<script src="../../resource/js/clean-blog.min.js"></script>

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
</script>

</body>

</html>
