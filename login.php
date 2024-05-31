<?php include "header.php" ;
ini_set('display_errors', '1');
?>
<html>
	<head><link href="style.css" rel="stylesheet" type="text/css"></head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <div class="popup">
            <div class="message" id="popupContent">
                <div id="myPopup"><h1>Message</h1><a onclick="close_popup()">x</a></div>
                <div>
                        <?php
                        if(isset($_SESSION['register'])){
                            echo "<h1>".$_SESSION['register'][0]."</h1>";
                        }
                        ?>
                </div>
            </div>
        </div>
		<div class="bg_login"></div>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post" id="form_login">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" value="<?= $_SESSION['register'][1] ?? '' ?>" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<button type="submit" form="form_login" value="Login" class="button-82-pushable" role="button">
					<span class="button-82-shadow"></span>
					<span class="button-82-edge"></span>
					<span class="button-82-front text">
					  Login
					</span>
                </button>
                <div class="create_account">
                    <a href="./register.php">
                        Create your Account
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
			</form>
		</div>
        <script>
            const mess =  "<?= isset($_SESSION['register']) ? 1 : 0 ?>" ;
            if (mess === "1"){
                const popup = document.getElementById("popupContent");
                popup.style.visibility = "visible";
            }

            function close_popup(){
                const popup = document.getElementById("popupContent");
                popup.style.visibility = "hidden";
            }
        </script>
	</body>
</html>

