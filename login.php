<?php
session_start();
require_once 'User.class.php';  // Assuming you have User.class.php

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize the User class
    $user = new User();

    // Clean the input (done inside User class)
    $username = $user->clean_input($_POST['username']);
    $password = $user->clean_input($_POST['password']);

    // Check if fields are empty
    if (empty($username) || empty($password)) {
        $_SESSION['error'] =   "Username and password are required";
        header('Location: index.php?error=' . urlencode($error));
        exit();
    }

    // Call the login function from the User class
    if ($user->login($username, $password)) {
        // The login function already handles session and redirection
        exit();
    } else {
        // Invalid login credentials
        $_SESSION['error'] =   "Invalid username or password";
        header('Location: index.php?error=' . urlencode($error));
        exit();
    }
} else {
    // Redirect to index if accessed without a POST request
    header('Location: index.php');
    exit();
}
