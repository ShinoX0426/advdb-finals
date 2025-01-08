<?php

require_once '../user.class.php';
require_once '../report.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$report = new Report();

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
    <title>Teacher Reports - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="teacher-dashboard.css">
    <link rel="stylesheet" href="form-styles.css">
    <style>
        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 5rem;
            height: auto;
            margin-right: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<?php include 'navbar-include.php' ?>

<main>
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

    <section id="past-reports">
        <div class="container">
            <h2>Past Reports</h2>
            <input type="text" name="searchTable" id="searchTable" placeholder="Search reports" onkeyup="searchReports()" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px;">
            <table>
                <thead>
                    <tr>
                        <th>Report ID</th>
                        <th>Student Name</th>
                        <th>Report Description</th>
                        <th>Report Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teacherReports as $report): ?>
                        <tr>
                            <td><?= $report['report_id'] ?></td>
                            <td><?= $report['student_first_name'] . ' ' . $report['student_last_name'] ?></td>
                            <td><?= $report['report_description'] ?></td>
                            <td><?= $report['report_date'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<script>
function filterStudents() {
    let input = document.getElementById('searchStudent');
    let filter = input.value.toLowerCase();
    let select = document.getElementById('student_id');
    let options = select.getElementsByTagName('option');
    let matchFound = false;

    // Add "No matches" option if it doesn't exist
    let noMatch = select.querySelector('.no-matches');
    if (!noMatch) {
        noMatch = document.createElement('option');
        noMatch.textContent = 'No matches found';
        noMatch.className = 'no-matches';
        noMatch.disabled = true;
        select.appendChild(noMatch);
    }

    // Filter options
    for (let i = 0; i < options.length; i++) {
        if (options[i].className === 'no-matches') continue;
        
        let text = options[i].text.toLowerCase();
        if (text.indexOf(filter) > -1) {
            options[i].style.display = '';
            matchFound = true;
        } else {
            options[i].style.display = 'none';
        }
    }

    // Show/hide "No matches" option
    noMatch.style.display = matchFound ? 'none' : '';
    
    // Clear "No matches" when search is empty
    if (filter === '') {
        noMatch.style.display = 'none';
    }
}
</script>

<script>
function searchReports() {
    let input = document.getElementById('searchTable');
    let filter = input.value.toLowerCase();
    let table = document.querySelector('#past-reports table');
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let display = 'none';
        
        for (let j = 0; j < td.length; j++) {
            let text = td[j].textContent || td[j].innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                display = '';
                break;
            }
        }
        tr[i].style.display = display;
    }

    // Show "No results" message if no matches
    let noResults = document.getElementById('noResults');
    if (!noResults) {
        noResults = document.createElement('tr');
        noResults.id = 'noResults';
        noResults.innerHTML = '<td colspan="4" style="text-align: center;">No matching reports found</td>';
        table.appendChild(noResults);
    }
    
    let hasVisibleRows = false;
    for (let i = 1; i < tr.length; i++) {
        if (tr[i].id !== 'noResults' && tr[i].style.display !== 'none') {
            hasVisibleRows = true;
            break;
        }
    }
    noResults.style.display = hasVisibleRows ? 'none' : '';
}
</script>

</body>

</html>