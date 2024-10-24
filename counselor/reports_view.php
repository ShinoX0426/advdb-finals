<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Don Pablo Guidance Counseling</title>
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

        .report-filters {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .report-filters select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            min-width: 150px;
        }

        .report-card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 15px;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .report-header h3 {
            color: #0f3978;
            margin: 0;
        }

        .report-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-reviewed {
            background: #d4edda;
            color: #155724;
        }

        .report-content {
            margin: 15px 0;
        }

        .report-content p {
            margin: 8px 0;
            color: #555;
        }

        .report-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-primary {
            background-color: #0f3978;
        }

        .btn-success {
            background-color: #28a745;
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
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="students_view.php"><i class="fas fa-users"></i> Students</a></li>
                <li><a href="appointment_view.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                <li><a href="cases_view.php"><i class="fas fa-file-alt"></i> Cases</a></li>
                <li><a href="reports_view.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="dashboard-header">
                <h2>Teacher Reports</h2>
                <button class="btn" onclick="generateReport()">Generate PDF Report</button>
            </div>

            <div class="report-filters">
                <select id="teacherFilter">
                    <option value="">All Teachers</option>
                    <!-- Teachers will be populated dynamically -->
                </select>

                <select id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                </select>

                <button class="btn btn-primary" onclick="loadReports()">Apply Filters</button>
            </div>

            <div id="reportsContainer">
                <!-- Reports will be populated dynamically -->
            </div>
        </div>
    </div>

    <script>
        // Fetch and display reports
        function loadReports(filters = {}) {
            fetch('teacher-reports.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'get_all',
                    ...filters
                })
            })
                .then(response => response.json())
                .then(reports => {
                    const container = document.getElementById('reportsContainer');
                    container.innerHTML = reports.map(report => `
                        <div class="report-card">
                            <div class="report-header">
                                <h3>${report.teacher_name} - ${report.subject}</h3>
                                <span class="report-status status-${report.status}">${report.status}</span>
                            </div>
                            <div class="report-content">
                                <p><strong>Type:</strong> ${report.report_type}</p>
                                <p><strong>Description:</strong> ${report.description}</p>
                                <p><strong>Date:</strong> ${report.created_at}</p>
                            </div>
                            <div class="report-actions">
                                <button class="btn btn-primary" onclick="viewDetails(${report.id})">View Details</button>
                                ${report.status === 'pending' ?
                            `<button class="btn btn-success" onclick="markAsReviewed(${report.id})">Mark as Reviewed</button>` :
                            ''
                        }
                            </div>
                        </div>
                    `).join('');
                });
        }

        // Mark report as reviewed
        function markAsReviewed(reportId) {
            fetch('teacher-reports.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'update_status',
                    report_id: reportId,
                    status: 'reviewed'
                })
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        loadReports();
                    }
                });
        }

        // Generate PDF report
        function generateReport() {
            window.location.href = 'generate-report.php';
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            loadReports();

            // Event listeners for filters
            document.getElementById('teacherFilter').addEventListener('change', (e) => {
                loadReports({ teacher_id: e.target.value });
            });

            document.getElementById('statusFilter').addEventListener('change', (e) => {
                loadReports({ status: e.target.value });
            });
        });
    </script>
</body>

</html>