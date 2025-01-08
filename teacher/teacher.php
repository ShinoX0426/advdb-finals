<?php

require_once '../user.class.php';
require_once '../cases.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$case = new Cases();

$students = $user->getStudents();
$totalStudents = count($students);
$newRegistrations = $user->getNewRegistrations(); // Assuming you have a method to get new registrations
$studentsWithCases = $case->getStudentsWithCases(); // Assuming you have a method to get students with cases


$teacher = $user->fetch($_SESSION['account']['user_id']);
$teacherName = $teacher['first_name'] . ' ' . $teacher['last_name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="teacher-dashboard.css">
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
    
<?= include 'navbar-include.php' ?>

<main>
    <section id="hero-section">
        <div class="teacher-profile">
            <div class="teacher-info">
                <h1><?= $teacherName ?></h1>
                <p>Mathematics Teacher</p>
            </div>
        </div>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Managed Students</h3>
                <p><?= $totalStudents ?></p>
            </div>
            <div class="card">
                <h3>Students with Cases</h3>
                <p><?= count($studentsWithCases) ?></p>
            </div>
            <div class="card">
                <h3>New Registrations</h3>
                <p><?= count($newRegistrations) ?></p>
            </div>
        </div>
    </section>

    <section id="recent-cases">
        <div class="container">
            <h2>Recent Cases</h2>
            <table>
                <thead>
                    <tr>
                        <th>Case ID</th>
                        <th>Student Name</th>
                        <th>Case Description</th>
                        <th>Date Reported</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row, you should fetch and display real data from your database -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Bullying</td>
                        <td>2023-10-01</td>
                        <td>Open</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Roe</td>
                        <td>Cheating</td>
                        <td>2023-10-02</td>
                        <td>Closed</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section id="students">
        <div class="container">
            <h2>Students</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Section</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example row, you should fetch and display real data from your database -->
                    <tr>
                        <td>1001</td>
                        <td>John Doe</td>
                        <td>10</td>
                        <td>A</td>
                        <td><a href="#">View Profile</a></td>
                    </tr>
                    <tr>
                        <td>1002</td>
                        <td>Jane Roe</td>
                        <td>10</td>
                        <td>B</td>
                        <td><a href="#">View Profile</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>

</html>