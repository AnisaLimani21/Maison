
    <?php

    include_once 'ProductRepository.php';

    $repo=new ProductRepository();
    $product=$repo->getProductById($_GET['id']);

    if(isser($_POST ['editBtn'])){
        $repo->updateProduct(
            $product['id'],
            $_POST['name'],
            $_POST['category'],
            $_POST ['description'],
            $_POST['price'],
            $_POST['image']

        );
        header("location : productDashboard.php");
    }
    ?>

   
<form method="post">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?=$product['name']?>"><br><br>

    <label for="category">Category:</label><br>
    <input type="text" id="category" name="category" value="<?=$product['category'] ?>"><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description"><?= $product['description'] ?></textarea><br><br>

    <label for="price">Price:</label><br>
    <input type="number" id="price" step="0.01" name="price" value="<?=$product['price'] ?>"><br><br>

    <label for="image">Image URL:</label><br>
    <input type="text" id="image" name="image" value="<?=$product['image']?>"><br><br>

    <input type="submit" name="editBtn" value="Save">
</form>

