<?php

$conn = new mysqli("localhost", "root", "", "maison");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$categoryName = "Cookies";
$sql = "SELECT * FROM products WHERE category = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $categoryName);
$stmt->execute();
$products = $stmt->get_result();

function createFileName($name) {
    
    $fileName = preg_replace("/[^A-Za-z0-9]/", "", $name);
    
    return $fileName . ".php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Cookies - Maison Chocolate</title>
    <link rel="stylesheet" href="Cookies.css">
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

<header class="header">
    <h1>Our Cookies</h1>
</header>

<section class="products">
    <?php if($products && $products->num_rows > 0): ?>
        <?php while($prod = $products->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>">
                <h3><?= htmlspecialchars($prod['name']) ?></h3>
                <p>$<?= htmlspecialchars($prod['price']) ?></p>
               
                <a href="<?= createFileName($prod['name']) ?>" class="btn">Order Now</a>

            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center">No products found</p>
    <?php endif; ?>
</section>



<script>
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
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
</script>

</body>
</html>
