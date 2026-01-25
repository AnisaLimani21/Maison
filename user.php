<?php

class User {
    private $conn;

    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function create($fullName, $email, $username, $pass, $confirmPass, $role = 'user'): bool
{
    if ($pass !== $confirmPass) {
        return false;
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (full_name, username, email, password, role)
              VALUES (:full_name, :username, :email, :password, :role)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':full_name', $fullName);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}



    public function login($username,$pass, $role = 'user'):bool{
      
    $query="SELECT id, username, password ,role FROM users WHERE username = :username AND role = :role";

    $stmt=$this->conn->prepare($query);

    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role',$role);

   // $stmt->bindParam(':email',$email);
    $stmt ->execute();
   // $stmt->bindParam(':pass',password_hash(password: $pass, algo:PASSWORD_DEFAULT));
    
   if($stmt->rowCount()===1){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(password_verify($pass,$row['password'])){
    session_start();
    $_SESSION ['user_id'] = $row['id'];
    $_SESSION ['username'] = $row['username'];
     $_SESSION ['role'] = $row['role'];

    return true;
   }


   }  
    return false;
}}
   




    //$errors = [];

      /*  if(empty($full_name)) $errors['full_name'] = "Full name is required.";
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
}*/
