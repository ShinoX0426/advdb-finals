<?php
require_once '../user.class.php';
require_once '../cases.class.php';

session_start();

// Initialize classes
$user = new User();
$case = new Cases();

// Fetch active cases for the logged-in student
$studentId = $_SESSION['account']['user_id']; // Assuming you have the student ID stored in the session
$activeCases = $case->getActiveCasesByStudentId($studentId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Include the existing styles from case_history.php */
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

        .cases-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #0f3978;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-open {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-closed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .case-description {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .view-details {
            color: #0f3978;
            text-decoration: none;
            font-weight: 500;
        }

        .view-details:hover {
            text-decoration: underline;
        }

        .no-cases {
            text-align: center;
            padding: 20px;
            color: #666;
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
                <li><a href="account.php"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
                <li><a href="set_appointment.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
                <li><a href="classlist.php"><i class="fas fa-list"></i> Class List</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="page-header">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['account']['first_name']); ?></h2>
                <p>Here is a summary of your active cases</p>
            </div>

            <div class="cases-container">
                <?php if (!empty($activeCases)) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($activeCases as $case) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($case['case_id']); ?></td>
                                    <td class="case-description"><?php echo htmlspecialchars($case['case_description']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($case['case_status']); ?>">
                                            <?php echo ucfirst(htmlspecialchars($case['case_status'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($case['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($case['last_updated']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="no-cases">
                        <p>No active cases available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>