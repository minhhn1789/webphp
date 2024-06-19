<?php
namespace model;
use Exception;
use PDO;
use PDOException;

class Blogs {
    const TABLE = 'posts';

    const ID = 'id';
    const AUTHOR_ID = 'author_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const IMAGE = 'image';

    const STATUS = 'status';
    const STATUS_ACTIVE = 'publish';
    const STATUS_INACTIVE = 'hidden';

    const IMAGE_UPLOAD_PATH = '/uploads/';

    const BASE_QUERY = 'SELECT posts.*, users.full_name FROM posts LEFT JOIN users on users.id = posts.author_id WHERE ';

    private $pdo;
    private $id;
    private $author_id;
    private $title;
    private $content;
    private $image;
    private $image_path;
    private $status;

    private $updated_at;

    private $directory_file_call;

    public function __construct(
        $pdo,
        $id = null,
        $author_id = null,
        $title = null,
        $content = null,
        $image = [],
        $status = null,
        $image_path = null,
        $directory_file_call = null,
        $updated_at = null
    ){
        $this->pdo = $pdo;
        $this->id = $id;
        $this->author_id = $author_id;
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
        $this->status = $status;
        $this->image_path = $image_path;
        $this->directory_file_call = $directory_file_call;
        $this->updated_at = $updated_at;
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

    public function getImagePath() {
        return $this->image_path;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getUpdatedAt(){
        return $this->updated_at;
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

    public function setImagePath($image_path): Blogs
    {
        $this->image_path = $image_path;
        return $this;
    }

    public function setStatus($status): Blogs
    {
        $this->status = $status;
        return $this;
    }

    public function setDirectoryFileCall($directory): Blogs
    {
        $this->directory_file_call = $directory;
        return $this;
    }

    public function setUpdatedAt($updatedAt): Blogs
    {
        $this->updated_at = $updatedAt;
        return $this;
    }


    /**
     * @throws exception
     */
    public static function create($pdo, $author_id, $title, $content, $image, $status): Blogs
    {
        $blog = new self($pdo, null, $author_id, $title, $content, $image, $status, null, dirname(__DIR__));
        if(!empty($blog->image)){
            $blog->_imageUpload();
        }
        $blog->save();
//        $blog->id = $blog->pdo->lastInsertId();
        return $blog;
    }

    /**
     * @throws Exception
     */
    private function _imageUpload(): void
    {
        try {
            if(!empty($this->image)) {
                $file_path = $this->directory_file_call . self::IMAGE_UPLOAD_PATH . basename($this->image['name']);
                $imageFileType = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                if (!getimagesize($this->image["tmp_name"])) {
                    throw new exception("File is not an image.");
                }

                if (file_exists($file_path)) {
                    throw new exception("Sorry, file already exists.");
                }

                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    throw new exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                }

                if ($this->image["size"] > 500000) {
                    throw new exception("Sorry, your file is too large.");
                }

                if (move_uploaded_file($this->image["tmp_name"], $file_path)) {
                    $this->setImagePath(basename($this->image['name']));
                } else {
                    throw new exception("Sorry, there was an error uploading your file.");
                }
            }
        }catch (Exception $e){
            throw new exception("Upload image error: ".  $e->getMessage());
        }
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
            $stmt->bindParam(':image', $this->image_path, PDO::PARAM_STR);
            $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
            $stmt->execute();
            if($this->id === null){
                $this->id = $this->pdo->lastInsertId();
            }
            $this->pdo->commit();
        } catch (PDOException $e) {
            throw new exception('Cannot save post '.  $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function update(): Blogs
    {
        if(!empty($this->image)){
            $this->_imageUpload();
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
                $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
                $stmt->execute([$this->id]);
            } catch (PDOException $e) {
                throw new exception('Cannot delete post '.  $e->getMessage());
            }
        }
        $this->id = null;
        $this->author_id = null;
        $this->title = null;
        $this->content = null;
        $this->image_path = null;
        $this->image = null;
        $this->status = null;
    }

    /**
     * @throws Exception
     */
    public static function getById($pdo, $id): Blogs
    {
        try{
            $stmt = $pdo->prepare(self::BASE_QUERY . self::TABLE.".".self::ID. " = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($result)){
                foreach ($result as $value){
                    return new Blogs(
                        $pdo,
                        $value['id'],
                        $value['author_id'],
                        $value['title'],
                        $value['content'],
                        null,
                        $value['status'],
                        $value['image'],
                        null,
                        $value['updated_at']
                    );
                }
            }
            return new Blogs($pdo);

        } catch (PDOException $e) {
            throw new exception('Cannot get post with id: '.$id. ' cause: '.  $e->getMessage());
        }
    }

    /**
     * @throws Exception
     * $filter[$attribute, $operator, $value, $combine]
     * $operator: < > = <= >= like in is
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
            throw new exception('Cannot get posts with filters '.  $e->getMessage());
        }
    }

}