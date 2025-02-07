<?php
include('classes/Database.php');  // Include database connection
require_once 'classes/User.php';   // Include the User class

// Handle the POST request when the registration form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $db = connectDatabase();
    
    // Create a new User object
    $user = new User($db);

    // Sanitize and assign input values to the User object
    $user->name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $user->email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure the password

    // Attempt to register the user
    if ($user->register()) {
        header("Location: views/login.php?success=1");  // Redirect to login page on success
    } else {
        echo "Registration failed!";
    }
}
?>