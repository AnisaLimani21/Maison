<?php
class Database {
    public $conn;
    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if($this->conn->connect_error) die("Connection failed: " . $this->conn->connect_error);
        $this->conn->set_charset("utf8mb4");
    }
    public function query($sql) { return $this->conn->query($sql); }
}

class Slider {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
        $res = $this->db->query("SELECT * FROM sliders ORDER BY id ASC");
        $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Product {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll($limit=null) {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        if($limit) $sql .= " LIMIT $limit";
        $res = $this->db->query($sql);
        $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Review {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function getAll() {
        $res = $this->db->query("SELECT * FROM reviews ORDER BY id ASC");
        $arr = []; if($res) while($row = $res->fetch_assoc()) $arr[] = $row; return $arr;
    }
}

class Newsletter {
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function addEmail($email) {
        $stmt = $this->db->query("INSERT IGNORE INTO newsletter (email) VALUES ('".$this->db->conn->real_escape_string($email)."')");
        return $stmt;
    }
}

$db = new Database("localhost", "root", "", "maison");
$sliderObj = new Slider($db);
$productObj = new Product($db);
$reviewObj = new Review($db);
$newsletter = new Newsletter($db);

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $newsletter->addEmail($email);
    
        header("Location: homee.php");
        exit;
    }
}

$sliders = $sliderObj->getAll();
$products = $productObj->getAll(6);
$reviews = $reviewObj->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Maison Chocolate</title>
<link rel="stylesheet" href="home.css">
</head>
<body>
<nav class="navbar">
    <div class="nav-left"><img src="img/logoP.png" class="logo" alt="Logo"></div>
    <div class="nav-center" id="nav-links">
        <a href="homee.php">Home</a>
        <a href="Produktet.php">Products</a>
        <a href="aboutus.php">About Us</a>
        <a href="gift.php">Gift Box</a>
    </div>
    <div class="nav-right">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <button onclick="searchProduct()">🔍</button>
        </div>
        <a href="login.php" class="login-btn"><img src="https://img.icons8.com/ios/50/user--v1.png" alt="Login"></a>
        <a href="cart.php" class="cart-icon"><img src="https://img.icons8.com/ios/50/shopping-cart--v1.png" alt="Cart"></a>
        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div class="hero">
    <div class="hero-text">
        <h1>Maison Chocolat</h1>
        <p>Discover the most exquisite chocolates and pastries, crafted to celebrate life’s sweetest moments.</p>
        <a href="Produktet.php"><button>Discover More</button></a>
    </div>
    <div class="hero-img"><img src="img/fotojakryesore.png" alt="Chocolate"></div>
</div>

<div class="quote">
“From delicate macarons to rich pralines, from soft muffins to signature chocolates — every creation is crafted to celebrate life’s sweetest moments, paired perfectly with a touch of champagne.”
</div>

<div id="newsletterPopup" class="popup">
  <div class="popup-content">
    <span class="close" id="closePopup">&times;</span>
    <h2>Join Our Maison Family!</h2>
    <p>Sign in to get the latest updates, promotions, and sweet treats!</p>
    <form method="POST" id="newsletterForm">
        <input type="email" name="email" placeholder="Your email..." required>
        <button type="submit">Subscribe</button>
    </form>
    <button id="noThanksBtn">No Thanks</button>
  </div>
</div>

<div class="slider-wrapper">
    <div class="slides" id="slides">
        <?php foreach($sliders as $slide): ?><div class="slide"><img src="<?php echo $slide['image']; ?>" alt=""></div><?php endforeach; ?>
    </div>
</div>

<div class="featured-products">
    <h1>Our Featured Products</h1>
    <div class="products-grid">
        <?php foreach($products as $prod): ?>
        <div class="product-card">
            <img src="<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>">
            <h3><?php echo $prod['name']; ?></h3>
            <p><?php echo $prod['description']; ?></p>
            <p class="price">$<?php echo $prod['price']; ?></p>
            <a href="Produktet.php"><button>View Product</button></a>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="reviews-section">
    <h1>What Our Customers Say</h1>
    <div class="reviews-grid">
        <?php foreach($reviews as $rev): ?>
        <div class="review-card">
            <div class="icon"><?php echo $rev['icon']; ?></div>
            <div class="stars" data-rating="<?php echo $rev['rating']; ?>">
                <?php for($i=1;$i<=5;$i++): ?><span class="star" data-value="<?php echo $i; ?>">★</span><?php endfor; ?>
            </div>
            <p class="review-text"><?php echo $rev['review_text']; ?></p>
            <h3>— <?php echo $rev['name']; ?></h3>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<footer class="footer">
    <div class="footer-left">
        <h2>Maison</h2>
        <p>Unique flavors, modern style, and carefully crafted delights.</p>
    </div>

    <div class="footer-center">
        <h2>Contact</h2>
        <p>Email: maison.contact@gmail.com</p>
        <p>Phone: +383 44 000 000</p>
    </div>

    <div class="footer-right">
        <h2>Follow Us</h2>
        <div class="social-icons">
            <a href="https://www.facebook.com/" target="_blank" title="Facebook">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M22 12.07C22 6.48 17.52 2 12 2S2 6.48 2 12.07c0 5 3.66 9.13 8.44 9.93v-7.03H8.08v-2.9h2.36V9.91c0-2.33 1.38-3.62 3.52-3.62 1.02 0 2.09.18 2.09.18v2.29h-1.18c-1.16 0-1.52.72-1.52 1.46v1.75h2.59l-.41 2.9h-2.18V22c4.78-.8 8.44-4.93 8.44-9.93z"/>
                </svg>
            </a>
            <a href="https://www.instagram.com/" target="_blank" title="Instagram">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3.5A5.5 5.5 0 1017.5 13 5.5 5.5 0 0012 7.5zm0 9A3.5 3.5 0 1115.5 13 3.5 3.5 0 0112 16.5zm4.7-9.8a1.3 1.3 0 11-1.3-1.3 1.3 1.3 0 011.3 1.3z"/>
                </svg>
            </a>
            <a href="https://x.com/" target="_blank" title="X/Twitter">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M18.9 2H22l-7.5 8.1L23 22h-6.6L11.7 14l-6.3 8H2l8.1-9.1L2 2h6.6l4.4 6 5.9-6z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>

<script>
const hamburger=document.getElementById("hamburger");const navLinks=document.getElementById("nav-links");hamburger.addEventListener("click",()=>navLinks.classList.toggle("active"));
window.addEventListener('load',()=>{const slidesContainer=document.getElementById('slides');const slideWidth=slidesContainer.children[0].offsetWidth;const slideCount=slidesContainer.children.length;for(let i=0;i<slideCount;i++)slidesContainer.appendChild(slidesContainer.children[i].cloneNode(true));let x=0;function moveSlider(){x-=1;if(Math.abs(x)>=slideWidth*slideCount)x=0;slidesContainer.style.transform=`translateX(${x}px)`;requestAnimationFrame(moveSlider);}moveSlider();});
function searchProduct(){const input=document.getElementById('searchInput').value.toLowerCase().trim();const pages={"muffins":"Muffins.php","cookies":"Cookies.php","donuts":"Donuts.php","macarons":"Macarons.php","chocolates":"Chocolates.php","brownies":"Brownies.php","croissants":"Croissants.php","cheesecakes":"Cheesecakes.php","pralines":"Pralines.php","wine":"Wine.php","login":"login.php","boba":"Boba.php","products":"Produktet.php"};if(pages[input])window.location.href=pages[input];else alert("Product not found");}
const allStars=document.querySelectorAll('.review-card .star');allStars.forEach(star=>{star.addEventListener('mouseover',()=>highlightStars(star.parentElement,parseInt(star.dataset.value)));star.addEventListener('mouseout',()=>highlightStars(star.parentElement,parseInt(star.parentElement.dataset.rating)));star.addEventListener('click',()=>{star.parentElement.dataset.rating=parseInt(star.dataset.value);highlightStars(star.parentElement,parseInt(star.dataset.value));});});function highlightStars(parent,rating){parent.querySelectorAll('.star').forEach(star=>{star.classList.toggle('selected',parseInt(star.dataset.value)<=rating);});}
const newsletterPopup=document.getElementById('newsletterPopup');const closePopup=document.getElementById('closePopup');const noThanksBtn=document.getElementById('noThanksBtn');window.addEventListener('load',()=>setTimeout(()=>newsletterPopup.style.display='flex',5000));closePopup.addEventListener('click',()=>newsletterPopup.style.display='none');noThanksBtn.addEventListener('click',()=>newsletterPopup.style.display='none');window.addEventListener('click',e=>{if(e.target===newsletterPopup)newsletterPopup.style.display='none';});
</script>

</body>
</html>
