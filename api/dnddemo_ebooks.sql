-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2019 at 11:53 AM
-- Server version: 5.6.45-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dnddemo_ebooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_ip_tracking`
--

CREATE TABLE `admin_ip_tracking` (
  `id` bigint(20) NOT NULL,
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `login_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login_table`
--

CREATE TABLE `admin_login_table` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(20) COLLATE latin1_general_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `admin_login_table`
--

INSERT INTO `admin_login_table` (`id`, `username`, `password`, `role_id`, `email`, `first_name`, `last_name`, `status`) VALUES
(1, '1248395', 'admin@123', 1, 'admin@scamcom.com', 'Admin', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `DEFINITIONS`
--

CREATE TABLE `DEFINITIONS` (
  `DefinitionID` int(11) NOT NULL,
  `WordID` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(255) COLLATE utf8_bin NOT NULL,
  `Definition` mediumtext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `role` varchar(50) DEFAULT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `facebook_url` text NOT NULL,
  `gplus_url` text NOT NULL,
  `twitter_url` text NOT NULL,
  `linkedin_url` text NOT NULL,
  `google_analytics` text NOT NULL,
  `contact_widget` text NOT NULL,
  `sales_mail` varchar(200) NOT NULL,
  `admin_mail` varchar(200) NOT NULL,
  `admin_phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_answer`
--

CREATE TABLE `tbl_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(10) DEFAULT NULL,
  `books_id` int(10) DEFAULT NULL,
  `answered_by` int(10) DEFAULT NULL,
  `answer` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int(2) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_answer`
--

INSERT INTO `tbl_answer` (`id`, `question_id`, `books_id`, `answered_by`, `answer`, `created_at`, `status`) VALUES
(1, 3, 2, 1, 'dyghf fun udf ugh uuy suydf day for for my fifth find if fya aiyr ruty fya for iay r7t rfug fun. a7r rytaryry TTY t', '2019-10-14 11:25:01', 1),
(2, 4, 5, 1, 'ggggggggggggggggggggggggggggg', '2019-10-14 11:25:39', 1),
(3, 5, 5, 1, '', '2019-10-14 11:25:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bookmark`
--

CREATE TABLE `tbl_bookmark` (
  `id` int(11) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `books_id` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bookmark`
--

INSERT INTO `tbl_bookmark` (`id`, `user_id`, `books_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1', '2019-10-10 11:22:01', '2019-10-19 11:01:14'),
(2, '2', '20', '1', '2019-10-24 05:06:21', '2019-10-24 05:06:21'),
(3, '1', '8', '1', '2019-10-25 07:06:14', '2019-10-25 07:06:14'),
(4, '1', '16', '0', '2019-10-25 07:28:51', '2019-10-25 07:28:57'),
(5, '1', '20', '1', '2019-10-25 07:29:21', '2019-10-25 07:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_books`
--

CREATE TABLE `tbl_books` (
  `id` int(11) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `category_id` varchar(10) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_slug` varchar(255) DEFAULT NULL,
  `thubm_image` varchar(255) DEFAULT NULL,
  `book_description` text,
  `author_name` varchar(255) DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `question_data` text,
  `isbn_number` varchar(255) DEFAULT NULL,
  `mostView` varchar(255) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `user_id`, `category_id`, `book_title`, `book_slug`, `thubm_image`, `book_description`, `author_name`, `book_image`, `video_url`, `audio_url`, `pdf_url`, `question_data`, `isbn_number`, `mostView`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'The Good Son', 'the good son', 'book_1570701749.jpg', 'dsg yeey wedyswd sdysd isydis isydiusd sidius dsyd sduyd sydsdy sidysd sydsdy sydsdysd sdysydsdy sidysdy sdysudy sydusyd sdysudy syds dsydsyd sure Susan \nosdusds dsdsud sdusdsudsud sudid oisdoi osiud sodusoduosd soudsd sudisdsi siidsdosd oisiudosd sdsudosdosduosudosduosdu sodou soiudos osdudiud osidusoidus', 'Vansh', '', '', '', '', '[\"thst so sdyd sddx ckck khkd ?\",\"sdshd sdsyd sydsuyd dsdu sdsdj do?\"]', NULL, '163', 0, '2019-10-10 00:00:00', '2019-10-10 10:02:29'),
(2, '1', '1', 'ddd', 'ddd', 'book_1571040310.jpg', 'dddd', 'ddd', '', '', '', '', '[\"ddddd\"]', NULL, '95', 1, '2019-10-14 00:00:00', '2019-10-14 08:05:10'),
(3, '1', '1', 'ggfdgd', 'ggfdgd', 'book_1571040448.jpg', 'gdgdg', 'dgdg', '', '', '', 'document_1571040448.pdf', '[]', NULL, '62', 1, '2019-10-14 00:00:00', '2019-10-14 08:07:28'),
(4, '1', '1', 'de', 'de', 'book_1571042971.jpg', 'ddd', 'dddd', '', '', '', 'document_1571042971.pdf', '[]', NULL, '36', 1, '2019-10-14 00:00:00', '2019-10-14 08:49:31'),
(5, '1', '1', 'sd', 'sd', 'book_1571043066.jpg', 'sdss', 's', '', '', '', '', '[\"ssss\",\"ddddd\"]', NULL, '19', 0, '2019-10-14 00:00:00', '2019-10-14 08:51:06'),
(6, '1', '2', 'ff', 'ff', 'book_1571045911.jpg', 'cc', 'cc', '', '', 'audio_1571045911.mp3', 'document_1571045911.PDF', '[]', NULL, '6', 0, '2019-10-14 00:00:00', '2019-10-14 09:38:31'),
(7, '1', '2', 'fff', 'fff', 'book_1571380592.jpg', 'ffff', 'fw', '', '', '', 'document_1571380592.pdf', '[]', NULL, '19', 0, '2019-10-17 00:00:00', '2019-10-18 06:36:32'),
(8, '1', '2', 'demo', 'demo', 'book_1571390365.jpg', 'yuiyi', 'dgyuyj ', '', '', '', 'document_1571390365.pdf', '[\"dsdsdsdsds\",\"ddddd\"]', NULL, '46', 0, '2019-10-18 00:00:00', '2019-10-18 09:19:25'),
(9, '1', '2', 'sdsdsdsdsd', 'sdsdsdsdsd', 'book_1571643273.jpg', 'sdsdsd', 'sdsdsd', '', '', '', '', '[\"trtrt\",\"rtrtrt\",\"rtrtr\",\"arererer\",\"wwwwww\",\"erer\",\"ererer\",\"ererer\",\"gtrtt\",\"wwewwe \"]', NULL, '10', 0, '2019-10-21 00:00:00', '2019-10-21 07:34:33'),
(10, '1', '2', 'sdsdsdsad fff', 'sdsdsdsad fff', 'book_1571655779.jpg', 'aaaa', 'ddddd', '', '', '', '', '[]', NULL, '1', 0, '2019-10-21 00:00:00', '2019-10-21 11:02:59'),
(11, '1', '2', 'sddsffdf', 'sddsffdf', 'book_1571658764.jpg', 'fdfdf', 'dfdfdf', '', '', '', '', '[]', NULL, '0', 0, '2019-10-21 00:00:00', '2019-10-21 11:52:44'),
(12, '1', '2', 'sdfsfffdf aaaaa', 'sdfsfffdf aaaaa', 'book_1571663320.jpg', 'sfsfsfsf', 'sfsfsf', '', '', '', '', '[]', NULL, '2', 0, '2019-10-21 00:00:00', '2019-10-21 13:08:40'),
(18, '1', '2', 'dfdffffffffffffff', 'dfdffffffffffffff', 'book_1571739486.jpg', 'fffffffffffff', 'ffffffffffffffffffffffff', '', '', '', '', '[]', NULL, '0', 0, '2019-10-22 00:00:00', '2019-10-22 10:18:06'),
(17, '1', '0', 'dffdsfdf', 'dffdsfdf', 'book_1571739454.jpg', 'dfdfdfdf', 'dfdfdfdf', '', '', '', '', '[]', NULL, '1', 0, '2019-10-22 00:00:00', '2019-10-22 10:17:34'),
(16, '2', '2', 'dummy book2', 'dummy book2', 'book_1571738214.jpg', 'simply dummy text df', 'Amit kumar', '', '', '', '', '', NULL, '71', 1, '2019-10-22 00:00:00', '2019-10-22 09:56:54'),
(19, '1', '2', 'thanks d', 'thanks d', 'book_1571739816.jpg', 'ðŸ±ðŸ±', 'www', '', '', '', '', '[]', NULL, '1', 0, '2019-10-22 00:00:00', '2019-10-22 10:23:36'),
(20, '2', '2', 'dummy book2', 'dummy book2', 'book_1571741181.jpg', 'simply dummy text df', 'Amit kumar', '', '', '', '', '', 'ISBN-135445678', '48', 1, '2019-10-22 00:00:00', '2019-10-22 10:46:21'),
(21, '1', '2', 'ssdsdsddemo', 'ssdsdsddemo', 'book_1571807772.jpg', 'sdsdsdsdsdsd', 'sdsd', '', '', '', '', '[]', '1234567890', '1', 0, '2019-10-22 00:00:00', '2019-10-23 05:16:12'),
(22, '1', '2', 'ssddsdfdfdf', 'ssddsdfdfdf', 'book_1571807924.jpg', 'sdsdsds', 'dsdsd', '', '', '', '', '[]', '1234545685', '2', 0, '2019-10-22 00:00:00', '2019-10-23 05:18:44'),
(23, '1', '2', 'rerer', 'rerer', '', 'ererer', 'ererer', '', '', '', '', '', '', '0', 0, '2019-10-23 00:00:00', '2019-10-24 00:00:00'),
(24, '1', '2', 'abc', 'abc', '', 'fgfgf', 'ggg', '', '', '', '', '', '', '0', 0, '2019-10-23 00:00:00', '2019-10-24 00:00:00'),
(25, '1', '1', 'yyyyyyyyyyyyyyyyyyyyyyyyy', 'yyyyyyyyyyyyyyyyyyyyyyyyy', '', '', '', '', '', '', '', '[]', '', '0', 0, '2019-10-23 00:00:00', '2019-10-24 05:40:21'),
(26, '1', '2', 'nice', 'nice', 'book_1571900756.jpg', 'dfgdfdgg', 'Amit', '', '', '', '', '', '1234567890', '0', 0, '2019-10-23 00:00:00', '2019-10-24 00:00:00'),
(27, '1', '1', 'fffffrr', 'fffffrr', 'book_1571915275.jpg', 'rrrrrrr', 'rrr', '', '', '', '', '[]', '1425369685', '9', 0, '2019-10-24 00:00:00', '2019-10-24 11:07:55'),
(28, '1', '1', 'sdfdsdfgg', 'sdfdsdfgg', '', '', '', '', '', '', '', '[]', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 11:08:17'),
(29, '1', '2', 'sdfdsdfgg', 'sdfdsdfgg', '', '', '', '', '', '', '', '[]', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 11:08:32'),
(30, '1', '2', 'nice', 'nice', '', 'dfgdfdgg', 'Amit', '', '', '', '', '[]', '', '2', 0, '2019-10-24 00:00:00', '2019-10-24 11:13:16'),
(31, '1', '2', 'yyyyyyyyyyyyyyyyyyyyyyyyy', 'yyyyyyyyyyyyyyyyyyyyyyyyy', '', '', '', '', '', '', '', '[]', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 11:15:52'),
(32, '1', '2', 'ff', 'ff', '', 'cc', 'cc', '', '', '', '', '[]', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 11:18:10'),
(33, '1', '1', 'vas', 'vas', 'book_1571918016.jpg', 'sdsd', 'ssss', '', '', '', '', '', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 00:00:00'),
(34, '1', '2', 'vas', 'vas', 'book_1571918102.jpg', 'sdsd', 'ssss', '', '', '', '', '[]', '1478523692', '0', 0, '2019-10-24 00:00:00', '2019-10-24 11:55:02'),
(35, '1', '2', 'vas', 'vas', 'book_1571918237.jpg', 'sdsd', 'ssss', '', '', '', '', '[]', '1478523690', '1', 0, '2019-10-24 00:00:00', '2019-10-24 11:57:17'),
(36, '1', '2', 'ghgh', 'ghgh', 'book_1571918996.jpg', 'gg', 'hghgh', '', '', '', '', '[]', '1593578521', '0', 0, '2019-10-24 00:00:00', '2019-10-24 12:09:56'),
(37, '1', '2', 'rerer', 'rerer', 'book_1571919848.jpg', 'ererer', 'ererer', '', '', '', '', '[]', '', '0', 0, '2019-10-24 00:00:00', '2019-10-24 12:24:08'),
(38, '1', '2', 'abc', 'abc', 'book_1571920109.jpg', 'fgfgf', 'ggg', '', '', '', '', '[]', '', '1', 0, '2019-10-24 00:00:00', '2019-10-24 12:28:29'),
(39, '1', '2', 'yyyyyyyyyyyyyyyyyyyyyyyyy', 'yyyyyyyyyyyyyyyyyyyyyyyyy', 'book_1571920185.jpg', 'fdfdfdfdf', 'dfdfdf', '', '', '', '', '[]', '', '6', 0, '2019-10-24 00:00:00', '2019-10-24 12:29:45');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `slug_url` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '1',
  `thum_image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `category_name`, `slug_url`, `status`, `thum_image`, `created_at`, `updated_at`) VALUES
(1, 'Recommended', 'recommended', '1', NULL, '2019-09-07 09:32:15', '2019-09-07 09:32:15'),
(2, 'New Books', 'new-books', '1', NULL, '2019-09-07 09:32:15', '2019-09-07 09:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `books_id` varchar(255) DEFAULT NULL,
  `comment` text,
  `status` varchar(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE `tbl_contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_id` varchar(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(2) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `id` int(11) NOT NULL,
  `book_id` int(50) DEFAULT NULL,
  `question` text,
  `questioned_by` int(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_faq`
--

INSERT INTO `tbl_faq` (`id`, `book_id`, `question`, `questioned_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'thst so sdyd sddx ckck khkd ?', 1, '2019-10-10 10:02:29', '2019-10-10 10:02:29'),
(2, 1, 'sdshd sdsyd sydsuyd dsdu sdsdj do?', 1, '2019-10-10 10:02:29', '2019-10-10 10:02:29'),
(3, 2, 'ddddd', 1, '2019-10-14 08:05:10', '2019-10-14 08:05:10'),
(4, 5, 'ssss', 1, '2019-10-14 08:51:06', '2019-10-14 08:51:06'),
(5, 5, 'ddddd', 1, '2019-10-14 08:51:06', '2019-10-14 08:51:06'),
(6, 8, 'dsdsdsdsds', 1, '2019-10-18 09:19:25', '2019-10-18 09:19:25'),
(7, 8, 'ddddd', 1, '2019-10-18 09:19:25', '2019-10-18 09:19:25'),
(8, 9, 'trtrt', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(9, 9, 'rtrtrt', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(10, 9, 'rtrtr', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(11, 9, 'arererer', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(12, 9, 'wwwwww', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(13, 9, 'erer', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(14, 9, 'ererer', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(15, 9, 'ererer', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(16, 9, 'gtrtt', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(17, 9, 'wwewwe ', 1, '2019-10-21 07:34:33', '2019-10-21 07:34:33'),
(18, 2, 'ddddd', 1, '2019-10-22 11:07:09', '2019-10-22 11:07:09'),
(19, 2, 'ddddd', 1, '2019-10-22 11:07:35', '2019-10-22 11:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_frnds`
--

CREATE TABLE `tbl_frnds` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `frnd_id` bigint(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0' COMMENT '0-requested,1-accept,2-decline',
  `request_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `accepted_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_frnds`
--

INSERT INTO `tbl_frnds` (`id`, `user_id`, `frnd_id`, `status`, `request_date`, `accepted_date`) VALUES
(1, 1, 11, 0, '2019-11-04 09:50:44', '2019-11-04 09:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_note`
--

CREATE TABLE `tbl_note` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `status` varchar(10) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_note`
--

INSERT INTO `tbl_note` (`id`, `user_id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(7, '1', NULL, 'rtt\nn', '1', '2019-10-19 10:34:24', '2019-10-19 10:34:24'),
(2, '6', NULL, 'ghh', '1', '2019-10-10 14:47:35', '2019-10-10 14:47:35'),
(10, '1', NULL, 'raqhhh ddd do do do do do ', '1', '2019-10-25 07:37:35', '2019-10-25 07:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `id` int(11) NOT NULL,
  `user_id` varchar(250) DEFAULT NULL,
  `books_id` varchar(250) DEFAULT NULL,
  `comment` text,
  `rating` varchar(250) DEFAULT NULL,
  `status` varchar(250) DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_review`
--

INSERT INTO `tbl_review` (`id`, `user_id`, `books_id`, `comment`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'gdf GF E8 R', '4.0', '1', '2019-10-10 11:22:24', '2019-10-25 07:28:32'),
(2, '1', '2', 'fffff', '3.0', '1', '2019-10-14 10:36:45', '2019-10-14 10:36:45'),
(3, '1', '3', 'dddd', '3.0', '1', '2019-10-15 06:32:32', '2019-10-15 06:32:32'),
(4, '1', '7', 'dfdggf', '3.0', '1', '2019-10-19 10:04:55', '2019-10-19 10:04:55'),
(5, '1', '8', 'ee', '3.5', '1', '2019-10-19 10:06:06', '2019-10-21 07:40:06'),
(6, '2', '20', 'test', '3.5', '1', '2019-10-24 05:06:13', '2019-10-24 05:06:13'),
(7, '1', '16', 'hjj', '3.5', '1', '2019-10-30 11:51:06', '2019-11-09 17:23:02'),
(8, '1', '4', 'yj', '3.5', '1', '2019-10-31 12:40:10', '2019-10-31 12:40:10'),
(9, '1', '20', 'dddwee', '5.0', '1', '2019-11-02 07:27:57', '2019-11-02 07:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `user_chats`
--

CREATE TABLE `user_chats` (
  `id` bigint(100) NOT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `sender` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `type` enum('text','file','image','audio','video','docfile') DEFAULT 'text',
  `message` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  `read_msg` enum('0','1') DEFAULT '0',
  `is_active` enum('0','1') DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_chats`
--

INSERT INTO `user_chats` (`id`, `channel_id`, `sender`, `receiver`, `type`, `message`, `created`, `modified`, `read_msg`, `is_active`) VALUES
(1, 584811, 4, 1, 'text', 'gg', '2019-11-13 11:21:22', NULL, '0', '1'),
(2, 584811, 1, 4, 'text', 'ttt', '2019-11-13 11:21:39', NULL, '0', '1'),
(3, 362732, 4, 3, 'text', 'ggg', '2019-11-13 11:21:58', NULL, '0', '1'),
(4, 478177, 1, 3, 'text', 'ffff', '2019-11-13 11:22:27', NULL, '0', '1'),
(5, 584811, 4, 1, 'text', 'hhh', '2019-11-13 11:22:41', NULL, '0', '1'),
(6, 584811, 4, 1, 'text', 'jj', '2019-11-13 11:23:14', NULL, '0', '1'),
(7, 584811, 1, 4, 'image', 'upload/chats/gallery/gallery_1573644223.jpg', '2019-11-13 11:23:43', NULL, '0', '1'),
(8, 297146, 4, 2, 'text', 'dgdgdg', '2019-11-13 11:26:29', NULL, '0', '1'),
(9, 297146, 2, 4, 'text', 'hii', '2019-11-13 11:31:31', NULL, '0', '1'),
(10, 297146, 4, 2, 'text', 'ccc', '2019-11-13 11:31:43', NULL, '0', '1'),
(11, 297146, 2, 4, 'image', 'upload/chats/gallery/gallery_1573644725.jpg', '2019-11-13 11:32:05', NULL, '0', '1'),
(12, 297146, 4, 2, 'image', 'upload/chats/gallery/gallery_1573644754.jpg', '2019-11-13 11:32:34', NULL, '0', '1'),
(13, 297146, 2, 4, 'image', 'upload/chats/gallery/gallery_1573644823.jpg', '2019-11-13 11:33:43', NULL, '0', '1'),
(14, 571017, 2, 3, 'text', 'hii', '2019-11-13 11:35:47', NULL, '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_chats_removed`
--

CREATE TABLE `user_chats_removed` (
  `channel_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_chats_removed`
--

INSERT INTO `user_chats_removed` (`channel_id`, `user_id`) VALUES
(155169, 72),
(519990, 72),
(493742, 72),
(359591, 79),
(359591, 72),
(216060, 72),
(327991, 72),
(153334, 72),
(769945, 72),
(578884, 72),
(767477, 72),
(174314, 72),
(921402, 79),
(190469, 79),
(817274, 79),
(227700, 80),
(328485, 79),
(576983, 94),
(343955, 96),
(343955, 72),
(742848, 72),
(592893, 72),
(210076, 72),
(742848, 96),
(210076, 96);

-- --------------------------------------------------------

--
-- Table structure for table `user_device_token`
--

CREATE TABLE `user_device_token` (
  `id` int(11) NOT NULL,
  `user_id` bigint(40) DEFAULT '0',
  `deviceid` varchar(255) DEFAULT NULL,
  `pushtoken` varchar(255) DEFAULT NULL,
  `phone_model` varchar(255) DEFAULT NULL,
  `phone_version` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_device_token`
--

INSERT INTO `user_device_token` (`id`, `user_id`, `deviceid`, `pushtoken`, `phone_model`, `phone_version`, `created`, `modified`) VALUES
(7, 2, 'FBA2BD37-FA9C-47E0-8922-E018816C74EE', 'c83a9750cffe29d7b5341ce7fd781bb1d668976e3e05694a07af0cb0a6a7a916', 'iPhone', NULL, NULL, NULL),
(9, 96, '49148FC3-DF22-4A22-96A5-95C58109DA76', '304c82108410458c61a3b517c146810cb6e41e6c1e3ab1d0d32a283abd05f188', 'iPhone', NULL, NULL, NULL),
(10, 94, NULL, '6ca08dee39bdb1d17cff30417caab04ab7fab25739409f4d15f6f975020ab2a6', NULL, NULL, NULL, NULL),
(16, 72, 'FBA2BD37-FA9C-47E0-8922-E018816C74EE', 'ebd9e618f0df50a0abfe5c39e629132c74f12df9aaaac8e2b418fd7bccd2f3ff', 'iPhone', NULL, NULL, NULL),
(13, 94, 'E22F2330-9065-4CFE-B145-E8B668300274', '2844ef4c51750d14b44fb88e000ab032f3e6ac0a5831d99ce730211ed093b0c9', 'iPhone', NULL, NULL, NULL),
(14, 94, '7AFEE8BD-A515-4CB6-9F6B-B3335016629B', '5bcaa0dcdc10ef96c4d3f5a944260b079dcc93b04b3dba1b9ced68940431e18a', 'iPad', NULL, NULL, NULL),
(15, 72, '9DB82E41-7411-4492-808F-FA5AEE5401A3', '11000000000000000', 'iPad', NULL, NULL, NULL),
(17, 94, '5FC93D3D-5D77-4341-9ABA-51515BD21605', 'f93c540e10012418d10570115ae6fe6105bd4c69e37e736e8a9d845e3be12416', 'iPad', NULL, NULL, NULL),
(21, 97, '32F032A5-94F1-4907-875A-0DD3D36EFB35', '76c086d278a9c65037ef0ebb6ad28460a3b474715eacbb3f50bf9a3d18af2d13', 'iPhone', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_login_table`
--

CREATE TABLE `user_login_table` (
  `id` bigint(20) NOT NULL,
  `register_id` varchar(200) DEFAULT NULL,
  `chat_id` bigint(20) DEFAULT NULL,
  `full_name` varchar(400) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `about_me` text,
  `country` varchar(255) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `confirmation_key` varchar(1000) DEFAULT NULL,
  `date_added` int(11) DEFAULT NULL,
  `date_edited` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `message_status` varchar(255) NOT NULL DEFAULT '1',
  `publisher_type` varchar(255) NOT NULL DEFAULT '0' COMMENT '0-reader,1-writer,2-reader-writer,3-publisher',
  `device_token` text,
  `device_type` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `thumb_image` varchar(500) DEFAULT NULL,
  `createdAt` datetime DEFAULT CURRENT_TIMESTAMP,
  `global_posting` varchar(255) DEFAULT '1' COMMENT '1-local,0-global'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_table`
--

INSERT INTO `user_login_table` (`id`, `register_id`, `chat_id`, `full_name`, `user_name`, `url`, `email`, `gender`, `phone_no`, `about_me`, `country`, `password`, `confirmation_key`, `date_added`, `date_edited`, `status`, `message_status`, `publisher_type`, `device_token`, `device_type`, `address`, `thumb_image`, `createdAt`, `global_posting`) VALUES
(1, '637426', 98300993, '', 'Vansh raj', 'pic_1571640636.jpg', 'vansh1996raj@gmail.com', '', '', 'fdhf dfdfff sdf dfhk kdhkfh dhf fkdfhkdfh khfkfhk kffh fdfyuduf dfudjfk FJ dfdufdf dufiu fodufo dfudufuid', '', 'IA==', NULL, NULL, 1570701195, 1, '1', 'Publish House', '', '', '', NULL, '2019-10-10 09:53:15', '1'),
(2, '304950', 98482280, '', 'Shyam Soft', 'pic_1571640636.jpg', 'shyamsoft38@gmail.com', '', '', '', '', 'IA==', NULL, NULL, 1571035221, 1, '1', 'Writer', '', '', '', NULL, '2019-10-14 06:40:21', '1'),
(3, '276218', 99591519, '', 'IUITR', 'pic_1573126444.', 'RYUYRURYRYUYU', 'male', '', 'YURURYUY', 'YUYU', 'VVVSVVJVUg==', NULL, NULL, 1573126444, 1, '1', 'Writer', 'SDHDHDD', 'android', '', NULL, '2019-11-07 11:34:04', '1'),
(4, '496726', 99875169, '', 'ss', 'pic_1573551059.', 'sss', 'male', '', 'sss', 'cc', 'YWFhYw==', NULL, NULL, 1573551059, 1, '1', 'Reader', 'cLl0NjjvgsM:APA91bGMXmfXhbUwHBHnyqR9TbxZAk5BKZbotsZcrin-GAEL8mNRlsD7ybXsZlxa6s04Lu70ajm9yo6j2xWGNYNJ9RTda4eY2ngfLdYfdJPCvw5pk6abT1Chvvaudq3RIO6ie3ak9VUN', 'android', NULL, NULL, '2019-11-12 09:30:59', '1');

-- --------------------------------------------------------

--
-- Table structure for table `WORDS`
--

CREATE TABLE `WORDS` (
  `WordID` int(11) NOT NULL,
  `Word` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_ip_tracking`
--
ALTER TABLE `admin_ip_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login_table`
--
ALTER TABLE `admin_login_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DEFINITIONS`
--
ALTER TABLE `DEFINITIONS`
  ADD PRIMARY KEY (`DefinitionID`),
  ADD KEY `WordID_WORDS_WordID` (`WordID`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`role`);

--
-- Indexes for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_books`
--
ALTER TABLE `tbl_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_frnds`
--
ALTER TABLE `tbl_frnds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_note`
--
ALTER TABLE `tbl_note`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_chats`
--
ALTER TABLE `user_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_device_token`
--
ALTER TABLE `user_device_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login_table`
--
ALTER TABLE `user_login_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `WORDS`
--
ALTER TABLE `WORDS`
  ADD PRIMARY KEY (`WordID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_ip_tracking`
--
ALTER TABLE `admin_ip_tracking`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_login_table`
--
ALTER TABLE `admin_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `DEFINITIONS`
--
ALTER TABLE `DEFINITIONS`
  MODIFY `DefinitionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_frnds`
--
ALTER TABLE `tbl_frnds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_chats`
--
ALTER TABLE `user_chats`
  MODIFY `id` bigint(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_device_token`
--
ALTER TABLE `user_device_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `WORDS`
--
ALTER TABLE `WORDS`
  MODIFY `WordID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
