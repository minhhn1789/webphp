<?php
include_once "../../model/database.php";
include_once "../../model/users.php";
session_start();
use model\Database;
use model\Users;

if (isset($_GET['clear_mess'])){
    unset($_SESSION['users']['error_message']);
    unset($_SESSION['users']['message']);
}

$id = '';
$full_name = '';
$gender = '';
$age = '';
$phone_number = '';
$email = '';
$address = '';
$username = '';
$error = $_SESSION['users']['error_message'] ?? 'Please Login!';
$_SESSION['users']['searchable'] = false;

$message = $_SESSION['users']['message'] ?? '';


if (isset($_GET['id']) && isset($_SESSION['users']['login'])){
    try {
        if($_SESSION['users']['login']) {
            $pdo = new Database();
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user = USERS::getById($pdo, $_GET['id']);
            $id = $user->getId();
            $full_name = $user->getFullName();
            $gender = $user->getSex();
            $age = $user->getAge();
            $phone_number = $user->getPhoneNumber();
            $email = $user->getEmail();
            $address = $user->getAddress();
            $username = $user->getUsername();
        }
    } catch (Exception $e) {
        $error = 'Can not get user information: '.  $e->getMessage();
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

    <title>User Information</title>

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
        <div id="myPopup"><h1>Error message</h1><a href="detail.php?id=<?= $id ?>&clear_mess=true">x</a></div>
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
        <div id="myPopupSuccess"><h1>Message</h1><a href="detail.php?id=<?= $id ?>&clear_mess=true">x</a></div>
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
                    <h1>Account Detail</h1>
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
            <form action="../../controller/user/detail.php" method="post" id="update_user">
                <input type="hidden" value="<?= $id ?>" id="user_id" name="user_id">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-with-value controls">
                        <label for="full_name">Full Name</label>
                        <input value="<?= $full_name ?>" type="text" class="form-control" placeholder="Full Name" id="full_name" name="full_name" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="sex">Gender</label>
                        <select name="sex" id="sex" class="form-control" required>
                            <option value="">--Please choose an option--</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="age">Age</label>
                        <input value="<?= $age ?>" type="number" class="form-control" placeholder="Age" id="age" name="age" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="phone_number">Phone Number</label>
                        <input value="<?= $phone_number ?>" type="number" class="form-control" placeholder="Phone Number" id="phone_number" name="phone_number" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="email">Email</label>
                        <input value="<?= $email ?>" type="text" class="form-control" placeholder="Email" id="email" name="email" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="address">Address</label>
                        <input value="<?= $address ?>" type="text" class="form-control" placeholder="Address" id="address" name="address" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="username">Username</label>
                        <input value="<?= $username ?>" type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" placeholder="Current Password" id="current_password" name="current_password">
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" placeholder="New Password" id="new_password" name="new_password">
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group-value controls">
                        <label for="re_password">Re-Enter New Password</label>
                        <input type="password" class="form-control" placeholder="Re-Enter New Password" id="re_password" name="re_password">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-xs-12">
                        <button id="save_form_button" type="submit" class="btn btn-default" form="update_user" value="update" role="button" <?= $id ? '' : 'disabled' ?> >Save</button>
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
    const temp = value = "<?= $gender ?? '' ?>" ;
    const mySelect = document.getElementById('sex');
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
