<?php
session_start();
ini_set('display_errors', '1');
if (isset($_SESSION['admin']['login_admin'])) {
    header('Location: home.php');
    exit;
}
if(isset($_GET['clear_mess'])){
    if($_GET['clear_mess']){
        unset($_SESSION['admin']);
    }
}
?>
<html lang="en">
<head><link href="../resource/css/style.css" rel="stylesheet" type="text/css">
    <title>Admin Login</title>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
<div class="popup">
    <div class="message" id="popupContent">
        <div id="myPopup"><h1>Message</h1><a href="index.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if(isset($_SESSION['admin']['register'])){
                echo "<h1>".$_SESSION['admin']['register']."</h1>";
            }
            ?>
        </div>
    </div>
    <div class="message_error" id="popupContentError">
        <div id="errorPopup"><h1>Message Error</h1><a href="index.php?clear_mess=true">x</a></div>
        <div>
            <?php
            if(isset($_SESSION['admin']['error_mess'])){
                echo "<h1>".$_SESSION['admin']['error_mess']."</h1>";
            }
            ?>
        </div>
    </div>
</div>

<div class="bg_login"></div>
<div class="login">
    <h1>Admin Login</h1>
    <form action="../../controller/admin/authenticate.php" method="post" id="form_login">
        <label for="username">
            <i class="fas fa-user"></i>
        </label>
        <?php
        if(isset($_SESSION['admin']['error_mess'])){
            echo "<input type='text' value=". $_SESSION['admin']['username'] ." name='username' placeholder='Username' id='username' required>";
        }else{
            echo "<input type='text' name='username' placeholder='Username' id='username' required>";
        }
        ?>
        <label for="password">
            <i class="fas fa-lock"></i>
        </label>
        <input type="password" value="<?= $_SESSION['admin']['password'] ?? '' ?>" name="password" placeholder="Password" id="password" required>
        <button type="submit" form="form_login" value="Login" class="button-82-pushable" role="button">
            <span class="button-82-shadow"></span>
            <span class="button-82-edge"></span>
            <span class="button-82-front text">
					  Login
					</span>
        </button>
        <div class="create_account">
            <a href="register.php">
                Create your Account
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="create_account">
            <a href="../login.php">
                Login with Users
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </form>
</div>
<script>
    const mess =  "<?= isset($_SESSION['admin']['register']) ? 1 : 0 ?>" ;
    const mess_err =  "<?= isset($_SESSION['admin']['error_mess']) ? 1 : 0 ?>" ;
    if (mess === "1"){
        const popup = document.getElementById("popupContent");
        popup.style.visibility = "visible";
    }

    if (mess_err === "1"){
        const popup = document.getElementById("popupContentError");
        popup.style.visibility = "visible";
    }
</script>
</body>
</html>

