<?php
class Category {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "maison"); 
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

   
    public function getAll() {
        $sql = "SELECT * FROM categories";
        return $this->conn->query($sql);
    }
}
?>
