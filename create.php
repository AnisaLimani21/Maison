<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Maison Chocolate</title>
    <link rel="stylesheet" href="create.css">
</head>
<body>
    
   <nav class="navbar">
    <div class="nav-left">
        <img src="img/logoP.png" class="logo" alt="Logo">
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
    <!--<div class="foto">
        <img src="img/logoP.png" alt="">
    </div>-->

  

    <div class="loginC">
    <div class="login">
        <form id="createForm" action="create.php" method="POST">
            <h2>Create Account</h2>
       <label for="name">Full Name:</label>

<input type="text" name="name" id="name" placeholder="Enter full name">

<span class="error" id="nameError"></span>

<label for="email">Email:</label>

<input type="email" name="email" id="email" placeholder="Enter your email">

<span class="error" id="emailError"></span>

<label for="user">Username:</label>

<input type="text" name="user" id="user" placeholder="Choose a username">

<span class="error" id="usernameError"></span>


<label for="pass">Password:</label>

<input type="password" name="pass" id="pass" placeholder="Create password">

<span class="error" id="passError"></span>


<label for="confirmPass">Confirm Password:</label>

<input type="password" name="confirmPass" id="confirmPass" placeholder="Confirm password">

<span class="error" id="confirmPassError"></span>


            <button type="submit" class="login-btn">Create Account</button>

            <p class="or-text">or sign up with</p>

            <div class="social-login">
                <a href="https://facebook.com" target="_blank" class="facebook-btn">Facebook</a>
                <a href="mailto:example@example.com" class="email-btn">Email</a>
            </div>

            <p class="create-account">
                Already have an account? <a href="login.html">Log In</a>
            </p>
        </form>
    </div>
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
            <a href="https://www.instagram.com/" target="_blank" title="Instagram">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7zm10 2c1.7 0 3 1.3 3 3v10c0 1.7-1.3 3-3 3H7c-1.7 0-3-1.3-3-3V7c0-1.7 1.3-3 3-3h10zm-5 3.5A5.5 5.5 0 1017.5 13 5.5 5.5 0 0012 7.5zm0 9A3.5 3.5 0 1115.5 13 3.5 3.5 0 0112 16.5zm4.7-9.8a1.3 1.3 0 11-1.3-1.3 1.3 1.3 0 011.3 1.3z"/>
                </svg>
            </a>
            <a href="https://x.com/" target="_blank" title="X/Twitter">
                <svg class="icon" viewBox="0 0 24 24">
                    <path fill="white" d="M18.9 2H22l-7.5 8.1L23 22h-6.6L11.7 14l-6.3 8H2l8.1-9.1L2 2h6.6l4.4 6 5.9-6z"/>
                </svg>
            </a>
        </div>
    </div>
</footer>

<script src="create.js"></script>
</body>
</html>


<?php

include_once 'database.php';
include_once 'user.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $db =new Database();
    $connection = $db->getConnection();
    $user = new  User(db: $connection);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $confirmPass = $_POST['confirmPass'];


    if($user->create(name: $name, email: $email, user: $user, pass: $pass, confirmPass: $confirmPass)){
        header(header:"Location:login.php");
        exit;
    }else{
        echo "Error creating user!";
    }

}



?>