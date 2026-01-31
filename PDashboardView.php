<?php
class PDashboardView {
    private $productView;
    private $messageView;

    public function __construct(ProductView $productView, MessageView $messageView) {
        $this->productView = $productView;
        $this->messageView = $messageView;
    }

    public function render() {
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Product Dashboard</title>
            <link rel="stylesheet" href="pDashboard.css">
        </head>
        <body>
            <nav class="navbar">
    <div class="nav-center" id="nav-links">
        <a href="homee.php">Home</a>
        <a href="Produktet.php">Products</a>
        <a href="aboutus.php">About Us</a>
        <a href="gift.php">Gift Box</a>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="productDashboard.php">Dashboard</a>
        <?php endif; ?>
    </div>
</nav>

            <?= $this->productView->render() ?>
            <hr>
            <?= $this->messageView->render() ?>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}
