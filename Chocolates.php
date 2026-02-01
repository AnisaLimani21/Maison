<?php
session_start();
include_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

$names = ["Dark Chocolate", "Milk Chocolate", "White Chocolate", "Hazelnut Chocolate"];
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
<title>Chocolates</title>
<link rel="stylesheet" href="Chocolates.css">
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

<div class="mini-cart" id="miniCart">
    <h4>Your Cart</h4>
    <ul id="cartItems"></ul>
    <p>Total: $<span id="totalPrice">0</span></p>
    <a href="save_cart.php" class="go-cart-btn">Go to Cart</a>
</div>
<header class="header">
    <h1>Our Chocolates</h1>
</header>

<div class="chocolate-display">

    <div class="main-photo">
        <img id="mainImg" src="<?= $first['image'] ?>">
    </div>

    <div class="chocolate-info">
        <h2 id="pName"><?= $first['name'] ?></h2>
        <p id="pPrice"><?= number_format($first['price'],2) ?> €</p>
        <p id="pDesc"><?= htmlspecialchars($first['description']) ?></p>

        <div class="quantity-box">
            <button class="qty-btn" onclick="changeQty(-1)">-</button>
            <input type="number" id="qty" value="1" min="1" max="20">
            <button class="qty-btn" onclick="changeQty(1)">+</button>
        </div>

        <button id="addToCartBtn">Add to Cart</button>
    </div>

    <div class="thumbnails">
        <?php foreach($products as $p): ?>
            <img src="<?= $p['image'] ?>"
                 data-id="<?= $p['id'] ?>"
                 data-name="<?= $p['name'] ?>"
                 data-price="<?= $p['price'] ?>"
                 data-desc="<?= htmlspecialchars($p['description']) ?>">
        <?php endforeach; ?>
    </div>

</div>

<script>
let currentId = <?= $first['id'] ?>;

function changeQty(v){
    let q = document.getElementById('qty');
    let n = parseInt(q.value) + v;
    if(n>=1 && n<=20) q.value = n;
}

document.querySelectorAll('.thumbnails img').forEach(img=>{
    img.onclick = ()=>{
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
    fetch('', {
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
</script>

</body>
</html>
