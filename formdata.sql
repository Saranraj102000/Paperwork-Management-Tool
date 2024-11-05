-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 06:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `formdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `paperworkdetails`
--

CREATE TABLE `paperworkdetails` (
  `id` int(11) NOT NULL,
  `cfirstname` varchar(100) DEFAULT NULL,
  `clastname` varchar(100) DEFAULT NULL,
  `ceipalid` varchar(100) DEFAULT NULL,
  `clinkedinurl` varchar(255) DEFAULT NULL,
  `cdob` date DEFAULT NULL,
  `cmobilenumber` varchar(15) DEFAULT NULL,
  `cemail` varchar(255) DEFAULT NULL,
  `clocation` varchar(255) DEFAULT NULL,
  `chomeaddress` varchar(255) DEFAULT NULL,
  `cssn` varchar(4) DEFAULT NULL,
  `cwork_authorization_status` varchar(50) DEFAULT NULL,
  `cv_validate_status` varchar(50) DEFAULT NULL,
  `ccertifications` varchar(255) DEFAULT NULL,
  `coverall_experience` varchar(50) DEFAULT NULL,
  `crecent_job_title` varchar(100) DEFAULT NULL,
  `ccandidate_source` varchar(50) DEFAULT NULL,
  `cresume_attached` varchar(3) DEFAULT NULL,
  `cphoto_id_attached` varchar(3) DEFAULT NULL,
  `cwa_attached` varchar(3) DEFAULT NULL,
  `cany_other_specify` varchar(255) DEFAULT NULL,
  `employer_own_corporation` varchar(3) DEFAULT NULL,
  `employer_corporation_name` varchar(100) DEFAULT NULL,
  `fed_id_number` varchar(100) DEFAULT NULL,
  `contact_person_name` varchar(100) DEFAULT NULL,
  `contact_person_designation` varchar(100) DEFAULT NULL,
  `contact_person_address` varchar(255) DEFAULT NULL,
  `contact_person_phone_number` varchar(15) DEFAULT NULL,
  `contact_person_extension_number` varchar(15) DEFAULT NULL,
  `contact_person_email_id` varchar(255) DEFAULT NULL,
  `benchsale_recruiter_name` varchar(100) DEFAULT NULL,
  `benchsale_recruiter_phone_number` varchar(15) DEFAULT NULL,
  `benchsale_recruiter_extension_number` varchar(15) DEFAULT NULL,
  `benchsale_recruiter_email_id` varchar(255) DEFAULT NULL,
  `website_link` varchar(255) DEFAULT NULL,
  `employer_linkedin_url` varchar(255) DEFAULT NULL,
  `employer_type` varchar(100) DEFAULT NULL,
  `employer_corporation_name1` varchar(100) DEFAULT NULL,
  `fed_id_number1` varchar(100) DEFAULT NULL,
  `contact_person_name1` varchar(100) DEFAULT NULL,
  `contact_person_designation1` varchar(100) DEFAULT NULL,
  `contact_person_address1` varchar(100) DEFAULT NULL,
  `contact_person_phone_number1` varchar(100) DEFAULT NULL,
  `contact_person_extension_number1` varchar(100) DEFAULT NULL,
  `contact_person_email_id1` varchar(100) DEFAULT NULL,
  `collaboration_collaborate` varchar(3) DEFAULT NULL,
  `delivery_manager` varchar(100) DEFAULT NULL,
  `delivery_account_lead` varchar(100) DEFAULT NULL,
  `team_lead` varchar(100) DEFAULT NULL,
  `associate_team_lead` varchar(100) DEFAULT NULL,
  `business_unit` varchar(100) DEFAULT NULL,
  `client_account_lead` varchar(100) DEFAULT NULL,
  `associate_director_delivery` varchar(100) DEFAULT NULL,
  `delivery_manager1` varchar(100) DEFAULT NULL,
  `delivery_account_lead1` varchar(100) DEFAULT NULL,
  `team_lead1` varchar(100) DEFAULT NULL,
  `associate_team_lead1` varchar(100) DEFAULT NULL,
  `recruiter_name` varchar(100) DEFAULT NULL,
  `recruiter_employee_id` varchar(15) DEFAULT NULL,
  `pt_support` varchar(100) DEFAULT NULL,
  `pt_ownership` varchar(100) DEFAULT NULL,
  `coe_non_coe` varchar(10) DEFAULT NULL,
  `geo` varchar(100) DEFAULT NULL,
  `entity` varchar(100) DEFAULT NULL,
  `client` varchar(100) DEFAULT NULL,
  `client_manager` varchar(100) DEFAULT NULL,
  `client_manager_email_id` varchar(255) DEFAULT NULL,
  `end_client` varchar(100) DEFAULT NULL,
  `business_track` varchar(100) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `experience_in_expertise_role` varchar(100) DEFAULT NULL,
  `job_code` varchar(100) DEFAULT NULL,
  `job_title` varchar(100) DEFAULT NULL,
  `primary_skill` varchar(100) DEFAULT NULL,
  `secondary_skill` varchar(100) DEFAULT NULL,
  `term` varchar(3) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `project_location` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `payrate` varchar(100) DEFAULT NULL,
  `clientrate` varchar(100) DEFAULT NULL,
  `margin` varchar(100) DEFAULT NULL,
  `vendor_fee` varchar(100) DEFAULT NULL,
  `margin_deviation_approval` varchar(3) DEFAULT NULL,
  `margin_deviation_reason` varchar(255) DEFAULT NULL,
  `ratecard_adherence` varchar(3) DEFAULT NULL,
  `ratecard_deviation_reason` varchar(255) DEFAULT NULL,
  `ratecard_deviation_approved` varchar(3) DEFAULT NULL,
  `payment_term` varchar(100) DEFAULT NULL,
  `payment_term_approval` varchar(3) DEFAULT NULL,
  `payment_term_deviation_reason` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `submittedby` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paperworkdetails`
--

INSERT INTO `paperworkdetails` (`id`, `cfirstname`, `clastname`, `ceipalid`, `clinkedinurl`, `cdob`, `cmobilenumber`, `cemail`, `clocation`, `chomeaddress`, `cssn`, `cwork_authorization_status`, `cv_validate_status`, `ccertifications`, `coverall_experience`, `crecent_job_title`, `ccandidate_source`, `cresume_attached`, `cphoto_id_attached`, `cwa_attached`, `cany_other_specify`, `employer_own_corporation`, `employer_corporation_name`, `fed_id_number`, `contact_person_name`, `contact_person_designation`, `contact_person_address`, `contact_person_phone_number`, `contact_person_extension_number`, `contact_person_email_id`, `benchsale_recruiter_name`, `benchsale_recruiter_phone_number`, `benchsale_recruiter_extension_number`, `benchsale_recruiter_email_id`, `website_link`, `employer_linkedin_url`, `employer_type`, `employer_corporation_name1`, `fed_id_number1`, `contact_person_name1`, `contact_person_designation1`, `contact_person_address1`, `contact_person_phone_number1`, `contact_person_extension_number1`, `contact_person_email_id1`, `collaboration_collaborate`, `delivery_manager`, `delivery_account_lead`, `team_lead`, `associate_team_lead`, `business_unit`, `client_account_lead`, `associate_director_delivery`, `delivery_manager1`, `delivery_account_lead1`, `team_lead1`, `associate_team_lead1`, `recruiter_name`, `recruiter_employee_id`, `pt_support`, `pt_ownership`, `coe_non_coe`, `geo`, `entity`, `client`, `client_manager`, `client_manager_email_id`, `end_client`, `business_track`, `industry`, `experience_in_expertise_role`, `job_code`, `job_title`, `primary_skill`, `secondary_skill`, `term`, `duration`, `project_location`, `start_date`, `end_date`, `payrate`, `clientrate`, `margin`, `vendor_fee`, `margin_deviation_approval`, `margin_deviation_reason`, `ratecard_adherence`, `ratecard_deviation_reason`, `ratecard_deviation_approved`, `payment_term`, `payment_term_approval`, `payment_term_deviation_reason`, `type`, `created_at`, `submittedby`) VALUES
(36, 'Chara', 'abc', '', 'abc', '2024-08-01', '876877', 'abc@gmail.com', 'abc', 'abc', 'abc', 'H1B', 'clear', 'abc', 'abc', 'abc', 'Monster', 'Yes', 'Yes', 'Yes', 'abc', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-20 21:41:14', ''),
(37, 'abc', 'abc', 'abc', 'abc', '2024-08-01', '8689698', 'abc@gmail.com', 'abc', 'abc', 'abc', 'H1B', 'Genuine', 'abc', 'abc', 'abc', 'Monster', 'Yes', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(38, 'abc', 'abc', 'abc', 'abc', '2024-08-01', '6887687687', 'abc@gmail.com', 'abc', 'abc', 'abc', 'H1B', 'Genuine', 'abc', 'abc', 'abc', 'Monster', 'Yes', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(39, 'abc', 'abc', 'abc', 'abc', '2024-08-01', '87687687', 'abc@gmail.com', 'abc', 'abc', 'abc', 'US_Citizen', 'Genuine', 'abc', 'abc', 'abc', 'Dice', 'Yes', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(40, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-01', '9876986', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Questionable', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(41, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-01', '87687', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(42, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-01', '8796', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'No', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(43, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-01', '8767', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'No', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(44, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-01', '87689', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(45, 'abc', 'abc', 'abc', 'abc', '2024-08-02', '986986', 'abc@gmail.com', 'abc', 'abc', 'abc', 'US_Citizen', 'Questionable', 'abc', 'abc', 'abc', 'Dice', 'No', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(46, 'abc', 'abc', 'abc', 'abc', '2024-08-02', '986986', 'abc@gmail.com', 'abc', 'abc', 'abc', 'US_Citizen', 'Questionable', 'abc', 'abc', 'abc', 'Dice', 'No', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(47, 'abc', 'abc', 'abc', 'abc', '2024-08-02', '9876986', 'abc@gmail.com', 'abc', 'abc', 'abc', 'H1B', 'Genuine', 'abc', 'abc', 'abc', 'Monster', 'Yes', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(48, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-02', '987868', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'H1B', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(49, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-02', '87687', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'Greencard', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(50, 'gsdjads', 'gsdjads', 'gsdjads', 'gsdjads', '2024-08-02', '87687', 'abc@gmail.com', 'gsdjads', 'gsdjads', 'gsdj', 'Greencard', 'Genuine', 'gsdjads', 'gsdjads', 'gsdjads', 'Monster', 'Yes', 'Yes', 'Yes', 'gsdjads', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(53, 'abc', 'abc', 'abc', 'abc', '2024-08-14', '768767678687689', 'abc@gmail.com', 'abc', 'abc', 'abc', 'H1B', 'Genuine', 'abc', 'abc', 'abc', 'Monster', 'Yes', 'Yes', 'Yes', 'abc', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-20 21:41:14', ''),
(138, 'Charan', 'Raj', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-21 16:44:45', ''),
(139, 'Vijay', '', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-22 16:36:44', 'saranraj50540@gmail.com'),
(141, 'Ajith', '', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-22 21:25:37', 'saranraj50540@gmail.com'),
(143, 'Saran', 'Raj', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-22 22:13:31', 'saranraj50540@gmail.com'),
(147, 'venkatttt', '', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '4645', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-28 21:36:47', 'saranraj50540@gmail.com'),
(148, 'Ro', 'Surya', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '2024-08-28 22:08:56', 'saranraj.s@vdartinc.com'),
(149, 'Sharan', 'raj', '', '', '0000-00-00', '', 'sharanraj2000@gmail.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-08-28 22:17:08', 'sharanraj2000@gmail.com'),
(150, 'abc', 'abc', 'abc', 'abc', '2024-09-04', '896986', 'saranraj.s@vdartinc.com', 'abc', 'abc', 'gsdj', 'GC_EAD', 'Questionable', 'adada', '5435', 'dev', 'Rehiring', 'Yes', 'Yes', 'No', 'nothing', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', NULL, '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-09-04 20:10:57', 'saranraj50540@gmail.com'),
(152, 'uu', '', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', NULL, '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-09-04 20:56:27', 'sharanraj2000@gmail.com'),
(153, 'abc', '', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', NULL, '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-09-04 21:44:35', 'sharanraj2000@gmail.com'),
(154, 'Saran', 'raj', '', '', '0000-00-00', '', 'saranraj.s@vdartinc.com', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, '', NULL, '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', NULL, '', '', '', '', '', '', '', '', NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '', '', '', NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', NULL, '', '', '0000-00-00', '0000-00-00', '', '', '', '', NULL, '', NULL, '', NULL, '', NULL, '', NULL, '2024-09-10 20:11:28', 'saranraj50540@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `record_history`
--

CREATE TABLE `record_history` (
  `id` int(11) NOT NULL,
  `record_id` int(11) DEFAULT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `modification_details` text DEFAULT NULL,
  `old_value` text NOT NULL,
  `new_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `record_history`
--

INSERT INTO `record_history` (`id`, `record_id`, `modified_by`, `modified_date`, `modification_details`, `old_value`, `new_value`) VALUES
(10, 148, 'saranraj50540@gmail.com', '2024-08-30 21:48:52', 'clastname', '', ''),
(11, 148, 'saranraj.s@vdartinc.com', '2024-08-30 21:50:45', 'clastname', '', ''),
(12, 36, 'saranraj50540@gmail.com', '2024-08-30 22:32:48', 'cfirstname', '', ''),
(13, 148, 'saranraj50540@gmail.com', '2024-08-30 22:44:29', 'clastname', '', ''),
(14, 147, 'saranraj50540@gmail.com', '2024-08-30 22:45:58', 'cssn', '', ''),
(16, 147, 'saranraj50540@gmail.com', '2024-08-30 22:53:18', 'cfirstname', '', ''),
(17, 148, 'saranraj.s@vdartinc.com', '2024-09-03 23:34:11', 'cfirstname', '', ''),
(20, 148, 'saranraj.s@vdartinc.com', '2024-09-04 18:15:45', '', 'saranraj.s@vdartinc.com', 'Rol'),
(21, 148, 'saranraj.s@vdartinc.com', '2024-09-04 18:16:27', 'cfirstname', 'saranraj.s@vdartinc.com', 'Role'),
(22, 148, 'saranraj.s@vdartinc.com', '2024-09-04 18:25:22', 'cfirstname', 'Rolexx', 'Ro'),
(23, 52, 'saranraj50540@gmail.com', '2024-09-05 16:46:04', 'cfirstname', 'abc', 'abcccc'),
(24, 36, 'saranraj50540@gmail.com', '2024-09-05 18:25:11', 'cfirstname', 'Charan kumar', 'Chara');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'saran', 'saranraj@gmail.com', '1234'),
(4, 'Allwin', 'saranraj50540@gmail.com', '4321'),
(5, 'Sharanraj', 'saranraj.s@vdartinc.com', '1234'),
(6, 'Charanraj', 'sharanraj2000@gmail.com', '1234'),
(7, 'Allwinnn', 'allwin.f@vdartinc.com', '4321'),
(9, 'Jeevan', 'jeevan@vdartinc.com', '4321'),
(10, 'sanjay', 'sanjay@vdartinc.com', '4321'),
(11, 'sanjay', 'sanjay@vdartinc.com', '4321'),
(12, 'sanjay', 'sanjay@vdartinc.com', '4321');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paperworkdetails`
--
ALTER TABLE `paperworkdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `record_history`
--
ALTER TABLE `record_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paperworkdetails`
--
ALTER TABLE `paperworkdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `record_history`
--
ALTER TABLE `record_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
