SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE appointmentrequests (
  request_id int(11) NOT NULL,
  student_id int(11) DEFAULT NULL,
  parent_id int(11) DEFAULT NULL,
  counselor_id int(11) NOT NULL,
  request_date date NOT NULL DEFAULT current_timestamp(),
  status enum('pending','approved','rejected') DEFAULT 'pending',
  reason text DEFAULT NULL,
  date_created timestamp NOT NULL DEFAULT current_timestamp(),
  last_updated timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE attendance (
  attendance_id int(11) NOT NULL,
  student_id int(11) NOT NULL,
  teacher_id int(11) NOT NULL,
  class_id int(11) NOT NULL,
  attendance_date date NOT NULL,
  attendance_time time NOT NULL,
  status enum('present','absent','late') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE caselogs (
  log_id int(11) NOT NULL,
  case_id int(11) NOT NULL,
  counselor_id int(11) NOT NULL,
  progress_note text DEFAULT NULL,
  log_date timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE cases (
  case_id int(11) NOT NULL,
  student_id int(11) NOT NULL,
  counselor_id int(11) NOT NULL,
  case_description text DEFAULT NULL,
  case_status enum('open','in progress','resolved') DEFAULT 'open',
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  last_updated timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE classes (
  class_id int(11) NOT NULL,
  teacher_id int(11) NOT NULL,
  class_name varchar(100) NOT NULL,
  description text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  last_updated timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE classlist (
  classlist_id int(11) NOT NULL,
  class_id int(11) NOT NULL,
  student_id int(11) NOT NULL,
  enrollment_date timestamp NOT NULL DEFAULT current_timestamp(),
  status enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE grades (
  grade_id int(11) NOT NULL,
  student_id int(11) NOT NULL,
  teacher_id int(11) NOT NULL,
  subject varchar(100) DEFAULT NULL,
  grade decimal(5,2) NOT NULL,
  grading_date date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE parentstudent (
  parent_id int(11) NOT NULL,
  student_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE teacherreports (
  report_id int(11) NOT NULL,
  teacher_id int(11) NOT NULL,
  student_id int(11) NOT NULL,
  report_description text DEFAULT NULL,
  report_date timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE users (
  user_id int(11) NOT NULL,
  first_name varchar(50) NOT NULL,
  middle_name varchar(50) DEFAULT NULL,
  last_name varchar(50) NOT NULL,
  email varchar(100) DEFAULT NULL,
  username varchar(100) NOT NULL,
  password varchar(255) NOT NULL,
  user_type enum('student','parent','teacher','counselor','admin') NOT NULL,
  date_of_birth date DEFAULT NULL,
  contact_num varchar(15) DEFAULT NULL,
  is_staff tinyint(1) DEFAULT 0,
  is_admin tinyint(1) DEFAULT 0,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  last_updated timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE appointmentrequests
  ADD PRIMARY KEY (request_id),
  ADD KEY student_id (student_id),
  ADD KEY parent_id (parent_id),
  ADD KEY counselor_id (counselor_id);

ALTER TABLE attendance
  ADD PRIMARY KEY (attendance_id),
  ADD KEY student_id (student_id),
  ADD KEY teacher_id (teacher_id),
  ADD KEY class_id (class_id);

ALTER TABLE caselogs
  ADD PRIMARY KEY (log_id),
  ADD KEY case_id (case_id),
  ADD KEY counselor_id (counselor_id);

ALTER TABLE cases
  ADD PRIMARY KEY (case_id),
  ADD KEY student_id (student_id),
  ADD KEY counselor_id (counselor_id);

ALTER TABLE classes
  ADD PRIMARY KEY (class_id),
  ADD KEY teacher_id (teacher_id);

ALTER TABLE classlist
  ADD PRIMARY KEY (classlist_id),
  ADD UNIQUE KEY unique_enrollment (class_id,student_id),
  ADD KEY class_id (class_id),
  ADD KEY student_id (student_id);

ALTER TABLE grades
  ADD PRIMARY KEY (grade_id),
  ADD KEY student_id (student_id),
  ADD KEY teacher_id (teacher_id);

ALTER TABLE parentstudent
  ADD PRIMARY KEY (parent_id,student_id),
  ADD KEY student_id (student_id);

ALTER TABLE teacherreports
  ADD PRIMARY KEY (report_id),
  ADD KEY teacher_id (teacher_id),
  ADD KEY student_id (student_id);

ALTER TABLE users
  ADD PRIMARY KEY (user_id),
  ADD UNIQUE KEY username (username);


ALTER TABLE appointmentrequests
  MODIFY request_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE attendance
  MODIFY attendance_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE caselogs
  MODIFY log_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE cases
  MODIFY case_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE classes
  MODIFY class_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE classlist
  MODIFY classlist_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE grades
  MODIFY grade_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE teacherreports
  MODIFY report_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE users
  MODIFY user_id int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE appointmentrequests
  ADD CONSTRAINT appointmentrequests_ibfk_1 FOREIGN KEY (student_id) REFERENCES `users` (user_id) ON DELETE SET NULL,
  ADD CONSTRAINT appointmentrequests_ibfk_2 FOREIGN KEY (parent_id) REFERENCES `users` (user_id) ON DELETE SET NULL,
  ADD CONSTRAINT appointmentrequests_ibfk_3 FOREIGN KEY (counselor_id) REFERENCES `users` (user_id);

ALTER TABLE attendance
  ADD CONSTRAINT attendance_ibfk_1 FOREIGN KEY (student_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT attendance_ibfk_2 FOREIGN KEY (teacher_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT attendance_ibfk_3 FOREIGN KEY (class_id) REFERENCES classes (class_id);

ALTER TABLE caselogs
  ADD CONSTRAINT caselogs_ibfk_1 FOREIGN KEY (case_id) REFERENCES `cases` (case_id),
  ADD CONSTRAINT caselogs_ibfk_2 FOREIGN KEY (counselor_id) REFERENCES `users` (user_id);

ALTER TABLE cases
  ADD CONSTRAINT cases_ibfk_1 FOREIGN KEY (student_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT cases_ibfk_2 FOREIGN KEY (counselor_id) REFERENCES `users` (user_id);

ALTER TABLE classes
  ADD CONSTRAINT classes_ibfk_1 FOREIGN KEY (teacher_id) REFERENCES `users` (user_id);

ALTER TABLE classlist
  ADD CONSTRAINT classlist_ibfk_1 FOREIGN KEY (class_id) REFERENCES classes (class_id),
  ADD CONSTRAINT classlist_ibfk_2 FOREIGN KEY (student_id) REFERENCES `users` (user_id);

ALTER TABLE grades
  ADD CONSTRAINT grades_ibfk_1 FOREIGN KEY (student_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT grades_ibfk_2 FOREIGN KEY (teacher_id) REFERENCES `users` (user_id);

ALTER TABLE parentstudent
  ADD CONSTRAINT parentstudent_ibfk_1 FOREIGN KEY (parent_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT parentstudent_ibfk_2 FOREIGN KEY (student_id) REFERENCES `users` (user_id);

ALTER TABLE teacherreports
  ADD CONSTRAINT teacherreports_ibfk_1 FOREIGN KEY (teacher_id) REFERENCES `users` (user_id),
  ADD CONSTRAINT teacherreports_ibfk_2 FOREIGN KEY (student_id) REFERENCES `users` (user_id);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
