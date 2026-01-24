<?php
require_once "Database.php";

class User {
    private $conn;

    private $table = "users";

    public function __construct($db) {
        $this->conn = $db->conn;
    }

   
    public function register($full_name, $username, $email, $password, $confirm_password, $role = 'user') {
      
        $errors = [];

        if(empty($full_name)) $errors['full_name'] = "Full name is required.";
        if(empty($username)) $errors['username'] = "Username is required.";
        if(empty($email)) $errors['email'] = "Email is required.";
        elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format.";
        if(empty($password)) $errors['password'] = "Password is required.";
        elseif(strlen($password) < 6) $errors['password'] = "Password must be at least 6 characters.";
        if($password !== $confirm_password) $errors['confirm'] = "Passwords do not match.";

        $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $errors['exists'] = "Username or email already taken.";
        }

        if(!empty($errors)) {
            return ['status'=>false, 'errors'=>$errors];
        }

        
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (full_name, username, email, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $full_name, $username, $email, $hashed, $role);

        if($stmt->execute()) {
            return ['status'=>true, 'message'=>"Account created successfully"];
        } else {
            return ['status'=>false, 'errors'=>['db'=>"Database error: " . $this->conn->error]];
        }
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, password, role FROM {$this->table} WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])) {
                return ['status'=>true, 'user_id'=>$row['id'], 'role'=>$row['role']];
            } else {
                return ['status'=>false, 'errors'=>['password'=>"Wrong password"]];
            }
        } else {
            return ['status'=>false, 'errors'=>['username'=>"User not found"]];
        }
    }
}
?>
