-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2019 at 02:07 PM
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
(1, '3', '1', '1', '2019-09-19 13:00:57', '2019-09-19 01:51:05'),
(2, '1', '1', '1', '2019-09-19 13:01:44', '2019-09-19 13:01:44'),
(3, '1', '5', '1', '2019-09-19 13:12:26', '2019-09-19 13:12:26'),
(4, '3', '3', '1', '2019-09-19 13:13:34', '2019-09-19 01:52:16'),
(5, '3', '24', '0', '2019-09-19 13:13:56', '2019-09-19 13:49:23'),
(6, '3', '5', '0', '2019-09-19 13:49:34', '2019-09-19 13:50:12'),
(7, '5', '1', '0', '2019-09-19 13:54:14', '2019-09-19 14:05:19'),
(8, '5', '4', '1', '2019-09-19 13:56:39', '2019-09-19 13:56:39'),
(9, '5', '9', '1', '2019-09-19 13:56:53', '2019-09-19 13:56:53'),
(10, '5', '20', '1', '2019-09-19 13:57:14', '2019-09-19 13:57:14'),
(11, '5', '6', '1', '2019-09-19 13:58:30', '2019-09-19 13:58:30');

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
  `mostView` varchar(255) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `user_id`, `category_id`, `book_title`, `book_slug`, `thubm_image`, `book_description`, `author_name`, `book_image`, `video_url`, `audio_url`, `pdf_url`, `mostView`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'DemoBook\n', 'demobook\n', '', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568786977.mp4', 'audio_1568786977.mp3', '', '142', 0, '2019-09-17 00:00:00', '2019-09-18 06:09:37'),
(2, '1', '2', 'DemoBook\n', 'demobook\n', 'book_1568787068.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568787068.mp4', 'audio_1568787068.mp3', '', '13', 0, '2019-09-17 00:00:00', '2019-09-18 06:11:08'),
(3, '1', '1', 'Demofull\n', 'demofull\n', 'book_1568787142.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Amit', '', 'video_1568787142.mp4', 'audio_1568787142.mp3', '', '82', 0, '2019-09-17 00:00:00', '2019-09-18 06:12:22'),
(4, '1', '1', 'DemoVideo\n', 'demovideo\n', 'book_1568787405.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568787405.mp4', '', '', '44', 0, '2019-09-17 00:00:00', '2019-09-18 06:16:45'),
(5, '1', '2', 'DemoAudio', 'demoaudio', 'book_1568787874.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', 'audio_1568787874.mp3', '', '21', 0, '2019-09-17 00:00:00', '2019-09-18 06:24:34'),
(6, '1', '1', 'pdf', 'pdf', 'book_1568801587.jpg', 'fswdsdsdsd sdhs did sydsi dsidys dsiuyd iusydis dsyds sdysud sd', 'vansh', '', '', '', 'document_1568801587.pdf', '9', 0, '2019-09-18 00:00:00', '2019-09-18 10:13:07'),
(7, '1', '1', 'dfdfdf', 'dfdfdf', 'book_1568806389.jpg', 'fdfd', 'dfdfdf', '', '', '', 'document_1568806389.pdf', '1', 0, '2019-09-18 00:00:00', '2019-09-18 11:33:09'),
(8, '1', '1', 'ffggfg', 'ffggfg', 'book_1568807811.jpg', 'fgfgfgffg', 'fgfgfgf', '', '', '', 'document_1568807811.docx', '6', 0, '2019-09-18 00:00:00', '2019-09-18 11:56:51'),
(9, '1', '2', 'DemoVVV', 'demovvv', 'book_1568808176.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', '', 'document_1568808176.mp4', '7', 0, '2019-09-18 00:00:00', '2019-09-18 12:02:56'),
(10, '1', '1', 'dddd', 'dddd', 'book_1568810042.jpg', 'dddd', 'dddd', '', 'video_1568810042.mp4', '', 'document_1568810042.pdf', '3', 0, '2019-09-18 00:00:00', '2019-09-18 12:34:02'),
(11, '1', '1', 'pppp', 'pppp', 'book_1568811555.jpg', 'dhfgdfgd', 'dfdfdf', '', 'video_1568811555.mp4', '', 'document_1568811555.pdf', '0', 0, '2019-09-18 00:00:00', '2019-09-18 12:59:15'),
(12, '1', '1', 'vbvb', 'vbvb', 'book_1568812725.jpg', 'vbvb', 'vbvb', '', 'video_1568812725.mp4', '', 'document_1568812725.pdf', '0', 0, '2019-09-18 00:00:00', '2019-09-18 13:18:45'),
(13, '1', '1', 'rerttr', 'rerttr', 'book_1568813666.jpg', 'rtrtrt', 'rtrtrtr', '', 'video_1568813666.mp4', '', 'document_1568813666.pdf', '2', 0, '2019-09-18 00:00:00', '2019-09-18 13:34:26'),
(14, '1', '2', 'dffdfdf', 'dffdfdf', 'book_1568813929.jpg', 'fdfdfd', 'fdfdfd', '', 'video_1568813929.mp4', '', 'document_1568813929.pdf', '2', 0, '2019-09-18 00:00:00', '2019-09-18 13:38:49'),
(15, '1', '0', 'fadads', 'fadads', 'book_1568874873.jpg', 'sdfsdfdsf', 'dfdfdssre', '', 'video_1568874873.mp4', '', 'document_1568874873.pdf', '0', 0, '2019-09-18 00:00:00', '2019-09-19 06:34:33'),
(16, '1', '1', 'gyytyty', 'gyytyty', 'book_1568875071.jpg', 'retrtertr rer', 'rtr RT r', '', 'video_1568875071.mp4', '', 'document_1568875071.pdf', '1', 0, '2019-09-18 00:00:00', '2019-09-19 06:37:51'),
(17, '1', '1', 'dfdfeeeeee', 'dfdfeeeeee', 'book_1568876297.jpg', 'dfdfdfse', 'eeeee', '', 'video_1568876297.mp4', 'audio_1568876297.mp3', 'document_1568876297.pdf', '0', 0, '2019-09-18 00:00:00', '2019-09-19 06:58:17'),
(18, '1', '1', 'fdf', 'fdf', 'book_1568880110.jpg', 'ffdfd', 'dfdf', '', 'video_1568880110.mp4', 'audio_1568880110.mp3', '', '2', 0, '2019-09-19 00:00:00', '2019-09-19 08:01:50'),
(19, '1', '1', 'sdsd', 'sdsd', 'book_1568880443.jpg', 'sdsd', 'sdsdsd', '', 'video_1568880443.mp4', 'audio_1568880443.mp3', '', '3', 0, '2019-09-19 00:00:00', '2019-09-19 08:07:23'),
(20, '1', '1', 'book', 'book', 'book_1568885928.jpg', 'book', 'book', '', 'video_1568885928.mp4', 'audio_1568885928.mp3', '', '29', 0, '2019-09-19 00:00:00', '2019-09-19 09:38:48'),
(21, '1', '1', 'ww', 'ww', 'book_1568889890.jpg', 'ww', 'ww', '', 'video_1568889890.mp4', '', '', '1', 0, '2019-09-19 00:00:00', '2019-09-19 10:44:50'),
(22, '1', '1', 'ERR', 'err', 'book_1568890041.jpg', 'RRR', 'RRR', '', '', 'audio_1568890041.mp3', '', '1', 0, '2019-09-19 00:00:00', '2019-09-19 10:47:21'),
(23, '1', '1', 'TYTY', 'tyty', 'book_1568890166.jpg', 'TYTYT', 'TYT', '', 'video_1568890166.mp4', 'audio_1568890166.mp3', '', '1', 0, '2019-09-19 00:00:00', '2019-09-19 10:49:26'),
(24, '1', '2', 'GUU', 'guu', 'book_1568890593.jpg', 'UUU', 'UUU', '', '', '', '', '8', 0, '2019-09-19 00:00:00', '2019-09-19 10:56:33'),
(25, '1', '1', 'fgfg', 'fgfg', 'book_1568896239.jpg', 'fgfgf', 'fgfgfg', '', 'video_1568896239.mp4', '', '', '1', 0, '2019-09-19 00:00:00', '2019-09-19 12:30:39');

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
(2, '1', NULL, 'jkkfg KJ ', '1', '2019-09-18 06:34:05', '2019-09-18 06:34:05'),
(3, '1', NULL, 'sssssss', '1', '2019-09-18 09:11:17', '2019-09-18 09:11:17');

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
(1, '1', '1', 'ttter ', '2.5', '1', '2019-09-19 13:00:15', '2019-09-19 13:12:10'),
(2, '3', '1', 'new data', '4.0', '1', '2019-09-19 13:00:41', '2019-09-19 13:02:40'),
(3, '1', '5', 'tt', '3.5', '1', '2019-09-19 13:12:38', '2019-09-19 13:12:48'),
(4, '1', '3', 'gg', '2.5', '1', '2019-09-19 13:13:12', '2019-09-19 13:13:12'),
(5, '3', '24', 'nice', '2.5', '1', '2019-09-19 13:44:29', '2019-09-19 13:44:29'),
(6, '3', '5', 'Something is good ðŸ˜ŠðŸ‘', '4.0', '1', '2019-09-19 13:50:03', '2019-09-19 13:50:03'),
(7, '3', '3', 'wao what a book', '4.0', '1', '2019-09-19 13:51:30', '2019-09-19 13:51:30'),
(8, '5', '1', 'something look nice..', '3.5', '1', '2019-09-19 13:55:03', '2019-09-19 13:55:03'),
(9, '5', '4', 'good book for reading..', '4.0', '1', '2019-09-19 13:56:12', '2019-09-19 13:56:12'),
(10, '5', '20', 'so nice ðŸ˜ðŸ‘Œ', '3.0', '1', '2019-09-19 13:57:34', '2019-09-19 13:57:34'),
(11, '3', '20', 'very very well ðŸ‘ðŸ˜€ðŸ˜€', '3.0', '1', '2019-09-19 14:02:04', '2019-09-19 14:02:04');

-- --------------------------------------------------------

--
-- Table structure for table `user_login_table`
--

CREATE TABLE `user_login_table` (
  `id` bigint(20) NOT NULL,
  `register_id` varchar(200) NOT NULL,
  `full_name` varchar(400) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `user_name` varchar(250) DEFAULT NULL,
  `url` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `about_me` varchar(300) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `confirmation_key` varchar(1000) NOT NULL,
  `date_added` int(11) DEFAULT NULL,
  `date_edited` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `message_status` varchar(255) NOT NULL DEFAULT '1',
  `publisher_type` varchar(255) NOT NULL DEFAULT '0' COMMENT '0-reader,1-writer,2-reader-writer,3-publisher',
  `device_token` text NOT NULL,
  `device_type` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `thumb_image` varchar(500) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `global_posting` varchar(255) NOT NULL DEFAULT '1' COMMENT '1-local,0-global'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_table`
--

INSERT INTO `user_login_table` (`id`, `register_id`, `full_name`, `user_name`, `url`, `email`, `gender`, `phone_no`, `about_me`, `country`, `password`, `confirmation_key`, `date_added`, `date_edited`, `status`, `message_status`, `publisher_type`, `device_token`, `device_type`, `address`, `thumb_image`, `createdAt`, `global_posting`) VALUES
(1, '635454', '', 'VAnsh', 'pic_1568886074.jpg', 'chaudhary.vanshraj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568785680, 1, '1', 'Writer', '', '', '', '', '2019-09-18 05:48:00', '1'),
(2, '711012', '', 'Vansh raj', 'pic_1568788260.', 'vansh1996raj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568788260, 1, '1', 'Reader', '', '', '', '', '2019-09-18 06:31:00', '1'),
(3, '691577', '', 'Shyam Soft', 'pic_1568891923.', 'shyamsoft38@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568891923, 1, '1', 'Reader', '', '', '', '', '2019-09-19 11:18:43', '1'),
(4, '405941', '', 'rr', 'pic_1568895911.', 'rr', 'male', '', 'rrr', 'rr', 'cnI=', '', NULL, 1568895911, 1, '1', 'Writer', '', '', '', '', '2019-09-19 12:25:11', '1'),
(5, '321220', '', 'RajAmit', 'pic_1568901241.', 'amt94001@gmail.com', 'male', '', 'simple ', 'india', 'MTIzNDU2', '', NULL, 1568901241, 1, '1', 'Reader and Writer', '', '', '', '', '2019-09-19 13:54:01', '1');

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
-- AUTO_INCREMENT for table `tbl_bookmark`
--
ALTER TABLE `tbl_bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
-- AUTO_INCREMENT for table `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
