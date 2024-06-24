<?php
namespace model;
use Exception;
use PDO;
use PDOException;
class Users
{
    const TABLE = 'users';
    const ID = 'id';
    const ROLE = 'role';
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const FULL_NAME = 'full_name';
    const ADDRESS = 'address';
    const AGE = 'age';
    const SEX = 'sex';
    const PHONE_NUMBER = 'phone_number';
    const EMAIL = 'email';
    const STATUS = 'status';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const BASE_QUERY = 'SELECT users.*, accounts.username, accounts.password FROM users LEFT JOIN accounts ON users.id = accounts.user_id WHERE ';

    private $id;
    private $full_name;
    private $address;
    private $age;
    private $sex;
    private $phone_number;
    private $email;
    private $role;
    private $status;
    private $username;
    private $password;
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
        $username = null,
        $password = null,
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
        $this->username = $username;
        $this->password = $password;
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

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setId($id): Users
    {
        $this->id = $id;
        return $this;
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

    public function setUsername($username): Users
    {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password): Users
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @throws exception
     */
    public static function create($pdo, $full_name, $address, $age, $sex, $phone_number, $email, $username, $password, $role = self::ROLE_USER, $status = self::STATUS_ACTIVE): Users
    {
        $user = new self($pdo, null, $full_name, $address,  $age, $sex, $phone_number, $email,  $username, $password, $role, $status);
        $user->save(True);
        $user->_createAccount();
        return $user;
    }

    /**
     * @param bool $is_create
     * @return Users
     * @throws Exception
     */
    public function save(bool $is_create = False): Users
    {
        if($is_create){
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
            throw new exception('Cannot save user '.  $e->getMessage());
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    public function update(): Users
    {
        $this->save();
        $this->_saveAccount();
        return $this;
    }

    /**
     * @throws Exception
     */
    private function _createAccount(): void
    {
        try{
            $status = 0;
            Accounts::create(
                $this->pdo,
                $this->getId(),
                $this->getUsername(),
                $this->password,
                $status
            );
        } catch (PDOException $e) {
            throw new exception('Cannot save account '.  $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function _saveAccount(){
        try{
            $status = 0;
            $account = new Accounts(
                $this->pdo,
                $this->getId(),
                $this->getUsername(),
                $this->password,
                $status
            );
            $account->save();
        } catch (PDOException $e) {
            throw new exception('Cannot save account '.  $e->getMessage());
        }
    }

    /**
     * @return void
     * @throws exception
     */
    public function delete(){
        if ($this->id !== null) {
            try{
                $stmt_account = $this->pdo->prepare("DELETE FROM accounts WHERE user_id = ?");
                $stmt_account->execute([$this->id]);
                $stmt_posts = $this->pdo->prepare("DELETE FROM posts WHERE author_id = ?");
                $stmt_posts->execute([$this->id]);
                $stmt_user = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
                $stmt_user->execute([$this->id]);
            } catch (PDOException $e) {
                throw new exception('Cannot delete user '.  $e->getMessage());
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
    public static function getById($pdo, $id): Users
    {
        try{
            $stmt = $pdo->prepare(self::BASE_QUERY . self::TABLE. "." . self::ID. " = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)){
                foreach ($result as $value){
                    return new Users(
                        $pdo,
                        $value['id'],
                        $value['full_name'],
                        $value['address'],
                        $value['age'],
                        $value['sex'],
                        $value['phone_number'],
                        $value['email'],
                        $value['username'],
                        $value['password'],
                        $value['role'],
                        $value['status']
                    );
                }
            }
            return new Users($pdo);
        } catch (PDOException $e) {
            throw new exception('Cannot get user with id: '.$id.' cause: '.  $e->getMessage());
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
                $query .= ' ';
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new exception('Cannot get users with filters: '.  $e->getMessage());
        }
    }
}
