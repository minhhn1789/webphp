<?php
namespace model;
use Exception;
use PDO;
use PDOException;
class Users
{
    const ID = 'id';
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const FULL_NAME = 'full_name';
    const ADDRESS = 'address';
    const AGE = 'age';
    const SEX = 'sex';
    const PHONE_NUMBER = 'phone_number';
    const EMAIL = 'email';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const BASE_QUERY = 'SELECT * FROM users WHERE ';

    private $id;
    private $full_name;
    private $address;
    private $age;
    private $sex;
    private $phone_number;
    private $email;
    private $role;
    private $status;
    private $pdo;

    public function __construct(
        $pdo,
        $id = null,
        $full_name = null,
        $address = null,
        $age = null,
        $sex = null,
        $phone_number = null,
        $email = null,
        $role = self::ROLE_USER,
        $status = self::STATUS_ACTIVE
    ){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->full_name = $full_name;
        $this->address = $address;
        $this->age = $age;
        $this->sex = $sex;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->role = $role;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getFullName() {
        return $this->full_name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAge() {
        return $this->age;
    }

    public function getSex() {
        return $this->sex;
    }

    public function getPhoneNumber() {
        return $this->phone_number;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setFullName($full_name): Users
    {
        $this->full_name = $full_name;
        return $this;
    }

    public function setAddress($address): Users
    {
        $this->address = $address;
        return $this;
    }

    public function setAge($age): Users
    {
        $this->age = $age;
        return $this;
    }

    public function setSex($sex): Users
    {
        $this->sex = $sex;
        return $this;
    }

    public function setPhoneNumber($phoneNumber): Users
    {
        $this->phone_number = $phoneNumber;
        return $this;
    }

    public function setEmail($email): Users
    {
        $this->email = $email;
        return $this;
    }

    public function setRole($role): Users
    {
        $this->role = $role;
        return $this;
    }

    public function setStatus($status): Users
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @throws exception
     */
    public static function create($pdo, $full_name, $address, $age, $sex, $phone_number, $email, $role = self::ROLE_USER, $status = self::STATUS_ACTIVE): Users
    {
        $user = new self($pdo, null, $full_name, $address,  $age, $sex, $phone_number, $email, $role, $status);
        $user->save();
        return $user;
    }

    /**
     * @return Users
     * @throws exception
     */
    public function save(): Users
    {
        if($this->id === null){
            $query = "insert into users(full_name, address, age, sex, phone_number,email, role, status) values(:full_name, :address, :age, :sex, :phone_number, :email, :role, :status)";
        }else{
            $query = "update users set full_name = :full_name, address = :address, age = :age, sex = :sex, phone_number = :phone_number, email = :email, role = :role, status = :status where id = :id";
        }
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo
                ->prepare($query);
            if($this->id !== null){
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':full_name', $this->full_name, PDO::PARAM_STR);
            $stmt->bindParam(':address', $this->address, PDO::PARAM_STR);
            $stmt->bindParam(':age', $this->age, PDO::PARAM_INT);
            $stmt->bindParam(':sex', $this->sex, PDO::PARAM_STR);
            $stmt->bindParam(':phone_number', $this->phone_number, PDO::PARAM_INT);
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindParam(':role', $this->role, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->execute();
            if($this->id === null){
                $this->id = $this->pdo->lastInsertId();
            }
            $this->pdo->commit();
        } catch (PDOException $e) {
            throw new exception('Cannot save user.');
        }
        return $this;
    }

    /**
     * @throws exception
     */
    public function edit($full_name = null, $address = null, $age = null, $sex = null, $phone_number = null, $email = null, $role = null, $status = null): Users
    {
        if($full_name !== null){
            $this->full_name = $full_name;
        }
        if($address !== null){
            $this->address = $address;
        }
        if($age !== null){
            $this->age = $age;
        }
        if($sex !== null){
            $this->sex = $sex;
        }
        if($phone_number !== null){
            $this->phone_number = $phone_number;
        }
        if($email !== null){
            $this->email = $email;
        }
        if($role !== null){
            $this->role = $role;
        }
        if($status !== null){
            $this->status = $status;
        }
        $this->save();
        return $this;
    }

    /**
     * @return void
     * @throws exception
     */
    public function delete(){
        if ($this->id !== null) {
            try{
                $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$this->id]);
            } catch (PDOException $e) {
                throw new exception('Cannot delete user.');
            }
        }
        $this->id = null;
        $this->full_name = null;
        $this->address = null;
        $this->age = null;
        $this->sex = null;
        $this->phone_number = null;
        $this->email = null;
        $this->role = null;
        $this->status = null;
    }

    /**
     * @throws Exception
     */
    public function getById() {
        try{
            $stmt = $this->pdo->prepare(self::BASE_QUERY . self::ID. " = ?");
            $stmt->execute([$this->id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new exception('Cannot get user with id: '.$this->id);
        }
    }

    /**
     * @throws Exception
     * $filter[$attribute, $operator, $value, $combine]
     * $operator: < > = <= >= like in
     * $combine: and or
     * $value is string, push it into ' '
     * example $filter = ["email", "=", "'abc@gmail.com'"]
     */
    public function filterByAttributes($filters) {
        try{
            $query = self::BASE_QUERY;
            foreach($filters as $filter){
                $query .= $filter[0] ." ". $filter[1] ." ". $filter[2] ." ". $filter[3] ?? '';
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new exception('Cannot get users with filters.');
        }
    }
}
