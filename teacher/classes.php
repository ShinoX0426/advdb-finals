<?php

require_once '../user.class.php';
require_once '../classes.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$class = new Classes();

$teacher = $user->fetch($_SESSION['account']['user_id']);
$teacherName = $teacher['first_name'] . ' ' . $teacher['last_name'];

if (isset($_GET['delete_id'])) {
    $class->delete($_GET['delete_id']);
    // Redirect after delete to avoid re-delete on refresh
    header('Location: classes.php?info=deleted');
    exit();
}

// Handle adds
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $className = $_POST['class_name'];
    $description = $_POST['description'];
    $schedule = $_POST['schedule'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $validUntil = $_POST['valid_until'];

    if ($class->add($teacher['user_id'], $className, $description, $schedule, $startTime, $endTime, $validUntil)) {
        header('Location: classes.php?info=added');
        exit();
    } else {
        echo "<script>alert('Failed to add class');</script>";
    }
}

$classes = $class->getClassesByTeacher($teacher['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - Don Pablo Lorenzo Memorial High School</title>
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
    <section id="manage-classes">
        <div class="container">
            <h2>Manage Classes</h2>
            <form method="POST" action="classes.php">
                <h3>Add Class</h3>
                <div class="form-row">
                    <label for="class_name">Name:</label>
                    <input type="text" id="class_name" name="class_name" required>

                    <label for="schedule">Schedule:</label>
                    <input type="text" id="schedule" name="schedule" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="form-row">
                    <div>
                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="end_time" required>
                    </div>
                </div>
                <div>
                    <label for="valid_until">Valid Until:</label>
                    <input type="date" id="valid_until" name="valid_until">
                </div>
                <button type="submit">Add Class</button>
            </form>
            <h3>Classes</h3>
            <input type="text" id="search-bar" placeholder="Search for classes...">
            <table>
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Description</th>
                        <th>Schedule</th>
                        <th>Time Slot</th>
                        <th>Valid Until</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="classes-table">
                    <?php foreach ($classes as $Class): ?>
                        <tr>
                            <td><?= htmlspecialchars($Class['class_name']) ?></td>
                            <td><?= htmlspecialchars($Class['description']) ?></td>
                            <td><?= htmlspecialchars($Class['schedule']) ?></td>
                            <td><?= date('H:i', strtotime($Class['start_time'])) ?> - <?= date('H:i', strtotime($Class['end_time'])) ?></td>
                            <td><?= htmlspecialchars($Class['valid_until']) ?></td>
                            <td>
                                <a href="class_list.php?id=<?= $Class['class_id'] ?>">Class Students</a>
                                <a href="edit_class.php?id=<?= $Class['class_id'] ?>" class="edit-btn">Edit</a>
                                <a href="classes.php?delete_id=<?= $Class['class_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this class?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<script>
    document.getElementById('search-bar').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var rows = document.querySelectorAll('#classes-table tr');
        rows.forEach(function(row) {
            var className = row.cells[0].textContent.toLowerCase();
            if (className.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
</body>

</html>