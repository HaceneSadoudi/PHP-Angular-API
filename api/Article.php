<?php


class Article
{

    private $conn;
    private $table = 'article';

    // article properties
    public $id;
    public $title;
    public $description;
    public $published;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get articles
    public function getArticles()
    {
        $sql = "SELECT * FROM $this->table";

        // prepare statement
        $stmt = $this->conn->prepare($sql);
        // execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single article
    public function getArticle()
    {
        $sql = "SELECT * FROM $this->table WHERE `id` = ? LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->published = $row['published'];
            return true;
        }

        return false;
    }

    public function createArticle()
    {
        $sql = "INSERT INTO $this->table (`id`,`title`,`description`,`published`) 
              VALUES (null,?,?,?)";

        $stmt = $this->conn->prepare($sql);
        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->published = htmlspecialchars(strip_tags($this->published));
        // binding parameters
        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->description);
        $stmt->bindParam(3, $this->published);
        echo "############ $this->title $this->description $this->published ###";
        if ($stmt->execute()) {
            return true;
        }

        printf("ERROR : %S \n", $stmt->error);
        return false;
    }


    public function updateArticle()
    {


        $sql = "UPDATE $this->table 
        SET `title`=?,
        `description`=?,
        `published` = ? 
        WHERE `id` = ? LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->published = htmlspecialchars(strip_tags($this->published));
        // binding parameters
        $stmt->bindParam(1, $this->title);
        $stmt->bindParam(2, $this->description);
        $stmt->bindParam(3, $this->published);
        $stmt->bindParam(4, $this->id);
        $stmt->execute();

        if (!$this->getArticle()) {
            return [
                "exists" => false,
            ];
        }
        $count = $stmt->rowCount();
        if ($count > 0) {
            return [
                "exists" => true,
                "done" => true
            ];
        } else {
            return [
                "exists" => true,
                "done" => false
            ];
        }
    }

    public function deleteArticle() {
        if (!$this->getArticle()) {
            return [
                "exists" => false,
            ];
        }
        $sql = "DELETE FROM $this->table WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $this->id = (int) htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();


        $count = $stmt->rowCount();
        if ($count > 0) {
            return [
                "exists" => true,
                "done" => true
            ];
        } else {
            return [
                "exists" => true,
                "done" => false
            ];
        }
    }
}
