<?php

require_once '../user.class.php';

session_start();

if (!isset($_SESSION['account']['user_type']) || $_SESSION['account']['user_type'] !== 'teacher') {
    header('Location: ../index.php');
    exit();
}

$user = new User();
$teacher = $user->fetch($_SESSION['account']['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->first_name = $_POST['first_name'];
    $user->middle_name = $_POST['middle_name'];
    $user->last_name = $_POST['last_name'];
    $user->email = $_POST['email'];
    $user->username = $_POST['username'];
    $user->date_of_birth = $_POST['date_of_birth'];
    $user->contact_num = $_POST['contact_num'];

    $updateResult = $user->update($_SESSION['account']['user_id']);

    if ($updateResult === true) {
        $message = "Account updated successfully.";
        $_SESSION['account'] = $user->fetch($_SESSION['account']['user_id']); // Update session data
    } else {
        $message = "Failed to update account: " . $updateResult;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account - Don Pablo Lorenzo Memorial High School</title>
    <link rel="stylesheet" href="teacher-dashboard.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 15px;
            color: green;
        }
    </style>
</head>

<body>

<?= include 'navbar-include.php' ?>

<main>
    <section id="account-section">
        <div class="container">
            <h2>Update Account Details</h2>
            <?php if (isset($message)): ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($teacher['first_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" value="<?= htmlspecialchars($teacher['middle_name']) ?>">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($teacher['last_name']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($teacher['email']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($teacher['username']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($teacher['date_of_birth']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="contact_num">Contact Number</label>
                    <input type="text" id="contact_num" name="contact_num" value="<?= htmlspecialchars($teacher['contact_num']) ?>" required>
                </div>
                <div class="form-group">
                    <button type="submit">Update Account</button>
                </div>
            </form>
        </div>
    </section>
</main>
</body>

</html>