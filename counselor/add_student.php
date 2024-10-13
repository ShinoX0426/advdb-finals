<?php
require_once '../user.class.php';

$user = new User();

$parents = [];
$parents = $user->getParent();
var_dump($parents);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    $firstName = $user->clean_input($_POST['firstName']);
    $middleName = $user->clean_input($_POST['middleName']);
    $lastName = $user->clean_input($_POST['lastName']);
    $username = $user->clean_input($_POST['username']);
    $email = $user->clean_input($_POST['email']);
    $password = $user->clean_input($_POST['password']);
    $confirmPassword = $user->clean_input($_POST['confirmPassword']);
    $userType = $user->clean_input($_POST['userType']);
    $dob = $user->clean_input($_POST['dob']);
    $contact = $user->clean_input($_POST['contact']);

    $result = $user->register($firstName, $middleName, $lastName, $username, $password, $confirmPassword, $userType, $dob, $contact);

    if ($result === '') {
        echo "<script>document.getElementById('success-message').textContent = 'Account created successfully!';</script>";
        header('location: students_view.php');
    } else {
        echo "<script>document.getElementById('error-message').textContent = '$result';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account - Admin</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #fd9619;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .register-container button:hover {
            background-color: #e58917;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Add Account</h2>
        <form id="addAccountForm" method="POST" action="">
            <div class="error" id="error-message"></div>
            <div class="success" id="success-message"></div>
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="middleName" placeholder="Middle Name">
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <select name="userType" required>
                <option value="">Select User Type</option>
                <option value="student">Student</option>
                <option value="parent">Parent</option>
                <option value="teacher">Teacher</option>
                <option value="counselor">Counselor</option>
                <option value="admin">Admin</option>
            </select>
            <input type="date" name="dob" placeholder="Date of Birth" required>
            <input type="text" name="contact" placeholder="Contact Number" required>
            <select name="parentId" required>
                <option value="">Select Parent</option>
                <?php foreach ($parents as $parents): ?>
                    <option value="<?= $parents['user_id'] ?>">
                        <?= htmlspecialchars($parents['first_name'] . ' ' . $parents['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>

</html>