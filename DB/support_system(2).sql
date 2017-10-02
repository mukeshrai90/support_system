-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2017 at 08:58 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bs_access_actions`
--

CREATE TABLE `bs_access_actions` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bs_access_actions`
--

INSERT INTO `bs_access_actions` (`id`, `name`, `parent_id`, `type`, `status`, `created`) VALUES
(1, 'Users', 0, 0, 1, '2017-02-07 00:00:00'),
(2, 'View List', 1, 1, 1, '2017-02-07 00:00:00'),
(3, 'Add', 1, 2, 1, '2017-02-07 00:00:00'),
(4, 'Edit', 1, 3, 1, '2017-02-07 00:00:00'),
(5, 'Update Status', 1, 4, 1, '2017-02-07 00:00:00'),
(6, 'Delete', 1, 5, 1, '2017-02-07 00:00:00'),
(7, 'Tickets', 0, 0, 1, '2017-02-08 00:00:00'),
(8, 'View List', 7, 1, 1, '2017-02-08 00:00:00'),
(9, 'Add', 7, 2, 0, '2017-02-08 00:00:00'),
(10, 'Edit', 7, 3, 0, '2017-02-08 00:00:00'),
(11, 'Update Status', 7, 4, 1, '2017-02-08 00:00:00'),
(12, 'Delete', 7, 5, 1, '2017-02-08 00:00:00'),
(13, 'CMS', 0, 0, 1, '2017-02-08 00:00:00'),
(14, 'View List', 13, 1, 1, '2017-02-08 00:00:00'),
(15, 'Add', 13, 2, 1, '2017-02-08 00:00:00'),
(16, 'Edit', 13, 3, 1, '2017-02-08 00:00:00'),
(17, 'Update Status', 13, 4, 1, '2017-02-08 00:00:00'),
(18, 'Delete', 13, 5, 1, '2017-02-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_admins`
--

CREATE TABLE `bs_admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_username` varchar(20) NOT NULL,
  `admin_email` varchar(50) DEFAULT NULL,
  `admin_mobile` varchar(12) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_emailed_pass` varchar(20) NOT NULL,
  `admin_address` varchar(500) DEFAULT NULL,
  `admin_designation` varchar(30) NOT NULL,
  `admin_location` varchar(30) NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `admin_last_login` datetime NOT NULL,
  `admin_added_on` datetime NOT NULL,
  `admin_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_admins`
--

INSERT INTO `bs_admins` (`admin_id`, `admin_name`, `admin_username`, `admin_email`, `admin_mobile`, `admin_password`, `admin_emailed_pass`, `admin_address`, `admin_designation`, `admin_location`, `admin_status`, `admin_last_login`, `admin_added_on`, `admin_updated_on`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '', 'e10adc3949ba59abbe56e057f20f883e', '', '', '', '', 1, '2017-10-02 21:08:38', '2017-09-07 00:00:00', '2017-09-07 00:00:00'),
(3, 'Admin', 'admin1', 'admin1@admin.com', '9999999999', 'e10adc3949ba59abbe56e057f20f883e', '9999999999', NULL, '', '', 1, '2017-10-02 00:59:13', '2017-09-12 00:24:18', '2017-10-01 01:00:51'),
(4, 'Admin', 'admin2', 'admin2@gmail.com', '9999999999', 'e10adc3949ba59abbe56e057f20f883e', '9999999999', NULL, '', '', 1, '2017-10-02 01:02:46', '2017-10-02 01:01:04', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_admin_access`
--

CREATE TABLE `bs_admin_access` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `action` varchar(20) NOT NULL,
  `access` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bs_admin_call_logs`
--

CREATE TABLE `bs_admin_call_logs` (
  `call_id` int(11) NOT NULL,
  `call_user_id` int(11) NOT NULL,
  `call_logged_admin_id` int(11) NOT NULL,
  `call_desc` varchar(500) NOT NULL,
  `call_type` tinyint(2) NOT NULL,
  `call_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_admin_call_logs`
--

INSERT INTO `bs_admin_call_logs` (`call_id`, `call_user_id`, `call_logged_admin_id`, `call_desc`, `call_type`, `call_time`) VALUES
(1, 1, 2, 'New Admin Added Successfully', 1, '2017-09-12 00:10:09'),
(2, 1, 2, 'Status has been changed to \"Active\"', 3, '2017-09-12 00:21:08'),
(3, 1, 3, 'New Admin Added Successfully Role has been changed to Field Executive', 1, '2017-09-12 00:24:18'),
(4, 1, 3, 'Admin Details Updated Successfully Role has been changed to Accounts', 2, '2017-09-12 00:26:43'),
(5, 3, 1, 'Status has been changed to \"Active\"', 3, '2017-09-13 00:35:35'),
(6, 3, 1, 'Admin Details Updated Successfully', 2, '2017-10-01 00:45:18'),
(7, 3, 1, 'Admin Details Updated Successfully', 2, '2017-10-01 00:48:04'),
(8, 3, 1, 'Admin Details Updated Successfully', 2, '2017-10-01 01:00:36'),
(9, 3, 1, 'Admin Details Updated Successfully Role has been changed to Field Executive', 2, '2017-10-01 01:00:51'),
(10, 4, 3, 'New Admin Added Successfully', 1, '2017-10-02 01:01:04'),
(11, 4, 3, 'Status has been changed to \"Active\"', 3, '2017-10-02 01:02:16');

-- --------------------------------------------------------

--
-- Table structure for table `bs_admin_roles`
--

CREATE TABLE `bs_admin_roles` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_role_id` int(5) NOT NULL,
  `admin_role_status` tinyint(1) NOT NULL,
  `admin_role_circle_id` int(5) DEFAULT NULL,
  `admin_role_ssa_id` int(5) DEFAULT NULL,
  `admin_role_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_admin_roles`
--

INSERT INTO `bs_admin_roles` (`id`, `admin_id`, `admin_role_id`, `admin_role_status`, `admin_role_circle_id`, `admin_role_ssa_id`, `admin_role_added_on`) VALUES
(1, 1, 1, 1, NULL, NULL, '2017-09-09 00:00:00'),
(3, 3, 2, 1, 2, 2, '2017-10-01 01:00:36'),
(4, 4, 3, 1, 2, 2, '2017-10-02 01:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `bs_afe_commissions`
--

CREATE TABLE `bs_afe_commissions` (
  `commission_id` bigint(11) NOT NULL,
  `applied_commission_id` int(11) NOT NULL,
  `commission_afe_id` int(11) NOT NULL,
  `commission_month` tinyint(2) NOT NULL,
  `commission_year` int(4) NOT NULL,
  `commission_total_leads` tinyint(1) UNSIGNED NOT NULL,
  `commission_amount` double NOT NULL,
  `total_plans_amt` double NOT NULL,
  `commission_status_id` int(2) NOT NULL,
  `commission_generated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_afe_commissions`
--

INSERT INTO `bs_afe_commissions` (`commission_id`, `applied_commission_id`, `commission_afe_id`, `commission_month`, `commission_year`, `commission_total_leads`, `commission_amount`, `total_plans_amt`, `commission_status_id`, `commission_generated_on`) VALUES
(1, 1, 3, 9, 2017, 1, 60, 600, 0, '2017-10-01 12:12:37'),
(2, 1, 3, 9, 2017, 1, 60, 600, 5, '2017-10-01 12:13:09');

-- --------------------------------------------------------

--
-- Table structure for table `bs_afe_commission_status`
--

CREATE TABLE `bs_afe_commission_status` (
  `status_id` int(2) NOT NULL,
  `previous_status_id` varchar(10) NOT NULL,
  `allowed_role_id` varchar(10) NOT NULL,
  `status_name` varchar(40) NOT NULL,
  `status_name_long` varchar(40) NOT NULL,
  `status_active` tinyint(1) NOT NULL,
  `status_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_afe_commission_status`
--

INSERT INTO `bs_afe_commission_status` (`status_id`, `previous_status_id`, `allowed_role_id`, `status_name`, `status_name_long`, `status_active`, `status_added_on`) VALUES
(1, '1,2', '1,3', 'Unvalidated', 'Unvalidated', 1, '2017-10-01 00:00:00'),
(2, '1,2', '1,3', 'Validated', 'Validated', 1, '0000-00-00 00:00:00'),
(3, '2', '1,2', 'Approve', 'Approved', 1, '2017-10-01 00:00:00'),
(4, '2', '1,2', 'Disapprove', 'Disapproved', 1, '2017-10-01 00:00:00'),
(5, '3,6', '1,3', 'Paid', 'Paid', 1, '2017-10-01 00:00:00'),
(6, '3,5', '1,3', 'Unpaid', 'Unpaid', 1, '2017-10-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_afe_users`
--

CREATE TABLE `bs_afe_users` (
  `afe_id` int(11) NOT NULL,
  `afe_name` varchar(100) NOT NULL,
  `afe_email` varchar(50) NOT NULL,
  `afe_mobile` varchar(12) NOT NULL,
  `afe_pan_card` varchar(12) NOT NULL,
  `afe_address` varchar(500) NOT NULL,
  `afe_circle_id` int(11) NOT NULL,
  `afe_ssa_id` int(11) NOT NULL,
  `afe_bank_account_no` varchar(20) NOT NULL,
  `afe_bank_name` varchar(50) NOT NULL,
  `afe_bank_ifsc_code` varchar(15) NOT NULL,
  `afe_bank_branch_address` varchar(500) NOT NULL,
  `afe_unique_referral_code` varchar(10) NOT NULL,
  `afe_status` tinyint(1) NOT NULL,
  `afe_added_on` datetime NOT NULL,
  `afe_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_afe_users`
--

INSERT INTO `bs_afe_users` (`afe_id`, `afe_name`, `afe_email`, `afe_mobile`, `afe_pan_card`, `afe_address`, `afe_circle_id`, `afe_ssa_id`, `afe_bank_account_no`, `afe_bank_name`, `afe_bank_ifsc_code`, `afe_bank_branch_address`, `afe_unique_referral_code`, `afe_status`, `afe_added_on`, `afe_updated_on`) VALUES
(1, 'Mukesh', '', '9999999999', '', '', 2, 2, '6565656565656', '565', '656556thghg', '5656', 'ukesh46NKG', 1, '2017-09-08 00:07:26', '0000-00-00 00:00:00'),
(2, 'Mukesh', '', '9999999999', '', '', 2, 2, '6565656565656', '5656', '656556thghg', '5656', 'ukeshUZLON', 1, '2017-09-08 00:11:12', '0000-00-00 00:00:00'),
(3, 'Muekshttt', '', '9999999999', '', '', 2, 2, '6565656565656', '5656789', '656556thghg', '5656', 'Z3T0RDSNJ', 1, '2017-09-08 00:12:21', '2017-09-09 22:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `bs_api_details`
--

CREATE TABLE `bs_api_details` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `senderId` varchar(50) NOT NULL,
  `api_url` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_api_details`
--

INSERT INTO `bs_api_details` (`id`, `username`, `password`, `senderId`, `api_url`, `status`, `date_added`) VALUES
(1, 't1abhimanyu', 'MjU1NDY4MTU=', 'BSPAYS', 'http://nimbusit.co.in/api/swsendSingle.asp?', 1, '2016-04-24 12:25:40');

-- --------------------------------------------------------

--
-- Table structure for table `bs_circles`
--

CREATE TABLE `bs_circles` (
  `circle_id` int(11) NOT NULL,
  `circle_name` varchar(50) NOT NULL,
  `circle_code` varchar(20) NOT NULL,
  `circle_status` tinyint(1) NOT NULL,
  `circle_added_on` datetime NOT NULL,
  `circle_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_circles`
--

INSERT INTO `bs_circles` (`circle_id`, `circle_name`, `circle_code`, `circle_status`, `circle_added_on`, `circle_updated_on`) VALUES
(1, 'sff', '', 1, '2017-09-15 00:33:46', '0000-00-00 00:00:00'),
(2, 'fgfhh', '', 1, '2017-09-15 00:34:53', '0000-00-00 00:00:00'),
(3, 'ghgfqqqq', '123', 0, '2017-09-15 22:08:11', '2017-09-15 22:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `bs_commission_master`
--

CREATE TABLE `bs_commission_master` (
  `id` int(5) NOT NULL,
  `rate` double NOT NULL,
  `type` tinyint(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `active` tinyint(1) NOT NULL,
  `added_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_commission_master`
--

INSERT INTO `bs_commission_master` (`id`, `rate`, `type`, `start_date`, `end_date`, `active`, `added_on`, `updated_on`) VALUES
(1, 10, 1, '2017-09-01', '2017-09-30', 1, '2017-10-01 00:00:00', '2017-10-01 00:00:00'),
(2, 9, 1, '2017-10-01', '0000-00-00', 1, '2017-10-02 00:00:00', '2017-10-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_cron_logs`
--

CREATE TABLE `bs_cron_logs` (
  `cron_id` bigint(20) NOT NULL,
  `cron_name` varchar(30) NOT NULL,
  `cron_response` varchar(500) NOT NULL,
  `cron_start_time` datetime NOT NULL,
  `cron_end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_cron_logs`
--

INSERT INTO `bs_cron_logs` (`cron_id`, `cron_name`, `cron_response`, `cron_start_time`, `cron_end_time`) VALUES
(1, 'generate_afe_commissions', 'Commission Generated Successfully', '2017-10-01 12:12:37', '2017-10-01 12:12:37'),
(2, 'generate_afe_commissions', 'Commission Generated Successfully', '2017-10-01 12:13:09', '2017-10-01 12:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `bs_email_config`
--

CREATE TABLE `bs_email_config` (
  `id` int(11) UNSIGNED NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `text_or_email` tinyint(2) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_email_config`
--

INSERT INTO `bs_email_config` (`id`, `purpose`, `subject`, `text_or_email`, `description`, `status`, `date_added`) VALUES
(1, 'Ticket generation mail to user', 'Ticket Id {{ticket_id}} has been generated', 0, 'Hi {{name}},<br/><br/>\n\nA ticket has been generated for your request. Your ticket id is {{ticket_id}}.\n<br/><br/>\nPlease mention your ticket id for further communication.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(2, 'Ticket generation and assignment mail to manager/admin', 'Ticket Id {{ticket_id}} has been generated', 0, 'Hi {{name}},<br/><br/\n>\nA ticket has been generated by {{user}} having ticket id {{ticket_id}}.\n<br/><br/>\nPlease go to this link to see the details and change status\n<br/> \n<a href=\"{{link_to_approve}}\"> Click Here</a> \n<br/><br/>\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(3, 'Ticket generation mail to admin', 'Ticket Id {{ticket_id}} has been generated', 0, 'Hi {{name}},<br/><br/\n>\nA ticket has been generated by {{user}} having ticket id {{ticket_id}}.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(4, 'Ticket disapproved mail to user', 'Ticket ({{ticket_id}}) has been disapproved', 0, 'Hi {{name}},<br/><br/>\n\nYour ticket with ticket id ({{ticket_id}}) has been disapproved.\n<br/><br/>\nDisapproved Reason: {{reason}}\n<br/><br/>\nYou can recreate this ticket by edit some details.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(5, 'Ticket disapproved mail to admin', 'Ticket ({{ticket_id}}) has been disapproved by {{user}}', 0, 'Hi {{name}},<br/><br/>\n\nTicket with ticket id ({{ticket_id}}) has been disapproved by {{user}}.\n<br/><br/>\nDisapproved Reason: {{reason}}\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(6, 'Ticket close mail to user', 'Ticket ({{ticket_id}}) has been closed', 0, 'Hi {{name}},<br/><br/>\n\nYour ticket with ticket id ({{ticket_id}}) has been closed.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(7, 'Ticket approved mail to admin', 'Ticket ({{ticket_id}}) has been approved', 0, 'Hi {{name}},<br/><br/>\n\nTicket with ticket id ({{ticket_id}}) has been approved by {{user}}.\n<br/><br/>\nDescription: {{description}}\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(8, 'New Registration Mail', 'Registered On Ticket System', 0, 'Hi {{name}},<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: {{username}}<br/>\nPassword: {{password}}\n<br/><br/>\nClick below link to login<br/>\n<a href=\"{{url}}\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 1, '0000-00-00 00:00:00'),
(9, 'Registeration Message to user', '', 1, 'You are registered on Ticket System.\nYour login credentials are:\nUsername: {{username}}\nPassword: {{password}}\nClick to login {{url}}', 1, '0000-00-00 00:00:00'),
(10, 'Ticket disapproved message to user', '', 1, 'Your ticket with ticket id {{ticket_id}} has been disapproved.', 1, '0000-00-00 00:00:00'),
(11, 'Ticket close message to user', '', 1, 'Your ticket with ticket id {{ticket_id}} has been closed.', 1, '0000-00-00 00:00:00'),
(12, 'Ticket generation message to user', '', 1, 'A ticket has been generated for your request. Your ticket id is {{ticket_id}}.', 1, '0000-00-00 00:00:00'),
(13, 'Ticket generation and assignment message to Admin/Manager', '', 1, 'A ticket has been generated by {{user}} having ticket id {{ticket_id}}.Click the link {{link_to_approve}}.\n ', 1, '0000-00-00 00:00:00'),
(14, 'Ticket disapproved message to admin', '', 1, 'Ticket with ticket id ({{ticket_id}}) has been disapproved by {{user}}.', 1, '0000-00-00 00:00:00'),
(15, 'Ticket approved message to admin', '', 1, 'Ticket with ticket id ({{ticket_id}}) has been approved by {{user}}.', 1, '0000-00-00 00:00:00'),
(16, 'Ticket generation message to Admin', '', 1, 'A ticket has been generated by {{user}} having ticket id {{ticket_id}}.\n', 1, '0000-00-00 00:00:00'),
(21, 'Onsite Status mail to user', 'Request Status Changed to \"Onsite\" by admin', 0, 'Hi {{name}},<br/><br/\n>\nRequest Status Changed to \"Onsite\" by admin for your ticket {{ticket_id}}\n<br/>\nPlease view Tickets Details for further details.\n\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-03-06 00:00:00'),
(17, 'Ticket Recreation and assignment message to Admin/Manager', '', 1, 'Ticket has been recreated by {{user}} having ticket id {{ticket_id}}.Please go to this link to see the details {{link_to_approve}}.\n ', 1, '2017-02-11 00:00:00'),
(18, 'Ticket recreation and assignment mail to manager/admin', 'Ticket Id {{ticket_id}} has been recreated', 0, 'Hi {{name}},<br/><br/\n>\nTicket has been recreated by {{user}} having ticket id {{ticket_id}}.\n<br/><br/>\nPlease go to this link to see the details and change status\n<br/> \n<a href=\"{{link_to_approve}}\"> Click Here</a> \n<br/><br/>\nThanks<br/>\nTeam Support', 1, '2017-02-11 00:00:00'),
(19, 'Bill/Invoice uploaded email to admin', 'Bill/Invoice uploaded', 0, 'Hi {{name}},<br/><br/\n>\nA new Bill/Invoice has been uploaded by {{user}} for ticket id {{ticket_id}}.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-02-12 00:00:00'),
(20, 'Bill/Invoice uploaded message to admin', '', 1, 'New Bill/Invoice has been uploaded for ticket ({{ticket_id}}) by {{user}}.', 1, '2017-02-12 00:00:00'),
(22, 'Carry-in Status mail to user', 'Request Status Changed to \"Carry-in\" by admin', 0, 'Hi {{name}},<br/><br/\n>\nRequest Status Changed to \"Carry-in\" by admin for your ticket {{ticket_id}}\n<br/>\nPlease view Tickets Details for further details.\n\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-03-07 00:00:00'),
(23, 'Onsite Status message to user', '', 1, 'Request Status Changed to \"Onsite\" by admin for your ticket {{ticket_id}}.Please view Tickets Details for further details.', 1, '2017-03-07 00:00:00'),
(24, 'Carry-in Status message to user', '', 1, 'Request Status Changed to \"Carry-in\" by admin for your ticket {{ticket_id}}.Please view Tickets Details for further details.', 1, '2017-03-07 00:00:00'),
(25, 'PO Upload mail to admin', 'PO has been uploaded by user for {{ticket_id}}', 0, 'Hi {{name}},<br/><br/>\r\nA new Bill/Invoice has been uploaded by {{user}} for ticket id {{ticket_id}}.\r\n<br/><br/>\r\n\r\nThanks<br/>\r\nTeam Support', 1, '2017-03-07 00:00:00'),
(26, 'Status change mail to user', 'Ticket ({{ticket_id}}) Status has been change by admin', 0, 'Hi {{name}},<br/><br/>\nTicket status has been changed by admin for ticket id {{ticket_id}}.\n<br/>\nPlease login to view further details.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-03-07 00:00:00'),
(27, 'PO Upload message to admin', '', 1, 'New Bill/Invoice has been uploaded for ticket ({{ticket_id}}) by {{user}}.', 1, '2017-03-07 00:00:00'),
(28, 'Status change message to user', '', 1, 'Ticket status has been changed by admin for ticket id {{ticket_id}}.Please login to view further details.', 1, '0000-00-00 00:00:00'),
(29, 'Ticket close mail to admin', 'Ticket ({{ticket_id}}) has been closed', 0, 'Hi {{name}},<br/><br/>\nTicket with ticket id ({{ticket_id}}) has been closed by {{user}}.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-03-07 00:00:00'),
(30, 'Ticket close message to admin', '', 1, 'Ticket with ticket id ({{ticket_id}}) has been closed by {{user}}.', 1, '2017-03-07 00:00:00'),
(31, 'Status change mail to admin', 'Ticket ({{ticket_id}}) Status has been changed', 0, 'Hi {{name}},<br/><br/>\r\nTicket status has been changed by {{user}} for ticket id {{ticket_id}}.\r\n<br/><br/>Please login to view further details.<br/><br/>\r\n\r\nThanks<br/>\r\nTeam Support', 1, '2017-03-07 00:00:00'),
(32, 'Status change message to admin', '', 1, 'Ticket status has been changed by {{user}} for ticket id {{ticket_id}}lease login to view further details.', 1, '0000-00-00 00:00:00'),
(33, 'Surrender Device Mail to Admin', 'User {{user}} has surrendered device(s)', 0, 'Hi {{name}},<br/><br/>\n\nUser {{user}} has surrender device(s).\n<br/><br/>\nDevice Id: {{device_id}}\n<br/>\nDevice Name: {{device_name}}\n<br/>\nDescriotion: {{description}}\n<br/><br/>\n\nThanks<br/>\nTeam Support', 1, '2017-03-15 00:00:00'),
(34, 'Surrender Device Message to Admin', '', 1, 'Device(s) has been surrendered by {{user}}', 1, '2017-03-15 00:00:00'),
(35, 'Ticket Physical Damaged Status Mail', 'Ticket {{ticket_id}} is assigned to you for approval', 0, 'Hi {{name}},<br/><br/>\r\n\r\nTicket with ticket id ({{ticket_id}}) has been assigned to you by Admin.\r\n<br/><br/>\r\nPlease go to this link to see the details and change status\r\n<br/> \r\n<a href=\"{{link_to_approve}}\"> Click Here</a> \r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 1, '2017-03-22 00:00:00'),
(36, 'Ticket Physical Damaged Status Message', '', 1, 'Ticket {{ticket_id}} has been assigned to you by admin for approval.Please go to this link to see the details {{link_to_approve}}.', 1, '2017-03-22 00:00:00'),
(37, 'New Admin Registration', 'Registered On Ticket System', 0, 'Hi {{name}},<br/><br/>\r\n\r\nYou are registered on Ticket System as Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: {{username}}<br/>\r\nPassword: {{password}}\r\n<br/><br/>\r\nPlease click below link to login<br/>\r\n<a href=\"{{url}}\">Click Here</a>\r\n\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 1, '0000-00-00 00:00:00'),
(38, 'Password Change Mail to User', 'Ticket System Password Changed', 0, 'Hi {{name}},<br/><br/>\r\n\r\nYour Ticket System Password has been changed by Admin:\r\n<br/><br/>\r\nPlease contact IT TEAM for further details.\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 1, '2017-08-22 00:00:00'),
(39, 'Ticket Resolved. You can collect System from IT TEAM', 'Ticket Resolved. You can collect System from IT TEAM', 0, 'Hi {{name}},<br/><br/>\r\nTicket status has been changed by admin for ticket id {{ticket_id}}.\r\n\r\n<br/>\r\nSystem Issue is Resolved. You can collect from IT TEAM.\r\n<br/><br/>\r\n\r\nThanks<br/>\r\nTeam Support', 1, '2017-08-22 00:00:00'),
(40, 'Ticket Resolved. You can collect System from IT TEAM', '', 1, 'Ticket status has been changed by admin for ticket id {{ticket_id}}.\r\n\"System Issue is Resolved. You can collect from IT TEAM.\"\r\n', 1, '2017-08-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_email_log`
--

CREATE TABLE `bs_email_log` (
  `id` int(11) UNSIGNED NOT NULL,
  `sender` varchar(50) NOT NULL,
  `sendto` varchar(50) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_email_log`
--

INSERT INTO `bs_email_log` (`id`, `sender`, `sendto`, `subject`, `message`, `purpose`, `status`, `date_added`) VALUES
(1, 'development@sanix.in', 'ajeetkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Ajeet Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0483<br/>\r\nPassword: 9127022016\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:08'),
(2, 'development@sanix.in', 'alok@bhardwajservices.com', 'Registered On Ticket System', 'Hi Alok Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4s/0167<br/>\r\nPassword: 9250059732\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:13'),
(3, 'development@sanix.in', 'amitvats@bhardwajservices.com', 'Registered On Ticket System', 'Hi Amit Vats,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0178<br/>\r\nPassword: 9811130733\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:18'),
(4, 'development@sanix.in', 'anilkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Anil Gole,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0169<br/>\r\nPassword: 9968516963\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:23'),
(5, 'development@sanix.in', 'anilkumarsharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Anil Kumar Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0449<br/>\r\nPassword: 9568986451\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:29'),
(6, 'development@sanix.in', 'cpsingh@bhardwajservices.com', 'Registered On Ticket System', 'Hi C.P. Singh,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0107<br/>\r\nPassword: 9250059700\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:34'),
(7, 'development@sanix.in', 'dsrawat@bhardwajservices.com', 'Registered On Ticket System', 'Hi Dan Singh Rawat,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0086<br/>\r\nPassword: 9990745928\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:39'),
(8, 'development@sanix.in', 'g.prasad@bhardwajservices.com', 'Registered On Ticket System', 'Hi Gauri Shankar prasad,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0239<br/>\r\nPassword: 9643356567\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:44'),
(9, 'development@sanix.in', 'mpsb@bhardwajservices.com', 'Registered On Ticket System', 'Hi Mahipal Singh Bisht,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0014<br/>\r\nPassword: 9818657730\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:50'),
(10, 'development@sanix.in', 'manishkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Manish Kumar (A/C),<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0420<br/>\r\nPassword: 9717723740\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:00:55'),
(11, 'development@sanix.in', 'manishsharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Manish Sharma (H.R),<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0171<br/>\r\nPassword: 9911388129\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:00'),
(12, 'development@sanix.in', 'manojkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Manoj Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0064<br/>\r\nPassword: 9350226601\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:06'),
(13, 'development@sanix.in', 'namrata@bhardwajservices.com', 'Registered On Ticket System', 'Hi Namrata Jain,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0080<br/>\r\nPassword: 358728\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:11'),
(14, 'development@sanix.in', 'nooralam@bhardwajservices.com', 'Registered On Ticket System', 'Hi Noor Mohd.,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0118<br/>\r\nPassword: 8750064539\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:16'),
(15, 'development@sanix.in', 'omsharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Om Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/2169<br/>\r\nPassword: 9899827129\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:21'),
(16, 'development@sanix.in', 'parivartanshukla@bhardwajservices.com', 'Registered On Ticket System', 'Hi Parivartan Shukla,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0230<br/>\r\nPassword: 471761\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:28'),
(17, 'development@sanix.in', 'prashasharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Prasha Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0438<br/>\r\nPassword: 433670\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:33'),
(18, 'development@sanix.in', 'praveen@bhardwajservices.com', 'Registered On Ticket System', 'Hi Praveen Srivastava,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0205<br/>\r\nPassword: 9250059703\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:38'),
(19, 'development@sanix.in', 'priti.rawat@bhardwajservices.com', 'Registered On Ticket System', 'Hi Priti Bist,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0451<br/>\r\nPassword: 802083\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:43'),
(20, 'development@sanix.in', 'priyankadwivedi@bhardwajservices.com', 'Registered On Ticket System', 'Hi Priyanka Dwivedi,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0238<br/>\r\nPassword: 946233\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:48'),
(21, 'development@sanix.in', 'priyankasharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Priyanka Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0218<br/>\r\nPassword: 835841\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:54'),
(22, 'development@sanix.in', 'rajeev@bhardwajservices.com', 'Registered On Ticket System', 'Hi R. K. Bhardwaj,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0005<br/>\r\nPassword: 9873233886\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:01:59'),
(23, 'development@sanix.in', 'rajkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Raj Kumar Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0033<br/>\r\nPassword: 9811164567\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:04'),
(24, 'development@sanix.in', 'rajkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Raj Kumar Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0033<br/>\r\nPassword: 9811164567\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:09'),
(25, 'development@sanix.in', 'sandeepkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Sandeep Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0183<br/>\r\nPassword: 9557353454\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:09'),
(26, 'development@sanix.in', 'sandeepkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Sandeep Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0183<br/>\r\nPassword: 9557353454\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:14'),
(27, 'development@sanix.in', 'sanjeevkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Sanjeev Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0115<br/>\r\nPassword: 8802956377\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:20'),
(28, 'development@sanix.in', 'shalnisharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Shalni Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0073<br/>\r\nPassword: 561041\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:25'),
(29, 'development@sanix.in', 'shripal@bhardwajservices.com', 'Registered On Ticket System', 'Hi Shripal Singh,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0024<br/>\r\nPassword: 9810191319\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:30'),
(30, 'development@sanix.in', 'sonutyagi@bhardwajservices.com', 'Registered On Ticket System', 'Hi Sonu Tyagi,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0242<br/>\r\nPassword: 9555247948\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:35'),
(31, 'development@sanix.in', 'surendrakumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Surendra Khurana,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0189<br/>\r\nPassword: 9899650930\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:41'),
(32, 'development@sanix.in', 'suresh.kabir@bhardwajservices.com', 'Registered On Ticket System', 'Hi Suresh Kabir,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0446<br/>\r\nPassword: 8851297175\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:46'),
(33, 'development@sanix.in', 'suresh@bhardwajservices.com', 'Registered On Ticket System', 'Hi Suresh Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/026<br/>\r\nPassword: 9810568374\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:51'),
(34, 'development@sanix.in', 'vaishali@bhardwajservices.com', 'Registered On Ticket System', 'Hi Vaishali Sharma,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0116<br/>\r\nPassword: 852320\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:02:56'),
(35, 'development@sanix.in', 'vinaykumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Vinay Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0442<br/>\r\nPassword: 8376961331\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:03:02'),
(36, 'development@sanix.in', 'safetymanager@bhardwajservices.com', 'Registered On Ticket System', 'Hi Vipin Tiwari,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0241<br/>\r\nPassword: 7065006700\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:03:09'),
(37, 'development@sanix.in', 'yogeshkumar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Yogesh Kumar,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0228<br/>\r\nPassword: 9818816481\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:03:15'),
(38, 'development@sanix.in', 'sandeepdixit@bhardwajservices.com', 'Registered On Ticket System', 'Hi Sandeep Dixit,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: b4S/0237<br/>\r\nPassword: 9990051026\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-18 04:03:21'),
(39, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Registered On Ticket System', 'Hi ,<br/><br/>\r\n\r\nYou are registered on Ticket System by Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: Admin<br/>\r\nPassword: 123456\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Registration Mail', 1, '2017-05-20 19:52:41'),
(40, 'info@parinyastechnologies.com', 'bskunwar@bhardwajservices.com', 'Registered On Ticket System', 'Hi B. S. Kunwar,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0015<br/>\nPassword: 9891387697\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:06'),
(41, 'info@parinyastechnologies.com', 'bharti@bhardwajservices.com', 'Registered On Ticket System', 'Hi Bharti Sharma,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0084<br/>\nPassword: 755864\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:12'),
(42, 'info@parinyastechnologies.com', 'chanchal@bhardwajservices.com', 'Registered On Ticket System', 'Hi Chanchal Gaur,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0110<br/>\nPassword: 672437\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:17'),
(43, 'info@parinyastechnologies.com', 'gagan@bhardwajservices.com', 'Registered On Ticket System', 'Hi Gagan Kaushik,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0131<br/>\nPassword: 9958288847\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:22'),
(44, 'info@parinyastechnologies.com', 'harendra@bhardwajservices.com', 'Registered On Ticket System', 'Hi Harendra,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4s/viom0324<br/>\nPassword: 9250059642\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:27'),
(45, 'info@parinyastechnologies.com', 'harshvardhan@bhardwajservices.com', 'Registered On Ticket System', 'Hi Harsh Bhardwaj,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0069<br/>\nPassword: 9811367293\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:33'),
(46, 'info@parinyastechnologies.com', 'harshtomar@bhardwajservices.com', 'Registered On Ticket System', 'Hi Harsh Tomar,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0114<br/>\nPassword: 8527193071\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:38'),
(47, 'info@parinyastechnologies.com', 'jagdishlal@bhardwajservices.com', 'Registered On Ticket System', 'Hi Jagdish Lal,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0235<br/>\nPassword: 9999642490\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:43'),
(48, 'info@parinyastechnologies.com', 'krantisharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi Kranti Sharma,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0112<br/>\nPassword: 8750310654\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:48'),
(49, 'info@parinyastechnologies.com', 'lkupadhyay@bhardwajservices.com', 'Registered On Ticket System', 'Hi L. K. Upadhyay,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0012<br/>\nPassword: 9899350248\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:54'),
(50, 'info@parinyastechnologies.com', 'lalit.tyagi@bhardwajservices.com', 'Registered On Ticket System', 'Hi Lalit Tyagi,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0337<br/>\nPassword: 9411677032\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:00:59'),
(51, 'info@parinyastechnologies.com', 'lalitachaubey@bhardwajservices.com', 'Registered On Ticket System', 'Hi Lalita Chaubey,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0233<br/>\nPassword: 806172\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:04'),
(52, 'info@parinyastechnologies.com', 'mdsharma@bhardwajservices.com', 'Registered On Ticket System', 'Hi M. D. Sharma,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0047<br/>\nPassword: 9873352506\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:09'),
(53, 'info@parinyastechnologies.com', 'anju@bhardwajservices.com', 'Registered On Ticket System', 'Hi Anju Mehta,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0176<br/>\nPassword: 853812\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:15'),
(54, 'info@parinyastechnologies.com', 'ankittyagi@bhardwajservices.com', 'Registered On Ticket System', 'Hi Ankit Tyagi,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0186<br/>\nPassword: 9582137898\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:20'),
(55, 'info@parinyastechnologies.com', 'aruntyagi@bhardwajservices.com', 'Registered On Ticket System', 'Hi Arun Tyagi,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/05555<br/>\nPassword: 9958965292\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:25'),
(56, 'info@parinyastechnologies.com', 'ashishmishra@bhardwajservices.com', 'Registered On Ticket System', 'Hi Ashish Ranjan Mishra,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0077<br/>\nPassword: 9811851914\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:31'),
(57, 'info@parinyastechnologies.com', 'ashutoshvats@bhardwajservices.com', 'Registered On Ticket System', 'Hi Ashutosh Vats,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0104<br/>\nPassword: 9639016195\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-05-24 04:01:36'),
(58, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Registered On Ticket System', 'Hi test,<br/><br/>\r\n\r\nYou are registered on Ticket System as Admin. Below are your login credentials:\r\n<br/><br/>\r\nUsername: admin1<br/>\r\nPassword: 9999999999\r\n<br/><br/>\r\nPlease click below link to login<br/>\r\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here</a>\r\n\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'New Admin Registration', 1, '2017-05-25 17:53:34'),
(59, 'info@parinyastechnologies.com', 'safetymanager@bhardwajservices.com', 'Ticket Id TS2017061600001 has been generated', 'Hi Vipin Tiwari,<br/><br/>\n\nA ticket has been generated for your request. Your ticket id is TS2017061600001.\n<br/><br/>\nPlease mention your ticket id for further communication.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Ticket generation mail to user', 1, '2017-06-16 12:00:49'),
(60, 'info@parinyastechnologies.com', 'ashishrmishra@gmail.com', 'Ticket Id TS2017061600001 has been generated', 'Hi IT Super Admin,<br/><br/\n>\nA ticket has been generated by Vipin Tiwari (b4S/0241) having ticket id TS2017061600001.\n<br/><br/>\nPlease go to this link to see the details and change status\n<br/> \n<a href=\"http://ticketsystem.b4spayslips.com/tickets/view/c4ca4238a0b923820dcc509a6f75849b\"> Click Here</a> \n<br/><br/>\nThanks<br/>\nTeam Support', 'Ticket generation and assignment mail to manager/admin', 1, '2017-06-16 12:00:54'),
(61, 'info@parinyastechnologies.com', 'mayank.sharma@bhardwaj.com', 'Registered On Ticket System', 'Hi Mayank Sharma,<br/><br/>\n\nYou are registered on Ticket System by Admin. Below are your login credentials:\n<br/><br/>\nUsername: b4S/0435<br/>\nPassword: 8860385772\n<br/><br/>\nClick below link to login<br/>\n<a href=\"http://ticketsystem.b4spayslips.com/\">Click Here </a>\n<br/><br/>\n\n\nThanks<br/>\nTeam Support', 'New Registration Mail', 1, '2017-08-17 11:11:18'),
(62, 'info@parinyastechnologies.com', 'mayank.sharma@bhardwajservices.com', 'Ticket Id TS2017082100001 has been generated', 'Hi Mayank Sharma,<br/><br/>\n\nA ticket has been generated for your request. Your ticket id is TS2017082100001.\n<br/><br/>\nPlease mention your ticket id for further communication.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Ticket generation mail to user', 1, '2017-08-21 06:43:27'),
(63, 'info@parinyastechnologies.com', 'ashishrmishra@gmail.com', 'Ticket Id TS2017082100001 has been generated', 'Hi IT Super Admin,<br/><br/\n>\nA ticket has been generated by Mayank Sharma (b4S/0435) having ticket id TS2017082100001.\n<br/><br/>\nPlease go to this link to see the details and change status\n<br/> \n<a href=\"http://ticketsystem.b4spayslips.com/tickets/view/c81e728d9d4c2f636f067f89cc14862c\"> Click Here</a> \n<br/><br/>\nThanks<br/>\nTeam Support', 'Ticket generation and assignment mail to manager/admin', 1, '2017-08-21 06:43:33'),
(64, 'info@parinyastechnologies.com', 'mayank.sharma@bhardwajservices.com', 'Request Status Changed to \"Carry-in\" by admin', 'Hi Mayank Sharma,<br/><br/\n>\nRequest Status Changed to \"Carry-in\" by admin for your ticket TS2017082100001\n<br/>\nPlease view Tickets Details for further details.\n\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Carry-in Status mail to user', 1, '2017-08-21 11:17:14'),
(65, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket System Password Changed', 'Hi Mayank Sharma,<br/><br/>\r\n\r\nYour Ticket System Password has been changed by Admin:\r\n<br/><br/>\r\nPlease contact IT TEAM for further details.\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'Password Change Mail to User', 0, '2017-08-22 17:36:51'),
(66, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket System Password Changed', 'Hi Mayank Sharma,<br/><br/>\r\n\r\nYour Ticket System Password has been changed by Admin:\r\n<br/><br/>\r\nPlease contact IT TEAM for further details.\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'Password Change Mail to User', 0, '2017-08-22 17:45:40'),
(67, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket System Password Changed', 'Hi Mayank Sharma,<br/><br/>\r\n\r\nYour Ticket System Password has been changed by Admin:\r\n<br/><br/>\r\nPlease contact IT TEAM for further details.\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'Password Change Mail to User', 1, '2017-08-22 17:47:26'),
(68, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi Mayank Sharma,<br/><br/>\nTicket status has been changed by Admin for ticket id TS2017082100001.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 18:02:14'),
(69, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi Mayank Sharma,<br/><br/>\nTicket status has been changed by Admin for ticket id TS2017082100001.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 18:14:27'),
(70, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi Mayank Sharma,<br/><br/>\nTicket status has been changed by Admin for ticket id TS2017082100001.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 18:18:35'),
(71, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been change by admin', 'Hi Mayank Sharma,<br/><br/>\nTicket status has been changed by admin for ticket id TS2017082100001.\n<br/>\nPlease login to view further details.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to user', 1, '2017-08-22 18:19:20'),
(72, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) has been closed', 'Hi IT Super Admin,<br/><br/>\nTicket with ticket id (TS2017082100001) has been closed by Mayank Sharma(b4S/0435).\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Ticket close mail to admin', 1, '2017-08-22 18:22:19'),
(73, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi Mayank Sharma,<br/><br/>\nTicket status has been changed by Admin for ticket id TS2017082100001.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 18:33:26'),
(74, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket Resolved. You can collect System from IT TEAM', 'Hi Mayank Sharma,<br/><br/>\r\nTicket status has been changed by admin for ticket id TS2017082100001.\r\n\r\n<br/>\r\nSystem Issue is Resolved. You can collect from IT TEAM.\r\n<br/><br/>\r\n\r\nThanks<br/>\r\nTeam Support', 'Ticket Resolved. You can collect System from IT TEAM', 1, '2017-08-22 18:35:48'),
(75, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi IT Super Admin,<br/><br/>\nTicket status has been changed by Mayank Sharma(b4S/0435) for ticket id TS2017082100001.\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 18:37:06'),
(76, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket (TS2017082100001) Status has been changed', 'Hi Mayank Sharma,<br/><br/>\r\nTicket status has been changed by Admin for ticket id TS2017082100001.\r\n<br/><br/>Please login to view further details.<br/><br/>\r\n\r\nThanks<br/>\r\nTeam Support', 'Status change mail to admin', 1, '2017-08-22 19:05:01'),
(77, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'Ticket System Password Changed', 'Hi Sandeep Dixit,<br/><br/>\r\n\r\nYour Ticket System Password has been changed by Admin:\r\n<br/><br/>\r\nPlease contact IT TEAM for further details.\r\n<br/><br/>\r\n\r\n\r\nThanks<br/>\r\nTeam Support', 'Password Change Mail to User', 1, '2017-08-23 18:46:46'),
(78, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'User Sandeep Dixit (b4S/0237) has surrendered device(s)', 'Hi Sandeep Dixit,<br/><br/>\n\nUser Sandeep Dixit (b4S/0237) has surrender device(s).\n<br/><br/>\nDevice Id: b4S/GZB/DTP/044\n<br/>\nDevice Name: fdfd\n<br/>\nDescriotion: fdfdfdf\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Surrender Device Mail to Admin', 0, '2017-08-23 18:49:01'),
(79, 'info@parinyastechnologies.com', 'mukeshrai90@gmail.com', 'User Sandeep Dixit (b4S/0237) has surrendered device(s)', 'Hi Sandeep Dixit,<br/><br/>\n\nUser Sandeep Dixit (b4S/0237) has surrender device(s).\n<br/><br/>\nDevice Id: 99\n<br/>\nDevice Name: hghgh\n<br/>\nDescriotion: ghgh\n<br/><br/>\n\nThanks<br/>\nTeam Support', 'Surrender Device Mail to Admin', 1, '2017-08-23 18:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `bs_lead_files`
--

CREATE TABLE `bs_lead_files` (
  `file_id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` tinyint(1) NOT NULL,
  `file_status` tinyint(1) NOT NULL,
  `file_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_lead_files`
--

INSERT INTO `bs_lead_files` (`file_id`, `lead_id`, `file_name`, `file_type`, `file_status`, `file_added_on`) VALUES
(1, 2, 'File-2-1294558696.3688.pdf', 3, 0, '2017-09-29 00:01:26'),
(2, 2, 'File-2-157537121.33861.pdf', 4, 0, '2017-09-29 00:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `bs_lead_status`
--

CREATE TABLE `bs_lead_status` (
  `status_id` int(2) NOT NULL,
  `previous_status_id` int(5) NOT NULL,
  `status_name` varchar(40) NOT NULL,
  `status_type` char(1) NOT NULL,
  `status_active` tinyint(1) NOT NULL,
  `status_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_lead_status`
--

INSERT INTO `bs_lead_status` (`status_id`, `previous_status_id`, `status_name`, `status_type`, `status_active`, `status_added_on`) VALUES
(1, 0, 'Lead Generated', 'L', 1, '2017-09-12 00:00:00'),
(2, 1, 'CAF Completed', 'L', 1, '2017-09-12 00:00:00'),
(3, 2, 'CPE Payment', 'L', 1, '2017-09-12 00:00:00'),
(4, 3, 'Installation & Activation', 'L', 1, '2017-09-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_plans`
--

CREATE TABLE `bs_plans` (
  `plan_id` int(11) NOT NULL,
  `circle_id` int(11) NOT NULL,
  `ssa_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `plan_code` varchar(20) NOT NULL,
  `plan_rental` double NOT NULL,
  `plan_features` text NOT NULL,
  `plan_status` tinyint(1) NOT NULL,
  `plan_added_on` datetime NOT NULL,
  `plan_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_plans`
--

INSERT INTO `bs_plans` (`plan_id`, `circle_id`, `ssa_id`, `plan_name`, `plan_code`, `plan_rental`, `plan_features`, `plan_status`, `plan_added_on`, `plan_updated_on`) VALUES
(1, 2, 0, 'gfgfgffhh', '', 600, 'cfdf', 1, '2017-09-15 22:45:27', '2017-09-15 22:48:15'),
(2, 1, 0, 'hgjhf', 'yt', 499, 'gfgf', 1, '2017-09-15 22:48:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `bs_roles`
--

CREATE TABLE `bs_roles` (
  `role_id` int(5) NOT NULL,
  `role_name` varchar(20) NOT NULL,
  `role_status` tinyint(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bs_roles`
--

INSERT INTO `bs_roles` (`role_id`, `role_name`, `role_status`) VALUES
(1, 'Admin', 0),
(2, 'Circle Branch Head', 1),
(3, 'Field Executive', 1),
(4, 'Support', 0),
(5, 'Technical', 0),
(6, 'Tele Caller', 0),
(7, 'Accounts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bs_site_infos`
--

CREATE TABLE `bs_site_infos` (
  `id` int(11) NOT NULL,
  `general_email` varchar(100) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  `noreply_email` varchar(100) NOT NULL,
  `noreply_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bs_site_infos`
--

INSERT INTO `bs_site_infos` (`id`, `general_email`, `contact_email`, `noreply_email`, `noreply_name`) VALUES
(1, 'info@parinyastechnologies.com', 'info@parinyastechnologies.com', 'info@parinyastechnologies.com', 'The Ticket System');

-- --------------------------------------------------------

--
-- Table structure for table `bs_sms_log`
--

CREATE TABLE `bs_sms_log` (
  `id` int(11) NOT NULL,
  `response` varchar(500) DEFAULT NULL,
  `sender` varchar(30) NOT NULL,
  `sendto` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_sms_log`
--

INSERT INTO `bs_sms_log` (`id`, `response`, `sender`, `sendto`, `message`, `purpose`, `status`, `date_added`) VALUES
(1, 'LogID=17382093', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-18 04:00:08'),
(2, 'LogID=17382094', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-18 04:00:13'),
(3, 'LogID=17382097', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-18 04:00:18'),
(4, 'LogID=17382098', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-18 04:00:24'),
(5, 'LogID=17382099', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-18 04:00:29'),
(6, 'LogID=17382100', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-18 04:00:34'),
(7, 'LogID=17382103', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-18 04:00:39'),
(8, 'LogID=17382104', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-18 04:00:45'),
(9, 'LogID=17382106', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-18 04:00:50'),
(10, 'LogID=17382108', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-18 04:00:55'),
(11, 'LogID=17382109', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-18 04:01:00'),
(12, 'LogID=17382111', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-18 04:01:06'),
(13, 'LogID=17382113', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-18 04:01:16'),
(14, 'LogID=17382114', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-18 04:01:23'),
(15, 'LogID=17382116', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-18 04:01:38'),
(16, 'LogID=17382121', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-18 04:01:59'),
(17, 'LogID=17382122', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(18, 'LogID=17382123', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(19, 'LogID=17382124', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(20, 'LogID=17382125', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(21, 'LogID=17382126', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(22, 'LogID=17382127', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-18 04:02:02'),
(23, 'LogID=17382128', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(24, 'LogID=17382129', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(25, 'LogID=17382130', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(26, 'LogID=17382131', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(27, 'LogID=17382132', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(28, 'LogID=17382133', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-18 04:02:03'),
(29, 'LogID=17382134', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-18 04:02:04'),
(30, 'LogID=17382135', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-18 04:02:04'),
(31, 'LogID=17382136', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-18 04:02:04'),
(32, 'LogID=17382137', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-18 04:02:04'),
(33, 'LogID=17382138', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-18 04:02:04'),
(34, 'LogID=17382139', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-18 04:02:09'),
(35, 'LogID=17382141', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-18 04:02:15'),
(36, 'LogID=17382142', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-18 04:02:20'),
(37, 'LogID=17382146', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-18 04:02:30'),
(38, 'LogID=17382147', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-18 04:02:36'),
(39, 'LogID=17382149', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-18 04:02:41'),
(40, 'LogID=17382150', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-18 04:02:46'),
(41, 'LogID=17382151', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-18 04:02:51'),
(42, 'LogID=17382155', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-18 04:03:04'),
(43, 'LogID=17382157', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-18 04:03:10'),
(44, 'LogID=17382158', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-18 04:03:16'),
(45, 'LogID=17382180', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-18 04:03:22'),
(46, 'Account validity expired.', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 0, '2017-05-20 19:20:02'),
(47, 'Account validity expired.', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 0, '2017-05-20 20:01:48'),
(48, 'Account validity expired.', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 0, '2017-05-20 20:02:52'),
(49, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(50, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(51, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(52, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(53, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(54, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-21 04:00:03'),
(55, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(56, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(57, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(58, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(59, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(60, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-21 04:00:04'),
(61, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(62, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(63, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(64, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(65, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(66, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(67, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-21 04:00:05'),
(68, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(69, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(70, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(71, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(72, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(73, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(74, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-21 04:00:06'),
(75, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-21 04:00:07'),
(76, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-21 04:00:07'),
(77, 'Account validity expired.', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 0, '2017-05-21 15:32:43'),
(78, 'Account validity expired.', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 0, '2017-05-21 17:28:58'),
(79, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-22 04:00:03'),
(80, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-22 04:00:03'),
(81, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-22 04:00:03'),
(82, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-22 04:00:03'),
(83, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(84, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(85, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(86, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(87, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(88, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-22 04:00:04'),
(89, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-22 04:00:05'),
(90, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-22 04:00:05'),
(91, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-22 04:00:05'),
(92, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-22 04:00:05'),
(93, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(94, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(95, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(96, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(97, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(98, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-22 04:00:06'),
(99, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(100, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(101, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(102, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(103, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(104, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-22 04:00:07'),
(105, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-22 04:00:08'),
(106, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-22 04:00:08'),
(107, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-23 04:00:01'),
(108, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-23 04:00:01'),
(109, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-23 04:00:01'),
(110, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-23 04:00:02'),
(111, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-23 04:00:02'),
(112, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-23 04:00:02'),
(113, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-23 04:00:02'),
(114, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-23 04:00:02'),
(115, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(116, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(117, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(118, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(119, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(120, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-23 04:00:03'),
(121, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-23 04:00:04'),
(122, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-23 04:00:04'),
(123, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-23 04:00:04'),
(124, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-23 04:00:04'),
(125, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-23 04:00:05'),
(126, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-23 04:00:05'),
(127, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-23 04:00:05'),
(128, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-23 04:00:05'),
(129, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-23 04:00:06'),
(130, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-23 04:00:06'),
(131, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-23 04:00:06'),
(132, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-23 04:00:06'),
(133, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-23 04:00:07'),
(134, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-23 04:00:07'),
(135, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-24 04:00:07'),
(136, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-24 04:00:22'),
(137, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-24 04:00:28'),
(138, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-24 04:00:33'),
(139, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-24 04:00:38'),
(140, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-24 04:00:43'),
(141, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-24 04:00:49'),
(142, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-24 04:00:54'),
(143, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-24 04:00:59'),
(144, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-24 04:01:10'),
(145, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-24 04:01:20'),
(146, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-24 04:01:25'),
(147, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-24 04:01:31'),
(148, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-24 04:01:36'),
(149, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-24 04:01:36'),
(150, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-24 04:01:36'),
(151, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-24 04:01:37'),
(152, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-24 04:01:37'),
(153, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-24 04:01:37'),
(154, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-24 04:01:37'),
(155, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-24 04:01:37'),
(156, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-24 04:01:38'),
(157, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-24 04:01:38'),
(158, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-24 04:01:38'),
(159, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-24 04:01:38'),
(160, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-24 04:01:38'),
(161, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(162, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(163, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(164, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(165, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(166, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-24 04:01:39'),
(167, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-24 04:01:40'),
(168, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-24 04:01:40'),
(169, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-24 04:01:40'),
(170, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-24 04:01:40'),
(171, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-24 04:01:40'),
(172, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-24 04:01:41'),
(173, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-24 04:01:41'),
(174, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-24 04:01:41'),
(175, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-24 04:01:41'),
(176, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-24 04:01:41'),
(177, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-25 04:00:03'),
(178, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-25 04:00:03'),
(179, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-25 04:00:03'),
(180, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(181, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(182, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(183, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(184, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(185, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-25 04:00:04'),
(186, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-25 04:00:05'),
(187, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-25 04:00:05'),
(188, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-25 04:00:05'),
(189, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-25 04:00:05'),
(190, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-25 04:00:05'),
(191, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-25 04:00:06'),
(192, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-25 04:00:06'),
(193, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-25 04:00:06'),
(194, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-25 04:00:06'),
(195, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(196, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(197, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(198, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(199, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(200, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(201, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-25 04:00:07'),
(202, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(203, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(204, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(205, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(206, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(207, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-25 04:00:08'),
(208, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(209, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(210, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(211, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(212, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(213, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-25 04:00:09'),
(214, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-25 04:00:10'),
(215, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-25 04:00:10'),
(216, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-25 04:00:10'),
(217, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-25 04:00:10'),
(218, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-25 04:00:10'),
(219, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-26 04:00:02');
INSERT INTO `bs_sms_log` (`id`, `response`, `sender`, `sendto`, `message`, `purpose`, `status`, `date_added`) VALUES
(220, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(221, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(222, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(223, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(224, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(225, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-26 04:00:03'),
(226, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(227, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(228, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(229, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(230, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(231, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-26 04:00:04'),
(232, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(233, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(234, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(235, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(236, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(237, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-26 04:00:05'),
(238, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(239, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(240, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(241, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(242, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(243, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-26 04:00:06'),
(244, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(245, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(246, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(247, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(248, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(249, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-26 04:00:07'),
(250, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(251, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(252, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(253, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(254, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(255, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-26 04:00:08'),
(256, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-26 04:00:09'),
(257, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-26 04:00:09'),
(258, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-26 04:00:09'),
(259, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-26 04:00:09'),
(260, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-26 04:00:09'),
(261, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-27 04:00:03'),
(262, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-27 04:00:03'),
(263, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-27 04:00:03'),
(264, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-27 04:00:03'),
(265, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-27 04:00:04'),
(266, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-27 04:00:04'),
(267, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-27 04:00:04'),
(268, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-27 04:00:04'),
(269, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-27 04:00:04'),
(270, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(271, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(272, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(273, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(274, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(275, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-27 04:00:05'),
(276, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-27 04:00:06'),
(277, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-27 04:00:06'),
(278, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-27 04:00:06'),
(279, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-27 04:00:06'),
(280, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-27 04:00:06'),
(281, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-27 04:00:07'),
(282, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-27 04:00:07'),
(283, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-27 04:00:07'),
(284, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-27 04:00:07'),
(285, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-27 04:00:07'),
(286, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-27 04:00:08'),
(287, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-27 04:00:08'),
(288, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-27 04:00:08'),
(289, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-27 04:00:08'),
(290, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-27 04:00:08'),
(291, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-27 04:00:09'),
(292, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-27 04:00:09'),
(293, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-27 04:00:09'),
(294, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-27 04:00:09'),
(295, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-27 04:00:09'),
(296, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-27 04:00:10'),
(297, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-27 04:00:10'),
(298, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-27 04:00:10'),
(299, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-27 04:00:10'),
(300, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-27 04:00:10'),
(301, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-27 04:00:11'),
(302, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-27 04:00:11'),
(303, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-28 04:00:01'),
(304, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-28 04:00:01'),
(305, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-28 04:00:01'),
(306, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(307, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(308, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(309, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(310, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(311, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-28 04:00:02'),
(312, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(313, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(314, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(315, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(316, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(317, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(318, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-28 04:00:03'),
(319, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(320, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(321, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(322, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(323, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(324, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(325, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-28 04:00:04'),
(326, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(327, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(328, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(329, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(330, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(331, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-28 04:00:05'),
(332, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(333, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(334, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(335, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(336, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(337, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(338, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-28 04:00:06'),
(339, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(340, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(341, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(342, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(343, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(344, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-28 04:00:07'),
(345, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-29 04:00:03'),
(346, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-29 04:00:03'),
(347, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-29 04:00:03'),
(348, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-29 04:00:03'),
(349, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(350, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(351, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(352, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(353, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(354, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-29 04:00:04'),
(355, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-29 04:00:05'),
(356, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-29 04:00:05'),
(357, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-29 04:00:05'),
(358, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-29 04:00:05'),
(359, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-29 04:00:05'),
(360, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-29 04:00:06'),
(361, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-29 04:00:06'),
(362, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-29 04:00:06'),
(363, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-29 04:00:06'),
(364, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-29 04:00:06'),
(365, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(366, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(367, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(368, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(369, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(370, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-29 04:00:07'),
(371, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-29 04:00:08'),
(372, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-29 04:00:08'),
(373, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-29 04:00:08'),
(374, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-29 04:00:08'),
(375, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-29 04:00:08'),
(376, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-29 04:00:09'),
(377, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-29 04:00:09'),
(378, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-29 04:00:09'),
(379, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-29 04:00:09'),
(380, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-29 04:00:09'),
(381, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(382, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(383, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(384, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(385, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(386, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-29 04:00:10'),
(387, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-30 04:00:02'),
(388, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-30 04:00:02'),
(389, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(390, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(391, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(392, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(393, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(394, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(395, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-30 04:00:03'),
(396, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(397, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(398, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(399, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(400, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(401, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-30 04:00:04'),
(402, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(403, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(404, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(405, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(406, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(407, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(408, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-30 04:00:05'),
(409, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(410, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(411, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(412, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(413, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(414, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(415, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-30 04:00:06'),
(416, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(417, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(418, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(419, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(420, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(421, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-30 04:00:07'),
(422, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(423, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(424, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(425, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(426, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(427, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(428, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-30 04:00:08'),
(429, 'Account validity expired.', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-05-31 04:00:02'),
(430, 'Account validity expired.', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-05-31 04:00:03'),
(431, 'Account validity expired.', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-05-31 04:00:03'),
(432, 'Account validity expired.', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-05-31 04:00:03'),
(433, 'Account validity expired.', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-05-31 04:00:03'),
(434, 'Account validity expired.', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-05-31 04:00:03'),
(435, 'Account validity expired.', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-05-31 04:00:03');
INSERT INTO `bs_sms_log` (`id`, `response`, `sender`, `sendto`, `message`, `purpose`, `status`, `date_added`) VALUES
(436, 'Account validity expired.', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(437, 'Account validity expired.', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(438, 'Account validity expired.', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(439, 'Account validity expired.', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(440, 'Account validity expired.', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(441, 'Account validity expired.', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(442, 'Account validity expired.', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-05-31 04:00:04'),
(443, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-05-31 04:00:05'),
(444, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-05-31 04:00:05'),
(445, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-05-31 04:00:05'),
(446, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-05-31 04:00:05'),
(447, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-05-31 04:00:05'),
(448, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-05-31 04:00:06'),
(449, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-05-31 04:00:06'),
(450, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-05-31 04:00:06'),
(451, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-05-31 04:00:06'),
(452, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-05-31 04:00:06'),
(453, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(454, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(455, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(456, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(457, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(458, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-05-31 04:00:07'),
(459, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(460, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(461, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(462, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(463, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(464, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-05-31 04:00:08'),
(465, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-05-31 04:00:09'),
(466, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-05-31 04:00:09'),
(467, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-05-31 04:00:09'),
(468, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-05-31 04:00:09'),
(469, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-05-31 04:00:09'),
(470, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-05-31 04:00:10'),
(471, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(472, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(473, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(474, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(475, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(476, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-01 04:00:03'),
(477, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(478, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(479, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(480, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(481, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(482, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(483, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-01 04:00:04'),
(484, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(485, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(486, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(487, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(488, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(489, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(490, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-01 04:00:05'),
(491, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(492, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(493, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(494, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(495, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(496, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-01 04:00:06'),
(497, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-01 04:00:07'),
(498, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-01 04:00:07'),
(499, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-02 04:00:03'),
(500, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-02 04:00:03'),
(501, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(502, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(503, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(504, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(505, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(506, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-02 04:00:04'),
(507, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(508, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(509, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(510, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(511, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(512, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-02 04:00:05'),
(513, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(514, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(515, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(516, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(517, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(518, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-02 04:00:06'),
(519, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(520, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(521, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(522, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(523, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(524, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-02 04:00:07'),
(525, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-02 04:00:08'),
(526, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-02 04:00:08'),
(527, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-03 04:00:02'),
(528, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-03 04:00:02'),
(529, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(530, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(531, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(532, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(533, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(534, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-03 04:00:03'),
(535, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(536, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(537, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(538, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(539, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(540, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-03 04:00:04'),
(541, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(542, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(543, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(544, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(545, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(546, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-03 04:00:05'),
(547, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(548, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(549, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(550, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(551, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(552, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-03 04:00:06'),
(553, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-03 04:00:07'),
(554, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-03 04:00:07'),
(555, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-04 04:00:03'),
(556, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-04 04:00:03'),
(557, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-04 04:00:03'),
(558, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(559, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(560, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(561, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(562, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(563, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-04 04:00:04'),
(564, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(565, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(566, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(567, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(568, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(569, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-04 04:00:05'),
(570, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(571, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(572, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(573, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(574, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(575, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-04 04:00:06'),
(576, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(577, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(578, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(579, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(580, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(581, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-04 04:00:07'),
(582, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-04 04:00:08'),
(583, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-05 04:00:03'),
(584, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-05 04:00:03'),
(585, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-05 04:00:03'),
(586, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-05 04:00:03'),
(587, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(588, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(589, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(590, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(591, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(592, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(593, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-05 04:00:04'),
(594, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(595, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(596, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(597, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(598, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(599, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-05 04:00:05'),
(600, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(601, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(602, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(603, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(604, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(605, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(606, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-05 04:00:06'),
(607, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-05 04:00:07'),
(608, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-05 04:00:07'),
(609, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-05 04:00:07'),
(610, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-05 04:00:07'),
(611, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-06 04:00:03'),
(612, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-06 04:00:03'),
(613, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-06 04:00:03'),
(614, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-06 04:00:03'),
(615, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-06 04:00:03'),
(616, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(617, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(618, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(619, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(620, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(621, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-06 04:00:04'),
(622, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(623, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(624, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(625, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(626, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(627, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(628, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-06 04:00:05'),
(629, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(630, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(631, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(632, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(633, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(634, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-06 04:00:06'),
(635, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-06 04:00:07'),
(636, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-06 04:00:07'),
(637, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-06 04:00:07'),
(638, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-06 04:00:07'),
(639, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-07 04:00:03'),
(640, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-07 04:00:03'),
(641, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-07 04:00:03'),
(642, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-07 04:00:03'),
(643, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-07 04:00:04'),
(644, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-07 04:00:04'),
(645, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-07 04:00:04'),
(646, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-07 04:00:04'),
(647, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-07 04:00:04'),
(648, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-07 04:00:05'),
(649, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-07 04:00:05'),
(650, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-07 04:00:05'),
(651, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-07 04:00:05');
INSERT INTO `bs_sms_log` (`id`, `response`, `sender`, `sendto`, `message`, `purpose`, `status`, `date_added`) VALUES
(652, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-07 04:00:05'),
(653, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-07 04:00:06'),
(654, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-07 04:00:06'),
(655, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-07 04:00:06'),
(656, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-07 04:00:06'),
(657, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-07 04:00:07'),
(658, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-07 04:00:07'),
(659, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-07 04:00:07'),
(660, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-07 04:00:07'),
(661, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-07 04:00:07'),
(662, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-07 04:00:08'),
(663, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-07 04:00:08'),
(664, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-07 04:00:08'),
(665, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-07 04:00:08'),
(666, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-07 04:00:08'),
(667, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-08 04:00:01'),
(668, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-08 04:00:02'),
(669, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-08 04:00:02'),
(670, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-08 04:00:02'),
(671, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-08 04:00:02'),
(672, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(673, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(674, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(675, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(676, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(677, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(678, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-08 04:00:03'),
(679, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(680, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(681, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(682, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(683, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(684, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-08 04:00:04'),
(685, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(686, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(687, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(688, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(689, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(690, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-08 04:00:05'),
(691, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-08 04:00:06'),
(692, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-08 04:00:06'),
(693, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-08 04:00:06'),
(694, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-08 04:00:06'),
(695, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(696, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(697, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(698, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(699, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(700, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-09 04:00:03'),
(701, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(702, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(703, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(704, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(705, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(706, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(707, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-09 04:00:04'),
(708, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(709, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(710, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(711, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(712, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(713, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(714, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-09 04:00:05'),
(715, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(716, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(717, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(718, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(719, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(720, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-09 04:00:06'),
(721, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-09 04:00:07'),
(722, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-09 04:00:07'),
(723, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-10 04:00:02'),
(724, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-10 04:00:02'),
(725, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-10 04:00:02'),
(726, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-10 04:00:02'),
(727, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(728, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(729, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(730, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(731, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(732, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(733, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-10 04:00:03'),
(734, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(735, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(736, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(737, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(738, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(739, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-10 04:00:04'),
(740, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(741, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(742, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(743, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(744, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(745, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(746, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-10 04:00:05'),
(747, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-10 04:00:06'),
(748, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-10 04:00:06'),
(749, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-10 04:00:06'),
(750, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-10 04:00:06'),
(751, 'Account validity expired.', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-11 04:00:03'),
(752, 'Account validity expired.', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-11 04:00:03'),
(753, 'Account validity expired.', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(754, 'Account validity expired.', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(755, 'Account validity expired.', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(756, 'Account validity expired.', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(757, 'Account validity expired.', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(758, 'Account validity expired.', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(759, 'Account validity expired.', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-11 04:00:04'),
(760, 'Account validity expired.', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(761, 'Account validity expired.', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(762, 'Account validity expired.', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(763, 'Account validity expired.', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(764, 'Account validity expired.', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(765, 'Account validity expired.', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-11 04:00:05'),
(766, 'Account validity expired.', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(767, 'Account validity expired.', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(768, 'Account validity expired.', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(769, 'Account validity expired.', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(770, 'Account validity expired.', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(771, 'Account validity expired.', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(772, 'Account validity expired.', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-11 04:00:06'),
(773, 'Account validity expired.', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(774, 'Account validity expired.', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(775, 'Account validity expired.', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(776, 'Account validity expired.', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(777, 'Account validity expired.', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(778, 'Account validity expired.', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-11 04:00:07'),
(779, 'Login details not found', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697', 'Registeration Message to user', 0, '2017-06-14 04:00:03'),
(780, 'Login details not found', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847', 'Registeration Message to user', 0, '2017-06-14 04:00:03'),
(781, 'Login details not found', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642', 'Registeration Message to user', 0, '2017-06-14 04:00:03'),
(782, 'Login details not found', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293', 'Registeration Message to user', 0, '2017-06-14 04:00:03'),
(783, 'Login details not found', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071', 'Registeration Message to user', 0, '2017-06-14 04:00:03'),
(784, 'Login details not found', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(785, 'Login details not found', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(786, 'Login details not found', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(787, 'Login details not found', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(788, 'Login details not found', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(789, 'Login details not found', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898', 'Registeration Message to user', 0, '2017-06-14 04:00:04'),
(790, 'Login details not found', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(791, 'Login details not found', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(792, 'Login details not found', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(793, 'Login details not found', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(794, 'Login details not found', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(795, 'Login details not found', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733', 'Registeration Message to user', 0, '2017-06-14 04:00:05'),
(796, 'Login details not found', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963', 'Registeration Message to user', 0, '2017-06-14 04:00:06'),
(797, 'Login details not found', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451', 'Registeration Message to user', 0, '2017-06-14 04:00:06'),
(798, 'Login details not found', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700', 'Registeration Message to user', 0, '2017-06-14 04:00:06'),
(799, 'Login details not found', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928', 'Registeration Message to user', 0, '2017-06-14 04:00:06'),
(800, 'Login details not found', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567', 'Registeration Message to user', 0, '2017-06-14 04:00:06'),
(801, 'Login details not found', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(802, 'Login details not found', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(803, 'Login details not found', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(804, 'Login details not found', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(805, 'Login details not found', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(806, 'Login details not found', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129', 'Registeration Message to user', 0, '2017-06-14 04:00:07'),
(807, 'Login details not found', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(808, 'Login details not found', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(809, 'Login details not found', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(810, 'Login details not found', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(811, 'Login details not found', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(812, 'Login details not found', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319', 'Registeration Message to user', 0, '2017-06-14 04:00:08'),
(813, 'Login details not found', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(814, 'Login details not found', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(815, 'Login details not found', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(816, 'Login details not found', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(817, 'Login details not found', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(818, 'Login details not found', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700', 'Registeration Message to user', 0, '2017-06-14 04:00:09'),
(819, 'Login details not found', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481', 'Registeration Message to user', 0, '2017-06-14 04:00:10'),
(820, 'Login details not found', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026', 'Registeration Message to user', 0, '2017-06-14 04:00:10'),
(821, 'LogID=18163809', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456', 'Registeration Message to user', 1, '2017-06-14 16:41:54'),
(822, 'LogID=18163947', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456\nClick to login {{url}}', 'Registeration Message to user', 1, '2017-06-14 17:14:58'),
(823, 'LogID=18163951', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:15:56'),
(824, 'LogID=18163958', 'BSPAYS', '919891387697', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0015\nPassword: 9891387697\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:11'),
(825, 'LogID=18163959', 'BSPAYS', '919958288847', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0131\nPassword: 9958288847\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:14'),
(826, 'LogID=18163960', 'BSPAYS', '919250059642', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/viom0324\nPassword: 9250059642\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:15'),
(827, 'LogID=18163961', 'BSPAYS', '919811367293', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0069\nPassword: 9811367293\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:17'),
(828, 'LogID=18163962', 'BSPAYS', '918527193071', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0114\nPassword: 8527193071\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:18'),
(829, 'LogID=18163963', 'BSPAYS', '919999642490', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0235\nPassword: 9999642490\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:19'),
(830, 'LogID=18163964', 'BSPAYS', '918750310654', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0112\nPassword: 8750310654\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:20'),
(831, 'LogID=18163965', 'BSPAYS', '919899350248', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0012\nPassword: 9899350248\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:21'),
(832, 'LogID=18163966', 'BSPAYS', '919411677032', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0337\nPassword: 9411677032\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:22'),
(833, 'LogID=18163968', 'BSPAYS', '919873352506', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0047\nPassword: 9873352506\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:25'),
(834, 'LogID=18163969', 'BSPAYS', '919582137898', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0186\nPassword: 9582137898\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:27'),
(835, 'LogID=18163970', 'BSPAYS', '919958965292', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/05555\nPassword: 9958965292\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:28'),
(836, 'LogID=18163971', 'BSPAYS', '919811851914', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0077\nPassword: 9811851914\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:29'),
(837, 'LogID=18163972', 'BSPAYS', '919639016195', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0104\nPassword: 9639016195\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:30'),
(838, 'LogID=18163973', 'BSPAYS', '919127022016', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0483\nPassword: 9127022016\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:31'),
(839, 'LogID=18163974', 'BSPAYS', '919250059732', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4s/0167\nPassword: 9250059732\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:33'),
(840, 'LogID=18163975', 'BSPAYS', '919811130733', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0178\nPassword: 9811130733\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:34'),
(841, 'LogID=18163976', 'BSPAYS', '919968516963', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0169\nPassword: 9968516963\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:35'),
(842, 'LogID=18163977', 'BSPAYS', '919568986451', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0449\nPassword: 9568986451\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:36'),
(843, 'LogID=18163978', 'BSPAYS', '919250059700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0107\nPassword: 9250059700\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:37'),
(844, 'LogID=18163979', 'BSPAYS', '919990745928', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0086\nPassword: 9990745928\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:38'),
(845, 'LogID=18163980', 'BSPAYS', '919643356567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0239\nPassword: 9643356567\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:40'),
(846, 'LogID=18163981', 'BSPAYS', '919818657730', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0014\nPassword: 9818657730\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:41'),
(847, 'LogID=18163982', 'BSPAYS', '919717723740', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0420\nPassword: 9717723740\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:42'),
(848, 'LogID=18163983', 'BSPAYS', '919911388129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0171\nPassword: 9911388129\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:43'),
(849, 'LogID=18163984', 'BSPAYS', '919350226601', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0064\nPassword: 9350226601\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:44'),
(850, 'LogID=18163985', 'BSPAYS', '918750064539', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0118\nPassword: 8750064539\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:46'),
(851, 'LogID=18163986', 'BSPAYS', '919899827129', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/2169\nPassword: 9899827129\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:48'),
(852, 'LogID=18163987', 'BSPAYS', '919250059703', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0205\nPassword: 9250059703\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:51'),
(853, 'LogID=18163989', 'BSPAYS', '919873233886', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0005\nPassword: 9873233886\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:55'),
(854, 'LogID=18163990', 'BSPAYS', '919811164567', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0033\nPassword: 9811164567\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:56'),
(855, 'LogID=18163991', 'BSPAYS', '919557353454', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0183\nPassword: 9557353454\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:57'),
(856, 'LogID=18163992', 'BSPAYS', '918802956377', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0115\nPassword: 8802956377\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:17:58'),
(857, 'LogID=18163993', 'BSPAYS', '919810191319', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0024\nPassword: 9810191319\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:01'),
(858, 'LogID=18163994', 'BSPAYS', '919555247948', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0242\nPassword: 9555247948\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:02'),
(859, 'LogID=18163995', 'BSPAYS', '919899650930', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0189\nPassword: 9899650930\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:03'),
(860, 'LogID=18163996', 'BSPAYS', '918851297175', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0446\nPassword: 8851297175\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:04'),
(861, 'LogID=18163997', 'BSPAYS', '919810568374', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/026\nPassword: 9810568374\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:05'),
(862, 'LogID=18163998', 'BSPAYS', '918376961331', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0442\nPassword: 8376961331\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:07'),
(863, 'LogID=18163999', 'BSPAYS', '917065006700', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0241\nPassword: 7065006700\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:09');
INSERT INTO `bs_sms_log` (`id`, `response`, `sender`, `sendto`, `message`, `purpose`, `status`, `date_added`) VALUES
(864, 'LogID=18164000', 'BSPAYS', '919818816481', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0228\nPassword: 9818816481\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:10'),
(865, 'LogID=18164001', 'BSPAYS', '919990051026', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0237\nPassword: 9990051026\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-14 17:18:11'),
(866, 'LogID=18211399', 'BSPAYS', '917065006700', 'A ticket has been generated for your request. Your ticket id is TS2017061600001.', 'Ticket generation message to user', 1, '2017-06-16 12:00:56'),
(867, 'LogID=18211400', 'BSPAYS', '919811851914', 'A ticket has been generated by Vipin Tiwari (b4S/0241) having ticket id TS2017061600001.Click the link http://bit.ly/2qebNQU.\n ', 'Ticket generation and assignment message to Admin/Manager', 1, '2017-06-16 12:00:56'),
(868, 'LogID=18259129', 'BSPAYS', '919023155109', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: Admin\nPassword: 123456\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-06-18 22:54:38'),
(869, 'LogID=20318396', 'BSPAYS', '918860385772', 'You are registered on Ticket System.\nYour login credentials are:\nUsername: b4S/0435\nPassword: 8860385772\nClick to login http://bit.ly/2soRj8g', 'Registeration Message to user', 1, '2017-08-17 11:11:19'),
(870, 'LogID=20439821', 'BSPAYS', '918860385772', 'A ticket has been generated for your request. Your ticket id is TS2017082100001.', 'Ticket generation message to user', 1, '2017-08-21 06:43:34'),
(871, 'LogID=20439823', 'BSPAYS', '919811851914', 'A ticket has been generated by Mayank Sharma (b4S/0435) having ticket id TS2017082100001.Click the link http://bit.ly/2qPzbkL.\n ', 'Ticket generation and assignment message to Admin/Manager', 1, '2017-08-21 06:43:34'),
(872, 'LogID=20451469', 'BSPAYS', '918860385772', 'Request Status Changed to \"Carry-in\" by admin for your ticket TS2017082100001.Please view Tickets Details for further details.', 'Carry-in Status message to user', 1, '2017-08-21 11:17:14'),
(873, 'invalid login', 'Test', '9023155109', 'Ticket status has been changed by Admin for ticket id TS2017082100001', 'Status change message to admin', 0, '2017-08-22 18:02:17'),
(874, 'invalid login', 'Test', '9023155109', 'Ticket status has been changed by Admin for ticket id TS2017082100001', 'Status change message to admin', 0, '2017-08-22 18:14:30'),
(875, 'invalid login', 'Test', '9023155109', 'Ticket status has been changed by Admin for ticket id TS2017082100001', 'Status change message to admin', 0, '2017-08-22 18:18:36'),
(876, 'invalid login', 'Test', '9023155109', 'Ticket status has been changed by admin for ticket id TS2017082100001.Please login to view further details.', 'Status change message to user', 0, '2017-08-22 18:19:22'),
(877, 'invalid login', 'Test', '9023155109', 'Ticket with ticket id (TS2017082100001) has been closed by Mayank Sharma(b4S/0435).', 'Ticket close message to admin', 0, '2017-08-22 18:22:21'),
(878, 'LogID=20494863', 'BSPAYS', '919023155109', 'Ticket status has been changed by Admin for ticket id TS2017082100001', 'Status change message to admin', 1, '2017-08-22 18:33:27'),
(879, 'LogID=20494874', 'BSPAYS', '919023155109', 'Ticket status has been changed by admin for ticket id TS2017082100001.\r\n\"System Issue is Resolved. You can collect from IT TEAM.\"\r\n', 'Ticket Resolved. You can collect System from IT TEAM', 1, '2017-08-22 18:35:49'),
(880, 'LogID=20494891', 'BSPAYS', '919023155109', 'Ticket status has been changed by Mayank Sharma(b4S/0435) for ticket id TS2017082100001', 'Status change message to admin', 1, '2017-08-22 18:37:07'),
(881, 'LogID=20494959', 'BSPAYS', '919023155109', 'Ticket status has been changed by Admin for ticket id TS2017082100001lease login to view further details.', 'Status change message to admin', 1, '2017-08-22 19:05:02'),
(882, 'LogID=20541201', 'BSPAYS', '919023155109', 'Device(s) has been surrendered by Sandeep Dixit (b4S/0237)', 'Surrender Device Message to Admin', 1, '2017-08-23 18:49:01'),
(883, 'LogID=20541224', 'BSPAYS', '919023155109', 'Device(s) has been surrendered by Sandeep Dixit (b4S/0237)', 'Surrender Device Message to Admin', 1, '2017-08-23 18:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `bs_ssa`
--

CREATE TABLE `bs_ssa` (
  `ssa_id` int(11) NOT NULL,
  `circle_id` int(11) NOT NULL,
  `ssa_name` varchar(50) NOT NULL,
  `ssa_code` varchar(20) NOT NULL,
  `ssa_status` tinyint(1) NOT NULL,
  `ssa_added_on` datetime NOT NULL,
  `ssa_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_ssa`
--

INSERT INTO `bs_ssa` (`ssa_id`, `circle_id`, `ssa_name`, `ssa_code`, `ssa_status`, `ssa_added_on`, `ssa_updated_on`) VALUES
(1, 1, 'jgggh', '123', 0, '2017-09-15 22:18:08', '2017-09-15 22:37:20'),
(2, 2, 'yuyyu', 'gjh', 1, '2017-09-15 22:27:24', '2017-09-15 22:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `bs_users`
--

CREATE TABLE `bs_users` (
  `user_id` int(11) NOT NULL,
  `user_unique_id` varchar(20) DEFAULT NULL,
  `user_bsnl_id` varchar(20) DEFAULT NULL,
  `user_full_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `user_mobile` varchar(12) CHARACTER SET utf8 DEFAULT NULL,
  `user_address` varchar(500) CHARACTER SET utf8 DEFAULT NULL,
  `user_circle_id` int(11) NOT NULL,
  `user_ssa_id` int(11) NOT NULL,
  `user_status_id` int(2) NOT NULL,
  `user_lead_status_id` int(2) NOT NULL,
  `user_active` tinyint(1) NOT NULL,
  `user_added_on` datetime NOT NULL,
  `user_updated_on` datetime NOT NULL,
  `user_afe_referer_id` int(11) NOT NULL,
  `user_cpe_payment_status` char(1) CHARACTER SET utf8 DEFAULT NULL,
  `installation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_users`
--

INSERT INTO `bs_users` (`user_id`, `user_unique_id`, `user_bsnl_id`, `user_full_name`, `user_email`, `user_mobile`, `user_address`, `user_circle_id`, `user_ssa_id`, `user_status_id`, `user_lead_status_id`, `user_active`, `user_added_on`, `user_updated_on`, `user_afe_referer_id`, `user_cpe_payment_status`, `installation_date`) VALUES
(1, '', '', 'ghgh', 'hgh@fh.bnb', '9999999999', 'ghgjhj', 2, 2, 1, 1, 1, '2017-09-16 00:48:47', '2017-09-16 18:20:38', 3, '', '2017-09-29'),
(2, '', '', 'Mukesh', 'mukesh@gmail.com', '9999999999', 'ghgjhj', 2, 2, 1, 1, 1, '2017-09-16 00:59:58', '2017-09-29 00:09:22', 3, 'Y', '2017-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user_call_logs`
--

CREATE TABLE `bs_user_call_logs` (
  `call_id` int(11) NOT NULL,
  `call_user_id` int(11) NOT NULL,
  `call_logged_admin_id` int(11) NOT NULL,
  `call_status_id` int(3) NOT NULL,
  `call_desc` varchar(200) NOT NULL,
  `call_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_user_call_logs`
--

INSERT INTO `bs_user_call_logs` (`call_id`, `call_user_id`, `call_logged_admin_id`, `call_status_id`, `call_desc`, `call_time`) VALUES
(1, 1, 1, 1, 'New Lead Created Successfully', '2017-09-16 00:48:47'),
(2, 2, 1, 1, 'New Lead Created Successfully', '2017-09-16 00:59:58'),
(3, 1, 1, 1, 'Lead Updated Successfully', '2017-09-16 18:20:38'),
(4, 2, 1, 1, 'Lead Updated Successfully', '2017-09-16 18:26:44'),
(5, 2, 1, 1, 'Lead Updated Successfully', '2017-09-16 18:27:08'),
(6, 2, 1, 2, 'Status has been changed', '2017-09-28 23:24:20'),
(7, 2, 1, 3, 'vnnb hmnm mnmnm', '2017-09-28 23:55:20'),
(8, 2, 1, 3, 'cbcbv fbvnvn<br/><b>CPE Payment Done</b>', '2017-09-28 23:57:44'),
(9, 2, 1, 4, 'f gjgj gjgj gjgj', '2017-09-28 23:58:07'),
(10, 2, 1, 2, 'ffgfgf ghgh ghghghghg', '2017-09-29 00:01:10'),
(11, 2, 1, 3, 'hth gghghghg<br/><b>CPE Payment Done</b>', '2017-09-29 00:01:26'),
(12, 2, 1, 3, 'DNCS File Uploaded successfully', '2017-09-29 00:01:26'),
(13, 2, 1, 4, 'fgfhfhfh fhf fhfh', '2017-09-29 00:09:22'),
(14, 2, 1, 4, 'Installation & Activation Pic File Uploaded successfully', '2017-09-29 00:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `bs_user_plans`
--

CREATE TABLE `bs_user_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_plan_id` int(11) NOT NULL,
  `user_plan_status` tinyint(1) NOT NULL,
  `user_plan_started_on` datetime NOT NULL,
  `user_plan_ended_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_user_plans`
--

INSERT INTO `bs_user_plans` (`id`, `user_id`, `user_plan_id`, `user_plan_status`, `user_plan_started_on`, `user_plan_ended_on`) VALUES
(1, 1, 1, 1, '2017-09-16 00:48:47', '2017-09-16 18:20:38'),
(2, 2, 1, 1, '2017-09-16 00:59:58', '2017-09-16 18:27:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bs_access_actions`
--
ALTER TABLE `bs_access_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_admins`
--
ALTER TABLE `bs_admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `bs_admin_access`
--
ALTER TABLE `bs_admin_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_admin_call_logs`
--
ALTER TABLE `bs_admin_call_logs`
  ADD PRIMARY KEY (`call_id`);

--
-- Indexes for table `bs_admin_roles`
--
ALTER TABLE `bs_admin_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_afe_commissions`
--
ALTER TABLE `bs_afe_commissions`
  ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `bs_afe_commission_status`
--
ALTER TABLE `bs_afe_commission_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `bs_afe_users`
--
ALTER TABLE `bs_afe_users`
  ADD PRIMARY KEY (`afe_id`);

--
-- Indexes for table `bs_api_details`
--
ALTER TABLE `bs_api_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_circles`
--
ALTER TABLE `bs_circles`
  ADD PRIMARY KEY (`circle_id`);

--
-- Indexes for table `bs_commission_master`
--
ALTER TABLE `bs_commission_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_cron_logs`
--
ALTER TABLE `bs_cron_logs`
  ADD PRIMARY KEY (`cron_id`);

--
-- Indexes for table `bs_email_config`
--
ALTER TABLE `bs_email_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_email_log`
--
ALTER TABLE `bs_email_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_lead_files`
--
ALTER TABLE `bs_lead_files`
  ADD PRIMARY KEY (`file_id`);

--
-- Indexes for table `bs_lead_status`
--
ALTER TABLE `bs_lead_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `bs_plans`
--
ALTER TABLE `bs_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `bs_roles`
--
ALTER TABLE `bs_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `bs_site_infos`
--
ALTER TABLE `bs_site_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_sms_log`
--
ALTER TABLE `bs_sms_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bs_ssa`
--
ALTER TABLE `bs_ssa`
  ADD PRIMARY KEY (`ssa_id`);

--
-- Indexes for table `bs_users`
--
ALTER TABLE `bs_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `bs_user_call_logs`
--
ALTER TABLE `bs_user_call_logs`
  ADD PRIMARY KEY (`call_id`);

--
-- Indexes for table `bs_user_plans`
--
ALTER TABLE `bs_user_plans`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bs_access_actions`
--
ALTER TABLE `bs_access_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `bs_admins`
--
ALTER TABLE `bs_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bs_admin_access`
--
ALTER TABLE `bs_admin_access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bs_admin_call_logs`
--
ALTER TABLE `bs_admin_call_logs`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `bs_admin_roles`
--
ALTER TABLE `bs_admin_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bs_afe_commissions`
--
ALTER TABLE `bs_afe_commissions`
  MODIFY `commission_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_afe_commission_status`
--
ALTER TABLE `bs_afe_commission_status`
  MODIFY `status_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bs_afe_users`
--
ALTER TABLE `bs_afe_users`
  MODIFY `afe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bs_api_details`
--
ALTER TABLE `bs_api_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bs_circles`
--
ALTER TABLE `bs_circles`
  MODIFY `circle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bs_commission_master`
--
ALTER TABLE `bs_commission_master`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_cron_logs`
--
ALTER TABLE `bs_cron_logs`
  MODIFY `cron_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_email_config`
--
ALTER TABLE `bs_email_config`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `bs_email_log`
--
ALTER TABLE `bs_email_log`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `bs_lead_files`
--
ALTER TABLE `bs_lead_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_lead_status`
--
ALTER TABLE `bs_lead_status`
  MODIFY `status_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bs_plans`
--
ALTER TABLE `bs_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_roles`
--
ALTER TABLE `bs_roles`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `bs_site_infos`
--
ALTER TABLE `bs_site_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bs_sms_log`
--
ALTER TABLE `bs_sms_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=884;
--
-- AUTO_INCREMENT for table `bs_ssa`
--
ALTER TABLE `bs_ssa`
  MODIFY `ssa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_users`
--
ALTER TABLE `bs_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_user_call_logs`
--
ALTER TABLE `bs_user_call_logs`
  MODIFY `call_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `bs_user_plans`
--
ALTER TABLE `bs_user_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
