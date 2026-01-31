<!DOCTYPE html>
<html>
<head>
    <title>Product Dashboard</title>
</head>
    <link rel="stylesheet" href="pDashboard.css">

<body>

<h2>Products</h2>
<a href="addProduct.php">Add Product</a>

<table border="1">
    <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>CATEGORY</th>
        <th>DESCRIPTION</th>
        <th>PRICE</th>
        <th>IMAGE</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

<?php
session_start();
if(!isset($_SESSION['user'])||$_SESSION['user']['role']!== 'admin'){
    header("Location: homee.php");
    exit;
}
include_once 'adminGuard.php';
include_once 'ProductRepository.php';
include_once 'database.php';
$db = new Database();
$conn = $db->getConnection();

try {
    $db = new PDO('mysql:host=localhost;dbname=maison;charset=utf8mb4', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


$productRepo = new ProductRepository();
$products = $productRepo->getAllProducts();

$stmt= $db->query(
    "SELECT m.*, u.username
    FROM messages m
    LEFT JOIN users u ON m.user_id=u.id
    ORDER BY m.created_at DESC"
);
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($products as $product) {
    echo '
    <tr>
        <td>'.$product['id'].'</td>
        <td>'.$product['name'].'</td>
        <td>'.$product['category'].'</td>
        <td>'.$product['description'].'</td>
        <td>'.$product['price'].'</td>
        <td>'.$product['image'].'</td>
        <td><a href="editProduct.php?id='.$product['id'].'">Edit</a></td>
        <td><a href="deleteProduct.php?id='.$product['id'].'">Delete</a></td>
    </tr>';
}
?>

</table>
<hr>
<h2>Contact Messages</h2>
<?php
if ($messages) {
    foreach ($messages as $msg) {
        echo '<div style="border:1px solid #ccc; padding:10px; margin-bottom:10px">';
        echo '<b>' . htmlspecialchars($msg['name']) . '</b> (' . htmlspecialchars($msg['email']) . ')<br>';

        if ($msg['user_id']) {
            echo '<small>User: <b>' . htmlspecialchars($msg['username']) . '</b></small><br>';
        } else {
            echo '<small>Guest</small><br>';
        }

        echo '<p>' . nl2br(htmlspecialchars($msg['message'])) . '</p>';
        echo '<small>' . $msg['created_at'] . '</small>';
        echo '</div>';
    }
}
?>
</body>
</html>
