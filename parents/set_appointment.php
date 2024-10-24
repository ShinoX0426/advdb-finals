<?php
session_start();
require_once '../user.class.php';
require_once '../appointment.class.php';

// Check if user is logged in and is a parent
if (!isset($_SESSION['account']) || $_SESSION['account']['user_type'] !== 'parent') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$appointment = new Appointment();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $student_id = $appointment->clean_input($_POST['student_id']);
    
    // Check if counselor_id is set in POST data
    $counselor_id = isset($_POST['counselor_id']) ? $appointment->clean_input($_POST['counselor_id']) : null;

    $request_date = $appointment->clean_input($_POST['request_date']);
    $reason = $appointment->clean_input($_POST['reason']);

    // Check if all necessary fields are provided
    if ($student_id && $counselor_id && $request_date && $reason) {
        // Add the appointment
        if ($appointment->add($student_id, $counselor_id, $request_date, $reason)) {
            // Appointment was added successfully
            $_SESSION['success'] = 'Appointment requested successfully!';
            header('Location: dashboard.php'); // Redirect to dashboard or another page
            exit();
        } else {
            // Handle error (e.g., display a message)
            $_SESSION['error'] = 'Failed to request appointment. Please try again.';
        }
    } else {
        $_SESSION['error'] = 'All fields are required.';
    }
}

// Fetch list of students for the dropdown
$counselors = $user->getCounselors();
$parentId = $_SESSION['account']['user_id'];
$children = $user->getStudents($parentId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Appointment - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
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

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            color: #0f3978;
        }

        .appointment-form {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #0f3978;
            font-weight: 500;
        }

        select, input[type="datetime-local"], textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        button[type="submit"] {
            background-color: #0f3978;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #0d2d5e;
        }

        .error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
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
                <li><a href="children.php"><i class="fas fa-users"></i> Your Children/Ward</a></li>
                <li><a href="set_appointment.php"><i class="fas fa-calendar-plus"></i> Set a Meeting</a></li>
                <li><a href="case_history.php"><i class="fas fa-history"></i> Case History</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="page-header">
                <h2>Set an Appointment</h2>
                <p>Schedule a meeting with a counselor</p>
            </div>

            <div class="appointment-form">
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="student_id">Select Child:</label>
                        <select name="student_id" required>
                            <?php foreach ($children as $child): ?>
                                <option value="<?php echo $child['user_id']; ?>">
                                    <?php echo htmlspecialchars($child['first_name'] . ' ' . $child['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="counselor_id">Select Counselor:</label>
                        <select name="counselor_id" required>
                            <option value="" disabled selected>Choose Counselor</option>
                            <?php foreach ($counselors as $counselor): ?>
                                <option value="<?php echo $counselor['user_id']; ?>">
                                    <?php echo htmlspecialchars($counselor['first_name'] . ' ' . $counselor['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="request_date">Request Date and Time:</label>
                        <input type="datetime-local" name="request_date" required>
                    </div>

                    <div class="form-group">
                        <label for="reason">Reason for Appointment:</label>
                        <textarea name="reason" required></textarea>
                    </div>

                    <button type="submit">Request Appointment</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>