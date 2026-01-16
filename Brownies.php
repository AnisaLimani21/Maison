<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Brownies</title>
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
        <a href="login.php" class="login-btn">
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
    <h1>Our Brownies</h1>
</header>

<section class="chocolate-display">
    <div class="main-photo">
        <img id="mainChocolate" src="img/Screenshot__368_-removebg-preview.png" alt="Hot Brownie">
    </div>
    <div class="chocolate-info">
        <h2 id="chocName">Hot Brownie</h2>
        <div class="price-add">
            <span id="chocPrice" data-unit-price="6.00">$6.00</span>
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
        <img src="img/Screenshot__368_-removebg-preview.png" alt="Hot Brownie" data-name="Hot Brownie" data-unit-price="6.00">
        <img src="img/Screenshot__431_-removebg-preview.png" alt="Chocolate Brownie" data-name="Chocolate Brownie" data-unit-price="6.50">
        <img src="img/Screenshot__433_-removebg-preview.png" alt="Caramel Brownie" data-name="Caramel Brownie" data-unit-price="7.00">
    </div>
</section>

<script>
const mainChocolate = document.getElementById('mainChocolate');
const chocName = document.getElementById('chocName');
const chocPrice = document.getElementById('chocPrice');
const addToCartBtn = document.getElementById("addToCartBtn");
const thumbnails = document.querySelectorAll('.thumbnails img');
const cartIcon = document.getElementById("cartIcon");
const cartCount = document.getElementById("cartCount");
const miniCart = document.getElementById("miniCart");
const cartItems = document.getElementById("cartItems");
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

const quantityInput = document.getElementById('quantity');
const increaseBtn = document.getElementById('increase');
const decreaseBtn = document.getElementById('decrease');


let cart = JSON.parse(localStorage.getItem("cart")) || [];
cartCount.textContent = cart.length;
updateMiniCart();


thumbnails.forEach(thumb => {
    thumb.addEventListener('click', () => {
        mainChocolate.src = thumb.src;
        chocName.textContent = thumb.dataset.name;
        chocPrice.dataset.unitPrice = thumb.dataset.unitPrice;
        chocPrice.textContent = `$${parseFloat(thumb.dataset.unitPrice).toFixed(2)}`;
        quantityInput.value = 1;
    });
});


hamburger.addEventListener("click", () => { navLinks.classList.toggle("active"); });


increaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    if(current < 20) quantityInput.value = current + 1;
});
decreaseBtn.addEventListener('click', () => {
    let current = parseInt(quantityInput.value);
    if(current > 1) quantityInput.value = current - 1;
});


addToCartBtn.addEventListener("click", () => {
    const qty = parseInt(quantityInput.value);
    const pricePerUnit = parseFloat(chocPrice.dataset.unitPrice);

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
        const itemTotal = (item.pricePerUnit * item.qty).toFixed(2);
        total += parseFloat(itemTotal);

        const li = document.createElement("li");
        li.innerHTML = `
            <img src="img/${item.img}" style="width:40px;height:30px;">
            ${item.name} x${item.qty} - $${itemTotal}
            <button onclick="removeFromCart(${index})" style="margin-left:5px;">Remove</button>
        `;
        cartItems.appendChild(li);
    });
    document.getElementById("totalPrice").textContent = `Total: $${total.toFixed(2)}`;
}


function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.textContent = cart.length;
    updateMiniCart();
}


cartIcon.addEventListener("click", e => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});

document.addEventListener("click", e => {
    if(!cartIcon.contains(e.target) && !miniCart.contains(e.target)) miniCart.style.display = "none";
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
