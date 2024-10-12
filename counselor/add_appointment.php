<?php
require_once '../appointment.class.php';
require_once '../user.class.php';

// Initialize classes
$appointment = new Appointment();
$user = new User();

// Fetch students and counselors from the database
$students = $user->getStudents();
$counselors = $user->getCounselors();

$message = "";
$result = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input values
    $student_id = $_POST['student_id'] ?? null;
    $counselor_id = $_POST['counselor_id'] ?? null;
    $request_date = $_POST['request_date'] ?? null;
    $reason = $_POST['reason'] ?? null;

    // Call the add method to insert the appointment
    $result = $appointment->add($student_id, $counselor_id, $request_date, $reason);

    if ($result) {
        $message = "Appointment request has been submitted successfully!";
    } else {
        $message = "Failed to submit the appointment request. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Appointment - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Similar styling as before */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        header { background-color: #0f3978; padding: 1rem; color: white; }
        nav { display: flex; justify-content: space-between; align-items: center; }
        .logo { display: flex; align-items: center; }
        .logo img { width: 40px; height: 40px; margin-right: 10px; }
        .main-container { max-width: 800px; margin: 50px auto; padding: 20px; background-color: white; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 10px; font-weight: bold; }
        select, input, textarea { padding: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px; width: 100%; }
        textarea { resize: none; }
        .btn { background-color: #fd9619; color: white; padding: 0.5rem 1rem; border: none; border-radius: 5px; cursor: pointer; }
        .message { margin-bottom: 20px; color: green; font-weight: bold; }
        .error { margin-bottom: 20px; color: red; font-weight: bold; }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logo.png" alt="Logo">
                <span>Don Pablo Guidance</span>
            </div>
        </nav>
    </header>
    <div class="main-container">
        <h2>Set an Appointment</h2>

        <!-- Display success or error message -->
        <?php if (isset($message)) : ?>
            <div class="<?= $result ? 'message' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Student Name Dropdown -->
            <label for="student_id">Select Student</label>
            <select id="student_id" name="student_id" required>
                <option value="">Select Student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= htmlspecialchars($student['user_id']) ?>">
                        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Counselor Dropdown -->
            <label for="counselor_id">Select Counselor</label>
            <select id="counselor_id" name="counselor_id" required>
                <option value="">Select Counselor</option>
                <?php foreach ($counselors as $counselor): ?>
                    <option value="<?= htmlspecialchars($counselor['user_id']) ?>">
                        <?= htmlspecialchars($counselor['first_name'] . ' ' . $counselor['last_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Appointment Date -->
            <label for="request_date">Appointment Date</label>
            <input type="date" id="request_date" name="request_date" required>

            <!-- Reason for Appointment -->
            <label for="reason">Reason for Appointment</label>
            <textarea id="reason" name="reason" rows="5" required></textarea>

            <button type="submit" class="btn">Submit Appointment</button>
        </form>
    </div>
</body>
</html>
