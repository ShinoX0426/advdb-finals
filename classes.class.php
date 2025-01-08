<?php
require_once 'database.php';

class Classes
{
    public $class_id = '';
    public $class_name = '';
    public $class_description = '';
    public $created_at = '';
    public $last_updated = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function add(
        $teacher_id,
        $class_name,
        $class_description,
        $schedule,
        $start_time,
        $end_time,
        $valid_until
    ) {
        $sql = "INSERT INTO classes (teacher_id, class_name, description, schedule, start_time, end_time, valid_until) 
                VALUES (:teacher_id, :class_name, :description, :schedule, :start_time, :end_time, :valid_until)";
        $stmt = $this->db->connect()->prepare($sql);
    
        // Validate time slot
        if (!$this->isTimeSlotAvailable($teacher_id, $start_time, $end_time)) {
            return "Time slot is not available";
        }
    
        // Bind parameters (including :teacher_id)
        $stmt->bindParam(':teacher_id', $teacher_id);
        $stmt->bindParam(':class_name', $class_name);
        $stmt->bindParam(':description', $class_description);
        $stmt->bindParam(':schedule', $schedule);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':end_time', $end_time);
        $stmt->bindParam(':valid_until', $valid_until);
    
        return $stmt->execute();
    }

    // Validate time inputs
    private function isTimeSlotAvailable($teacher_id, $start_time, $end_time)
    {
        $sql = "SELECT COUNT(*) FROM classes 
                WHERE teacher_id = :teacher_id 
                AND ((start_time <= :start_time AND end_time > :start_time) 
                OR (start_time < :end_time AND end_time >= :end_time))";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->bindParam(':start_time', $start_time, PDO::PARAM_STR);
        $stmt->bindParam(':end_time', $end_time, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchColumn() == 0;
    }

    // Get a class by its ID
    public function get($class_id)
    {
        $sql = "SELECT * FROM classes WHERE class_id = :class_id LIMIT 1";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    // Update an existing class
    public function update($class_id)
    {
        $sql = "UPDATE classes SET 
                    class_name = :class_name, 
                    description = :class_description, 
                    last_updated = CURRENT_TIMESTAMP
                WHERE class_id = :class_id";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':class_name', $this->class_name, PDO::PARAM_STR);
        $query->bindParam(':class_description', $this->class_description, PDO::PARAM_STR);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);

        return $query->execute();
    }

    // Delete a class
    public function delete($class_id)
    {
        $sql = "DELETE FROM classes WHERE class_id = :class_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);

        return $query->execute();
    }

    // Get all classes
    public function getAll()
    {
        $sql = "SELECT * FROM classes";
        $query = $this->db->connect()->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // Get classes by teacher ID
    public function getClassesByTeacher($teacher_id)
    {
        $sql = "SELECT * FROM classes WHERE teacher_id = :teacher_id";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    // Clean input function for security
    public function clean_input($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}