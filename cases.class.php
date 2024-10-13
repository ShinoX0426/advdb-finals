<?php
require_once 'database.php';

class Cases {
    public $case_id = '';
    public $student_id = '';
    public $counselor_id = '';
    public $case_description = '';
    public $case_status = 'open';  // Default value
    public $created_at = '';
    public $last_updated = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    public function add($student_id, $counselor_id, $case_description, $status) {
        $sql = "INSERT INTO cases (student_id, counselor_id, case_description, case_status) VALUES (:student_id, :counselor_id, :case_description, :case_status)";
        $stmt = $this->db->connect()->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':counselor_id', $counselor_id, PDO::PARAM_INT);
        $stmt->bindParam(':case_description', $case_description, PDO::PARAM_STR);
        $stmt->bindParam(':case_status', $status, PDO::PARAM_STR);
    
        return $stmt->execute(); // Returns true on success
    }
    

    // Get a case by its ID
    public function get($case_id) {
        $sql = "SELECT * FROM cases WHERE case_id = :case_id LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':case_id', $case_id);

        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Update an existing case
    public function update($case_id) {
        $sql = "UPDATE cases SET 
                    student_id = :student_id, 
                    counselor_id = :counselor_id, 
                    case_description = :case_description, 
                    case_status = :case_status, 
                    last_updated = CURRENT_TIMESTAMP
                WHERE case_id = :case_id";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':student_id', $this->student_id);
        $query->bindParam(':counselor_id', $this->counselor_id);
        $query->bindParam(':case_description', $this->case_description);
        $query->bindParam(':case_status', $this->case_status);
        $query->bindParam(':case_id', $case_id);

        return $query->execute();
    }

    // Delete a case
    public function delete($case_id) {
        $sql = "DELETE FROM cases WHERE case_id = :case_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':case_id', $case_id);

        return $query->execute();
    }

    public function getAll() {
        // SQL query with JOIN to retrieve case and user details
        $sql = "SELECT 
                    cases.case_id,
                    student.first_name AS student_first_name,
                    student.last_name AS student_last_name,
                    counselor.first_name AS counselor_first_name,
                    counselor.last_name AS counselor_last_name,
                    cases.case_status,
                    cases.case_description
                FROM cases
                JOIN users AS student ON cases.student_id = student.user_id
                JOIN users AS counselor ON cases.counselor_id = counselor.user_id";
    
        $query = $this->db->connect()->prepare($sql);
    
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }
    

    // Get cases by student
    public function getByStudent($student_id) {
        $sql = "SELECT * FROM cases WHERE student_id = :student_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // Get cases by counselor
    public function getByCounselor($counselor_id) {
        $sql = "SELECT * FROM cases WHERE counselor_id = :counselor_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':counselor_id', $counselor_id);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // Clean input function for security
    public function clean_input($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}
?>
