
<?php
    class MessageManager{

    private $db;

    public function __construct(PDO $db){
        $this->db=$db;
    }


    public function addMessage($name,$email,$message,$userID=null){
        $stmt=$this->db->prepare(
            "INSERT INTO messages (user_id,name,email,message,created_at)
            VALUES (:user_id,:name,:email,:message,NOW())"
        );

        $stmt->bindParam(':user_id',$userId);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':message',$message);
        return $stmt->execute();
    }

    public function getAllMessages(){
        $stmt=$this->db->query(
            "SELECT m.*,u.username
            FROM messages m
            LEFT JOIN users u ON m.user_id=u.id
            ORDER BY m.created_at DESC"
        );
    }

    }


    ?>