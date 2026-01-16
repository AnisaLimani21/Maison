<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Chocolates</title>
<link rel="stylesheet" href="Chocolates.css">
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

        <a href="login.html" class="login-btn">
            <img src="https://img.icons8.com/ios/50/user--v1.png" alt="Login">
        </a>

        <a href="cart.html" class="cart-icon" id="cartIcon">
            <img src="https://img.icons8.com/ios/50/shopping-cart--v1.png" alt="Cart">
            <span class="cart-count" id="cartCount">0</span>
        </a>

        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div id="miniCart" class="mini-cart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p id="totalPrice">Total: $0.00</p>
    <a href="cart.html" class="go-cart-btn">Go to Cart</a>
</div>

<header class="header">
    <h1>Our Chocolates</h1>
</header>

<section class="chocolate-display">
    <div class="main-photo">
        <img id="mainChocolate" src="img/Screenshot__427_-removebg-preview.png">
    </div>

    <div class="chocolate-info">
        <h2 id="chocName">Dark Chocolate</h2>
        <div class="price-add">
            <span id="chocPrice" data-unit-price="5.00">$5.00</span>
            <button id="addToCartBtn">Add to Cart 🛒</button>
        </div>

        <div class="quantity-box">
            <label>Quantity:</label>
            <button class="qty-btn" id="decrease">-</button>
            <input type="number" id="quantity" value="1" min="1" max="20">
            <button class="qty-btn" id="increase">+</button>
        </div>
    </div>

    <div class="thumbnails">
        <img src="img/Screenshot__427_-removebg-preview.png" data-name="Dark Chocolate" data-price="5.00">
        <img src="img/Screenshot__428_-removebg-preview.png" data-name="Milk Chocolate" data-price="4.50">
        <img src="img/2gg795cc7v4kwp7ni73aqfhpm09275pqas5kx3q30dpz2n3esdpjo7kinlxx-w1750-q85-removebg-preview.png" data-name="White Chocolate" data-price="4.80">
        <img src="img/Screenshot__430_-removebg-preview.png" data-name="Hazelnut Chocolate" data-price="5.50">
    </div>
</section>

<script>const mainChocolate = document.getElementById('mainChocolate');
const chocName = document.getElementById('chocName');
const chocPrice = document.getElementById('chocPrice');
const addToCartBtn = document.getElementById("addToCartBtn");
const thumbnails = document.querySelectorAll('.thumbnails img');
const quantityInput = document.getElementById('quantity');
const cartIcon = document.getElementById("cartIcon");
const cartCount = document.getElementById("cartCount");
const miniCart = document.getElementById("miniCart");
const cartItems = document.getElementById("cartItems");
const increaseBtn = document.getElementById('increase');
const decreaseBtn = document.getElementById('decrease');
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
cartCount.textContent = cart.length;
updateMiniCart();

thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
        mainChocolate.src = thumb.src;
        chocName.textContent = thumb.dataset.name;
        chocPrice.dataset.unitPrice = thumb.dataset.price;
        chocPrice.textContent = "$" + parseFloat(thumb.dataset.price).toFixed(2);
        quantityInput.value = 1;
    });
});

increaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    if(current < 20) quantityInput.value = current + 1;
});
decreaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    if(current > 1) quantityInput.value = current - 1;
});
quantityInput.addEventListener("input", () => {
    let val = parseInt(quantityInput.value);
    if(isNaN(val) || val < 1) val = 1;
    if(val > 20) val = 20;
    quantityInput.value = val;
});

addToCartBtn.addEventListener("click", () => {
    const qty = parseInt(quantityInput.value);
    const pricePerUnit = parseFloat(chocPrice.dataset.unitPrice) || 0;

    const product = {
        name: chocName.textContent,
        pricePerUnit: pricePerUnit,
        qty: qty,
        img: mainChocolate.src.split("/").pop()
    };

    cart.push(product);
    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.textContent = cart.length;
    updateMiniCart();
    alert(`${product.name} x${product.qty} added to cart!`);
});

function updateMiniCart() {
    cartItems.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        const price = parseFloat(item.pricePerUnit) || 0;
        const itemTotal = price * item.qty;
        total += itemTotal;

        const li = document.createElement("li");
        li.innerHTML = `
            <img src="img/${item.img}" style="width:40px;height:30px;margin-right:5px;">
            ${item.name} x${item.qty} - $${itemTotal.toFixed(2)}
            <button onclick="removeFromCart(${index})">Remove</button>
        `;
        cartItems.appendChild(li);
    });

    document.getElementById("totalPrice").textContent = "Total: $" + total.toFixed(2);
    miniCart.style.display = cart.length ? "block" : "none";
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.textContent = cart.length;
    updateMiniCart();
}

hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});

cartIcon.addEventListener("click", e => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});

document.addEventListener("click", e => {
    if (!cartIcon.contains(e.target) && !miniCart.contains(e.target)) {
        miniCart.style.display = "none";
    }
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
