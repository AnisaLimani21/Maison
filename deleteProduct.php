
    <?php

    include_once 'productRepository.php';
    $repo = new ProductRepository();

    $repo->deleteproduct($_GET['id']);

    header("location : productDashboard.php");


    ?>