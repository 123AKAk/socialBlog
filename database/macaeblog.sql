-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2023 at 05:50 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `macaeblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `verified` int(11) NOT NULL DEFAULT 0,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `password`, `date_created`, `date_updated`, `status`, `verified`, `role`) VALUES
(1, 'Macae Admin', 'admin@admin.com', '$2y$10$hGrLcW.ttxLKZZHntKdFhO2JnD7i4JzApMAueiKm6aN7rY.EqmN.i', '2023-02-07 13:02:48', '2023-02-07 13:02:48', 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `ad_name` varchar(10) NOT NULL,
  `ad_desc` text NOT NULL,
  `ad_url` text NOT NULL,
  `ad_thumbnail` text NOT NULL,
  `country` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ad_id`, `ad_name`, `ad_desc`, `ad_url`, `ad_thumbnail`, `country`, `status`, `date_created`) VALUES
(1, 'eyo', 'dsdfghhgfdsasdfghjhgfdsasfghjjhgfdsZxcvbnm,mnbvcxxcvbnm,.,mnbvcxzxcvbnm,.,mnb', '', 'sasa', 0, 0, '2023-02-06 16:27:51');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` text NOT NULL,
  `category_desc` text NOT NULL,
  `category_creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `category_update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_desc`, `category_creation_date`, `category_update_date`, `status`) VALUES
(1, 'Tech', 'All about Tech news', '2023-02-05 00:00:00', '2023-02-05 00:00:00', 0),
(2, 'Tech', 'All about Tech news', '2023-02-05 00:00:00', '2023-02-05 00:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comments_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `country_id` int(11) NOT NULL,
  `country_name` text NOT NULL,
  `ip_address` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`country_id`, `country_name`, `ip_address`, `status`) VALUES
(1, 'Nigeria', '12121', 0),
(2, 'England', '2323232', 0),
(3, 'Ghana', '323212121', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dblog`
--

CREATE TABLE `dblog` (
  `id` int(11) NOT NULL,
  `event` text NOT NULL,
  `table_name` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `event_desc` text NOT NULL,
  `date_logged` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `point` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_title` text NOT NULL,
  `post_contents` text NOT NULL,
  `post_thumbnail` text NOT NULL,
  `post_creation_time` datetime NOT NULL DEFAULT current_timestamp(),
  `post_update_date` datetime NOT NULL DEFAULT current_timestamp(),
  `id_category` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `post_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_title`, `post_contents`, `post_thumbnail`, `post_creation_time`, `post_update_date`, `id_category`, `id_admin`, `id_user`, `post_status`) VALUES
(1, 'The Art of Man Version 2', 'The documentation for the JavaScript library Dropzone.\r\nDropzone is a simple JavaScript library that helps you add file drag and drop functionality to your web forms. It is one of the most popular drag and drop library on the web and is used by millions of people.\r\nThere are many configuration options, so Dropzone can be used in a variety of situations.\r\nSome of Dropzone\'s highlights are:\r\nBeautiful by default.\r\nImage thumbnail previews. Simply register the callback thumbnail(file, data)\r\nand display the image wherever you like\r\nProgress Bars\r\nRetina enabled\r\nMultiple files and synchronous uploads\r\nSupport for large files\r\nChunked uploads (single files can be uploaded as chunks in multiple HTTP requests)\r\nComplete theming. The look and feel of Dropzone is just the default theme. You\r\ncan define everything yourself by overwriting the default event listeners.\r\nBrowser image resizing (resize the images before you upload them to your\r\nserver)\r\nWell tested', 'apc.jpg', '2023-02-05 00:00:00', '2023-02-05 00:00:00', 1, 1, 0, 0),
(2, 'The other Side of Eyo', 'Eyo just loves feeling good, it\'s not his fault tho.\r\n\r\nJust try to pity him sometimes \r\n\r\nIt is not easy at all', 'eyo.jpg', '2023-02-05 00:00:00', '2023-02-05 00:00:00', 0, 0, 0, 0),
(3, 'dsds', 'dsds', 'dsds', '2023-02-06 15:44:59', '0000-00-00 00:00:00', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rssfeed`
--

CREATE TABLE `rssfeed` (
  `rss_id` int(11) NOT NULL,
  `rss_name` varchar(10) NOT NULL,
  `rss_url` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rssfeed`
--

INSERT INTO `rssfeed` (`rss_id`, `rss_name`, `rss_url`, `status`) VALUES
(1, 'Sport ', 'https://stackoverflow.com/questions/15992085/html-select-drop-down-with-an-input-field', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subscribed_emails`
--

CREATE TABLE `subscribed_emails` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `verified_status` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribed_emails`
--

INSERT INTO `subscribed_emails` (`id`, `name`, `email`, `verified_status`, `date_created`) VALUES
(1, 'James', 'james@gmail.com', 0, '2023-02-06 16:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `password` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0,
  `saved_posts` text NOT NULL,
  `user_ip_address` text NOT NULL,
  `user_country` text NOT NULL,
  `authors_followed` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `gender`, `password`, `date_created`, `date_updated`, `status`, `saved_posts`, `user_ip_address`, `user_country`, `authors_followed`) VALUES
(1, 'Favour', 'favour@gmail.com', '', '123', '2023-02-06 16:14:00', '2023-02-06 17:10:54', 0, '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comments_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `dblog`
--
ALTER TABLE `dblog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `rssfeed`
--
ALTER TABLE `rssfeed`
  ADD PRIMARY KEY (`rss_id`);

--
-- Indexes for table `subscribed_emails`
--
ALTER TABLE `subscribed_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comments_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dblog`
--
ALTER TABLE `dblog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rssfeed`
--
ALTER TABLE `rssfeed`
  MODIFY `rss_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribed_emails`
--
ALTER TABLE `subscribed_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
