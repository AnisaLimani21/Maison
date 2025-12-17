<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Croissants</title>
<link rel="stylesheet" href="Chocolates.css">
<style>
.quantity-control { display:flex; align-items:center; gap:5px; }
.quantity-control button { width:30px; height:30px; font-size:18px; border:none; border-radius:5px; background:#6b3e26; color:#fff; cursor:pointer; transition:0.3s; }
.quantity-control button:hover { background:#855c3a; }
.quantity-control input { width:50px; text-align:center; font-size:16px; padding:3px; border-radius:5px; border:1px solid #ccc; }
</style>
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
        <a href="#" class="cart-icon" id="cartIcon">
            <img src="https://img.icons8.com/ios/50/shopping-cart--v1.png" alt="Cart">
            <span id="cartCount" class="cart-count">0</span>
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
    <h1>Croissants</h1>
</header>

<section class="chocolate-display">
    <div class="main-photo">
        <img id="mainChocolate" src="img/Screenshot__434_-removebg-preview.png" alt="Croissant">
    </div>

    <div class="chocolate-info">
        <h2 id="chocName">Classic Croissant</h2>
        <div class="price-add">
            <span id="chocPrice" data-price="3.50">$3.50</span>
            <div class="quantity-control">
                <button id="decreaseQty">-</button>
                <input type="number" id="chocQty" value="1" min="1" max="20">
                <button id="increaseQty">+</button>
            </div>
            <button id="addToCartBtn">Add to Cart</button>
        </div>
    </div>

    <div class="thumbnails">
        <img src="img/Screenshot__434_-removebg-preview.png" data-name="Classic Croissant" data-price="3.50">
        <img src="img/Screenshot__436_-removebg-preview.png" data-name="Chocolate Croissant" data-price="4.00">
        <img src="img/Screenshot__437_-removebg-preview.png" data-name="Almond Croissant" data-price="4.20">
        <img src="img/Screenshot__438_-removebg-preview.png" data-name="Caramel Croissant" data-price="4.50">
    </div>
</section>

<script>
const mainChocolate = document.getElementById('mainChocolate');
const chocName = document.getElementById('chocName');
const chocPrice = document.getElementById('chocPrice');
const addToCartBtn = document.getElementById("addToCartBtn");
const thumbnails = document.querySelectorAll('.thumbnails img');
const qtyInput = document.getElementById("chocQty");
const increaseBtn = document.getElementById("increaseQty");
const decreaseBtn = document.getElementById("decreaseQty");

const cartIcon = document.getElementById("cartIcon");
const cartCount = document.getElementById("cartCount");
const miniCart = document.getElementById("miniCart");
const cartItems = document.getElementById("cartItems");
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
cartCount.textContent = cart.length;

function updateMiniCart(){
    cartItems.innerHTML = "";
    let total = 0;
    cart.forEach(item => {
        const li = document.createElement("li");
        li.innerHTML = `<img src="img/${item.img}" style="width:40px;height:30px;margin-right:5px;vertical-align:middle;"> ${item.name} x${item.qty} - $${(item.pricePerUnit*item.qty).toFixed(2)}`;
        cartItems.appendChild(li);
        total += item.pricePerUnit * item.qty;
    });
    document.getElementById("totalPrice").textContent = `Total: $${total.toFixed(2)}`;
}

thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
        mainChocolate.src = thumb.src;
        chocName.textContent = thumb.dataset.name;
        chocPrice.dataset.price = thumb.dataset.price;
        chocPrice.textContent = `$${thumb.dataset.price}`;
        qtyInput.value = 1;
    });
});

increaseBtn.addEventListener("click", () => {
    let val = parseInt(qtyInput.value);
    if(val < 20) qtyInput.value = val + 1;
});
decreaseBtn.addEventListener("click", () => {
    let val = parseInt(qtyInput.value);
    if(val > 1) qtyInput.value = val - 1;
});

addToCartBtn.addEventListener("click", () => {
    const quantity = parseInt(qtyInput.value);
    const item = {
        name: chocName.textContent,
        pricePerUnit: parseFloat(chocPrice.dataset.price),
        img: mainChocolate.src.split("/").pop(),
        qty: quantity
    };
    cart.push(item);
    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.textContent = cart.length;
    updateMiniCart();
    alert(`${item.name} x${quantity} added to cart!`);
});

cartIcon.addEventListener("click", (e) => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});

document.addEventListener("click", (e) => {
    if (!cartIcon.contains(e.target) && !miniCart.contains(e.target)) {
        miniCart.style.display = "none";
    }
});

hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("active");
});

updateMiniCart();
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
