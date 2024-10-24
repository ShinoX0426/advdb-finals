<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attendance Dashboard</title>
    <style>
        :root {
            --warning-color: #e74c3c;
            --background-color: #f4f6f9;
            --card-background: #ffffff;
            --text-color: #333333;
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

        .main-content {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
        }

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

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: white;
            margin: 0;
        }

        .heading1 {
            color: black;
            margin: 0;
        }

        .overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .card h2 {
            font-size: 18px;
            margin-top: 0;
            color: var(--text-color);
        }

        .card .value {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }

        .attendance-chart {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .attendance-history {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
        }

        .present {
            background-color: #2ecc71;
            color: white;
        }

        .absent {
            background-color: #e74c3c;
            color: white;
        }

        @media (max-width: 768px) {
            .overview {
                grid-template-columns: 1fr;
            }
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
        <div class="dashboard">
            <div class="header">
                <h1 class="heading1">Attendance Dashboard</h1>
            </div>

            <div class="overview">
                <div class="card">
                    <h2>Overall Attendance</h2>
                    <div class="value" style="color: #3498db;">92%</div>
                    <p>Academic Year 2023-2024</p>
                </div>
                <div class="card">
                    <h2>Present Days</h2>
                    <div class="value" style="color: #2ecc71;">87</div>
                    <p>Out of 95 total days</p>
                </div>
                <div class="card">
                    <h2>Absent Days</h2>
                    <div class="value" style="color: var(--warning-color);">8</div>
                    <p>Requires attention</p>
                </div>
            </div>

            <div class="attendance-chart">
                <h2>Monthly Attendance Trend</h2>
                <!-- Placeholder for a chart -->
                <p>Chart showing monthly attendance percentage would go here.</p>
            </div>

            <div class="attendance-history">
                <h2>Recent Attendance History</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Subject</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-10-15</td>
                            <td><span class="status present">Present</span></td>
                            <td>Mathematics</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>2023-10-14</td>
                            <td><span class="status present">Present</span></td>
                            <td>Science</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>2023-10-13</td>
                            <td><span class="status absent">Absent</span></td>
                            <td>History</td>
                            <td>Medical Leave</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>