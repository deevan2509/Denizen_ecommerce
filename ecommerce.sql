-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2024 at 05:25 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` int(20) NOT NULL,
  `category` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `category`, `image`) VALUES
(1, 'Nike Court Royale', 450, 'shoes', 0x6e696b65636f7572742d726f79616c652d322d6e6578742d6e61747572652d73686f65732d5252637232302e706e67),
(2, 'Tiffosi', 200, 'watches', 0x77617463682e6a7067),
(3, 'Adidas Galaxy', 200, 'shoes', 0x4164696461732047616c6178792e6a706567),
(4, 'All Star Classic', 100, 'shoes', 0x416c6c207374617220636c61737369632e6a706567),
(5, 'Brown Classic Loafers', 90, 'shoes', 0x42726f776e20636c6173736963206c6f61666572732e6a7067),
(6, 'Fila Cloud', 110, 'shoes', 0x46696c6120636c6f75642e6a706567),
(7, 'Fila Gold', 150, 'shoes', 0x46696c6120676f6c642e6a7067),
(8, 'Nike Bounce', 300, 'shoes', 0x4e696b6520426f756e63652e6a7067),
(9, 'Nike Jordans', 290, 'shoes', 0x4e696b65206a6f7264616e732e6a7067),
(10, 'Nike Revolution', 320, 'shoes', 0x4e696b65205265766f6c7574696f6e2e6a706567),
(11, 'Lewis t-shirt', 90, 'clothing', 0x7368697274312e6a7067),
(12, 'Gucci T-shirt', 90, 'clothing', 0x7368697274342e6a7067),
(13, 'Sefossi T-shirt', 55, 'clothing', 0x7368697274332e6a7067),
(14, 'Maney Tshirt', 110, 'clothing', 0x7368697274322e6a7067),
(15, 'Skull Black Tee', 85, 'clothing', 0x636c6f7468696e672e6a7067),
(16, 'Casual Grey T-shirt', 90, 'clothing', 0x43617375616c2047726579205473686972742e6a706567),
(17, 'Clai Men Pattern Shirt', 150, 'clothing', 0x436c6169204d656e205061747465726e2053686972742e6a7067),
(18, 'Denim jacket', 200, 'clothing', 0x44656e696d206a61636b65742e6a7067),
(19, 'Safossi Grey Jacket', 180, 'clothing', 0x5361666f7373692047726579204a61636b65742e6a7067),
(20, 'Terest Long Sleeve', 120, 'clothing', 0x546572657374204c6f6e6720536c656576652e6a7067),
(22, 'Tiffosi V2', 450, 'watches', 0x7761746368312e6a7067),
(23, 'Seiko', 230, 'watches', 0x7761746368322e6a7067),
(24, 'Basio', 290, 'watches', 0x7761746368332e6a7067),
(25, 'Succi Limo', 300, 'watches', 0x7761746368342e6a7067),
(26, 'Playboy Time', 180, 'watches', 0x506c6179626f792e6a7067),
(27, 'Pocodar', 170, 'watches', 0x506f636f6461722e6a7067),
(28, 'LIGE', 230, 'watches', 0x4c4947452e6a7067),
(29, 'Beats V1', 800, 'headphones', 0x7370312e6a7067),
(30, 'Beats V2', 1100, 'headphones', 0x7370322e6a7067),
(31, 'Airpods White', 600, 'headphones', 0x7370342e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone` int(10) NOT NULL,
  `registration_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password` varchar(255) NOT NULL,
  `Account_Type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email_id`, `first_name`, `last_name`, `phone`, `registration_time`, `password`, `Account_Type`) VALUES
(65, 'sharew5m123@gmail.com', 'reys', 'rudt', 0, '2024-04-01 17:02:49', 'e4f194cba29960e12d8b8f1bfedc972b', 'User'),
(67, 'sham1234@gmail.com', 'Sham', 'das', 0, '2024-04-01 17:02:55', 'e10adc3949ba59abbe56e057f20f883e', 'User'),
(68, 'Jieying@gmail.com', 'Jieying', 'chong', 0, '2024-04-01 17:15:46', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(69, 'anna@gmail.com', 'Shi Ying', 'Chang', 123456789, '2024-04-01 17:03:22', '827ccb0eea8a706c4c34a16891f84e7b', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `users_products`
--

CREATE TABLE `users_products` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `order_date` date DEFAULT current_timestamp(),
  `order_time` time DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_products`
--

INSERT INTO `users_products` (`order_id`, `user_id`, `item_id`, `quantity`, `status`, `order_date`, `order_time`) VALUES
(10, 69, 2, NULL, 'Confirmed', NULL, NULL),
(11, 69, 1, NULL, 'Confirmed', NULL, NULL),
(12, 69, 2, NULL, 'Confirmed', NULL, NULL),
(13, 69, 1, NULL, 'Confirmed', NULL, NULL),
(14, 69, 2, NULL, 'Confirmed', NULL, NULL),
(15, 69, 1, NULL, 'Confirmed', NULL, NULL),
(16, 69, 2, NULL, 'Confirmed', '2024-04-02', '10:58:48'),
(17, 69, 4, NULL, 'Confirmed', '2024-04-02', '10:58:50'),
(18, 69, 7, NULL, 'Confirmed', '2024-04-02', '10:58:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_products`
--
ALTER TABLE `users_products`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_item_id` (`item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users_products`
--
ALTER TABLE `users_products`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_products`
--
ALTER TABLE `users_products`
  ADD CONSTRAINT `fk_item_id` FOREIGN KEY (`item_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
