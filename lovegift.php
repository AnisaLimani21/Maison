<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Love Gift Box</title>
<link rel="stylesheet" href="lovegift.css">
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

<section class="product-single">
    <div class="circle-box">
        <img src="img/dhurata3.webp" alt="Love Gift Box">
    </div>
    <div class="product-details">
        <h2 class="product-title">Party Gift Box</h2>
        <p class="price">€48.00</p>
        <h3>Ingredients:</h3>
        <ul>
            <li>Cocoa butter</li>
            <li>Hazelnuts (roasted)</li>
            <li>Pistachios</li>
            <li>Caramel</li>
            <li>Emulsifier</li>
            <li>Vanilla</li>
        </ul>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" value="1" min="1" max="20">
        <p class="total-price">Total: €48.00</p>
        <button id="add-to-cart">Add to Cart</button>
    </div>
</section>

<div class="mini-cart" id="miniCart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p id="totalPriceMini">Total: €0.00</p>
    <a href="cart.php" class="go-cart-btn">Go to Cart</a>
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
let cart = JSON.parse(localStorage.getItem("cart")) || [];
const price = 48.00;
const quantityInput = document.getElementById('quantity');
const totalPrice = document.querySelector('.total-price');
const cartItems = document.getElementById('cartItems');
const miniCart = document.getElementById('miniCart');
const cartIcon = document.getElementById('cartIcon');

function updateTotalPrice() {
    let qty = parseInt(quantityInput.value);
    if(qty < 1) qty = 1;
    if(qty > 20) qty = 20;
    totalPrice.textContent = `Total: €${(price*qty).toFixed(2)}`;
}

quantityInput.addEventListener('input', updateTotalPrice);

document.getElementById('add-to-cart').onclick = () => {
    let qty = parseInt(quantityInput.value);
    let existing = cart.find(item => item.name === "Party Gift Box");
    if(existing) { existing.qty += qty; } 
    else { cart.push({ name: "Party Gift Box", pricePerUnit: price, qty: qty, img:"dhurata3.webp" }); }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateMiniCart();
    quantityInput.value = 1;
    updateTotalPrice();
}

function updateMiniCart(){
    cartItems.innerHTML = "";
    cart.forEach(item => {
        const li = document.createElement('li');
        li.innerHTML = `<img src="img/${item.img}" alt="${item.name}"> ${item.name} €${item.pricePerUnit.toFixed(2)} x ${item.qty} = €${(item.pricePerUnit*item.qty).toFixed(2)}`;
        cartItems.appendChild(li);
    });
    document.getElementById('totalPriceMini').textContent = `Total: €${cart.reduce((sum,i)=>sum+i.qty*i.pricePerUnit,0).toFixed(2)}`;
    document.getElementById('cartCount').textContent = cart.reduce((sum,i)=>sum+i.qty,0);
}

cartIcon.onclick = e => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display==="block"?"none":"block";
}

document.addEventListener('click', e=>{
    if(!e.target.closest(".cart-icon") && !e.target.closest(".mini-cart")){
        miniCart.style.display="none";
    }
})

updateTotalPrice();
updateMiniCart();
</script>
</body>
</html>
