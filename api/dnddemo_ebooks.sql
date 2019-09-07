-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2019 at 01:20 PM
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
  `user_id` int(10) DEFAULT NULL,
  `category_id` int(10) DEFAULT NULL,
  `book_title` varchar(255) DEFAULT NULL,
  `book_slug` varchar(255) DEFAULT NULL,
  `thubm_image` varchar(255) DEFAULT NULL,
  `book_description` text,
  `author_name` varchar(255) DEFAULT NULL,
  `book_image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `pdf_url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_books`
--

INSERT INTO `tbl_books` (`id`, `user_id`, `category_id`, `book_title`, `book_slug`, `thubm_image`, `book_description`, `author_name`, `book_image`, `video_url`, `audio_url`, `pdf_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 'Test book', 'test book', 'book_1567857479.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the ', 'Raj Amit', NULL, NULL, NULL, '', 1, '2019-09-07 00:00:00', '2019-09-07 11:57:59'),
(2, 12, 1, 'Test book', 'test book', 'book_1567861435.jpg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the ', 'Raj Amit', 'gallery_1567861435.jpg', 'video_1567861435.mp4', 'audio_1567861435.mp3', 'document_1567861435.docx', 1, '2019-09-07 00:00:00', '2019-09-07 13:03:55');

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
  `global_posting` varchar(255) NOT NULL DEFAULT '1' COMMENT '1-local,0-global'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login_table`
--

INSERT INTO `user_login_table` (`id`, `register_id`, `full_name`, `user_name`, `url`, `email`, `gender`, `phone_no`, `about_me`, `country`, `password`, `confirmation_key`, `date_added`, `date_edited`, `status`, `message_status`, `publisher_type`, `device_token`, `device_type`, `address`, `thumb_image`, `global_posting`) VALUES
(1, '334355', '', 'VAnsh', 'pic_1567839999.', 'chaudhary.vanshraj@gmail.com', '', '', '', '', 'IA==', '', NULL, 1567839999, 0, '1', 'Reader', '', '', '', '', '1'),
(2, '579648', 'Amit Kumar', 'AMIT123457', 'pic_1567847134.jpg', 'todayamit4@gmail.com', 'male', '9015135215', '', 'us', 'QW1pdEAxMjM0NTY3ODk=', '', NULL, 1567841152, 0, '1', 'writer', '', '', 'A 82', '', '1'),
(3, '869731', '', 'dd', 'pic_1567848148.', 'dd', 'male', '', '', '', 'ZGQ=', '', NULL, 1567848148, 0, '1', 'Writer', '', '', '', '', '1'),
(4, '596611', '', 'ssddf', 'pic_1567851947.', 'fffff', 'male', '', '', '', 'cXFx', '', NULL, 1567851947, 0, '1', 'Publish House', '', '', '', '', '1'),
(5, '320546', '', 'dfsdf', 'pic_1567852178.', 'sff', 'male', '', '', '', 'c2RzZHM=', '', NULL, 1567852178, 0, '1', 'Writer', '', '', '', '', '1'),
(6, '512329', '', 'fwdcdaaaa', 'pic_1567852213.', 'ddfaa', '', '', '', '', 'dmFuc2gxMjNh', '', NULL, 1567852213, 0, '1', 'writer', '', '', '', '', '1'),
(7, '706329', '', 'sd', 'pic_1567852437.', 'ss', 'male', '', '', '', 'c3M=', '', NULL, 1567852437, 0, '1', 'Reader', '', '', '', '', '1'),
(8, '963748', '', 'sdsd', 'pic_1567852592.', 'sdd@gmail.com', 'male', '', '', '', 'c2RzZA==', '', NULL, 1567852592, 0, '1', 'Reader', '', '', '', '', '1'),
(9, '692501', '', 'ZXzxx', 'pic_1567852774.', 'xx', 'male', '', '', '', 'eHh4', '', NULL, 1567852774, 0, '1', 'Reader', '', '', '', '', '1'),
(10, '108555', '', 'ssfX', 'pic_1567852882.', 'ssff', 'male', '', '', '', 'c3M=', '', NULL, 1567852882, 0, '1', 'Reader', '', '', '', '', '1'),
(11, '999009', '', 'yrt', 'pic_1567853113.', 'yu', 'male', '', '', 'India', 'MTIz', '', NULL, 1567853113, 0, '1', 'Reader and Writer', '', '', '', '', '1'),
(12, '178391', 'Amit Kumar', 'AMIT123457', 'pic_1567853709.jpg', 'shyamsoft38@gmail.com', 'male', '9015135215', '', 'india', 'QW1pdEAxMjM0NTY=', '', NULL, 1567853709, 0, '1', 'Reader', '', '', '', '', '1'),
(13, '698006', '', 'Vansh raj', 'pic_1567854224.', 'vansh1996raj@gmail.com', '', '', '', '', 'MTIz', '', NULL, 1567854224, 0, '1', 'Writer', '', '', '', '', '1'),
(14, '475401', '', 'drtg', 'pic_1567854786.', 'fggf', 'male', '', '', 'india', 'ZXJlZg==', '', NULL, 1567854786, 0, '1', 'Writer', '', '', '', '', '1'),
(15, '848168', '', 'ererr', 'pic_1567854865.', 'rer', 'male', '', '', 'rrrr', 'ZXI=', '', NULL, 1567854865, 0, '1', 'Writer', '', '', '', '', '1');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_login_table`
--
ALTER TABLE `user_login_table`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
