<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Boba Drinks</title>

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Arial,sans-serif;background:#fff8f2;overflow-x:hidden}

.navbar{
    width:100%;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#6b3e26;
    box-shadow:0 8px 20px rgba(0,0,0,.3);
    border-bottom-left-radius:10px;
    border-bottom-right-radius:10px
}

.logo{width:70px}

.nav-left,.nav-right{display:flex;align-items:center;gap:15px}

.nav-center{display:flex;gap:30px}
.nav-center a{text-decoration:none;color:#fff;font-weight:600}
.nav-center a:hover{color:#ffd88c}

.search-bar{display:flex;align-items:center;background:#fff;border-radius:20px;padding:2px 10px}
.search-bar input{border:none;outline:none;background:none}
.search-bar button{border:none;background:none;font-size:18px;cursor:pointer}

.login-btn img,.cart-icon img{
    width:30px;height:30px;filter:invert(100%);transition:.3s
}
.login-btn img:hover,.cart-icon img:hover{
    filter:invert(85%) sepia(100%) saturate(500%) hue-rotate(30deg)
}

.cart-icon{position:relative;cursor:pointer}
.cart-count{
    position:absolute;
    top:-6px;right:-6px;
    background:red;color:#fff;
    font-size:12px;padding:2px 6px;border-radius:50%
}

.hamburger{
    display:none;
    font-size:28px;
    color:#fff;
    cursor:pointer
}

.mini-cart{
    position:absolute;
    right:20px;top:65px;
    width:300px;
    background:#fff8f2;
    border:2px solid #6b3e26;
    padding:20px;
    border-radius:10px;
    display:none;
    z-index:100
}

.mini-cart h4{color:#6b3e26;margin-bottom:10px}
.mini-cart ul{list-style:none;max-height:200px;overflow-y:auto}
.mini-cart li{display:flex;gap:8px;margin-bottom:10px;font-size:14px;align-items:center}
.mini-cart img{width:40px;height:30px;object-fit:contain}
#totalPrice{font-weight:bold;color:#6b3e26;margin-top:10px}
.go-cart-btn{
    display:block;margin-top:10px;
    background:#6b3e26;color:#fff;
    text-align:center;padding:8px;
    border-radius:6px;text-decoration:none
}

.header{text-align:center;padding:30px;color:#6b3e26}

.boba-display{
    display:flex;
    justify-content:center;
    gap:40px;
    flex-wrap:wrap;
    padding:20px
}

.main-photo-wrapper{
    width:300px;height:450px;
    display:flex;justify-content:center;align-items:center;
    border:2px solid #6b3e26;border-radius:10px
}

.main-photo-wrapper img{width:100%;height:100%;object-fit:contain}

.boba-info{
    max-width:300px;
    display:flex;
    flex-direction:column;
    align-items:flex-start
}

.price-add span{font-size:20px;font-weight:bold;color:#6b3e26}

.qty-box{display:flex;gap:10px;margin:10px 0}
.qty-box button{
    padding:5px 10px;
    background:#6b3e26;color:#fff;
    border:none;border-radius:4px;cursor:pointer
}

#addToCartBtn{
    padding:14px;
    background:linear-gradient(135deg,#6b3e26,#9c5c3b);
    color:#fff;border:none;border-radius:8px;
    cursor:pointer;font-weight:bold
}

.boba-thumbnails{
    display:flex;gap:10px;margin-top:15px;flex-wrap:wrap
}
.boba-thumbnails img{
    width:60px;height:60px;
    object-fit:contain;
    cursor:pointer;
    border:2px solid transparent;
    border-radius:5px
}
.boba-thumbnails img.active{border-color:#6b3e26}

@media(max-width:900px){
    .navbar{flex-wrap:wrap;padding:15px 20px}
    .nav-center{
        display:none;
        flex-direction:column;
        width:100%;
        background:#4b2e1e;
        margin-top:15px;
        border-radius:0 0 15px 15px
    }
    .nav-center.active{display:flex}
    .nav-center a{
        padding:15px;
        text-align:center;
        border-top:1px solid rgba(255,255,255,.2)
    }
    .hamburger{display:block}
}

@media(max-width:600px){
    .search-bar{display:none}
    .boba-display{flex-direction:column;align-items:center}
    .boba-info{align-items:center;text-align:center}
}
</style>
</head>

<body>

<nav class="navbar">
    <div class="nav-left">
        <img src="img/logoP.png" class="logo">
    </div>

    <div class="nav-center" id="navLinks">
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
            <img src="https://img.icons8.com/ios/50/user--v1.png">
        </a>

        <div class="cart-icon" id="cartIcon">
            <img src="https://img.icons8.com/ios/50/shopping-cart--v1.png">
            <span id="cartCount" class="cart-count">0</span>
        </div>

        <div class="hamburger" id="hamburger">☰</div>
    </div>
</nav>

<div class="mini-cart" id="miniCart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p id="totalPrice">Total: $0.00</p>
    <a href="cart.html" class="go-cart-btn">Go to Cart</a>
</div>

<header class="header"><h1>Our Boba Drinks</h1></header>

<section class="boba-display">
    <div class="main-photo-wrapper">
        <img id="mainBoba" src="img/Screenshot__469_-removebg-preview.png">
    </div>
    <div class="boba-info">
        <h2 id="bobaName">Strawberry Boba</h2>
        <p>Sweet strawberry flavored boba with milk.</p>
        <div class="price-add"><span id="bobaPrice">$5.00</span></div>

        <div class="qty-box">
            <button id="minusBtn">-</button>
            <span id="qtyDisplay">1</span>
            <button id="plusBtn">+</button>
        </div>

        <button id="addToCartBtn">Add to Cart</button>

        <div class="boba-thumbnails">
            <img src="img/Screenshot__469_-removebg-preview.png" data-name="Strawberry Boba" data-price="5" class="active">
            <img src="img/Screenshot__470_-removebg-preview.png" data-name="Taro Boba" data-price="5.5">
            <img src="img/unnamed-removebg-preview.png" data-name="Matcha Boba" data-price="6">
            <img src="img/Screenshot__471_-removebg-preview.png" data-name="Brown Sugar Boba" data-price="6.5">
        </div>
    </div>
</section>

<script>
let qty=1;
let cart=JSON.parse(localStorage.getItem("cart"))||[];

const qtyDisplay=document.getElementById("qtyDisplay");
const mainBoba=document.getElementById("mainBoba");
const bobaName=document.getElementById("bobaName");
const bobaPrice=document.getElementById("bobaPrice");
const cartIcon=document.getElementById("cartIcon");
const miniCart=document.getElementById("miniCart");
const cartItems=document.getElementById("cartItems");

plusBtn.onclick=()=>{qty++;qtyDisplay.textContent=qty}
minusBtn.onclick=()=>{if(qty>1){qty--;qtyDisplay.textContent=qty}}

document.querySelectorAll(".boba-thumbnails img").forEach(img=>{
    img.onclick=()=>{
        document.querySelectorAll(".boba-thumbnails img").forEach(i=>i.classList.remove("active"));
        img.classList.add("active");
        mainBoba.src=img.src;
        bobaName.textContent=img.dataset.name;
        bobaPrice.textContent="$"+(+img.dataset.price).toFixed(2);
        qty=1;qtyDisplay.textContent=qty
    }
});

addToCartBtn.onclick=()=>{
    const price=parseFloat(bobaPrice.textContent.replace("$",""));
    const item=cart.find(i=>i.name===bobaName.textContent);
    if(item){item.qty+=qty}
    else{cart.push({name:bobaName.textContent,pricePerUnit:price,img:mainBoba.src.split("/").pop(),qty})}
    localStorage.setItem("cart",JSON.stringify(cart));
    updateCart()
};

function updateCart(){
    cartItems.innerHTML="";
    let total=0;
    cart.forEach(i=>{
        total+=i.pricePerUnit*i.qty;
        cartItems.innerHTML+=`<li><img src="img/${i.img}">${i.name} x${i.qty}</li>`
    });
    cartCount.textContent=cart.reduce((s,i)=>s+i.qty,0);
    totalPrice.textContent="Total: $"+total.toFixed(2)
}

cartIcon.onclick=()=>miniCart.style.display=miniCart.style.display==="block"?"none":"block";

hamburger.onclick=()=>navLinks.classList.toggle("active");

updateCart();

function searchProduct(){
    const v=searchInput.value.toLowerCase().trim();
    const p={muffins:"Muffins.html",cookies:"Cookies.html",donuts:"Donuts.html",macarons:"Macarons.html",chocolates:"Chocolates.html",brownies:"Brownies.html",croissants:"Croissants.html",cheesecakes:"Cheesecakes.html",pralines:"Pralines.html",wine:"Wine.html",boba:"Boba.html",products:"Produktet.html",login:"login.html"};
    if(p[v])location.href=p[v];else alert("Product not found")
}
</script>

</body>
</html>
