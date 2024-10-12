<?php
require_once '../appointment.class.php';
require_once '../user.class.php';

// Initialize classes
$appointment = new Appointment();
$user = new User();

// Fetch students and counselors from the database
$studentsCount = $user->getStudentCount();
$counselorsCount = $user->getCounselorCount();
$appointmentCount = $appointment->getAppointmentCount();
$appointmentAllCount = $appointment->getAllAppointmentCount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Don Pablo Guidance Counseling</title>
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
            margin-bottom: 15px;
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
                <span>Welcome, Admin</span>
                <a href="#" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="students_view.php"><i class="fas fa-users"></i> Students</a></li>
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
                    <p><?=$studentsCount?></p>
                </div>
                <div class="card">
                    <h3>Total Appointments</h3>
                    <p><?=$appointmentAllCount?></p>
                </div>
                <div class="card">
                    <h3>Upcoming Appointments</h3>
                    <p><?=$appointmentCount?></p>
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
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>Academic Counseling</td>
                            <td>2023-09-20</td>
                            <td><a href="#" class="btn btn-small">View</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jane Smith</td>
                            <td>Personal Counseling</td>
                            <td>2023-09-19</td>
                            <td><a href="#" class="btn btn-small">View</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Mike Johnson</td>
                            <td>Career Guidance</td>
                            <td>2023-09-18</td>
                            <td><a href="#" class="btn btn-small">View</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>