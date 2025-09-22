<?php
require_once "database.php";

class Book {
    public $title = "";
    public $author = "";
    public $genre = "";
    public $publication_year = "";

    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addBook() {
        $sql = "INSERT INTO book (title, author, genre, publication_year)
                VALUES (:title, :author, :genre, :publication_year)";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':title', $this->title);
        $query->bindParam(':author', $this->author);
        $query->bindParam(':genre', $this->genre);
        $query->bindParam(':publication_year', $this->publication_year);
        return $query->execute();
    }

    
    public function viewBooks() {
        $sql = "SELECT * FROM book ORDER BY title ASC;";
        $query = $this->db->connect()->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return [];
        }
    }
}
