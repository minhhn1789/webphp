<?php
ini_set('display_errors', '1');
session_start();
include "database.php";
$conn = connect_db();
try {
//    $sql = "INSERT INTO users(full_name, address, age, sex, phone_number,email) VALUES(?, ?, ?, ?, ?, ?)";
//    $statement = mysqli_stmt_init($conn);
//    $perpareStmt = mysqli_stmt_prepare($statement,$sql);
//    mysqli_stmt_bind_param($statement,'ssisis', $_SESSION['fullname'],
//        $_SESSION['address'],$_SESSION['age'], $_SESSION['sex'], $_SESSION['phone_number'], $_SESSION['email']
//    );
//    mysqli_stmt_execute($statement);
}catch (Exception $e) {
    echo $e->getMessage();
    var_dump($statement);
}

//echo implode(' ', $_SESSION);
