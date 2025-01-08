<?php

require_once '../user.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$student = $user->fetch($_SESSION['account']['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account - Don Pablo Lorenzo Memorial High School</title>
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

        .account-details {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .detail {
            margin-bottom: 15px;
        }

        .detail label {
            font-weight: bold;
            color: #0f3978;
        }

        .detail span {
            display: block;
            margin-top: 5px;
            color: #333;
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
                <span>Welcome, <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="account.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
            <li><a href="set_appointment.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
            <li><a href="classlist.php"><i class="fas fa-list"></i> Class List</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="page-header">
                <h2>Account Details</h2>
                <p>View your account details</p>
            </div>

            <div class="account-details">
                <div class="detail">
                    <label>First Name:</label>
                    <span><?= htmlspecialchars($student['first_name']) ?></span>
                </div>
                <div class="detail">
                    <label>Middle Name:</label>
                    <span><?= htmlspecialchars($student['middle_name']) ?></span>
                </div>
                <div class="detail">
                    <label>Last Name:</label>
                    <span><?= htmlspecialchars($student['last_name']) ?></span>
                </div>
                <div class="detail">
                    <label>Email:</label>
                    <span><?= htmlspecialchars($student['email']) ?></span>
                </div>
                <div class="detail">
                    <label>Username:</label>
                    <span><?= htmlspecialchars($student['username']) ?></span>
                </div>
                <div class="detail">
                    <label>Date of Birth:</label>
                    <span><?= htmlspecialchars($student['date_of_birth']) ?></span>
                </div>
                <div class="detail">
                    <label>Contact Number:</label>
                    <span><?= htmlspecialchars($student['contact_num']) ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
