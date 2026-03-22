-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2026 at 02:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `device_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `status` enum('In Stock','Deployed','Under Repair') DEFAULT 'In Stock',
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `serial_number`, `device_name`, `price`, `status`, `category_id`) VALUES
(135, 'A,SN1001', 'Laptop', 4500.00, 'In Stock', 1),
(136, 'B,SN1002', 'Laptop', 4700.00, 'Deployed', 1),
(137, 'C,SN1003', 'Laptop', 5000.00, 'Deployed', 1),
(138, 'A,SN1004', 'Desktop', 3800.00, 'In Stock', 2),
(188, 'B,SN1005', 'Desktop', 4000.00, 'In Stock', 2),
(189, 'C,SN1006', 'Desktop', 4200.00, 'In Stock', 2),
(190, 'A,SN1007', 'Printer', 1200.00, 'Under Repair', 3),
(191, 'B,SN1008', 'Printer', 1500.00, 'Under Repair', 3),
(192, 'C,SN1009', 'Printer', 1300.00, 'Under Repair', 3),
(193, 'A,SN1010', 'Router', 800.00, 'Under Repair', 2),
(194, 'B,SN1011', 'Router', 900.00, 'Deployed', 1),
(195, 'C,SN1012', 'Router', 850.00, 'Under Repair', 2),
(196, 'A,SN1013', 'Switch', 700.00, 'Under Repair', 3),
(197, 'B,SN1014', 'Switch', 750.00, 'Deployed', 1),
(198, 'C,SN1015', 'Switch', 720.00, 'Under Repair', 5),
(199, 'A,SN1016', 'Monitor', 1100.00, 'Deployed', 3),
(200, 'B,SN1017', 'Monitor', 1150.00, 'Under Repair', 3),
(201, 'C,SN1018', 'Monitor', 1120.00, 'Deployed', 2),
(202, 'A,SN1019', 'Keyboard', 100.00, 'Under Repair', 2),
(203, 'B,SN1020', 'Keyboard', 120.00, 'Under Repair', 2),
(204, 'C,SN1021', 'Keyboard', 110.00, 'Deployed', 3),
(205, 'A,SN1022', 'Mouse', 80.00, 'In Stock', 1),
(206, 'B,SN1023', 'Mouse', 90.00, 'Under Repair', 2),
(207, 'C,SN1024', 'Mouse', 85.00, 'Under Repair', 1),
(208, 'A,SN1025', 'Headset', 150.00, 'Deployed', 3),
(209, 'A,SN1026', 'Monitor', 700.00, 'In Stock', 1),
(210, 'A,SN1027', 'Keyboard', 750.00, 'Deployed', 1),
(211, 'A,SN1028', 'Keyboard', 720.00, 'Deployed', 1),
(212, 'A,SN1029', 'Keyboard', 1100.00, 'In Stock', 2),
(213, 'A,SN1030', 'Mouse', 1150.00, 'In Stock', 2),
(214, 'A,SN1031', 'Mouse', 1120.00, 'In Stock', 2),
(215, 'A,SN1032', 'Mouse', 100.00, 'Under Repair', 3),
(216, 'A,SN1033', 'server', 120.00, 'Under Repair', 3),
(217, 'A,SN1034', 'monitor', 110.00, 'Under Repair', 3),
(218, 'A,SN1035', 'hp pc', 80.00, 'Under Repair', 2),
(219, 'A,SN1036', 'ecran', 90.00, 'Deployed', 1),
(220, 'A,SN1037', 'pc hp', 85.00, 'Under Repair', 2),
(221, 'A,SN1038', 'pc lenovo', 150.00, 'Under Repair', 3),
(222, 'A,SN1039', 'pc portable', 700.00, 'Deployed', 1),
(223, 'A,SN1040', 'mouse', 750.00, 'Under Repair', 5),
(224, 'A,SN1041', 'monitor', 720.00, 'Deployed', 3),
(225, 'A,SN1042', 'hp pc', 1100.00, 'Under Repair', 3),
(226, 'A,SN1043', 'ecran', 1150.00, 'Deployed', 2),
(227, 'A,SN1044', 'pc hp', 1120.00, 'Under Repair', 2),
(228, 'A,SN1045', 'pc lenovo', 100.00, 'Under Repair', 2),
(229, 'A,SN1046', 'pc portable', 120.00, 'Deployed', 3),
(230, 'A,SN1047', 'mouse', 110.00, 'In Stock', 1),
(231, 'A,SN1048', 'monitor', 80.00, 'Under Repair', 2),
(232, 'A,SN1049', 'hp pc', 90.00, 'Under Repair', 1),
(233, 'A,SN1050', 'ecran', 85.00, 'Deployed', 3),
(234, 'A,SN1051', 'pc hp', 150.00, 'Under Repair', 2),
(235, 'A,SN1052', 'pc lenovo', 150.00, 'Under Repair', 1),
(236, 'A,SN1053', 'pc portable', 150.00, 'Deployed', 3),
(237, 'zzzzzzzzzz', 'zzzzzzzzzz', 99999999.99, 'Deployed', 5),
(238, 'sss', 'kokodd', 1900.00, 'In Stock', 1),
(239, 'sssssssssssssssssssssssss', 'bbbbbbbbbbbb', 890.00, 'In Stock', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Laptop'),
(2, 'Monitor'),
(3, 'Server'),
(4, 'Printer'),
(5, 'Router');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) DEFAULT NULL,
  `title` enum('manager','staff','intern') DEFAULT 'staff',
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL DEFAULT 'employee',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `title`, `password`, `role`, `created_at`) VALUES
(1, 'admin', NULL, 'staff', '$2y$10$xs3EsL5dlbxMq32X4HBobOv3RLLhy3D07r6NPXhKFwY72rDE8ytfu', 'admin', '2026-03-17 12:22:48'),
(5, 'joseph007', 'siradesign.contact@gmail.gggg', 'staff', '$2y$10$f7i2FugMcgpYwWvDN1U4M..ulIvDqlph63Dfe03pd1y67qeZmUtwi', 'employee', '2026-03-18 01:56:29'),
(9, 'koooo', 'jdirayoussef1997@gmail.com', 'manager', '$2y$10$iKxjMfj0L5I/8kUlR/5LiuY7BbE3Fw7XNoaGJJEt0RDKGg3O/iJRG', 'employee', '2026-03-18 10:42:46'),
(10, 'sososo', 'youssefjdira@hotmail.com', 'intern', '$2y$10$9zW5o5o//EEkig4SYF9UmeCELGXvHmF1QKH5qHk4j6aGRJwCknz0a', 'employee', '2026-03-18 10:43:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
