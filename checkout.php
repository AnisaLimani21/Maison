<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
include_once 'database.php';

class User{
    private $conn;
    private $id;
    public $username;

    public function __construct($conn,$id){
        $this->conn=$conn;
        $this->id=$id;
        $this->loadData();
    }

    private function loadData(){
        $stmt=$this->conn->prepare("SELECT username FROM users WHERE id=:uid");
        $stmt->execute([':uid'=>$this->id]);
        $data=$stmt->fetch(PDO::FETCH_ASSOC);
        $this->username=$data['username']??'Guest';
    }
}

class Cart{
    private $conn;
    private $userId;
    public $items=[];
    public $totalAmount=0;

    public function __construct($conn,$userId){
        $this->conn=$conn;
        $this->userId=$userId;
        $this->loadItems();
    }

    private function loadItems(){
        $stmt=$this->conn->prepare("
            SELECT o.id AS order_id, p.name, p.image, oi.quantity, oi.price
            FROM orders o
            JOIN order_items oi ON oi.order_id=o.id
            JOIN products p ON p.id=oi.product_id
            WHERE o.user_id=:uid
        ");
        $stmt->execute([':uid'=>$this->userId]);
        $this->items=$stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->totalAmount=0;
        foreach($this->items as $item){
            $this->totalAmount += $item['quantity']*$item['price'];
        }
    }

    public function pay($paymentMethod){
        $stmt=$this->conn->prepare("
            UPDATE orders SET status='Paid', payment_method=:pm WHERE user_id=:uid
        ");
        $stmt->execute([':pm'=>$paymentMethod, ':uid'=>$this->userId]);
        return true;
    }
}

$db=new Database();
$conn=$db->getConnection();
$user=new User($conn,$_SESSION['user_id']);
$cart=new Cart($conn,$_SESSION['user_id']);
$paid=false;
if(isset($_POST['pay'])){
    $paymentMethod=$_POST['payment_method']??'Unknown';
    $paid=$cart->pay($paymentMethod);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - Maison Chocolate</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #fdf4ed;
    padding: 20px;
    color: #4b2e19;
}

.container {
    max-width: 900px;
    margin: 0 auto;
}

h1, h2 {
    color: #6b3e26;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #ffd88c;
    padding: 10px;
    text-align: center;
}

th {
    background: #fdf1e6;
    color: #6b3e26;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s;
}

.pay-btn {
    background: linear-gradient(135deg,#6b3e26,#e6c066);
    color: #fff;
}

.print-btn {
    background: #28a745;
    color: #fff;
    margin-top: 15px;
}

.home-btn {
    background: #6b3e26;
    color: #fff;
    margin-top: 10px;
}

.payment-method {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ffd88c;
    width: 200px;
}

#invoice {
    background: #fffaf3;
    padding: 20px;
    border-radius: 12px;
}

#invoice h2 {
    text-align: center;
}

.product-img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 6px;
}

#invoice p, #invoice table {
    margin-bottom: 15px;
}
</style>
</head>
<body>
<div class="container">
<h1>Checkout - Welcome <?= htmlspecialchars($user->username) ?></h1>

<?php if(!empty($cart->items) && !$paid): ?>
<form method="POST">
<table>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>
<?php foreach($cart->items as $item): ?>
<tr>
<td><?= htmlspecialchars($item['name']) ?></td>
<td><?= $item['quantity'] ?></td>
<td>$<?= number_format($item['price'],2) ?></td>
<td>$<?= number_format($item['quantity']*$item['price'],2) ?></td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="3"><strong>Total Amount</strong></td>
<td><strong>$<?= number_format($cart->totalAmount,2) ?></strong></td>
</tr>
</table>

<label>Payment Method:</label>
<select name="payment_method" class="payment-method" required>
<option value="Credit Card">Credit Card</option>
<option value="PayPal">PayPal</option>
<option value="Cash">Cash</option>
</select>

<br><br>
<button type="submit" name="pay" class="pay-btn">Pay Now</button>
</form>

<?php elseif(!empty($cart->items) && $paid): ?>
<h2>Payment Successful!</h2>
<p>Total Paid: $<?= number_format($cart->totalAmount,2) ?></p>

<div id="invoice">
<div style="text-align:center; margin-bottom:20px;">
<img src="img/logoP.png" alt="Maison Chocolate" style="width:120px;">
<h2>Maison Chocolate Invoice</h2>
</div>

<p><strong>Customer:</strong> <?= htmlspecialchars($user->username) ?><br>
<strong>Date:</strong> <?= date('d-m-Y H:i') ?><br>
<strong>Payment Method:</strong> <?= htmlspecialchars($paymentMethod) ?></p>

<table>
<tr>
<th>Product</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>
<?php foreach($cart->items as $item): ?>
<tr>
<td><?= htmlspecialchars($item['name']) ?></td>
<td><?= $item['quantity'] ?></td>
<td>$<?= number_format($item['price'],2) ?></td>
<td>$<?= number_format($item['quantity']*$item['price'],2) ?></td>
</tr>
<?php endforeach; ?>
<tr>
<td colspan="3"><strong>Total Amount</strong></td>
<td><strong>$<?= number_format($cart->totalAmount,2) ?></strong></td>
</tr>
</table>

<p style="text-align:center; margin-top:20px; font-size:14px;">Thank you for your purchase! Maison Chocolate &copy; <?= date('Y') ?></p>
</div>

<button onclick="printInvoice()" class="print-btn">Print Invoice</button>
<form action="homee.php" method="get">
<button type="submit" class="home-btn">Go to Home</button>
</form>

<script>
function printInvoice(){
var content=document.getElementById('invoice').innerHTML;
var mywindow=window.open('','Print','height=800,width=900');
mywindow.document.write('<html><head><title>Invoice</title>');
mywindow.document.write('<style>body{font-family:Arial,sans-serif;color:#4b2e19;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ffd88c;padding:10px;text-align:center;} th{background:#fdf1e6;color:#6b3e26;}</style>');
mywindow.document.write('</head><body>');
mywindow.document.write(content);
mywindow.document.write('</body></html>');
mywindow.document.close();
mywindow.focus();
mywindow.print();
mywindow.close();
}
</script>

<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>
</div>
</body>
</html>
