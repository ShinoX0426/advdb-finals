<?php

require_once 'user.class.php';

function updateUser() {
    $user = new User();
    $user->first_name = 'John';
    $user->middle_name = 'A';
    $user->last_name = 'Doe';
    $user->email = 'john.doe@example.com';
    $user->username = 'john_doe';
    $user->user_type = 'student';
    $user->date_of_birth = '2000-01-01';
    $user->contact_num = '1234567890';

    $result = $user->update(2358);

    if ($result === true) {
        echo "User updated successfully.";
    } else {
        echo "Failed to update user: " . $result;
    }
}

updateUser();
?>