<?php
session_start();

require_once "database.php";
require_once "MessageManager.php";
require_once "homeController.php";
require_once "homeView.php";
$db=(new Database())->getConnection();
$controller=new HomeController($db);
$controller->handlePost();





$sliders = $controller->getSliders() ??[];
$products = $controller->getProducts(6) ?? [];
$reviews = $controller->getReviews() ?? [];
$view =new HomeView($sliders,$products,$reviews);
$view->render();
?>
