<?php
require_once "User.php";

$db = new Database();
$user = new User($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $login = $user->login($username, $password);

    if ($login["status"]) {
        echo "<p style='color:green;'>Login successful. Role: " . $login["role"] . "</p>";
    } else {
        echo "<p style='color:red;'>" . $login["message"] . "</p>";
    }
}
?>


