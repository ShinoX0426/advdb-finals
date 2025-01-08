<?php
require_once '../user.class.php';
require_once '../classes.class.php';
require_once '../database.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$class = new Classes();
$db = new Database();

$students = $user->getStudents();
$teacher = $user->fetch($_SESSION['account']['user_id']);
$teacherName = $teacher['first_name'] . ' ' . $teacher['last_name'];

$class_id = $_GET['id'] ?? null;
if (!$class_id) {
    error_log('Class ID is missing');
    header('Location: classes.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])){
    $student_id = $_GET['delete_id'];
    $class_id = $_GET['id'];

    $sql = "DELETE FROM classlist WHERE student_id = :student_id AND class_id = :class_id";
    $stmt = $db->connect()->prepare($sql);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':class_id', $class_id);

    if ($stmt->execute()) {
        header("Location: class_list.php?id=$class_id&info=removed");
        exit();
    } else {
        echo "<script>alert('Failed to remove student');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_type']) && $_POST['request_type'] === 'add_student') {
    $student_id = $_POST['student_id'];
    $enrollment_date = date('Y-m-d');
    $status = 'active';

    $sql = "INSERT INTO classlist (class_id, student_id, enrollment_date, status) 
            VALUES (:class_id, :student_id, :enrollment_date, :status)";
    $stmt = $db->connect()->prepare($sql);
    $stmt->bindParam(':class_id', $class_id);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':enrollment_date', $enrollment_date);
    $stmt->bindParam(':status', $status);

    if ($stmt->execute()) {
        header("Location: class_list.php?id=$class_id&info=added");
        exit();
    } else {
        echo "<script>alert('Failed to add student');</script>";
    }
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status']) && isset($_GET['update_id'])){
    $status = $_POST['status'];
    $student_id = $_GET['update_id'];
    $class_id = $_GET['id'];

    $sql = "UPDATE classlist SET status = :status 
    WHERE student_id = :student_id 
    AND class_id = :class_id";
    $stmt = $db->connect()->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':class_id', $class_id);

    if ($stmt->execute()) {
        header("Location: class_list.php?id=$class_id&info=updated");
        exit();
    } else {
        echo "<script>alert('Failed to update student');</script>";
    }
}

$sql = "SELECT classlist.*, users.first_name, users.last_name 
        FROM classlist 
        JOIN users ON classlist.student_id = users.user_id 
        WHERE classlist.class_id = :class_id";
$stmt = $db->connect()->prepare($sql);
$stmt->bindParam(':class_id', $class_id);
$stmt->execute();
$enrolledStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="teacher-dashboard.css">
    <link rel="stylesheet" href="form-styles.css">
</head>

<body>

<?php include 'navbar-include.php' ?>

<main>
    <section id="class-list">
        <div class="container">
            <h2>Class List</h2>
            <h4><a href="classes.php" style="margin-bottom:1rem; text-decoration:none; color:black;">Go Back</a></h4>
            <form method="POST" action="class_list.php?id=<?= $class_id ?>">
                <h3>Add Student</h3>
                <input type="text" name="request_type" value="add_student" hidden>
                <div class="form-row">
                <input type="text" id="searchStudent" placeholder="Search by Name or Student ID" onkeyup="filterStudents()">
                <select name="student_id" id="studentSelect" required>
                    <option value="">Select Student</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['user_id'] ?>">
                            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>
                <button type="submit">Add Student</button>
            </form>
            <h3>Students</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Enrollment Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enrolledStudents as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                            <td><?= htmlspecialchars(date('m-d-Y', strtotime($student['enrollment_date']))) ?></td>
                            <td><?= htmlspecialchars($student['status']) ?></td>
                            <td>
                                <div class="button-group">
                                    <a href="class_list.php?id=<?=$_GET['id']?>&update_id=<?= $student['student_id'] ?>" class="btn edit">Update Status</a>
                                    <a href="class_list.php?id=<?=$_GET['id']?>&delete_id=<?= $student['student_id'] ?>" class="btn delete">Remove from Class</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php if(isset($_GET['update_id'])): ?>
    <div class="modal" id="updateModal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <form method="POST" action="class_list.php?id=<?= $class_id ?>&update_id=<?= $_GET['update_id'] ?>">
                <h3>Update Student</h3>
                <div class="form-row">
                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" value="<?= htmlspecialchars($student['status']) ?>" required>
                </div>
                <button type="submit">Update Student</button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('updateModal').style.display = 'block';
        document.getElementById('closeModal').onclick = function() {
            document.getElementById('updateModal').style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target == document.getElementById('updateModal')) {
                document.getElementById('updateModal').style.display = 'none';
            }
        }
    </script>
<?php endif; ?>


<script>
function filterStudents() {
    var input, filter, select, options, i, txtValue;
    input = document.getElementById('searchStudent');
    filter = input.value.toLowerCase();
    select = document.getElementById('studentSelect');
    options = select.getElementsByTagName('option');

    for (i = 0; i < options.length; i++) {
        txtValue = options[i].textContent || options[i].innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
}
</script>

</body>

</html>