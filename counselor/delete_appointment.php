<?php
require_once '../appointment.class.php';

$appointment = new Appointment();

$id = null;

$id = $_GET['id'];

if ($appointment->delete($id)) {
    header('location: appointments_view.php?info=success');
} else {
    header('location: appointments_view.php?info=No%20ID%20Provided!');
}