-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2019 at 06:04 AM
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
(1, 1, 62, 2, 'dfsdsdsdsdsdsd', '2019-10-05 12:18:00', 1),
(2, 2, 62, 2, 'gooo', '2019-10-05 12:18:00', 1),
(3, 3, 62, 2, 'dd', '2019-10-05 12:18:00', 1),
(8, 5, 63, 2, 'bbb', '2019-10-05 13:11:41', 1),
(7, 4, 63, 2, 'vvv', '2019-10-05 13:11:41', 1),
(9, 6, 63, 2, 'cfdfdfdfdfc', '2019-10-05 13:11:41', 1),
(10, 7, 63, 2, 'mm', '2019-10-05 13:11:41', 1),
(11, 8, 63, 2, 'dd', '2019-10-05 13:11:41', 1),
(12, 9, 64, 19, 'answer1', '2019-10-07 04:56:29', 1),
(13, 10, 64, 19, 'answer2', '2019-10-07 04:56:29', 1),
(14, 11, 64, 19, 'answer3', '2019-10-07 04:56:29', 1),
(15, 12, 64, 19, 'answer4', '2019-10-07 04:56:29', 1);

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
(1, '3', '1', '0', '2019-09-19 13:00:57', '2019-09-30 07:02:07'),
(2, '1', '1', '1', '2019-09-19 13:01:44', '2019-09-19 13:01:44'),
(3, '1', '5', '1', '2019-09-19 13:12:26', '2019-09-19 13:12:26'),
(4, '3', '3', '0', '2019-09-19 13:13:34', '2019-09-30 07:01:52'),
(5, '3', '24', '0', '2019-09-19 13:13:56', '2019-09-19 13:49:23'),
(6, '3', '5', '0', '2019-09-19 13:49:34', '2019-09-19 13:50:12'),
(7, '5', '1', '0', '2019-09-19 13:54:14', '2019-09-19 14:05:19'),
(8, '5', '4', '1', '2019-09-19 13:56:39', '2019-09-19 13:56:39'),
(9, '5', '9', '1', '2019-09-19 13:56:53', '2019-09-19 13:56:53'),
(10, '5', '20', '1', '2019-09-19 13:57:14', '2019-09-19 13:57:14'),
(11, '5', '6', '1', '2019-09-19 13:58:30', '2019-09-19 13:58:30'),
(12, '1', '3', '1', '2019-09-20 13:22:37', '2019-09-20 13:22:37'),
(13, '2', '2', '0', '2019-09-21 07:28:08', '2019-09-21 12:44:31'),
(14, '2', '3', '0', '2019-09-23 07:08:06', '2019-10-01 07:57:21'),
(15, '1', '9', '1', '2019-09-23 09:22:17', '2019-09-23 09:22:17'),
(16, '2', '8', '0', '2019-09-23 12:41:36', '2019-10-01 07:57:26'),
(17, '2', '32', '0', '2019-09-24 10:16:35', '2019-10-01 07:57:30'),
(18, '3', '34', '1', '2019-09-30 07:01:40', '2019-09-30 07:01:40'),
(19, '2', '5', '0', '2019-10-01 07:57:11', '2019-10-01 07:57:41'),
(20, '2', '1', '1', '2019-10-01 10:50:44', '2019-10-01 10:50:44'),
(21, '19', '5', '1', '2019-10-04 05:10:55', '2019-10-04 05:10:55'),
(22, '2', '59', '1', '2019-10-04 12:19:18', '2019-10-04 12:19:18'),
(23, '3', '62', '1', '2019-10-05 07:28:36', '2019-10-05 07:28:36');

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
  `mostView` varchar(255) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `user_id`, `category_id`, `book_title`, `book_slug`, `thubm_image`, `book_description`, `author_name`, `book_image`, `video_url`, `audio_url`, `pdf_url`, `question_data`, `mostView`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'DemoBook\n', 'demobook\n', '', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568786977.mp4', 'audio_1568786977.mp3', '', '0', '279', 0, '2019-09-17 00:00:00', '2019-09-18 06:09:37'),
(2, '1', '2', 'DemoBook\n', 'demobook\n', 'book_1568787068.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568787068.mp4', 'audio_1568787068.mp3', '', '0', '35', 0, '2019-09-17 00:00:00', '2019-09-18 06:11:08'),
(3, '1', '1', 'Demofull\n', 'demofull\n', 'book_1568787142.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Amit', '', 'video_1568787142.mp4', 'audio_1568787142.mp3', '', '0', '199', 0, '2019-09-17 00:00:00', '2019-09-18 06:12:22'),
(4, '1', '1', 'DemoVideo\n', 'demovideo\n', 'book_1568787405.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568787405.mp4', '', '', '0', '74', 0, '2019-09-17 00:00:00', '2019-09-18 06:16:45'),
(5, '1', '2', 'DemoAudio', 'demoaudio', 'book_1568787874.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', 'audio_1568787874.mp3', '', '0', '79', 0, '2019-09-17 00:00:00', '2019-09-18 06:24:34'),
(6, '1', '1', 'pdf', 'pdf', 'book_1568801587.jpg', 'fswdsdsdsd sdhs did sydsi dsidys dsiuyd iusydis dsyds sdysud sd', 'vansh', '', '', '', 'document_1568801587.pdf', '0', '11', 0, '2019-09-18 00:00:00', '2019-09-18 10:13:07'),
(7, '1', '1', 'dfdfdf', 'dfdfdf', 'book_1568806389.jpg', 'fdfd', 'dfdfdf', '', '', '', 'document_1568806389.pdf', '0', '1', 0, '2019-09-18 00:00:00', '2019-09-18 11:33:09'),
(8, '1', '1', 'ffggfg', 'ffggfg', 'book_1568807811.jpg', 'fgfgfgffg', 'fgfgfgf', '', '', '', 'document_1568807811.docx', '0', '17', 0, '2019-09-18 00:00:00', '2019-09-18 11:56:51'),
(9, '1', '2', 'DemoVVV', 'demovvv', 'book_1568808176.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', '', 'document_1568808176.mp4', '0', '23', 0, '2019-09-18 00:00:00', '2019-09-18 12:02:56'),
(10, '1', '1', 'dddd', 'dddd', 'book_1568810042.jpg', 'dddd', 'dddd', '', 'video_1568810042.mp4', '', 'document_1568810042.pdf', '0', '10', 0, '2019-09-18 00:00:00', '2019-09-18 12:34:02'),
(11, '1', '1', 'pppp', 'pppp', 'book_1568811555.jpg', 'dhfgdfgd', 'dfdfdf', '', 'video_1568811555.mp4', '', 'document_1568811555.pdf', '0', '0', 0, '2019-09-18 00:00:00', '2019-09-18 12:59:15'),
(12, '1', '1', 'vbvb', 'vbvb', 'book_1568812725.jpg', 'vbvb', 'vbvb', '', 'video_1568812725.mp4', '', 'document_1568812725.pdf', '0', '1', 0, '2019-09-18 00:00:00', '2019-09-18 13:18:45'),
(13, '1', '1', 'rerttr', 'rerttr', 'book_1568813666.jpg', 'rtrtrt', 'rtrtrtr', '', 'video_1568813666.mp4', '', 'document_1568813666.pdf', '0', '2', 0, '2019-09-18 00:00:00', '2019-09-18 13:34:26'),
(14, '1', '2', 'dffdfdf', 'dffdfdf', 'book_1568813929.jpg', 'fdfdfd', 'fdfdfd', '', 'video_1568813929.mp4', '', 'document_1568813929.pdf', '0', '10', 0, '2019-09-18 00:00:00', '2019-09-18 13:38:49'),
(15, '1', '0', 'fadads', 'fadads', 'book_1568874873.jpg', 'sdfsdfdsf', 'dfdfdssre', '', 'video_1568874873.mp4', '', 'document_1568874873.pdf', '0', '1', 0, '2019-09-18 00:00:00', '2019-09-19 06:34:33'),
(16, '1', '1', 'gyytyty', 'gyytyty', 'book_1568875071.jpg', 'retrtertr rer', 'rtr RT r', '', 'video_1568875071.mp4', '', 'document_1568875071.pdf', '0', '2', 0, '2019-09-18 00:00:00', '2019-09-19 06:37:51'),
(17, '1', '1', 'dfdfeeeeee', 'dfdfeeeeee', 'book_1568876297.jpg', 'dfdfdfse', 'eeeee', '', 'video_1568876297.mp4', 'audio_1568876297.mp3', 'document_1568876297.pdf', '0', '2', 0, '2019-09-18 00:00:00', '2019-09-19 06:58:17'),
(18, '1', '1', 'fdf', 'fdf', 'book_1568880110.jpg', 'ffdfd', 'dfdf', '', 'video_1568880110.mp4', 'audio_1568880110.mp3', '', '0', '3', 0, '2019-09-19 00:00:00', '2019-09-19 08:01:50'),
(19, '1', '1', 'sdsd', 'sdsd', 'book_1568880443.jpg', 'sdsd', 'sdsdsd', '', 'video_1568880443.mp4', 'audio_1568880443.mp3', '', '0', '3', 0, '2019-09-19 00:00:00', '2019-09-19 08:07:23'),
(20, '1', '1', 'book', 'book', 'book_1568885928.jpg', 'book', 'book', '', 'video_1568885928.mp4', 'audio_1568885928.mp3', '', '0', '31', 0, '2019-09-19 00:00:00', '2019-09-19 09:38:48'),
(21, '1', '1', 'ww', 'ww', 'book_1568889890.jpg', 'ww', 'ww', '', 'video_1568889890.mp4', '', '', '0', '1', 0, '2019-09-19 00:00:00', '2019-09-19 10:44:50'),
(22, '1', '1', 'ERR', 'err', 'book_1568890041.jpg', 'RRR', 'RRR', '', '', 'audio_1568890041.mp3', '', '0', '1', 0, '2019-09-19 00:00:00', '2019-09-19 10:47:21'),
(23, '1', '1', 'TYTY', 'tyty', 'book_1568890166.jpg', 'TYTYT', 'TYT', '', 'video_1568890166.mp4', 'audio_1568890166.mp3', '', '0', '2', 0, '2019-09-19 00:00:00', '2019-09-19 10:49:26'),
(24, '1', '2', 'GUU', 'guu', 'book_1568890593.jpg', 'UUU', 'UUU', '', '', '', '', '0', '12', 0, '2019-09-19 00:00:00', '2019-09-19 10:56:33'),
(25, '1', '1', 'fgfg', 'fgfg', 'book_1568896239.jpg', 'fgfgf', 'fgfgfg', '', 'video_1568896239.mp4', '', '', '0', '3', 0, '2019-09-19 00:00:00', '2019-09-19 12:30:39'),
(26, '1', '2', 'Ali BAba', 'ali baba', 'book_1569042194.jpg', 'rte 343', 'Ali baba', '', 'video_1569042194.mp4', '', '', '0', '3', 0, '2019-09-20 00:00:00', '2019-09-21 05:03:14'),
(27, '1', '1', 'ww', 'ww', 'book_1569043112.jpg', 'ww', 'ww', '', 'video_1569043112.mp4', '', '', '0', '0', 0, '2019-09-20 00:00:00', '2019-09-21 05:18:32'),
(28, '1', '1', 'ww', 'ww', 'book_1569046143.jpg', 'ww', 'ww', '', 'video_1569046143.mp4', '', '', '0', '2', 0, '2019-09-20 00:00:00', '2019-09-21 06:09:03'),
(29, '1', '1', 'ss', 'ss', 'book_1569046430.jpg', 'ss', 'ss', '', 'video_1569046430.mp4', '', '', '0', '0', 0, '2019-09-20 00:00:00', '2019-09-21 06:13:50'),
(30, '1', '1', 'xff', 'xff', 'book_1569047259.jpg', 'xxxffffffffff', 'xxxxxxxxxxxxxxxx', '', 'video_1569047259.mp4', '', '', '0', '14', 0, '2019-09-20 00:00:00', '2019-09-21 06:27:39'),
(31, '1', '1', 'rrggg', 'rrggg', 'book_1569047760.jpg', 'grgrggg', 'grgrg', '', '', '', '', '0', '15', 0, '2019-09-20 00:00:00', '2019-09-21 06:36:00'),
(32, '2', '2', 'The GOOD SON', 'the good son', 'book_1569320133.jpg', 'dfgdgfry. ey yr wyr ER r FG dhgf dfgdgfry dfgdgfry dfgdgfry dfyfy u fdysf dgf dfdf auws do usdfhjfjfjgdfj dfre eryueyry eyreyrey euyeur uyruery euyreir eyi ruy euyruefufi euyrf eufyff.     rfeeer', 'VAnsh', '', 'video_1569320133.mp4', 'audio_1569320133.mp3', '', '0', '40', 0, '2019-09-24 00:00:00', '2019-09-24 10:15:33'),
(64, '3', '2', 'New Story books', 'new story books', 'book_1570423584.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'Amit kumar', '', '', '', '', '[\"question1\",\"question2\",\"question3\",\"question4\"]', '7', 1, '2019-10-06 00:00:00', '2019-10-07 04:46:24'),
(62, '3', '2', 'is simply dummy book1', 'is simply dummy book1', 'book_1570258263.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'Amit kumar', '', '', '', '', '[\"zaaa\",\"ssss\",\"dfryytyty\"]', '57', 1, '2019-10-04 00:00:00', '2019-10-05 06:51:03'),
(59, '2', '1', 'dsdasdsdsd', 'dsdasdsdsd', 'book_1570183871.jpg', 'dsdasdsdsd', 'sdsdsd', '', '', '', '', '[\"SF rwrr ertr to ytuyuy \",\"ssdsds\"]', '14', 0, '2019-10-04 00:00:00', '2019-10-04 10:11:11'),
(60, '2', '1', 'jsjsh', 'jsjsh', 'book_1570206578.jpg', 'hshshs', 'hahhss', '', 'video_1570206578.mp4', '', '', '[\"bdhhdhd\",\"bbd\",\"hdhdh\"]', '3', 0, '2019-10-04 00:00:00', '2019-10-04 16:29:38'),
(63, '2', '2', 'asigh', 'asigh', 'book_1570271642.jpg', 'hshshs ueueueu', 'vansh', '', '', '', '', '[\"bbshs agahaa hhshs hahall gehshl bhshs hhs hh\",\"bhsjssh hjsjjs bjksksjshs hsjsjsj hjjsjsagahaja\",\"bsbs k sbshhs hauauaus hhshss hjaiaau jjsjs jjsjs?\",\"bhzhs hahhss ggaha jjaja yyaha\",\"hahaiaoa hhsjs\"]', '59', 0, '2019-10-05 00:00:00', '2019-10-05 10:34:02'),
(58, '3', '2', 'is simply dummy book1', 'is simply dummy book1', 'book_1570180325.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'Amit kumar', '', '', '', '', '[\"zaaa\",\"ssss\",\"dfryytyty\"]', '89', 1, '2019-10-04 00:00:00', '2019-10-04 09:12:05');

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

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `name`, `user_id`, `email`, `phone`, `message`, `created_at`, `status`) VALUES
(1, 'Amit Kumar', '3', 'shyamsoft38@gmial.com', '9015135215', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its ', '2019-09-24 05:41:17', '1'),
(2, 'Vansh raj', '2', 'vansh1996raj@gmail.com', '8439993033', 'hello testing mail', '2019-09-24 07:04:33', '1'),
(3, 'Vansh raj', '2', 'ss', '22', 'tt', '2019-09-24 07:06:34', '1'),
(4, 'Vansh raj', '2', 'gg', '22', 'gg', '2019-09-24 07:31:02', '1'),
(5, 'Vansh raj', '2', 'gg', '222', 'e', '2019-09-24 07:32:08', '1');

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
(1, 62, 'zaaa', 3, '2019-10-05 06:51:03', '2019-10-05 06:51:03'),
(2, 62, 'ssss', 3, '2019-10-05 06:51:03', '2019-10-05 06:51:03'),
(3, 62, 'dfryytyty', 3, '2019-10-05 06:51:03', '2019-10-05 06:51:03'),
(4, 63, 'bbshs agahaa hhshs hahall gehshl bhshs hhs hh', 2, '2019-10-05 10:34:02', '2019-10-05 10:34:02'),
(5, 63, 'bhsjssh hjsjjs bjksksjshs hsjsjsj hjjsjsagahaja', 2, '2019-10-05 10:34:02', '2019-10-05 10:34:02'),
(6, 63, 'bsbs k sbshhs hauauaus hhshss hjaiaau jjsjs jjsjs?', 2, '2019-10-05 10:34:02', '2019-10-05 10:34:02'),
(7, 63, 'bhzhs hahhss ggaha jjaja yyaha', 2, '2019-10-05 10:34:02', '2019-10-05 10:34:02'),
(8, 63, 'hahaiaoa hhsjs', 2, '2019-10-05 10:34:02', '2019-10-05 10:34:02'),
(9, 64, 'question1', 3, '2019-10-07 04:46:24', '2019-10-07 04:46:24'),
(10, 64, 'question2', 3, '2019-10-07 04:46:24', '2019-10-07 04:46:24'),
(11, 64, 'question3', 3, '2019-10-07 04:46:24', '2019-10-07 04:46:24'),
(12, 64, 'question4', 3, '2019-10-07 04:46:24', '2019-10-07 04:46:24');

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
(22, 2, 10, 1, '2019-09-27 06:01:27', '2019-09-27 13:00:04'),
(20, 3, 1, 1, '2019-09-26 07:34:06', '2019-09-27 12:47:13'),
(21, 2, 1, 1, '2019-09-26 07:35:36', '2019-09-30 07:06:51'),
(23, 1, 10, 1, '2019-09-27 12:29:07', '2019-09-27 12:47:13'),
(24, 4, 10, 0, '2019-09-27 12:29:38', '2019-09-27 12:47:13'),
(25, 11, 1, 1, '2019-09-27 13:06:47', '2019-09-27 13:06:47'),
(26, 14, 1, 1, '2019-09-30 05:15:25', '2019-09-30 05:46:08'),
(27, 1, 11, 0, '2019-09-30 05:33:35', '2019-09-30 05:33:35'),
(28, 1, 15, 0, '2019-09-30 05:39:19', '2019-09-30 05:39:19'),
(29, 2, 3, 0, '2019-10-04 12:46:32', '2019-10-04 12:46:32');

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
(23, '1', NULL, 'dfdgfg DF FG FG aaaaaadf GF for fagaf gfg agfdg after FG FG agf after ASAF FG FG FG FG FDAGFF FG FG r hfg gfg', '1', '2019-09-23 10:20:40', '2019-09-23 10:20:40'),
(5, '1', NULL, 'dsddd', '1', '2019-09-20 13:12:47', '2019-09-20 13:12:47'),
(32, '2', NULL, 'sjsjshs bhshs', '1', '2019-10-04 16:27:58', '2019-10-04 16:27:58'),
(29, '2', NULL, 'sdfdsds err ', '1', '2019-10-01 07:53:48', '2019-10-01 07:53:48');

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
(1, '1', '1', 'nic', '5.0', '1', '2019-09-19 13:00:15', '2019-09-20 04:50:51'),
(2, '3', '1', 'new data', '4.0', '1', '2019-09-19 13:00:41', '2019-09-19 13:02:40'),
(12, '2', '14', 'ddfd', '3.5', '1', '2019-09-23 07:09:53', '2019-09-23 07:09:53'),
(3, '1', '5', 'tt', '3.5', '1', '2019-09-19 13:12:38', '2019-09-19 13:12:48'),
(4, '1', '3', 'gg', '2.5', '1', '2019-09-19 13:13:12', '2019-09-19 13:13:12'),
(5, '3', '24', 'nice', '2.5', '1', '2019-09-19 13:44:29', '2019-09-19 13:44:29'),
(6, '3', '5', 'Something is good ðŸ˜ŠðŸ‘', '4.0', '1', '2019-09-19 13:50:03', '2019-09-19 13:50:03'),
(7, '3', '3', 'wao what a book', '4.0', '1', '2019-09-19 13:51:30', '2019-09-19 13:51:30'),
(8, '5', '1', 'something look nice..', '3.5', '1', '2019-09-19 13:55:03', '2019-09-19 13:55:03'),
(9, '5', '4', 'good book for reading..', '4.0', '1', '2019-09-19 13:56:12', '2019-09-19 13:56:12'),
(10, '5', '20', 'so nice ðŸ˜ðŸ‘Œ', '3.0', '1', '2019-09-19 13:57:34', '2019-09-19 13:57:34'),
(11, '3', '20', 'very very well ðŸ‘ðŸ˜€ðŸ˜€', '3.0', '1', '2019-09-19 14:02:04', '2019-09-19 14:02:04'),
(13, '2', '2', 'dfdfdf', '2.0', '1', '2019-09-23 07:11:38', '2019-09-23 07:11:44'),
(14, '2', '3', 'ffgfgfg', '4.5', '1', '2019-09-23 07:11:54', '2019-09-23 07:12:07'),
(15, '1', '9', 'vvv', '3.5', '1', '2019-09-23 09:22:09', '2019-09-23 09:22:09'),
(16, '2', '8', 'dfgdgfry', '4.0', '1', '2019-09-23 12:41:31', '2019-09-24 07:37:37'),
(17, '2', '24', 'cc', '4.0', '1', '2019-09-23 12:42:43', '2019-09-23 12:42:43'),
(18, '2', '32', 'sss', '2.0', '1', '2019-09-24 10:16:30', '2019-09-24 10:16:30'),
(19, '2', '30', 'hho', '3.5', '1', '2019-09-27 17:16:22', '2019-09-27 17:16:22'),
(20, '3', '34', 'nice story ðŸ‘ðŸ‘', '3.0', '1', '2019-09-30 07:01:38', '2019-09-30 07:01:38'),
(21, '2', '4', 'd', '3.5', '1', '2019-10-01 06:55:28', '2019-10-01 07:54:57'),
(22, '19', '1', 'bshhs', '3.0', '1', '2019-10-03 06:09:02', '2019-10-03 06:09:02'),
(23, '19', '5', 'nice', '3.0', '1', '2019-10-04 05:10:34', '2019-10-04 05:10:34'),
(24, '19', '35', 'good', '4.5', '1', '2019-10-04 07:25:16', '2019-10-04 07:25:16'),
(25, '2', '58', 'fgg', '3.5', '1', '2019-10-04 16:27:14', '2019-10-04 16:27:14'),
(26, '3', '62', 'nice', '3.0', '1', '2019-10-05 07:28:02', '2019-10-05 07:28:02'),
(27, '2', '63', 'ffdsae vvg b', '3.0', '1', '2019-10-05 12:43:05', '2019-10-05 12:43:05');

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
(1, '635454', 98096647, '', 'VAnsh', 'pic_1569231542.jpg', 'chaudhary.vanshraj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568785680, 1, '1', 'Writer', '', '', '', '', '2019-09-18 05:48:00', '1'),
(2, '711012', 98096647, '', 'Vansh raj', 'pic_1569842654.jpg', 'vansh1996raj@gmail.com', '', '', '', '', 'NTk4MjE3', '', NULL, 1568788260, 1, '1', 'Writer', '', '', '', '', '2019-09-18 06:31:00', '1'),
(3, '691577', 98128957, '', 'Shyam Soft', 'pic_1569827153.jpg', 'shyamsoft38@gmail.com', '', '', '', 'simple and interesting guy', 'ODUxNzI0', '', NULL, 1568891923, 1, '1', 'Publish House', '', '', '', '', '2019-09-19 11:18:43', '1'),
(10, '816967', 0, '', 'raj', 'pic_1569564028.', 'raj@gmail.com', 'male', '', 'Raj ', 'india', 'MTIzNA==', '', NULL, 1569564028, 1, '1', 'Reader', '', '', '', '', '2019-09-27 06:00:28', '1'),
(11, '362547', 97863204, '', 'demo', 'pic_1569576604.', 'demo@gmail.com', 'male', '', 'demo test', 'india', 'MTIz', NULL, NULL, 1569576604, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-27 09:30:04', '1'),
(12, '345058', 97863070, '', 'abcd', 'pic_1569583655.', 'ddd@gmail.com', 'male', '', 'abcd', 'fgfgf', 'MTIzNA==', NULL, NULL, 1569583655, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-27 11:27:35', '1'),
(13, '737643', 97863134, '', 'dfdfdf', 'pic_1569583791.', 'dfdfd', 'male', '', 'dfdfd', 'eew', 'MTIz', NULL, NULL, 1569583791, 1, '1', 'Reader', '', '', NULL, NULL, '2019-09-27 11:29:51', '1'),
(14, '916676', 98128959, '', 'demoA', 'pic_1569819966.', 'dshgass@gmail.com', 'male', '', 'demo', 'sdsdsd', 'MTIz', NULL, NULL, 1569819966, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-30 05:06:06', '1'),
(15, '953499', 97948044, '', 'jony', 'pic_1569821753.', 'heje@gmail.com', 'male', '', 'hsbsysh heje', 'jsjs', 'MTIz', NULL, NULL, 1569821753, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-30 05:35:53', '1'),
(16, '861412', NULL, '', 'ssdsd', 'pic_1569834729.', 'ssd', 'male', '', 'sdsd', 'sdsd', 'c2RzZHM=', NULL, NULL, 1569834729, 1, '1', 'Reader', '', '', NULL, NULL, '2019-09-30 09:12:09', '1'),
(17, '318065', 97953038, '', 'sdsdsdsd', 'pic_1569834921.', 'sdsd', 'male', '', 'dsdsd', 'sdsd', 'c2RzZHNk', NULL, NULL, 1569834921, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-30 09:15:21', '1'),
(18, '263200', 97953696, '', 'demo', 'pic_1569836446.', 'hshsj', 'male', '', 'bshsj', 'hjd', 'MTIz', NULL, NULL, 1569836446, 1, '1', 'Writer', '', '', NULL, NULL, '2019-09-30 09:40:46', '1'),
(19, '161400', 98120073, '', 'Amit Raj', 'pic_1570082821.jpg', 'raj.amit650@gmail.com', '', '', '', '', 'IA==', NULL, NULL, 1570082634, 1, '1', 'Reader', '', '', NULL, NULL, '2019-10-03 06:03:54', '1');

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
-- Indexes for table `user_login_table`
--
ALTER TABLE `user_login_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

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
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_frnds`
--
ALTER TABLE `tbl_frnds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
