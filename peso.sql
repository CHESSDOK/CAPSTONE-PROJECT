-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2024 at 04:08 AM
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
  `admin_level` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_profile`
--

INSERT INTO `admin_profile` (`id`, `username`, `password`, `email`, `admin_level`) VALUES
(1, 'Admin', '$2y$10$szZWza9fsLiGXs4evidE7.uc3zwFoQjs/hfwGvw2Vd6lddYLzBuTW', 'mercadomarklawrence55@gmail.com', 'super_admin'),
(2, 'jervin123', '$2y$10$bs.kIy4YfXaiSviKhSgXLeis9MBQHvqUMP0PV0pzCGuKxQSNqvqCG', 'jervinguevarra123@gmail.com', NULL),
(3, 'jerving123', '$2y$10$AvSxZd27fLrwIIFprAJC1eYvMEiZ9zZdW689Uvta6pXcVZQEIl4T6', 'jervinguevarra123@gmail.com', NULL),
(4, 'Jima', '$2y$10$DeLy5nNImdzDJT8Q61F8/.2MVCNj9M4lKU2b1H5ONAnUXyocPD/4S', 'bernabegiemer@gmail.com', NULL),
(5, 'Jima', '$2y$10$x4lMG.vRA1QvU/Hrjg8ire.u5EcgHXwP2UqdQz2R/w9PONLwBcBuK', 'bernabegiemer@gmail.com', NULL),
(6, 'Azure', '$2y$10$lZyxZFyzc9pIxdNESm9pI.Aaxa80D.zxkls7LcqEl3RCgiRDhsbqu', 'ict1mercado.cdlb@gmail.com', NULL),
(7, 'Mark', '$2y$10$ZODJ37OaJ8a8Eaj6A5v9vuIqCsIQ3HXZop.1V2HX8IvD6aeOwIMG2', 'ict1mercado.cdlb@gmail.com', NULL),
(8, 'Azure123', '$2y$10$hrWjfunJ0GOVP4yVTSizSuRcNEZiLFuHwdSgUPMOINDzAalwgkEky', 'mercadomarklawrence55@gmail.com', NULL),
(9, 'Azure123', '$2y$10$AzcQso28OxN7m/XpNJOEpOGRijxAY.LCvsN84QRRkSDAgt/smlA5O', 'ict1mercado.cdlb@gmail.com', NULL);

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
  `age` int DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sex` enum('male','female') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `civil_status` enum('Single','Married','Widowed') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_no` int DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'user.png',
  `house_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `prefix` enum('Sr.','Jr.','II','III','IV','V','VI','VII') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `emergency_contact_num` int DEFAULT NULL,
  `income` int DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employment_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employment_form` enum('Recruitment Agency','Government Hire','Name Hire','Referral') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `employer_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact_number` int DEFAULT NULL,
  `employer_address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `local_agency_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `local_agency_address` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `dept_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(19, 'Wood works', 'Sculpting, chair, cabinet making', 4);

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

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `j_id` int NOT NULL,
  `employer_id` int DEFAULT NULL,
  `admin_id` int DEFAULT NULL,
  `job_title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `job_postings` (`j_id`, `employer_id`, `admin_id`, `job_title`, `job_description`, `specialization`, `vacant`, `requirment`, `work_location`, `remarks`, `date_posted`, `is_active`) VALUES
(11, NULL, 1, 'Carpenter', 'Wood crafting and stuff', '', 12, 'Has experience on woodsman ship', 'Bayog', '', '2024-10-08', 1),
(13, NULL, 1, 'Security Guard', 'Mall Security Guard', '', 2, 'Security Guard License, can work on night shift', 'Olivares plaza, Los Banos', '', '2024-10-08', 1),
(15, NULL, 1, 'Housewife', 'care giver', '', 12, 'Girl with big boob daw sabi ni jervin', 'Sta. Cruz Laguna', '', '2024-10-08', 1),
(16, NULL, 1, 'Warehouse man', 'Heavy work labor', '', 12, 'High graduate', 'Sta. Cruz Laguna', '', '2024-10-08', 1);

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
(37, 20, NULL);

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
(17, 'jack', 'https://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVkhttps://www.youtube.com/watch?v=NfTvrL99dVk', 'uploads/Application-Form.pdf', 17);

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
(183, 38, 'What is the purpose of meta descriptions in SEO?', 'To rank higher in paid search results', 'To provide alt text for images', 'To provide a brief summary of the page content in search results', 'To display large amounts of text on a website', 'c', 1);

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
(28, 1, 'How To Take Measurements', 2, 2, 7, 'accurate measurement will make dress fit perfectly', '2024-10-07 16:11:28'),
(29, 2, 'Learning Needle And Thread', 2, 2, 5, 'sewing', '2024-10-05 19:18:47'),
(30, 3, 'Cutting Dress', 2, 2, 5, 'Cutting smoothly ', '2024-10-05 19:27:23'),
(31, 16, 'Layouts For Dressmaking', 2, 2, 5, 'designing perfect fit', '2024-10-05 19:37:33'),
(37, 9, 'Introduction', 2, 2, 5, 'getting started with digital maketing', '2024-10-06 15:23:44'),
(38, 10, 'Search Engine Optimization (seo)', 2, 2, 5, ' (SEO)', '2024-10-06 15:30:14');

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
(596, 27, 183, 38, 'c');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `employer_documents`
--
ALTER TABLE `employer_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `employer_profile`
--
ALTER TABLE `employer_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `empyers`
--
ALTER TABLE `empyers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `interview`
--
ALTER TABLE `interview`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `j_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `modules_taken`
--
ALTER TABLE `modules_taken`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `module_content`
--
ALTER TABLE `module_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `quiz_name`
--
ALTER TABLE `quiz_name`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=597;

--
-- AUTO_INCREMENT for table `user_score`
--
ALTER TABLE `user_score`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
