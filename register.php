<?php include "header.php";
ini_set('display_errors', '1');
?>
<html>
	<head><link href="style.css" rel="stylesheet" type="text/css"></head>
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
        <div class="popup">
            <div class="popuptext" id="popupContent">
                 <div id="myPopup"><h1>Error message</h1><a onclick="close_error()">x</a></div>
                 <div>
                     <ol>
                         <?php
                         if(isset($_SESSION['error_message'])){
                             foreach ($_SESSION['error_message'] as $err) {
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
			<form action="create_user.php" method="post" id="form_register">
				<label for="fullname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" value="<?= $_SESSION['fullname'] ?? '' ?>" name="fullname" placeholder="Fullname" id="fullname" required>
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
				<input type="number" value="<?= $_SESSION['age'] ?? '' ?>" name="age" placeholder="Age" id="age" required>
                <label for="phone_number">
					<i class="fas fa-mobile"></i>
				</label>
				<input type="number" value="<?= $_SESSION['phone_number'] ?? '' ?>" name="phone_number" placeholder="Phone Number" id="phone_number" required>
                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" value="<?= $_SESSION['email'] ?? '' ?>" name="email" placeholder="Email" id="email" required>

                <label for="address">
					<i class="fas fa-location-arrow"></i>
				</label>
				<input type="text" name="address" value="<?= $_SESSION['address'] ?? '' ?>" placeholder="Address" id="address" required>

                <label for="nick_name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="nick_name" value="<?= $_SESSION['nick_name'] ?? '' ?>" placeholder="Username" id="nick_name" required>

                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" value="<?= $_SESSION['password'] ?? '' ?>" placeholder="Password" id="password" required>

                <label for="re_password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="re_password" value="<?= $_SESSION['re_password'] ?? '' ?>" placeholder="Re-Enter the password" id="re_password" required>


                <button type="submit" form="form_register" value="register" class="button-82-pushable" role="button">
					<span class="button-82-shadow"></span>
					<span class="button-82-edge"></span>
					<span class="button-82-front text">
					  Register
					</span>
				  </button>
			</form>
		</div>
        <script>
            const temp = value = "<?= $_SESSION['sex'] ?? '' ?>" ;
            const mySelect = document.getElementById('sex');
            if (temp !== null){
                for (let i in mySelect) {
                    if (mySelect[i].value === temp) {
                        mySelect.selectedIndex = i;
                        break;
                    }
                }
            }

            const error =  "<?= isset($_SESSION['error_message']) ? 1 : 0 ?>" ;
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

