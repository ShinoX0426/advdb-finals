<?php
require_once '../user.class.php';

$user = new User();

$id = null;

$id = $_GET['id'];

if (isset($id)) {
    $user->delete($id);
    header('location: students.php?info=success');
} else {
    header('location: students.php?info=No%20ID%20Provided!');
}