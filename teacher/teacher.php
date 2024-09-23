<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="teacher-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header>
        <div class="container">
            <div class="teacher-profile">
                <img src="../images/teacher1.jpeg" alt="Teacher Photo" class="teacher-photo">
                <div class="teacher-info">
                    <h1>Ms. Jane Smith</h1>
                    <p>Mathematics Teacher</p>
                </div>
            </div>
            <nav>
                <ul>
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li><a href="#class-list">Class List</a></li>
                    <li><a href="#reports">Reports</a></li>
                </ul>
            </nav>
            <div class="user-actions">
                <a href="#" class="notifications"><i class="fas fa-bell"></i></a>
                <a href="../index.php" class="logout-btn" onclick="confirm(" Press a button!");"">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <section id="dashboard" class="dashboard">
            <h2>Dashboard</h2>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Students</h3>
                    <p>150</p>
                </div>
                <div class="card">
                    <h3>Average Attendance</h3>
                    <p>95%</p>
                </div>
                <div class="card">
                    <h3>Upcoming Events</h3>
                    <p>3</p>
                </div>
            </div>
        </section>

        <section id="class-list" class="class-list">
            <h2>Class List</h2>
            <div class="class-actions">
                <button id="addStudentBtn" class="btn">Add Student</button>
                <input type="text" id="searchStudent" placeholder="Search student...">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Performance</th>
                        <th>Attendance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                    <!-- More student rows here -->
                </tbody>
            </table>
        </section>

        <section id="student-profile" class="student-profile hidden">
            <h2>Student Profile</h2>
            <div class="profile-content">
                <div class="profile-image">
                    <img src="images/student-placeholder.jpg" alt="Student Photo">
                </div>
                <div class="profile-details">
                    <h3>John Doe</h3>
                    <p><strong>ID:</strong> 001</p>
                    <p><strong>Grade:</strong> 10</p>
                    <p><strong>Performance:</strong> Excellent</p>
                    <p><strong>Progress:</strong> Above Average</p>
                    <p><strong>Attendance:</strong> 98%</p>
                </div>
            </div>
            <div class="violation-section hidden">
                <h3>Violations/Penalties</h3>
                <ul>
                    <li>No violations recorded</li>
                </ul>
            </div>
        </section>

        <section id="reports" class="reports">
            <h2>Reports</h2>
            <form id="violationReportForm">
                <h3>Report Violation</h3>
                <select name="student" required>
                    <option value="">Select Student</option>
                    <option value="1">John Doe</option>
                    <!-- More student options -->
                </select>
                <input type="text" name="violation" placeholder="Violation description" required>
                <textarea name="details" placeholder="Additional details"></textarea>
                <button type="submit" class="btn">Submit Report</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 Don Pablo Lorenzo Memorial High School. All rights reserved.</p>
        </div>
    </footer>

    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Student</h2>
            <form id="addStudentForm">
                <input type="text" name="name" placeholder="Student Name" required>
                <input type="number" name="grade" placeholder="Grade" required>
                <input type="file" name="photo" accept="image/*">
                <button type="submit" class="btn">Add Student</button>
            </form>
        </div>
    </div>

    <script src="teacher-dashboard.js"></script>
</body>

</html>