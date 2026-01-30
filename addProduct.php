
<?php
ob_start();
    include_once 'Produktet.php';
    include_once 'ProductRepository.php';

    if(isset($_POST['addBtn'])){

    $product =new Produktet(
        
        null,

        $_POST['name'],
        $_POST['category'],
        $_POST['description'],
        $_POST['price'],
        $_POST['image']

    );

    $repo =new ProductRepository();
    $repo -> insertProduct($product);
    header("location: productDashboard.php");
ob_end_flush();
    }


?>



<form method="post">
    <input type="text" name="name" placeholder="Product name"><br><br>
    <input type="text" name="category" placeholder="Category"><br><br>
    <textarea name="description" placeholder="Description"></textarea><br><br>
    <input type="number" step="0.01" name="price" placeholder="Price"><br><br>
    <input type="text" name="image" placeholder="Image URL"><br><br>
    <input type="submit" name="addBtn" value="Add Product">
</form>

