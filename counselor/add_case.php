<?php
require_once '../cases.class.php'; // Include the Cases class
require_once '../user.class.php'; // Include the User class
require_once '../report.class.php'; // Include the User class

// Initialize classes
$case = new Cases(); // Assuming you have a Cases class
$user = new User();
$report = new Report();


// Fetch students and counselors from the database
$students = $user->getStudents();
$counselors = $user->getCounselors();

$message = "";
$result = false;

// Check if report data is available
if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];
    $report = new Report();
    $reportCase = $report->fetch($report_id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input values
    $student_id = $_POST['student_id'] ?? null;
    $counselor_id = $_POST['counselor_id'] ?? null;
    $case_description = $_POST['case_description'] ?? null;
    $status = $_POST['status'] ?? null; // Make sure this comes from the form if it's needed

    // Instead of using properties, directly call the add method
    $result = $case->add($student_id, $counselor_id, $case_description, $status);

    // Set message based on result
    if ($result) {
        $message = "Case has been submitted successfully!";
        header('location: cases_view.php');
    } else {
        $message = "Failed to submit the case. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Case - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <link rel=stylesheet href="form-styles.css">
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
        <h2>Add a New Case</h2>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="<?= $result ? 'message' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <!-- Student Name Dropdown -->
            <label for="student_id">Select Student</label>
            <?php if(isset($_GET['report_id'])): ?>
                <input type="text" name="student_id" value="<?php echo $reportCase['student_id']; ?>" hidden readonly>
                <input type="text" value="<?php echo $reportCase['student_first_name'] . ' ' . $reportCase['student_last_name']; ?>" readonly>
            <?php else: ?>
            <div class="form-row">
                <input type="text" id="searchStudent" placeholder="Search by Name or Student ID" onkeyup="filterStudents()">
                <select name="student_id" id="student_id" required>
                    <option value="">Select a student</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?php echo $student['user_id']; ?>">
                            <?php echo $student['first_name'] . ' ' . $student['last_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

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

            <!-- Case Description -->
            <label for="case_description">Case Description</label>
            <textarea id="case_description" name="case_description" rows="5" 
            value = "<?= isset($case_description) ?>"
            required></textarea>

            <!-- Case Status -->
            <label for="status">Case Status</label>
            <select id="status" name="status" required>
                <option value="">Select Status</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
                <option value="in_progress">In Progress</option>
            </select>

            <button type="submit" class="btn">Submit Case</button>
        </form>
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