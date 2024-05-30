<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $errors = array();

            if (empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)) 
                array_push($errors,"All fields are required");
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Email is not valid");
            }
            if(strlen($password)<8){
                array_push($errors,"Password must be at leat 8 character long");
            }
            if($password!==$passwordRepeat){
                array_push($errors,"Password does not match");
            }

            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount =mysqli_num_rows($result);
            if($rowCount>0){
                array_push($errors,"Email already exists!");
            }
            if(count($errors)>0){
                foreach($errors as $error){
                    echo "<div class='alert alert-danger'>$error<>";    
                }
            }else{
                //Nhap data vao SQL
                $sql="INSERT INTO users (full_name, email, password) Value(?, ? , ?)";
                $stmt = mysqli_stmt_init($conn);
                $perpareStmt = mysqli_stmt_prepare($stmt,$sql);
                if ($perpareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$passwordHash);
                    mysqli_stmt_execute($stmt);
                    echo"<div class='alert alert-success'>You are registered successfully.</div>";

                }else{
                    die("Somthing went wrong");
                }
            }
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form=group">
                <input type="text" name="fullname" placeholder="Fullname: " id="fullname" required>

            </div>
            <div class="form=group">
                <input type="email" name="email" placeholder="Email: " id="email" required>

            </div>
            <div class="form=group">
                <input type="password" name="password" placeholder="Password: " id="password" required>

            </div>
            <div class="form=group">
                <input type="text" name="repeat_password" placeholder="Repeat Password: ">
            </div>
            <div class="form=btn">
                <button type="submit" form="form_Regiter" value="Regiter" class="button-82-pushable" role="button">
					<span class="button-82-shadow"></span>
					<span class="button-82-edge"></span>
					<span class="button-82-front text">
					  Regiter
            </div>
        </form>
    </div>
    
</body>
</html>