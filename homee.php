<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "maison";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$conn->set_charset("utf8mb4");
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
    <div class="nav-left">
        <img src="img/logoP.png" class="logo" alt="Logo">
    </div>
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
        <a href="login.php" class="login-btn">
            <img src="https://img.icons8.com/ios/50/user--v1.png" alt="Login">
        </a>
        <a href="cart.php" class="cart-icon">
            <img src="https://img.icons8.com/ios/50/shopping-cart--v1.png" alt="Cart">
        </a>
        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div class="hero">
    <div class="hero-text">
        <h1>Maison Chocolat</h1>
        <p>Discover the most exquisite chocolates and pastries, crafted to celebrate life’s sweetest moments.</p>
        <a href="Produktet.php"><button>Discover More</button></a>
    </div>
    <div class="hero-img">
        <img src="img/fotojakryesore.png" alt="Chocolate">
    </div>
</div>

<div class="quote">
“From delicate macarons to rich pralines, from soft muffins to signature chocolates — every creation is crafted to celebrate life’s sweetest moments, paired perfectly with a touch of champagne.”
</div>

<div id="newsletterPopup" class="popup">
  <div class="popup-content">
    <span class="close" id="closePopup">&times;</span>
    <h2>Join Our Maison Family!</h2>
    <p>Sign in to get the latest updates, promotions, and sweet treats!</p>
    <a href="create.php"><button>Sign in</button></a>
    <button id="noThanksBtn">No Thanks</button>
  </div>
</div>

<div class="slider-wrapper">
    <div class="slides" id="slides">
        <?php
        $sql = "SELECT * FROM sliders ORDER BY id ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="slide"><img src="'.$row['image'].'" alt=""></div>';
            }
        }
        ?>
    </div>
</div>

<div class="sale-section">
    <h1>Big Sale</h1>
    <img src="photos/sale.jpg" alt="Sale">
    <h2>Sign up to My Maison Rewards for exclusive early access</h2>
    <p>Enjoy up to 50% off favourites like Maison.</p>
    <a href="create.php"><button>Sign up</button></a>
</div>

<div class="reviews-section">
    <h1>What Our Customers Say</h1>
    <div class="reviews-grid">
        <?php
        $sql = "SELECT * FROM reviews ORDER BY id ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="review-card">';
                echo '<div class="icon">'.$row['icon'].'</div>';
                echo '<div class="stars" data-rating="'.$row['rating'].'">';
                for($i=1; $i<=5; $i++){
                    echo '<span class="star" data-value="'.$i.'">★</span>';
                }
                echo '</div>';
                echo '<p class="review-text">'.$row['review_text'].'</p>';
                echo '<h3>— '.$row['name'].'</h3>';
                echo '</div>';
            }
        }
        ?>
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
            <a href="https://www.facebook.com/" target="_blank" title="Facebook">FB</a>
            <a href="https://www.instagram.com/" target="_blank" title="Instagram">IG</a>
            <a href="https://x.com/" target="_blank" title="X/Twitter">X</a>
        </div>
    </div>
</footer>

<script>
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
hamburger.addEventListener("click", () => navLinks.classList.toggle("active"));

window.addEventListener('load', () => {
    const slidesContainer = document.getElementById('slides');
    const slideWidth = slidesContainer.children[0].offsetWidth;
    const slideCount = slidesContainer.children.length;

    for (let i = 0; i < slideCount; i++) {
        slidesContainer.appendChild(slidesContainer.children[i].cloneNode(true));
    }

    let x = 0;

    function moveSlider() {
        x -= 1;
        if (Math.abs(x) >= slideWidth * slideCount) x = 0;
        slidesContainer.style.transform = `translateX(${x}px)`;
        requestAnimationFrame(moveSlider);
    }
    moveSlider();
});

function searchProduct() {
    const input = document.getElementById('searchInput').value.toLowerCase().trim();
    const pages = {
        "muffins": "Muffins.php",
        "cookies": "Cookies.php",
        "donuts": "Donuts.php",
        "macarons": "Macarons.php",
        "chocolates": "Chocolates.php",
        "brownies": "Brownies.php",
        "croissants": "Croissants.php",
        "cheesecakes": "Cheesecakes.php",
        "pralines": "Pralines.php",
        "wine": "Wine.php",
        "login": "login.php",
        "boba":"Boba.php",
        "products": "Produktet.php"
    };
    if(pages[input]) window.location.href = pages[input];
    else alert("Product not found");
}

const allStars = document.querySelectorAll('.review-card .star');
allStars.forEach(star => {
    star.addEventListener('mouseover', () => highlightStars(star.parentElement, parseInt(star.dataset.value)));
    star.addEventListener('mouseout', () => highlightStars(star.parentElement, parseInt(star.parentElement.dataset.rating)));
    star.addEventListener('click', () => {
        star.parentElement.dataset.rating = parseInt(star.dataset.value);
        highlightStars(star.parentElement, parseInt(star.dataset.value));
    });
});
function highlightStars(parent, rating) {
    parent.querySelectorAll('.star').forEach(star => {
        star.classList.toggle('selected', parseInt(star.dataset.value) <= rating);
    });
}

const newsletterPopup = document.getElementById('newsletterPopup');
const closePopup = document.getElementById('closePopup');
const noThanksBtn = document.getElementById('noThanksBtn');
window.addEventListener('load', () => setTimeout(() => newsletterPopup.style.display = 'flex', 5000));
closePopup.addEventListener('click', () => newsletterPopup.style.display = 'none');
noThanksBtn.addEventListener('click', () => newsletterPopup.style.display = 'none');
window.addEventListener('click', e => { if(e.target === newsletterPopup) newsletterPopup.style.display = 'none'; });
</script>

</body>
</html>
