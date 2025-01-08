<?php
require_once '../user.class.php';
session_start();

// Check if the user is logged in and is a parent
if (!isset($_SESSION['account']) || $_SESSION['account']['user_type'] !== 'parent') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$parentId = $_SESSION['account']['user_id'];

// Handle form submission for updating parent account
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_parent'])) {
    $user->first_name = $user->clean_input($_POST['first_name']);
    $user->middle_name = $user->clean_input($_POST['middle_name']);
    $user->last_name = $user->clean_input($_POST['last_name']);
    $user->email = $user->clean_input($_POST['email']);
    $user->username = $user->clean_input($_POST['username']);
    $user->date_of_birth = $user->clean_input($_POST['date_of_birth']);
    $user->contact_num = $user->clean_input($_POST['contact_num']);

    $updateResult = $user->update($parentId);
    $message = $updateResult === true ? 'Account updated successfully.' : $updateResult;
}

// Handle form submission for updating child account
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_child'])) {
    $childId = $_POST['child_id'];
    $user->first_name = $user->clean_input($_POST['child_first_name']);
    $user->middle_name = $user->clean_input($_POST['child_middle_name']);
    $user->last_name = $user->clean_input($_POST['child_last_name']);
    $user->email = $user->clean_input($_POST['child_email']);
    $user->username = $user->clean_input($_POST['child_username']);
    $user->date_of_birth = $user->clean_input($_POST['child_date_of_birth']);
    $user->contact_num = $user->clean_input($_POST['child_contact_num']);

    $updateResult = $user->update($childId);
    $message = $updateResult === true ? 'Child account updated successfully.' : $updateResult;
}

// Fetch parent and children details
$parentDetails = $user->fetch($parentId);
$children = $user->getStudents($parentId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Include the existing styles from dashboard.php */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }

        header {
            background-color: #0f3978;
            padding: 1rem;
            color: white;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .logout-btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 1rem;
        }

        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        .sidebar {
            width: 250px;
            background-color: #0f3978;
            color: white;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
        }

        .sidebar ul li {
            margin-bottom: 15px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            color: #0f3978;
        }

        .form-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #0f3978;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0d2e5c;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 4px;
            color: white;
        }

        .message.success {
            background-color: #28a745;
        }

        .message.error {
            background-color: #dc3545;
        }

        hr{
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logo.png" alt="Logo">
                <span>Don Pablo Guidance</span>
            </div>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['account']['first_name'] . ' ' . $_SESSION['account']['last_name']); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="children.php"><i class="fas fa-users"></i> Your Children/Ward</a></li>
                <li><a href="set_appointment.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
                <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
                <li><a href="account.php"><i class="fas fa-user"></i> Account</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="page-header">
                <h2>Edit Account</h2>
                <p>Update your account details and your children's accounts</p>
            </div>

            <div class="form-container">
                <?php if (isset($message)) : ?>
                    <div class="message <?php echo $updateResult === true ? 'success' : 'error'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <h3>Parent Account</h3>
                <form method="POST">
                    <input type="hidden" name="update_parent" value="1">
                    <label>First Name: <input type="text" name="first_name" value="<?php echo htmlspecialchars($parentDetails['first_name']); ?>"></label>
                    <label>Middle Name: <input type="text" name="middle_name" value="<?php echo htmlspecialchars($parentDetails['middle_name']); ?>"></label>
                    <label>Last Name: <input type="text" name="last_name" value="<?php echo htmlspecialchars($parentDetails['last_name']); ?>"></label>
                    <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($parentDetails['email']); ?>"></label>
                    <label>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($parentDetails['username']); ?>"></label>
                    <label>Date of Birth: <input type="date" name="date_of_birth" value="<?php echo htmlspecialchars($parentDetails['date_of_birth']); ?>"></label>
                    <label>Contact Number: <input type="text" name="contact_num" value="<?php echo htmlspecialchars($parentDetails['contact_num']); ?>"></label>
                    <button type="submit">Update Parent Account</button>
                </form>

                <hr>

                <h3>Children Accounts</h3>
                <?php foreach ($children as $child) : ?>
                    <form method="POST">
                        <input type="hidden" name="update_child" value="1">
                        <input type="hidden" name="child_id" value="<?php echo htmlspecialchars($child['user_id']); ?>">
                        <label>First Name: <input type="text" name="child_first_name" value="<?php echo htmlspecialchars($child['first_name']); ?>"></label>
                        <label>Middle Name: <input type="text" name="child_middle_name" value="<?php echo htmlspecialchars($child['middle_name']); ?>"></label>
                        <label>Last Name: <input type="text" name="child_last_name" value="<?php echo htmlspecialchars($child['last_name']); ?>"></label>
                        <label>Email: <input type="email" name="child_email" value="<?php echo htmlspecialchars($child['email'] ?? ''); ?>"></label>
                        <label>Username: <input type="text" name="child_username" value="<?php echo htmlspecialchars($child['username'] ?? ''); ?>"></label>
                        <label>Date of Birth: <input type="date" name="child_date_of_birth" value="<?php echo htmlspecialchars($child['date_of_birth']); ?>"></label>
                        <label>Contact Number: <input type="text" name="child_contact_num" value="<?php echo htmlspecialchars($child['contact_num']); ?>"></label>
                        <button type="submit">Update Child Account</button>
                    </form>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>