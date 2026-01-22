<?php
require_once "Database.php";

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->conn;
    }

  
    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                return ["status" => true, "role" => $row['role']];
            } else {
                return ["status" => false, "message" => "Wrong password"];
            }
        } else {
            return ["status" => false, "message" => "User not found"];
        }
    }

   
    public function register($username, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        if ($stmt->execute()) {
            return ["status" => true, "message" => "Account created successfully"];
        } else {
            return ["status" => false, "message" => "Error: " . $this->conn->error];
        }
    }
}
?>
