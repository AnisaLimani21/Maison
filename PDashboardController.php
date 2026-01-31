<?php

class PDashboardController {
    private $productRepo;
    private $messageRepo;

    public function __construct($productRepo, $messageRepo) {
        $this->productRepo = $productRepo;
        $this->messageRepo = $messageRepo;
    }

    public function getProducts() {
        return $this->productRepo->getAllProducts();
    }

    public function getMessages() {
        return $this->messageRepo->getAllMessages();
    }
}
?>