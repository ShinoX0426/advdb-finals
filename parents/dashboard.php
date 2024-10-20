<?php
session_start();
require_once '../user.class.php';
require_once '../appointment.class.php';
require_once '../cases.class.php';

// Check if user is logged in and is a parent
if (!isset($_SESSION['account']) || $_SESSION['account']['user_type'] !== 'parent') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$appointment = new Appointment();
$case = new Cases();

$parentId = $_SESSION['account']['user_id'];
$parentName = $_SESSION['account']['first_name'] . ' ' . $_SESSION['account']['last_name'];

// Fetch children of the parent
$children = $user->getStudents($parentId); // Assuming this method returns all students; you may need to modify it to return only children of the current parent
$childrenCount = count($children);

// Fetch upcoming meetings
$upcomingMeetings = $appointment->getByStudent($parentId); // This assumes the parent ID is used; you might need to adjust this to fetch appointments for all children
$upcomingMeetingsCount = count($upcomingMeetings);

// Fetch open cases
$openCases = $case->getByStudent($parentId); // Again, this assumes using parent ID; adjust as necessary
$openCasesCount = count($openCases);

// Prepare data for display
$recentMeetings = array_slice($upcomingMeetings, 0, 5); // Get the 5 most recent meetings

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard - Don Pablo Guidance Counseling</title>
    <title>Parent Dashboard - Don Pablo Guidance Counseling</title>
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

        .upcoming-meetings {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .upcoming-meetings h3 {
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
                <h2>Parent Dashboard Overview</h2>
                <button class="btn">Request Assistance</button>
            </div>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Children</h3>
                    <p><?php echo $childrenCount; ?></p>
                </div>
                <div class="card">
                    <h3>Upcoming Meetings</h3>
                    <p><?php echo $upcomingMeetingsCount; ?></p>
                </div>
                <div class="card">
                    <h3>Open Cases</h3>
                    <p><?php echo $openCasesCount; ?></p>
                </div>
            </div>
            <div class="upcoming-meetings">
                <h3>Upcoming Meetings</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Child</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Counselor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentMeetings)) : ?>
                            <?php foreach ($recentMeetings as $meeting) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($meeting['student_first_name'] . ' ' . $meeting['student_last_name']); ?></td>
                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($meeting['request_date']))); ?></td>
                                    <td><?php echo htmlspecialchars(date('H:i', strtotime($meeting['request_date']))); ?></td>
                                    <td><?php echo htmlspecialchars($meeting['counselor_first_name'] . ' ' . $meeting['counselor_last_name']); ?></td>
                                    <td><a href="#" class="btn btn-small">Reschedule</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">No upcoming meetings scheduled.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>