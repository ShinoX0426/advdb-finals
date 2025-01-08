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

    // Assuming $result is the return value from the appointment submission method
    if ($result) {
        if (is_array($result) && isset($result['success'])) {
            // If $result is an array with a 'success' key (as in the previous example)
            if ($result['success']) {
                $message = "Appointment request has been submitted successfully!";
                if (isset($result['appointment_id'])) {
                    $message .= " Your appointment ID is: " . $result['appointment_id'];
                }
            } else {
                $message = "Failed to submit the appointment request. ";
                if (isset($result['message'])) {
                    $message .= $result['message'];
                }
                if (isset($result['error'])) {
                    // Log the detailed error for debugging
                    error_log("Appointment request error: " . $result['error']);
                }
            }
        } else {
            // If $result is just a boolean true
            $message = "Appointment request has been submitted successfully!";
        }
    } else {
        $message = "Failed to submit the appointment request. Please try again. ";
        if (method_exists($appointment, 'getError')) {
            $errorDetails = $appointment->getError();
            // Log the detailed error for debugging
            error_log("Appointment request error: " . $errorDetails);
            // Optionally add a generic message for the user
            $message .= "An unexpected error occurred.";
        }
    }

    // Display the message to the user
    echo $message;

    // Optionally, you might want to set a session message or redirect:
// $_SESSION['message'] = $message;
// header("Location: appointment_confirmation.php");
// exit();
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

        .main-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        select,
        input,
        textarea {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }

        textarea {
            resize: none;
        }

        .btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .message {
            margin-bottom: 20px;
            color: green;
            font-weight: bold;
        }

        .error {
            margin-bottom: 20px;
            color: red;
            font-weight: bold;
        }

        .back-link {
            text-align: center;
            margin-top: 10px;
        }

        .back-link a {
            color: #0f3978;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
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
        </nav>
    </header>
    <div class="main-container">
        <h2>Set an Appointment</h2>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="<?= $result ? 'message' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Student Name Dropdown -->
            <label for="student_id">Select Student</label>
            <input type="text" id="searchStudent" placeholder="Search by Name or Student ID" onkeyup="filterStudents()">
            <select name="student_id" id="student_id" required>
                <option value="">Select a student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['user_id'] ?>"><?= $student['first_name'] . ' ' . $student['last_name'] ?></option>
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
        <div class="back-link">
            <a href="appointments_view.php">Back to Student List</a>
        </div>
    </div>

    <script>
function filterStudents() {
    let input = document.getElementById('searchStudent');
    let filter = input.value.toLowerCase();
    let select = document.getElementById('student_id');
    let options = select.getElementsByTagName('option');
    let matchFound = false;

    // Add "No matches" option if it doesn't exist
    let noMatch = select.querySelector('.no-matches');
    if (!noMatch) {
        noMatch = document.createElement('option');
        noMatch.textContent = 'No matches found';
        noMatch.className = 'no-matches';
        noMatch.disabled = true;
        select.appendChild(noMatch);
    }

    // Filter options
    for (let i = 0; i < options.length; i++) {
        if (options[i].className === 'no-matches') continue;
        
        let text = options[i].text.toLowerCase();
        if (text.indexOf(filter) > -1) {
            options[i].style.display = '';
            matchFound = true;
        } else {
            options[i].style.display = 'none';
        }
    }

    // Show/hide "No matches" option
    noMatch.style.display = matchFound ? 'none' : '';
    
    // Clear "No matches" when search is empty
    if (filter === '') {
        noMatch.style.display = 'none';
    }
}
</script>
</body>

</html>