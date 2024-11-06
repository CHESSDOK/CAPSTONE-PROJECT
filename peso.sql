-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql113.infinityfree.com
-- Generation Time: Nov 06, 2024 at 07:55 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37485657_peso`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin_level` varchar(100) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`id`, `username`, `password`, `email`, `admin_level`, `full_name`, `phone`, `profile_picture`) VALUES
(1, 'Developer', '$2y$10$leKyw3m7p3VVUBP8Vee58.9uMPVbJJ1Ph5OYGeOUQnK9GmCxdRuvC', 'mercadomarklawrence55@gmail.com', 'super_admin', 'Mark Lawrence Aranda Mercado', '09162602288', 'uploads/coding.png');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_profile`
--

CREATE TABLE `applicant_profile` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `landline` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'user.png',
  `house_address` varchar(255) DEFAULT NULL,
  `tin` varchar(255) DEFAULT NULL,
  `sss_no` varchar(20) DEFAULT NULL,
  `pagibig_no` varchar(20) DEFAULT NULL,
  `philhealth_no` varchar(20) DEFAULT NULL,
  `passport_no` varchar(20) DEFAULT NULL,
  `school_name1` varchar(255) DEFAULT NULL,
  `year_grad1` varchar(255) DEFAULT NULL,
  `award1` varchar(255) DEFAULT NULL,
  `school_name2` varchar(255) DEFAULT NULL,
  `year_grad2` varchar(250) DEFAULT NULL,
  `award2` varchar(255) DEFAULT NULL,
  `school_name3` varchar(255) DEFAULT NULL,
  `course3` varchar(255) DEFAULT NULL,
  `year_grad3` varchar(255) DEFAULT NULL,
  `award3` varchar(255) DEFAULT NULL,
  `level3` varchar(255) DEFAULT NULL,
  `year_level3` varchar(250) DEFAULT NULL,
  `school_name4` varchar(255) DEFAULT NULL,
  `course4` varchar(255) DEFAULT NULL,
  `year_grad4` varchar(250) DEFAULT NULL,
  `award4` varchar(255) DEFAULT NULL,
  `level4` varchar(255) DEFAULT NULL,
  `year_level4` varchar(255) DEFAULT NULL,
  `preferred_occupation` varchar(255) DEFAULT NULL,
  `pwl` varchar(100) DEFAULT NULL,
  `overseas_loc` varchar(255) DEFAULT NULL,
  `local_loc` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `pwd2` varchar(255) DEFAULT NULL,
  `prefix` enum('Sr.','Jr.','II','III','IV','V','VI','VII','none') DEFAULT NULL,
  `four_ps` varchar(100) DEFAULT NULL,
  `hhid` varchar(100) DEFAULT NULL,
  `selected_options` varchar(255) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `employment_status` varchar(100) DEFAULT NULL,
  `es_status` varchar(100) DEFAULT NULL,
  `es_others` varchar(100) DEFAULT NULL,
  `actively_looking` varchar(100) DEFAULT NULL,
  `al_details` varchar(255) DEFAULT NULL,
  `willing_to_work` varchar(255) DEFAULT NULL,
  `ww_details` varchar(255) DEFAULT NULL,
  `passport_expiry` varchar(255) DEFAULT NULL,
  `expected_salary` int(11) DEFAULT NULL,
  `resume` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_profile`
--

INSERT INTO `applicant_profile` (`user_id`, `username`, `password`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `email`, `first_name`, `last_name`, `middle_name`, `dob`, `pob`, `age`, `height`, `sex`, `civil_status`, `contact_no`, `landline`, `photo`, `house_address`, `tin`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `school_name1`, `year_grad1`, `award1`, `school_name2`, `year_grad2`, `award2`, `school_name3`, `course3`, `year_grad3`, `award3`, `level3`, `year_level3`, `school_name4`, `course4`, `year_grad4`, `award4`, `level4`, `year_level4`, `preferred_occupation`, `pwl`, `overseas_loc`, `local_loc`, `pwd`, `pwd2`, `prefix`, `four_ps`, `hhid`, `selected_options`, `religion`, `employment_status`, `es_status`, `es_others`, `actively_looking`, `al_details`, `willing_to_work`, `ww_details`, `passport_expiry`, `expected_salary`, `resume`) VALUES
(1, 'Lawrence', '$2y$10$A3jI4p43BJgAGwGqUWeibOyAPZTCnDhnjxWU46nTCo1SFPb7Qiy.y', 1, '207989', '2024-11-06 05:27:21', NULL, NULL, 'ict1mercado.cdlb@gmail.com', 'Libby', 'Rolfson', 'Graciela Schoen', '2024-01-09', '747 Thompson Creek', 0, '5&#039;4', 'female', 'Separated', '280-239-8926', '846-716-0364', '73026436_2186796674953917_7179570363964063744_n.jpg', '8293 Loraine Rest', '123423', '597', '90', '1234', '446', 'Brock Turcotte', '2025-10-17', 'Eum eligendi cumque in dolorum modi exercitationem.', 'Soledad Trantow', '2024-06-07', 'Error voluptatum nobis quo aliquam animi soluta repudiandae explicabo eum.', 'Aglae Erdman', 'Nicaragua', '2024-07-06', 'Vel incidunt dolorem voluptates.', '', NULL, 'Sadye Purdy', 'Norway', '2024-01-09', 'Iste soluta impedit consequatur quidem aperiam hic expedita.', '', NULL, 'Regional Operations Coordinator,Lead Program Agent,Direct Optimization Coordinator,International Security Strategist', 'overseas', 'Qatar,Kiribati,Iceland', 'Davis,Beavercreek,Richland', 'Hearing', '', 'Sr.', 'Yes', 'Occaecati harum occaecati.', 'Computer Literate,Carpentry Work,Auto Mechanic,Beautician', 'Veritatis fugiat impedit libero eius eveniet autem earum impedit beatae.', 'unemployed', 'retired', '', 'Yes', 'Eveniet praesentium repellat.', 'Yes', '', '2025-10-29', 0, ''),
(2, 'deguzman', '$2y$10$Pbyd8e2tQRERdnOGsWyYmuPk8QVLzmREp/V9aNMzlNDUL5HgHkj3m', 1, '863124', '2024-11-06 15:11:44', NULL, NULL, 'deguzmanpatrick.cdlb@gmail.com', 'Patrick', 'De Guzman', 'PeÃ±a', '2024-11-06', 'Calamba City, Laguna', 0, '', 'male', 'Single', '09557507465', '', 'Screenshot_2024-11-06-07-29-55-34_a23b203fd3aafc6dcb84e438dda678b6.jpg', '1356 Purok 5, Baklasan Street', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', NULL, 'Service Crew', '', 'Philippines,Philippines,Philippines', 'LOS BANOS,LOS BANOS,LOS BANOS', '', '', '', '', '', 'Domestic Chores,Driver', 'N/a', '', '', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `job_posting_id` int(11) DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `job` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `applicant_id`, `job_posting_id`, `application_date`, `status`, `job`) VALUES
(1, 2, 2, '2024-11-05', 'accepted', 'Programmer');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` enum('filed','in_progress','resolved') DEFAULT 'filed',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `user_id`, `title`, `description`, `file`, `status`, `created_at`) VALUES
(1, 1, 'Abuse', 'They abuse me hehe', 'uploads/17308772639166287036201656802809.jpg', 'filed', '2024-11-06 07:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `messages` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `module_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `module_count`) VALUES
(1, 'Dressmaking', 'mananahi', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employer_documents`
--

CREATE TABLE `employer_documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_name` varchar(100) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `is_verified` varchar(100) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_documents`
--

INSERT INTO `employer_documents` (`id`, `user_id`, `document_name`, `document_path`, `is_verified`, `comment`) VALUES
(1, 1, 'POEA license', 'uploads/philsys id.png', NULL, NULL),
(2, 1, 'SEC Certificate', 'uploads/Screenshot 2024-09-03 081318.png', NULL, NULL),
(3, 1, 'D.O. 174 Series of 2017 (Contractor/ Sub - Contractor) Certicate', 'uploads/2.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employer_profile`
--

CREATE TABLE `employer_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `tel_num` varchar(255) DEFAULT NULL,
  `president` varchar(255) DEFAULT NULL,
  `HR` varchar(255) DEFAULT NULL,
  `company_mail` varchar(255) DEFAULT NULL,
  `HR_mail` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_profile`
--

INSERT INTO `employer_profile` (`id`, `user_id`, `company_name`, `company_address`, `tel_num`, `president`, `HR`, `company_mail`, `HR_mail`, `photo`) VALUES
(1, 1, 'BEEOTECH', 'Timugan Los Banos Laguna', '800-501', 'Patrick Deguzman', 'Mark Mercado', 'beeotech@gmail.com', 'mercadomark@gmail.com', '672b5e9b2e2bd.png');

-- --------------------------------------------------------

--
-- Table structure for table `empyers`
--

CREATE TABLE `empyers` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `Fname` varchar(255) DEFAULT NULL,
  `Lname` varchar(255) DEFAULT NULL,
  `Bdate` varchar(255) DEFAULT NULL,
  `contact` int(11) DEFAULT NULL,
  `is_verified` tinyint(4) DEFAULT NULL,
  `otp` varchar(255) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empyers`
--

INSERT INTO `empyers` (`id`, `username`, `password`, `email`, `Fname`, `Lname`, `Bdate`, `contact`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`) VALUES
(1, 'Mark23', '$2y$10$R9I0C7fn7S2YRlwR4mRfceR1wejWIKdniy6qlfthpa2AQC1LnZLW2', 'ict1mercado.cdlb@gmail.com', 'Mark', 'Mercado', '2002-07-23', 2147483647, 1, '133678', '2024-11-06 20:19:37', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Job_id` int(11) DEFAULT NULL,
  `sched_date` date DEFAULT NULL,
  `sched_time` time DEFAULT NULL,
  `interview` varchar(200) DEFAULT NULL,
  `meeting` varchar(200) DEFAULT NULL,
  `is_read` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interview`
--

INSERT INTO `interview` (`id`, `user_id`, `Job_id`, `sched_date`, `sched_time`, `interview`, `meeting`, `is_read`) VALUES
(1, 2, 2, '2024-11-06', '20:00:00', 'FacetoFace', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `j_id` int(11) NOT NULL,
  `employer_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `job_title` varchar(100) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `job_type` varchar(255) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `job_description` text NOT NULL,
  `selected_options` varchar(255) DEFAULT NULL,
  `vacant` int(11) NOT NULL,
  `requirment` varchar(255) NOT NULL,
  `work_location` varchar(255) NOT NULL,
  `education` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`j_id`, `employer_id`, `admin_id`, `job_title`, `company_name`, `job_type`, `salary`, `job_description`, `selected_options`, `vacant`, `requirment`, `work_location`, `education`, `remarks`, `date_posted`, `is_active`) VALUES
(1, NULL, 1, 'Service Crew', 'Jollibee ', 'Part time', 10000, 'n/a', 'Auto Mechanic', 2, 'â€¢ n/a', 'Calamba Laguna', 'High School Graduate', '', '2024-11-06', 1),
(2, NULL, 1, 'Programmer', ',Tech Inc', 'Prelance', 10000, 'TECH INC', 'Computer Literate', 3, 'â€¢Atleast 3 years experience', 'Calamba Laguna', 'High School Graduate', '', '2024-11-06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `language_proficiency`
--

CREATE TABLE `language_proficiency` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_p` varchar(255) NOT NULL,
  `read_l` tinyint(1) DEFAULT 0,
  `write_l` tinyint(1) DEFAULT 0,
  `speak_l` tinyint(1) DEFAULT 0,
  `understand_l` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_proficiency`
--

INSERT INTO `language_proficiency` (`id`, `user_id`, `language_p`, `read_l`, `write_l`, `speak_l`, `understand_l`) VALUES
(1, 1, 'English', 1, 0, 1, 1),
(2, 1, 'Filipino', 1, 0, 0, 0),
(3, 2, 'English', 0, 0, 0, 0),
(4, 2, 'Filipino', 0, 0, 0, 0),
(5, 2, 'English', 0, 0, 0, 0),
(6, 2, 'Filipino', 0, 0, 0, 0),
(7, 2, 'English', 0, 0, 0, 0),
(8, 2, 'Filipino', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `license`
--

CREATE TABLE `license` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `eligibility` varchar(255) NOT NULL,
  `rating` varchar(255) NOT NULL,
  `doe` date NOT NULL,
  `prc_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `license`
--

INSERT INTO `license` (`id`, `user_id`, `eligibility`, `rating`, `doe`, `prc_path`) VALUES
(1, 1, 'Lakewood', 'Corporis modi doloribus harum fugit repudiandae esse blanditiis.', '2024-01-18', '');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `module_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `module_name`) VALUES
(1, 1, 'sewing'),
(2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules_taken`
--

CREATE TABLE `modules_taken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `status` varchar(200) DEFAULT 'fail',
  `date_taken` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules_taken`
--

INSERT INTO `modules_taken` (`id`, `user_id`, `module_id`, `status`, `date_taken`) VALUES
(1, 2, 1, 'fail', '2024-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `module_content`
--

CREATE TABLE `module_content` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `modules_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_content`
--

INSERT INTO `module_content` (`id`, `description`, `video`, `file_path`, `modules_id`) VALUES
(1, 'Try', 'https://www.youtube.com/watch?v=2MZQKsiUk7E&t=1893s', 'uploads/rem.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `image`, `description`, `created_at`) VALUES
(1, 'NCC', 'news/Planet9_3840x2160.jpg', 'PESO', '2024-11-06 07:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `ofw_profile`
--

CREATE TABLE `ofw_profile` (
  `id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `otp_expiry` datetime NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `prefix` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `sex` enum('Male','Female') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `civil_status` enum('Single','Married','Widowed','Separated') DEFAULT NULL,
  `house_address` text DEFAULT NULL,
  `contact_no` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sss_no` varchar(20) DEFAULT NULL,
  `pagibig_no` varchar(20) DEFAULT NULL,
  `philhealth_no` varchar(20) DEFAULT NULL,
  `passport_no` varchar(20) DEFAULT NULL,
  `immigration_status` enum('Documented','Undocumented','Returning','Repatriated') DEFAULT NULL,
  `education_level` enum('Elementary Undergraduate','Elementary Graduate','High School Undergraduate','High School Graduate','College Undergraduate','College Graduate','Vocational') DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `spouse_contact` varchar(20) DEFAULT NULL,
  `fathers_name` varchar(100) DEFAULT NULL,
  `fathers_address` text DEFAULT NULL,
  `mothers_name` varchar(100) DEFAULT NULL,
  `mothers_address` text DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `emergency_contact_num` varchar(20) DEFAULT NULL,
  `next_of_kin_relationship` varchar(50) DEFAULT NULL,
  `next_of_kin_contact` varchar(20) DEFAULT NULL,
  `occupation` enum('Administrative Work','Medical Work','Factory/Manufacturing','Farmers (Agriculture)','Teaching','Information Technology','Engineering','Restaurant Jobs (F&B)','Seaman (Sea-Based)','Household Service Worker (Domestic Helper)','Construction Work','Entertainment','Tourism Sector','Hospitality Sector','Others') DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `employment_type` enum('Land-Based','Sea-Based') DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `employment_form` enum('Recruitment Agency','Government Hire','Name Hire','Referral') DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `employer_name` varchar(100) DEFAULT NULL,
  `employer_address` text DEFAULT NULL,
  `local_agency_name` varchar(100) DEFAULT NULL,
  `local_agency_address` text DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ofw_profile`
--

INSERT INTO `ofw_profile` (`id`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`, `is_verified`, `username`, `password`, `profile_image`, `last_name`, `first_name`, `middle_name`, `prefix`, `dob`, `sex`, `age`, `civil_status`, `house_address`, `contact_no`, `email`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `immigration_status`, `education_level`, `spouse_name`, `spouse_contact`, `fathers_name`, `fathers_address`, `mothers_name`, `mothers_address`, `emergency_contact_name`, `emergency_contact_num`, `next_of_kin_relationship`, `next_of_kin_contact`, `occupation`, `income`, `employment_type`, `country`, `employment_form`, `contact_number`, `employer_name`, `employer_address`, `local_agency_name`, `local_agency_address`, `departure_date`, `arrival_date`) VALUES
(1, '482293', '2024-11-06 15:15:16', NULL, NULL, 1, 'deguzman', '$2y$10$fh6P7HMLxGEmklZs8MEBlex2wQ9ZN7HnBaEXcntHAl7GrQp7drIBq', '17308771206774684244781095607996.jpg', 'De Guzman', 'Patrick', 'PeÃ±a', '', '2024-11-06', 'Male', 22, 'Single', '1356 Purok 5, Baklasan Street', '09557507465', 'deguzmanpatrick.cdlb@gmail.com', '542', '', '', '', 'Documented', 'College Graduate', '', '', '', '1356 Purok 5, Baklasan Street', '', '', 'Patrick PeÃ±a De Guzman', '', '', '09557507465', 'Information Technology', '200.00', 'Land-Based', 'Bayog', 'Government Hire', '09557507465', 'None', '1356 Purok 5, Baklasan Street', 'Patrick PeÃ±a De Guzman', '1356 Purok 5, Baklasan Street', '2024-11-06', '2024-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_answer` varchar(255) DEFAULT NULL,
  `marks` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `quiz_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `marks`) VALUES
(3, 2, 'sda', 'w', 'a', 'c', 'z', 'a', 1),
(4, 2, 'asd', ' xz', 'xzx', 'ZX', 'czx', 'a', 1),
(5, 2, 'xczxc', 'cz', 'c', 'a', 'zx', 'a', 1),
(6, 2, 'sda', 'xc', 'sd', 'xa', 'sd', 'a', 1),
(7, 2, 'xzcsc', 'xs', 'sd', 'a', 'a', 'a', 1),
(8, 2, '1', 'asd', 'dfg', 'ser', 'hgdrt', 'b', 1),
(9, 2, '2', 'asdf', 'fdsghs', 'dhgd', 'sewgfser', 'b', 1),
(10, 2, '4', 'asdf', 'gdsfh', 'gh', 'awe', 'd', 1),
(11, 2, '6', 'asdf', 'fghdg', 'segrg', 'fghbfdth', 'b', 1),
(12, 2, '8', 'asdf', 'gfdh', 'drth', 'swe4tfgtes', 'a', 1),
(13, 2, '1', 'asd', 'dfg', 'ser', 'hgdrt', 'b', 1),
(14, 2, '2', 'asdf', 'fdsghs', 'dhgd', 'sewgfser', 'b', 1),
(15, 2, '4', 'asdf', 'gdsfh', 'gh', 'awe', 'd', 1),
(16, 2, '6', 'asdf', 'fghdg', 'segrg', 'fghbfdth', 'b', 1),
(17, 2, '8', 'asdf', 'gfdh', 'drth', 'swe4tfgtes', 'a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_name`
--

CREATE TABLE `quiz_name` (
  `id` int(11) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `correct_ans` int(11) DEFAULT NULL,
  `wrong_ans` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_name`
--

INSERT INTO `quiz_name` (`id`, `module_id`, `title`, `correct_ans`, `wrong_ans`, `total`, `tag`, `date`) VALUES
(2, 1, 'Tahi', 3, 3, 5, 'Quiz 1', '2024-11-06 02:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `save_job`
--

CREATE TABLE `save_job` (
  `id` int(11) NOT NULL,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_form`
--

CREATE TABLE `survey_form` (
  `id` int(11) NOT NULL,
  `question` varchar(200) DEFAULT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_reponse`
--

CREATE TABLE `survey_reponse` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `survey_id` int(11) DEFAULT NULL,
  `reponse` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE `training` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `training` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `institution` varchar(255) NOT NULL,
  `certificate_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `training`
--

INSERT INTO `training` (`id`, `user_id`, `training`, `start_date`, `end_date`, `institution`, `certificate_path`) VALUES
(1, 1, 'Dolorum nostrum suscipit accusantium nostrum harum distinctio.', '2025-04-20', '2024-07-25', 'Consequuntur sint fugiat adipisci aliquam.', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `answer` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `question_id`, `quiz_id`, `answer`) VALUES
(3, 2, 1, 1, 'a'),
(4, 2, 2, 1, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `user_score`
--

CREATE TABLE `user_score` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `correct_answers` int(11) DEFAULT NULL,
  `wrong_answers` int(11) DEFAULT NULL,
  `dates` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_score`
--

INSERT INTO `user_score` (`id`, `user_id`, `quiz_id`, `score`, `correct_answers`, `wrong_answers`, `dates`) VALUES
(2, 2, 1, 2, 2, 0, '2024-11-06 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `work_exp`
--

CREATE TABLE `work_exp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `started_date` date NOT NULL,
  `termination_date` date NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_exp`
--

INSERT INTO `work_exp` (`id`, `user_id`, `company_name`, `address`, `position`, `started_date`, `termination_date`, `status`) VALUES
(1, 1, 'Kessler - Armstrong', '20104 Mueller Streets', 'Dicta debitis consequatur ipsa voluptas eius dolores dignissimos.', '2025-04-20', '2024-07-25', 'Idaho');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_profile`
--
ALTER TABLE `admin_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_id` (`applicant_id`),
  ADD KEY `job_posting_id` (`job_posting_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employer_documents`
--
ALTER TABLE `employer_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employer_doc_id` (`user_id`);

--
-- Indexes for table `employer_profile`
--
ALTER TABLE `employer_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employerid` (`user_id`);

--
-- Indexes for table `empyers`
--
ALTER TABLE `empyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interview`
--
ALTER TABLE `interview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`j_id`),
  ADD KEY `employer_job_id` (`employer_id`);

--
-- Indexes for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `license`
--
ALTER TABLE `license`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules_taken`
--
ALTER TABLE `modules_taken`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `module_content`
--
ALTER TABLE `module_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_name`
--
ALTER TABLE `quiz_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `save_job`
--
ALTER TABLE `save_job`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_form`
--
ALTER TABLE `survey_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_reponse`
--
ALTER TABLE `survey_reponse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training`
--
ALTER TABLE `training`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_score`
--
ALTER TABLE `user_score`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_exp`
--
ALTER TABLE `work_exp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profile`
--
ALTER TABLE `admin_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employer_profile`
--
ALTER TABLE `employer_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `empyers`
--
ALTER TABLE `empyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `j_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `language_proficiency`
--
ALTER TABLE `language_proficiency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `license`
--
ALTER TABLE `license`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules_taken`
--
ALTER TABLE `modules_taken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `module_content`
--
ALTER TABLE `module_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ofw_profile`
--
ALTER TABLE `ofw_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `quiz_name`
--
ALTER TABLE `quiz_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `save_job`
--
ALTER TABLE `save_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_form`
--
ALTER TABLE `survey_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey_reponse`
--
ALTER TABLE `survey_reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training`
--
ALTER TABLE `training`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_score`
--
ALTER TABLE `user_score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_exp`
--
ALTER TABLE `work_exp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
