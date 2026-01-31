<?php

class ProductView{
private $products;


public function __construct(array $products){
    $this->products=$products;
}
public function render(){
    ob_start();
    ?>

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

    <?php foreach ($this->products as $product): ?>
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
<?php
return ob_get_clean();
}

}
?>


