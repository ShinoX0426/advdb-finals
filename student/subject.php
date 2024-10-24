<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Subjects</title>
    <style>
        /* Base styles (same as main dashboard) */
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

        /* Subjects specific styles */
        .subjects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .subject-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .subject-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #1e40af;
        }

        .subject-card p {
            color: #4b5563;
            margin-bottom: 15px;
        }

        .subject-card .teacher {
            font-style: italic;
            color: #6b7280;
        }

        .activities-list {
            list-style-type: none;
            margin-top: 15px;
        }

        .activities-list li {
            background-color: #f3f4f6;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
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
            <h2>My Subjects</h2>
            <a href="../logout.php" class="logout-btn">Logout</a>
        </header>
        <div class="subjects-grid">
            <div class="subject-card">
                <h3>Mathematics</h3>
                <p class="teacher">Teacher: Dr. Jane Smith</p>
                <p>Advanced Calculus and Linear Algebra</p>
                <ul class="activities-list">
                    <li>Homework due: Oct 20</li>
                    <li>Quiz: Oct 22</li>
                    <li>Group Project: Nov 5</li>
                </ul>
            </div>
            <div class="subject-card">
                <h3>Physics</h3>
                <p class="teacher">Teacher: Prof. John Doe</p>
                <p>Mechanics and Thermodynamics</p>
                <ul class="activities-list">
                    <li>Lab Report due: Oct 18</li>
                    <li>Midterm Exam: Oct 25</li>
                    <li>Research Paper: Nov 10</li>
                </ul>
            </div>
            <!-- Add more subject cards as needed -->
        </div>
    </div>
</body>

</html>