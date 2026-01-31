<?php
    class Slider {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
    $stmt = $this->db->prepare("SELECT * FROM sliders ORDER BY id ASC");
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Product {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll($limit=null) {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        if($limit) $sql .= " LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        if($limit)$stmt->bindValue(':limit',(int)$limit,PDO::PARAM_INT);
        $stmt->execute();
               return $stmt->fetchAll(PDO::FETCH_ASSOC);

       // $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Review {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM reviews ORDER BY id ASC");
       $stmt->execute();
         return $stmt->fetchAll(PDO::FETCH_ASSOC);
      
        // $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Newsletter {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function addEmail($email) {
        $stmt = $this->db->prepare("INSERT IGNORE INTO newsletter (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
class HomeController {
    private $slider;
    private $product;
    private $review;
    private $newsletter;
    private $messageManager;
    

        public function __construct($db){
        $this->slider=new Slider($db);
        $this->product = new Product($db);
        $this->review = new Review($db);
        $this->newsletter = new Newsletter($db);
        $this->messageManager = new MessageManager($db);   
        }
  

    public function handlePost() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['message'])) {
                $this->messageManager->addMessage($_POST['name'], $_POST['email'], $_POST['message'], $_SESSION['user']['id'] ?? null);
            }
            if(isset($_POST['email'])) {
                $this->newsletter->addEmail($_POST['email']);
            }
            header("Location: homee.php");
            exit;
        }
    }

    public function getSliders() { return $this->slider->getAll(); }
    public function getProducts($limit=null) { return $this->product->getAll($limit); }
    public function getReviews() { return $this->review->getAll(); }
}

?>