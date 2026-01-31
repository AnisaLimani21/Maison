
<?php

class MessageRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllMessages() {
        $stmt = $this->db->query(
            "SELECT m.*, u.username
             FROM messages m
             LEFT JOIN users u ON m.user_id=u.id
             ORDER BY m.created_at DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
