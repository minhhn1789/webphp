<?php
session_start();
ini_set('display_errors', '1');
if(isset($_GET['clear_mess'])){
    if($_GET['clear_mess']){
        unset($_SESSION['users']);
    }
}
?>
<html lang="en">
	<head><link href="resource/css/style.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <div class="popup">
            <div class="message" id="popupContent">
                <div id="myPopup"><h1>Message</h1><a href="login.php?clear_mess=true">x</a></div>
                <div>
                        <?php
                        if(isset($_SESSION['users']['register'])){
                            echo "<h1>".$_SESSION['users']['register'][0]."</h1>";
                        }
                        ?>
                </div>
            </div>
            <div class="message_error" id="popupContentError">
                <div id="errorPopup"><h1>Message Error</h1><a href="login.php?clear_mess=true">x</a></div>
                <div>
                    <?php
                    if(isset($_SESSION['users']['error_mess'])){
                        echo "<h1>".$_SESSION['users']['error_mess']."</h1>";
                    }
                    ?>
                </div>
            </div>
        </div>

		<div class="bg_login"></div>
		<div class="login">
			<h1>Login</h1>
			<form action="../controller/user/authenticate.php" method="post" id="form_login">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
                <?php
                    if(isset($_SESSION['users']['error_mess'])){
                        echo "<input type='text' value=". $_SESSION['users']['username'] ." name='username' placeholder='Username' id='username' required>";
                    }else if(isset($_SESSION['users']['register'][1])){
                        echo "<input type='text' value=". $_SESSION['users']['register'][1] ." name='username' placeholder='Username' id='username' required>";
                    }else{
                        echo "<input type='text' name='username' placeholder='Username' id='username' required>";
                    }
                ?>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" value="<?= $_SESSION['users']['password'] ?? '' ?>" name="password" placeholder="Password" id="password" required>
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
                    <a href="/blog/view/admin">
                        Login with Admin
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
			</form>
		</div>
        <script>
            const mess =  "<?= isset($_SESSION['users']['register']) ? 1 : 0 ?>" ;
            const mess_err =  "<?= isset($_SESSION['users']['error_mess']) ? 1 : 0 ?>" ;
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

