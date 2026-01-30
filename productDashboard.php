<!DOCTYPE html>
<html>
<head>
    <title>Product Dashboard</title>
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

<?php
include_once '../ProductRepository.php';

$productRepo = new ProductRepository();
$products = $productRepo->getAllProducts();

foreach ($products as $product) {
    echo "
    <tr>
        <td>{$product['id']}</td>
        <td>{$product['name']}</td>
        <td>{$product['category']}</td>
        <td>{$product['description']}</td>
        <td>{$product['price']}</td>
        <td>{$product ['image']}</td>
        <td><a href='editProduct.php?id={$product['id']}'>Edit</a></td>
        <td><a href='deleteProduct.php?id={$product['id']}'>Delete</a></td>
    </tr>";
}
?>

</table>
</body>
</html>
