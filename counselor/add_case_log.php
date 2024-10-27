<?php
require_once '../cases.class.php';
require_once '../database.php';

var_dump($_POST);
$case_id = $_POST['case_id'];
$counselor_id = $_POST['counselor_id'];

// Check if POST data for case_id and counselor_id is provided
if (!isset($_POST['case_id']) || !isset($_POST['counselor_id'])) {
    header('Location: cases_view.php');
    exit;
}

$error_message = '';
$success_message = '';

// Create database connection
$db = new Database();
$conn = $db->connect();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['progress_note'])) {
        $error_message = 'Progress note is required';
    } else {
        $progress_note = trim($_POST['progress_note']);
        
        // Insert the new case log
        $sql = "INSERT INTO caselogs (case_id, counselor_id, progress_note) 
                VALUES (:case_id, :counselor_id, :progress_note)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':case_id', $case_id, PDO::PARAM_INT);
        $stmt->bindParam(':counselor_id', $counselor_id, PDO::PARAM_INT);
        $stmt->bindParam(':progress_note', $progress_note, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            // Update the case's last_updated timestamp
            $updateCaseSQL = "UPDATE cases SET last_updated = CURRENT_TIMESTAMP 
                            WHERE case_id = :case_id";
            $updateStmt = $conn->prepare($updateCaseSQL);
            $updateStmt->bindParam(':case_id', $case_id, PDO::PARAM_INT);
            $updateStmt->execute();
            
            $success_message = 'Case log added successfully';
            // Redirect after short delay
            header("refresh:1;url=caselog.php?case_id=" . $case_id);
        } else {
            $error_message = 'Error adding case log';
        }
    }
}

// Fetch case details for display
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Case Log - Don Pablo Guidance Counseling</title>
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

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-height: 150px;
            font-family: inherit;
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

        .btn:hover {
            background-color: #e88610;
        }

        .back-button {
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .case-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
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
                <a href="javascript:history.back()" class="btn">
                    <i class="fas fa-arrow-left"></i> Back to Case
                </a>
            </div>

            <?php if ($error_message): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <?php if ($caseDetails): ?>
                    <div class="case-info">
                        <h3>Case Information</h3>
                        <p><strong>Student:</strong> <?= htmlspecialchars($caseDetails['student_first_name'] . ' ' . $caseDetails['student_last_name']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($caseDetails['case_status']) ?></p>
                    </div>

                    <h2>Add New Case Log</h2>
                    <form method="POST" action="">
                        <input type="hidden" name="case_id" value="<?= $case_id ?>">
                        <input type="hidden" name="counselor_id" value="<?= $counselor_id ?>">
                        <div class="form-group">
                            <label for="progress_note">Progress Note:</label>
                            <textarea 
                                id="progress_note" 
                                name="progress_note" 
                                required 
                                placeholder="Enter your progress note here..."
                            ></textarea>
                        </div>
                        <button type="submit" class="btn">
                            <i class="fas fa-save"></i> Save Log
                        </button>
                    </form>
                <?php else: ?>
                    <p>Case not found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>