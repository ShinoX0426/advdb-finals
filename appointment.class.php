<?php

require_once 'database.php';

class Appointment
{
    public $request_id = null;
    public $student_id = null;
    public $parent_id = null;
    public $counselor_id = null;
    public $request_date = null;
    public $status = 'pending';
    public $reason = null;
    public $date_created = null;
    public $last_updated = null;

    // Valid status values based on enum
    private const VALID_STATUSES = ['pending', 'approved', 'rejected'];

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function add($student_id, $counselor_id, $request_date, $reason)
    {
        // Fetch the parent_id from the parentstudent table based on student_id
        $stmt = $this->db->connect()->prepare("SELECT parent_id FROM parentstudent WHERE student_id = :student_id");
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        $parent_id = $stmt->fetchColumn();

        // Check if parent_id exists
        if (!$parent_id) {
            return false;
        }

        // Insert the appointment request
        // Note: date_created and last_updated will be set by MySQL defaults
        $stmt = $this->db->connect()->prepare(
            "INSERT INTO appointmentrequests 
            (student_id, counselor_id, parent_id, request_date, reason) 
            VALUES (:student_id, :counselor_id, :parent_id, :request_date, :reason)"
        );

        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':counselor_id', $counselor_id);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->bindParam(':request_date', $request_date);
        $stmt->bindParam(':reason', $reason);

        return $stmt->execute();
    }

    public function fetch($request_id)
    {
        $sql = "SELECT * FROM appointmentrequests WHERE request_id = :request_id LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':request_id', $request_id);
        
        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                // Map the database fields to object properties
                foreach ($data as $key => $value) {
                    $this->$key = $value;
                }
                return true;
            }
        }
        return false;
    }

    function getParentId($student_id) {
        $sql = "SELECT parent_id FROM parentstudent WHERE student_id = :student_id";
        
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id);
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['parent_id'] : null;  // Return parent_id or null if not found
    }
    

    function update($request_id) {
        // Get the parent_id using student_id
        $this->parent_id = $this->getParentId($this->student_id);
    
        $sql = "UPDATE appointmentrequests SET 
                student_id = :student_id,
                parent_id = :parent_id,
                counselor_id = :counselor_id,
                request_date = :request_date,
                status = :status,
                reason = :reason,
                last_updated = CURRENT_TIMESTAMP
                WHERE request_id = :request_id";
        
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
    

    public function delete($request_id)
    {
        $sql = "DELETE FROM appointmentrequests WHERE request_id = :request_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':request_id', $request_id);

        return $query->execute();
    }

    public function getAll()
    {
        try {
            $stmt = $this->db->connect()->prepare(
                "SELECT 
                    a.*,
                    u_student.first_name AS student_first_name, 
                    u_student.last_name AS student_last_name,
                    u_counselor.first_name AS counselor_first_name, 
                    u_counselor.last_name AS counselor_last_name,
                    u_parent.first_name AS parent_first_name,
                    u_parent.last_name AS parent_last_name
                FROM appointmentrequests a
                LEFT JOIN users u_student ON a.student_id = u_student.user_id
                LEFT JOIN users u_parent ON a.parent_id = u_parent.user_id
                JOIN users u_counselor ON a.counselor_id = u_counselor.user_id"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAll(): " . $e->getMessage());
            return [];
        }
    }

    public function getByStatus($status)
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException("Invalid status value");
        }

        $sql = "SELECT * FROM appointmentrequests WHERE status = :status";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':status', $status);
        
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getByCounselor($counselor_id)
    {
        $sql = "SELECT * FROM appointmentrequests WHERE counselor_id = :counselor_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':counselor_id', $counselor_id);
        
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getByStudent($student_id)
    {
        $sql = "SELECT * FROM appointmentrequests WHERE student_id = :student_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':student_id', $student_id);
        
        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function getAppointmentCount()
    {
        $sql = "SELECT COUNT(*) FROM appointmentrequests WHERE status IN ('pending', 'approved')";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function getAllAppointmentCount()
    {
        $sql = "SELECT COUNT(*) FROM appointmentrequests";
        $query = $this->db->connect()->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }

    public function clean_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}