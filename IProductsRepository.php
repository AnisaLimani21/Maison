
<?php

    interface IProductRepository{

    public function insertProduct($product);

    public function getAllProducts();

    public function getProductById($id);

    public function updateProduct($id,$name,$category,$description,$price,$image);

    public function deleteProduct($id);

    }


?>