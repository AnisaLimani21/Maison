<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lemon Spark</title>
<link rel="stylesheet" href="ChocolateChipCookie.css">
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
        <form class="search-bar">
            <input type="text" placeholder="Search...">
            <button>🔍</button>
        </form>
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
    <a href="cart.php" class="go-cart-btn">Go to Cart</a>
</div>

<section class="product-single"
         data-name="Lemon Spark"
         data-price="3.10"
         data-img="Screenshot__420_-removebg-preview (1).png">

    <div class="circle-box">
        <img src="img/Screenshot__420_-removebg-preview (1).png" alt="Lemon Spark" style="width:500px; max-width:100%;">
    </div>

    <div class="product-details">
        <h2 class="product-title">Lemon Spark</h2>
        <p class="price">$3.10</p>

        <h3>Ingredients:</h3>
        <ul>
            <li>Soft Vanilla Batter</li>
            <li>Lemon Zest</li>
            <li>White Chocolate Chips</li>
            <li>Butter</li>
            <li>Milk</li>
            <li>Whipped Cream</li>
        </ul>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" value="1" min="1" max="20">

        <p class="total-price">Total: $3.10</p>
        <button id="add-to-cart">Add to Cart</button>
    </div>
</section>

<script>
const product = document.querySelector('.product-single');
const productName = product.dataset.name;
const productPrice = parseFloat(product.dataset.price);
const productImg = product.dataset.img;

const quantityInput = document.getElementById('quantity');
const totalPriceEl = document.querySelector('.total-price');
const addToCartBtn = document.getElementById("add-to-cart");

const cartIcon = document.getElementById("cartIcon");
const cartCount = document.getElementById("cartCount");
const miniCart = document.getElementById("miniCart");
const cartItems = document.getElementById("cartItems");

let cart = JSON.parse(localStorage.getItem("cart")) || [];
cartCount.textContent = cart.length;
updateMiniCart();

quantityInput.addEventListener('input', () => {
    let qty = parseInt(quantityInput.value);
    if(isNaN(qty) || qty < 1) qty = 1;
    if(qty > 20) qty = 20;
    quantityInput.value = qty;
    totalPriceEl.textContent = `Total: $${(productPrice * qty).toFixed(2)}`;
});

addToCartBtn.addEventListener("click", () => {
    const quantity = parseInt(quantityInput.value);
    const item = { name: productName, pricePerUnit: productPrice, img: productImg, qty: quantity };
    cart.push(item);
    localStorage.setItem("cart", JSON.stringify(cart));
    cartCount.textContent = cart.length;
    updateMiniCart();
    alert(`${productName} x${quantity} added to cart!`);
});

function updateMiniCart() {
    cartItems.innerHTML = "";
    let total = 0;
    cart.forEach(item => {
        const cost = (item.pricePerUnit * item.qty).toFixed(2);
        total += parseFloat(cost);
        const li = document.createElement("li");
        li.innerHTML = `<img src="img/${item.img}" style="width:40px;height:30px;margin-right:5px;"> ${item.name} x${item.qty} - $${cost}`;
        cartItems.appendChild(li);
    });
    document.getElementById("totalPrice").textContent = `Total: $${total.toFixed(2)}`;
}

cartIcon.addEventListener("click", e => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});
document.addEventListener("click", e => {
    if(!cartIcon.contains(e.target) && !miniCart.contains(e.target)) miniCart.style.display = "none";
});

const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");
hamburger.addEventListener("click", () => { navLinks.classList.toggle("active"); });
</script>

</body>
</html>
