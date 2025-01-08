<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Subjects</title>\
    <link rel="stylesheet" href="student-styles.css">
</head>

<body>
<?php include 'sidebar.php'; ?>
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