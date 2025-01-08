<?php

class DatabaseSeeder{

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function seed() {
        // Clear existing data to prevent duplicate entries
        $this->truncateTables();

        // Seed tables in an order that respects foreign key constraints
        $this->seedClasses();
        $this->seedParentStudent();
        $this->seedCases();
        $this->seedCaseLogs();
        $this->seedAppointmentRequests();
        $this->seedClassList();
        $this->seedAttendance();
        $this->seedGrades();
        $this->seedTeacherReports();

        echo "Database seeding completed successfully!\n";
    }

    private function truncateTables() {
        $tables = [
            'users', 'classes', 'parentstudent', 'cases', 'caselogs', 
            'appointmentrequests', 'classlist', 'attendance', 
            'grades', 'teacherreports'
        ];

        foreach ($tables as $table) {
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
            $this->pdo->exec("TRUNCATE TABLE $table;");
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        }
    }

    private function seedClasses() {
        $subjects = ['Mathematics', 'Science', 'English', 'History', 'Computer Science', 
                     'Biology', 'Chemistry', 'Physics', 'Literature', 'Geography'];
        $teacherIds = $this->getUserIdsByType('teacher', 10);

        $stmt = $this->pdo->prepare("INSERT INTO classes (teacher_id, class_name, description) VALUES (?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $teacherId = $teacherIds[$i % count($teacherIds)];
            $stmt->execute([
                $teacherId,
                $subjects[$i],
                "Advanced {$subjects[$i]} class for high school students"
            ]);
        }
    }

    private function seedParentStudent() {
        $parentIds = $this->getUserIdsByType('parent', 10);
        $studentIds = $this->getUserIdsByType('student', 10);

        $stmt = $this->pdo->prepare("INSERT INTO parentstudent (parent_id, student_id) VALUES (?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $parentIds[$i % count($parentIds)],
                $studentIds[$i % count($studentIds)]
            ]);
        }
    }

    private function seedCases() {
        $studentIds = $this->getUserIdsByType('student', 10);
        $counselorIds = $this->getUserIdsByType('counselor', 10);

        $stmt = $this->pdo->prepare("INSERT INTO cases (student_id, counselor_id, case_description, case_status) VALUES (?, ?, ?, ?)");
        $statuses = ['open', 'in progress', 'resolved'];

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $studentIds[$i % count($studentIds)],
                $counselorIds[$i % count($counselorIds)],
                "Student counseling case {$i} description",
                $statuses[array_rand($statuses)]
            ]);
        }
    }

    private function seedCaseLogs() {
        $caseIds = $this->getLastNIds('cases', 10);
        $counselorIds = $this->getUserIdsByType('counselor', 10);

        $stmt = $this->pdo->prepare("INSERT INTO caselogs (case_id, counselor_id, progress_note) VALUES (?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $caseIds[$i % count($caseIds)],
                $counselorIds[$i % count($counselorIds)],
                "Progress log entry for case {$i}"
            ]);
        }
    }

    private function seedAppointmentRequests() {
        $studentIds = $this->getUserIdsByType('student', 10);
        $parentIds = $this->getUserIdsByType('parent', 10);
        $counselorIds = $this->getUserIdsByType('counselor', 10);
        $statuses = ['pending', 'approved', 'rejected'];

        $stmt = $this->pdo->prepare("INSERT INTO appointmentrequests (student_id, parent_id, counselor_id, request_date, status, reason) VALUES (?, ?, ?, ?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $studentIds[$i % count($studentIds)],
                $parentIds[$i % count($parentIds)],
                $counselorIds[$i % count($counselorIds)],
                date('Y-m-d', strtotime("-{$i} days")),
                $statuses[array_rand($statuses)],
                "Appointment request reason {$i}"
            ]);
        }
    }

    private function seedClassList() {
        $classIds = $this->getLastNIds('classes', 10);
        $studentIds = $this->getUserIdsByType('student', 10);

        $stmt = $this->pdo->prepare("INSERT INTO classlist (class_id, student_id, status) VALUES (?, ?, ?)");
        $statuses = ['active', 'inactive'];

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $classIds[$i % count($classIds)],
                $studentIds[$i % count($studentIds)],
                $statuses[array_rand($statuses)]
            ]);
        }
    }

    private function seedAttendance() {
        $studentIds = $this->getUserIdsByType('student', 10);
        $teacherIds = $this->getUserIdsByType('teacher', 10);
        $classIds = $this->getLastNIds('classes', 10);
        $statuses = ['present', 'absent', 'late'];

        $stmt = $this->pdo->prepare("INSERT INTO attendance (student_id, teacher_id, class_id, attendance_date, attendance_time, status) VALUES (?, ?, ?, ?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $studentIds[$i % count($studentIds)],
                $teacherIds[$i % count($teacherIds)],
                $classIds[$i % count($classIds)],
                date('Y-m-d', strtotime("-{$i} days")),
                date('H:i:s', strtotime("0{$i}:30:00")),
                $statuses[array_rand($statuses)]
            ]);
        }
    }

    private function seedGrades() {
        $studentIds = $this->getUserIdsByType('student', 10);
        $teacherIds = $this->getUserIdsByType('teacher', 10);
        $subjects = ['Mathematics', 'Science', 'English', 'History', 'Computer Science'];

        $stmt = $this->pdo->prepare("INSERT INTO grades (student_id, teacher_id, subject, grade, grading_date) VALUES (?, ?, ?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $studentIds[$i % count($studentIds)],
                $teacherIds[$i % count($teacherIds)],
                $subjects[$i % count($subjects)],
                round(rand(50, 100), 2),
                date('Y-m-d', strtotime("-{$i} days"))
            ]);
        }
    }

    private function seedTeacherReports() {
        $teacherIds = $this->getUserIdsByType('teacher', 10);
        $studentIds = $this->getUserIdsByType('student', 10);

        $stmt = $this->pdo->prepare("INSERT INTO teacherreports (teacher_id, student_id, report_description) VALUES (?, ?, ?)");

        for ($i = 0; $i < 10; $i++) {
            $stmt->execute([
                $teacherIds[$i % count($teacherIds)],
                $studentIds[$i % count($studentIds)],
                "Teacher report {$i} for student development and performance"
            ]);
        }
    }

    private function getUserIdsByType($type, $limit = 10) {
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE user_type = ? LIMIT $limit");
        $stmt->execute([$type]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    private function getLastNIds($table, $limit = 10) {
        $stmt = $this->pdo->query("SELECT {$table}_id FROM $table ORDER BY {$table}_id DESC LIMIT $limit");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}

// Usage example
try {
    $pdo = new PDO("mysql:host=localhost;dbname=adv_guidance", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $seeder = new DatabaseSeeder($pdo);
    $seeder->seed();
} catch (PDOException $e) {
    die("Database seeding failed: " . $e->getMessage());
}