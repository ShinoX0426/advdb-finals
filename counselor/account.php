<?php

require_once '../user.class.php';

session_start();

$user = new User();
$counselor = $user->fetch($_SESSION['account']['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->first_name = $_POST['first_name'];
    $user->middle_name = $_POST['middle_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->username = $_POST['username'];
    $user->date_of_birth = $_POST['date_of_birth'];
    $user->contact_num = $_POST['contact_num'];

    $updateResult = $user->update($_SESSION['account']['user_id']);

    if ($updateResult === true) {
        $message = "Account updated successfully.";
        $_SESSION['account'] = $user->fetch($_SESSION['account']['user_id']); // Update session data
    } else {
        $message = "Failed to update account: " . $updateResult;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account - Don Pablo Guidance Counseling</title>
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

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 15px;
            color: green;
        }

        .sidebar {
            width: 250px;
            background-color: #0f3978;
            color: white;
            padding: 20px;
            position: fixed;
            top: 64px; /* height of the header */
            bottom: 0;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
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
                <span>Welcome, Counselor</span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="sidebar">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="students_view.php"><i class="fas fa-users"></i> Students</a></li>
            <li><a href="appointments_view.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
            <li><a href="cases_view.php"><i class="fas fa-file-alt"></i> Cases</a></li>
            <li><a href="reports_view.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="account.php"><i class="fa fa-user"></i> Account</a></li>
        </ul>
    </div>

    <div class="container">
        <h2>Update Account Details</h2>
        <?php if (isset($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($counselor['first_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="middle_name">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" value="<?= htmlspecialchars($counselor['middle_name']) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($counselor['last_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($counselor['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($counselor['username']) ?>" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($counselor['date_of_birth']) ?>" required>
            </div>
            <div class="form-group">
                <label for="contact_num">Contact Number</label>
                <input type="text" id="contact_num" name="contact_num" value="<?= htmlspecialchars($counselor['contact_num']) ?>" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Account</button>
            </div>
        </form>
    </div>
</body>

</html>