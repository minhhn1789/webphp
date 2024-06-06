<?php
namespace model;
use Exception;
use PDO;
use PDOException;
class Accounts {
    const ID = 'id';
    const USER_ID = 'user_id';
    const USER_NAME = 'user_name';
    const PASSWORD = 'password';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const BASE_QUERY = 'SELECT * FROM accounts WHERE ';

    private $pdo;
    private $id;
    private $user_id;
    private $user_name;
    private $password;
    private $status;

    public function __construct(
        $pdo,
        $id = null,
        $user_id = null,
        $user_name = null,
        $password = null,
        $status = null
    ){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->password = $password;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setUserId($id): Accounts
    {
        $this->user_id = $id;
        return $this;
    }

    public function setUserName($userName): Accounts
    {
        $this->user_name = $userName;
        return $this;
    }

    public function setPassword($password): Accounts
    {
        $this->password = $password;
        return $this;
    }

    public function setStatus($status): Accounts
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @throws exception
     */
    public static function create($pdo, $user_id, $user_name, $password, $status): Accounts
    {
        $account = new self($pdo, null, $user_id, $user_name, $password, $status);
        $account->save();
        $account->id = $account->pdo->lastInsertId();
        return $account;
    }

    /**
     * @return Accounts
     * @throws exception
     */
    public function save(): Accounts
    {
        if($this->id === null){
            $query = "insert into accounts(user_id, user_name, password, status) values(:user_id, :user_name, :password, :status)";
        }else{
            $query = "update accounts set user_id = :user_id, user_name = :user_name, password = :password, status = :status where id = :id";
        }
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo
                ->prepare($query);
            if($this->id !== null){
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_name', $this->user_name, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            throw new exception('Cannot save account.');
        }
        return $this;
    }

    /**
     * @throws exception
     */
    public function edit($user_id = null, $user_name = null, $password = null, $status = null): Accounts
    {
        if($user_id !== null){
            $this->user_id = $user_id;
        }
        if($user_name !== null){
            $this->user_name = $user_name;
        }
        if($password !== null){
            $this->password = $password;
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
                $stmt = $this->pdo->prepare("DELETE FROM accounts WHERE id = ?");
                $stmt->execute([$this->id]);
            } catch (PDOException $e) {
                throw new exception('Cannot delete account.');
            }
        }
        $this->id = null;
        $this->user_id = null;
        $this->user_name = null;
        $this->password = null;
        $this->status = null;
    }

    /**
     * @throws Exception
     */
    public function getByUserName() {
        try{
            $stmt = $this->pdo->prepare(self::BASE_QUERY . self::USER_NAME ." = ?");
            $stmt->execute([$this->user_name]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new exception('Cannot get user with id: '.$this->user_name);
        }
    }

    /**
     * @throws Exception
     * $filter[$attribute, $operator, $value, $combine]
     * $operator: < > = <= >= like in
     * $combine: and or
     */
    public function filterByAttributes($filters) {
        try{
            $query = self::BASE_QUERY;
            foreach($filters as $filter){
                $query .= $filter[0] ." ". $filter[1] ." ". $filter[2] ." ". $filter[3];
            }
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new exception('Cannot get account with filters.');
        }
    }

}