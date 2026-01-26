<?php
session_start();
include_once 'database.php';
include_once 'user.php';

$error = '';
$redirect = $_GET['redirect'] ?? 'dashboard.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->getConnection();
    $userObj = new User($conn);

    $username = $_POST['user'] ?? '';
    $password = $_POST['pass'] ?? '';

    
    $userData = $userObj->login($username, $password); 

    if($userData) { 
        
        $_SESSION['user_id'] = $userData['id'];  
        $_SESSION['username'] = $userData['username'];
        $_SESSION['role'] = $userData['role']; 

        header("Location: $redirect");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Log-in Maison Chocolate</title>
<link rel="stylesheet" href="login.css">
</head>
<body>
<nav class="navbar">
    <div class="nav-left">
        <img src="img/logoP.png" class="logo">
    </div>
    <div class="nav-center" id="nav-links">
        <a href="homee.php">Home</a>
        <a href="Produktet.php">Products</a>
        <a href="aboutus.php">About Us</a>
        <a href="gift.php">Gift Box</a>
    </div>
    <div class="nav-right">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search products...">
            <button onclick="searchProduct()">🔍</button>
        </div>
        <span class="hamburger" id="hamburger">☰</span>
    </div>
</nav>

<div class="login-container">
    <div class="login">
        <form id="loginForm" action="login.php" method="POST">
            <h2>Log In</h2>
            <?php if($error) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
            
            <label for="user">Username:</label>
            <input type="text" name="user" id="user" placeholder="Enter username" required>

            <label for="pass">Password:</label>
            <input type="password" name="pass" id="pass" placeholder="Enter password" required>

            <button type="submit" class="login-btn">Log In</button>

            <p class="or-text">or login with</p>
            <div class="social-login">
                <a href="https://facebook.com" target="_blank" class="facebook-btn">Facebook</a>
                <a href="mailto:example@example.com" class="email-btn">Email</a>
            </div>

            <p class="create-account">Don't have an account? <a href="create.php">Create Account</a></p>
        </form>
    </div>
</div>

<footer class="footer">
    <div class="footer-left">
        <h2>Maison</h2>
        <p>Unique flavors, modern style, and carefully crafted delights.</p>
    </div>
    <div class="footer-center">
        <h2>Contact</h2>
        <p>Email: maison.contact@gmail.com</p>
        <p>Phone: +383 44 000 000</p>
    </div>
    <div class="footer-right">
        <h2>Follow Us</h2>
        <div class="social-icons">
            <a href="https://www.facebook.com/" target="_blank" title="Facebook">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M22 12.07C22 6.48 17.52 2 12 2S2 6.48 2 12.07c0 5 3.66 9.13 8.44 9.93v-7.03H8.08v-2.9h2.36V9.91c0-2.33 1.38-3.62 3.52-3.62 1.02 0 2.09.18 2.09.18v2.29h-1.18c-1.16 0-1.52.72-1.52 1.46v1.75h2.59l-.41 2.9h-2.18V22c4.78-.8 8.44-4.93 8.44-9.93z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>
</body>
</html>
