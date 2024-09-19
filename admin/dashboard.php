<?php
// Start the session and include necessary files
session_start();
include('config.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch some sample data (you would replace these with actual database queries)
$total_students = 500;
$total_appointments = 50;
$upcoming_appointments = 10;
$recent_cases = [
    ['id' => 1, 'student' => 'John Doe', 'issue' => 'Academic Counseling', 'date' => '2023-09-20'],
    ['id' => 2, 'student' => 'Jane Smith', 'issue' => 'Personal Counseling', 'date' => '2023-09-19'],
    ['id' => 3, 'student' => 'Mike Johnson', 'issue' => 'Career Guidance', 'date' => '2023-09-18'],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../../../FINAL/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .dashboard-container {
            display: flex;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            background-color: #0f3978;
            color: white;
            padding: 20px;
            height: calc(100vh - 120px);
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

        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 30%;
        }

        .card h3 {
            margin-top: 0;
            color: #0f3978;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0;
        }

        .recent-cases {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .recent-cases h3 {
            margin-top: 0;
            color: #0f3978;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../../../FINAL/images/logo.png" alt="Logo">
                <span>Don Pablo Guidance</span>
            </div>
            <div class="user-info">
                <span>Welcome, Admin</span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Students</a></li>
                <li><a href="#"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                <li><a href="#"><i class="fas fa-file-alt"></i> Cases</a></li>
                <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="dashboard-header">
                <h2>Dashboard Overview</h2>
                <button class="btn">Generate Report</button>
            </div>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Students</h3>
                    <p><?php echo $total_students; ?></p>
                </div>
                <div class="card">
                    <h3>Total Appointments</h3>
                    <p><?php echo $total_appointments; ?></p>
                </div>
                <div class="card">
                    <h3>Upcoming Appointments</h3>
                    <p><?php echo $upcoming_appointments; ?></p>
                </div>
            </div>
            <div class="recent-cases">
                <h3>Recent Cases</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student</th>
                            <th>Issue</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_cases as $case): ?>
                            <tr>
                                <td><?php echo $case['id']; ?></td>
                                <td><?php echo $case['student']; ?></td>
                                <td><?php echo $case['issue']; ?></td>
                                <td><?php echo $case['date']; ?></td>
                                <td><a href="#" class="btn btn-small">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>