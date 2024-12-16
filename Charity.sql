-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 13, 2024 at 01:12 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Charity`
--

-- --------------------------------------------------------

--
-- Table structure for table `Charity`
--

CREATE TABLE `Charity` (
  `id` int(11) NOT NULL,
  `campTitle` varchar(255) NOT NULL,
  `campDesc` text NOT NULL,
  `orgName` varchar(255) NOT NULL,
  `targetGoal` decimal(10,2) NOT NULL,
  `achievedGoal` decimal(10,2) DEFAULT 0.00,
  `challenges` text DEFAULT NULL,
  `solutions` text DEFAULT NULL,
  `photo_paths` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Charity`
--

INSERT INTO `Charity` (`id`, `campTitle`, `campDesc`, `orgName`, `targetGoal`, `achievedGoal`, `challenges`, `solutions`, `photo_paths`, `created_at`, `updated_at`) VALUES
(1, 'Save the Rainforest', 'Join in our mission to protect the Amazon rainforest from deforestation. The Amazon is not just a forest; it’s a vital ecosystem that supports countless species of flora and fauna, many of which are found nowhere else on Earth. Deforestation due to logging, agriculture, and urbanization poses a grave threat to this unique environment. Our campaign aims to raise awareness and funds to combat these destructive practices. We believe that every dollar counts, and together we can make a significant impact in preserving this crucial part of our planet for future generations.', 'Helping Hands Charity', 500000.00, 42000.00, 'The primary challenges we face include rampant deforestation caused by illegal logging and agricultural expansion. These activities not only destroy vast areas of forest but also disrupt the delicate balance of the ecosystem. Additionally, our organization struggles with limited resources to effectively monitor and protect these areas from poachers and illegal land developers. Raising awareness about the importance of the rainforest and encouraging sustainable practices within local communities is crucial to overcoming these challenges.', 'Our proposed solutions involve a multi-faceted approach. Firstly, we plan to implement reforestation projects that involve local communities in planting native trees to restore damaged areas. Secondly, we will conduct educational outreach programs to inform residents about sustainable agricultural practices that can be adopted to reduce reliance on deforestation. Furthermore, we aim to collaborate with local authorities to strengthen law enforcement against illegal logging activities. By working together with the community, we can create a sustainable environment that benefits both the people and the rainforest.', 'uploads/campaigns/IMG-67524c9a8f8836.77348307.jpeg', '2024-12-06 01:00:10', '2024-12-13 09:40:54'),
(2, 'Clean Up the Ocean', 'Join in our mission to protect the Amazon rainforest from deforestation. The Amazon is not just a forest; it’s a vital ecosystem that supports countless species of flora and fauna, many of which are found nowhere else on Earth. Deforestation due to logging, agriculture, and urbanization poses a grave threat to this unique environment. Our campaign aims to raise awareness and funds to combat these destructive practices. We believe that every dollar counts, and together we can make a significant impact in preserving this crucial part of our planet for future generations.', 'Helping Hands Charity', 500000.00, 0.00, 'The primary challenges we face include rampant deforestation caused by illegal logging and agricultural expansion. These activities not only destroy vast areas of forest but also disrupt the delicate balance of the ecosystem. Additionally, our organization struggles with limited resources to effectively monitor and protect these areas from poachers and illegal land developers. Raising awareness about the importance of the rainforest and encouraging sustainable practices within local communities is crucial to overcoming these challenges.', 'Our proposed solutions involve a multi-faceted approach. Firstly, we plan to implement reforestation projects that involve local communities in planting native trees to restore damaged areas. Secondly, we will conduct educational outreach programs to inform residents about sustainable agricultural practices that can be adopted to reduce reliance on deforestation. Furthermore, we aim to collaborate with local authorities to strengthen law enforcement against illegal logging activities. By working together with the community, we can create a sustainable environment that benefits both the people and the rainforest.', 'uploads/campaigns/IMG-67524e514327a7.77311556.jpg', '2024-12-06 01:07:29', '2024-12-13 09:41:00'),
(3, 'Protect Our Oceans', 'Join us in our mission to clean up our oceans and protect marine life from plastic pollution. Our campaign aims to organize beach clean-up events, educate communities about sustainable practices, and advocate for policies that reduce plastic waste. Every contribution helps us purchase clean-up equipment and fund educational programs.', 'Ocean Conservation Society', 100000.00, 35000.00, 'Our main challenges include a lack of resources for organizing large-scale events, limited public awareness about the impacts of plastic pollution, and insufficient funding to support ongoing educational initiatives.', 'We plan to implement a series of community workshops, partner with local businesses for sponsorship, and engage volunteers through social media campaigns to raise awareness. Our goal is to mobilize at least 500 volunteers for our beach clean-up events.', 'uploads/campaigns/IMG-6752522ea85ed6.40025518.jpg,uploads/campaigns/IMG-6752522ea86e93.85674625.jpg,uploads/campaigns/IMG-6752522ea877d8.09236206.jpg', '2024-12-06 01:23:58', '2024-12-13 10:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `Donations`
--

CREATE TABLE `Donations` (
  `donId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `campId` int(11) NOT NULL,
  `shareInfo` tinyint(1) NOT NULL,
  `donatedAt` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Donations`
--

INSERT INTO `Donations` (`donId`, `username`, `amount`, `campId`, `shareInfo`, `donatedAt`) VALUES
(3, 'kuki34', 10000, 1, 1, '2024-12-12 06:50:52'),
(4, 'kuki34', 20000, 1, 1, '2024-12-12 07:34:57'),
(5, 'kuki34', 10000, 1, 0, '2024-12-13 07:54:17'),
(6, 'kuki34', 2000, 1, 1, '2024-12-13 07:55:12'),
(7, 'kuki34', 5000, 3, 0, '2024-12-13 10:37:09'),
(8, 'kuki34', 10000, 3, 1, '2024-12-13 10:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `fNotification`
--

CREATE TABLE `fNotification` (
  `id` int(11) NOT NULL,
  `orgName` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fNotification`
--

INSERT INTO `fNotification` (`id`, `orgName`, `message`, `is_read`, `created_at`) VALUES
(1, 'Ocean Conservation Society', 'User kuki34 donated 5000 Birr for the campaign \'Protect Our Oceans\'.', 0, '2024-12-13 10:37:09'),
(2, 'Ocean Conservation Society', 'User kuki34 donated 10000 Birr for the campaign \'Protect Our Oceans\'.', 1, '2024-12-13 10:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Notifications`
--

INSERT INTO `Notifications` (`id`, `username`, `message`, `is_read`, `created_at`) VALUES
(1, 'ephitriq', 'You have received a reward of 500,000 Birr!', 0, '2024-12-11 13:29:16'),
(2, 'kuki34', 'You have received a reward of 500,000 Birr!', 0, '2024-12-11 13:29:35'),
(4, 'lidu7', 'You have received a reward of 500,000 Birr!', 0, '2024-12-13 08:25:26'),
(5, 'hana', 'You have received a reward of 500,000 Birr!', 0, '2024-12-13 08:27:14'),
(7, 'kuki34', 'Thank you for your donation of 5000 Birr to Ocean Conservation Society!', 0, '2024-12-13 10:16:08'),
(8, 'kuki34', 'Thank you for your donation of 5000 Birr to Ocean Conservation Society!', 0, '2024-12-13 10:16:59'),
(12, 'kuki34', 'Thank you for your donation of 10000 Birr to Ocean Conservation Society!', 0, '2024-12-13 10:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `Organization`
--

CREATE TABLE `Organization` (
  `orgName` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `orgDesc` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joinedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Organization`
--

INSERT INTO `Organization` (`orgName`, `logo`, `orgDesc`, `location`, `website`, `password`, `joinedDate`) VALUES
('Helping Hands Charity', 'uploads/org/IMG-67523defad9669.31256023.png', 'A non-profit organization dedicated to providing food and shelter to the homeless.', '123 Main Street, Springfield, IL, 62701', 'https://www.helpinghandscharity.org', '$2y$10$h7OcX0UQNRQHPjOTmbl2W.VUdeC9632.S/FWjwZhTNVEdK.OgJ24a', '2024-12-12 07:02:34'),
('Ocean Conservation Society', 'uploads/org/IMG-67524f80705e88.30082253.png', 'The Ocean Conservation Society is dedicated to preserving marine ecosystems and protecting ocean wildlife. We work towards raising awareness of the threats facing our oceans and engage communities in conservation efforts.', 'San Francisco, CA', 'https://www.oceanconservation.org', '$2y$10$h4ZWYXiV5X6RT0vI7J0XWeb70AbI36Wog47E4xmb73VR2kH0ll7OK', '2024-12-12 07:02:34');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `username` varchar(100) NOT NULL,
  `balance` int(255) NOT NULL DEFAULT 0,
  `photo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joinedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_login` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`fullName`, `email`, `age`, `gender`, `username`, `balance`, `photo`, `password`, `joinedDate`, `first_login`) VALUES
('Ephrata Tesfaye', 'ephulala@gmail.com', 23, 'Female', 'ephitriq', 500000, 'uploads/user/default.png', '$2y$10$6JGiMiixuw.TbO2l2PVHCe82YCKwlp8oFE0h9Igfi4IvR1AyvnR56', '2024-12-11 13:21:25', 0),
('Hana Daniel', 'hana@gmail.com', 22, 'Female', 'hana', 500000, 'uploads/user/default.png', '$2y$10$Wm1CCxeVFLWrB9ruusNvw.pf3L/zBO9GG6qnPiKn2L1vVHCMW7hp2', '2024-12-13 08:26:41', 0),
('Ekram Siraj', 'ekramsiraj32@gmail.com', 22, 'Female', 'kuki34', 423000, 'uploads/user/default.png', '$2y$10$Kn.XkEJZx1XqpNViLm/Riuxs27BKpLVuT3EfmNrcaJ924mqBRZp0W', '2024-12-11 13:08:49', 0),
('Lidiya Joseph', 'lidu@gmail.com', 22, 'Female', 'lidu7', 500000, 'uploads/user/IMG-675bef533ed893.06414908.jpg', '$2y$10$EE8EZK7JYZ9eH.RqdrgKU.UQV6Qk5htii742ZSutlRCabgNQaKeeW', '2024-12-13 08:24:51', 0),
('Yordanos andualem', 'yordanos@gmail.com', 23, 'Male', 'papi', 0, 'uploads/user/default.png', '$2y$10$cRAsKZ9G6rNRvyqr//Gfwuv2BtMyxLPnZhubS3caDDxXjKWCxOPUG', '2024-12-13 11:22:55', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Charity`
--
ALTER TABLE `Charity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orgName` (`orgName`);

--
-- Indexes for table `Donations`
--
ALTER TABLE `Donations`
  ADD PRIMARY KEY (`donId`),
  ADD KEY `username` (`username`),
  ADD KEY `orgId` (`campId`);

--
-- Indexes for table `fNotification`
--
ALTER TABLE `fNotification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orgName` (`orgName`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `Organization`
--
ALTER TABLE `Organization`
  ADD PRIMARY KEY (`orgName`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Charity`
--
ALTER TABLE `Charity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Donations`
--
ALTER TABLE `Donations`
  MODIFY `donId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fNotification`
--
ALTER TABLE `fNotification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Charity`
--
ALTER TABLE `Charity`
  ADD CONSTRAINT `charity_ibfk_1` FOREIGN KEY (`orgName`) REFERENCES `Organization` (`orgName`) ON DELETE CASCADE;

--
-- Constraints for table `Donations`
--
ALTER TABLE `Donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`username`) REFERENCES `User` (`username`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`campId`) REFERENCES `Charity` (`id`);

--
-- Constraints for table `fNotification`
--
ALTER TABLE `fNotification`
  ADD CONSTRAINT `fnotification_ibfk_1` FOREIGN KEY (`orgName`) REFERENCES `Organization` (`orgName`);

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`username`) REFERENCES `User` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
