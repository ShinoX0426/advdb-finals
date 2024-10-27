<?php
require_once '../cases.class.php';

// Ensure case_id is provided
if (!isset($_GET['case_id'])) {
    header('Location: cases_view.php');
    exit;
}

session_start();

var_dump($_SESSION);
$case_id = (int)$_GET['case_id'];

// Create database connections
$db = new Database();
$conn = $db->connect();

// First fetch case details including student information
$caseDetailsSql = "SELECT 
    c.*,
    s.first_name AS student_first_name,
    s.last_name AS student_last_name
    FROM cases c
    JOIN users s ON c.student_id = s.user_id
    WHERE c.case_id = :case_id";

$stmtCase = $conn->prepare($caseDetailsSql);
$stmtCase->bindParam(':case_id', $case_id, PDO::PARAM_INT);
$stmtCase->execute();
$caseDetails = $stmtCase->fetch(PDO::FETCH_ASSOC);

// Then fetch case logs
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
    <title>Case Logs - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* [Previous styles remain the same] */
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

        .case-header {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .case-header h3 {
            color: #0f3978;
            margin-bottom: 10px;
        }

        .case-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .case-info p {
            margin: 5px 0;
        }

        .logs-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .log-entry {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .log-entry:last-child {
            border-bottom: none;
        }

        .log-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #666;
        }

        .logout-btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 1rem;
        }

        .log-content {
            line-height: 1.5;
        }

        .btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .back-button {
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
                <span>Welcome, Counselor</span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>
    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="students_view.php"><i class="fas fa-users"></i> Students</a></li>
                <li><a href="appointments_view.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                <li><a href="cases_view.php"><i class="fas fa-file-alt"></i> Cases</a></li>
                <li><a href="reports_view.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="back-button">
                <a href="cases_view.php" class="btn"><i class="fas fa-arrow-left"></i> Back to Cases</a>
            </div>
            
            <?php if ($caseDetails): ?>
            <div class="case-header">
                <h3>Case Details</h3>
                <div class="case-info">
                    <div>
                        <p><strong>Student:</strong> <?= htmlspecialchars($caseDetails['student_first_name'] . ' ' . $caseDetails['student_last_name']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($caseDetails['case_status']) ?></p>
                    </div>
                    <div>
                        <p><strong>Case Description:</strong></p>
                        <p><?= htmlspecialchars($caseDetails['case_description']) ?></p>
                    </div>
                </div>
            </div>

            <div class="logs-container">
                <h3>Case Logs</h3>
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

                <div style="margin-top: 20px;">
                    <form action="add_case_log.php" method="post">
                        <input type="hidden" name="case_id" value="<?= $caseDetails['case_id'] ?>">
                        <input type="hidden" name="counselor_id" value="<?= $caseDetails ['counselor_id'] ?>">
                        <button type="submit" class="btn" name="view">Add Case Log</button>
                    </form>
                </div>
            </div>
            <?php else: ?>
                <div class="case-header">
                    <p>Case not found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>