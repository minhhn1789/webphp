<?php
ini_set('display_errors', '1');
include "model/database.php";
include "model/users.php";
use model\Users;
use model\Database;


$pdo = new Database();
try{
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $user = User::create(
//        $dbh,
//        null,
//        'ha hoang',
//        'asd asd',
//        12,
//        'Male',
//        123123,
//        'hahoanglc97@gmail.com',
//        User::ROLE_USER,
//        User::STATUS_INACTIVE
//    );
//    $id = $user->getId();
//    $name = $user->getFullName();
//    $newUser = new User($dbh, $id);
//    $newUser->getById();

    $user = Users::getById($pdo,24);
    $account = \model\Accounts::getByUserName($pdo, 'admin');
    echo $user->getFullName();
    echo $account->getUsername();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Failed: " . $e->getMessage();
}