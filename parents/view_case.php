<?php
require_once '../cases.class.php';
require_once '../database.php';

// Ensure case_id is provided
if (!isset($_GET['id'])) {
    header('Location: case_history.php');
    exit;
}

$case_id = (int)$_GET['id'];

// Create database connection
$db = new Database();
$conn = $db->connect();

// Fetch case details
$caseDetailsSql = "SELECT 
    c.*,
    s.first_name AS student_first_name,
    s.last_name AS student_last_name,
    co.first_name AS counselor_first_name,
    co.last_name AS counselor_last_name
    FROM cases c
    JOIN users s ON c.student_id = s.user_id
    JOIN users co ON c.counselor_id = co.user_id
    WHERE c.case_id = :case_id";

$stmtCase = $conn->prepare($caseDetailsSql);
$stmtCase->bindParam(':case_id', $case_id, PDO::PARAM_INT);
$stmtCase->execute();
$caseDetails = $stmtCase->fetch(PDO::FETCH_ASSOC);

// Fetch case logs
$logsSQL = "SELECT 
    cl.log_id,
    cl.progress_note,
    cl.log_date,
    u.first_name AS counselor_first_name,
    u.last_name AS counselor_last_name
    FROM caselogs cl
    JOIN users u ON cl.counselor_id = u.user_id
    WHERE cl.case_id = :case_id
    ORDER BY cl.log_date DESC";

$stmtLogs = $conn->prepare($logsSQL);
$stmtLogs->bindParam(':case_id', $case_id, PDO::PARAM_INT);
$stmtLogs->execute();
$caseLogs = $stmtLogs->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Case - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
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

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        .case-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .logs-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .log-entry {
            margin-bottom: 20px;
        }

        .log-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .log-content {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
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
                <span>Welcome, Parent</span>
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
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="case-info">
                <h2>Case Details</h2>
                <p><strong>Student:</strong> <?= htmlspecialchars($caseDetails['student_first_name'] . ' ' . $caseDetails['student_last_name']) ?></p>
                <p><strong>Counselor:</strong> <?= htmlspecialchars($caseDetails['counselor_first_name'] . ' ' . $caseDetails['counselor_last_name']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($caseDetails['case_status']) ?></p>
                <p><strong>Description:</strong> <?= htmlspecialchars($caseDetails['case_description']) ?></p>
            </div>

            <div class="logs-container">
                <h2>Case Logs</h2>
                <?php if (!empty($caseLogs)): ?>
                    <?php foreach ($caseLogs as $log): ?>
                        <div class="log-entry">
                            <div class="log-header">
                                <span><strong>Counselor:</strong> <?= htmlspecialchars($log['counselor_first_name'] . ' ' . $log['counselor_last_name']) ?></span>
                                <span><?= date('F j, Y g:i A', strtotime($log['log_date'])) ?></span>
                            </div>
                            <div class="log-content">
                                <?= htmlspecialchars($log['progress_note']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No logs found for this case.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>