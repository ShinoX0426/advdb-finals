-- Insert filler appointments for student with user_id: 85
INSERT INTO appointmentrequests (student_id, parent_id, counselor_id, request_date, status, reason, date_created, last_updated)
VALUES 
(85, 3, 4, '2025-01-10', 'pending', 'Request for academic counseling.', '2025-01-10 09:00:00', '2025-01-10 09:00:00'),
(85, 3, 4, '2025-01-15', 'approved', 'Follow-up on academic progress.', '2025-01-15 10:00:00', '2025-01-15 10:00:00'),
(85, 3, 4, '2025-01-20', 'rejected', 'Request for personal counseling.', '2025-01-20 11:00:00', '2025-01-20 11:00:00');


CREATE TABLE `classlist` (
  `classlist_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert filler classlist entries for student with user_id: 85
INSERT INTO classlist (class_id, student_id, enrollment_date, status)
VALUES 
(36, 85, '2025-01-01 08:00:00', 'active'),
(37, 85, '2025-01-02 09:00:00', 'active'),
(38, 85, '2025-01-03 10:00:00', 'inactive');

-- Insert filler cases for student with user_id: 85
INSERT INTO cases (student_id, counselor_id, case_description, case_status, created_at, last_updated)
VALUES 
(85, 4, 'Student has difficulty focusing in class.', 'open', '2025-01-01 10:00:00', '2025-01-01 10:00:00'),
(85, 4, 'Frequent tardiness and absenteeism reported.', 'in progress', '2025-01-02 11:00:00', '2025-01-02 11:00:00'),
(85, 4, 'Issues observed with social interaction.', 'resolved', '2025-01-03 12:00:00', '2025-01-03 12:00:00');

-- Existing schema definitions...

-- Insert filler cases for student with user_id: 1203
INSERT INTO cases (student_id, counselor_id, case_description, case_status, created_at, last_updated)
VALUES 
(1203, 4, 'Student has difficulty focusing in class.', 'open', '2025-01-01 10:00:00', '2025-01-01 10:00:00'),
(1203, 4, 'Frequent tardiness and absenteeism reported.', 'in progress', '2025-01-02 11:00:00', '2025-01-02 11:00:00'),
(1203, 4, 'Issues observed with social interaction.', 'resolved', '2025-01-03 12:00:00', '2025-01-03 12:00:00');

-- Insert filler appointments for student with user_id: 1203
INSERT INTO appointmentrequests (student_id, parent_id, counselor_id, request_date, status, reason, date_created, last_updated)
VALUES 
(1203, 3, 4, '2025-01-10', 'pending', 'Request for academic counseling.', '2025-01-10 09:00:00', '2025-01-10 09:00:00'),
(1203, 3, 4, '2025-01-15', 'approved', 'Follow-up on academic progress.', '2025-01-15 10:00:00', '2025-01-15 10:00:00'),
(1203, 3, 4, '2025-01-20', 'rejected', 'Request for personal counseling.', '2025-01-20 11:00:00', '2025-01-20 11:00:00');

-- Existing schema definitions...