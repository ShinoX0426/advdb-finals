<?php
require_once '../user.class.php';
require_once '../cases.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$case = new Cases();

$students = $user->getStudents();
$totalStudents = count($students);
$newRegistrations = $user->getNewRegistrations();
$studentsWithCases = $case->getStudentsWithCases();

$teacher = $user->fetch($_SESSION['account']['user_id']);
$teacherName = $teacher['first_name'] . ' ' . $teacher['last_name'];

$parents = [];
$parents = $user->getParent();

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['info']) && $_GET == "edit_success"){
    if ($_GET['info'] == "edit_success") {
        echo "<div id='success-message'>Edit Successful!</div>";
    } elseif ($_GET['info'] == "edit_failed") {
        echo "<div id='error-message'>Edit Failed!</div>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['enable-id'])) {
    $user->enable($_GET['enable-id']);
    header('location: students.php?info=success');
    exit();
}

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

    if ($result == 'Success') {
        header('location: students.php?info=account_created');
        exit();
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
    <title>Teacher Students View - Don Pablo Lorenzo Memorial High School</title>
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
        table th {
            text-align: center;
        }

        .btn-small {
            color: white;
            background-color: #CC7722;
            display: block;
            margin-bottom: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-small:hover {
            background-color: #A0522D;
        }

        #actions-td{
            text-align: center;
        }

        #success-message{
            padding: 1rem;
            font-weight: bold;
            color: white;
            background-color: #009E60;
            width: 100%;
            border-radius: 10px;
        }

        #error-message{
            padding: 1rem;
            display:flex;
            font-weight: bold;
            color: white;
            background-color: red;
            width: 100%;
            border-radius: 10px;
        }
        
        #error-message p{
            margin-left: 1rem;
            font-weight: normal;
        }


        .disabled-row {
            color: white;
            background-color:rgba(255, 0, 0, 0.73);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<?php include 'navbar-include.php' ?>

<main>
    <section id="hero-section">
        <div class="teacher-profile">
            <div class="teacher-info">
                <h1><?= $teacherName ?></h1>
                <p>Mathematics Teacher</p>
            </div>
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
    </section>

    <section class="register-container">
        <h2>Add Student</h2>
        <form id="addAccountForm" method="POST" action="">
            <?php if(isset($_GET['info']) && $_GET['info'] == "edit_failed"){
                ?>
                <div class="error" id="error-message">Edit Failed</div><?php
            }
            ?>
            <?php if(isset($_GET['info']) && $_GET['info'] == "account_created"){
                ?>
                <div class="success" id="success-message">Account Created!</div><?php
            }
            ?>

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

            <button class="btn-small" type="submit" name="register">Register</button>
        </form>
    </section>

    <section id="students">
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
                        <th>Name</th>
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
                            <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['middle_name'] . ' ' . $student['last_name']) ?></td>
                            <td><?= htmlspecialchars($student['date_of_birth']) ?></td>
                            <td><?= htmlspecialchars($student['parent_first_name'] . ' ' . $student['parent_last_name']) ?></td>
                            <td><?= htmlspecialchars($student['contact_num']) ?></td>
                            <td id="actions-td">
                                <?php
                                if($student['is_disabled']) {
                                    echo '<a href="students.php?enable-id=' . $student['user_id'] . '" class="btn-small">Enable</a>';
                                } else {
                                    ?>
                                    <a href="edit_students.php?id=<?= $student['user_id'] ?>" class="btn-small">Update</a>
                                    <?php
                                    echo '<a href="disable.php?id=' . $student['user_id'] . '" class="btn-small">Disable</a>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>

</html>