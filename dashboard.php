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
    $orderItemId = intval($_POST['item_id'] ?? 0);
    
    if($action === 'update_qty' && $orderItemId > 0) {
        $newQty = intval($_POST['quantity']);
        if($newQty < 1) $newQty = 1;
        $stmt = $conn->prepare("UPDATE order_items SET quantity = :qty WHERE id = :oid");
        $stmt->execute([':qty'=>$newQty, ':oid'=>$orderItemId]);
        header("Location: dashboard.php");
        exit;
    }

    if($action === 'delete' && $orderItemId > 0) {
        $stmt = $conn->prepare("DELETE FROM order_items WHERE id = :oid");
        $stmt->execute([':oid'=>$orderItemId]);
        header("Location: dashboard.php");
        exit;
    }
}


$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->bindParam(':uid', $userId);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Maison Chocolate</title>
<style>
body { font-family: Arial, sans-serif; background:#f5f5f5; margin:0; padding:0; }
.dashboard-container { max-width:1200px; margin:50px auto; padding:20px;}
h1,h2 { color:#333; }
.product-card { background:#fff; padding:20px; margin-bottom:20px; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1);}
.product-card table { width:100%; border-collapse: collapse; margin-top:10px; }
.product-card th, .product-card td { border:1px solid #ddd; padding:8px; text-align:center; }
.product-card th { background:#f0f0f0; }
.product-img { width:60px; height:60px; object-fit:cover; border-radius:8px; }
button { padding:5px 10px; border:none; border-radius:6px; cursor:pointer; }
button.update { background: #4CAF50; color:white; }
button.delete { background: #f44336; color:white; }
form { display:inline-block; margin:0; }
</style>
</head>
<body>

<div class="dashboard-container">
<h1>Welcome, <?php echo htmlspecialchars($userData['username']); ?>!</h1>
<p>Your role: <?php echo htmlspecialchars($userData['role']); ?></p>
<form action="logout.php" method="POST" style="margin:15px 0;">
    <button type="submit" 
        style="
            background:#000;
            color:#fff;
            padding:10px 18px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-weight:bold;
        ">
        Logout
    </button>
</form>


<h2>Your Products</h2>

<?php if(!empty($orders)): ?>
    <?php foreach($orders as $order): ?>
        <?php
        $stmt2 = $conn->prepare("
            SELECT oi.id as order_item_id, oi.quantity, oi.price, p.name, p.image 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = :oid
        ");
        $stmt2->bindParam(':oid', $order['id']);
        $stmt2->execute();
        $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <?php foreach($items as $item): ?>
        <div class="product-card">
            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
            <table>
                <tr>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>
                        <?php if(!empty($item['image']) && file_exists($item['image'])): ?>
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" class="product-img" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" style="display:flex; justify-content:center;">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width:60px; margin-right:5px;">
                            <input type="hidden" name="item_id" value="<?php echo $item['order_item_id']; ?>">
                            <input type="hidden" name="action" value="update_qty">
                            <button type="submit" class="update">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($item['price'],2); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $item['order_item_id']; ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p>You have no products yet.</p>
<?php endif; ?>

</div>

<script>
window.history.pushState(null, null, window.location.href);
window.onpopstate = function () {
    window.location.href = "login.php";
};
</script>



</body>
</html>
