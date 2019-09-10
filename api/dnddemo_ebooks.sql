-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 10, 2019 at 02:03 PM
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
  `bookMark` varchar(255) DEFAULT NULL,
  `mostView` varchar(255) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `user_id`, `category_id`, `book_title`, `book_slug`, `thubm_image`, `book_description`, `author_name`, `book_image`, `video_url`, `audio_url`, `pdf_url`, `bookMark`, `mostView`, `status`, `created_at`, `updated_at`) VALUES
(1, '12', '1', 'Test book', 'test book', 'book_1567857479.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the ', 'Raj Amit', NULL, NULL, NULL, '', NULL, '0', 1, '2019-09-07 00:00:00', '2019-09-07 11:57:59'),
(2, '12', '1', 'Test book', 'test book', 'book_1567861435.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the ', 'Raj Amit', 'gallery_1567861435.jpg', 'video_1567861435.mp4', 'audio_1567861435.mp3', 'document_1567861435.docx', NULL, '0', 1, '2019-09-07 00:00:00', '2019-09-07 13:03:55'),
(3, '1', '1', 'video', 'video', 'book_1568007056.', '', '', 'gallery_1568007056.', 'video_1568007056.mp4', 'audio_1568007056.', 'document_1568007056.', NULL, '0', 1, '2019-09-08 00:00:00', '2019-09-09 05:30:56'),
(4, '1', '0', 'video', 'video', 'book_1568008965.', '', '', 'gallery_1568008965.', 'video_1568008966.mp4', 'audio_1568008965.', 'document_1568008965.', NULL, '0', 1, '2019-09-08 00:00:00', '2019-09-09 06:02:46'),
(5, '1', 'music', 'video', 'video', 'book_1568025083.', '', '', 'gallery_1568025083.png', 'video_1568025083.', 'audio_1568025083.', 'document_1568025083.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:31:23'),
(6, '1', '1', 'book', 'book', 'book_1568025164.', '', '', 'gallery_1568025164.jpg', 'video_1568025164.', 'audio_1568025164.', 'document_1568025164.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:32:44'),
(7, '1', '1', 'book', 'book', 'book_1568025500.', '', '', 'gallery_1568025500.jpg', 'video_1568025500.', 'audio_1568025500.', 'document_1568025500.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:38:20'),
(8, '1', '1', 'book', 'book', 'book_1568025578.', '', '', 'gallery_1568025578.jpg', 'video_1568025578.', 'audio_1568025578.', 'document_1568025578.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:39:38'),
(9, '1', '1', 'book', 'book', 'book_1568025635.', '', '', 'gallery_1568025635.jpg', 'video_1568025635.', 'audio_1568025635.', 'document_1568025635.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:40:35'),
(10, '1', '1', 'book', 'book', 'book_1568026354.', '', '', 'gallery_1568026354.jpg', 'video_1568026354.', 'audio_1568026354.', 'document_1568026354.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 10:52:34'),
(11, '1', '1', 'book', 'book', 'book_1568028268.', '', '', 'gallery_1568028268.jpg', 'video_1568028268.', 'audio_1568028268.', 'document_1568028268.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 11:24:28'),
(12, '1', '1', 'book', 'book', 'book_1568030373.jpg', '', '', 'gallery_1568030373.', 'video_1568030373.', 'audio_1568030373.', 'document_1568030373.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 11:59:33'),
(13, '1', '1', 'book', 'book', 'book_1568030398.jpg', '', '', 'gallery_1568030398.', 'video_1568030398.', 'audio_1568030398.', 'document_1568030398.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 11:59:58'),
(14, '1', '1', 'book', 'book', 'book_1568034523.jpg', '', '', 'gallery_1568034523.', 'video_1568034523.', 'audio_1568034523.', 'document_1568034523.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 13:08:43'),
(15, '1', '1', 'book', 'book', 'book_1568034696.jpg', '', '', 'gallery_1568034696.', 'video_1568034696.', 'audio_1568034696.', 'document_1568034696.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-09 13:11:36'),
(16, '1', '2', 'music', 'music', 'book_1568094479.jpg', 'did. her voice wrw email erw. ', '', 'gallery_1568094479.', 'video_1568094479.', 'audio_1568094479.', 'document_1568094479.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-10 05:47:59'),
(17, '1', '2', 'ETG', 'etg', 'book_1568094565.jpg', 'ETGQ ETWvga ert to. ', '', 'gallery_1568094565.', 'video_1568094565.', 'audio_1568094565.', 'document_1568094565.', NULL, '0', 1, '2019-09-09 00:00:00', '2019-09-10 05:49:25'),
(18, '1', '2', 'ETG', 'etg', 'book_1568094639.jpg', 'ETGQ ETWvga ert to. ', '', 'gallery_1568094639.', 'video_1568094639.', 'audio_1568094639.', 'document_1568094639.', '0', '0', 1, '2019-09-09 00:00:00', '2019-09-10 12:27:29');

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
  `status` tinyint(1) NOT NULL DEFAULT '0',
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
(1, '318527', '', 'VAnsh', 'pic_1568111814.jpg', 'chaudhary.vanshraj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568028117, 0, '1', 'Writer', '', '', '', '', '2019-09-09 11:21:57', '1'),
(2, '847942', '', 'Vansh raj', 'pic_1568108462.', 'vansh1996raj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1568108462, 0, '1', 'Writer', '', '', '', '', '2019-09-10 09:41:02', '1'),
(3, '675018', '', 'dfd', 'pic_1568110414.', 'dfdf', 'male', '', '', 'df', 'ZmRm', '', NULL, 1568110414, 0, '1', 'Writer', '', '', '', '', '2019-09-10 10:13:34', '1'),
(4, '925860', '', 'fgg', 'pic_1568110461.', 'g', 'male', '', '', 'gfgf', 'Z2Zn', '', NULL, 1568110461, 0, '1', 'Reader', '', '', '', '', '2019-09-10 10:14:21', '1'),
(5, '103969', '', 'dgdgdggdfgdfdsfd', 'pic_1568110536.', 'sdsf', 'male', '', '', 'sf', 'c2ZkZg==', '', NULL, 1568110536, 0, '1', 'Reader', '', '', '', '', '2019-09-10 10:15:36', '1'),
(6, '286303', '', 'errer', 'pic_1568110964.jpg', 'frsdfsdf', 'male', '', '', 'sdfd', 'c2Rmc2Rmc2Zz', '', NULL, 1568110911, 0, '1', 'Writer', '', '', '', '', '2019-09-10 10:21:51', '1');

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
-- AUTO_INCREMENT for table `tbl_books`
--
ALTER TABLE `tbl_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
