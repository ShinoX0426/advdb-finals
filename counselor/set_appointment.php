<?php
require_once '../appointment.class.php';
require_once '../user.class.php';

// Initialize classes
$appointment = new Appointment();
$user = new User();

// Fetch students and counselors from the database
$students = $user->getStudents(); // Assuming this fetches all students
$counselors = $user->getCounselors(); // Assuming this fetches all counselors

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $counselor_id = $_POST['counselor_id'];
    $request_date = $_POST['request_date'];
    $reason = $_POST['reason'];

    $appointment->student_id = $student_id;
    $appointment->counselor_id = $counselor_id;
    $appointment->request_date = $request_date;
    $appointment->reason = $reason;

    $result = $appointment->add();

    // Redirect or show success/failure message
    if ($result) {
        $message = "Appointment request has been submitted successfully!";
    } else {
        $message = "Failed to submit the appointment request. Please try again.";
    }
}
?>