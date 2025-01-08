<?php
require_once '../user.class.php';  // Assuming the User class is in 'User.php'

// Initialize the User object
$user = new User();

// Check if an ID was provided for editing
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the user details
    $userData = $user->fetch($id);

    if (!$userData) {
        echo "User not found!";
        exit;
    }
} else {
    echo "No user ID provided!";
    exit;
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user details with POST data
    $user->first_name = $_POST['first_name'];
    $user->middle_name = $_POST['middle_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->username = $_POST['username'];
    $user->user_type = $_POST['user_type'];
    $user->date_of_birth = $_POST['date_of_birth'];
    $user->contact_num = $_POST['contact_num'];

    // Call the update method
    $result = $user->update($id);

    if ($result) {
        echo "User updated successfully!";
        // header("Location: students_view.php");  // Redirect to list of students after success
        exit;
    } else {
        echo "Failed to update user!";
    }
}
?>