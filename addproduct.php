<?php
require_once "database.php";

class Books extends Database {
    public $title = "";
    public $author = "";
    public $genre = "";
    public $pub_year = "";

    // Add a new book
    public function addBook() {
        $sql = "INSERT INTO books (title, author, genre, pub_year) 
                VALUES (:title, :author, :genre, :pub_year)";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":pub_year", $this->pub_year);

        return $query->execute();
    }

    // View all books
    public function viewBook() {
        $sql = "SELECT * FROM books ORDER BY id ASC;";
        $query = $this->connect()->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

  public function searchBook($keyword) {
        $sql = "SELECT * FROM books 
                WHERE title LIKE :keyword 
                OR id LIKE :keyword
                ORDER BY id ASC;";

        $query = $this->connect()->prepare($sql);
        $search = "%" . $keyword . "%";
        $query->bindParam(":keyword", $search);

        if ($query->execute()) {
            return $query->fetchAll(); 
        } else {
            return null;
        }
    }

    public function isBookexist($pname, $pid="") {
        $sql = "SELECT COUNT(*) AS total FROM books WHERE title=:title and id <> :id;";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":title", $pname);
        $query->bindParam(":id", $pid);
        $record = null;
        if($query->execute()) {
            $record = $query->fetch();
        }
        if($record["total"] > 0){
            return true;
        }else{
            return false;
        }
        
    }

    // Edit book by ID
    public function editBook($pid) {
        $sql = "UPDATE books 
                SET title=:title, author=:author, genre=:genre, pub_year=:pub_year 
                WHERE id = :id";
        $query = $this->connect()->prepare($sql);

        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":pub_year", $this->pub_year);
        $query->bindParam(":id", $pid, PDO::PARAM_INT);

        return $query->execute();
    }

    // Fetch one book by ID
    public function fetchBoks($pid){
        $sql = "SELECT * FROM books WHERE id=:id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $pid, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return null;
    }

    // Delete book by ID
    public function deleteBook($pid) {
        $sql = "DELETE FROM books WHERE id = :id";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":id", $pid, PDO::PARAM_INT);

        return $query->execute();
    }
}
