-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2024 at 09:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `byaheros`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, '', '', '', ''),
(3, 'Klenth Joeseph', 'Cañedo', 'admin@gmail.com', '12345'),
(5, 'wow', 'hehe', 'samani@gmail.com', 'hehehe'),
(7, 'test', 'tase', 'test@tgaj', 'test'),
(8, 'hakhdflk', 'kjadhsk', 'lkjahds@gmau.cjklah', '$2y$10$B0ELxllI71/L2J7jTgFQ/OMgIveezfqdC4ddeZ8WmWXZCOwtDK/.G'),
(9, 'taloloy', 'ahdsfkh', 'klhadsf12@fa', '$2y$10$CcNHt4x4Lj8N6TAqXXGwX.Ixv3XYD3M9U5wdunvoh2fbPDGCulwz2'),
(11, 'ahahh', 'hashah', 'hakshd@gakl', '$2y$10$w2aacYgZzVbhHTFHz7lTUe3BjdGmCZC.yBXr9vfDKE7TQO693Glh6'),
(12, 'ade', 'rante', 'ade@gmail.com', '$2y$10$ctl6OsaMGTEmp6YKZmAJKucFBqMMsgZaThVuCrwD42HJY.0lGTVK6'),
(13, 'adeads', 'asdf', '234adsf@dasf', '$2y$10$z3GafZYRE1XnpcSzKwl45uBmLaScoj.Om6gGjXnEk00bMeoPVIcly');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `rental_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `status` enum('Pending','Accepted','Declined') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `product_id`, `start_date`, `end_date`, `payment_method`, `rental_date`, `user_id`, `status`) VALUES
(1, 4, '2024-05-19', '2024-05-20', 'Credit card', '2024-05-19 09:49:01', 4, 'Declined'),
(2, 1, '2024-05-19', '2024-05-20', 'Debit card', '2024-05-19 10:53:57', 4, 'Declined'),
(3, 1, '2024-05-21', '2024-05-22', 'Debit card', '2024-05-19 11:53:02', 4, 'Accepted'),
(4, 2, '2024-05-19', '2024-05-20', 'Debit card', '2024-05-19 15:57:14', 5, 'Accepted'),
(5, 39, '2024-05-21', '2024-05-22', 'Credit card', '2024-05-21 07:13:56', 4, 'Pending'),
(6, 2, '2024-05-21', '2024-05-23', 'Debit card', '2024-05-21 10:21:44', 4, 'Accepted'),
(7, 3, '2024-05-21', '2024-05-22', 'Debit card', '2024-05-21 10:23:21', 4, 'Declined'),
(8, 1, '2024-05-23', '2024-05-24', 'Gcash', '2024-05-21 10:31:14', 7, 'Accepted'),
(9, 3, '2024-05-23', '2024-05-24', 'Gcash', '2024-05-23 02:31:44', 4, 'Accepted'),
(10, 40, '2024-05-23', '2024-05-24', 'Credit card', '2024-05-23 02:56:50', 8, 'Accepted'),
(11, 3, '2024-05-27', '2024-05-28', 'Debit card', '2024-05-27 07:38:27', 4, 'Declined');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `rental_id` int(11) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `rental_id`, `sale_date`, `amount`) VALUES
(1, 1, '2024-05-18', 1500.00),
(2, 2, '2024-05-18', 1500.00),
(3, 3, '2024-05-18', 1500.00),
(4, 4, '2024-05-18', 1500.00),
(5, 5, '2024-05-18', 1500.00),
(6, 6, '2024-05-18', 1500.00),
(7, 7, '2024-05-18', 1500.00),
(8, 8, '2024-05-18', 1500.00),
(9, 9, '2024-05-18', 900.00),
(10, 10, '2024-05-18', 900.00),
(11, 11, '2024-05-18', 1200.00),
(12, 12, '2024-05-18', 1500.00),
(13, 13, '2024-05-19', 1200.00),
(14, 14, '2024-05-19', 1500.00),
(15, 15, '2024-05-19', 900.00),
(16, 1, '2024-05-19', 900.00),
(17, 2, '2024-05-19', 1500.00),
(18, 3, '2024-05-19', 1500.00),
(19, 4, '2024-05-19', 1500.00),
(20, 5, '2024-05-21', 1233.00),
(21, 6, '2024-05-21', 1500.00),
(22, 7, '2024-05-21', 1200.00),
(23, 8, '2024-05-21', 1500.00),
(25, 10, '2024-05-23', 150.00),
(26, 11, '2024-05-27', 1200.00);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `car_image` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `year_manufactured` int(11) DEFAULT NULL,
  `price_cost` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `car_image`, `alt_text`, `name`, `description`, `year_manufactured`, `price_cost`, `status`) VALUES
(1, '../units/viosxle.png', 'vios', '2023 Toyota Vios XLE', 'The 2023 Toyota Vios XLE blends style, comfort, and reliability. Enjoy advanced features, a spacious interior, and great fuel efficiency. Perfect for city and long trips. Rent now for a smooth ride.', 2023, 1500.00, 'available'),
(2, 'mirage.jpg', 'Mirage', '2023 Mitsubishi Mirage G4', 'The 2023 Mitsubishi Mirage G4 is efficient and convenient. Modern design, comfortable seating, and great fuel economy. Ideal for busy streets and tight parking. Rent today for an economical drive.', 2023, 1500.00, 'available'),
(3, 'WIGOaa.png', 'WIGO', '2024 Toyota Wigo', 'The 2024 Toyota Wigo is a fun, practical 5-seater hatchback. Compact yet spacious with agile handling and a stylish look. Perfect for city adventures and getaways. Rent now for a lively ride.', 2024, 1200.00, 'available'),
(4, 'pngegg.png', 'Mater', '1829 Tow Truck', 'Tow Mater KG is an . His appearances include the feature films Cars, Cars 2, and Cars 3, as well as in the TV series Cars ', 1829, 900.00, 'available'),
(39, '../units/hiace.jpg', '', 'Hiace', 'hi dol mao nani ang edited hehehehe', 2023, 1233.00, 'maintenance'),
(40, '../units/car.jpg', '', 'tricycle', 'omtoda', 2023, 150.00, 'available'),
(41, '../units/hiace.jpg', '', 'trisikad', 'trisikad', 2024, 200.00, 'maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`) VALUES
(1, 'user', 'user@gmail.com', '$2y$10$Edltu8xxHJQVVt5QuT0qNeKqUbGlY6SdUPsHyUcLOdi7GXIuABwRi', 'active'),
(2, 'hatdog', 'hatdog@gmail.com', '$2y$10$2Uoto9ys8Egmh/.IMZfQ5uk49nPQAo3dhnnoovaU3KxtAj04Ablhm', 'active'),
(3, 'sayon', 'sayon@gmial.com', '$2y$10$sF.kqowVsolCE3Klnu/ybOZbsBoe8aX33eZJPmbxxKJUioSjV71bK', 'active'),
(4, 'ade', 'ade@gmail.com', '$2y$10$fhB3GeCRwWF8KvGHlluxl.gYMC//Bca/clTuOUZzLD/ydElwYKaEK', 'active'),
(5, 'rian', 'rian@gmail.com', '$2y$10$oimVPvOhxM34D1ltzrMJtexXm0N8kWfyIcOkK7BSHPCYrn2EIY0Q6', 'active'),
(6, 'taloloy', 'taloloy@gmail.com', '$2y$10$ZMSjpx4I6JuJI9XNFjIr0OOXXpblC9s2cD2PKxJVIhya8ILNx9X72', 'blocked'),
(7, 'kristel', 'kristel@gmail.com', '$2y$10$SmaHQa.08K.Vjh5dioW39efA6n0tHu61F8KFMi4tP95b.FuoXEjnO', 'active'),
(8, 'viceganda', 'viceganda@gmail.com', '$2y$10$bbovXZ82XoMvTgITX9Rx8e7Xv40dE3zfmYK.Qa4LO55ua.dOS/zY.', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
