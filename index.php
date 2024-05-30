<!-- Biểu mẫu đăng nhập được tạo bằng HTML5 và CSS3. Chúng tôi không cần sử dụng PHP trong tệp này. Do đó, chúng ta có thể lưu nó dưới dạng HTML đơn giản. -->
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
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
		<div class="bg_login"></div>
		<div class="login">
			<h1>Login</h1>
			<form action="authenticate.php" method="post" id="form_login">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
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
				<!-- <input type="submit" value="Login"> -->
			</form>
		</div>
	</body>
</html>

