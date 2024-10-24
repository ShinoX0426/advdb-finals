<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <style>
        .sidebar {
            width: 250px;
            background-color: #1e40af;
            color: white;
            padding: 20px;
        }

        .sidebar h1 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .sidebar nav ul {
            list-style-type: none;
        }

        .sidebar nav ul li {
            margin-bottom: 15px;
        }

        .sidebar nav ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar nav ul li a:before {
            content: '•';
            margin-right: 10px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            height: 100vh;
        }

        .profile-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            background-color: #1a237e;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-right: 20px;
        }

        .profile-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .profile-id {
            color: #666;
            margin: 5px 0 0;
        }

        .profile-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #666;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        header h2 {
            font-size: 28px;
        }

        .logout-btn {
            background-color: #f97316;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;

            text-decoration: none;
        }

        .dashboard-widgets {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h1>Student Portal</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="student.php">Dashboard</a></li>
                <li><a href="subject.php">Subjects</a></li>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="#">Performance</a></li>
                <li><a href="#">Penalties</a></li>
            </ul>
        </nav>
    </div>
    <div class="main-content">
        <header>
            <h2>Student Profile</h2>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </header>
        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar">JD</div>
                <div>
                    <h1 class="profile-name">Jane Doe</h1>
                    <p class="profile-id">Student ID: STU123456</p>
                </div>
            </div>
            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">jane.doe@example.com</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Program</div>
                    <div class="detail-value">Computer Science</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Year</div>
                    <div class="detail-value">3rd Year</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Advisor</div>
                    <div class="detail-value">Dr. Smith</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>