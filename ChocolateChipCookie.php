<?php
session_start();

$host = "localhost";
$db = "maison";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);


$product_name = "Chocolate Chip Cookie";

$stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
$stmt->bind_param("s", $product_name);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if(!$product) {
    die("Produkt nuk u gjet");
}


if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    $qty = intval($_POST['quantity']);
    if($qty < 1) $qty = 1;
    if($qty > 20) $qty = 20;

    $found = false;
    foreach($_SESSION['cart'] as &$item){
        if($item['name'] == $product['name']){
            $item['qty'] += $qty;
            $found = true;
            break;
        }
    }
    if(!$found){
        $_SESSION['cart'][] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'qty' => $qty
        ];
    }

    echo "<script>alert('{$product['name']} x$qty added to cart!'); window.location.href='chocolatechipcookie.php';</script>";
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
            echo "<li><img src='img/{$item['image']}' style='width:40px;height:30px;margin-right:5px;vertical-align:middle;'> {$item['name']} x{$item['qty']} - $".number_format($itemTotal,2)."</li>";
        }
        ?>
    </ul>
    <p id="totalPrice">Total: $<?php echo number_format($total,2); ?></p>
    <a href="#" class="go-cart-btn" id="goCartBtn">Go to Cart</a>
</div>

<section class="product-single">
    <div class="circle-box">
        <img src="img/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
    </div>
    <div class="product-details">
        <h2 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h2>
        <p class="price" data-unit-price="<?php echo $product['price']; ?>">$<?php echo number_format($product['price'],2); ?></p>
        <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>

        <h3>Ingredients:</h3>
        <ul>
            <?php
            $ingredients = explode(',', $product['ingredients'] ?? 'Flour,Butter,Sugar,Chocolate Chips');
            foreach($ingredients as $ing){
                echo "<li>".htmlspecialchars(trim($ing))."</li>";
            }
            ?>
        </ul>

        <form method="POST">
            <label for="quantity">Quantity:</label>
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

quantityInput.addEventListener('input', () => {
    let qty = parseInt(quantityInput.value);
    if(qty < 1) qty = 1;
    if(qty > 20) qty = 20;
    totalPriceEl.textContent = `Total: $${(price * qty).toFixed(2)}`;
});


const cartIcon = document.getElementById("cartIcon");
const miniCart = document.getElementById("miniCart");

cartIcon.addEventListener("click", (e) => {
    e.preventDefault();
    miniCart.style.display = miniCart.style.display === "block" ? "none" : "block";
});

document.addEventListener("click", (e) => {
    if (!cartIcon.contains(e.target) && !miniCart.contains(e.target)) {
        miniCart.style.display = "none";
    }
});


document.getElementById('goCartBtn').addEventListener('click', function(e){
    e.preventDefault();
    <?php if(isset($_SESSION['user_id'])): ?>
        window.location.href = 'dashboard.php';
    <?php else: ?>
        window.location.href = 'login.php';
    <?php endif; ?>
});
</script>

</body>
</html>
