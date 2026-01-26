<?php
session_start();

include_once 'database.php';
include_once 'user.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=dashboard.php");
    exit;
}

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Cart is empty!");
}

$db = new Database();
$conn = $db->getConnection();
$userManager = new UserManager($conn);
$userId = $_SESSION['user_id'];

$finalCart = [];
foreach($_SESSION['cart'] as $item){
    if(isset($finalCart[$item['name']])){
        $finalCart[$item['name']]['qty'] += $item['qty'];
    } else {
        $finalCart[$item['name']] = $item;
    }
}


$totalPrice = 0;
foreach($finalCart as $item){
    $totalPrice += $item['price'] * $item['qty'];
}


$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at) VALUES (:uid, :total, 'pending', NOW())");
$stmt->bindParam(':uid', $userId);
$stmt->bindParam(':total', $totalPrice);
$stmt->execute();

$orderId = $conn->lastInsertId();


$stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:oid, :pid, :qty, :price)");
foreach($finalCart as $item){
    $stmtItem->bindParam(':oid', $orderId);
    $stmtItem->bindParam(':pid', $item['id']);
    $stmtItem->bindParam(':qty', $item['qty']);
    $stmtItem->bindParam(':price', $item['price']);
    $stmtItem->execute();
}

unset($_SESSION['cart']);


header("Location: dashboard.php?order_success=1");
exit;
?>
