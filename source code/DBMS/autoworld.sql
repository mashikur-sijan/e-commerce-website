-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2025 at 05:53 PM
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
-- Database: `autoworld`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Acura'),
(2, 'Daihatsu'),
(3, 'Hino'),
(4, 'Honda'),
(5, 'Infiniti'),
(6, 'Lexus'),
(7, 'Mazda'),
(8, 'Mitsubishi'),
(9, 'Nissan'),
(10, 'Subaru'),
(11, 'Suzuki'),
(12, 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `cart_details`
--

CREATE TABLE `cart_details` (
  `product_id` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `quantity` int(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`) VALUES
(1, 'Convertible'),
(2, 'Coupe'),
(3, 'Crossover'),
(4, 'Hatchback'),
(5, 'Luxury Car'),
(6, 'MPV'),
(7, 'Sedan'),
(8, 'Sports Car'),
(9, 'SUV'),
(10, 'Wagon');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `date_sent`) VALUES
(1, 'admin', 'sifota@ares.edu.pl', 'asdfasdfasdf', '2025-04-19 21:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending',
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `order_id`, `amount`, `payment_date`, `status`, `payment_method`) VALUES
(1, 2, 0, 0.00, '2025-04-19 13:22:54', 'paid', ''),
(5, 2, 0, 2500000.00, '2025-04-19 13:56:04', 'paid', 'bkash'),
(6, 4, 0, 3100000.00, '2025-04-19 14:42:39', 'declined', 'bkash'),
(7, 4, 0, 850000.00, '2025-04-19 15:06:44', 'paid', 'paypal');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_keywords` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_image1` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `product_image5` varchar(255) NOT NULL,
  `product_price` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_title`, `product_description`, `product_keywords`, `category_id`, `brand_id`, `product_image1`, `product_image2`, `product_image3`, `product_image4`, `product_image5`, `product_price`, `date`, `status`) VALUES
(1, 'TOYOTA Townace Noah Super Extra Limo SR40', 'Model - 1999. Registration - 2004. Engine - 3S-FE 2000cc Transmission - Automatic Fuel Type - Octane + LPG - 90 LTR Color - Blizzard White Pearl (070)', 'toyota,nissian,mitsubishi,honda,suzuki,jdm', 6, 12, '67e52659e01da_01.jpg', '67e52659e01e4_02.jpg', '67e52659e01e5_03.jpg', '67e52659e01ea_04.jpg', '67e52659e01eb_05.jpg', '850000 Tk.', '2025-03-27 10:20:09', 'active'),
(2, 'TOYOTA Corolla Axio X NZE141', 'Model - 2010. Registration - 2016. Engine - 1NZ-FE 1500cc. Transmission - CVT. Fuel Type - Octane + LPG - 60 LTR. Color - Dark Gray Metallic (1E0)', 'toyota,nissian,mitsubishi,honda,suzuki,jdm', 7, 12, '67e526ea7a830_01.jpg', '67e526ea7a836_02.jpg', '67e526ea7a837_03.jpg', '67e526ea7a838_04.jpg', '67e526ea7a839_05.jpg', '1450000 Tk.', '2025-03-27 10:22:34', 'active'),
(3, 'TOYOTA Corolla Axio Hybrid NKE165', 'Model - 2014. Registration - 2020. Engine - 1NZ-FXE 1500cc. Transmission - CVT.  Fuel Type - Octane. Color - Super White II (040).', 'toyota,nissian,mitsubishi,honda,suzuki,jdm', 7, 12, '67e5277270efe_01.png', '67e5277270f05_02.png', '67e5277270f06_03.jpeg', '67e5277270f07_04.jpeg', '67e5277270f08_05.jpeg', '1650000 Tk.', '2025-03-27 10:24:50', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `userpassword` varchar(255) DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_ip` varchar(100) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `user_mobile` varchar(15) DEFAULT NULL,
  `user_type` enum('user','admin') DEFAULT 'user',
  `status` enum('active','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `username`, `user_email`, `userpassword`, `user_image`, `user_ip`, `user_address`, `user_mobile`, `user_type`, `status`) VALUES
(3, 'abc', 'abc@gmail.com', '$2y$10$4WoSxJKMrVHIae0.JGqM/uaTanT.evNHNbIne9P.Z.k136.ex2Kr.', 'ezgif-5-f872e15bdf.jpg', '::1', 'abc', '1565', 'user', 'active'),
(4, 'admin', 'admin@gmail.com', '$2y$10$D0g8OI3qgI1XT4Zli3ZeKOoLEpLNbsv39ZKwGANeIO.qTm.lTdCdG', 'ezgif-5-39f0fe1fea.jpg', '::1', 'dhaka', '1565', 'admin', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart_details`
--
ALTER TABLE `cart_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cart_details`
--
ALTER TABLE `cart_details`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
