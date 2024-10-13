-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2024 at 07:46 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peso`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_profile`
--

CREATE TABLE `admin_profile` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_level` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`id`, `username`, `password`, `email`, `admin_level`, `full_name`, `phone`, `profile_picture`) VALUES
(1, 'Admin', '$2y$10$szZWza9fsLiGXs4evidE7.uc3zwFoQjs/hfwGvw2Vd6lddYLzBuTW', 'mercadomarklawrence55@gmail.com', 'super_admin', 'Mark Azre', '09762848025', 'uploads/woman-portrait.png'),
(11, 'Azure', '$2y$10$YuRbmR/kQCpQboBgFIElG.RcD9HI.1fcK15MQIngeRH1arwEyofJq', 'hygoteba@mailinator.com', 'admin', 'Kylan Mcmahon', '7551', 'uploads/barack-obama.png');

-- --------------------------------------------------------

--
-- Table structure for table `applicant_profile`
--

CREATE TABLE `applicant_profile` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `middle_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `height` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sex` enum('male','female') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `civil_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_no` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `landline` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'user.png',
  `house_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sss_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pagibig_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `philhealth_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passport_no` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `immigration_status` enum('Documented','Undocumented','Returning','Repatriated') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `spouse_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `spouse_contact` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fathers_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fathers_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mothers_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mothers_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_contact_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `next_of_kin_relationship` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `next_of_kin_contact` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `education_level` enum('Elementary Undergraduate','Elementary Graduate','High School Undergraduate','High School Graduate','College Undergraduate','College Graduate','Vocational') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `occupation` enum('Administrative Work','Medical Work','Factory/Manufacturing','Farmers (Agriculture)','Teaching','Information Technology','Engineering','Restaurant Jobs (F&B)','Seaman (Sea-Based)','Household Service Worker (Domestic Helper)','Construction Work','Entertainment','Tourism Sector','Hospitality Sector','Others') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pwd` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pwd2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prefix` enum('Sr.','Jr.','II','III','IV','V','VI','VII') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `four_ps` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_contact_num` int DEFAULT NULL,
  `income` int DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `religion` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employment_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employment_form` enum('Recruitment Agency','Government Hire','Name Hire','Referral') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employer_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_number` int DEFAULT NULL,
  `employer_address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `local_agency_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `local_agency_address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `dept_date` date DEFAULT NULL,
  `employment_status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `actively_looking` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `willing_to_work` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `expected_salary` int DEFAULT NULL,
  `resume` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_profile`
--

INSERT INTO `applicant_profile` (`id`, `user_id`, `email`, `first_name`, `last_name`, `middle_name`, `dob`, `pob`, `age`, `height`, `specialization`, `sex`, `civil_status`, `contact_no`, `landline`, `photo`, `house_address`, `tin`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `immigration_status`, `spouse_name`, `spouse_contact`, `fathers_name`, `fathers_address`, `mothers_name`, `mothers_address`, `emergency_contact_name`, `next_of_kin_relationship`, `next_of_kin_contact`, `education_level`, `occupation`, `pwd`, `pwd2`, `prefix`, `four_ps`, `emergency_contact_num`, `income`, `country`, `religion`, `employment_type`, `employment_form`, `employer_name`, `contact_number`, `employer_address`, `local_agency_name`, `local_agency_address`, `arrival_date`, `dept_date`, `employment_status`, `actively_looking`, `willing_to_work`, `passport_expiry`, `expected_salary`, `resume`) VALUES
(26, 43, 'tepezaveza@mailinator.com', 'Maggy', 'Bonner', 'Allegra Stokes', '2018-07-15', 'Consequatur eveniet', 10, 'In sit dolores minus', NULL, 'female', 'Live-in', '+1 (886) 188-6705', '+1 (844) 133-8456', 'woman.png', 'Beatae ut numquam qu', 'Sed quos dolore pari', 'Minim tempor exercit', 'Obcaecati aut reicie', 'Esse sit ullam tota', 'Quis commodo tempor ', 'Repatriated', 'Kelly Saunders', '36', 'Brent Norris', 'Eaque velit ut quisq', 'Nissim Yang', 'Et molestias asperna', 'Holly Mcgowan', 'Minima incididunt au', '80', 'Elementary Graduate', 'Restaurant Jobs (F&B)', 'Others', '', 'V', 'No', 63, 768, 'Aliquam id placeat ', 'Repellendus Id accu', 'Sea-Based', 'Referral', 'Gould and Harper Trading', 365, 'Bryan and Hunt Associates', 'Sheila Sullivan', 'Consequatur consect', '1984-08-11', '2012-02-15', 'unemployed', 'No', 'Yes', '2010-06-11', 123456, 'favicon.ico'),
(27, 44, 'raqitym@mailinator.com', 'Dillon', 'Henderson', 'Quon Mcdaniel', '1992-08-29', '', 87, NULL, NULL, 'male', 'Widowed', '5889', NULL, '6707dba238f33.png', 'Sunt et quo volupta', NULL, '0', '0', '0', '16', 'Documented', 'Jamal Carr', '62', 'Riley Atkinson', 'Et odit deserunt min', 'Reuben Shields', 'Eu et culpa aut labo', 'Lawrence Campos', 'Ea eos dolorem cons', '3', 'Elementary Graduate', 'Others', NULL, '', 'V', NULL, 69, 124, 'Odit non qui delenit', NULL, 'Sea-Based', 'Name Hire', 'Cotton Strickland Trading', 499, 'Mejia and Johns Trading', 'Halla Mckay', 'Dolorum asperiores i', '2009-08-10', '2010-11-11', NULL, NULL, NULL, NULL, NULL, NULL),
(28, 45, 'nawa@mailinator.com', 'Mari', 'Talley', 'Giselle Cervantes', '1986-05-26', '', 69, NULL, NULL, 'male', 'Single', '5731187', NULL, '67086b9d1de62.jpg', 'Ad omnis laborum qui', NULL, '0', '0', '0', '630', 'Undocumented', 'Lysandra Wilkerson', '2', 'Judah Levy', 'Ab veritatis cum nul', 'Morgan Oconnor', 'Officiis ea sunt aut', 'Imani Russell', 'Nostrud id repudiand', '600', 'Elementary Undergraduate', 'Others', NULL, '', 'IV', NULL, 60, 432, 'Adipisci reiciendis ', NULL, 'Land-Based', 'Referral', 'Jackson Battle Traders', 435, 'Hampton and Marks Associates', 'Shannon Irwin', 'Doloribus aut conseq', '2017-05-02', '1974-05-19', NULL, NULL, NULL, NULL, NULL, NULL),
(29, 46, 'voxajo@mailinator.com', 'Allegra', 'Bradshaw', 'Velma Gilmore', '1977-06-23', '', 16, NULL, NULL, 'male', 'Married', '4967', NULL, '6707de8f0147b.jpg', 'Sint sed proident q', NULL, '0', '0', '0', '99', 'Returning', 'Sophia Holcomb', '42', 'Keiko Buck', 'Quia sunt non esse a', 'Cheryl Mccarty', 'Quaerat fugiat enim ', 'William Castillo', 'Consequatur tenetur', '411', 'College Graduate', 'Information Technology', NULL, '', 'V', NULL, 95, 336, 'Et obcaecati soluta ', NULL, 'Sea-Based', 'Government Hire', 'Garrison Deleon Plc', 291, 'Mcdaniel and Jacobson Trading', 'Blair Stokes', 'Ratione sed sit aut ', '2003-03-31', '2000-05-04', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int NOT NULL,
  `applicant_id` int DEFAULT NULL,
  `job_posting_id` int DEFAULT NULL,
  `application_date` date DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `job` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `applicant_id`, `job_posting_id`, `application_date`, `status`, `job`) VALUES
(67, 45, 30, '2024-10-13', 'interview', 'International Tactics Supervisor'),
(68, 45, 29, '2024-10-13', 'pending', 'District Directives Specialist'),
(69, 45, 27, '2024-10-13', 'pending', 'Future Tactics Manager'),
(70, 45, 26, '2024-10-13', 'pending', 'Corporate Metrics Liaison'),
(71, 45, 25, '2024-10-13', 'pending', 'Internal Tactics Specialist'),
(72, 45, 24, '2024-10-13', 'interview', 'Principal Accountability Strategist'),
(73, 45, 23, '2024-10-13', 'interview', 'Customer Branding Associate');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('filed','in_progress','resolved') COLLATE utf8mb4_unicode_ci DEFAULT 'filed',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `user_id`, `title`, `description`, `file`, `status`, `created_at`) VALUES
(12, 45, 'Abusive employer', 'harassment, physical abuse', '../uploads/462463385_1483381795713486_9058732459192274728_n.png', 'resolved', '2024-10-11 00:14:44'),
(13, 44, 'Underpaid', 'Salary decrease and unpaid work', 'uploads/PESO.pdf', 'in_progress', '2024-10-11 00:18:25'),
(14, 43, 'LAw', 'fgsadfawee', 'uploads/PESO.pdf', 'filed', '2024-10-12 12:12:46'),
(15, 43, 'LAwnew', 'fgsadfawee', 'uploads/e-Phil-ID.pdf', 'filed', '2024-10-12 13:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sender` varchar(100) NOT NULL,
  `message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `sender`, `message`, `timestamp`) VALUES
(7, 43, 'user', 'Hi', '2024-10-12 07:19:48');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `messages` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int NOT NULL,
  `course_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `module_count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `module_count`) VALUES
(1, 'Dressmaking', 'sewing', 3),
(5, 'Digital Marketing Essentials', 'Master the fundamentals of digital marketing, including SEO, social media strategies, content creation, and paid advertising.', 3),
(6, 'Auto motive', 'Car and Motor workshop', 2),
(19, 'Wood works', 'Sculpting, chair, cabinet making', 4),
(21, 'Excepturi omnis dolo', 'Sapiente voluptatibu', 490);

-- --------------------------------------------------------

--
-- Table structure for table `employer_documents`
--

CREATE TABLE `employer_documents` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `document_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_documents`
--

INSERT INTO `employer_documents` (`id`, `user_id`, `document_name`, `document_path`, `is_verified`, `comment`) VALUES
(3, 9, 'Single', 'uploads/philsys id.png', 1, NULL),
(4, 10, 'Single', 'uploads/ITEP414-SAM-Assignment-2-and-Task-2.pdf', 1, NULL),
(5, 11, 'Single', 'uploads/ITEP414-SAM-Assignment-1-and-Task-1.pdf', 1, NULL),
(6, 11, 'Single', 'uploads/CLAIM-MERCADO, MARK LAWRENCE ARANDA_2023-1.docx', 0, NULL),
(7, 9, 'D.O. 174 Series of 2017 (Contractor/ Sub - Contractor) Certicate', 'uploads/barack-obama.png', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employer_profile`
--

CREATE TABLE `employer_profile` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `company_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `president` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HR` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `HR_mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_profile`
--

INSERT INTO `employer_profile` (`id`, `user_id`, `company_name`, `company_address`, `tel_num`, `president`, `HR`, `company_mail`, `HR_mail`, `photo`) VALUES
(9, 9, 'Wehner inc', '47505 Rosenbaum Rapids', '75', 'Grady Doyle', 'Voluptatum sunt eligendi repellat nihil officiis deleniti quos.', 'Harber, Brown and Strosin', 'your.email+fakedata60367@gmail.com', '67075944b1138.png'),
(10, 10, 'Lehner Group', '72695 Stoltenberg Parkway', '49', 'Breitenberg Schmitt', 'John Schmitt', 'Senger, Runolfsson and Gerlach', 'your.email+fakedata52491@gmail.com', '6708ea2fc3a24.png'),
(11, 11, 'Herzog Inc', '25813 Ward Well', '62', 'Lemke O Connell', 'Carol Yundt', 'Hilpert, Lakin and Doyle', 'your.email+fakedata66606@gmail.com', '670760a7022ed.png');

-- --------------------------------------------------------

--
-- Table structure for table `empyers`
--

CREATE TABLE `empyers` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Bdate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` int DEFAULT NULL,
  `is_verified` tinyint DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empyers`
--

INSERT INTO `empyers` (`id`, `username`, `password`, `email`, `Fname`, `Lname`, `Bdate`, `contact`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`) VALUES
(9, 'Mark55', '$2y$10$Pne11S1JqPKgRbXvf88I2OA8wF9hEH8PMenlS26deUJ0GMdu70nlq', 'mercadomarklawrence55@gmail.com', 'Brady Parker', 'Gloria Acevedo', '1976-09-19', 9136, 1, '836619', '2024-10-10 12:32:12', NULL, NULL),
(10, 'Ict1', '$2y$10$so3p8.RcQnOqPiCAva0X1uGvZ2X7X2wV3aziLsQ2eIT8siaXlZWQC', 'ict1mercado.cdlb@gmail.com', NULL, NULL, NULL, NULL, 1, '606376', '2024-10-10 12:41:57', NULL, NULL),
(11, 'Batbat', '$2y$10$QTbi7Iy1aVIVgfFapjB/weUo9TzbOwLaJkN2qP.eFXz4OuBLFBcFG', 'marklawrencemercado8@gmail.com', NULL, NULL, NULL, NULL, 1, '878316', '2024-10-10 12:49:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `interview`
--

CREATE TABLE `interview` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `Job_id` int DEFAULT NULL,
  `sched_date` date DEFAULT NULL,
  `sched_time` time DEFAULT NULL,
  `interview` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meeting` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_read` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interview`
--

INSERT INTO `interview` (`id`, `user_id`, `Job_id`, `sched_date`, `sched_time`, `interview`, `meeting`, `is_read`) VALUES
(11, 45, 17, '2024-10-09', '13:38:00', 'FacetoFace', '', 1),
(12, 45, 18, '2024-10-01', '13:30:00', 'FacetoFace', '', 1),
(13, 45, 30, '2025-03-23', '02:29:00', 'FacetoFace', 'lalakay laguna', 0),
(14, 45, 24, '2024-10-31', '13:30:00', 'FacetoFace', '', 0),
(15, 45, 23, '2024-10-29', '18:28:00', 'online', 'asdwasscadwa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `j_id` int NOT NULL,
  `employer_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `job_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialization` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vacant` int NOT NULL,
  `requirment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_posted` date NOT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`j_id`, `employer_id`, `admin_id`, `job_title`, `job_type`, `job_description`, `specialization`, `vacant`, `requirment`, `work_location`, `remarks`, `date_posted`, `is_active`) VALUES
(17, 9, NULL, 'Principal Creative Specialist', '', 'Forward Interactions Officer', NULL, 11, 'College Graduate', '3012 Raynor Junction', '', '2024-10-10', 1),
(18, 10, NULL, 'Corporate Markets Strategist', '', 'Customer Response Administrator', NULL, 25, 'Market graduate, ', '8747 Shanie Islands', '', '2024-10-10', 1),
(19, 11, NULL, 'Human Communications Engineer', '', 'Legacy Optimization Agent', NULL, 439, '2ys work experience ', '417 Kub Locks', '', '2024-10-10', 1),
(23, NULL, 1, 'Customer Branding Associate', '', 'Forward Factors Orchestrator', '', 65, 'Deserunt dignissimos repellat ex reprehenderit dolore velit explicabo.', '87400 Toy Well', 'Iusto recusandae suscipit expedita quas cumque.', '2024-10-12', 1),
(24, NULL, 1, 'Principal Accountability Strategist', '', 'Forward Security Developer', '', 182, 'Ipsa expedita esse ipsam totam ullam pariatur corrupti doloribus.', '368 Aleen Rue', 'Dolorum laboriosam cupiditate eum.', '2024-10-12', 1),
(25, NULL, 1, 'Internal Tactics Specialist', '', 'Global Branding Specialist', '', 263, 'Unde dignissimos repellendus dolorum corporis voluptate voluptatum.', '31659 Justina Extension', 'Voluptas temporibus alias eius ipsam ipsum blanditiis cum fuga saepe.', '2024-10-12', 1),
(26, NULL, 11, 'Corporate Metrics Liaison', '', 'Principal Mobility Manager', '', 639, 'Distinctio ipsum saepe nobis asperiores temporibus iste quas sunt.', 'Ab minus tempore commodi iste.', 'Nihil veritatis porro culpa eligendi impedit nostrum cupiditate impedit voluptatum.', '2024-10-12', 1),
(27, NULL, 11, 'Future Tactics Manager', '', 'Customer Accounts Strategist', '', 510, 'Incidunt facilis ut natus nisi architecto accusamus nam ea.', 'Harum iusto rerum libero.', 'Iusto harum tenetur iusto optio dolore distinctio labore.', '2024-10-12', 1),
(28, 9, NULL, 'Human Mobility Assistant', 'Part time', 'Forward Factors Officer', NULL, 102, 'Itaque maxime harum.', 'Voluptatibus molestias culpa expedita vero exercitationem.', '', '2024-10-12', 1),
(29, NULL, 1, 'District Directives Specialist', 'Fulltime', 'Dynamic Factors Supervisor', '', 598, 'Repellat a eveniet fugiat sequi modi occaecati nesciunt.', '7001 Johnston Ferry', 'Necessitatibus ea magni aut soluta magnam iure sequi quasi.', '2024-10-13', 1),
(30, NULL, 1, 'International Tactics Supervisor', 'Fulltime', 'Principal Implementation Analyst', '', 663, 'Incidunt laborum facere voluptatem quia placeat.', '7994 Brandt Forest', 'Adipisci nesciunt perferendis magni dignissimos dolore.', '2024-10-13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int NOT NULL,
  `course_id` int DEFAULT NULL,
  `module_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `course_id`, `module_name`) VALUES
(1, 1, 'measurements'),
(2, 1, 'needle & thread'),
(3, 1, 'Cutting'),
(4, 3, 'new1'),
(5, 3, 'new12'),
(6, 4, 'Baking'),
(7, 4, 'Grilling'),
(9, 5, 'Introduction to Digital Marketing'),
(10, 5, 'Search Engine Optimization (SEO)'),
(11, 5, ' Social Media Marketing'),
(12, 4, 'Frying'),
(13, 2, 'dfe'),
(14, 2, 'dsaadw'),
(15, 2, 'wfd3we'),
(16, 1, 'Drafting'),
(19, 18, NULL),
(20, 18, NULL),
(21, 18, NULL),
(22, 19, 'Sculpture'),
(23, 19, 'Chair & table building'),
(24, 19, 'Bamboo Item'),
(27, 20, NULL),
(28, 20, NULL),
(29, 20, NULL),
(30, 20, NULL),
(31, 20, NULL),
(32, 20, NULL),
(33, 20, NULL),
(34, 20, NULL),
(35, 20, NULL),
(36, 20, NULL),
(37, 20, NULL),
(40, 21, NULL),
(41, 21, NULL),
(42, 21, NULL),
(43, 21, NULL),
(44, 21, NULL),
(45, 21, NULL),
(46, 21, NULL),
(47, 21, NULL),
(48, 21, NULL),
(49, 21, NULL),
(50, 21, NULL),
(51, 21, NULL),
(52, 21, NULL),
(53, 21, NULL),
(54, 21, NULL),
(55, 21, NULL),
(56, 21, NULL),
(57, 21, NULL),
(58, 21, NULL),
(59, 21, NULL),
(60, 21, NULL),
(61, 21, NULL),
(62, 21, NULL),
(63, 21, NULL),
(64, 21, NULL),
(65, 21, NULL),
(66, 21, NULL),
(67, 21, NULL),
(68, 21, NULL),
(69, 21, NULL),
(70, 21, NULL),
(71, 21, NULL),
(72, 21, NULL),
(73, 21, NULL),
(74, 21, NULL),
(75, 21, NULL),
(76, 21, NULL),
(77, 21, NULL),
(78, 21, NULL),
(79, 21, NULL),
(80, 21, NULL),
(81, 21, NULL),
(82, 21, NULL),
(83, 21, NULL),
(84, 21, NULL),
(85, 21, NULL),
(86, 21, NULL),
(87, 21, NULL),
(88, 21, NULL),
(89, 21, NULL),
(90, 21, NULL),
(91, 21, NULL),
(92, 21, NULL),
(93, 21, NULL),
(94, 21, NULL),
(95, 21, NULL),
(96, 21, NULL),
(97, 21, NULL),
(98, 21, NULL),
(99, 21, NULL),
(100, 21, NULL),
(101, 21, NULL),
(102, 21, NULL),
(103, 21, NULL),
(104, 21, NULL),
(105, 21, NULL),
(106, 21, NULL),
(107, 21, NULL),
(108, 21, NULL),
(109, 21, NULL),
(110, 21, NULL),
(111, 21, NULL),
(112, 21, NULL),
(113, 21, NULL),
(114, 21, NULL),
(115, 21, NULL),
(116, 21, NULL),
(117, 21, NULL),
(118, 21, NULL),
(119, 21, NULL),
(120, 21, NULL),
(121, 21, NULL),
(122, 21, NULL),
(123, 21, NULL),
(124, 21, NULL),
(125, 21, NULL),
(126, 21, NULL),
(127, 21, NULL),
(128, 21, NULL),
(129, 21, NULL),
(130, 21, NULL),
(131, 21, NULL),
(132, 21, NULL),
(133, 21, NULL),
(134, 21, NULL),
(135, 21, NULL),
(136, 21, NULL),
(137, 21, NULL),
(138, 21, NULL),
(139, 21, NULL),
(140, 21, NULL),
(141, 21, NULL),
(142, 21, NULL),
(143, 21, NULL),
(144, 21, NULL),
(145, 21, NULL),
(146, 21, NULL),
(147, 21, NULL),
(148, 21, NULL),
(149, 21, NULL),
(150, 21, NULL),
(151, 21, NULL),
(152, 21, NULL),
(153, 21, NULL),
(154, 21, NULL),
(155, 21, NULL),
(156, 21, NULL),
(157, 21, NULL),
(158, 21, NULL),
(159, 21, NULL),
(160, 21, NULL),
(161, 21, NULL),
(162, 21, NULL),
(163, 21, NULL),
(164, 21, NULL),
(165, 21, NULL),
(166, 21, NULL),
(167, 21, NULL),
(168, 21, NULL),
(169, 21, NULL),
(170, 21, NULL),
(171, 21, NULL),
(172, 21, NULL),
(173, 21, NULL),
(174, 21, NULL),
(175, 21, NULL),
(176, 21, NULL),
(177, 21, NULL),
(178, 21, NULL),
(179, 21, NULL),
(180, 21, NULL),
(181, 21, NULL),
(182, 21, NULL),
(183, 21, NULL),
(184, 21, NULL),
(185, 21, NULL),
(186, 21, NULL),
(187, 21, NULL),
(188, 21, NULL),
(189, 21, NULL),
(190, 21, NULL),
(191, 21, NULL),
(192, 21, NULL),
(193, 21, NULL),
(194, 21, NULL),
(195, 21, NULL),
(196, 21, NULL),
(197, 21, NULL),
(198, 21, NULL),
(199, 21, NULL),
(200, 21, NULL),
(201, 21, NULL),
(202, 21, NULL),
(203, 21, NULL),
(204, 21, NULL),
(205, 21, NULL),
(206, 21, NULL),
(207, 21, NULL),
(208, 21, NULL),
(209, 21, NULL),
(210, 21, NULL),
(211, 21, NULL),
(212, 21, NULL),
(213, 21, NULL),
(214, 21, NULL),
(215, 21, NULL),
(216, 21, NULL),
(217, 21, NULL),
(218, 21, NULL),
(219, 21, NULL),
(220, 21, NULL),
(221, 21, NULL),
(222, 21, NULL),
(223, 21, NULL),
(224, 21, NULL),
(225, 21, NULL),
(226, 21, NULL),
(227, 21, NULL),
(228, 21, NULL),
(229, 21, NULL),
(230, 21, NULL),
(231, 21, NULL),
(232, 21, NULL),
(233, 21, NULL),
(234, 21, NULL),
(235, 21, NULL),
(236, 21, NULL),
(237, 21, NULL),
(238, 21, NULL),
(239, 21, NULL),
(240, 21, NULL),
(241, 21, NULL),
(242, 21, NULL),
(243, 21, NULL),
(244, 21, NULL),
(245, 21, NULL),
(246, 21, NULL),
(247, 21, NULL),
(248, 21, NULL),
(249, 21, NULL),
(250, 21, NULL),
(251, 21, NULL),
(252, 21, NULL),
(253, 21, NULL),
(254, 21, NULL),
(255, 21, NULL),
(256, 21, NULL),
(257, 21, NULL),
(258, 21, NULL),
(259, 21, NULL),
(260, 21, NULL),
(261, 21, NULL),
(262, 21, NULL),
(263, 21, NULL),
(264, 21, NULL),
(265, 21, NULL),
(266, 21, NULL),
(267, 21, NULL),
(268, 21, NULL),
(269, 21, NULL),
(270, 21, NULL),
(271, 21, NULL),
(272, 21, NULL),
(273, 21, NULL),
(274, 21, NULL),
(275, 21, NULL),
(276, 21, NULL),
(277, 21, NULL),
(278, 21, NULL),
(279, 21, NULL),
(280, 21, NULL),
(281, 21, NULL),
(282, 21, NULL),
(283, 21, NULL),
(284, 21, NULL),
(285, 21, NULL),
(286, 21, NULL),
(287, 21, NULL),
(288, 21, NULL),
(289, 21, NULL),
(290, 21, NULL),
(291, 21, NULL),
(292, 21, NULL),
(293, 21, NULL),
(294, 21, NULL),
(295, 21, NULL),
(296, 21, NULL),
(297, 21, NULL),
(298, 21, NULL),
(299, 21, NULL),
(300, 21, NULL),
(301, 21, NULL),
(302, 21, NULL),
(303, 21, NULL),
(304, 21, NULL),
(305, 21, NULL),
(306, 21, NULL),
(307, 21, NULL),
(308, 21, NULL),
(309, 21, NULL),
(310, 21, NULL),
(311, 21, NULL),
(312, 21, NULL),
(313, 21, NULL),
(314, 21, NULL),
(315, 21, NULL),
(316, 21, NULL),
(317, 21, NULL),
(318, 21, NULL),
(319, 21, NULL),
(320, 21, NULL),
(321, 21, NULL),
(322, 21, NULL),
(323, 21, NULL),
(324, 21, NULL),
(325, 21, NULL),
(326, 21, NULL),
(327, 21, NULL),
(328, 21, NULL),
(329, 21, NULL),
(330, 21, NULL),
(331, 21, NULL),
(332, 21, NULL),
(333, 21, NULL),
(334, 21, NULL),
(335, 21, NULL),
(336, 21, NULL),
(337, 21, NULL),
(338, 21, NULL),
(339, 21, NULL),
(340, 21, NULL),
(341, 21, NULL),
(342, 21, NULL),
(343, 21, NULL),
(344, 21, NULL),
(345, 21, NULL),
(346, 21, NULL),
(347, 21, NULL),
(348, 21, NULL),
(349, 21, NULL),
(350, 21, NULL),
(351, 21, NULL),
(352, 21, NULL),
(353, 21, NULL),
(354, 21, NULL),
(355, 21, NULL),
(356, 21, NULL),
(357, 21, NULL),
(358, 21, NULL),
(359, 21, NULL),
(360, 21, NULL),
(361, 21, NULL),
(362, 21, NULL),
(363, 21, NULL),
(364, 21, NULL),
(365, 21, NULL),
(366, 21, NULL),
(367, 21, NULL),
(368, 21, NULL),
(369, 21, NULL),
(370, 21, NULL),
(371, 21, NULL),
(372, 21, NULL),
(373, 21, NULL),
(374, 21, NULL),
(375, 21, NULL),
(376, 21, NULL),
(377, 21, NULL),
(378, 21, NULL),
(379, 21, NULL),
(380, 21, NULL),
(381, 21, NULL),
(382, 21, NULL),
(383, 21, NULL),
(384, 21, NULL),
(385, 21, NULL),
(386, 21, NULL),
(387, 21, NULL),
(388, 21, NULL),
(389, 21, NULL),
(390, 21, NULL),
(391, 21, NULL),
(392, 21, NULL),
(393, 21, NULL),
(394, 21, NULL),
(395, 21, NULL),
(396, 21, NULL),
(397, 21, NULL),
(398, 21, NULL),
(399, 21, NULL),
(400, 21, NULL),
(401, 21, NULL),
(402, 21, NULL),
(403, 21, NULL),
(404, 21, NULL),
(405, 21, NULL),
(406, 21, NULL),
(407, 21, NULL),
(408, 21, NULL),
(409, 21, NULL),
(410, 21, NULL),
(411, 21, NULL),
(412, 21, NULL),
(413, 21, NULL),
(414, 21, NULL),
(415, 21, NULL),
(416, 21, NULL),
(417, 21, NULL),
(418, 21, NULL),
(419, 21, NULL),
(420, 21, NULL),
(421, 21, NULL),
(422, 21, NULL),
(423, 21, NULL),
(424, 21, NULL),
(425, 21, NULL),
(426, 21, NULL),
(427, 21, NULL),
(428, 21, NULL),
(429, 21, NULL),
(430, 21, NULL),
(431, 21, NULL),
(432, 21, NULL),
(433, 21, NULL),
(434, 21, NULL),
(435, 21, NULL),
(436, 21, NULL),
(437, 21, NULL),
(438, 21, NULL),
(439, 21, NULL),
(440, 21, NULL),
(441, 21, NULL),
(442, 21, NULL),
(443, 21, NULL),
(444, 21, NULL),
(445, 21, NULL),
(446, 21, NULL),
(447, 21, NULL),
(448, 21, NULL),
(449, 21, NULL),
(450, 21, NULL),
(451, 21, NULL),
(452, 21, NULL),
(453, 21, NULL),
(454, 21, NULL),
(455, 21, NULL),
(456, 21, NULL),
(457, 21, NULL),
(458, 21, NULL),
(459, 21, NULL),
(460, 21, NULL),
(461, 21, NULL),
(462, 21, NULL),
(463, 21, NULL),
(464, 21, NULL),
(465, 21, NULL),
(466, 21, NULL),
(467, 21, NULL),
(468, 21, NULL),
(469, 21, NULL),
(470, 21, NULL),
(471, 21, NULL),
(472, 21, NULL),
(473, 21, NULL),
(474, 21, NULL),
(475, 21, NULL),
(476, 21, NULL),
(477, 21, NULL),
(478, 21, NULL),
(479, 21, NULL),
(480, 21, NULL),
(481, 21, NULL),
(482, 21, NULL),
(483, 21, NULL),
(484, 21, NULL),
(485, 21, NULL),
(486, 21, NULL),
(487, 21, NULL),
(488, 21, NULL),
(489, 21, NULL),
(490, 21, NULL),
(491, 21, NULL),
(492, 21, NULL),
(493, 21, NULL),
(494, 21, NULL),
(495, 21, NULL),
(496, 21, NULL),
(497, 21, NULL),
(498, 21, NULL),
(499, 21, NULL),
(500, 21, NULL),
(501, 21, NULL),
(502, 21, NULL),
(503, 21, NULL),
(504, 21, NULL),
(505, 21, NULL),
(506, 21, NULL),
(507, 21, NULL),
(508, 21, NULL),
(509, 21, NULL),
(510, 21, NULL),
(511, 21, NULL),
(512, 21, NULL),
(513, 21, NULL),
(514, 21, NULL),
(515, 21, NULL),
(516, 21, NULL),
(517, 21, NULL),
(518, 21, NULL),
(519, 21, NULL),
(520, 21, NULL),
(521, 21, NULL),
(522, 21, NULL),
(523, 21, NULL),
(524, 21, NULL),
(525, 21, NULL),
(526, 21, NULL),
(527, 21, NULL),
(528, 21, NULL),
(529, 21, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `modules_taken`
--

CREATE TABLE `modules_taken` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `module_id` int NOT NULL,
  `status` varchar(200) COLLATE utf8mb4_general_ci DEFAULT 'fail',
  `date_taken` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules_taken`
--

INSERT INTO `modules_taken` (`id`, `user_id`, `module_id`, `status`, `date_taken`) VALUES
(14, 45, 9, 'passed', '2024-10-10'),
(15, 45, 10, 'passed', '2024-10-10'),
(16, 45, 11, 'passed', '2024-10-10'),
(17, 43, 9, 'passed', '2024-10-11'),
(18, 43, 10, 'passed', '2024-10-11'),
(19, 43, 11, 'passed', '2024-10-11'),
(20, 43, 1, 'fail', '2024-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `module_content`
--

CREATE TABLE `module_content` (
  `id` int NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modules_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `module_content`
--

INSERT INTO `module_content` (`id`, `description`, `video`, `file_path`, `modules_id`) VALUES
(1, 'learning correct measurements', 'https://www.youtube.com/watch?v=Qxo2ToDM-uE&list=RDCLAK5uy_kmPRjHDECIcuVwnKsx2Ng7fyNgFKWNJFs&index=9', 'uploads/1.jpg', 1),
(2, 'correct needle and uses', 'https://www.youtube.com/watch?v=WvoAL44J42g', 'uploads/2.jpg', 2),
(3, 'types of dress', 'https://www.youtube.com/watch?v=z-5tJblM-WQ', 'uploads/3.jpg', 3),
(4, 'new', 'https://www.youtube.com/watch?v=ahHiepqCDK8', 'uploads/supply.pdf', 4),
(5, 'how to bake ', 'https://www.youtube.com/watch?v=KTh4kTdj3Kk&list=RDKTh4kTdj3Kk&start_radio=1', 'uploads/download (1).jpeg', 6),
(6, 'how to grill', 'https://www.youtube.com/watch?v=NoZJYcNcbUA', 'uploads/PESO.pdf', 7),
(8, 'Introduction To Digital Marketing', 'https://www.youtube.com/watch?v=ZVuHLPl69mM', 'uploads/diskette.png', 9),
(9, 'Search Engine Optimization (SEO)', 'https://www.youtube.com/watch?v=xsVTqzratPs', 'uploads/diskette.png', 10),
(10, 'FRIED', 'https://www.youtube.com/watch?v=nqwvvmzfWDA', 'uploads/diskette.png', 12),
(11, 'sdfweaf', 'https://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVk', 'uploads/Application-Form.pdf', 18),
(12, 'jack', 'https://www.youtube.com/watch?v=QdJPIylB7TA', 'uploads/Application Form6.pdf', 18),
(13, 'jack', 'https://www.youtube.com/watch?v=QdJPIylB7TA', 'uploads/Application Form6.pdf', 18),
(14, 'jack', 'https://www.youtube.com/watch?v=QdJPIylB7TA', 'uploads/Application Form6.pdf', 16),
(15, 'hahaha', 'https://www.youtube.com/watch?v=kSNOF7vNplM&t=278s', 'uploads/Application Form6.pdf', 18),
(16, 'sdfweaf', 'https://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVk', 'uploads/Application-Form.pdf', 17),
(17, 'jack', 'https://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVk', 'uploads/Application-Form.pdf', 17),
(18, 'Social median marketin strats', 'https://www.youtube.com/watch?v=J_RJY8TuSso', 'uploads/Application-Form.pdf', 11);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int NOT NULL,
  `quiz_id` int DEFAULT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_a` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_b` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_c` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_d` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marks` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `quiz_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `marks`) VALUES
(4, 4, 'what is CM', 'centimeter', 'milimeter', 'inches', 'meter', 'a', 1),
(5, 4, 'Inches ', '1', '2', '3', '4', 'b', 1),
(6, 4, 'Meter', '1', '2', '3', '4', 'd', 1),
(7, 4, 'Color', '1', '2', '3', '4', 'c', 1),
(8, 5, 'what is CM', '1', '2', '3', '4', 'c', 1),
(9, 5, '2', '3', '4', '6', '7', 'b', 1),
(10, 6, 'Which of the following is considered a leavening agent used in baking?', '.Salt', 'Sugar', ' Baking powder', 'Olive oil', 'c', 1),
(11, 6, 'What type of flour is most commonly used for making bread?', 'Cake flour', 'All-purpose flour', 'Bread flour', 'Self-rising flour', 'c', 1),
(12, 6, 'Which ingredient is often used to give baked goods a tender texture?', 'Butter', 'Baking soda', 'Cornstarch', 'Water', 'a', 1),
(13, 6, 'When a recipe calls for creaming, which two ingredients are typically mixed together?', 'Flour and eggs', 'Butter and sugar', 'Milk and flour', 'Eggs and sugar', 'b', 1),
(14, 6, ' What is the primary function of eggs in most baking recipes?', 'To add sweetness', 'To provide structure and stability', 'To act as a thickening agent', 'To enhance flavor', 'b', 1),
(15, 6, 'Which of the following is commonly used as a fat in baking?', 'Sugar', 'Salt', ' Shortening', 'Cornstarch', 'c', 1),
(16, 6, ' What is the purpose of adding salt to baked goods?', 'To increase sweetness', 'To enhance flavor', ' To act as a preservative', 'To provide moisture', 'b', 1),
(17, 6, 'Which sugar is most often used in making meringue? a) Granulated sugar', ' Brown sugar', 'Granulated sugar', ' Confectioners’ sugar', 'Raw sugar', 'b', 1),
(18, 6, 'What is the main purpose of using yeast in bread baking?', 'To add flavor', ' To sweeten the dough', ' To make the dough rise', ' To improve the dough’s texture', 'c', 1),
(19, 6, ' What ingredient is typically used to thicken custards and fillings?', 'Flour', ' Cornstarch', 'Yeast', ' Baking soda', 'b', 1),
(20, 7, ' What is the primary purpose of marinating meat before grilling?', 'To make the meat look better', 'To reduce cooking time', 'To enhance flavor and tenderize the meat', 'To increase the temperature of the grill', 'c', 1),
(21, 7, ' Which of the following is the best oil to use for greasing the grill to prevent sticking?', 'Olive oil', 'Butter', 'Vegetable oil', 'Coconut oil', 'c', 1),
(22, 7, 'What is the ideal internal temperature for grilling a medium-rare steak?', ' 120°F (49°C)', '140°F (60°C)', '130°F (54°C)', '160°F (71°C)', 'c', 1),
(23, 7, 'Which of the following cuts of meat is typically used for grilling?', 'Ribeye', 'Shank', 'Chuck roast', 'Brisket', 'a', 1),
(24, 7, 'What is the correct technique for using indirect heat while grilling?', 'Placing the food directly over the flames', 'Cooking the food with the grill lid open', 'Cooking the food away from the flames with the lid closed', 'Cooking the food with high heat for a short time', 'c', 1),
(25, 7, 'Which type of grill typically provides the most smoky flavor?', 'Electric grill', 'Gas grill', 'Charcoal grill', 'Infrared grill', 'c', 1),
(26, 7, ' What is the best way to check if chicken is fully cooked when grilling?', 'By cutting it open and checking the color', 'By using a meat thermometer to check the internal temperature', 'By feeling its texture', ' By measuring the cooking time', 'b', 1),
(27, 7, 'How often should you flip burgers while grilling?', 'Every 1 minute', ' As often as possible', 'Only once during grilling', 'Every 30 seconds', 'c', 1),
(28, 7, 'What is the best method for preventing vegetables from falling through the grill grates?', ' Use high heat to cook them faster', ' Use a grilling basket or skewers', 'Cut them into large pieces', 'Keep the grill lid open', 'b', 1),
(29, 7, 'Which of the following meats is best suited for quick grilling over high heat?', 'Pork chops', 'Brisket', 'Lamb shank', ' Beef short ribs', 'a', 1),
(30, 8, ' What is the primary purpose of marinating meat before grilling?', 'To make the meat look better', 'To reduce cooking time', 'To enhance flavor and tenderize the meat', 'To increase the temperature of the grill', 'c', 1),
(31, 8, 'Which of the following is the best oil to use for greasing the grill to prevent sticking?', ' Olive oil', 'Butter', 'Vegetable oil', ' Coconut oil', 'c', 1),
(32, 8, 'What is the ideal internal temperature for grilling a medium-rare steak?', '120°F (49°C)', ' 160°F (71°C)', '130°F (54°C)', '140°F (60°C)', 'c', 1),
(33, 8, 'Which of the following cuts of meat is typically used for grilling?', 'Ribeye', 'Shank', 'Chuck roast', 'Brisket', 'a', 1),
(34, 8, 'What is the correct technique for using indirect heat while grilling?', 'Placing the food directly over the flames', 'Cooking the food with the grill lid open', 'Cooking the food away from the flames with the lid closed', 'Cooking the food with high heat for a short time', 'c', 1),
(35, 8, 'Which type of grill typically provides the most smoky flavor?', 'Electric grill', 'Gas grill', 'Charcoal grill', 'Infrared grill', 'c', 1),
(36, 8, 'What is the best way to check if chicken is fully cooked when grilling?', 'By cutting it open and checking the color', ' By using a meat thermometer to check the internal temperature', 'By feeling its texture', ' By measuring the cooking time', 'b', 1),
(37, 8, 'How often should you flip burgers while grilling?', 'Every 1 minute', 'As often as possible', 'Only once during grilling', 'Every 30 seconds', 'c', 1),
(38, 8, 'What is the best method for preventing vegetables from falling through the grill grates?', ' Use high heat to cook them faster', 'Use a grilling basket or skewers', 'Cut them into large pieces', 'Keep the grill lid open', 'b', 1),
(39, 8, ' Which of the following meats is best suited for quick grilling over high heat?', 'Pork chops', ' Brisket', 'Lamb shank', 'Beef short ribs', 'a', 1),
(40, 9, 'Which of the following meats is best suited for quick grilling over high heat?', ' Pork chops', ' Brisket', 'Lamb shank', 'Beef short ribs', 'a', 1),
(41, 9, '. What is the best method for preventing vegetables from falling through the grill grates?', 'Cut them into large pieces', 'Keep the grill lid open', 'Use a grilling basket or skewers', 'Use high heat to cook them faster', 'c', 1),
(42, 9, ' Which type of grill typically provides the most smoky flavor?', 'Electric grill', 'Gas grill', ' Charcoal grill', 'Infrared grill', 'c', 1),
(43, 9, 'How often should you flip burgers while grilling?', 'Every 1 minute', 'As often as possible', 'Only once during grilling', ' Every 30 seconds', 'c', 1),
(44, 9, ' What is the best way to check if chicken is fully cooked when grilling?', 'By cutting it open and checking the color', ' By using a meat thermometer to check the internal temperature', ' By feeling its texture', 'By measuring the cooking time', 'b', 1),
(45, 9, 'What is the correct technique for using indirect heat while grilling?', 'Cooking the food with the grill lid open', 'Placing the food directly over the flames', 'Cooking the food away from the flames with the lid closed', 'Cooking the food with high heat for a short time', 'c', 1),
(46, 9, 'Which of the following cuts of meat is typically used for grilling?', 'Ribeye', 'Shank', 'Chuck roast', 'Brisket', 'a', 1),
(47, 9, 'What is the ideal internal temperature for grilling a medium-rare steak?', ' 120°F (49°C)', ' 140°F (60°C)', ' 130°F (54°C)', ' 160°F (71°C)', 'c', 1),
(48, 9, 'Which of the following is the best oil to use for greasing the grill to prevent sticking?', 'Coconut oil', ') Butter', 'Vegetable oil', 'Olive oil', 'c', 1),
(49, 9, ' What is the primary purpose of marinating meat before grilling?', 'To make the meat look better', 'To reduce cooking time', 'To enhance flavor and tenderize the meat', 'To increase the temperature of the grill', 'c', 1),
(75, 13, 'Which social media platform is most commonly used for professional networking?', 'Facebook', ' Instagram', 'LinkedIn', 'Twitter', 'c', 1),
(76, 13, 'What is the primary goal of a social media strategy?', 'To create viral content', 'To post as much content as possible', 'To align social media efforts with business objectives', ' To focus only on paid campaigns', 'c', 1),
(77, 13, 'Which platform is best known for its image and video-centric content?', 'Twitter', ' Instagram', ' LinkedIn', 'Facebook', 'b', 1),
(78, 13, 'Which of the following is an example of paid social media marketing?', ' Sharing a personal blog post on your profile', 'Responding to customer comments on your page', 'Running a Facebook Ads campaign', 'Posting a story on Instagram', 'c', 1),
(79, 13, 'Which social media platform is most commonly used for professional networking?', 'Facebook', ' Instagram', 'LinkedIn', 'Twitter', 'c', 1),
(80, 13, 'What is the primary goal of a social media strategy?', 'To create viral content', 'To post as much content as possible', 'To align social media efforts with business objectives', ' To focus only on paid campaigns', 'c', 1),
(81, 13, 'Which platform is best known for its image and video-centric content?', 'Twitter', ' Instagram', ' LinkedIn', 'Facebook', 'b', 1),
(82, 13, 'Which of the following is an example of paid social media marketing?', ' Sharing a personal blog post on your profile', 'Responding to customer comments on your page', 'Running a Facebook Ads campaign', 'Posting a story on Instagram', 'c', 1),
(83, 13, 'Which social media platform is most commonly used for professional networking?', 'Facebook', ' Instagram', 'LinkedIn', 'Twitter', 'c', 1),
(84, 13, 'What is the primary goal of a social media strategy?', 'To create viral content', 'To post as much content as possible', 'To align social media efforts with business objectives', ' To focus only on paid campaigns', 'c', 1),
(85, 13, 'Which platform is best known for its image and video-centric content?', 'Twitter', ' Instagram', ' LinkedIn', 'Facebook', 'b', 1),
(86, 13, 'Which of the following is an example of paid social media marketing?', ' Sharing a personal blog post on your profile', 'Responding to customer comments on your page', 'Running a Facebook Ads campaign', 'Posting a story on Instagram', 'c', 1),
(87, 13, 'Which social media platform is most commonly used for professional networking?', 'Facebook', ' Instagram', 'LinkedIn', 'Twitter', 'c', 1),
(88, 13, 'What is the primary goal of a social media strategy?', 'To create viral content', 'To post as much content as possible', 'To align social media efforts with business objectives', ' To focus only on paid campaigns', 'c', 1),
(89, 13, 'Which platform is best known for its image and video-centric content?', 'Twitter', ' Instagram', ' LinkedIn', 'Facebook', 'b', 1),
(90, 13, 'Which of the following is an example of paid social media marketing?', ' Sharing a personal blog post on your profile', 'Responding to customer comments on your page', 'Running a Facebook Ads campaign', 'Posting a story on Instagram', 'c', 1),
(91, 13, 'Which social media platform is most commonly used for professional networking?', 'Facebook', ' Instagram', 'LinkedIn', 'Twitter', 'c', 1),
(92, 13, 'What is the primary goal of a social media strategy?', 'To create viral content', 'To post as much content as possible', 'To align social media efforts with business objectives', ' To focus only on paid campaigns', 'c', 1),
(93, 13, 'Which platform is best known for its image and video-centric content?', 'Twitter', ' Instagram', ' LinkedIn', 'Facebook', 'b', 1),
(94, 13, 'Which of the following is an example of paid social media marketing?', ' Sharing a personal blog post on your profile', 'Responding to customer comments on your page', 'Running a Facebook Ads campaign', 'Posting a story on Instagram', 'c', 1),
(95, 14, ' What is frying?', 'Cooking food in hot oil', ' Cooking food in dry heat', 'Cooking food in water', 'Cooking food in steam', 'a', 1),
(96, 14, 'Which type of frying involves submerging food completely in hot oil?', 'Pan-frying', 'Shallow frying', 'Deep frying', ' Dry frying', 'c', 1),
(97, 14, 'Which oil is commonly used for deep frying due to its high smoke point?', 'Olive oil', 'Coconut oil', 'Sunflower oil', 'Sesame oil', 'd', 1),
(98, 14, 'What temperature range is typically used for deep frying?', ' 100°C - 150°C', ' 150°C - 190°C', '200°C - 250°C', ' 50°C - 100°C', 'b', 1),
(99, 14, ' What is the purpose of breading or battering food before frying?', 'To change the color', ' To make it sweeter', ' To create a crispy coating', 'To soften the food', 'c', 1),
(100, 14, ' What is pan-frying?', 'Frying food without oil', 'Frying food with a small amount of oil', 'Frying food in deep oil', 'Frying food on high heat', 'b', 1),
(101, 14, 'Which of the following is not typically used in frying?', ' Oil', ' Fat', 'Butter', 'Water', 'd', 1),
(102, 14, 'What effect does overcrowding the frying pan have?', ' Makes food fry faster', ' Lowers the oil temperature', ' Increases the oil temperature', 'Cooks food evenly', 'b', 1),
(103, 14, 'What is shallow frying?', 'Submerging food in oil', 'Cooking food in a small amount of oil covering part of the food', 'Cooking food in steam', 'Cooking food in no oil', 'b', 1),
(104, 14, 'Which of the following foods is commonly deep-fried?', ' Bread', 'French fries', 'Fruit salad', ' Salad', 'b', 1),
(105, 14, 'What happens if oil is not hot enough when frying?', 'Food becomes crispy', ' Food absorbs too much oil', 'Food cooks faster', ' Food doesn’t cook at all', 'b', 1),
(106, 14, ' Which frying method is healthier?', 'Air frying', 'Deep frying', 'Shallow frying', 'Pan-frying', 'a', 1),
(107, 14, 'Which utensil is commonly used to remove fried food from oil?', 'Knife', 'Spoon', 'Slotted spoon', 'Fork', 'c', 1),
(108, 14, 'What is the smoke point of oil?', 'The temperature at which oil bubbles', 'The temperature at which oil starts to burn', 'The temperature at which oil cools', 'The temperature at which oil freezes', 'b', 1),
(109, 14, 'What type of oil is often avoided for deep frying due to its low smoke point?', 'Canola oil', ' Extra virgin olive oil', 'Peanut oil', ' Corn oil', 'b', 1),
(110, 14, 'How do you know when oil is ready for frying?', ' It cools down', 'It turns yellow', 'It stops bubbling', 'It begins to shimmer and lightly smoke', 'd', 1),
(111, 14, 'Why is it important to use dry ingredients when frying?', ' To improve taste', 'To prevent food from sticking to the pan', 'To avoid splattering and hot oil popping', 'To fry food faster', 'c', 1),
(112, 14, 'What is the role of a thermometer in frying?', 'To measure food weight', 'To check oil temperature', ') To stir food', 'To cool food down', 'b', 1),
(113, 14, 'What is stir-frying?', ' Frying food submerged in oil', 'Cooking food quickly with a small amount of oil while stirring constantly', 'Cooking food on a grill', 'Cooking food in water', 'b', 1),
(114, 14, 'What is the main difference between pan-frying and sautéing?', 'The type of oil used', 'The amount of oil and the heat applied', 'The type of food cooked', 'The cooking time', 'b', 1),
(115, 14, 'Which food is not usually fried?', 'Cake', 'Chicken', 'Donuts', 'French fries', 'a', 1),
(116, 14, 'What is double frying?', ' Frying food in two different oils', 'Frying the same food twice', 'Frying food, letting it cool, and frying it again for crispiness', 'Frying two foods at once', 'c', 1),
(117, 14, 'What happens when food is fried at too high a temperature?', 'It burns outside and remains raw inside', 'It cooks evenly', 'It absorbs less oil', 'It becomes too tender', 'a', 1),
(118, 14, 'Why is it important to let fried food drain on paper towels?', 'To improve flavor', 'To keep food moist', 'To remove excess oil', 'To add texture', 'c', 1),
(119, 14, ' What is a common sign that frying oil has degraded?', ' It turns clear', ' It produces a lot of smoke and smells burnt', 'It becomes thicker', 'It produces bubbles', 'b', 1),
(120, 14, 'What is tempura frying?', ' Frying in butter', 'Japanese method of frying with a light batter', 'Frying without oil', ' Frying with only flour', 'b', 1),
(121, 14, 'What does the term \"golden brown\" refer to in frying?', ' The oil used', 'The desired color of the food when perfectly fried', 'The name of a frying pan', 'The temperature of the oil', 'b', 1),
(122, 14, 'What’s the best way to keep fried food crispy?', 'Keep it on a wire rack', 'Cover it with foil', 'Store it in a plastic container', 'Let it sit in oil', 'a', 1),
(123, 14, 'Why is it not recommended to reuse oil for multiple frying sessions?', ' It makes the food oily', ' It affects the cooking time', 'It can lead to burnt flavors and unhealthy compounds', 'It increases the smoke point', 'c', 1),
(124, 14, 'Which of the following frying techniques is considered low-fat?', ' Deep frying', 'Pan-frying', 'Air frying', ' Shallow frying', 'c', 1),
(125, 14, 'What is the purpose of adding a pinch of salt to oil before frying?', ' To improve flavor', ' To reduce oil splattering', 'o change the color of oil', ' To increase oil temperature', 'b', 1),
(126, 14, ' What is flash frying?', 'Cooking food with a low temperature', 'Cooking food very quickly at high heat', 'Frying in butter', ' Frying food at a medium temperature', 'b', 1),
(127, 14, 'What should be done before frying frozen food?', 'Fry it immediately', 'Thaw it and dry it completely', 'Heat it in a microwave', 'Add extra oil', 'b', 1),
(128, 14, 'Which of the following is a benefit of frying with peanut oil?', 'It has a low smoke point', ' It has a strong flavor', 'It has a neutral flavor and high smoke point', 'It is not healthy', 'c', 1),
(129, 14, 'What type of frying uses little to no oil?', 'Shallow frying', ' Deep frying', 'Air frying', ' Stir frying', 'c', 1),
(130, 14, 'What is the risk of frying with wet or damp food?', ' It fries faster', ' It doesn’t absorb oil', 'It causes oil splatters and can be dangerous', 'It burns easily', 'c', 1),
(131, 14, 'What type of batter is typically used in tempura frying?', ' A batter made with milk', 'A batter made with yeast', 'A heavy batter made with breadcrumbs', 'A light, airy batter made with flour, water, and egg', 'd', 1),
(132, 14, 'Which oil is least suitable for frying due to its low smoke point?', 'Peanut oil', 'Extra virgin olive oil', 'Vegetable oil', 'Corn oil', 'b', 1),
(133, 14, 'What is the main role of a thermometer in frying?', ' To cook food faster', 'To make oil boil', 'To ensure oil is at the correct temperature', 'To cool the oil', 'c', 1),
(134, 14, 'Why is frying at the right temperature important?', 'To ensure food cooks evenly and doesn’t absorb too much oil', 'o burn the food', 'To cook the food faster', 'To make the food dry', 'a', 1),
(135, 15, 'fhndfrthd', 's', 'd', 'f', 'hg', 'd', 1),
(136, 15, '34f4esefsfdg', 's', 'd', 'f', 'g', 'a', 1),
(137, 15, 'fhndfrthd', 's', 'd', 'f', 'hg', 'd', 1),
(138, 15, '34f4esefsfdg', 's', 'd', 'f', 'g', 'a', 1),
(139, 15, 'fhndfrthd', 's', 'd', 'f', 'hg', 'd', 1),
(140, 15, '34f4esefsfdg', 's', 'd', 'f', 'g', 'a', 1),
(141, 16, 'sdf', 's', 'd', 'f', 'hg', 'd', 1),
(142, 20, 'fhndfrthd', 's', 'qd', 'sdf', 'sd', 'c', 1),
(143, 22, 'fhndfrthd', 's', 'qd', 'f', 'sd', 'c', 1),
(144, 26, 'fhndfrthd', 'sd', 'qd', 'fgd', 'xz', 'c', 1),
(145, 27, 'sadfawef', 's', 'v', 'x', 'z', 'c', 1),
(146, 27, 'sadfawef', 's', 'v', 'x', 'z', 'c', 1),
(147, 28, 'What is the standard measurement for a full bust?', 'Around the chest, just below the bust', 'Around the fullest part of the bust', 'Around the waistline', 'Around the hips', 'b', 1),
(148, 28, 'Where should the waist measurement be taken?', 'At the narrowest part of the waist', 'Around the fullest part of the hips', 'Just below the bust', 'At the level of the belly button', 'a', 1),
(149, 28, 'How do you measure the hip size?', 'Around the narrowest part of the waist', 'Around the fullest part of the hips', 'From the top of the shoulder to the hip', 'From the waist to the ankle', 'b', 1),
(150, 28, 'What is the correct way to measure the length of a dress?', 'From the top of the shoulder to the floor', ' From the waist to the knee', 'From the bust to the knee', 'From the hip to the ankle', 'a', 1),
(151, 28, 'How do you measure the shoulder width?', 'From the top of one shoulder to the other', 'Around the fullest part of the bust', 'From the nape of the neck to the hip', 'From the shoulder to the wrist', 'a', 1),
(152, 29, 'What type of needle is most commonly used for hand sewing?', 'Embroidery needle', 'Tapestry needle', 'Sharps needle', 'Darning needle', 'c', 1),
(153, 29, 'What does the number on a sewing needle indicate?', 'The type of metal used', 'The thickness of the needle', 'The length of the needle', 'The sharpness of the needle point', 'b', 1),
(154, 29, 'Which type of thread is most suitable for sewing heavy fabrics like denim?', 'Cotton thread', 'Silk thread', 'Polyester thread', 'Nylon thread', 'c', 1),
(155, 29, 'What is the main purpose of a ballpoint needle?', 'To sew through thick fabrics', 'To sew knits and stretch fabrics without damaging them', 'To sew delicate fabrics like silk', 'To sew leather and vinyl', 'b', 1),
(156, 29, 'Which needle size is best for sewing fine, delicate fabrics like silk', 'Size 9 or 10', 'Size 18 or 20', 'Size 14 or 16', 'Size 7 or 8', 'a', 1),
(157, 30, 'What type of scissors is best for cutting fabric?', 'Kitchen scissors', 'Dressmaker’s shears', 'Paper scissors', 'Embroidery scissors', 'b', 1),
(158, 30, 'What is the main purpose of pinking shears?', 'To prevent fabric edges from fraying', 'To cut thick fabrics', 'To create decorative edges', 'To make straight cuts', 'a', 1),
(159, 30, 'Which cutting tool is ideal for cutting multiple layers of fabric with precision?', 'Regular scissors', 'Rotary cutter', 'Pinking shears', 'Electric scissorsv', 'b', 1),
(160, 30, 'How should fabric be placed when cutting patterns?', 'On a flat, smooth surface', 'Folded several times', 'Hung on a rack', 'On a bumpy surface', 'a', 1),
(161, 30, 'What is the correct way to hold fabric shears while cutting?', 'Keep the lower blade flat against the table', ' Lift the fabric in the air', 'Use small snips for large cuts', 'Tilt the scissors at a steep angle', 'a', 1),
(162, 31, 'What is the primary purpose of a dressmaking pattern?', 'To decorate the fabric', 'To provide a template for cutting fabric pieces', 'To measure the fabric', 'To store sewing tools', 'b', 1),
(163, 31, 'Which tool is commonly used for creating straight lines when drafting patterns?', 'French curve', 'Ruler', 'Scissors', 'Tape measure', 'b', 1),
(164, 31, 'What does \"ease\" refer to in garment design?', 'The tightness of a garment', 'The amount of fabric needed for seams', 'The extra fabric allowed for movement and comfort', 'The length of the garment', 'c', 1),
(165, 31, 'When drawing a garment layout, what should be included?', 'Only the front view of the garment', 'All views, including front, back, and side ', 'Only fabric swatches', 'Only the measurements of the garment', 'b', 1),
(166, 31, 'Which technique is often used to add flair and movement to a dress design?', 'Gathering', 'Cutting on the fold', 'Creating darts', 'Adding interfacing', 'a', 1),
(172, 37, 'What is the main purpose of Search Engine Optimization (SEO)?', 'To create social media posts', 'To improve a websites ranking on search engines', 'To increase email subscribers', 'To design a website layout', 'b', 1),
(173, 37, 'Which of the following is a key component of content marketing?', 'Creating infographics for offline marketing', 'Developing valuable and relevant content to attract an audience', 'Sending cold emails', 'Paying for banner ads', 'b', 1),
(174, 37, 'What does \"PPC\" stand for in digital marketing?', 'Personal Paid Campaigns', 'Pay-Per-Click', 'Public Posting Content', 'Paid Promotional Content', 'b', 1),
(175, 37, 'Which digital marketing platform is most commonly used for professional networking and B2B marketing?', 'Instagram', 'LinkedIn', 'Snapchat', 'TikTok', 'b', 1),
(176, 37, 'What is the main goal of social media marketing?', 'To sell physical products directly', 'To engage with the audience and build brand awareness', 'To make videos go viral', 'To increase website bounce rates', 'b', 1),
(177, 38, 'What does SEO stand for?', 'Social Engagement Optimization', 'Search Engine Optimization', 'Site Enhancement Operations', 'Search Efficiency Optimization', 'b', 1),
(178, 38, 'What does SEO stand for?', 'Social Engagement Optimization', 'Search Engine Optimization', 'Site Enhancement Operations', 'Search Efficiency Optimization', 'b', 1),
(179, 38, 'What does SEO stand for?', 'Social Engagement Optimization', 'Search Engine Optimization', 'Site Enhancement Operations', 'Search Efficiency Optimization', 'b', 1),
(180, 38, 'Which factor is most important for improving a website\'s SEO ranking?', 'Increasing website color variety', 'High-quality, relevant content', 'Paying for ads', 'Using a large number of images', 'b', 1),
(181, 38, 'What is a \"keyword\" in SEO?', 'A word or phrase that users search for in search engines', 'A type of website plugin', 'A tag used in HTML coding', 'A special offer code for marketing', 'a', 1),
(182, 38, 'Which SEO technique involves acquiring backlinks from other websites?', 'On-page SEO', 'Keyword stuffing', 'Off-page SEO', 'Page speed optimization', 'c', 1),
(183, 38, 'What is the purpose of meta descriptions in SEO?', 'To rank higher in paid search results', 'To provide alt text for images', 'To provide a brief summary of the page content in search results', 'To display large amounts of text on a website', 'c', 1),
(184, 39, 'What is the primary goal of social media marketing?', 'To create print advertisements', 'To engage with the audience and build brand awareness', 'To sell products directly through social media', 'To increase email subscribers', 'b', 1),
(185, 39, 'Which social media platform is most commonly used for visual content and influencer marketing?', 'LinkedIn', 'Instagram', 'Twitter', 'Pinterest', 'b', 1),
(186, 39, 'What is the purpose of using hashtags in social media posts?', 'To increase the character count', 'To categorize content and increase visibility', 'To confuse the audience', 'To promote paid advertisements', 'b', 1),
(187, 39, 'What is an important metric to measure the success of social media campaigns?', 'The number of followers only', 'Engagement rate, including likes, shares, and comments', 'The number of posts published', 'The number of ads run', 'b', 1),
(188, 39, 'Which type of content tends to perform best on social media platforms?', 'Long, detailed articles', 'Short, visually appealing posts such as images and videos ', 'Only text-based updates', 'Complicated infographics', 'b', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_name`
--

CREATE TABLE `quiz_name` (
  `id` int NOT NULL,
  `module_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_ans` int DEFAULT NULL,
  `wrong_ans` int DEFAULT NULL,
  `total` int DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quiz_name`
--

INSERT INTO `quiz_name` (`id`, `module_id`, `title`, `correct_ans`, `wrong_ans`, `total`, `tag`, `date`) VALUES
(5, 4, 'New', 1, 1, 2, 'how to measure ', '2024-09-02 15:04:41'),
(6, 6, 'Ingredients Of Baking', 1, 0, 10, 'Quiz/Exam', '2024-09-26 16:01:35'),
(9, 7, 'Grill', 1, 0, 10, 'How to Grill', '2024-09-26 12:29:00'),
(14, 12, 'How To Fry', 1, 0, 40, 'QUIZ', '2024-09-26 16:03:36'),
(15, 0, 'Randomm', 1, 1, 2, 'sdfasfwe', '2024-10-01 09:31:21'),
(16, 0, 'Randomm', 1, 1, 1, 'szfasd', '2024-10-01 09:42:24'),
(17, 0, 'Meyekop757', 1, 1, 1, '32zcxf', '2024-10-01 09:43:24'),
(18, 0, 'Meyekop757', 1, 1, 1, '32zcxf', '2024-10-01 09:44:13'),
(19, 0, 'Meyekop757', 1, 1, 1, '32zcxf', '2024-10-01 09:46:22'),
(20, 0, 'Meyekop757', 1, 1, 1, '32zcxf', '2024-10-01 09:48:51'),
(21, 0, 'Randomm', 1, 1, 1, 'sdfscx ', '2024-10-01 09:50:20'),
(22, 0, 'Nezuko', 1, 1, 1, 'sdfw', '2024-10-01 09:55:06'),
(23, 0, 'Nezuko', 1, 1, 1, 'sdfw', '2024-10-01 09:58:44'),
(24, 0, 'Nezuko', 1, 1, 1, 'sdfw', '2024-10-01 09:58:50'),
(25, 0, 'Meyokop', 2, 2, 1, 'sdaf', '2024-10-01 09:59:30'),
(26, 4, 'Nezuko', 2, 2, 1, 'sadfasdfawhgfsdgdrt', '2024-10-01 13:44:11'),
(27, 5, 'Nezuko', 1, 1, 1, 'sdfasdvczxc vzdfvvzsdf', '2024-10-01 13:46:51'),
(28, 1, 'How To Take Measurements', 2, 2, 7, 'accurate measurement will make dress fit perfectly', '2024-10-10 19:16:40'),
(29, 2, 'Learning Needle And Thread', 2, 2, 5, 'sewing', '2024-10-05 19:18:47'),
(30, 3, 'Cutting Dress', 2, 2, 5, 'Cutting smoothly ', '2024-10-05 19:27:23'),
(31, 16, 'Layouts For Dressmaking', 2, 2, 5, 'designing perfect fit', '2024-10-05 19:37:33'),
(37, 9, 'Introduction', 2, 2, 5, 'getting started with digital maketing', '2024-10-06 15:23:44'),
(38, 10, 'Search Engine Optimization (seo)', 2, 2, 5, ' (SEO)', '2024-10-06 15:30:14'),
(39, 11, 'Social Media Marketing', 2, 2, 5, '5 questions about Social Media Marketing', '2024-10-10 19:23:53');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `otp` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL,
  `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`id`, `email`, `username`, `password`, `is_verified`, `otp`, `otp_expiry`, `reset_token`, `reset_token_expiry`) VALUES
(43, 'mercadomarklawrence55@gmail.com', 'Mark55', '$2y$10$hOzr8CnHcqsbz8AUmYa62eSxITdZTZWZW26jnhFremy1KfApEbtY2', 1, '755668', '2024-10-10 12:19:31', NULL, NULL),
(44, 'ict1mercado.cdlb@gmail.com', 'Ict1', '$2y$10$dw2KZgMQI0DhNNh5iMPyveUa1y4I2itlra5GB56qW2gdoCE4JxZ.i', 1, '351097', '2024-10-10 12:23:51', NULL, NULL),
(45, 'marklawrencemercado8@gmail.com', 'Batbat', '$2y$10$.V.hAcf04TXC9RjQ4m8wQepu3c.B3SyapjnECl0tjOV8w89s4G32G', 1, '440801', '2024-10-10 12:26:17', NULL, NULL),
(46, 'batbattmercado@gmail.com', 'Rhave', '$2y$10$HvsxRxY4xJu1vSqIVb8SGu0/iqW89pjBDcK0.SfsionuWD1QnN7YO', 1, '178237', '2024-10-10 12:29:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_form`
--

CREATE TABLE `survey_form` (
  `id` int NOT NULL,
  `question` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey_reponse`
--

CREATE TABLE `survey_reponse` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `survey_id` int DEFAULT NULL,
  `reponse` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `quiz_id` int DEFAULT NULL,
  `answer` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `question_id`, `quiz_id`, `answer`) VALUES
(438, 14, 120, 14, ''),
(439, 14, 121, 14, 'a'),
(440, 14, 122, 14, 'a'),
(441, 14, 123, 14, 'a'),
(442, 14, 124, 14, ''),
(443, 14, 125, 14, ''),
(444, 14, 126, 14, 'a'),
(445, 14, 127, 14, ''),
(446, 14, 128, 14, 'a'),
(447, 14, 129, 14, 'a'),
(448, 14, 130, 14, ''),
(449, 14, 131, 14, 'a'),
(450, 14, 132, 14, ''),
(451, 14, 133, 14, ''),
(452, 14, 134, 14, 'a'),
(453, 14, 50, 10, 'a'),
(454, 14, 51, 10, 'c'),
(455, 14, 52, 10, 'c'),
(456, 14, 53, 10, 'a'),
(457, 14, 54, 10, 'd'),
(458, 14, 8, 5, 'b'),
(459, 14, 9, 5, 'c'),
(470, 14, 10, 6, 'c'),
(471, 14, 11, 6, 'c'),
(472, 14, 12, 6, 'a'),
(473, 14, 13, 6, 'b'),
(474, 14, 14, 6, 'b'),
(475, 14, 15, 6, 'b'),
(476, 14, 16, 6, 'b'),
(477, 14, 17, 6, 'b'),
(478, 14, 18, 6, 'b'),
(479, 14, 19, 6, 'c'),
(480, 28, 55, 11, 'a'),
(481, 28, 56, 11, 'a'),
(482, 28, 57, 11, 'b'),
(483, 28, 58, 11, 'a'),
(484, 28, 59, 11, 'a'),
(495, 28, 157, 30, 'a'),
(496, 28, 158, 30, 'a'),
(497, 28, 159, 30, 'b'),
(498, 28, 160, 30, 'b'),
(499, 28, 161, 30, 'a'),
(515, 28, 162, 31, 'b'),
(516, 28, 163, 31, 'b'),
(517, 28, 164, 31, 'c'),
(518, 28, 165, 31, 'b'),
(519, 28, 166, 31, 'a'),
(525, 28, 147, 28, 'b'),
(526, 28, 148, 28, 'a'),
(527, 28, 149, 28, 'b'),
(528, 28, 150, 28, 'a'),
(529, 28, 151, 28, 'a'),
(535, 27, 147, 28, 'b'),
(536, 27, 148, 28, 'a'),
(537, 27, 149, 28, 'b'),
(538, 27, 150, 28, 'a'),
(539, 27, 151, 28, 'a'),
(545, 28, 152, 29, 'c'),
(546, 28, 153, 29, 'b'),
(547, 28, 154, 29, 'b'),
(548, 28, 155, 29, 'a'),
(549, 28, 156, 29, 'b'),
(565, 27, 152, 29, 'c'),
(566, 27, 153, 29, 'b'),
(567, 27, 154, 29, 'c'),
(568, 27, 155, 29, 'b'),
(569, 27, 156, 29, 'a'),
(570, 27, 157, 30, 'b'),
(571, 27, 158, 30, 'b'),
(572, 27, 159, 30, 'b'),
(573, 27, 160, 30, 'a'),
(574, 27, 161, 30, 'b'),
(580, 27, 162, 31, 'b'),
(581, 27, 163, 31, 'b'),
(582, 27, 164, 31, 'c'),
(583, 27, 165, 31, 'b'),
(584, 27, 166, 31, 'b'),
(585, 27, 172, 37, 'b'),
(586, 27, 173, 37, 'b'),
(587, 27, 174, 37, 'b'),
(588, 27, 175, 37, 'b'),
(589, 27, 176, 37, 'b'),
(590, 27, 177, 38, 'a'),
(591, 27, 178, 38, 'c'),
(592, 27, 179, 38, 'b'),
(593, 27, 180, 38, 'b'),
(594, 27, 181, 38, 'b'),
(595, 27, 182, 38, 'b'),
(596, 27, 183, 38, 'c'),
(597, 45, 172, 37, 'b'),
(598, 45, 173, 37, 'b'),
(599, 45, 174, 37, 'b'),
(600, 45, 175, 37, 'b'),
(601, 45, 176, 37, 'b'),
(602, 45, 177, 38, 'b'),
(603, 45, 178, 38, 'b'),
(604, 45, 179, 38, 'b'),
(605, 45, 180, 38, 'b'),
(606, 45, 181, 38, 'a'),
(607, 45, 182, 38, 'a'),
(608, 45, 183, 38, 'c'),
(609, 45, 184, 39, 'b'),
(610, 45, 185, 39, 'b'),
(611, 45, 186, 39, 'b'),
(612, 45, 187, 39, 'b'),
(613, 45, 188, 39, 'b'),
(614, 43, 172, 37, 'b'),
(615, 43, 173, 37, 'b'),
(616, 43, 174, 37, 'b'),
(617, 43, 175, 37, 'b'),
(618, 43, 176, 37, 'b'),
(619, 43, 177, 38, 'b'),
(620, 43, 178, 38, 'b'),
(621, 43, 179, 38, 'b'),
(622, 43, 180, 38, 'b'),
(623, 43, 181, 38, 'a'),
(624, 43, 182, 38, 'a'),
(625, 43, 183, 38, 'a'),
(626, 43, 184, 39, 'b'),
(627, 43, 185, 39, 'b'),
(628, 43, 186, 39, 'b'),
(629, 43, 187, 39, 'b'),
(630, 43, 188, 39, 'b'),
(651, 43, 147, 28, 'b'),
(652, 43, 148, 28, 'b'),
(653, 43, 149, 28, 'b'),
(654, 43, 150, 28, 'b'),
(655, 43, 151, 28, 'b');

-- --------------------------------------------------------

--
-- Table structure for table `user_score`
--

CREATE TABLE `user_score` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `quiz_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `correct_answers` int DEFAULT NULL,
  `wrong_answers` int DEFAULT NULL,
  `dates` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_score`
--

INSERT INTO `user_score` (`id`, `user_id`, `quiz_id`, `score`, `correct_answers`, `wrong_answers`, `dates`) VALUES
(69, 45, 37, 5, 5, 0, '2024-10-09 16:00:00'),
(70, 45, 38, 6, 6, 1, '2024-10-09 16:00:00'),
(71, 45, 39, 5, 5, 0, '2024-10-09 16:00:00'),
(72, 43, 37, 5, 5, 0, '2024-10-10 16:00:00'),
(73, 43, 38, 5, 5, 2, '2024-10-10 16:00:00'),
(74, 43, 39, 5, 5, 0, '2024-10-10 16:00:00'),
(79, 43, 28, 2, 2, 3, '2024-10-11 16:00:00');

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
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `register`
--
ALTER TABLE `register`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_profile`
--
ALTER TABLE `admin_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employer_profile`
--
ALTER TABLE `employer_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `empyers`
--
ALTER TABLE `empyers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `j_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=530;

--
-- AUTO_INCREMENT for table `modules_taken`
--
ALTER TABLE `modules_taken`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `module_content`
--
ALTER TABLE `module_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;

--
-- AUTO_INCREMENT for table `quiz_name`
--
ALTER TABLE `quiz_name`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `survey_form`
--
ALTER TABLE `survey_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `survey_reponse`
--
ALTER TABLE `survey_reponse`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=656;

--
-- AUTO_INCREMENT for table `user_score`
--
ALTER TABLE `user_score`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
