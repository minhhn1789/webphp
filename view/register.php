<?php
session_start();
ini_set('display_errors', '1');
if(isset($_GET['clear_mess'])){
    if($_GET['clear_mess']){
        unset($_SESSION['users']['error_message']);
    }
}
?>
<html lang="en">
	<head>
        <link href="resource/css/style.css" rel="stylesheet" type="text/css">
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <div class="popup">
            <div class="popuptext" id="popupContent">
                 <div id="myPopup"><h1>Error message</h1><a href="register.php?clear_mess=true">x</a></div>
                 <div>
                     <ol>
                         <?php
                         if(isset($_SESSION['users']['error_message'])){
                             foreach ($_SESSION['users']['error_message'] as $err) {
                                 echo "<li>".$err."</li>";
                             }
                         }
                         ?>
                     </ol>
                 </div>
            </div>
        </div>
		<div class="bg_register"></div>
		<div class="register">
			<h1>Register</h1>
			<form action="../controller/user/create.php" method="post" id="form_register">
				<label for="full_name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" value="<?= $_SESSION['users']['full_name'] ?? '' ?>" name="full_name" placeholder="Full Name" id="full_name" required>
                <label for="sex">
					<i class="fas fa-venus-mars"></i>
				</label>
				<select name="sex" id="sex">
					<option value="">--Please choose an option--</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
                <label for="age">
					<i class="fas fa-calendar"></i>
				</label>
				<input type="number" value="<?= $_SESSION['users']['age'] ?? '' ?>" name="age" placeholder="Age" id="age" required>
                <label for="phone_number">
					<i class="fas fa-mobile"></i>
				</label>
				<input type="number" value="<?= $_SESSION['users']['phone_number'] ?? '' ?>" name="phone_number" placeholder="Phone Number" id="phone_number" required>
                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" value="<?= $_SESSION['users']['email'] ?? '' ?>" name="email" placeholder="Email" id="email" required>

                <label for="address">
					<i class="fas fa-location-arrow"></i>
				</label>
				<input type="text" name="address" value="<?= $_SESSION['users']['address'] ?? '' ?>" placeholder="Address" id="address" required>

                <label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" value="<?= $_SESSION['users']['username'] ?? '' ?>" placeholder="Username" id="username" required>

                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" value="<?= $_SESSION['users']['password'] ?? '' ?>" placeholder="Password" id="password" required>

                <label for="re_password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="re_password" value="<?= $_SESSION['users']['re_password'] ?? '' ?>" placeholder="Re-Enter the password" id="re_password" required>


                <button type="submit" form="form_register" value="register" class="button-82-pushable" role="button">
					<span class="button-82-shadow"></span>
					<span class="button-82-edge"></span>
					<span class="button-82-front text">
					  Register
					</span>
				  </button>

                <div class="login_back">
                    <a href="login.php?clear_mess=true">
                        Back to Login
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
			</form>
		</div>
        <script>
            const temp = value = "<?= $_SESSION['users']['sex'] ?? '' ?>" ;
            const mySelect = document.getElementById('sex');
            if (temp !== null){
                for (let i in mySelect) {
                    if (mySelect[i].value === temp) {
                        mySelect.selectedIndex = i;
                        break;
                    }
                }
            }

            const error =  "<?= isset($_SESSION['users']['error_message']) ? 1 : 0 ?>" ;
            if (error === "1"){
                const popup = document.getElementById("popupContent");
                popup.style.visibility = "visible";
            }

            function close_error(){
                const popup = document.getElementById("popupContent");
                popup.style.visibility = "hidden";
            }
        </script>
	</body>
</html>

