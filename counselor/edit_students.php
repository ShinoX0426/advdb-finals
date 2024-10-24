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
        header("Location: students_view.php");  // Redirect to list of students after success
        exit;
    } else {
        echo "Failed to update user!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .register-container h2 {
            margin-bottom: 20px;
            color: #0f3978;
            text-align: center;
        }

        .register-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #555;
        }

        .register-container input:focus,
        .register-container select:focus {
            border-color: #fd9619;
            outline: none;
            box-shadow: 0 0 5px rgba(253, 150, 25, 0.5);
        }

        .register-container button {
            width: 100%;
            padding: 12px;
            background-color: #fd9619;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .register-container button:hover {
            background-color: #e58917;
        }

        .back-link {
            text-align: center;
            margin-top: 10px;
        }

        .back-link a {
            color: #0f3978;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Edit Student Information</h2>

        <!-- Display edit form with current user data -->
        <form method="POST" action="#">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?= htmlspecialchars($userData['first_name']) ?>" required>

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name" value="<?= htmlspecialchars($userData['middle_name']) ?>">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?= htmlspecialchars($userData['last_name']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

            <label for="username">Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($userData['username']) ?>" required>

            <label for="user_type">User Type:</label>
            <select name="user_type">
                <option value="student" <?= $userData['user_type'] == 'student' ? 'selected' : '' ?>>Student</option>
                <option value="parent" <?= $userData['user_type'] == 'parent' ? 'selected' : '' ?>>Parent</option>
                <option value="teacher" <?= $userData['user_type'] == 'teacher' ? 'selected' : '' ?>>Teacher</option>
                <option value="counselor" <?= $userData['user_type'] == 'counselor' ? 'selected' : '' ?>>Counselor</option>
                <option value="admin" <?= $userData['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="<?= htmlspecialchars($userData['date_of_birth']) ?>"
                required>

            <label for="contact_num">Contact Number:</label>
            <input type="text" name="contact_num" value="<?= htmlspecialchars($userData['contact_num']) ?>" required>

            <button type="submit">Update Student</button>
        </form>

        <div class="back-link">
            <a href="students_view.php">Back to Student List</a>
        </div>
    </div>

</body>

</html>