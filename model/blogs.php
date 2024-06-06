<?php
namespace model;
use Exception;
use PDO;
use PDOException;

class Blogs {
    const ID = 'id';
    const AUTHOR_ID = 'author_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const IMAGE = 'image';
    const STATUS_ACTIVE = 'publish';
    const STATUS_INACTIVE = 'hidden';

    const BASE_QUERY = 'SELECT * FROM posts WHERE ';

    private $pdo;
    private $id;
    private $author_id;
    private $title;
    private $content;
    private $image;
    private $status;

    public function __construct(
        $pdo,
        $id = null,
        $author_id = null,
        $title = null,
        $content = null,
        $image = null,
        $status = null
    ){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->author_id = $author_id;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthorId() {
        return $this->author_id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }

    public function getImage() {
        return $this->image;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setAuthorId($author_id): Blogs
    {
        $this->author_id = $author_id;
        return $this;
    }

    public function setTitle($title): Blogs
    {
        $this->title = $title;
        return $this;
    }

    public function setContent($content): Blogs
    {
        $this->content = $content;
        return $this;
    }

    public function setImage($image): Blogs
    {
        $this->image = $image;
        return $this;
    }

    public function setStatus($status): Blogs
    {
        $this->status = $status;
        return $this;
    }


    /**
     * @throws exception
     */
    public static function create($pdo, $id, $author_id, $title, $content, $image, $status): Blogs
    {
        $blog = new self($pdo, $id, $author_id, $title, $content, $image, $status);
        $blog->save();
        $blog->id = $blog->pdo->lastInsertId();
        return $blog;
    }

    /**
     * @return void
     * @throws exception
     */
    public function save(){
        if($this->id === null){
            $query = "insert into posts(author_id, title, content, image , status) values(:author_id, :title, :content, :image, :status)";
        }else{
            $query = "update posts set author_id = :author_id, title = :title, content = :content, image = :image , status = :status where id = :id";
        }
        try{
            $this->pdo->beginTransaction();
            $stmt = $this->pdo
                ->prepare($query);
            if($this->id !== null){
                $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindParam(':content', $this->content, PDO::PARAM_STR);
            $stmt->bindParam(':image', $this->image, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            throw new exception('Cannot save blog.');
        }
    }

    /**
     * @throws exception
     */
    public function edit($author_id = null, $title = null, $content = null, $image = null, $status = null){
        if($author_id !== null){
            $this->author_id = $author_id;
        }
        if($title !== null){
            $this->title = $title;
        }
        if($content !== null){
            $this->content = $content;
        }
        if($image !== null){
            $this->image = $image;
        }
        if($status !== null){
            $this->status = $status;
        }

        $this->save();
    }

    /**
     * @return void
     * @throws exception
     */
    public function delete(){
        if ($this->id !== null) {
            try{
                $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
                $stmt->execute([$this->id]);
            } catch (PDOException $e) {
                throw new exception('Cannot delete blog.');
            }
        }
        $this->id = null;
        $this->author_id = null;
        $this->title = null;
        $this->content = null;
        $this->image = null;
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
            throw new exception('Cannot get blog with id: '.$this->id);
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
            throw new exception('Cannot get posts with filters.');
        }
    }

}