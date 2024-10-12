<?php

require_once 'database.php';

class Appointment {
    public $request_id = '';
    public $student_id = '';
    public $parent_id = '';
    public $counselor_id = '';
    public $request_date = '';  // Original request date
    public $status = 'pending'; // Default status is 'pending'
    public $reason = '';        // New field to capture the reason for the appointment
    public $date_created = '';  // Timestamp of when the appointment request was created
    public $last_updated = '';  // Timestamp of the last update

    protected $db;

    function __construct(){
        $this->db = new Database();
    }

    public function add($student_id, $counselor_id, $request_date, $reason) {
        try {
            // Fetch the parent_id from the parentstudent table based on student_id
            $stmt = $this->db->connect()->prepare("SELECT parent_id FROM parentstudent WHERE student_id = :student_id");
            $stmt->bindParam(':student_id', $student_id);
            $stmt->execute();
            $parent_id = $stmt->fetchColumn();
    
            // Check if parent_id exists
            if (!$parent_id) {
                // Handle case where the parent_id is not found
                return false;
            }
    
            // Insert the appointment request including parent_id
            $stmt = $this->db->connect()->prepare("INSERT INTO appointmentrequests (student_id, counselor_id, request_date, reason, parent_id) 
                                        VALUES (:student_id, :counselor_id, :request_date, :reason, :parent_id)");
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':counselor_id', $counselor_id);
            $stmt->bindParam(':request_date', $request_date);
            $stmt->bindParam(':reason', $reason);
            $stmt->bindParam(':parent_id', $parent_id);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle error
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Fetch an appointment by request_id
    function fetch($request_id) {
        $sql = "SELECT * FROM appointmentrequests WHERE request_id = :request_id LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':request_id', $request_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    // Update an appointment
    function update($request_id) {
        $sql = "UPDATE appointmentrequests SET 
                student_id = :student_id,
                parent_id = :parent_id,
                counselor_id = :counselor_id,
                request_date = :request_date,
                status = :status,
                reason = :reason,
                last_updated = CURRENT_TIMESTAMP -- Automatically set to the current timestamp
                WHERE request_id = :request_id;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':student_id', $this->student_id);
        $query->bindParam(':parent_id', $this->parent_id);
        $query->bindParam(':counselor_id', $this->counselor_id);
        $query->bindParam(':request_date', $this->request_date);
        $query->bindParam(':status', $this->status);
        $query->bindParam(':reason', $this->reason);
        $query->bindParam(':request_id', $request_id);

        return $query->execute();
    }

    // Delete an appointment
    function delete($request_id) {
        $sql = "DELETE FROM appointmentrequests WHERE request_id = :request_id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':request_id', $request_id);

        return $query->execute();
    }

    public function getAll() {
        try {
            // Fetch appointments with student and counselor names
            $stmt = $this->db->connect()->prepare(
                "SELECT 
                    a.request_id, 
                    u_student.first_name AS student_first_name, 
                    u_student.last_name AS student_last_name,
                    u_counselor.first_name AS counselor_first_name, 
                    u_counselor.last_name AS counselor_last_name, 
                    a.request_date, 
                    a.status, 
                    a.reason 
                FROM appointmentrequests a
                JOIN users u_student ON a.student_id = u_student.user_id
                JOIN users u_counselor ON a.counselor_id = u_counselor.user_id"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    

    // Fetch appointments by status
    function getByStatus($status) {
        $sql = "SELECT * FROM appointmentrequests WHERE status = :status;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    // Fetch appointments by counselor
    function getByCounselor($counselor_id) {
        $sql = "SELECT * FROM appointmentrequests WHERE counselor_id = :counselor_id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':counselor_id', $counselor_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    // Fetch appointments by student
    function getByStudent($student_id) {
        $sql = "SELECT * FROM appointmentrequests WHERE student_id = :student_id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    function getAppointmentCount() {
        $sql = "SELECT COUNT(*) FROM appointmentrequests WHERE status LIKE 'pending' OR 'approved';";
        $query = $this->db->connect()->prepare($sql);

        return $query->execute();
    }

    function getAllAppointmentCount() {
        $sql = "SELECT COUNT(*) FROM appointmentrequests;";
        $query = $this->db->connect()->prepare($sql);

        return $query->execute();
    }

    // Clean input function for security
    public function clean_input($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}

?>
