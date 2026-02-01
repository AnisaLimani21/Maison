<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

$names = ["Strawberry Boba", "Taro Boba", "Matcha Boba", "Brown Sugar Boba"];
$products = [];
foreach($names as $name){
    $stmt = $conn->prepare("SELECT * FROM products WHERE name = :name");
    $stmt->execute(['name'=>$name]);
    if($p = $stmt->fetch(PDO::FETCH_ASSOC)) $products[] = $p;
}

if(!$products) die("Produktet nuk u gjetën");

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['action']) && $_POST['action']==='add_to_cart'){
    $id = intval($_POST['id']);
    $qty = max(1, min(20, intval($_POST['quantity'])));
    $found = false;

    foreach($products as $p){
        if($p['id']==$id){
            foreach($_SESSION['cart'] as &$item){
                if($item['id']==$id){
                    $item['qty'] += $qty;
                    $found = true;
                    break;
                }
            }
            if(!$found){
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
    foreach($_SESSION['cart'] as $i) $total += $i['price']*$i['qty'];

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
            <span id="cartCount" class="cart-count"><?= $cart_count ?></span>
        </a>
        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div class="mini-cart" id="miniCart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p>Total: $<span id="totalPrice">0</span></p>
    <a href="save_cart.php" class="go-cart-btn">Go to Cart</a>
</div>

<header class="header">
    <h1>Our Boba Drinks</h1>
</header>

<div class="boba-display">
    <div class="main-photo-wrapper">
        <img id="mainImg" src="<?= $first['image'] ?>" alt="<?= $first['name'] ?>">
    </div>
    <div class="boba-info">
        <h2 id="pName"><?= $first['name'] ?></h2>
        <p id="pPrice"><?= number_format($first['price'],2) ?> €</p>
        <p id="pDesc"><?= htmlspecialchars($first['description']) ?></p>

        <div class="qty-box">
            <button onclick="changeQty(-1)">-</button>
            <input type="number" id="qty" value="1" min="1" max="20">
            <button onclick="changeQty(1)">+</button>
        </div>

        <button id="addToCartBtn">Add to Cart</button>

        <div class="boba-thumbnails">
            <?php foreach($products as $p): ?>
                <img src="<?= $p['image'] ?>"
                     data-id="<?= $p['id'] ?>"
                     data-name="<?= $p['name'] ?>"
                     data-price="<?= $p['price'] ?>"
                     data-desc="<?= htmlspecialchars($p['description']) ?>"
                     class="<?= $p['id']==$first['id'] ? 'active' : '' ?>">
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
let currentId = <?= $first['id'] ?>;

function changeQty(v){
    let q = document.getElementById('qty');
    let n = parseInt(q.value) + v;
    if(n>=1 && n<=20) q.value = n;
}

document.querySelectorAll('.boba-thumbnails img').forEach(img=>{
    img.onclick = ()=>{
        document.querySelectorAll('.boba-thumbnails img').forEach(t=>t.classList.remove('active'));
        img.classList.add('active');
        document.getElementById('mainImg').src = img.src;
        document.getElementById('pName').innerText = img.dataset.name;
        document.getElementById('pPrice').innerText = parseFloat(img.dataset.price).toFixed(2)+' €';
        document.getElementById('pDesc').innerText = img.dataset.desc;
        currentId = img.dataset.id;
        document.getElementById('qty').value = 1;
    }
});

document.getElementById('addToCartBtn').onclick = ()=>{
    let qty = parseInt(document.getElementById('qty').value);
    fetch('',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=add_to_cart&id=${currentId}&quantity=${qty}`
    })
    .then(r=>r.json())
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
            document.getElementById('totalPrice').innerText = d.total.toFixed(2);
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

const hamburger=document.getElementById("hamburger");
const navLinks=document.getElementById("nav-links");
hamburger.onclick=()=>{navLinks.classList.toggle("active");};
</script>

</body>
</html>
