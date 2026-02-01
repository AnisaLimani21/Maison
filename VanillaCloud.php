<?php 
session_start();
include_once 'database.php'; 

$db = new Database();
$conn = $db->getConnection(); 

$product_name = "Vanilla Cloud";

$stmt = $conn->prepare("SELECT * FROM products WHERE name = :name");
$stmt->execute(['name' => $product_name]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product) die("Produkt nuk u gjet");

if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $qty = intval($_POST['quantity']);
    if($qty < 1) $qty = 1;
    if($qty > 20) $qty = 20;

    $found = false;
    foreach($_SESSION['cart'] as &$item){
        if($item['id'] == $product['id']){
            $item['qty'] += $qty; 
            $found = true;
            break;
        }
    }
    if(!$found){
        $_SESSION['cart'][] = [
            'id' => $product['id'],  
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'qty' => $qty
        ];
    }

    $total = 0;
    foreach($_SESSION['cart'] as $item) $total += $item['price']*$item['qty'];

    echo json_encode([
        'success'=>true,
        'cart_count'=>count($_SESSION['cart']),
        'cart'=>$_SESSION['cart'],
        'total'=>$total
    ]);
    exit;
}

$cart_count = count($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($product['name']); ?></title>
<link rel="stylesheet" href="ChocolateChipCookie.css">
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
    <ul id="cartItems">
        <?php
        $total = 0;
        foreach($_SESSION['cart'] as $item){
            $itemTotal = $item['price'] * $item['qty'];
            $total += $itemTotal;
            $imageURL = htmlspecialchars($item['image']);
            echo "<li><img src='$imageURL' style='width:40px;height:30px;'> {$item['name']} x{$item['qty']} - $".number_format($itemTotal,2)."</li>";
        }
        ?>
    </ul>
    <p>Total: $<span id="totalPrice"><?php echo number_format($total,2); ?></span></p>
    <a href="save_cart.php" class="go-cart-btn" id="goCartBtn">Go to Cart</a>
</div>

<section class="product-single">
    <div class="circle-box">
        <?php
        $imagePath = $product['image']; 
        if(file_exists($imagePath)) echo "<img src='$imagePath'>";
        else echo "<p style='color:red;'>Foto nuk u gjet</p>";
        ?>
    </div>

    <div class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="price" data-unit-price="<?php echo $product['price']; ?>">$<?php echo number_format($product['price'],2); ?></p>
        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>

        <h3>Ingredients:</h3>
        <ul>
            <?php foreach(explode(',', $product['ingredients'] ?? 'Soft Vanilla Batter,White Chocolate Chips,Butter,Milk,Vanilla Extract,Whipped Cream') as $ing) echo "<li>".htmlspecialchars(trim($ing))."</li>"; ?>
        </ul>

        <form id="addCartForm">
            <label>Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="20">
            <p class="total-price">Total: $<?php echo number_format($product['price'],2); ?></p>
            <button type="submit" id="add-to-cart">Add to Cart</button>
        </form>
    </div>
</section>

<script>
const quantityInput = document.getElementById('quantity');
const price = <?php echo $product['price']; ?>;
const totalPriceEl = document.querySelector('.total-price');
const cartCountEl = document.getElementById('cartCount');
const cartItemsEl = document.getElementById('cartItems');
const totalPriceSpan = document.getElementById('totalPrice');

quantityInput.addEventListener('input', () => {
    let qty = parseInt(quantityInput.value);
    if(qty < 1) qty = 1;
    if(qty > 20) qty = 20;
    totalPriceEl.textContent = `Total: $${(price * qty).toFixed(2)}`;
});

document.getElementById('addCartForm').addEventListener('submit', function(e){
    e.preventDefault();
    let qty = parseInt(quantityInput.value);

    fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add_to_cart&quantity=${qty}`
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            cartCountEl.textContent = data.cart_count;
            cartItemsEl.innerHTML = '';
            data.cart.forEach(item => {
                let li = document.createElement('li');
                li.innerHTML = `<img src="${item.image}" style="width:40px;height:30px;"> ${item.name} x${item.qty} - $${(item.price*item.qty).toFixed(2)}`;
                cartItemsEl.appendChild(li);
            });
            totalPriceSpan.textContent = data.total.toFixed(2);
        }
    });
});

const cartIcon = document.getElementById("cartIcon");
const miniCart = document.getElementById("miniCart");
cartIcon.addEventListener("click", e => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});
document.addEventListener("click", e => {
    if(!cartIcon.contains(e.target) && !miniCart.contains(e.target)) miniCart.style.display = "none";
});
</script>

</body>
</html>
