<?php
$HOSTNAME = "localhost";
$USERNAME="root";
$PASSWORD="";
$DBNAME = "blog";
function connect_db(){
    global $HOSTNAME;
    global $USERNAME;
    global $PASSWORD;
    global $DBNAME;
    $conn= mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DBNAME);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
