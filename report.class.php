<?php

require_once 'database.php';

class Report
{
    public $report_id = '';
    public $teacher_id = '';
    public $student_id = '';
    public $report_description = '';
    public $report_date = '';

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    // Create new report
    function add()
    {
        $sql = "INSERT INTO teacherreports (teacher_id, student_id, report_description) 
                VALUES (:teacher_id, :student_id, :report_description)";

        try {
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':teacher_id', $this->teacher_id);
            $query->bindParam(':student_id', $this->student_id);
            $query->bindParam(':report_description', $this->report_description);

            $result = $query->execute();

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Report added successfully',
                    'report_id' => $this->db->connect()->lastInsertId()
                ];
            } else {
                $errorInfo = $query->errorInfo();
                return [
                    'success' => false,
                    'message' => 'Failed to add report',
                    'error' => $errorInfo[2],
                    'error_code' => $errorInfo[1]
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Database error occurred',
                'error' => $e->getMessage(),
                'error_code' => $e->getCode()
            ];
        }
    }

    // Read or fetch report by report_id
    function fetch($id)
    {
        $sql = "SELECT tr.*, 
                       t.first_name AS teacher_first_name, 
                       t.last_name AS teacher_last_name, 
                       s.first_name AS student_first_name, 
                       s.last_name AS student_last_name
                FROM teacherreports tr
                JOIN users t ON tr.teacher_id = t.user_id
                JOIN users s ON tr.student_id = s.user_id
                WHERE tr.report_id = :report_id LIMIT 1;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $id);
        $data = null;
        if ($query->execute()) {
            $data = $query->fetch(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    // Update report
    function update($id)
    {
        $sql = "UPDATE teacherreports SET 
                teacher_id = :teacher_id, 
                student_id = :student_id, 
                report_description = :report_description 
                WHERE report_id = :report_id;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':teacher_id', $this->teacher_id);
        $query->bindParam(':student_id', $this->student_id);
        $query->bindParam(':report_description', $this->report_description);
        $query->bindParam(':report_id', $id);

        return $query->execute();
    }

    // Delete report
    function delete($id)
    {
        $sql = "DELETE FROM teacherreports WHERE report_id = :report_id;";
        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(':report_id', $id);

        return $query->execute();
    }

    // Fetch all reports
function fetchAll()
{
    $sql = "SELECT tr.report_id, 
                   tr.report_description, 
                   tr.report_date, 
                   t.first_name AS teacher_first_name, 
                   t.last_name AS teacher_last_name, 
                   s.first_name AS student_first_name, 
                   s.last_name AS student_last_name
            FROM teacherreports tr
            JOIN users t ON tr.teacher_id = t.user_id
            JOIN users s ON tr.student_id = s.user_id
            ORDER BY tr.report_date DESC";
    $query = $this->db->connect()->prepare($sql);
    $reports = [];
    if ($query->execute()) {
        $reports = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    return $reports;
}
}