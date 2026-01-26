<?php
class OrderManager {
    private PDO $conn;
    private string $table = "orders"; 
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getUserOrders(int $userId): array {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE user_id = :uid ORDER BY created_at DESC");
        $stmt->bindParam(':uid', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
