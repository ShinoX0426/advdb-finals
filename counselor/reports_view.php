<?php
require_once '../report.class.php';
require_once '../user.class.php';

session_start();

$report = new Report();
$reports = $report->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $result = $report->delete($delete_id);

    if ($result) {
        $message = "Report has been deleted successfully!";
    } else {
        $message = "Failed to delete the report. Please try again.";
    }
}

if (isset($_GET['info'])) {
    $info = $_GET['info'];
    ?>
    <script>
        alert('<?= $info ?>');

        // Use JavaScript to remove the query parameter from the URL
        if (typeof history.replaceState === 'function') {
            var url = window.location.href;
            var newUrl = url.split('?')[0]; // Remove everything after '?'
            window.history.replaceState(null, '', newUrl); // Update the URL without reloading the page
        }
    </script>
    <?php
}

$user = new User();

$teacherId = $_SESSION['account']['user_id'];
$students = $user->getStudents();
$teacherReports = $report->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $report->teacher_id = $teacherId;
    $report->student_id = $_POST['student_id'];
    $report->report_description = $_POST['report_description'];

    $result = $report->add();

    if ($result['success']) {
        header('Location: reports.php');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>

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
            margin-bottom: 20px;
        }

        .report-filters input[type="text"],
        .report-filters select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .reports-table {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
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
            background-color: orange;
            color: white;
            border-radius: 10px;
        }

        .btn-small:hover {
            color: black;
            background-color: lightsalmon;
        }

        a {
            text-decoration: none;
        }
        .reports-table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th, td {
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.3s ease;
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.875rem;
            margin: 0 4px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view {
            background-color: #0f3978;
            color: white;
        }

        .btn-edit {
            background-color: #fd9619;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-small:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .report-filters {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .report-filters input[type="text"],
        .report-filters select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .report-filters input[type="text"]:focus,
        .report-filters select:focus {
            outline: none;
            border-color: #0f3978;
            box-shadow: 0 0 0 2px rgba(15, 57, 120, 0.1);
        }

        .highlight {
            background-color: #fff3cd;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        #report-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #report-section h2 {
            margin-bottom: 20px;
            color: #0f3978;
        }

        #report-section form {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }

        #report-section label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        #report-section input[type="text"],
        #report-section select,
        #report-section textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        #report-section input[type="text"]:focus,
        #report-section select:focus,
        #report-section textarea:focus {
            outline: none;
            border-color: #0f3978;
            box-shadow: 0 0 0 2px rgba(15, 57, 120, 0.1);
        }

        #report-section button[type="submit"] {
            background-color: #fd9619;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #report-section button[type="submit"]:hover {
            background-color: #e0851b;
        }

        .form-row {
            display: flex;
            align-items: center;
            gap: 10px;
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
            <li><a href="appointments_view.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
            <li><a href="cases_view.php"><i class="fas fa-file-alt"></i> Cases</a></li>
            <li><a href="reports_view.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="account.php"><i class="fa fa-user"></i> Account</a></li>
        </ul>
    </div>

        <div class="main-content">
        <div class="dashboard-header">
                <h2>Teacher Reports</h2>
                <h4 style="color:">View and update teachers' reports here...</h4>
            </div>
        <section id="report-section">
        <div class="container">
            <h2>Submit a New Report</h2>
            <?php if (isset($error)): ?>
                <p style="color: red;"><?= $error ?></p>
            <?php endif; ?>
            <form method="POST" action="reports.php">
                <div>
                <label for="student_id">Student</label>
                <div class="form-row">
                <input type="text" id="searchStudent" placeholder="Search by Name or Student ID" onkeyup="filterStudents()">
                    <select name="student_id" id="student_id" required>
                        <option value="">Select a student</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['user_id'] ?>"><?= $student['first_name'] . ' ' . $student['last_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                </div>
                <div>
                    <label for="report_description">Report Description</label>
                    <textarea name="report_description" id="report_description" rows="4" required></textarea>
                </div>
                <button type="submit">Submit Report</button>
            </form>
        </div>
    </section>
    <div class="dashboard-header">
                <h2>Reports Table</h2>
            </div>
            <div class="report-filters">
                <input type="text" placeholder="Search by teacher ID..." id="search-bar">
            </div>
            <div class="reports-table">
        <table id="reportsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Teacher Name</th>
                    <th>Student Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
                <?php $loopIndex = 1; ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= $loopIndex++ ?></td>
                        <td><?= htmlspecialchars($report['teacher_first_name'] . ' ' . $report['teacher_last_name']) ?></td>
                        <td><?= htmlspecialchars($report['student_first_name'] . ' ' . $report['student_last_name']) ?></td>
                        <td><?= htmlspecialchars($report['report_description']) ?></td>
                        <td><?= htmlspecialchars($report['report_date']) ?></td>
                        <td>
                            <button onclick="initiateCase(<?= $report['report_id'] ?>)" class="btn-small btn-view">Initiate Case</button>
                            <a href="edit_report.php?id=<?= $report['report_id'] ?>" class="btn-small btn-edit">Edit</a>
                            <button onclick="deleteReport(<?= $report['report_id'] ?>)" class="btn-small btn-delete">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        const searchBar = document.getElementById('search-bar');
        const filterStatus = document.getElementById('filter-status');
        const table = document.getElementById('reportsTable');
        const rows = table.getElementsByTagName('tr');

        function filterTable() {
            const searchTerm = searchBar.value.toLowerCase();
            const statusFilter = filterStatus.value.toLowerCase();
            let hasResults = false;

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                const teacherName = cells[1].textContent.toLowerCase();
                const studentName = cells[2].textContent.toLowerCase();
                
                const matchesSearch = teacherName.includes(searchTerm) || 
                                    studentName.includes(searchTerm) ||
                                    cells[0].textContent.toLowerCase().includes(searchTerm);

                if (matchesSearch) {
                    row.style.display = '';
                    hasResults = true;
                    
                    // Highlight matching text
                    if (searchTerm) {
                        cells[1].innerHTML = highlightText(cells[1].textContent, searchTerm);
                        cells[2].innerHTML = highlightText(cells[2].textContent, searchTerm);
                    }
                } else {
                    row.style.display = 'none';
                }
            }

            // Show no results message if needed
            const noResultsRow = document.getElementById('noResultsRow');
            if (!hasResults) {
                if (!noResultsRow) {
                    const tbody = table.getElementsByTagName('tbody')[0];
                    const newRow = tbody.insertRow();
                    newRow.id = 'noResultsRow';
                    const cell = newRow.insertCell(0);
                    cell.colSpan = 6;
                    cell.className = 'no-results';
                    cell.textContent = 'No matching records found';
                }
            } else if (noResultsRow) {
                noResultsRow.remove();
            }
        }

        function highlightText(text, searchTerm) {
            if (!searchTerm) return text;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        function initiateCase(reportId) {
            if (confirm('Are you sure you want to initiate a case from this report?')) {
                // Add your case initiation logic here
                window.location.href = `add_case.php?report_id=${reportId}`;
            }
        }

        function deleteReport(reportId) {
            if (confirm('Are you sure you want to delete this report?')) {
                window.location.href = `reports_view.php?delete_id=${reportId}`;
            }
        }

        // Event listeners
        searchBar.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);

        // Initialize filtering
        filterTable();
    </script>
</body>

</html>