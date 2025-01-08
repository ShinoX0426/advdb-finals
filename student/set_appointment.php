<?php
session_start();
require_once '../appointment.class.php';
require_once '../user.class.php';

// Initialize classes
$appointment = new Appointment();
$user = new User();

// Fetch all counselors
$counselors = $user->getCounselors();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['account']['user_id'];
    $counselor_id = $_POST['counselor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $description = $_POST['description'];

    $appointment->setAppointment($student_id, $counselor_id, $appointment_date, $appointment_time, $description);
    header('Location: set_appointment.php?success=1');
    exit();
}
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
        /* Include the existing styles from case_history.php */
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
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .page-header h2 {
            color: #0f3978;
        }

        .form-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group button {
            background-color: #0f3978;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0d2e63;
        }

        .success-message {
            color: green;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #0f3978;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
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
                <h2>Set an Appointment</h2>
                <p>Choose a counselor and set an appointment</p>
            </div>

            <div class="form-container">
                <?php if (isset($_GET['success'])) : ?>
                    <div class="success-message">Appointment set successfully!</div>
                <?php endif; ?>

                <form method="POST" action="set_appointment.php">
                    <div class="form-group">
                        <label for="counselor_id">Choose Counselor</label>
                        <select id="counselor_id" name="counselor_id" required>
                            <option value="">Select a counselor</option>
                            <?php foreach ($counselors as $counselor) : ?>
                                <option value="<?php echo htmlspecialchars($counselor['user_id']); ?>">
                                    <?php echo htmlspecialchars($counselor['first_name'] . ' ' . $counselor['last_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" required>
                    </div>

                    <div class="form-group">
                        <label for="appointment_time">Appointment Time</label>
                        <input type="time" id="appointment_time" name="appointment_time" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit">Set Appointment</button>
                    </div>
                </form>
            </div>

            <div class="page-header">
                <h2>Past Appointments</h2>
            </div>

            <?php
            $student_id = $_SESSION['account']['user_id'];
            $past_appointments = $appointment->getByStudent($student_id);
            ?>

            <?php if (!empty($past_appointments)) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Counselor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($past_appointments as $appointment) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['counselor_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['request_date']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['reason']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No past appointments found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>