<?php

/*class User {
    private $conn;

    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

   
   /* public function create($fullName, $email, $username, $pass, $confirmPass, $role = 'user'): bool
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

public function create($fullName, $email, $username, $pass, $confirmPass, $role = 'user'): bool
{
    if ($pass !== $confirmPass) {
        return false;
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password, role)
              VALUES (:username, :email, :password, :role)";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}



public function login($username, $password) {
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password, $user['password'])) {

        return $user;
    }
    return false;
}

   

?>


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







interface UserInterface {
    public function getId(): int;
    public function getUsername(): string;
    public function getRole(): string;
}

abstract class BaseUser implements UserInterface {
    protected int $id;
    protected string $username;
    protected string $email;
    protected string $role;

    public function __construct(array $userData) {
        $this->id = $userData['id'];
        $this->username = $userData['username'];
        $this->email = $userData['email'];
        $this->role = $userData['role'];
    }

    public function getId(): int {
        return $this->id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getRole(): string {
        return $this->role;
    }

    abstract public function dashboardInfo(): array;
}

class Customer extends BaseUser {
    public function dashboardInfo(): array {
        return [
            'welcome' => "Welcome, {$this->username}!",
            'role' => $this->role
        ];
    }
}

class Admin extends BaseUser {
    public function dashboardInfo(): array {
        return [
            'welcome' => "Admin Dashboard - Hello, {$this->username}",
            'role' => $this->role
        ];
    }
}

class UserManager {
    private PDO $conn;
    private string $table = "users";

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function create(string $username, string $email, string $password, string $confirmPassword, string $role = 'user'): bool {
        if($password !== $confirmPassword) return false;

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO {$this->table} (username, email, password, role, created_at)
                  VALUES (:username, :email, :password, :role, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function login(string $username, string $password): ?BaseUser {
    $sql = "SELECT * FROM {$this->table} WHERE username = :username LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])) {
        return $user['role'] === 'admin' ? new Admin($user) : new Customer($user);
    }

    return null;
}


    public function getAllUsers(): array {
        $stmt = $this->conn->query("SELECT id, username, email, role FROM {$this->table}");
        $users = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if($row['role'] === 'admin') {
                $users[] = new Admin($row);
            } else {
                $users[] = new Customer($row);
            }
        }
        return $users;
    }
    public function getUserById(int $id): ?BaseUser {
    $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if($user) {
        return $user['role'] === 'admin' ? new Admin($user) : new Customer($user);
    }
    return null;
}

}
?>
