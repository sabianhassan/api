<?php
require_once 'config/config.php';
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = connectDatabase();
    $user = new User($db);

    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];

    if ($user->register()) {
        header("Location: views/login.php?success=1");
    } else {
        echo "Registration failed!";
    }
}
?>
