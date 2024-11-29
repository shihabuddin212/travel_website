-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2024 at 08:35 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_travel`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_id` int NOT NULL,
  `booking_date` date NOT NULL,
  `travel_date` date NOT NULL,
  `number_of_persons` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `payment_status` enum('pending','completed','refunded') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `package_id`, `booking_date`, `travel_date`, `number_of_persons`, `total_amount`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES
(4, 1, 7, '2024-11-22', '2024-11-20', 1, 920.00, 'confirmed', 'completed', '2024-11-22 14:55:24', '2024-11-22 14:55:24'),
(5, 1, 8, '2024-11-22', '2024-11-13', 1, 1380.00, 'confirmed', 'completed', '2024-11-22 14:59:35', '2024-11-22 14:59:35'),
(6, 1, 9, '2024-11-22', '2024-11-13', 1, 6037.50, 'confirmed', 'completed', '2024-11-22 15:00:55', '2024-11-22 15:00:55'),
(10, 1, 1, '2024-11-22', '2024-11-27', 2, 30000.00, 'confirmed', 'completed', '2024-11-22 15:30:21', '2024-11-22 15:30:21'),
(11, 1, 2, '2024-11-22', '2024-12-07', 3, 75000.00, 'pending', 'pending', '2024-11-22 15:30:21', '2024-11-22 15:30:21'),
(12, 1, 3, '2024-11-12', '2024-11-17', 2, 24000.00, 'confirmed', 'completed', '2024-11-22 15:30:21', '2024-11-22 15:30:21'),
(13, 4, 1, '2024-11-22', '2024-11-27', 2, 30000.00, 'confirmed', 'completed', '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(14, 4, 2, '2024-11-22', '2024-12-07', 3, 75000.00, 'pending', 'pending', '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(15, 4, 3, '2024-11-12', '2024-11-17', 2, 24000.00, 'confirmed', 'completed', '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(16, 4, 1, '2024-11-22', '2024-11-27', 2, 30000.00, 'confirmed', 'completed', '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(17, 4, 2, '2024-11-22', '2024-12-07', 3, 75000.00, 'pending', 'pending', '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(18, 4, 3, '2024-11-12', '2024-11-17', 2, 24000.00, 'confirmed', 'completed', '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(19, 4, 1, '2024-11-22', '2024-11-27', 2, 30000.00, 'confirmed', 'completed', '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(20, 4, 2, '2024-11-22', '2024-12-07', 3, 75000.00, 'pending', 'pending', '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(21, 4, 3, '2024-11-22', '2024-12-17', 2, 24000.00, 'confirmed', 'completed', '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(22, 1, 1, '2024-11-20', '2024-12-25', 2, 30000.00, 'confirmed', 'completed', '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(23, 1, 2, '2024-11-21', '2024-12-15', 3, 75000.00, 'pending', 'pending', '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(24, 1, 3, '2024-11-22', '2024-11-30', 1, 12000.00, 'confirmed', 'completed', '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(25, 1, 25, '2024-11-22', '2024-11-15', 1, 920.00, 'confirmed', 'completed', '2024-11-22 17:35:05', '2024-11-22 17:35:05'),
(26, 1, 26, '2024-11-23', '2024-11-15', 1, 1840.00, 'confirmed', 'completed', '2024-11-22 18:57:32', '2024-11-22 18:57:32'),
(27, 1, 27, '2024-11-23', '2024-11-13', 1, 1380.00, 'confirmed', 'completed', '2024-11-22 19:00:39', '2024-11-22 19:00:39'),
(28, 1, 28, '2024-11-23', '2024-11-20', 10, 40250.00, 'confirmed', 'completed', '2024-11-22 19:09:07', '2024-11-22 19:09:07'),
(29, 1, 29, '2024-11-23', '2024-11-20', 10, 27600.00, 'confirmed', 'completed', '2024-11-23 15:55:47', '2024-11-23 15:55:47'),
(30, 1, 30, '2024-11-23', '2024-11-28', 10, 80500.00, 'confirmed', 'completed', '2024-11-23 16:00:11', '2024-11-23 16:00:11'),
(31, 1, 31, '2024-11-23', '2024-11-14', 7, 12880.00, 'confirmed', 'completed', '2024-11-23 16:02:51', '2024-11-23 16:02:51'),
(32, 1, 32, '2024-11-23', '2024-11-15', 1, 920.00, 'confirmed', 'completed', '2024-11-23 16:05:15', '2024-11-23 16:05:15'),
(33, 1, 33, '2024-11-23', '2024-12-05', 10, 13800.00, 'confirmed', 'completed', '2024-11-23 16:11:37', '2024-11-23 16:11:37'),
(34, 1, 34, '2024-11-24', '2024-11-11', 4, 3680.00, 'confirmed', 'completed', '2024-11-23 18:58:59', '2024-11-23 18:58:59'),
(35, 1, 35, '2024-11-24', '2024-11-19', 1, 1840.00, 'confirmed', 'completed', '2024-11-23 19:05:11', '2024-11-23 19:05:11'),
(36, 1, 36, '2024-11-24', '2024-11-25', 1, 6037.50, 'confirmed', 'completed', '2024-11-23 19:35:44', '2024-11-23 19:35:44'),
(37, 6, 37, '2024-11-24', '2024-11-27', 1, 1380.00, 'confirmed', 'completed', '2024-11-23 20:27:22', '2024-11-23 20:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE `destinations` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `location` varchar(100) DEFAULT NULL,
  `division` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `tour_type` varchar(50) DEFAULT NULL,
  `included_features` text,
  `image_url` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `description`, `price`, `duration`, `tour_type`, `included_features`, `image_url`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Cox\'s Bazar Tour', 'Beautiful beach tour package', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/coxs-bazar.png', NULL, '2024-11-22 14:30:45', '2024-11-22 17:38:02'),
(2, 'Sundarbans Adventure', 'Explore the mangrove forest', 25000.00, '4 days', 'Adventure', 'Hotel, Transport, Meals', 'images/sundarban.webp', NULL, '2024-11-22 14:30:45', '2024-11-22 17:38:01'),
(3, 'Sajek Valley Trip', 'Mountain adventure package', 12000.00, '2 days', 'Hill Track', 'Hotel, Transport, Meals', 'images/sajek-valley.jpg', NULL, '2024-11-22 14:30:45', '2024-11-22 17:38:00'),
(4, 'Bus to Coxs-bazar', NULL, 1380.00, '1 day', 'bus', 'Hotel, Transport, Meals', 'Hotel, Transport, Meals', NULL, '2024-11-22 14:52:51', '2024-11-22 17:38:08'),
(7, 'Bus to Coxs-bazar', 'Travel package via bus', 920.00, '1 day', 'bus', 'Hotel, Transport, Meals', NULL, NULL, '2024-11-22 14:55:24', '2024-11-22 17:38:04'),
(8, 'Train to Coxs-bazar', 'Travel package via train', 1380.00, '1 day', 'train', 'Hotel, Transport, Meals', NULL, NULL, '2024-11-22 14:59:35', '2024-11-22 17:38:07'),
(9, 'Air to Coxs-bazar', 'Travel package via air', 6037.50, '1 day', 'air', 'Hotel, Transport, Meals', NULL, NULL, '2024-11-22 15:00:55', '2024-11-22 17:37:59'),
(10, 'Cox\'s Bazar Beach Tour', 'Enjoy the longest natural beach in the world', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/packages/coxs-bazar.jpg', 4.50, '2024-11-22 15:29:51', '2024-11-22 15:29:51'),
(11, 'Sundarbans Mangrove Forest', 'Explore the largest mangrove forest', 25000.00, '4 days', 'Adventure', 'Boat, Guide, Meals', 'images/packages/sundarbans.jpg', 4.80, '2024-11-22 15:29:51', '2024-11-22 15:29:51'),
(12, 'Sajek Valley Trip', 'Visit the queen of hills', 12000.00, '2 days', 'Hill Track', 'Transport, Stay, Guide', 'images/packages/sajek.jpg', 4.30, '2024-11-22 15:29:51', '2024-11-22 15:29:51'),
(13, 'Cox\'s Bazar Tour', 'Beautiful beach tour package', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/packages/coxs-bazar.jpg', 4.50, '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(14, 'Sundarbans Adventure', 'Explore the mangrove forest', 25000.00, '4 days', 'Adventure', 'Boat, Guide, Meals', 'images/packages/sundarbans.jpg', 4.80, '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(15, 'Sajek Valley Trip', 'Mountain adventure package', 12000.00, '2 days', 'Hill Track', 'Transport, Stay, Guide', 'images/packages/sajek.jpg', 4.30, '2024-11-22 15:37:07', '2024-11-22 15:37:07'),
(16, 'Cox\'s Bazar Tour', 'Beautiful beach tour package', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/packages/coxs-bazar.jpg', 4.50, '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(17, 'Sundarbans Adventure', 'Explore the mangrove forest', 25000.00, '4 days', 'Adventure', 'Boat, Guide, Meals', 'images/packages/sundarbans.jpg', 4.80, '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(18, 'Sajek Valley Trip', 'Mountain adventure package', 12000.00, '2 days', 'Hill Track', 'Transport, Stay, Guide', 'images/packages/sajek.jpg', 4.30, '2024-11-22 15:39:25', '2024-11-22 15:39:25'),
(19, 'Cox\'s Bazar Tour', 'Beautiful beach tour package with sea view hotel', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/coxs-bazar.png', 4.50, '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(20, 'Sundarbans Adventure', 'Explore the mangrove forest with boat trip', 25000.00, '4 days', 'Adventure', 'Boat, Guide, Meals', 'images/sundarban.webp', 4.80, '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(21, 'Sajek Valley Trip', 'Mountain adventure package with stunning views', 12000.00, '2 days', 'Hill Track', 'Transport, Stay, Guide', 'images/sajek-valley.jpg', 4.30, '2024-11-22 15:44:38', '2024-11-22 15:44:38'),
(22, 'Cox\'s Bazar Beach Tour', 'Enjoy the longest beach in the world', 15000.00, '3 days', 'Beach Tour', 'Hotel, Transport, Meals', 'images/packages/coxs-bazar.jpg', 4.50, '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(23, 'Sundarbans Adventure', 'Explore the largest mangrove forest', 25000.00, '4 days', 'Adventure', 'Boat, Guide, Accommodation, Meals', 'images/packages/sundarbans.jpg', 4.80, '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(24, 'Sajek Valley Trek', 'Experience the clouds and mountains', 12000.00, '2 days', 'Hill Track', 'Transport, Stay, Breakfast', 'images/packages/sajek.jpg', 4.30, '2024-11-22 17:33:08', '2024-11-22 17:33:08'),
(25, 'Bus to Coxs-bazar', 'Travel package via bus', 920.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-22 17:35:05', '2024-11-22 17:35:05'),
(26, 'Bus to Coxs-bazar', 'Travel package via bus', 1840.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-22 18:57:31', '2024-11-22 18:57:31'),
(27, 'Bus to Coxs-bazar', 'Travel package via bus', 1380.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-22 19:00:39', '2024-11-22 19:00:39'),
(28, 'Air to Coxs-bazar', 'Travel package via air', 40250.00, '1 day', 'air', NULL, NULL, NULL, '2024-11-22 19:09:07', '2024-11-22 19:09:07'),
(29, 'Train to Coxs-bazar', 'Travel package via train', 27600.00, '1 day', 'train', NULL, NULL, NULL, '2024-11-23 15:55:47', '2024-11-23 15:55:47'),
(30, 'Air to Coxs-bazar', 'Travel package via air', 80500.00, '1 day', 'air', NULL, NULL, NULL, '2024-11-23 16:00:11', '2024-11-23 16:00:11'),
(31, 'Bus to Coxs-bazar', 'Travel package via bus', 12880.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 16:02:51', '2024-11-23 16:02:51'),
(32, 'Bus to Coxs-bazar', 'Travel package via bus', 920.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 16:05:15', '2024-11-23 16:05:15'),
(33, 'Bus to Coxs-bazar', 'Travel package via bus', 13800.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 16:11:37', '2024-11-23 16:11:37'),
(34, 'Bus to Coxs-bazar', 'Travel package via bus', 3680.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 18:58:59', '2024-11-23 18:58:59'),
(35, 'Bus to Coxs-bazar', 'Travel package via bus', 1840.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 19:05:11', '2024-11-23 19:05:11'),
(36, 'Air to Coxs-bazar', 'Travel package via air', 6037.50, '1 day', 'air', NULL, NULL, NULL, '2024-11-23 19:35:44', '2024-11-23 19:35:44'),
(37, 'Bus to Coxs-bazar', 'Travel package via bus', 1380.00, '1 day', 'bus', NULL, NULL, NULL, '2024-11-23 20:27:22', '2024-11-23 20:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `package_id` int DEFAULT NULL,
  `destination_id` int DEFAULT NULL,
  `rating` int NOT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('admin','user','agency') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_token` varchar(128) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `email_verified` tinyint(1) DEFAULT '0',
  `verification_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `user_type`, `created_at`, `updated_at`, `reset_token`, `reset_expires`, `email_verified`, `verification_token`) VALUES
(1, 'deedpool ', 'god of war', 'ih134857@gmail.com', '$2y$10$O8dImvGX1BdPOcCBcD3tk.C/Ad3O/LERlYrfhsbsIO4Yvtp9co6Qm', '01780044655', 'user', '2024-11-20 16:24:46', '2024-11-23 15:38:06', NULL, NULL, 0, NULL),
(2, 'asdffasdd', 'afsdadfs', 'ih134afsd857@gmail.com', '$2y$10$KeR24BikoVEYrpA.516VyuTp9S8xGmT1F73jO3yBy14hoir36PmKi', 'asdf', 'user', '2024-11-20 17:40:26', '2024-11-20 17:40:26', NULL, NULL, 0, NULL),
(3, 'Shihab Uddin', ' Uddin', 'mshhihab141@gmail.com', '$2y$10$jKTsSRtnxDJ4BbixFhrYLu3E5JV3ZCgz3FdBZoVgBYFYQ/WkMN2TW', '01771464646', 'user', '2024-11-20 18:05:31', '2024-11-20 18:46:12', NULL, NULL, 0, NULL),
(4, 'OVI', '', 'mdsiyamsaqlainovi@gmail.com', '$2y$10$r5D5UDlH9eYwFr/Uew9YQOCeMIC5N8Hw6Jh1D7NdZvlh0g98aGWIO', NULL, 'user', '2024-11-21 10:24:22', '2024-11-21 10:24:22', NULL, NULL, 0, NULL),
(5, 'adad', 'adad', 'adad@gmail.com', '$2y$10$OeyJVTTowFsBoUqmxLPNCuwMxqrfVmrJzztqC.HFXhYnoEi8cVnTW', 'adad', 'user', '2024-11-21 17:04:15', '2024-11-21 17:04:15', NULL, NULL, 0, NULL),
(6, 'shihab', 'shihab', 'shihab@gmail.com', '$2y$10$unuZRDfoHfw2AyhQVMha5..olQ13AN3JgE9PVZzs1HNvsaH8RLYne', '1234', 'admin', '2024-11-23 20:26:03', '2024-11-23 20:33:27', NULL, NULL, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
