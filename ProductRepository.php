<?php

    include_once '../IProductRepository.php';
    include_once'../database.php';
    class ProductRepository implements IProductRepository{

    private $connection;

    function __construct(){
        $conn=new database;
    }

    public function insertProduct($product){
        $con=$this->connection;
        $sql="INSERT INTO product(name,,category,description,price,image)
                
                VALUES (?,?,?,?,?,?)";

                $statement =$conn->prepare($sql);
                $statement ->execute([
                    $product -> getName(),
                    $product -> getCategory(),
                    $product -> getDescription(),
                    $product -> getPrice(),
                    $product -> getImage()
                ]);
    }


    public function getAllProducts(){
        $sql= "SELECT * FROM  product";
        return $this -> connection -> query($sql)-> fetchAll();   
    }

    public function getProductById($id){

        $sql="SELECT * FROM product WHERE id=?";
        $statement = $this-> connection ->prepare ($sql);
        $statement ->execute ([$id]);
        return $statement ->fetch();   
    }

    public function updateProduct($id,$name,$category,$description,$price,$image){

    $sql =" UPDATE product
         SET name=?, category=?, description=?,price=?,image=?
                WHERE id=?;"
                $statement =$this-> connection ->prepare ($sql);
                $statement-> execute([$name,$category,$description,$price,$image,$id]);

   }

   
    }

?>