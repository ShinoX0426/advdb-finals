<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'adv_guidance';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM Users WHERE Username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['Password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['user_type'] = $user['UserType'];

        // Redirect based on user type
        switch ($user['UserType']) {
            case 'Student':
                header('Location: student_dashboard.php');
                break;
            case 'Teacher':
                header('Location: teacher_dashboard.php');
                break;
            case 'Counselor':
                header('Location: counselor_dashboard.php');
                break;
            case 'Admin':
                header('Location: admin_dashboard.php');
                break;
            default:
                header('Location: index.php');
        }
        exit();
    } else {
        $error = "Invalid username or password";
        header('Location: index.php?error=' . urlencode($error));
        exit();
    }
}
?>