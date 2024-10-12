<?php

require_once 'database.php';

class User {
    public $id = '';
    public $first_name = '';
    public $middle_name = '';
    public $last_name = '';
    public $email = '';
    public $username = '';
    public $password = '';
    public $user_type = '';  // 'student', 'parent', 'teacher', 'counselor', 'admin'
    public $date_of_birth = '';  // New field
    public $contact_num = '';  // New field
    public $is_staff = false;
    public $is_admin = false;

    protected $db;

    function __construct(){
        $this->db = new Database();
    }

    // Create new user
    function add() {
        $sql = "INSERT INTO Users (first_name, middle_name, last_name, email, username, password, user_type, date_of_birth, contact_num) 
                VALUES (:first_name, :middle_name, :last_name, :email, :username, :password, :user_type, :date_of_birth, :contact_num);";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':middle_name', $this->middle_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':username', $this->username);
        $hashpassword = password_hash($this->password, PASSWORD_DEFAULT);
        $query->bindParam(':password', $hashpassword);
        $query->bindParam(':user_type', $this->user_type);
        $query->bindParam(':date_of_birth', $this->date_of_birth);
        $query->bindParam(':contact_num', $this->contact_num);

        return $query->execute();
    }

    // Read or fetch user by username
    function fetch($username) {
        $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch();
        }
        return $data;
    }

    // Update user
    function update($id) {
        $sql = "UPDATE Users SET 
                first_name = :first_name, 
                middle_name = :middle_name, 
                last_name = :last_name, 
                email = :email, 
                username = :username,
                user_type = :user_type,
                date_of_birth = :date_of_birth,
                contact_num = :contact_num
                WHERE user_id = :id;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':first_name', $this->first_name);
        $query->bindParam(':middle_name', $this->middle_name);
        $query->bindParam(':last_name', $this->last_name);
        $query->bindParam(':email', $this->email);
        $query->bindParam(':username', $this->username);
        $query->bindParam(':user_type', $this->user_type);
        $query->bindParam(':date_of_birth', $this->date_of_birth);
        $query->bindParam(':contact_num', $this->contact_num);
        $query->bindParam(':id', $id);

        return $query->execute();
    }

    // Delete user
    function delete($id) {
        $sql = "DELETE FROM Users WHERE user_id = :id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':id', $id);

        return $query->execute();
    }

    // Check if username exists (excluding a specific ID for update operations)
    function usernameExist($username, $excludeID = null) {
        $sql = "SELECT COUNT(*) FROM Users WHERE username = :username";
        if ($excludeID) {
            $sql .= " AND user_id != :excludeID";
        }

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);

        if ($excludeID) {
            $query->bindParam(':excludeID', $excludeID);
        }

        $count = $query->execute() ? $query->fetchColumn() : 0;

        return $count > 0;
    }

    // Login function
    function login($username, $password) {
        // Fetch user data by username
        $sql = "SELECT * FROM Users WHERE username = :username LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':username', $username);
    
        if ($query->execute()) {
            $data = $query->fetch();
    
            // Check if the user exists and the password matches
            if ($data && password_verify($password, $data['password'])) {
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
    
                // Store user data in session
                $_SESSION['account'] = $data;
    
                // Redirect based on user type
                switch ($data['user_type']) { // Fetch user_type from $data (fetched user record)
                    case 'student':
                        header('Location: student/student.php');
                        break;
                    case 'teacher':
                        header('Location: teacher/teacher.php');
                        break;
                    case 'counselor':
                        header('Location: counselor/dashboard.php');
                        break;
                    case 'admin':
                        header('Location: counselor/dashboard.php');
                        break;
                    default:
                        header('Location: index.php'); // Fallback to home page
                }
                exit();
            }
        }
        
        // Return false if login fails (invalid credentials)
        return false;
    }

    // Clean input function for security
    public function clean_input($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
    
    // Register new user
    public function register($firstName, $middleName, $lastName, $username, $password, $confirmPassword, $userType, $dob, $contact) {
        // Check if username exists
        if ($this->usernameExists($username)) {
            return 'Username already taken.';
        }

        // Validate password
        if (strlen($password) < 6) {
            return 'Password must be at least 6 characters long.';
        }

        // Check password confirmation
        if ($password !== $confirmPassword) {
            return 'Passwords do not match.';
        }

        // Insert user into the database
        try {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->connect()->prepare("
                INSERT INTO Users (first_name, middle_name, last_name, username, password, user_type, date_of_birth, contact_num) 
                VALUES (:first_name, :middle_name, :last_name, :username, :password, :user_type, :date_of_birth, :contact_num)
            ");
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':middle_name', $middleName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashPassword);
            $stmt->bindParam(':user_type', $userType);
            $stmt->bindParam(':date_of_birth', $dob);
            $stmt->bindParam(':contact_num', $contact);

            if ($stmt->execute()) {
                return ''; // No error, registration successful
            } else {
                return 'Error registering user.';
            }
        } catch (PDOException $e) {
            return 'Database error: ' . $e->getMessage();
        }
    }

    // Check if username already exists
    public function usernameExists($username) {
        $stmt = $this->db->connect()->prepare("SELECT COUNT(*) FROM Users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function logout(){
        session_start();
        session_unset();
        session_destroy();

        header('location: index.php');
    }

    public function getParent() {
        // Fetch parent users
        $sql = "SELECT user_id, first_name, last_name FROM users WHERE user_type = 'parent'";
        $stmt = $this->db->connect()->prepare($sql);
    
        // Execute and fetch the result
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all parent users as an associative array
        }
    
        return []; // Return an empty array if no parents are found
    }    

    public function getStudents(){
        // Fetch student users
        $sql = "
            SELECT 
                s.user_id, s.first_name, s.middle_name, s.last_name, s.date_of_birth, s.contact_num, 
                p.first_name AS parent_first_name, p.last_name AS parent_last_name
            FROM 
                users s
            LEFT JOIN 
                parentstudent ps ON s.user_id = ps.student_id
            LEFT JOIN 
                users p ON ps.parent_id = p.user_id
            WHERE 
                s.user_type = 'student'
            ";
        $stmt = $this->db->connect()->prepare($sql);
    
        // Execute and fetch the result
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all parent users as an associative array
        }
    
        return []; // Return an empty array if no parents are found
    }

    // Method to get all counselors
    public function getCounselors() {
        // Fetch counselors users
        $sql = "SELECT user_id, first_name, last_name FROM users WHERE user_type = 'counselor'";
        $stmt = $this->db->connect()->prepare($sql);
    
        // Execute and fetch the result
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all parent users as an associative array
        }
    
        return []; // Return an empty array if no parents are found
    }

    public function getStudentCount(){
        $sql = "SELECT COUNT(*) FROM users WHERE user_type LIKE 'student';";
        $query = $this->db->connect()->prepare($sql);

        return $query->execute();
    }

    public function getCounselorCount(){
        $sql = "SELECT COUNT(*) FROM users WHERE user_type LIKE 'counselor';";
        $query = $this->db->connect()->prepare($sql);

        return $query->execute();
    }
}

?>
