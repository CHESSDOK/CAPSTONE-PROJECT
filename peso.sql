-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2024 at 02:12 PM
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
  `school_name1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_grad1` date DEFAULT NULL,
  `award1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `school_name2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_grad2` date DEFAULT NULL,
  `award2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `school_name3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `course3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_grad3` date DEFAULT NULL,
  `award3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_level3` date DEFAULT NULL,
  `school_name4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `course4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_grad4` date DEFAULT NULL,
  `award4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `level4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `year_level4` date DEFAULT NULL,
  `preferred_occupation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pwl` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `overseas_loc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `local_loc` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `occupation` enum('Administrative Work','Medical Work','Factory/Manufacturing','Farmers (Agriculture)','Teaching','Information Technology','Engineering','Restaurant Jobs (F&B)','Seaman (Sea-Based)','Household Service Worker (Domestic Helper)','Construction Work','Entertainment','Tourism Sector','Hospitality Sector','Others') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pwd` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pwd2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prefix` enum('Sr.','Jr.','II','III','IV','V','VI','VII') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `four_ps` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hhid` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `selected_options` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
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
  `es_status` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `es_others` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `actively_looking` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `al_details` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `willing_to_work` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ww_details` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `passport_expiry` date DEFAULT NULL,
  `expected_salary` int DEFAULT NULL,
  `resume` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicant_profile`
--

INSERT INTO `applicant_profile` (`id`, `user_id`, `email`, `first_name`, `last_name`, `middle_name`, `dob`, `pob`, `age`, `height`, `sex`, `civil_status`, `contact_no`, `landline`, `photo`, `house_address`, `tin`, `sss_no`, `pagibig_no`, `philhealth_no`, `passport_no`, `immigration_status`, `spouse_name`, `spouse_contact`, `fathers_name`, `fathers_address`, `mothers_name`, `mothers_address`, `emergency_contact_name`, `next_of_kin_relationship`, `next_of_kin_contact`, `education_level`, `school_name1`, `year_grad1`, `award1`, `school_name2`, `year_grad2`, `award2`, `school_name3`, `course3`, `year_grad3`, `award3`, `level3`, `year_level3`, `school_name4`, `course4`, `year_grad4`, `award4`, `level4`, `year_level4`, `preferred_occupation`, `pwl`, `overseas_loc`, `local_loc`, `occupation`, `pwd`, `pwd2`, `prefix`, `four_ps`, `hhid`, `selected_options`, `emergency_contact_num`, `income`, `country`, `religion`, `employment_type`, `employment_form`, `employer_name`, `contact_number`, `employer_address`, `local_agency_name`, `local_agency_address`, `arrival_date`, `dept_date`, `employment_status`, `es_status`, `es_others`, `actively_looking`, `al_details`, `willing_to_work`, `ww_details`, `passport_expiry`, `expected_salary`, `resume`) VALUES
(26, 43, 'fyxasikyd@mailinator.com', 'Todd', 'Mcclure', 'Brock Shields', '2019-08-10', 'Dicta assumenda prov', 10, '12', 'male', 'Married', '+1 (969) 381-4238', '+1 (202) 414-8913', 'woman.png', 'Voluptates voluptas ', 'Eveniet ipsum proid', 'Ex cupidatat in reru', 'Aut sint rerum labor', '4322', '190', 'Repatriated', 'Kelly Saunders', '36', 'Brent Norris', 'Eaque velit ut quisq', 'Nissim Yang', 'Et molestias asperna', 'Holly Mcgowan', 'Minima incididunt au', '80', 'Elementary Graduate', 'Dannie Kozey', '2024-10-24', 'Dolores', 'Easton Skiles', '2024-10-30', 'Error labore eveniet repudiandae vero nam harum enim animi.', 'Elias Torp', 'Dignissimos suscipit dolore eaque nisi libero.', '2024-09-30', 'Doloremque necessitatibus cumque distinctio voluptatum.', '', '2024-10-26', 'Keagan DuBuque', 'Ipsum sapiente impedit sapiente vel iure laboriosam optio minus.', '2024-11-08', 'Itaque corrupti velit quisquam.', '423', '2024-11-08', 'District Security Coordinator,Forward Division Agent,Chief Identity Developer,Senior Markets Assistant', 'local', '', 'c2,c1,c3', 'Restaurant Jobs (F&B)', 'Others', 'one leg', 'VII', 'Yes', '12432', 'Electrician,Embroidery,Driver,Domestic Chores,Tailoring,Stenography', 63, 768, 'Aliquam id placeat ', 'Incididunt ratione i', 'Sea-Based', 'Referral', 'Gould and Harper Trading', 365, 'Bryan and Hunt Associates', 'Sheila Sullivan', 'Consequatur consect', '1984-08-11', '2012-02-15', 'employed', '', '', 'Yes', 'truy1', 'No', 'after 3 months', '2024-11-09', 12432, 'Performance-Task-2-Part-1_ITEP-413.pdf'),
(27, 44, 'raqitym@mailinator.com', 'Dillon', 'Henderson', 'Quon Mcdaniel', '1992-08-29', '', 87, NULL, 'male', 'Widowed', '5889', NULL, '6707dba238f33.png', 'Sunt et quo volupta', NULL, '0', '0', '0', '16', 'Documented', 'Jamal Carr', '62', 'Riley Atkinson', 'Et odit deserunt min', 'Reuben Shields', 'Eu et culpa aut labo', 'Lawrence Campos', 'Ea eos dolorem cons', '3', 'Elementary Graduate', '0', NULL, '0', '0', NULL, '0', '0', NULL, NULL, '0', NULL, NULL, '0', NULL, NULL, '0', '0', NULL, NULL, NULL, NULL, NULL, 'Others', NULL, '', 'V', NULL, NULL, NULL, 69, 124, 'Odit non qui delenit', NULL, 'Sea-Based', 'Name Hire', 'Cotton Strickland Trading', 499, 'Mejia and Johns Trading', 'Halla Mckay', 'Dolorum asperiores i', '2009-08-10', '2010-11-11', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 45, 'your.email+fakedata40179@gmail.com', 'Carmine', 'Halvorson', 'Maxwell Kshlerin', '2024-08-18', '9017 Ressie Crescent', 69, '35', 'female', 'Widowed', '461-316-4958', '369-441-3564', '456338803_483159741228069_3311839368960614240_n.jpg', '78105 Darby Plaza', 'Blanditiis nam explicabo voluptatum sed ipsam cumque.', '556', '580', '342423', '9', 'Undocumented', 'Lysandra Wilkerson', '2', 'Judah Levy', 'Ab veritatis cum nul', 'Morgan Oconnor', 'Officiis ea sunt aut', 'Imani Russell', 'Nostrud id repudiand', '600', 'Elementary Undergraduate', '0', NULL, '0', '0', NULL, '0', '0', NULL, NULL, '0', NULL, NULL, '0', NULL, NULL, '0', '0', NULL, NULL, NULL, NULL, NULL, 'Others', 'Hearing', '', 'V', 'Yes', NULL, 'Tailoring,Sewing,Painter/Artist,Masonry,new1,new2', 60, 432, 'Adipisci reiciendis ', 'Fuga reprehenderit architecto occaecati vel accusantium pariatur.', 'Land-Based', 'Referral', 'Jackson Battle Traders', 435, 'Hampton and Marks Associates', 'Shannon Irwin', 'Doloribus aut conseq', '2017-05-02', '1974-05-19', 'employed', NULL, NULL, 'Yes', NULL, 'No', NULL, '2025-01-18', 12432, ''),
(29, 46, 'your.email+fakedata92204@gmail.com', 'Coty', 'Ebert', 'Rahsaan Greenholt', '2024-01-05', '300 Dietrich Valleys', 16, '123', 'female', 'Single', '829-082-9515', '5056', '457146626_1974469039642222_919670330705078606_n.jpg', '7419 Keaton Forks', 'Praesentium est accusamus ratione sunt.', '529', '44', '123', '492', 'Returning', 'Sophia Holcomb', '42', 'Keiko Buck', 'Quia sunt non esse a', 'Cheryl Mccarty', 'Quaerat fugiat enim ', 'William Castillo', 'Consequatur tenetur', '411', 'College Graduate', '0', NULL, '0', '0', NULL, '0', '0', NULL, NULL, '0', NULL, NULL, '0', NULL, NULL, '0', '0', NULL, NULL, NULL, NULL, NULL, 'Information Technology', 'Hearing', '', 'Jr.', 'No', NULL, 'Beautician,Auto Mechanic,Carpentry Work', 95, 336, 'Et obcaecati soluta ', 'Nisi perferendis illum voluptatem incidunt illo velit nam consequatur.', 'Sea-Based', 'Government Hire', 'Garrison Deleon Plc', 291, 'Mcdaniel and Jacobson Trading', 'Blair Stokes', 'Ratione sed sit aut ', '2003-03-31', '2000-05-04', 'employed', NULL, NULL, 'No', NULL, 'No', NULL, '2025-07-17', 2233321, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_profile`
--
ALTER TABLE `applicant_profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
