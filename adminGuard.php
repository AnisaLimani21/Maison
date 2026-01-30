<?php

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['user_id'])|| $_SESSION ['user']['role']!=='admin'){
        header("Location: login.php");
        exit;
    }


?>