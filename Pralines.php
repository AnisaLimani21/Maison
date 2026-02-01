<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT * FROM products WHERE category='Pralines'");
$pralines = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$pralines) die("No pralines found");

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$cart_count = count($_SESSION['cart']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action']==='add_to_cart') {
    $id = intval($_POST['id']);
    $qty = max(1, min(20, intval($_POST['quantity'])));

    $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if($product){
        $found = false;
        foreach($_SESSION['cart'] as &$item){
            if($item['id']==$id){ $item['qty']+=$qty; $found=true; break; }
        }
        if(!$found){
            $_SESSION['cart'][] = [
                'id'=>$product['id'],
                'name'=>$product['name'],
                'price'=>$product['price'],
                'image'=>$product['image'],
                'qty'=>$qty
            ];
        }

        $total = 0;
        foreach($_SESSION['cart'] as $i) $total+=$i['price']*$i['qty'];

        echo json_encode([
            'success'=>true,
            'cart_count'=>count($_SESSION['cart']),
            'cart'=>$_SESSION['cart'],
            'total'=>$total
        ]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pralines</title>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #fff8f2;
    overflow-x: hidden;
}

.navbar {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: #6b3e26;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.logo {
    width: 70px;
}

.nav-left,
.nav-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.nav-center {
    display: flex;
    gap: 30px;
}

.nav-center a {
    text-decoration: none;
    color: #fff;
    font-weight: 600;
}

.nav-center a:hover {
    color: #ffd88c;
}

.search-bar {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 20px;
    padding: 2px 10px;
}

.search-bar input {
    border: none;
    outline: none;
    padding: 5px;
}

.search-bar button {
    border: none;
    background: none;
    font-size: 18px;
    cursor: pointer;
}

.login-btn img,
.cart-icon img {
    width: 30px;
    height: 30px;
    filter: invert(100%);
    transition: 0.3s;
}

.login-btn img:hover,
.cart-icon img:hover {
    filter: invert(85%) sepia(100%) saturate(500%) hue-rotate(30deg);
}

.cart-icon {
    position: relative;
    cursor: pointer;
}

.cart-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: red;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 50%;
}

.hamburger {
    display: none;
    font-size: 28px;
    color: #fff;
    cursor: pointer;
}
.header { text-align: center; padding: 30px 0; }
.header h1 { color: #6b3e26; }
.mini-cart {
    position: absolute;
    right: 20px;
    top: 80px;
    width: 300px;
    background: #fff8f2;
    border: 2px solid #6b3e26;
    padding: 20px;
    border-radius: 10px;
    display: none;
    z-index: 100;
}

.mini-cart h4 {
    color: #6b3e26;
    margin-bottom: 10px;
}

.mini-cart ul {
    list-style: none;
    max-height: 200px;
    overflow-y: auto;
}

.mini-cart li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 14px;
}

.mini-cart img {
    width: 40px;
    height: 30px;
    object-fit: cover;
    border-radius: 5px;
}

.go-cart-btn {
    display: block;
    margin-top: 10px;
    background: #6b3e26;
    color: white;
    text-align: center;
    padding: 8px;
    border-radius: 6px;
    text-decoration: none;
}

.grid {
    padding: 40px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 30px;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

.card img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 20px;
    margin-bottom: 15px;
}

.btn {
    background: #6b3e26;
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 10px;
    display: inline-block;
}

.modal-bg {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.65);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 200;
}

.modal {
    background: white;
    width: 90%;
    max-width: 460px;
    padding: 25px;
    border-radius: 20px;
    position: relative;
}

.close {
    position: absolute;
    top: 15px;
    right: 18px;
    font-size: 22px;
    cursor: pointer;
    color: #6b3e26;
}

.modal img {
    width: 100%;
    height: 240px;
    object-fit: contain;
    background: #fff8f2;
    border-radius: 15px;
    margin-bottom: 15px;
}

.qty-selector {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-top: 15px;
}

.qty-selector button {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    border: none;
    background: #6b3e26;
    color: white;
    font-size: 18px;
    cursor: pointer;
}

.add-btn {
    width: 100%;
    padding: 14px;
    margin-top: 20px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #6b3e26, #9c5c3b);
    color: white;
    font-weight: bold;
    cursor: pointer;
}

@media (max-width: 900px) {
    .navbar {
        flex-wrap: wrap;
        padding: 15px 20px;
    }
    .nav-center {
        display: none;
        flex-direction: column;
        width: 100%;
        background: #4b2e1e;
        margin-top: 15px;
        border-radius: 0 0 15px 15px;
    }
    .nav-center.active {
        display: flex;
    }
    .nav-center a {
        padding: 15px;
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }
    .hamburger {
        display: block;
    }
}

@media (max-width: 600px) {
    .search-bar {
        display: none;
    }
    .grid {
        grid-template-columns: 1fr;
        padding: 20px;
    }
}
</style>
</head>
<body>

<nav class="navbar">
    <div class="nav-left"><img src="img/logoP.png" class="logo" alt="Logo"></div>
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
            <span id="cartCount" class="cart-count"><?php echo $cart_count; ?></span>
        </a>
        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div id="miniCart" class="mini-cart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p>Total: $<span id="totalPrice">0.00</span></p>
    <a href="save_cart.php" class="go-cart-btn">Go to Cart</a>
</div>
<header class="header">
    <h1>Our Pralines</h1>
</header>


<div class="grid" id="pralineGrid">
<?php foreach($pralines as $p): ?>
<div class="card" data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-name="<?= htmlspecialchars($p['name']) ?>" data-image="<?= htmlspecialchars($p['image']) ?>" data-ingredients="<?= htmlspecialchars($p['ingredients'] ?? '') ?>">
    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
    <h3><?= htmlspecialchars($p['name']) ?></h3>
    <p>$<?= number_format($p['price'],2) ?></p>
    <div class="btn" onclick="openModal(this)">View Details</div>
</div>
<?php endforeach; ?>
</div>

<div id="modalBg" class="modal-bg">
    <div class="modal">
        <span class="close" id="modalClose">×</span>
        <img id="modalImg" src="" alt="">
        <h3 id="modalName"></h3>
        <p id="modalPrice"></p>
        <ul id="modalIng"></ul>
        <div class="qty-selector">
            <button id="minusBtn">-</button>
            <span id="qtyNumber">1</span>
            <button id="plusBtn">+</button>
        </div>
        <button class="add-btn" id="modalAddBtn">Add to Cart</button>
    </div>
</div>

<script>
let pralines = <?= json_encode($pralines) ?>;
let currentIndex = 0, qty = 1;

const modalBg = document.getElementById('modalBg');
const modalImg = document.getElementById('modalImg');
const modalName = document.getElementById('modalName');
const modalPrice = document.getElementById('modalPrice');
const modalIng = document.getElementById('modalIng');
const qtyNumber = document.getElementById('qtyNumber');
const cartCountEl = document.getElementById('cartCount');
const cartItemsEl = document.getElementById('cartItems');
const totalPriceEl = document.getElementById('totalPrice');

modalIng.innerHTML = '';
if(pralines[currentIndex].ingredients && pralines[currentIndex].ingredients.trim() !== ''){
    modalIng.innerHTML = pralines[currentIndex].ingredients
        .split(',')
        .map(x=>`<li>${x.trim()}</li>`)
        .join('');
} 


function openModal(el){
    const id = el.parentElement.dataset.id || el.dataset.id;
    currentIndex = pralines.findIndex(p=>p.id==id);
    const p = pralines[currentIndex];
    qty=1; qtyNumber.innerText='1';
    modalImg.src = p.image;
    modalName.innerText = p.name;
    modalPrice.innerText = "$"+parseFloat(p.price).toFixed(2);
    modalBg.style.display='flex';
}
document.getElementById('modalClose').onclick = ()=>modalBg.style.display='none';
document.getElementById('plusBtn').onclick = ()=>{ if(qty<20){ qty++; qtyNumber.innerText=qty; } }
document.getElementById('minusBtn').onclick = ()=>{ if(qty>1){ qty--; qtyNumber.innerText=qty; } }

function updateCartDisplay(cart){
    cartItemsEl.innerHTML='';
    let total=0;
    cart.forEach(i=>{
        total+=parseFloat(i.price)*i.qty;
        cartItemsEl.innerHTML+=`<li><img src="${i.image}" style="width:40px;height:30px;"> ${i.name} x${i.qty} - $${(i.price*i.qty).toFixed(2)}</li>`;
    });
    cartCountEl.innerText = cart.reduce((a,b)=>a+b.qty,0);
    totalPriceEl.innerText = total.toFixed(2);
}

document.getElementById('modalAddBtn').onclick = ()=>{
    const p = pralines[currentIndex];
    fetch('',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=add_to_cart&id=${p.id}&quantity=${qty}`
    }).then(res=>res.json()).then(d=>{
        if(d.success){
            updateCartDisplay(d.cart);
            modalBg.style.display='none';
            document.getElementById('miniCart').style.display='block';
        }
    });
}

document.getElementById("cartIcon").onclick=()=>document.getElementById("miniCart").style.display = document.getElementById("miniCart").style.display==="block"?"none":"block";
document.addEventListener("click",e=>{
    if(!document.getElementById("cartIcon").contains(e.target) && !document.getElementById("miniCart").contains(e.target))
        document.getElementById("miniCart").style.display="none";
});
document.getElementById("hamburger").onclick=()=>document.getElementById("nav-links").classList.toggle("active");
</script>

</body>
</html>




