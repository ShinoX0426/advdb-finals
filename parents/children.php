<?php
session_start();
require_once '../user.class.php';

// Check if user is logged in and is a parent
if (!isset($_SESSION['account']) || $_SESSION['account']['user_type'] !== 'parent') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$parentId = $_SESSION['account']['user_id'];
$parentName = $_SESSION['account']['first_name'] . ' ' . $_SESSION['account']['last_name'];

// Fetch children/wards connected to the parent
$children = $user->getStudents($parentId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Children/Ward - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Copy the styles from the dashboard.php */
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

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .children-list {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .children-list h3 {
            margin-top: 0;
            color: #0f3978;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-small {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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
                <span>Welcome, <?php echo htmlspecialchars($parentName); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="children.php"><i class="fas fa-users"></i> Your Children/Ward</a></li>
                <li><a href="set_meeting.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
                <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="dashboard-header">
                <h2>Your Children/Ward</h2>
            </div>
            <div class="children-list">
                <h3>Children/Wards</h3>
                <?php if (!empty($children)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Contact Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $child) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($child['first_name'] . ' ' . $child['middle_name'] . ' ' . $child['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($child['date_of_birth']); ?></td>
                                    <td><?php echo htmlspecialchars($child['contact_num']); ?></td>
                                    <td>
                                        <a href="set_meeting.php?student_id=<?php echo $child['user_id']; ?>" class="btn btn-small">Set Meeting</a>
                                        <a href="case_history.php?student_id=<?php echo $child['user_id']; ?>" class="btn btn-small">View Cases</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No children/wards are currently connected to your account.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>