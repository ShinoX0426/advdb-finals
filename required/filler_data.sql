SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO appointmentrequests (request_id, student_id, parent_id, counselor_id, request_date, status, reason, date_created, last_updated) VALUES
(9, 3, 5, 4, '1111-11-11', 'pending', '111', '2024-10-24 10:04:13', '2024-10-24 10:04:13');

INSERT INTO cases (case_id, student_id, counselor_id, case_description, case_status, created_at, last_updated) VALUES
(5, 8, 1, 'asdfsadf', 'open', '2024-10-24 09:23:19', '2024-10-24 09:23:19');

INSERT INTO parentstudent (parent_id, student_id) VALUES
(5, 3);

INSERT INTO users (user_id, first_name, middle_name, last_name, email, username, password, user_type, date_of_birth, contact_num, is_staff, is_admin, created_at, last_updated) VALUES
(1, 'Admin', 'Admin', 'Al Badi', NULL, 'AA', '$2y$10$aeHHMe8MIDgvEWtQbar9FOyDIAGghYcnUljMvxg4mlmwbr2.nDN5.', 'admin', NULL, NULL, 0, 0, '2024-10-13 00:52:44', '2024-10-21 03:04:43'),
(2, 'Parent', 'Magulang', 'asdasd', NULL, 'asdas', '$2y$10$kVZoZdY7Ms2Ir2ifZ4rheuBdh/UKClvjF0UUmYWxACQ6FtaRMuRxu', 'parent', '1111-11-11', '1111111', 0, 0, '2024-10-13 01:16:40', '2024-10-21 03:04:37'),
(3, 'Student', 'Anak', 'AA', NULL, 'johndoe2', '$2y$10$wNi7mF1idpXhXw7Y9GW6.OFU/Z5DFJ9R6.jMttSUA4zycPwgs2IFG', 'student', '2024-10-14', '13123123', 0, 0, '2024-10-13 01:32:41', '2024-10-21 03:04:31'),
(4, 'Counselor', 'Counsel', 'daa', NULL, 'alexa', '$2y$10$k/8QUKS06.A7XEtPzmJkzu8ZoWGxccBr/O8CW.GcI/Wt5PWSO4Zbi', 'counselor', '1111-11-11', '11111111111', 0, 0, '2024-10-13 02:25:11', '2024-10-21 03:04:17'),
(5, 'Parent', '', 'User', 'parent@example.com', 'abcde_parent', '$2y$10$D8k7i6r6b9pyFwSB4QDdIO.02h1Y1NgEGQTj25rqFE04GyvmF4nQq', 'parent', '1970-01-01', '1234567890', 0, 0, '2024-10-21 03:26:06', '2024-10-21 03:26:06'),
(6, 'Admin', '', 'User', 'admin@example.com', 'abcde_admin', '$2y$10$TRX1R79FE4Ulw05xH71VM.QHNh.tr4zrfZk3afr1U0vIORz.7LjJq', 'admin', '1970-01-01', '1234567890', 0, 0, '2024-10-21 03:26:07', '2024-10-21 03:26:07'),
(7, 'Teacher', '', 'User', 'teacher@example.com', 'abcde_teacher', '$2y$10$uKreP5miFcYT6e5XfPMMauTrnD8oI6OpnvIcIC88QFparwpWMWzRi', 'teacher', '1970-01-01', '1234567890', 0, 0, '2024-10-21 03:26:07', '2024-10-21 03:26:07'),
(8, 'Student', '', 'User', 'student@example.com', 'abcde_student', '$2y$10$p64UWfGzUeMJNoi5Xyk15uw33IxGdHS0eJ2nXRJrfqsCJlOJ02tEq', 'student', '2000-01-01', '1234567890', 0, 0, '2024-10-21 03:26:07', '2024-10-21 03:26:07');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
