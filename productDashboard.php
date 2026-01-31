<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: homee.php");
    exit;
}

require_once 'database.php';
require_once 'ProductRepository.php';
require_once 'MessageRepository.php';
require_once 'PDashboardController.php';

$db = (new Database())->getConnection();

$controller = new PDashboardController(
    new ProductRepository($db),
    new MessageRepository($db)
);

$products = $controller->getProducts() ?? [];
$messages = $controller->getMessages() ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Dashboard</title>
    <link rel="stylesheet" href="pDashboard.css">
</head>

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

    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id'] ?></td>
        <td><?= $product['name'] ?></td>
        <td><?= $product['category'] ?></td>
        <td><?= $product['description'] ?></td>
        <td><?= $product['price'] ?></td>
        <td><?= $product['image'] ?></td>
        <td><a href="editProduct.php?id=<?= $product['id'] ?>">Edit</a></td>
        <td><a href="deleteProduct.php?id=<?= $product['id'] ?>">Delete</a></td>
    </tr>
    <?php endforeach; ?>

</table>

<hr>

<h2>Contact Messages</h2>

<?php if ($messages): ?>
    <?php foreach ($messages as $msg): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px">
            <b><?= htmlspecialchars($msg['name']) ?></b> (<?= htmlspecialchars($msg['email']) ?>)<br>

            <?php if ($msg['user_id']): ?>
                <small>User: <b><?= htmlspecialchars($msg['username']) ?></b></small><br>
            <?php else: ?>
                <small>Guest</small><br>
            <?php endif; ?>

            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <small><?= $msg['created_at'] ?></small>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
