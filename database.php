<?php
$hostName = "localhost";
$dbUser="root";
$dbpassword="";
$dbName = "phplogin";
$conn= mysqli_connect($hostName, $dbUser, $dbpassword, $dbName);
if(!$conn){
    die("Somthing went wrong;");
}
?>