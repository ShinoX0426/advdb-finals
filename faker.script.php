<?php

require_once 'vendor/autoload.php';
require_once 'database.php';

$faker = Faker\Factory::create();
$db = new Database();

for ($i = 0; $i < 10; $i++) {
    $first_name = $faker->firstName;
    $middle_name = $faker->firstName;
    $last_name = $faker->lastName;
    $email = $faker->email;
    $username = $faker->userName;
    $password = $faker->password;
    $user_type = $faker->randomElement(['student', 'teacher', 'parent', 'admin']);
    $date_of_birth = $faker->date('Y-m-d');
    $contact_num = $faker->phoneNumber;

    $sql = "INSERT INTO Users (first_name, middle_name, last_name, email, username, password, user_type, date_of_birth, contact_num) 
            VALUES (:first_name, :middle_name, :last_name, :email, :username, :password, :user_type, :date_of_birth, :contact_num)";

    try {
        $query = $db->connect()->prepare($sql);

        $query->bindParam(':first_name', $first_name);
        $query->bindParam(':middle_name', $middle_name);
        $query->bindParam(':last_name', $last_name);
        $query->bindParam(':email', $email);
        $query->bindParam(':username', $username);
        $hashpassword = password_hash($password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':user_type', $user_type);
        $query->bindParam(':date_of_birth', $date_of_birth);
        $query->bindParam(':contact_num', $contact_num);

        $result = $query->execute();

        if ($result) {
            echo "User added successfully with ID: " . $db->connect()->lastInsertId() . "\n";
        } else {
            $errorInfo = $query->errorInfo();
            echo "Failed to add user: " . $errorInfo[2] . "\n";
        }
    } catch (PDOException $e) {
        echo "Database error occurred: " . $e->getMessage() . "\n";
    }
}