<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: homee.php");
    exit;
}

require_once 'database.php';
require_once 'ProductRepository.php';
require_once 'MessageRepository.php';
require_once 'PDashboardController.php';
require_once 'ProductView.php';
require_once 'MessageView.php';
require_once 'PDashboardView.php';

$db = (new Database())->getConnection();

$controller = new PDashboardController(
    new ProductRepository($db),
    new MessageRepository($db)
);

$products = $controller->getProducts() ?? [];
$messages = $controller->getMessages() ?? [];

$productView=new ProductView($products);
$messageView=new MessageView($messages);

$dashboard=new PDashboardView($productView,$messageView);

echo $dashboard->render();


?>

