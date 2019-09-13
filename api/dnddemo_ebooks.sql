-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 13, 2019 at 01:19 PM
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
(1, '6', '14', '1', '2019-09-12 09:54:08', '2019-09-12 10:14:49'),
(2, '7', '14', '0', '2019-09-12 10:16:30', '2019-09-12 12:17:30'),
(3, '7', '13', '0', '2019-09-12 10:17:14', '2019-09-12 12:35:57'),
(4, '1', '14', '0', '2019-09-12 12:39:40', '2019-09-13 12:10:25'),
(5, '1', '13', '0', '2019-09-12 12:40:14', '2019-09-13 12:07:41'),
(6, '1', '7', '0', '2019-09-13 05:08:21', '2019-09-13 11:45:27');

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
(1, '1', '2', 'Test book ', 'test book ', '', 'Test book ', 'Amit Kumar', 'gallery_1568181187.jpg', '', '', '', '0', 1, '2019-09-10 00:00:00', '2019-09-11 05:53:07'),
(2, '1', '1', 'videofdjfdgf jsdfw ', 'videofdjfdgf jsdfw ', '', '', '', 'gallery_1568181396.png', '', '', '', '0', 1, '2019-09-10 00:00:00', '2019-09-11 07:21:01'),
(3, '1', '1', 'videofdjfdgf jsdfw ', 'videofdjfdgf jsdfw ', '', '', '', 'gallery_1568181717.png', '', '', '', '0', 0, '2019-09-10 00:00:00', '2019-09-11 10:38:29'),
(4, '1', '2', 'videofdjfdgf jsdfw ', 'videofdjfdgf jsdfw ', '', '', '', 'gallery_1568181722.png', '', '', '', '0', 0, '2019-09-10 00:00:00', '2019-09-11 06:02:02'),
(5, '1', '2', 'Test book  fdf', 'test book  fdf', '', 'Test book  fdf', 'Amit Kumar', 'gallery_1568182149.jpg', '', '', '', '0', 0, '2019-09-10 00:00:00', '2019-09-11 06:09:09'),
(6, '1', '1', 'video', 'video', '', '', '', 'gallery_1568185152.png', '', '', '', '0', 0, '2019-09-10 00:00:00', '2019-09-11 06:59:12'),
(7, '1', '1', 'video', 'video', 'book_1568185184.png', '', '', 'gallery_1568185184.png', '', '', '', '0', 0, '2019-09-10 00:00:00', '2019-09-11 06:59:44'),
(8, '1', '1', 'music', 'music', 'book_1568186185.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', '', '', '0', 0, '2019-09-11 00:00:00', '2019-09-11 07:16:25'),
(9, '1', '2', 'Demo', 'demo', 'book_1568186216.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', '', '', '0', 0, '2019-09-11 00:00:00', '2019-09-11 07:16:56'),
(10, '6', '1', 'Demo', 'demo', 'book_1568186225.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', '', '', '', '0', 0, '2019-09-11 00:00:00', '2019-09-11 07:25:52'),
(11, '1', '1', 'Video book', 'video book', 'book_1568187287.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568187287.mp4', '', '', '0', 0, '2019-09-11 00:00:00', '2019-09-11 08:53:38'),
(12, '6', '1', 'docbook', 'docbook', 'book_1568188327.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568188327.mp4', '', 'document_1568188327.docx', '0', 0, '2019-09-11 00:00:00', '2019-09-11 07:52:07'),
(13, '1', '1', 'Demo Full', 'demo full', 'book_1568196455.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568196455.mp4', 'audio_1568196455.mp3', 'document_1568196455.docx', '0', 0, '2019-09-11 00:00:00', '2019-09-11 10:07:35'),
(14, '6', '1', 'Demopdf', 'demopdf', 'book_1568196915.png', 'ontrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 'Vansh', '', 'video_1568196915.mp4', 'audio_1568196915.mp3', 'document_1568196915.pdf', '0', 0, '2019-09-11 00:00:00', '2019-09-11 13:08:46');

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
(1, '8', 'Payment account', 'Test payment', '1', '2019-09-13 12:23:25', '2019-09-13 12:23:25'),
(2, '8', 'Payment account', 'Test payment', '1', '2019-09-13 12:37:15', '2019-09-13 12:37:15'),
(3, '6', '', 'gshyd jsduy  sdgy jsdg sdhg hdf hdf uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:37:25', '2019-09-13 12:37:25'),
(4, '6', '', 'gshyd jsduy  sdgy jsdg sdhg hdf hdf uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:37:39', '2019-09-13 12:37:39'),
(5, '6', '', 'gshyd jsduy  sdgy jsdg sdhg hdf hdf uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:37:40', '2019-09-13 12:37:40'),
(6, '6', '', 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:37:45', '2019-09-13 12:37:45'),
(7, '6', '', 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:37:47', '2019-09-13 12:37:47'),
(8, '6', '', 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 12:38:01', '2019-09-13 12:38:01'),
(9, '1', '', 'this is from,of r to the try yaqe yeq. artrt r to RT RT RT RT r', '1', '2019-09-13 12:44:03', '2019-09-13 12:44:03'),
(10, '1', NULL, 'sdfgsdfsdf dfsdf', '1', '2019-09-13 13:12:30', '2019-09-13 12:46:56'),
(11, '1', NULL, '', '1', '2019-09-13 12:47:16', '2019-09-13 12:47:16'),
(12, '1', NULL, '', '1', '2019-09-13 12:47:26', '2019-09-13 12:47:26'),
(13, '1', NULL, '', '1', '2019-09-13 12:48:10', '2019-09-13 12:48:10'),
(14, '1', NULL, 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 13:14:02', '2019-09-13 13:14:02'),
(15, '1', NULL, 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 13:14:04', '2019-09-13 13:14:04'),
(16, '1', NULL, 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 13:14:05', '2019-09-13 13:14:05'),
(17, '1', NULL, 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 13:14:06', '2019-09-13 13:14:06'),
(18, '1', NULL, 'gshyd js uyyut ed yskdj yew wy euyi werwer iuyri iuriey ier iyr g ers wer tt wr55 gfg srtt rt trwe 564 gfhhh', '1', '2019-09-13 13:14:06', '2019-09-13 13:14:06'),
(19, '1', NULL, 'etrtrt terwerertrt ett ', '1', '2019-09-13 13:16:14', '2019-09-13 13:16:14'),
(20, '1', NULL, 'rtyyrt ert ryr yrweyt ', '1', '2019-09-13 13:16:32', '2019-09-13 13:16:32'),
(21, '1', NULL, 'rtyyrt ert ryr yrweyt ', '1', '2019-09-13 13:16:44', '2019-09-13 13:16:44'),
(22, '1', NULL, 'rtrtt', '1', '2019-09-13 13:17:04', '2019-09-13 13:17:04');

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
(1, '318527', '', 'VAnsh', 'pic_1568375460.jpg', 'chaudhary.vanshraj@gmail.com', '', '', 'vjj', 'India', 'IA==', '', NULL, 1568028117, 1, '1', 'Writer', '', '', '', '', '2019-09-09 11:21:57', '1'),
(2, '847942', '', 'Vansh raj', 'pic_1568108462.', 'vansh1996raj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568108462, 1, '1', 'Writer', '', '', '', '', '2019-09-10 09:41:02', '1'),
(3, '675018', '', 'dfd', 'pic_1568110414.', 'dfdf', 'male', '', '', 'df', 'ZmRm', '', NULL, 1568110414, 1, '1', 'Writer', '', '', '', '', '2019-09-10 10:13:34', '1'),
(4, '925860', '', 'fgg', 'pic_1568110461.', 'g', 'male', '', '', 'gfgf', 'Z2Zn', '', NULL, 1568110461, 1, '1', 'Reader', '', '', '', '', '2019-09-10 10:14:21', '1'),
(5, '103969', '', 'dgdgdggdfgdfdsfd', 'pic_1568110536.', 'sdsf', 'male', '', '', 'sf', 'c2ZkZg==', '', NULL, 1568110536, 1, '1', 'Reader', '', '', '', '', '2019-09-10 10:15:36', '1'),
(6, '286303', '', 'errer', 'pic_1568110964.jpg', 'frsdfsdf', 'male', '', '', 'sdfd', 'c2Rmc2Rmc2Zz', '', NULL, 1568110911, 0, '1', 'Writer', '', '', '', '', '2019-09-10 10:21:51', '1'),
(7, '313076', '', 'sdd', 'pic_1568288403.jpg', 'dddd', 'male', '', 'dddddrtrt. rrtr RT ', 'ddd', 'ZGRk', '', NULL, 1568282898, 1, '1', 'Writer', '', '', '', '', '2019-09-12 10:08:18', '1'),
(8, '326988', '', 'demo', 'pic_1568367995.', 'dfdfW@gmail.com', 'male', '', 'this is demo', 'ddd', 'ZGQ=', '', NULL, 1568367995, 1, '1', 'Publish House', '', '', '', '', '2019-09-13 09:46:35', '1');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_note`
--
ALTER TABLE `tbl_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
