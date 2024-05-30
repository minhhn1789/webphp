<?php
	// Chúng tôi cần sử dụng phiên, vì vậy bạn phải luôn bắt đầu phiên bằng mã bên dưới.
	session_start();
	// Nếu người dùng chưa đăng nhập sẽ chuyển hướng đến trang đăng nhập...
	if (isset($_SESSION['loggedin'])) {
		header('Location: home.php');
		exit;
	}
?>
<html>
	<head><link href="style.css" rel="stylesheet" type="text/css"></head>
		<meta charset="utf-8">
		<title>Register</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="bg_register"></div>
		<div class="register">
			<h1>Register</h1>
			<form action="authenticate.php" method="post" id="form_register">
				<label for="fullname">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="fullname" placeholder="Fullname" id="fullname" required>
                <label for="sex">
					<i class="fas fa-venus-mars"></i>
				</label>
				<select id="sex">
					<option value="">--Please choose an option--</option>
					<option value="male">Male</option>
					<option value="female">Female</option>
				</select>
                <label for="age">
					<i class="fas fa-calendar"></i>
				</label>
				<input type="number" name="age" placeholder="Age" id="age" required>
                <label for="phone_number">
					<i class="fas fa-mobile"></i>
				</label>
				<input type="number" name="phone_number" placeholder="Phone Number" id="phone_number" required>
                <label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="text" name="email" placeholder="Email" id="email" required>

                <label for="address">
					<i class="fas fa-location-arrow"></i>
				</label>
				<input type="text" name="address" placeholder="Address" id="address" required>

                <label for="nick_name">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="nick_name" placeholder="Username" id="nick_name" required>

                <label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>

                <label for="re_password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="re_password" placeholder="Re-Enter the password" id="re_password" required>

				
                <button type="submit" form="form_register" value="register" class="button-82-pushable" role="button">
					<span class="button-82-shadow"></span>
					<span class="button-82-edge"></span>
					<span class="button-82-front text">
					  Register
					</span>
				  </button>
			</form>
		</div>
	</body>
</html>

