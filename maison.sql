-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2026 at 01:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maison`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `description`, `price`, `image`, `created_at`) VALUES
(1, 'Chocolate Chip Cookie', 'Cookies', 'Delicious chocolate chip cookie', 2.50, 'img/Cookie_in_Mid-Break_with_Chocolate_Chips__1_-removebg-preview.png', '2026-01-07 00:11:55'),
(2, 'Green Meadow Cookie', 'Cookies', 'Fresh matcha flavored cookie', 3.00, 'img/Partially_Broken_Matcha_Cookie_Flight__1_-removebg-preview.png', '2026-01-07 00:11:55'),
(3, 'Dark Velvet Cookie', 'Cookies', 'Rich dark chocolate cookie', 3.50, 'img/Crumbled_Chocolate_Cookie_Delight__1_-removebg-preview.png', '2026-01-07 00:11:55'),
(4, 'CocoBerry Crave Cookie', 'Cookies', 'Oatmeal raisin cookie with a berry twist', 3.00, 'img/Broken_Oatmeal_Raisin_Cookie_in_Air__1_-removebg-preview (1).png', '2026-01-07 00:11:55'),
(5, 'Peanut Glow Cookie', 'Cookies', 'Peanut butter cookie delight', 2.50, 'img/Crumbled_Peanut_Butter_Delight__1_-removebg-preview.png', '2026-01-07 00:11:55'),
(6, 'Blueberry Burst', 'Muffins', 'Delicious blueberry muffin', 2.80, 'img/Screenshot (411).png', '2026-01-07 00:11:55'),
(7, 'Double Chocolate', 'Muffins', 'Rich double chocolate muffin', 3.20, 'img/Screenshot (412).png', '2026-01-07 00:11:55'),
(8, 'Vanilla Dream', 'Muffins', 'Irresistible vanilla muffin', 2.50, 'img/vanilla-dream-irresistible-vanilla-muffin-white-table_351987-1858.jpg', '2026-01-07 00:11:55'),
(9, 'Red Velvet', 'Muffins', 'Classic red velvet muffin', 3.00, 'img/Screenshot (407).png', '2026-01-07 00:11:55'),
(10, 'Blueberry Bliss', 'Donuts', 'Tasty blueberry donut', 2.00, 'img/Screenshot__402_-removebg-preview.png', '2026-01-07 00:11:55'),
(11, 'Chocolate Frosted', 'Donuts', 'Chocolate frosted donut', 2.50, 'img/Screenshot__397_-removebg-preview.png', '2026-01-07 00:11:55'),
(12, 'Strawberry Sprinkle', 'Donuts', 'Strawberry sprinkled donut', 2.50, 'img/Screenshot__365_-removebg-preview.png', '2026-01-07 00:11:55'),
(13, 'Caramel Crunch', 'Donuts', 'Caramel flavored crunchy donut', 3.00, 'img/Screenshot__400_-removebg-preview.png', '2026-01-07 00:11:55'),
(14, 'Classic Glazed', 'Donuts', 'Classic glazed donut', 2.00, 'img/Glazed-Donuts--removebg-preview.png', '2026-01-07 00:11:55'),
(15, 'Sugar Cloud', 'Donuts', 'Soft sugar donut', 2.50, 'img/Screenshot__403_-removebg-preview.png', '2026-01-07 00:11:55'),
(16, 'Golden Nut Pistachio', 'Donuts', 'Pistachio nut donut', 3.50, 'img/Screenshot__414_-removebg-preview.png', '2026-01-07 00:11:55'),
(17, 'Snowy Bliss', 'Donuts', 'Sweet snowy donut', 3.00, 'img/Screenshot__405_-removebg-preview.png', '2026-01-07 00:11:55'),
(18, 'Strawberry Dream', 'Macarons', 'Sweet strawberry macaron', 3.00, 'img/Screenshot__418_-removebg-preview.png', '2026-01-07 00:11:55'),
(19, 'Choco Delight', 'Macarons', 'Chocolate flavored macaron', 3.20, 'img/Screenshot__423_-removebg-preview.png', '2026-01-07 00:11:55'),
(20, 'Pistachio Bliss', 'Macarons', 'Pistachio flavored macaron', 3.50, 'img/Screenshot__419_-removebg-preview.png', '2026-01-07 00:11:55'),
(21, 'Vanilla Cloud', 'Macarons', 'Soft vanilla macaron', 3.00, 'img/Screenshot__422_-removebg-preview.png', '2026-01-07 00:11:55'),
(22, 'Lemon Spark', 'Macarons', 'Zesty lemon macaron', 3.10, 'img/Screenshot__420_-removebg-preview (1).png', '2026-01-07 00:11:55'),
(23, 'Raspberry Rose', 'Macarons', 'Raspberry rose macaron', 3.40, 'img/Screenshot__424_-removebg-preview.png', '2026-01-07 00:11:55'),
(24, 'Dark Chocolate', 'Chocolates', 'Rich dark chocolate', 5.00, 'img/Screenshot__427_-removebg-preview.png', '2026-01-07 00:11:55'),
(25, 'Milk Chocolate', 'Chocolates', 'Creamy milk chocolate', 4.50, 'img/Screenshot__428_-removebg-preview.png', '2026-01-07 00:11:55'),
(26, 'White Chocolate', 'Chocolates', 'Smooth white chocolate', 4.80, 'img/2gg795cc7v4kwp7ni73aqfhpm09275pqas5kx3q30dpz2n3esdpjo7kinlxx-w1750-q85-removebg-preview.png', '2026-01-07 00:11:55'),
(27, 'Hazelnut Chocolate', 'Chocolates', 'Chocolate with hazelnuts', 5.50, 'img/Screenshot__430_-removebg-preview.png', '2026-01-07 00:11:55'),
(28, 'Hot Brownie', 'Brownies', 'Delicious hot brownie', 6.00, 'img/Screenshot__368_-removebg-preview.png', '2026-01-07 00:11:55'),
(29, 'Chocolate Brownie', 'Brownies', 'Classic chocolate brownie', 6.50, 'img/Screenshot__431_-removebg-preview.png', '2026-01-07 00:11:55'),
(30, 'Caramel Brownie', 'Brownies', 'Caramel flavored brownie', 7.00, 'img/Screenshot__433_-removebg-preview.png', '2026-01-07 00:11:55'),
(31, 'Classic Croissant', 'Croissants', 'Flaky classic croissant', 3.50, 'img/Screenshot__434_-removebg-preview.png', '2026-01-07 00:11:55'),
(32, 'Chocolate Croissant', 'Croissants', 'Croissant filled with chocolate', 4.00, 'img/Screenshot__436_-removebg-preview.png', '2026-01-07 00:11:55'),
(33, 'Almond Croissant', 'Croissants', 'Croissant topped with almonds', 4.20, 'img/Screenshot__437_-removebg-preview.png', '2026-01-07 00:11:55'),
(34, 'Caramel Croissant', 'Croissants', 'Croissant with caramel drizzle', 4.50, 'img/Screenshot__438_-removebg-preview.png', '2026-01-07 00:11:55'),
(35, 'Hazelnut Praline', 'Pralines', 'Smooth hazelnut cream.', 2.50, 'img/image.png', '2026-01-07 00:11:55'),
(36, 'Dark Choco Praline', 'Pralines', 'Rich dark chocolate.', 2.80, 'img/image1.jpg', '2026-01-07 00:11:55'),
(37, 'Almond Crunch', 'Pralines', 'Crispy almond center.', 2.60, 'img/image3.jpg', '2026-01-07 00:11:55'),
(38, 'Caramel Heart', 'Pralines', 'Soft caramel filling.', 2.40, 'img/image4.jpg', '2026-01-07 00:11:55'),
(39, 'Luxury Signature', 'Pralines', 'Premium gourmet praline.', 3.00, 'img/image5.jpg', '2026-01-07 00:11:55'),
(40, 'Red Wine', 'Wine', 'Full-bodied red with notes of cherry.', 15.00, 'img/Screenshot__465_-removebg-preview.png', '2026-01-07 00:11:55'),
(41, 'White Wine', 'Wine', 'Crisp and fresh white wine.', 14.50, 'img/Screenshot__460_-removebg-preview.png', '2026-01-07 00:11:55'),
(42, 'Rosé Wine', 'Wine', 'Fruity and refreshing rosé.', 16.00, 'img/Screenshot__457_-removebg-preview.png', '2026-01-07 00:11:55'),
(43, 'Sparkling Wine', 'Wine', 'Elegant sparkling wine with bubbles.', 18.00, 'img/Screenshot__461_-removebg-preview.png', '2026-01-07 00:11:55'),
(44, 'Strawberry Boba', 'Boba', 'Sweet strawberry flavored boba with milk.', 5.00, 'img/Screenshot__469_-removebg-preview.png', '2026-01-07 00:11:55'),
(45, 'Taro Boba', 'Boba', 'Delicious taro flavored boba with milk.', 5.50, 'img/Screenshot__470_-removebg-preview.png', '2026-01-07 00:11:55'),
(46, 'Matcha Boba', 'Boba', 'Creamy matcha flavored boba.', 6.00, 'img/unnamed-removebg-preview.png', '2026-01-07 00:11:55'),
(47, 'Brown Sugar Boba', 'Boba', 'Rich brown sugar boba drink.', 6.50, 'img/Screenshot__471_-removebg-preview.png', '2026-01-07 00:11:55'),
(48, 'Sphère Gift Box x 20 pcs', 'Gift Box', 'A luxurious selection of spherical chocolate pralines!', 26.00, 'img/dhurata.webp', '2026-01-07 00:11:55'),
(49, 'Mini Bar Gift Box Size L', 'Gift Box', 'Assorted mini chocolate bars in a convenient gift box!', 42.00, 'img/dhurata1.webp', '2026-01-07 00:11:55'),
(50, 'Mini Bar Gift Box Size XL', 'Gift Box', 'Dark and Milk Ganache flavored with Champagne', 60.00, 'img/dhurata2.webp', '2026-01-07 00:11:55'),
(51, 'Love Gift Box', 'Gift Box', 'A romantic assortment of chocolates, crafted to delight', 48.00, 'img/dhurata3.webp', '2026-01-07 00:11:55'),
(52, 'Party Gift Box', 'Gift Box', 'A festive assortment of chocolates!', 115.00, 'img/dhurata4.webp', '2026-01-07 00:11:55'),
(53, 'La Bomb Gift Box', 'Gift Box', 'Explosive flavors in every chocolate', 85.00, 'img/dhurata5.webp', '2026-01-07 00:11:55'),
(54, 'Classic Cheesecake', 'Cheesecakes', 'Smooth and creamy classic cheesecake', 6.99, 'img/Screenshot__370_-removebg-preview.png', '2026-01-07 00:11:55'),
(55, 'Strawberry Cheesecake', 'Cheesecakes', 'Fresh strawberry topping on creamy cheesecake', 7.50, 'img/Screenshot__443_-removebg-preview.png', '2026-01-07 00:11:55'),
(56, 'Blueberry Cheesecake', 'Cheesecakes', 'Delicious blueberry cheesecake', 7.00, 'img/Screenshot__448_-removebg-preview.png', '2026-01-07 00:11:55'),
(57, 'Chocolate Cheesecake', 'Cheesecakes', 'Rich chocolate cheesecake', 8.00, 'img/Screenshot__444_-removebg-preview.png', '2026-01-07 00:11:55'),
(58, 'Caramel Cheesecake', 'Cheesecakes', 'Cheesecake with caramel drizzle', 8.50, 'img/Screenshot__449_-removebg-preview.png', '2026-01-07 00:11:55'),
(59, 'Lemon Cheesecake', 'Cheesecakes', 'Zesty lemon flavored cheesecake', 6.50, 'img/Screenshot__445_-removebg-preview.png', '2026-01-07 00:11:55'),
(60, 'Raspberry Cheesecake', 'Cheesecakes', 'Fresh raspberry topping on cheesecake', 7.80, 'img/Screenshot__450_-removebg-preview.png', '2026-01-07 00:11:55'),
(61, 'Oreo Cheesecake', 'Cheesecakes', 'Cheesecake with Oreo cookie crust', 8.20, 'img/Screenshot__451_-removebg-preview.png', '2026-01-07 00:11:55'),
(62, 'Matcha Cheesecake', 'Cheesecakes', 'Creamy matcha flavored cheesecake', 8.00, 'img/Screenshot__452_-removebg-preview.png', '2026-01-07 00:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
