<?php

require_once '../user.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'student') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$student = $user->fetch($_SESSION['account']['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Account - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="student-styles.css">
</head>
<body>
    <?php include_once 'sidebar.php'; ?>
    <main class main-content>
        <section id="account-section">
            <div class="container">
                <div class="account-details">
                    <h2>Account Details</h2>
                    <div class="detail">
                        <label>First Name:</label>
                        <span><?= htmlspecialchars($student['first_name']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Middle Name:</label>
                        <span><?= htmlspecialchars($student['middle_name']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Last Name:</label>
                        <span><?= htmlspecialchars($student['last_name']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($student['email']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Username:</label>
                        <span><?= htmlspecialchars($student['username']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Date of Birth:</label>
                        <span><?= htmlspecialchars($student['date_of_birth']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Contact Number:</label>
                        <span><?= htmlspecialchars($student['contact_num']) ?></span>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
