<?php
require_once '../cases.class.php';

$cases = new Cases();
$allCases = $cases->getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cases View - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        header { background-color: #0f3978; padding: 1rem; color: white; }
        nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; }
        .logo img { width: 40px; height: 40px; margin-right: 10px; }
        .user-info { display: flex; align-items: center; }
        .logout-btn { background-color: #fd9619; color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; margin-left: 1rem; }
        .dashboard-container { display: flex; min-height: calc(100vh - 64px); }
        .sidebar { width: 250px; background-color: #0f3978; color: white; padding: 20px; }
        .sidebar ul { list-style-type: none; }
        .sidebar ul li { margin-bottom: 15px; }
        .sidebar ul li a { color: white; text-decoration: none; display: flex; align-items: center; }
        .sidebar ul li a i { margin-right: 10px; }
        .main-content { flex-grow: 1; padding: 20px; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { background-color: #fd9619; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        .cases-table { background-color: #fff; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); padding: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .btn-small { padding: 0.25rem 0.5rem; font-size: 0.875rem; }
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
                <a href="#" class="logout-btn">Logout</a>
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
            <div class="dashboard-header">
                <h2>Cases Overview</h2>
                <a href="add_case.php" class="btn">Add Case</a>
            </div>
            <div class="cases-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Counselor</th>
                            <th>Status</th>
                            <th>Case Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($allCases)) : ?>
                            <?php foreach ($allCases as $case) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($case['case_id']) ?></td>
                                    <td><?= htmlspecialchars($case['student_first_name'] . ' ' . $case['student_last_name']) ?></td>
                                    <td><?= htmlspecialchars($case['counselor_first_name'] . ' ' . $case['counselor_last_name']) ?></td>
                                    <td><?= htmlspecialchars($case['case_status']) ?></td>
                                    <td><?= htmlspecialchars($case['case_description']) ?></td>
                                    <td>
                                        <button class="btn-small">Edit</button>
                                        <button class="btn-small">Delete</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6">No cases found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
