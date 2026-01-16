<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Macarons</title>
    <link rel="stylesheet" href="Macarons.css">
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
    <h1>Our Macarons</h1>
</header>


<section class="products">

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__418_-removebg-preview.png" alt="Strawberry Dream" class="mac1">
        </div>
        <h3>Strawberry Dream</h3>
        <p>$3.00</p>
        <a href="StrawberryDream.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__423_-removebg-preview.png" alt="Choco Delight" class="mac2">
        </div>
        <h3>Choco Delight</h3>
        <p>$3.20</p>
        <a href="ChocoDelight.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__419_-removebg-preview.png" alt="Pistachio Bliss">
        </div>
        <h3>Pistachio Bliss</h3>
        <p>$3.50</p>
        <a href="PistachioBliss.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__422_-removebg-preview.png" alt="Vanilla Cloud">
        </div>
        <h3>Vanilla Cloud</h3>
        <p>$3.00</p>
        <a href="VanillaCloud.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__420_-removebg-preview (1).png" alt="Lemon Spark">
        </div>
        <h3>Lemon Spark</h3>
        <p>$3.10</p>
        <a href="LemonSpark.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <div class="img-wrapper">
            <img src="img/Screenshot__424_-removebg-preview.png" alt="Raspberry Rose">
        </div>
        <h3>Raspberry Rose</h3>
        <p>$3.40</p>
        <a href="RaspberryRose.php" class="btn">Order Now</a>
    </div>

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
         muffins: "Muffins.php",
         cookies: "Cookies.php",
         donuts: "Donuts.php",
         macarons: "Macarons.php",
         chocolates: "Chocolates.php",
         brownies: "Brownies.php",
         croissants: "Croissants.php"
         cheesecakes: "Cheesecakes.php",
         pralines: "Pralines.php",
         wine: "Wine.php",
         login: "login.php",
         products: "Produktet.php"
     };
     if(pages[input]) window.location.href = pages[input];
     else alert("Product not found");
 }
</script>

</body>
</html>
