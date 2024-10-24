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
    $parent_id = filter_input(INPUT_POST, 'parent_id', FILTER_VALIDATE_INT);
    $counselor_id = filter_input(INPUT_POST, 'counselor_id', FILTER_VALIDATE_INT);
    $request_date = htmlspecialchars($_POST['request_date'] ?? '');
    $status = htmlspecialchars($_POST['status'] ?? '');
    $reason = htmlspecialchars($_POST['reason'] ?? '');

    // Validate required fields
    if (!$student_id || !$counselor_id || !$request_date || !$status) {
        $error = "All required fields must be filled out!";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment Request</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #eee;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }

        select.form-control {
            background-color: white;
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-weight: 500;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #4a90e2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #357abd;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            margin-left: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .form-group:last-child {
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        /* Status-specific colors */
        select[name="status"] option[value="pending"] {
            color: #f59e0b;
        }

        select[name="status"] option[value="approved"] {
            color: #10b981;
        }

        select[name="status"] option[value="rejected"] {
            color: #ef4444;
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
                <textarea name="reason" id="reason" class="form-control" rows="4"><?php echo htmlspecialchars($appointmentData['reason']); ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Appointment</button>
                <a href="javascript:history.back()" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>