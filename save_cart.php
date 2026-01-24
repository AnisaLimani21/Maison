<?php
session_start();


if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$host = "localhost";
$db = "maison";
$user = "root";
$pass = "";


$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if(empty($_SESSION['cart'])) {
    die("Cart is empty.");
}


$total_price = 0;
foreach($_SESSION['cart'] as $item){
    $total_price += $item['price'] * $item['qty'];
}


$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at) VALUES (?, ?, 'pending', NOW())");
$stmt->bind_param("id", $user_id, $total_price);
$stmt->execute();

$order_id = $stmt->insert_id;
$stmt->close();

$stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach($_SESSION['cart'] as $item){
    $product_id = $item['id'] ?? 0;
    $quantity = $item['qty'];
    $price = $item['price'];
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
    $stmt->execute();
}
$stmt->close();


unset($_SESSION['cart']);


header("Location: dashboard.php");
exit;
?>
