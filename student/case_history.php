<?php
session_start();
require_once '../Cases.class.php';

// Assuming the logged-in student's ID is stored in the session
$student_id = $_SESSION['account']['user_id'];

$cases = new Cases();
$student_cases = $cases->getByStudent($student_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Cases - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Include the existing styles from dashboard.php */
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

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            color: #0f3978;
        }

        .cases-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #0f3978;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-open {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-closed {
            background-color: #d1fae5;
            color: #065f46;
        }

        .case-description {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .view-details {
            color: #0f3978;
            text-decoration: none;
            font-weight: 500;
        }

        .view-details:hover {
            text-decoration: underline;
        }

        .no-cases {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
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
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['account']['first_name'] . ' ' . $_SESSION['account']['last_name']); ?></span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="account.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
            <li><a href="set_appointment.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
            <li><a href="classlist.php"><i class="fas fa-list"></i> Class List</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="page-header">
                <h2>Your Cases</h2>
                <p>View all your cases and their status</p>
            </div>

            <div class="cases-container">
                <div class="mb-3">
                    <input type="text" id="searchInput" class="form-control" onkeyup="searchTable()" placeholder="Search for cases..">
                </div>
                <?php if (!empty($student_cases)) : ?>
                    <table id="casesTable">
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Counselor ID</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($student_cases as $case) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($case['case_id']); ?></td>
                                    <td><?php echo htmlspecialchars($case['counselor_id']); ?></td>
                                    <td class="case-description"><?php echo htmlspecialchars($case['case_description']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($case['case_status']); ?>">
                                            <?php echo ucfirst(htmlspecialchars($case['case_status'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($case['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($case['last_updated']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <div class="no-cases">
                        <p>No cases found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("casesTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>