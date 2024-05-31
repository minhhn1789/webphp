<?php
ini_set('display_errors', '1');
session_start();
include "database.php";
$conn = connect_db();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $err = [];
    if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["fullname"])) {
        $err[] = "FullName: The full name only letters and white space allowed.";
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $err[] = "Email: Invalid email format.";
    }

    if (!preg_match("/^[0-9]{10,14}$/",$_POST["phone_number"])) {
        $err[] = "Phone Number: The phone number only contain number with length between 10 to 14 number.";
    }

    if ($_POST["age"] < 0 || $_POST["age"] > 150) {
        $err[] = "Age: Invalid age of user.";
    }

    if (!preg_match("/^[A-Za-z][A-Za-z0-9]{3,20}$/",$_POST["nick_name"])) {
        $err[] = "Username: Please enter correct format username with length from 4 to 20 character without special character.";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/",$_POST["password"])) {
        $err[] = "Password: Invalid format password. \n
        At least one lowercase letter. \n
        At least one uppercase letter. \n
        At least one digit. \n
        Minimum length of 8 characters.";
    }elseif($_POST["password"] != $_POST["re_password"]){
        $err[] = "Please re-enter correct password.";
    }

    try {

//    Check email exist
        $email = $_POST["email"];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            $err[] = "Email: Email already exists!";
        }

//    Check nick_name exist

        $nick_name = $_POST["nick_name"];
        $sql = "SELECT * FROM account WHERE nick_name = '$nick_name'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            $err[] = "Username: Username already exists!";
        }
    }catch (Exception $e) {
        $err[] = 'Can not check data caught exception: '.  $e->getMessage();
    }


    if (!empty($err)){
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['sex'] = $_POST['sex'];
        $_SESSION['age'] = $_POST['age'];
        $_SESSION['phone_number'] = $_POST['phone_number'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['address'] = $_POST['address'];
        $_SESSION['nick_name'] = $_POST['nick_name'];
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['re_password'] = $_POST['re_password'];
        $_SESSION['error_message'] =  $err;
        header('Location: register.php');
    }

//    Insert new user
    try {
        $sql_user = "INSERT INTO users(full_name, address, age, sex, phone_number,email) VALUES(?, ?, ?, ?, ?, ?)";
        $statement = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($statement,$sql_user);
        if ($prepareStmt){
            mysqli_stmt_bind_param($statement,'ssisis', $_POST['fullname'],
                $_POST['address'],$_POST['age'], $_POST['sex'], $_POST['phone_number'], $_POST['email']
            );
            mysqli_stmt_execute($statement);

        }else{
            throw new Exception("Something went wrong with query create user");
        }

        $sql_get_id = "SELECT id FROM users ORDER BY ID DESC LIMIT 1";
        $result = mysqli_query($conn, $sql_get_id);
        $row = mysqli_fetch_array($result);

        $sql_account = "INSERT INTO account(user_id, nick_name, password, status) VALUES(?, ?, ?, ?)";
        $prepareStmt = mysqli_stmt_prepare($statement,$sql_account);
        if ($prepareStmt){
            $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $status = 0;
            $user_id = (int)$row[0];
            mysqli_stmt_bind_param($statement,'issi', $user_id,
                $_POST['nick_name'], $password_hash, $status
            );
            mysqli_stmt_execute($statement);

        }else{
            throw new Exception("Something went wrong with query create account");
        }
    } catch (Exception $e) {
        $_SESSION['error_message'][] = 'Can not create new account caught exception: '.  $e->getMessage(). "\n";
        header('Location: register.php');
    }

    $_SESSION['register'][] = 'Create account successful!';
    $_SESSION['register'][] = $_POST['nick_name'];
    header('Location: login.php');

}