<?php


class User {
    private $conn;

    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

   
    public function create($name, $email, $user,$pass, $confirmPass, $role = 'user'):bool{
      
    $query="INSERT INTO{$this->table_name} (name,email,user,pass,confirmPass,role)VALUES(:name, :email, :user, :pass, :confirmPass, :role)";
    $stmt=$this->conn->prepare($query);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':user',$user);
    $stmt->bindParam(':pass',password_hash(password: $pass, algo:PASSWORD_DEFAULT));
    $stmt->bindParam(':confirmPass',password_hash(password:$confirmPass, algo:PASSWORD_DEFAULT));
    $stmt->bindParam(':role',$role);
    

    if($stmt->execute()){
        return true;
    }
    return false;
    }


    public function login($user,$pass, $role = 'user'):bool{
      
    $query="SELECT id, name,email,user, password FROM{$this->table_name} WHERE email= :email";

    $stmt=$this->conn->prepare($query);

    $stmt->bindParam(':user', $user);
   // $stmt->bindParam(':email',$email);
    $stmt ->execute();
   // $stmt->bindParam(':pass',password_hash(password: $pass, algo:PASSWORD_DEFAULT));
   // $stmt->bindParam(':role',$role);
    
   if($stmt->rowCount()>0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(paassword_verify(password: $pass,hash:$row['password'])){
    session_start();
    $_SESSION ['user_id'] = $row['id'];
    $_SESSION ['email'] = $row['email'];
    return true;
   }


   }   return false;

   }


}

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
?>
