<?php

namespace model;

use Exception;
use model\Users;
use model\Accounts;

class Check
{
    const PATTERN = [
        "name" => "/^[a-zA-Z-' ]*$/",
        "phone_number" => "/^[0-9]{10,14}$/",
        "username" => "/^[A-Za-z0-9_-]{3,10}$/",
        "password" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/"
    ];

    private $pdo;
    private $full_name;
    private $email;
    private $age;
    private $user_name;
    private $phone_number;
    private $password;
    private $re_password;
    private $err_arr;

    public function __construct(
        $pdo,
        $full_name = null,
        $email = null,
        $age = null,
        $user_name = null,
        $phone_number = null,
        $password = null,
        $re_password = null,
        $err_arr = []
    ){
        $this->pdo = $pdo;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->age = $age;
        $this->user_name = $user_name;
        $this->phone_number = $phone_number;
        $this->password = $password;
        $this->re_password = $re_password;
        $this->err_arr = $err_arr;
    }

    public function getFullName(){
        return $this->full_name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPhoneNumber(){
        return $this->phone_number;
    }

    public function getUserName(){
        return $this->user_name;
    }

    public function getAge(){
        return $this->age;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRePassword(){
        return $this->re_password;
    }

    public function setFullName($full_name): Check
    {
        $this->full_name = $full_name;
        return $this;
    }

    public function setEmail($email): Check
    {
        $this->email = $email;
        return $this;
    }

    public function setPhoneNumber($phone_number): Check
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    public function setUserName($user_name): Check
    {
        $this->user_name = $user_name;
        return $this;
    }

    public function setAge($age): Check
    {
        $this->age = $age;
        return $this;
    }

    public function setPassword($password): Check
    {
        $this->password = $password;
        return $this;
    }

    public function setRePassword($re_password): Check
    {
        $this->re_password = $re_password;
        return $this;
    }

    public function checkName(): Check
    {
        if (!preg_match(self::PATTERN['name'], $this->full_name)) {
            $this->err_arr[] = "FullName: The full name only letters and white space allowed.";
        }
        return $this;
    }

    public function checkEmail(): Check
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->err_arr[] = "Email: Invalid email format.";
        }

        try{
            $user = new Users($this->pdo);
            $results = $user->filterByAttributes([[
                USERS::EMAIL,
                "=",
                "'".$this->email."'"
            ]]);
            if(count($results) > 0){
                $this->err_arr[] = "Email: Email already exists!";
            }
        }catch (Exception $e) {
            $this->err_arr[]  = 'Can not check data caught exception: '.  $e->getMessage();
        }
        return $this;
    }

    public function checkPhoneNumber(): Check
    {
        if (!preg_match(self::PATTERN['phone_number'],$this->phone_number)) {
            $this->err_arr[] = "Phone Number: The phone number only contain number with length between 10 to 14 number.";
        }
        return $this;
    }

    public function checkAge(): Check
    {
        if ($this->age < 0 || $this->age > 150) {
            $this->err_arr[] = "Age: Invalid age of user.";
        }
        return $this;
    }

    public function checkUserName(): Check
    {
        if (!preg_match(self::PATTERN['username'],$this->user_name)) {
            $this->err_arr[] = "Username: Username can only contain letters, numbers, underscores, and hyphens. It must be between 3 and 10 characters long.";
        }

        try{
            $account = new Accounts($this->pdo);
            $account->setUserName($this->user_name);
            $results = $account->getByUserName();
            if(count($results)){
                $this->err_arr[] = "Username: Username already exists!";
            }
        }catch (Exception $e) {
            $this->err_arr[]  = 'Can not check data caught exception: '.  $e->getMessage();
        }
        return $this;
    }

    public function checkPassword(): Check
    {
        if (!preg_match(self::PATTERN['password'],$this->password)) {
            $this->err_arr[] = "Password: Invalid format password. \n
        At least one lowercase letter. \n
        At least one uppercase letter. \n
        At least one digit. \n
        Minimum length of 8 characters.";
        }elseif($this->password != $this->re_password){
            $this->err_arr[] = "Please re-enter correct password.";
        }
        return $this;
    }

    public function checkAll():Check
    {
        return $this
            ->checkName()
            ->checkEmail()
            ->checkAge()
            ->checkPhoneNumber()
            ->checkUserName()
            ->checkPassword();
    }

    public function getErrorMessage(){
        return $this->err_arr;
    }
}