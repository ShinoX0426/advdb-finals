<?php
require_once '../user.class.php';
require_once '../cases.class.php'; // Include the Cases class

$user = new User();
$case = new Cases(); // Assuming you have a Cases class

$students = $user->getStudents();
$totalStudents = count($students);
$newRegistrations = $user->getNewRegistrations(); // Assuming you have a method to get new registrations
$studentsWithCases = $case->getStudentsWithCases(); // Assuming you have a method to get students with cases

// var_dump($students);

if (isset($_GET['info'])) {
    $info = $_GET['info'];
    ?>
    <script>
        alert('<?= $info ?>');

        // Use JavaScript to remove the query parameter from the URL
        if (typeof history.replaceState === 'function') {
            var url = window.location.href;
            var newUrl = url.split('?')[0]; // Remove everything after '?'
            window.history.replaceState(null, '', newUrl); // Update the URL without reloading the page
        }
    </script>
    <?php
}

$parents = [];
$parents = $user->getParent();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    $firstName = $user->clean_input($_POST['firstName']);
    $middleName = $user->clean_input($_POST['middleName']);
    $lastName = $user->clean_input($_POST['lastName']);
    $username = $user->clean_input($_POST['username']);
    $email = $user->clean_input($_POST['email']);
    $password = $user->clean_input($_POST['password']);
    $confirmPassword = $user->clean_input($_POST['confirmPassword']);
    $userType = $user->clean_input("student");
    $dob = $user->clean_input($_POST['dob']);
    $contact = $user->clean_input($_POST['contact']);
    $parentId = $user->clean_input($_POST['parentId']);

    $result = $user->register(
        $firstName, 
        $middleName, 
        $lastName, 
        $email,
        $username, 
        $password, 
        $confirmPassword, 
        $userType, 
        $dob, 
        $contact, 
        $parentId);

    if ($result === 'Success') {
        echo "<script>document.getElementById('success-message').textContent = 'Account created successfully!';</script>";
        header('location: students_view.php?info=Account created successfully!');
    } else {
        echo "<script>document.getElementById('error-message').textContent = '$result';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students View - Don Pablo Guidance Counseling</title>
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
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

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #fd9619;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .dashboard-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 30%;
        }

        .card h3 {
            margin-top: 0;
            color: #0f3978;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 0;
        }

        .filters {
            margin-bottom: 20px;
        }

        .filters input[type="text"],
        .filters select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-row select {
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-row select option {
            padding: 8px;
        }

        .form-row select option:hover {
            background-color: #f0f0f0;
        }

        .students-table {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .students-table h2{
            margin-bottom: 1rem;
            color: #0f3978;
        }

        .disabled-row {
        background-color: #ccc; /* You can change this color as needed */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-small {
            padding: 0.25rem;
            margin: 0.5rem;
            font-size: 0.875rem;

            background-color: orange;
            color: white;
            border-radius: 10px;
        }

        .btn-small:hover {
            color: black;
            background-color: lightsalmon;
        }


        a {
            text-decoration: none;
        }

        .register-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 0.1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .register-container h2 {
            margin-bottom: 0.25rem;
            color: #0f3978;
        }

        /* Form styling */
        #addAccountForm {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Rows for multiple inputs */
        .form-row {
            display: flex;
            gap: 1rem;
            width: 100%;
        }

        .form-row input[type="text"],
        .form-row input[type="email"],
        .form-row input[type="password"],
        .form-row input[type="date"],
        .form-row select {
            flex: 1;
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
                <span>Welcome, Counselor</span>
                <a href="../logout.php" class="logout-btn">Logout</a>
            </div>
        </nav>
    </header>
    <div class="dashboard-container">
        <div class="sidebar">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="students_view.php"><i class="fas fa-users"></i> Students</a></li>
                <li><a href="appointments_view.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
                <li><a href="cases_view.php"><i class="fas fa-file-alt"></i> Cases</a></li>
                <li><a href="reports_view.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="account.php"><i class="fa fa-user"></i> Account</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="dashboard-header">
                <h2>Students Overview</h2>
            </div>
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total Students</h3>
                    <p><?= $totalStudents ?></p>
                </div>
                <div class="card">
                    <h3>Students with Cases</h3>
                    <p><?= count($studentsWithCases) ?></p>
                </div>
                <div class="card">
                    <h3>New Registrations</h3>
                    <p><?= count($newRegistrations) ?></p>
                </div>
            </div>
            <div class="register-container">
                <h2>Add Student</h2>
                <form id="addAccountForm" method="POST" action="">
                    <div class="error" id="error-message"></div>
                    <div class="success" id="success-message"></div>

                    <!-- Row 1: firstName, middleName, lastName -->
                    <div class="form-row">
                        <input type="text" name="firstName" placeholder="First Name" required>
                        <input type="text" name="middleName" placeholder="Middle Name">
                        <input type="text" name="lastName" placeholder="Last Name" required>
                    </div>

                    <!-- Row 2: username, email -->
                    <div class="form-row">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <!-- Row 3: password, confirmPassword -->
                    <div class="form-row">
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
                    </div>

                    <!-- Single row for userType, dob, contact -->
                    <div class="form-row">
                        <input type="date" name="dob" placeholder="Date of Birth" required>
                        <input type="text" name="contact" placeholder="Contact Number" required>
                    </div>

                    <!-- Parent dropdown -->
                    <div class="form-row">
                        <input type="text" id="searchParent" placeholder="Search by Name or Parent ID">
                        <select name="parentId" required>
                            <option value="">Select Parent</option>
                            <?php foreach ($parents as $p): ?>
                                <option value="<?= $p['user_id'] ?>">
                                    <?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if(isset($result)): ?>
                        <p style="color: red; margin-bottom: 10px; margin-top: 10px;">
                            <?= $result ?>
                            <br>
                            <br>
                        </p>
                    <?php endif; ?>

                    <button class="btn-small" style="max-width:10%;" type="submit" name="register">Register</button>
                </form>
            </div>
            <div class="students-table">
                <h2>Students</h2>
                <div class="filters">
                    <input type="text" placeholder="Search by name..." id="search-bar">
                    <script>
                    document.getElementById('search-bar').addEventListener('keyup', function() {
                        let searchText = this.value.toLowerCase();
                        let tableRows = document.querySelector('table tbody').getElementsByTagName('tr');
                        
                        for (let row of tableRows) {
                            let cells = row.getElementsByTagName('td');
                            let found = false;
                            
                            for (let cell of cells) {
                                if (cell.textContent.toLowerCase().includes(searchText)) {
                                    found = true;
                                    break;
                                }
                            }
                            
                            row.style.display = found ? '' : 'none';
                        }
                    });
                    </script>

                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>DOB</th>
                            <th>Parent/Guardian</th>
                            <th>Contact</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr class="<?= $student['is_disabled'] ? 'disabled-row' : '' ?>">
                                <td><?= htmlspecialchars($student['user_id']) ?></td>
                                <td><?= htmlspecialchars($student['first_name']) ?></td>
                                <td><?= htmlspecialchars($student['middle_name']) ?></td>
                                <td><?= htmlspecialchars($student['last_name']) ?></td>
                                <td><?= htmlspecialchars($student['date_of_birth']) ?></td>
                                <td><?= htmlspecialchars($student['parent_first_name'] . ' ' . $student['parent_last_name']) ?>
                                </td>
                                <td><?= htmlspecialchars($student['contact_num']) ?></td>
                                <td>
                                    <a href="edit_students.php?id=<?= $student['user_id'] ?>" class="btn-small">Update</a>
                                    <a href="delete.php?id=<?= $student['user_id'] ?>" class="btn-small">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchParent');
    const parentSelect = document.querySelector('select[name="parentId"]');
    const originalOptions = Array.from(parentSelect.options);

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        // Clear current options except the first "Select Parent" option
        while (parentSelect.options.length > 1) {
            parentSelect.remove(1);
        }

        // Filter and add matching options
        originalOptions.forEach((option, index) => {
            if (index === 0) return; // Skip the "Select Parent" option
            
            // Check if search term matches either the option value (ID) or text (name)
            const matchesId = option.value.toLowerCase().includes(searchTerm);
            const matchesName = option.text.toLowerCase().includes(searchTerm);
            
            if (matchesId || matchesName) {
                parentSelect.add(option.cloneNode(true));
            }
        });

        // If no matches found, you might want to show a message
        if (parentSelect.options.length === 1 && searchTerm !== '') {
            const noMatchOption = new Option('No matches found', '', false, false);
            noMatchOption.disabled = true;
            parentSelect.add(noMatchOption);
        }
    });

    // Optional: Clear search when a parent is selected
    // parentSelect.addEventListener('change', function() {
    //     searchInput.value = '';
    //     // Restore all options
    //     while (parentSelect.options.length > 1) {
    //         parentSelect.remove(1);
    //     }
    //     originalOptions.forEach((option, index) => {
    //         if (index === 0) return;
    //         parentSelect.add(option.cloneNode(true));
    //     });
    // });
});
</script>
</body>

</html>