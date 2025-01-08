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

if (!isset($_GET['id'])) {
    header('Location: classes.php');
    exit();
}

$class_id = $_GET['id'];
$classData = $class->get($class_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $className = $_POST['class_name'];
    $description = $_POST['description'];
    $schedule = $_POST['schedule'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $validUntil = $_POST['valid_until'];

    $class->class_name = $className;
    $class->class_description = $description;

    if ($class->update($class_id)) {
        header('Location: classes.php?info=updated');
        exit();
    } else {
        echo "<script>alert('Failed to update class');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class - Don Pablo Lorenzo Memorial High School</title>
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
    <section id="edit-class">
        <div class="container">
            <h2>Edit Class</h2>
            <form method="POST" action="edit_class.php?id=<?= $class_id ?>">
                <div class="form-row">
                    <label for="class_name">Name:</label>
                    <input type="text" id="class_name" name="class_name" value="<?= htmlspecialchars($classData['class_name']) ?>" required>

                    <label for="schedule">Schedule:</label>
                    <input type="text" id="schedule" name="schedule" value="<?= htmlspecialchars($classData['schedule']) ?>" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"><?= htmlspecialchars($classData['description']) ?></textarea>
                </div>
                <div class="form-row">
                    <div>
                        <label for="start_time">Start Time:</label>
                        <input type="time" id="start_time" name="start_time" value="<?= htmlspecialchars($classData['start_time']) ?>" required>
                    </div>
                    <div>
                        <label for="end_time">End Time:</label>
                        <input type="time" id="end_time" name="end_time" value="<?= htmlspecialchars($classData['end_time']) ?>" required>
                    </div>
                </div>
                <div>
                    <label for="valid_until">Valid Until:</label>
                    <input type="date" id="valid_until" name="valid_until" value="<?= htmlspecialchars($classData['valid_until']) ?>">
                </div>
                <button type="submit">Update Class</button>
            </form>
        </div>
    </section>
</main>

</body>

</html>