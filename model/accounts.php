<?php
namespace model;
use Exception;
use PDO;
use PDOException;
class Accounts {
    const ID = 'id';
    const USER_ID = 'user_id';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    const BASE_QUERY = 'SELECT * FROM accounts WHERE ';

    private $pdo;
    private $id;
    private $user_id;
    private $username;
    private $password;
    private $status;

    public function __construct(
        $pdo,
        $id = null,
        $user_id = null,
        $username = null,
        $password = null,
        $status = null
    ){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUsername() {
        return $this->username;
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

    public function setUsername($username): Accounts
    {
        $this->username = $username;
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
    public static function create($pdo, $user_id, $username, $password, $status): Accounts
    {
        $account = new self($pdo, null, $user_id, $username, $password, $status);
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
            $query = "insert into accounts(user_id, username, password, status) values(:user_id, :username, :password, :status)";
        }else{
            $query = "update accounts set user_id = :user_id, username = :username, password = :password, status = :status where id = :id";
        }
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo
                ->prepare($query);
            if($this->id !== null){
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
            $stmt->bindParam(':username', $this->username, PDO::PARAM_STR);
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
     * @throws Exception
     */
    public static function getByUserName($pdo, $username): Accounts
    {
        try{
            $stmt = $pdo->prepare(self::BASE_QUERY . self::USERNAME ." = ?");
            $stmt->execute([$username]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)){
                foreach ($result as $value){
                    return new Accounts(
                        $pdo,
                        $value['id'],
                        $value['user_id'],
                        $value['username'],
                        $value['password'],
                        $value['status']
                    );
                }
            }
            return new Accounts($pdo);
        } catch (PDOException $e) {
            throw new exception('Cannot get user with id: '.$username);
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