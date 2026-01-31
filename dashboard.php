<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include_once 'database.php';

$db = new Database();
$conn = $db->getConnection();
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = :uid");
$stmt->bindParam(':uid', $userId);
$stmt->execute();
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = intval($_POST['product_id'] ?? 0);

    if($action === 'update_qty' && $productId > 0) {
        $newQty = max(1,intval($_POST['quantity']));
        $stmt2 = $conn->prepare("SELECT id FROM order_items WHERE product_id=:pid AND order_id IN (SELECT id FROM orders WHERE user_id=:uid)");
        $stmt2->execute([':pid'=>$productId, ':uid'=>$userId]);
        $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        if(count($items) > 0) {
            $stmt3 = $conn->prepare("UPDATE order_items SET quantity=:qty WHERE id=:oid");
            $stmt3->execute([':qty'=>$newQty, ':oid'=>$items[0]['id']]);

            for($i=1;$i<count($items);$i++){
                $stmtDel = $conn->prepare("DELETE FROM order_items WHERE id=:oid");
                $stmtDel->execute([':oid'=>$items[$i]['id']]);
            }
        }

        header("Location: dashboard.php");
        exit;
    }

    if($action === 'delete' && $productId > 0) {
        $stmt2 = $conn->prepare("DELETE FROM order_items WHERE product_id=:pid AND order_id IN (SELECT id FROM orders WHERE user_id=:uid)");
        $stmt2->execute([':pid'=>$productId, ':uid'=>$userId]);
        header("Location: dashboard.php");
        exit;
    }

    if($action === 'clear_cart') {
        $stmtClear = $conn->prepare("DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id=:uid)");
        $stmtClear->execute([':uid'=>$userId]);
        header("Location: dashboard.php");
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=:uid");
$stmt->execute([':uid'=>$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$allProducts = [];
$totalAmount = 0;
foreach ($orders as $order) {
    $stmt2 = $conn->prepare("
        SELECT p.id AS product_id, p.name, p.image, oi.quantity, oi.price
        FROM order_items oi
        JOIN products p ON oi.product_id=p.id
        WHERE oi.order_id=:oid
    ");
    $stmt2->execute([':oid'=>$order['id']]);
    $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    foreach($items as $item){
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
    max-width: 1200px; 
    margin: 50px auto; 
    padding: 20px; 
}
h1,h2 { color: #6b3e26; }
button, .update-btn, .delete-btn, .checkout-btn, .clear-btn, .continue-btn {
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.total-box {
    background: #fffaf3;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-align: center;
    font-size: 18px;
    color: #4b2e19;
}

.cart-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-top: 15px;
}
.continue-btn {
    background: linear-gradient(135deg,#6b3e26,#e6c066);
    color: #fff;
    border: none;
    padding: 12px 25px;
}
.continue-btn:hover {
    background: linear-gradient(135deg,#4d2d1a,#d4a64d);
}
.checkout-btn {
    background: #28a745;
    color: #fff;
    border: none;
    padding: 12px 25px;
}
.checkout-btn:hover { background: #1e7e34; }
.clear-btn {
    background: #dc3545;
    color: #fff;
    border: none;
    padding: 12px 25px;
}
.clear-btn:hover { background: #a71d2a; }

.product-card {
    background: linear-gradient(145deg, #fff, #ffeef0);
    padding: 20px;
    margin-bottom: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    transition: transform 0.3s, box-shadow 0.3s;
}
.product-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
}
.product-card table { 
    width: 100%; 
    border-collapse: collapse; 
    margin-top: 15px; 
}
.product-card th, .product-card td { 
    border:1px solid #ffd88c; 
    padding: 10px; 
    text-align:center; 
}
.product-card th { background: #fdf1e6; color: #6b3e26; }

.product-img { 
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 8px; 
    cursor: pointer; 
}

.qty-form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}
.qty-input {
    width: 60px;
    padding: 8px 10px;
    border-radius: 12px;
    border: 2px solid #ffd88c;
    outline: none;
    text-align: center;
    font-weight: 600;
    color: #4b2e19;
    background: #fffaf3;
    transition: 0.3s;
}
.qty-input:focus {
    border-color: #e6c066;
    box-shadow: 0 0 8px rgba(230,192,102,0.4);
}
.update-btn {
    background: linear-gradient(135deg,#6b3e26,#e6c066);
    color: #fff;
    border: none;
    padding: 8px 15px;
}
.update-btn:hover {
    background: linear-gradient(135deg,#4d2d1a,#d4a64d);
}

.delete-btn {
    background: #dc3545;
    color: #fff;
    border: none;
    padding: 8px 15px;
}
.delete-btn:hover { background: #a71d2a; }

.logout-btn {
    background: #6b3e26;
    color: #fff;
    padding: 10px 20px;
    border: none;
    margin-bottom: 15px;
}
.logout-btn:hover { background: #4d2d1a; }
</style>
</head>
<body>

<div class="dashboard-container">
<h1>Welcome, <?php echo htmlspecialchars($userData['username']); ?>!</h1>
<p>Your role: <?php echo htmlspecialchars($userData['role']); ?></p>

<form action="logout.php" method="POST">
    <button type="submit" class="logout-btn">Logout</button>
</form>

<h2>Your Products</h2>

<?php if($allProducts): ?>
    <?php foreach($allProducts as $pid => $item): ?>
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
                        <span>No Image</span>
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
                <td>$<?= number_format($item['quantity'] * $item['price'],2) ?></td>
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

    
    <div class="total-box">
        <p>Total Products: <?= count($allProducts) ?></p>
        <p>Total Amount: $<?= number_format($totalAmount,2) ?></p>
        <div class="cart-actions">
            <form action="homee.php" method="get">
                <button type="submit" class="continue-btn">Continue Shopping</button>
            </form>
            <form action="checkout.php" method="get">
                <button type="submit" class="checkout-btn">Proceed to Checkout</button>
            </form>
            <form method="POST">
                <input type="hidden" name="action" value="clear_cart">
                <button type="submit" class="clear-btn">Clear Cart</button>
            </form>
        </div>
    </div>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>

</div>

</body>
</html>
