-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 03:29 PM
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
-- Database: `web shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `pk_orderID` int(11) NOT NULL,
  `fk_user` int(11) NOT NULL,
  `fk_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `fk_managedBy` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`pk_orderID`, `fk_user`, `fk_product`, `quantity`, `totalPrice`, `fk_managedBy`, `date`, `status`) VALUES
(4, 4, 2, 4, 15.96, 1, '2025-06-05 14:56:04', 1),
(5, 1, 2, 1, 3.99, 1, '2025-06-05 14:59:01', 2),
(6, 1, 2, 6, 23.94, 1, '2025-06-05 15:03:44', 1),
(7, 4, 2, 9, 35.91, 1, '2025-06-05 15:04:28', 2),
(8, 5, 2, 7, 27.93, 4, '2025-06-05 15:06:29', 1),
(9, 4, 2, 8, 31.92, 4, '2025-06-05 15:07:41', 2),
(10, 4, 2, 10, 39.90, 4, '2025-06-05 15:07:55', 2),
(11, 6, 5, 2, 60.00, 4, '2025-06-16 14:40:16', 1),
(12, 4, 8, 3, 2370.00, 4, '2025-06-16 15:44:07', 2),
(13, 4, 4, 5, 175.00, 4, '2025-06-19 14:18:23', 2),
(14, 4, 3, 1, 345.00, 4, '2025-06-19 14:50:59', 1),
(17, 4, 2, 1, 3.99, 4, '2025-06-26 13:44:33', 2),
(18, 4, 2, 1, 3.99, 4, '2025-06-26 14:11:04', 2),
(19, 4, 3, 1, 345.00, 4, '2025-06-26 14:14:15', 1),
(20, 7, 2, 7, 27.93, 4, '2025-06-26 15:26:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pk_productID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `imageToPath` varchar(1000) DEFAULT NULL,
  `stock` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pk_productID`, `name`, `price`, `description`, `imageToPath`, `stock`) VALUES
(2, 'Magic Hat', 3.99, 'Magic hat', 'product_assets/wizard_hat.jpg', 927),
(3, 'Dragon Egg', 345.00, 'A rare dragon egg that may hatch into a loyal companion', 'product_assets/dragon_egg.jpg', 43),
(4, 'Magic Staff', 35.00, 'A powerful wand imbued with ancient spells', 'product_assets/magic_staff.jpg', 20),
(5, 'Love Potion', 30.00, 'A mystical elixir that enchants the heart and stirs the soul, promising to ignite the flames of love', 'product_assets/love_potion.jpg', 196),
(6, 'Enchanted Cloak', 100.00, 'A cloak that hides you in the shadows', 'product_assets/enchanted_cloak.jpg', 45),
(7, 'Spellbook', 76.00, 'A book filled with spells and incantations', 'product_assets/spellbook.jpg', 340),
(8, 'Crystal Ball', 790.00, 'A crystal ball for scrying and seeing the future', 'product_assets/crystal_ball.jpg', 0),
(9, 'Phoenix Feather', 670.00, 'A rare feather from a mystical phoenix', 'product_assets/phoenix_feather.jpg', 12),
(10, 'Elven Bow', 140.00, 'A finely crafted bow used by elven archers', 'product_assets/elven_bow.jpg', 37),
(11, 'Fairy Dust', 42.00, 'A vial of sparkling fairy dust with magical properties', 'product_assets/fairy_dust.jpg', 42);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `pk_userID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`pk_userID`, `name`, `password`, `isAdmin`) VALUES
(1, 'CheOl904', '1', 1),
(4, 'admin', 'admin', 1),
(5, 'user', '1', 0),
(6, 'Qwerty', '1', 0),
(7, 'u', 'u', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`pk_orderID`),
  ADD KEY `fk_product` (`fk_product`),
  ADD KEY `fk_user` (`fk_user`),
  ADD KEY `fk_approvedBy` (`fk_managedBy`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pk_productID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`pk_userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `pk_orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pk_productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `pk_userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_approvedBy` FOREIGN KEY (`fk_managedBy`) REFERENCES `user` (`pk_userID`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`fk_product`) REFERENCES `product` (`pk_productID`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`fk_user`) REFERENCES `user` (`pk_userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
