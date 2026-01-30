<?php

    include_once 'IProductsRepository.php';
    include_once 'database.php';
    class ProductRepository implements IProductsRepository{

    private $connection;

    function __construct(){
       $this->connection = (new database())->getConnection();// $conn=new database;
    }

    public function insertProduct($product){
       // $con=$this->connection;
        $sql="INSERT INTO products(name,category,description,price,image)
                
                VALUES (?,?,?,?,?)";

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
        $sql= "SELECT * FROM  products";
        return $this -> connection -> query($sql)-> fetchAll(PDO::FETCH_ASSOC);   
    }

    public function getProductById($id){

        $sql="SELECT * FROM products WHERE id=?";
        $statement = $this-> connection ->prepare ($sql);
        $statement ->execute ([$id]);
        return $statement ->fetch(PDO::FETCH_ASSOC);   
    }

    public function updateProduct($id,$name,$category,$description,$price,$image){

    $sql =" UPDATE products
         SET name=?, category=?, description=?,price=?,image=?
                WHERE id=?";
                $statement =$this-> connection ->prepare ($sql);
                $statement-> execute([$name,$category,$description,$price,$image,$id]);

   }

        public function deleteProduct ($id){
            $sql=" DELETE FROM products WHERE id=?";
            $statement =$this-> connection ->prepare ($sql);
            $statement -> execute([$id]);
        }

    }

?>