<?php
session_start();
ini_set('display_errors', '1');
// Thay đổi thông tin này thành thông tin kết nối của bạn.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'blog';
// Hãy thử và kết nối bằng thông tin trên.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// Nếu có lỗi kết nối, hãy dừng tập lệnh và hiển thị lỗi.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Bây giờ chúng ta kiểm tra xem dữ liệu từ biểu mẫu đăng nhập đã được gửi chưa, isset() sẽ kiểm tra xem dữ liệu có tồn tại hay không.

if ( !isset($_POST['username'], $_POST['password']) ) {
    // Không thể lấy được dữ liệu lẽ ra đã được gửi.
	exit('Please fill both the username and password fields!');
}
// Chuẩn bị SQL của chúng ta, việc chuẩn bị câu lệnh SQL sẽ ngăn cản việc tiêm SQL.

if ($stmt = $con->prepare('SELECT id, password FROM account WHERE nick_name = ?')) {
	// Liên kết các tham số (s = string, i = int, b = blob, v.v.), trong trường hợp của chúng tôi tên người dùng là một chuỗi nên chúng tôi sử dụng "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Lưu kết quả để chúng ta kiểm tra xem tài khoản có tồn tại trong cơ sở dữ liệu hay không.
	$stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Tài khoản đã tồn tại, bây giờ chúng ta xác minh mật khẩu.
        // Lưu ý: hãy nhớ sử dụng pass_hash trong file đăng ký của bạn để lưu trữ mật khẩu đã băm.
        if (password_verify($_POST['password'], $password)) {
            // Xác minh thành công! Người dùng đã đăng nhập!
            // Tạo session để biết người dùng đã đăng nhập, về cơ bản chúng hoạt động như cookie nhưng ghi nhớ dữ liệu trên máy chủ.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];         
            $_SESSION['id'] = $id;
            header('Location: home.php');
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }


	$stmt->close();
}

?>


