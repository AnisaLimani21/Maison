<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

$names = ["Classic Cheesecake", "Strawberry Cheesecake", "Blueberry Cheesecake", "Chocolate Cheesecake", "Caramel Cheesecake", "Lemon Cheesecake", "Raspberry Cheesecake", "Oreo Cheesecake", "Matcha Cheesecake"];
$products = [];
foreach ($names as $name) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name = :name");
    $stmt->execute(['name' => $name]);
    if ($p = $stmt->fetch(PDO::FETCH_ASSOC)) $products[] = $p;
}
if (!$products) die("Produktet nuk u gjetën");

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $id = intval($_POST['id']);
    $qty = max(1, min(20, intval($_POST['quantity'])));
    $found = false;

    foreach ($products as $p) {
        if ($p['id'] == $id) {
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $id) {
                    $item['qty'] += $qty;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id'=>$p['id'],
                    'name'=>$p['name'],
                    'price'=>$p['price'],
                    'image'=>$p['image'],
                    'qty'=>$qty
                ];
            }
            break;
        }
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $i) $total += $i['price'] * $i['qty'];

    echo json_encode([
        'success'=>true,
        'cart_count'=>count($_SESSION['cart']),
        'cart'=>$_SESSION['cart'],
        'total'=>$total
    ]);
    exit;
}

$first = $products[0];
$cart_count = count($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cheesecakes</title>
<link rel="stylesheet" href="Chocolates.css">
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
    padding: 15px 30px;
    background: #6b3e26;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    position: relative;
    z-index: 1000;
}

.nav-left { display: flex; align-items: center; }
.logo { width: 70px; }

.nav-center {
    display: flex;
    gap: 30px;
    justify-content: center;
    align-items: center;
    flex: 1;
}
.nav-center a {
    text-decoration: none;
    color: #fff;
    font-weight: 600;
    transition: 0.3s;
}
.nav-center a:hover { color: #ffd88c; }

.nav-right { 
    display: flex; 
    align-items: center; 
    gap: 15px; 
    position: relative; 
}

.search-bar {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1px solid #ffd88c;
    border-radius: 20px;
    padding: 2px 10px;
}
.search-bar input { 
    border: none; 
    outline: none; 
    padding: 5px; 
    background: none;
}
.search-bar button { 
    border: none; 
    background: none; 
    font-size: 18px; 
    cursor: pointer; 
}

.login-btn img, .cart-icon img { 
    width: 30px; 
    height: 30px; 
    filter: invert(100%); 
    transition: 0.3s; 
}
.login-btn img:hover, .cart-icon img:hover { 
    filter: invert(85%) sepia(100%) saturate(500%) hue-rotate(30deg); 
}

.hamburger { display: none; font-size: 28px; color: white; cursor: pointer; }

.cart-icon { position: relative; cursor: pointer; }
.cart-count {
    position: absolute;
    top: 0;
    right: 0;
    transform: translate(50%, -50%);
    background: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 50%;
}


.mini-cart { 
    position: absolute; 
    top: 50px; 
    right: 0; 
    background: #fff8f2; 
    border: 2px solid #6b3e26; 
    padding: 20px; 
    border-radius: 10px; 
    box-shadow: 0 5px 15px rgba(0,0,0,0.3); 
    display: none; 
    width: 300px; 
    z-index: 2000; 
}
.mini-cart h4 { 
    margin-bottom: 10px; 
    color: #6b3e26; 
}
.mini-cart ul { 
    list-style: none; 
    padding: 0; 
    max-height: 200px; 
    overflow-y: auto; 
}
.mini-cart ul li { 
    margin-bottom: 8px; 
    font-size: 14px; 
    color: #333; 
    display: flex; 
    align-items: center; 
}
.mini-cart ul li img { margin-right: 10px; }
#totalPrice { 
    font-weight: bold; 
    margin-top: 10px; 
    color: #6b3e26; 
}
.go-cart-btn { 
    display: block; 
    margin-top: 10px; 
    text-align: center; 
    background-color: #6b3e26; 
    color: #fff; 
    padding: 8px 0; 
    border-radius: 6px; 
    text-decoration: none; 
    transition: 0.3s; 
}
.go-cart-btn:hover { background-color: #855c3a; }


.header { 
    text-align: center; 
    padding: 30px 0; 
}
.header h1 { 
    color: #6b3e26; 
}


.cheesecake-display { 
    display:flex; 
    gap:20px; 
    margin:20px; 
    justify-content:center; 
    flex-wrap:wrap; 
    position:relative; 
}

.main-photo-wrapper {
    position: relative;
    width: 350px;
    height: 350px;
}
.main-photo {
    width:350px; 
    height:350px; 
    border-radius:20px; 
    overflow:hidden; 
    position:relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.main-photo img {
    width:200px; 
    height:200px; 
    object-fit:contain; 
    transition: transform 0.4s ease;
}

.miniatures {
    position: absolute;
    top:50%;
    left:50%;
    width: 400px;
    height: 400px;
    transform: translate(-50%, -50%);
    pointer-events:none; 
}
.miniatures img {
    width:90px;
    height:90px;
    object-fit:cover;
    border:3px solid #d88f2f;
    border-radius:50%;
    cursor:pointer;
    position:absolute;
    transition:0.3s;
    pointer-events:auto;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
}
.miniatures img:hover {
    transform: scale(1.05);
    border-color:#ffd88c;
}

.m1{top:0; left:50%; transform:translateX(-50%);}
.m2{top:15%; right:0; transform:translateY(-50%);}
.m3{top:50%; right:0; transform:translateY(-50%);}
.m4{bottom:15%; right:0; transform:translateY(50%);}
.m5{bottom:0; left:50%; transform:translateX(-50%);}
.m6{bottom:15%; left:0; transform:translateY(50%);}
.m7{top:50%; left:0; transform:translateY(-50%);}
.m8{top:15%; left:0; transform:translateY(-50%);}

.cheesecake-info { 
    margin-top:70px;    
    text-align:left;  
    margin-left:50px;   
}
.cheesecake-info h2 { font-size:28px; color:#333; }

.price-add { 
    display:flex; 
    align-items:center; 
    gap:20px; 
    justify-content:center; 
    margin-top:10px; 
}
#cakePrice { font-size:22px; color:#555; margin:0; }

#addToCartBtn { 
    background-color:#6b3e26; 
    color:#fff; 
    border:none; 
    padding:10px 20px; 
    font-size:16px; 
    border-radius:8px; 
    cursor:pointer; 
    transition: all 0.3s ease; 
}
#addToCartBtn:hover { background-color:#855c3a; transform: scale(1.05); }

.quantity-box {
    display: flex;
    align-items: center;
    gap: 5px;
}
.quantity-box input {
    width: 50px;
    text-align: center;
    font-size: 16px;
    padding: 5px;
}
.quantity-box button {
    padding: 5px 10px;
    cursor: pointer;
    background-color: #6b3e26;
    color: white;
    border: none;
    border-radius: 5px;
}
.quantity-box button:hover { background-color:#855c3a; }


@media screen and (max-width: 768px) {
    .cheesecake-info {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        max-width: 90%;
        margin: 20px 10px 50px 10px;
        padding: 0 10px;    
    }
    
    .price-add {
        flex-direction: column;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    #cakePrice { font-size: 20px; }
    #addToCartBtn { width: 80%; padding: 12px 0; font-size: 18px; }

    .miniatures img { width:70px; height:70px; }
    .main-photo { width:250px; height:250px; }
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
        <a href="login.php" class="login-btn"><img src="https://img.icons8.com/ios/50/user--v1.png" alt="Login"></a>
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
    <p>Total: $<span id="totalPrice">0</span></p>
    <a href="save_cart.php" class="go-cart-btn">Go to Cart</a>
</div>

<header class="header">
    <h1>Cheesecakes</h1>
</header>

<section class="cheesecake-display">
    <div class="main-photo-wrapper">
        <div class="main-photo">
            <img id="mainCake" src="<?= $first['image'] ?>" alt="<?= $first['name'] ?>">
        </div>
        <div class="miniatures">
            <?php foreach($products as $i=>$p): ?>
                <img class="m<?= $i+1 ?>" src="<?= $p['image'] ?>"
                     data-id="<?= $p['id'] ?>"
                     data-name="<?= $p['name'] ?>"
                     data-price="<?= $p['price'] ?>">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="cheesecake-info">
        <h2 id="cakeName"><?= $first['name'] ?></h2>
        <div class="price-add">
            <span id="cakePrice" data-unit-price="<?= $first['price'] ?>"><?= number_format($first['price'],2) ?> €</span>
            <div class="quantity-box">
                <button onclick="changeQty(-1)">-</button>
                <input type="number" id="qty" value="1" min="1" max="20">
                <button onclick="changeQty(1)">+</button>
            </div>
            <button id="addToCartBtn">Add to Cart 🛒</button>
        </div>
    </div>
</section>

<script>
let currentId = <?= $first['id'] ?>;

function changeQty(v){
    let q = document.getElementById('qty');
    let n = parseInt(q.value) + v;
    if(n>=1 && n<=20) q.value = n;
}

document.querySelectorAll('.miniatures img').forEach(img=>{
    img.onclick = ()=>{
        document.getElementById('mainCake').src = img.src;
        document.getElementById('cakeName').innerText = img.dataset.name;
        document.getElementById('cakePrice').innerText = parseFloat(img.dataset.price).toFixed(2)+' €';
        document.getElementById('cakePrice').dataset.unitPrice = img.dataset.price;
        currentId = img.dataset.id;
        document.getElementById('qty').value = 1;
    }
});

document.getElementById('addToCartBtn').onclick = ()=>{
    let qty = parseInt(document.getElementById('qty').value);
    fetch('', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=add_to_cart&id=${currentId}&quantity=${qty}`
    })
    .then(res=>res.json())
    .then(d=>{
        if(d.success){
            document.getElementById('cartCount').innerText = d.cart_count;
            let ul = document.getElementById('cartItems');
            ul.innerHTML = '';
            d.cart.forEach(i=>{
                let li = document.createElement('li');
                li.innerHTML = `<img src="${i.image}" style="width:40px;height:30px;"> ${i.name} x${i.qty} - $${(i.price*i.qty).toFixed(2)}`;
                ul.appendChild(li);
            });
            document.getElementById('totalPrice').textContent = d.total.toFixed(2);
            document.getElementById('miniCart').style.display='block';
        }
    });
};

document.getElementById('cartIcon').onclick = e=>{
    e.preventDefault();
    let m = document.getElementById('miniCart');
    m.style.display = m.style.display==='block'?'none':'block';
};

document.addEventListener("click", e=>{
    let m = document.getElementById('miniCart');
    let c = document.getElementById('cartIcon');
    if(!c.contains(e.target) && !m.contains(e.target)) m.style.display='none';
});
</script>

</body>
</html>




