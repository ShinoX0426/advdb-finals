<?php
require_once '../cases.class.php';

$case = new Cases();

$id = null;

$id = $_GET['id'];

if ($case->delete($id)) {
    header('location: cases_view.php?info=success');
} else {
    header('location: cases_view.php?info=No%20ID%20Provided!');
}