-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2023 at 02:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstonedatabase`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_group_req` (IN `new_400C` INT, IN `new_group_id` VARCHAR(30))   BEGIN
    IF new_400C = 4 THEN
        -- Update the 'status' column in the 'group_req' table
        UPDATE group_req
        SET status = 'complete'
        WHERE group_id = new_group_id;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `400a_mark`
--

CREATE TABLE `400a_mark` (
  `student_id` varchar(15) NOT NULL,
  `mark` float NOT NULL,
  `semester` varchar(30) NOT NULL,
  `faculty_id` varchar(15) NOT NULL,
  `mark_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `400a_mark`
--

INSERT INTO `400a_mark` (`student_id`, `mark`, `semester`, `faculty_id`, `mark_date`) VALUES
('2019-1-60-013', 88, 'Spring-2023', 'FA-0123', '2023-12-27');

-- --------------------------------------------------------

--
-- Table structure for table `400b_mark`
--

CREATE TABLE `400b_mark` (
  `student_id` varchar(15) NOT NULL,
  `mark` float NOT NULL,
  `semester` varchar(30) NOT NULL,
  `faculty_id` varchar(15) NOT NULL,
  `mark_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `400c_mark`
--

CREATE TABLE `400c_mark` (
  `student_id` varchar(15) NOT NULL,
  `mark` float NOT NULL,
  `semester` varchar(30) NOT NULL,
  `faculty_id` varchar(15) NOT NULL,
  `mark_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `board_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board_member`
--

CREATE TABLE `board_member` (
  `faculty_faculty_id` varchar(15) NOT NULL,
  `board_board_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_name` varchar(20) NOT NULL,
  `building` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_name`, `building`) VALUES
('BBA', 'AB'),
('CSE', 'Main'),
('ECE', 'AB01'),
('EEE', 'Main');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` varchar(15) NOT NULL,
  `f_firstname` varchar(255) NOT NULL,
  `f_lastname` varchar(255) NOT NULL,
  `phone_no` decimal(13,0) NOT NULL,
  `f_email` varchar(200) NOT NULL,
  `f_password` varchar(200) NOT NULL,
  `department_dept_name` varchar(20) NOT NULL,
  `is_verified` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `f_firstname`, `f_lastname`, `phone_no`, `f_email`, `f_password`, `department_dept_name`, `is_verified`) VALUES
('FA-0123', 'Abir', 'Khan', '1955223121', 'abirkhan@ewubd.edu', 'd41d8cd98f00b204e9800998ecf8427e', 'CSE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `group_id` varchar(30) NOT NULL,
  `faculty_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_id`, `faculty_id`) VALUES
('54U9', 'FA-0123');

--
-- Triggers `group`
--
DELIMITER $$
CREATE TRIGGER `insert_to_grp_thesis` AFTER INSERT ON `group` FOR EACH ROW BEGIN
    INSERT INTO grp_thesis_type (group_id, `400A`, `400B`, `400C`)
    VALUES (NEW.group_id, 0, 0, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `group_req`
--

CREATE TABLE `group_req` (
  `group_id` varchar(30) NOT NULL,
  `std_1` varchar(15) NOT NULL,
  `std_2` varchar(15) NOT NULL,
  `std_3` varchar(15) NOT NULL,
  `std_4` varchar(15) NOT NULL,
  `dept_name` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `date_of_reg` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_req`
--

INSERT INTO `group_req` (`group_id`, `std_1`, `std_2`, `std_3`, `std_4`, `dept_name`, `status`, `date_of_reg`) VALUES
('54U9', '2019-1-60-013', '2019-1-60-014', '2019-1-60-016', '2019-1-60-015', 'CSE', 'on_going', '2023-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `grp_thesis_type`
--

CREATE TABLE `grp_thesis_type` (
  `group_id` varchar(30) NOT NULL,
  `400A` int(2) NOT NULL,
  `400B` int(2) NOT NULL,
  `400C` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grp_thesis_type`
--

INSERT INTO `grp_thesis_type` (`group_id`, `400A`, `400B`, `400C`) VALUES
('54U9', 4, 0, 0);

--
-- Triggers `grp_thesis_type`
--
DELIMITER $$
CREATE TRIGGER `update_grp` AFTER UPDATE ON `grp_thesis_type` FOR EACH ROW BEGIN
    CALL update_group_req(NEW.`400C`, NEW.`group_id`);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `room_no`
--

CREATE TABLE `room_no` (
  `building` varchar(10) NOT NULL,
  `room_no` decimal(3,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` varchar(15) NOT NULL,
  `s_firstname` varchar(255) NOT NULL,
  `s_lastname` varchar(255) NOT NULL,
  `phone_no` decimal(14,0) NOT NULL,
  `s_email` varchar(200) NOT NULL,
  `s_password` varchar(200) NOT NULL,
  `tot_credit` decimal(3,0) DEFAULT NULL CHECK (`tot_credit` >= 90),
  `is_verified` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `s_firstname`, `s_lastname`, `phone_no`, `s_email`, `s_password`, `tot_credit`, `is_verified`) VALUES
('2019-1-60-013', 'Avir', 'Khan', '1955223121', '2019-1-60-013@std.ewubd.edu', '161ebd7d45089b3446ee4e0d86dbcf92', '105', 1),
('2019-1-60-014', 'Abir', 'Khan', '1955223121', '2019-1-60-014@std.ewubd.edu', '161ebd7d45089b3446ee4e0d86dbcf92', '105', 1),
('2019-1-60-015', 'Khan', 'Abir', '1955223121', '2019-1-60-015@std.ewubd.edu', '161ebd7d45089b3446ee4e0d86dbcf92', '105', 1),
('2019-1-60-016', 'Tonmoy', 'Khan', '1955223121', '2019-1-60-016@std.ewubd.edu', '161ebd7d45089b3446ee4e0d86dbcf92', '105', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `faculty_faculty_id` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`faculty_faculty_id`) VALUES
('FA-0123');

-- --------------------------------------------------------

--
-- Table structure for table `support`
--

CREATE TABLE `support` (
  `suo_id` int(11) NOT NULL,
  `std_id` varchar(15) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `detail` varchar(400) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slot`
--

CREATE TABLE `time_slot` (
  `time_slot_id` varchar(4) NOT NULL,
  `day` varchar(15) NOT NULL,
  `start_hr` decimal(2,0) NOT NULL CHECK (`start_hr` >= 0 and `start_hr` < 24),
  `start_min` decimal(2,0) NOT NULL CHECK (`start_min` >= 0 and `start_min` < 60),
  `end_hr` decimal(2,0) DEFAULT NULL CHECK (`end_hr` >= 0 and `end_hr` < 24),
  `end_min` decimal(2,0) DEFAULT NULL CHECK (`end_min` >= 0 and `end_min` < 60)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verify_faculty`
--

CREATE TABLE `verify_faculty` (
  `f_email` varchar(200) NOT NULL,
  `ver_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify_faculty`
--

INSERT INTO `verify_faculty` (`f_email`, `ver_code`) VALUES
('2019-1-60-013@std.ewubd.edu', 'dde30bb58870c8ea7658e1f9d7858cc9');

-- --------------------------------------------------------

--
-- Table structure for table `verify_student`
--

CREATE TABLE `verify_student` (
  `s_email` varchar(200) NOT NULL,
  `ver_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify_student`
--

INSERT INTO `verify_student` (`s_email`, `ver_code`) VALUES
('2019-1-60-013@std.ewubd.edu', '1324b2bf794c7d85e7606e7f768913c1'),
('2019-1-60-014@std.ewubd.edu', '58a18dbc6184c183dbb33da85e91f72b'),
('2019-1-60-015@std.ewubd.edu', 'a67ac800a0b29cde1b6732aceda51811'),
('2019-1-60-016@std.ewubd.edu', '58eddc7c1b884a9ea9fe49c9b41a6a02');

-- --------------------------------------------------------

--
-- Table structure for table `viva_board`
--

CREATE TABLE `viva_board` (
  `viva_no` int(11) NOT NULL,
  `semester` varchar(6) NOT NULL CHECK (`semester` in ('Fall','Spring','Summer')),
  `year` decimal(4,0) NOT NULL CHECK (`year` > 1901 and `year` < 2100),
  `board_board_number` varchar(5) NOT NULL,
  `room_no_room_no` decimal(3,0) NOT NULL,
  `room_no_building` varchar(10) NOT NULL,
  `time_slot_time_slot_id` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viva_group`
--

CREATE TABLE `viva_group` (
  `viva_no` int(11) NOT NULL,
  `group_id` varchar(30) NOT NULL,
  `def_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `400a_mark`
--
ALTER TABLE `400a_mark`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `faculty_id_400A` (`faculty_id`);

--
-- Indexes for table `400b_mark`
--
ALTER TABLE `400b_mark`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `faculty_id_400B` (`faculty_id`);

--
-- Indexes for table `400c_mark`
--
ALTER TABLE `400c_mark`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `faculty_id_400C` (`faculty_id`);

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`board_number`);

--
-- Indexes for table `board_member`
--
ALTER TABLE `board_member`
  ADD PRIMARY KEY (`faculty_faculty_id`),
  ADD KEY `board_member_board_fk` (`board_board_number`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_name`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`),
  ADD KEY `faculty_department_fk` (`department_dept_name`);

--
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`group_id`,`faculty_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Indexes for table `group_req`
--
ALTER TABLE `group_req`
  ADD PRIMARY KEY (`group_id`),
  ADD KEY `dept_name_fk` (`dept_name`);

--
-- Indexes for table `grp_thesis_type`
--
ALTER TABLE `grp_thesis_type`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `room_no`
--
ALTER TABLE `room_no`
  ADD PRIMARY KEY (`room_no`,`building`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`faculty_faculty_id`);

--
-- Indexes for table `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`suo_id`);

--
-- Indexes for table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`time_slot_id`) USING BTREE;

--
-- Indexes for table `verify_faculty`
--
ALTER TABLE `verify_faculty`
  ADD PRIMARY KEY (`f_email`);

--
-- Indexes for table `verify_student`
--
ALTER TABLE `verify_student`
  ADD PRIMARY KEY (`s_email`);

--
-- Indexes for table `viva_board`
--
ALTER TABLE `viva_board`
  ADD PRIMARY KEY (`viva_no`,`semester`,`year`),
  ADD KEY `viva_board_board_fk` (`board_board_number`),
  ADD KEY `viva_board_room_no_fk` (`room_no_room_no`,`room_no_building`),
  ADD KEY `viva_board_time_slot_fk` (`time_slot_time_slot_id`);

--
-- Indexes for table `viva_group`
--
ALTER TABLE `viva_group`
  ADD PRIMARY KEY (`viva_no`,`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `support`
--
ALTER TABLE `support`
  MODIFY `suo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `viva_board`
--
ALTER TABLE `viva_board`
  MODIFY `viva_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `400a_mark`
--
ALTER TABLE `400a_mark`
  ADD CONSTRAINT `faculty_id_400A` FOREIGN KEY (`faculty_id`) REFERENCES `supervisor` (`faculty_faculty_id`),
  ADD CONSTRAINT `student_id_400A` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `400b_mark`
--
ALTER TABLE `400b_mark`
  ADD CONSTRAINT `faculty_id_400B` FOREIGN KEY (`faculty_id`) REFERENCES `supervisor` (`faculty_faculty_id`),
  ADD CONSTRAINT `student_id_400B` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `400c_mark`
--
ALTER TABLE `400c_mark`
  ADD CONSTRAINT `faculty_id_400C` FOREIGN KEY (`faculty_id`) REFERENCES `supervisor` (`faculty_faculty_id`),
  ADD CONSTRAINT `student_id_400C` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `board_member`
--
ALTER TABLE `board_member`
  ADD CONSTRAINT `board_member_board_fk` FOREIGN KEY (`board_board_number`) REFERENCES `board` (`board_number`),
  ADD CONSTRAINT `board_member_faculty_fk` FOREIGN KEY (`faculty_faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_department_fk` FOREIGN KEY (`department_dept_name`) REFERENCES `department` (`dept_name`);

--
-- Constraints for table `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `supervisor` (`faculty_faculty_id`),
  ADD CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `group_req` (`group_id`);

--
-- Constraints for table `group_req`
--
ALTER TABLE `group_req`
  ADD CONSTRAINT `dept_name_fk` FOREIGN KEY (`dept_name`) REFERENCES `department` (`dept_name`);

--
-- Constraints for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD CONSTRAINT `supervisor_faculty_fk` FOREIGN KEY (`faculty_faculty_id`) REFERENCES `faculty` (`faculty_id`);

--
-- Constraints for table `viva_board`
--
ALTER TABLE `viva_board`
  ADD CONSTRAINT `viva_board_board_fk` FOREIGN KEY (`board_board_number`) REFERENCES `board` (`board_number`),
  ADD CONSTRAINT `viva_board_room_no_fk` FOREIGN KEY (`room_no_room_no`,`room_no_building`) REFERENCES `room_no` (`room_no`, `building`),
  ADD CONSTRAINT `viva_board_time_slot_fk` FOREIGN KEY (`time_slot_time_slot_id`) REFERENCES `time_slot` (`time_slot_id`);

--
-- Constraints for table `viva_group`
--
ALTER TABLE `viva_group`
  ADD CONSTRAINT `viva_no` FOREIGN KEY (`viva_no`) REFERENCES `viva_board` (`viva_no`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
