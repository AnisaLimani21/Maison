<?php

require_once "classes/Category.php";
require_once "ProduktetClass.php";
require_once "ProductRepository.php";

$categoryObj = new Category();
$categories = $categoryObj->getAll();

$productRepo=new ProductRepository();
$products=$productRepo->getAllProducts();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maison Chocolate</title>
    <link rel="stylesheet" href="Produktet.css">
</head>
<body>


<nav class="navbar">
    <div class="nav-top">
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
    </div>
</nav>


<section class="categories">
    <?php if($categories && $categories->num_rows > 0): ?>
        <?php while($cat = $categories->fetch_assoc()): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['name']) ?>">
                <h3><?= htmlspecialchars($cat['name']) ?></h3>
                <a href="<?= htmlspecialchars($cat['name']) ?>.php">View More</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center">No categories found</p>
    <?php endif; ?>
</section>


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
const hamburger = document.querySelector('.hamburger');
const navCenter = document.querySelector('.nav-center');
hamburger.addEventListener('click', () => {
    navCenter.classList.toggle('active');
});

function searchProduct() {
    const input = document.getElementById('searchInput').value.toLowerCase().trim();
    const pages = {
        "cookies":"Cookies.php",
        "muffins":"Muffins.php",
        "donuts":"Donuts.php",
        "macarons":"Macarons.php",
        "chocolates":"Chocolates.php",
        "brownies":"Brownies.php",
        "croissants":"Croissants.php",
        "cheesecakes":"Cheesecakes.php",
        "pralines":"Pralines.php",
        "wine":"Wine.php",
        "boba drinks":"Boba.php"
    };
    if(pages[input]){
        window.location.href = pages[input];
    } else {
        alert("Product not found");
    }
}
</script>

</body>
</html>
