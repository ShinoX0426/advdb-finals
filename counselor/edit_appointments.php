<?php
require_once '../appointment.class.php';
require_once '../user.class.php';
// Initialize objects
$appointment = new Appointment();
$user = new User();

// Check if an appointment ID was provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Fetch the appointment details
    $appointmentData = $appointment->fetch($id);
    if (!$appointmentData) {
        echo "Appointment not found!";
        exit;
    }
} else {
    echo "No appointment ID provided!";
    exit;
}

// Get lists of students and counselors for dropdowns
$students = $user->getStudents();
$counselors = $user->getCounselors();

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
    $counselor_id = filter_input(INPUT_POST, 'counselor_id', FILTER_VALIDATE_INT);
    $request_date = htmlspecialchars($_POST['request_date'] ?? '');
    $status = htmlspecialchars($_POST['status'] ?? '');
    $reason = htmlspecialchars($_POST['reason'] ?? '');

    // Validate required fields
    if (!$student_id || !$counselor_id || !$request_date || !$status) {
        $error = "All required fields must be filled out!";
    } else {
        // Validate appointment date
        $date = DateTime::createFromFormat('Y-m-d', $request_date);
        if (!$date || $date->format('Y-m-d') !== $request_date) {
            $error = "Invalid appointment date!";
        } else {
            // Update appointment details
            $appointment->student_id = $student_id;
            $appointment->counselor_id = $counselor_id;
            $appointment->request_date = $request_date;
            $appointment->status = $status;
            $appointment->reason = $reason;
            try {
                $result = $appointment->update($id);
                if ($result) {
                    header("Location: appointments_view.php?success=1");
                    exit;
                }
            } catch (PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment Request</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0f3978;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #0d2e63;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Appointment Request</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="student_id">Student:</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['user_id']; ?>" 
                            <?php echo ($appointmentData['student_id'] == $student['user_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="counselor_id">Counselor:</label>
                <select name="counselor_id" id="counselor_id" class="form-control" required>
                    <option value="">Select Counselor</option>
                    <?php foreach ($counselors as $counselor): ?>
                        <option value="<?php echo $counselor['user_id']; ?>"
                            <?php echo ($appointmentData['counselor_id'] == $counselor['user_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($counselor['first_name'] . ' ' . $counselor['last_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="request_date">Appointment Date:</label>
                <input type="date" name="request_date" id="request_date" class="form-control" 
                    value="<?php echo htmlspecialchars($appointmentData['request_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" <?php echo ($appointmentData['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo ($appointmentData['status'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="rejected" <?php echo ($appointmentData['status'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                </select>
            </div>
            <div class="form-group">
                <label for="reason">Reason:</label>
                <textarea name="reason" id="reason" class="form-control" rows="5" required><?php echo htmlspecialchars($appointmentData['reason']); ?></textarea>
            </div>
            <button type="submit" class="btn">Update Appointment</button>
        </form>
    </div>
</body>
</html>