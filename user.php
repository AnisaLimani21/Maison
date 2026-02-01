<?php


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
