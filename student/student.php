<?php
require_once '../user.class.php';
require_once '../cases.class.php';

// Initialize classes
$user = new User();
$case = new Cases();

session_start();

// Fetch active cases for the logged-in student
$studentId = $_SESSION['account']['user_id']; // Assuming you have the student ID stored in the session
$activeCases = $case->getActiveCasesByStudentId($studentId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student-styles.css">
</head>

<body>

<?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h2>Welcome, Student</h2>
        <div class="case-section">
            <h3>Active Case</h3>
            <ul id="caseList">
                <?php if (!empty($activeCases)): ?>
                    <?php foreach ($activeCases as $case): ?>
                        <li><?php echo htmlspecialchars($case['case_description']); ?></li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>No active cases available.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</body>

</html>