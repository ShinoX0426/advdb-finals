<?php
// logout.php
require_once 'user.class.php';

$user = new User();
$user->logout();  // Call the logout method in the User class
