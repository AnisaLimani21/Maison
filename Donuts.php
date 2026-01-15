<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Donuts</title>
    <link rel="stylesheet" href="Donuts.css">
</head>
<body>
<nav class="navbar">
    <div class="nav-left">
        <img src="img/logoP.png" class="logo" alt="Logo">
    </div>

    <div class="nav-center" id="nav-links">
        <a href="homee.html">Home</a>
        <a href="Produktet.html">Products</a>
        <a href="aboutus.html">About Us</a>
        <a href="gift.html">Gift Box</a>
    </div>

    <div class="nav-right">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <button onclick="searchProduct()">🔍</button>
        </div>

        <a href="login.html" class="login-btn">
            <img src="https://img.icons8.com/ios/50/user--v1.png" alt="Login">
        </a>

        <a href="cart.html" class="cart-icon">
            <img src="https://img.icons8.com/ios/50/shopping-cart--v1.png" alt="Cart">
        </a>

        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<header class="header">
    <h1>Our Donuts</h1>
</header>

<section class="donut-products">

    <div class="donut-card">
        <div class="img-circle donut1">
            <img src="img/Screenshot__402_-removebg-preview.png" alt="">
        </div>
        <h3>Blueberry Bliss</h3>
        <p>$2.00</p>
        <a href="BlueberryBliss.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut2">
            <img src="img/Screenshot__397_-removebg-preview.png" alt="">
        </div>
        <h3>Chocolate Frosted</h3>
        <p>$2.50</p>
        <a href="ChocolateFrosted.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut3">
            <img src="img/Screenshot__365_-removebg-preview.png" alt="">
        </div>
        <h3>Strawberry Sprinkle</h3>
        <p>$2.50</p>
        <a href="StrawberrySprinkle.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut4">
            <img src="img/Screenshot__400_-removebg-preview.png" alt="">
        </div>
        <h3>Caramel Crunch</h3>
        <p>$3.00</p>
        <a href="CaramelCrunch.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut5">
            <img src="img/Glazed-Donuts--removebg-preview.png" alt="">
        </div>
        <h3>Classic Glazed</h3>
        <p>$2.00</p>
        <a href="ClassicGlazed.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut6">
            <img src="img/Screenshot__403_-removebg-preview.png" alt="">
        </div>
        <h3>Sugar Cloud</h3>
        <p>$2.50</p>
        <a href="SugarCloud.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut7">
            <img src="img/Screenshot__414_-removebg-preview.png" alt="">
        </div>
        <h3>Golden Nut Pistachio</h3>
        <p>$3.50</p>
        <a href="GoldenNutPistachio.html" class="btn">Order Now</a>
    </div>

    <div class="donut-card">
        <div class="img-circle donut8">
            <img src="img/Screenshot__405_-removebg-preview.png" alt="">
        </div>
        <h3>Snowy Bliss</h3>
        <p>$3.00</p>
        <a href="SnowyBliss.html" class="btn">Order Now</a>
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
        "muffins": "Muffins.html",
        "cookies": "Cookies.html",
        "donuts": "Donuts.html",
        "macarons": "Macarons.html",
        "chocolates": "Chocolates.html",
        "brownies": "Brownies.html",
        "croissants": "Croissants.html",
        "cheesecakes": "Cheesecakes.html",
        "pralines": "Pralines.html",
        "wine": "Wine.html",
        "login": "login.html",
        "boba":"Boba.html",
        "products": "Produktet.html"
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
