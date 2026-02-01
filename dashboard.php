<?php
session_start();
include_once 'database.php';

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=:uid");
$stmt->execute([':uid'=>$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT o.id AS order_id, p.id AS product_id, p.name, p.image, oi.quantity, oi.price 
                        FROM orders o
                        JOIN order_items oi ON oi.order_id=o.id
                        JOIN products p ON p.id=oi.product_id
                        WHERE o.user_id=:uid");
$stmt->execute([':uid'=>$userId]);
$itemsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allProducts = [];
$totalAmount = 0;
foreach($itemsRaw as $item){
    $pid = $item['product_id'];
    if(isset($allProducts[$pid])){
        $allProducts[$pid]['quantity'] += $item['quantity'];
    } else {
        $allProducts[$pid] = [
            'name'=>$item['name'],
            'image'=>$item['image'],
            'quantity'=>$item['quantity'],
            'price'=>$item['price']
        ];
    }
    $totalAmount += $item['quantity'] * $item['price'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Maison Chocolate</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fdf4ed;
    margin: 0;
    padding: 0;
}

.dashboard-container {
    max-width: 900px;
    margin: 30px auto;
    padding: 20px;
}

h1,
h2 {
    color: #6b3e26;
    text-align: center;
}

.logout-btn {
    background: #6b3e26;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    display: block;
    margin: 0 auto 20px auto;
}

.logout-btn:hover {
    background: #4d2d1a;
}

.products-scroll-wrapper {
    position: relative;
    max-height: 450px;
    overflow: hidden;
    border: 2px solid #ffd88c;
    border-radius: 15px;
    padding: 40px 0;
    margin-bottom: 20px;
}

.products-scroll {
    max-height: 450px;
    overflow-y: scroll;
    padding: 10px 20px;
    scrollbar-width: none;
}

.products-scroll::-webkit-scrollbar {
    display: none;
}

.scroll-btn {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: #6b3e26;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin: 0 auto;
    opacity: 0.9;
    transition: 0.3s;
}

.scroll-btn:hover {
    opacity: 1;
}

.up-btn {
    margin-bottom: 10px;
}

.down-btn {
    margin-top: 10px;
}

.product-card {
    background: linear-gradient(145deg, #fff, #ffeef0);
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.product-card table {
    width: 100%;
    border-collapse: collapse;
}

.product-card th,
.product-card td {
    border: 1px solid #ffd88c;
    padding: 8px;
    text-align: center;
}

.product-card th {
    background: #fdf1e6;
    color: #6b3e26;
}

.product-img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
}

.qty-form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.qty-input {
    width: 60px;
    padding: 6px;
    border-radius: 10px;
    border: 2px solid #ffd88c;
    text-align: center;
    font-weight: 600;
    color: #4b2e19;
    background: #fffaf3;
}

.qty-input:focus {
    border-color: #e6c066;
    box-shadow: 0 0 6px rgba(230, 192, 102, 0.4);
}

.update-btn {
    background: linear-gradient(135deg, #6b3e26, #e6c066);
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 10px;
    cursor: pointer;
}

.update-btn:hover {
    background: linear-gradient(135deg, #4d2d1a, #d4a64d);
}

.delete-btn {
    background: #dc3545;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 10px;
    cursor: pointer;
}

.delete-btn:hover {
    background: #a71d2a;
}

.total-box {
    background: #fffaf3;
    padding: 15px;
    border-radius: 15px;
    text-align: center;
    font-weight: bold;
    color: #4b2e19;
    margin-top: 20px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.cart-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.continue-btn,
.checkout-btn,
.clear-btn {
    border: none;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
}

.continue-btn {
    background: linear-gradient(135deg, #6b3e26, #e6c066);
    color: #fff;
}

.checkout-btn {
    background: #28a745;
    color: #fff;
}

.clear-btn {
    background: #dc3545;
    color: #fff;
}

</style>
</head>
<body>

<div class="dashboard-container">
<h1>Welcome, <?= htmlspecialchars($userData['username']) ?>!</h1>
<p style="text-align:center; font-weight:600; color:#6b3e26;">Your role: <?= htmlspecialchars($userData['role']) ?></p>
<form action="logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
</form>


<h2>Your Products</h2>

<button class="scroll-btn up-btn">&#9650;</button> 
<div class="products-scroll-wrapper">
    <div class="products-scroll">
    <?php if($allProducts): ?>
        <?php foreach($allProducts as $pid=>$item): ?>
            <div class="product-card">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <table>
                    <tr>
                        <th>Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <td>
                            <?php if(!empty($item['image']) && file_exists($item['image'])): ?>
                                <img src="<?= htmlspecialchars($item['image']) ?>" class="product-img" alt="<?= htmlspecialchars($item['name']) ?>">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" class="qty-form">
                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                                <input type="hidden" name="product_id" value="<?= $pid ?>">
                                <input type="hidden" name="action" value="update_qty">
                                <button type="submit" class="update-btn">Update</button>
                            </form>
                        </td>
                        <td>$<?= number_format($item['quantity']*$item['price'],2) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $pid ?>">
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">Your cart is empty.</p>
    <?php endif; ?>
    </div>
</div>
<button class="scroll-btn down-btn">&#9660;</button> 

<?php if($allProducts): ?>
<div class="total-box">
    <p>Total Products: <?= count($allProducts) ?></p>
    <p>Total Amount: $<?= number_format($totalAmount,2) ?></p>
    <div class="cart-actions">
        <form action="homee.php" method="get"><button type="submit" class="continue-btn">Continue Shopping</button></form>
        <form action="checkout.php" method="get"><button type="submit" class="checkout-btn">Checkout</button></form>
        <form method="POST"><input type="hidden" name="action" value="clear_cart"><button type="submit" class="clear-btn">Clear Cart</button></form>
    </div>
</div>
<?php endif; ?>

</div>

<script>
const scrollContainer = document.querySelector('.products-scroll');
document.querySelector('.up-btn').onclick = ()=> { scrollContainer.scrollBy({top:-150, behavior:'smooth'}); };
document.querySelector('.down-btn').onclick = ()=> { scrollContainer.scrollBy({top:150, behavior:'smooth'}); };
</script>

</body>
</html>
