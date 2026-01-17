<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
   

    <div class="product-card">
        <img src="img/Cookie_in_Mid-Break_with_Chocolate_Chips__1_-removebg-preview.png" alt="">
        <h3>Chocolate Chip Cookie</h3>
        <p>$2.50</p>
        <a href="ChocolateChipCookie.html" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <img src="img/Partially_Broken_Matcha_Cookie_Flight__1_-removebg-preview.png" alt="">
        <h3>Green Meadow Cookie</h3>
        <p>$3.00</p>
        <a href="GreenMeadowCookie.php" class="btn">Order Now</a>
    </div>
    <div class="product-card">
        <img src="img/Crumbled_Chocolate_Cookie_Delight__1_-removebg-preview.png" alt="">
        <h3>Dark Velvet Cookie</h3>
        <p>$3.50</p>
        <a href="DarkVelvet.php" class="btn">Order Now</a>
    </div>

    <div class="product-card">
        <img src="img/Broken_Oatmeal_Raisin_Cookie_in_Air__1_-removebg-preview (1).png" alt="">
        <h3>CocoBerry Crave Cookie</h3>
        <p>$3.00</p>
        <a href="CocoBerryCrave.php" class="btn">Order Now</a>
    </div>
    
    <div class="product-card">
        <img src="img/Crumbled_Peanut_Butter_Delight__1_-removebg-preview.png" alt="">
        <h3>Peanut Glow Cookie</h3>
        <p>$2.50</p>
        <a href="PeanutGlow.php" class="btn">Order Now</a>
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

    if(pages[input]) {
        window.location.href = pages[input];
    } else {
        alert("Product not found");
    }
}

</script>


</body>
</html>