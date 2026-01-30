<?php
class Produktet{

    private $id;
    private $name;
    private $category;
    private $description;
    private $price;
    private $image;


    function __construct($id,$name,$category,$description,$price,$image){
        $this->id= $id;
        $this->name=$name;
        $this->category=$category;
        $this->description=$description;
        $this->price=$price;
        $this->image=$image;
    }

    function getId(){
        return $this->id;
    }
    function getName(){
        return $this->name;
    }
    function getCategory(){
        return $this->category;
    }
    function getDescription(){
        return $this->description;
    }
    function getPrice(){
        return $this->price;
    }
    function getImage(){
        return $this->image;
    }

    
}

?>