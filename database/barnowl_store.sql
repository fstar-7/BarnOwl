-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2026 at 03:17 PM
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
-- Database: `barnowl_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner_sale`
--

CREATE TABLE `banner_sale` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `discount_text` varchar(50) DEFAULT NULL,
  `button_text` varchar(100) NOT NULL DEFAULT 'Browse Deals',
  `link_url` varchar(255) NOT NULL DEFAULT '/games?shortcut=promo',
  `bg_mode` enum('gradient','image') NOT NULL DEFAULT 'gradient',
  `bg_color_from` varchar(20) NOT NULL DEFAULT '#4c1d95',
  `bg_color_to` varchar(20) NOT NULL DEFAULT '#9333ea',
  `bg_image` varchar(255) DEFAULT NULL,
  `overlay_opacity` decimal(3,2) NOT NULL DEFAULT 0.40,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner_sale`
--

INSERT INTO `banner_sale` (`id`, `title`, `subtitle`, `description`, `discount_text`, `button_text`, `link_url`, `bg_mode`, `bg_color_from`, `bg_color_to`, `bg_image`, `overlay_opacity`, `is_active`) VALUES
(1, 'Mega Sale Weekend!', 'Penawaran terbatas hanya hari ini', NULL, '80%', 'Browse Deals', '/games?shortcut=promo', 'gradient', '#4c1d95', '#9333ea', NULL, 0.40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) NOT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `game_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `title`, `subtitle`, `description`, `image`, `order`, `is_active`, `game_id`) VALUES
(1, 'SCRAPWORLD: DUST & DIESEL', 'NOW AVAILABLE', 'Rasakan dunia cyberpunk yang tak terbatas.', 'scrapworld.png', 2, 1, 1),
(2, 'Voidborn: Echoes of the Eclipse', 'NEW RELEASE', 'Bertahan hidup di pulau yang penuh misteri.', 'voidborn.png', 3, 1, 2),
(3, 'CubeForge: Deep Earth', 'PLAY WITH FRIENDS', 'Co-op horror yang akan membuatmu tegang.', 'cubeforge.png', 4, 1, 5),
(4, 'Anima-L', 'NOW AVAILABLE', 'Rasakan dunia cyberpunk yang tak terbatas.', 'anima-l.png', 5, 1, 4),
(5, 'Amberwood Grove', 'NEW RELEASE', 'Bertahan hidup di pulau yang penuh misteri.', 'amberwood.png', 1, 1, 5),
(6, 'Shattered Nexus', 'MOBA', 'Co-op horror yang akan membuatmu tegang.', 'nexus.png', 6, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `price` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `discount` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `rating` decimal(3,1) NOT NULL DEFAULT 0.0,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('featured','new_release','regular') NOT NULL DEFAULT 'regular',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `name`, `description`, `thumbnail`, `banner`, `price`, `discount`, `rating`, `views`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Scrapworld: Dust & Diesel', 'Welcome to Scrapworld, a barren post-apocalyptic wasteland where the law no longer exists. Take control of your custom-built monster vehicles, lead a gang of outlaws, and fight for survival amidst deadly sandstorms and ruthless enemy factions. Dust, diesel, and blood—the choice is yours.', 'scrapworld.png', 'scrapworld.png', 350000, 20, 4.8, 15200, 'featured', '2026-06-24 09:29:36', '2026-06-25 07:09:49'),
(2, 'Voidborn: Echoes of the Eclipse', 'Awaken as a soulless warrior in a dying gothic world consumed by an eternal cosmic eclipse. Armed with a mystical spear and bounded by a tragic destiny, wander through foggy ruins, challenge fallen gods, and harness the volatile power of the Void. Can you survive the echoes of the eclipse?', 'voidborn.png', 'voidborn.png', 199000, 0, 4.5, 8700, 'featured', '2026-06-24 09:29:36', '2026-06-25 08:03:18'),
(3, 'CubeForge: Deep Earth', 'Dig deep into a completely destructible blocky world in CubeForge: Deep Earth! Build massive automated mines, craft unique steampunk machinery, and defend your underground colonies from ancient mechanical threats. Grab your pickaxe—adventure awaits in the depths!', 'cubeforge.png', 'cubeforge.png', 249000, 10, 4.6, 12300, 'featured', '2026-06-24 09:29:36', '2026-06-25 08:57:12'),
(4, 'Anima-L', 'Hack, upgrade, and fight alongside bio-mechanical beasts in Anima-L! In a neon-drenched cyberpunk world ruled by corrupt mega-corporations, tame digital monsters, equip them with lethal laser weapons and high-tech gadgets, and execute high-stakes tactical heists to liberate the city.', 'anima-l.png', 'anima-l.png', 0, 0, 4.2, 5400, 'featured', '2026-06-24 09:29:36', '2026-06-25 08:38:07'),
(5, 'Amberwood Grove', 'Escape to a magical countryside in Amberwood Grove! Inherit a hidden cottage, grow glowing mystical crops, brew helpful herbal potions for the local villagers, and befriend the whimsical spirits of the forest in this cozy pixel-art witchcraft farming sim.', 'amberwood.png', 'amberwood.png', 159000, 30, 4.7, 9800, 'new_release', '2026-06-24 09:29:36', '2026-06-25 09:10:10'),
(6, 'Shattered Nexus', 'Magic vs. Technology Warfare: Choose your side or mix the ultimate team. Dominate the arena by combining the raw, destructive power of ancient elemental sorcery and divine magic with the precision, firepower, and shields of cutting-edge futuristic technology.', 'nexus.png', 'nexus.png', 350000, 20, 4.8, 15200, 'featured', '2026-06-25 00:59:51', '2026-06-25 09:25:32'),
(7, 'Shadow Realm', 'Action game dengan mekanik stealth.', 'game2.png', NULL, 199000, 0, 4.5, 8700, 'featured', '2026-06-25 00:59:51', '2026-06-25 00:59:51'),
(8, 'Lost Archipelago', 'Survival adventure di pulau terpencil.', 'game3.png', NULL, 249000, 10, 4.6, 12300, 'new_release', '2026-06-25 00:59:51', '2026-06-25 00:59:51'),
(9, 'Pixel Kingdom', 'Strategy game berbasis pixel art.', 'game4.png', NULL, 0, 0, 4.2, 5400, 'featured', '2026-06-25 00:59:51', '2026-06-25 00:59:51'),
(10, 'Void Hunters', 'Co-op horror shooter.', 'game5.png', NULL, 159000, 30, 4.7, 9800, 'new_release', '2026-06-25 00:59:51', '2026-06-25 00:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `game_genre`
--

CREATE TABLE `game_genre` (
  `game_id` int(10) UNSIGNED NOT NULL,
  `genre_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_genre`
--

INSERT INTO `game_genre` (`game_id`, `genre_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 3),
(3, 3),
(3, 6),
(4, 5),
(4, 7),
(5, 1),
(5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `game_platform`
--

CREATE TABLE `game_platform` (
  `game_id` int(10) UNSIGNED NOT NULL,
  `platform_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(1, 'Action'),
(3, 'Adventure'),
(7, 'Casual'),
(4, 'Horror'),
(2, 'RPG'),
(6, 'Simulation'),
(5, 'Strategy');

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `price_at_buy` int(10) UNSIGNED NOT NULL,
  `discount_at_buy` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`id`, `name`) VALUES
(5, 'Mobile'),
(4, 'Nintendo Switch'),
(1, 'PC'),
(2, 'PlayStation'),
(3, 'Xbox');

-- --------------------------------------------------------

--
-- Table structure for table `store_hero`
--

CREATE TABLE `store_hero` (
  `id` int(10) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL DEFAULT 'Discover',
  `title` varchar(150) NOT NULL DEFAULT 'BARN OWL',
  `title_accent` varchar(100) NOT NULL DEFAULT 'STORE',
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_hero`
--

INSERT INTO `store_hero` (`id`, `label`, `title`, `title_accent`, `description`, `is_active`) VALUES
(1, 'Discover', 'BARN OWL', 'STORE', 'Temukan game legendaris idamanmu dengan penawaran dan harga terbaik.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `support_ticket`
--

CREATE TABLE `support_ticket` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `role`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@barnowl.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, '2026-06-24 09:29:36', '2026-06-24 09:29:36'),
(2, 'Akmal', 'Akmal@mas.com', '$2y$10$DjI5q9h9EVhgzYG0iuSpButRIpRnLyFSB7swo9N1d/TfX78TLyE6m', 'user', NULL, '2026-06-24 10:27:57', '2026-06-24 10:27:57'),
(4, 'egi', 'egi@gm.com', '$2y$10$BvDyOgrzt0zbkh1d1.NAkeq5IsUI7Qw6kvZaoeyZC75TlwGkTT86a', 'admin', NULL, '2026-06-25 01:35:36', '2026-06-25 04:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `game_id`, `created_at`) VALUES
(1, 4, 1, '2026-06-25 04:10:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner_sale`
--
ALTER TABLE `banner_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carousel_game` (`game_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cart` (`user_id`,`game_id`),
  ADD KEY `fk_cart_game` (`game_id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_genre`
--
ALTER TABLE `game_genre`
  ADD PRIMARY KEY (`game_id`,`genre_id`),
  ADD KEY `fk_gg_genre` (`genre_id`);

--
-- Indexes for table `game_platform`
--
ALTER TABLE `game_platform`
  ADD PRIMARY KEY (`game_id`,`platform_id`),
  ADD KEY `fk_gp_platform` (`platform_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_library` (`user_id`,`game_id`),
  ADD KEY `fk_lib_game` (`game_id`),
  ADD KEY `fk_lib_order` (`order_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_oi_order` (`order_id`),
  ADD KEY `fk_oi_game` (`game_id`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `store_hero`
--
ALTER TABLE `store_hero`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_ticket`
--
ALTER TABLE `support_ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ticket_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_wishlist` (`user_id`,`game_id`),
  ADD KEY `fk_wl_game` (`game_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner_sale`
--
ALTER TABLE `banner_sale`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `library`
--
ALTER TABLE `library`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `store_hero`
--
ALTER TABLE `store_hero`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_ticket`
--
ALTER TABLE `support_ticket`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carousel`
--
ALTER TABLE `carousel`
  ADD CONSTRAINT `fk_carousel_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_genre`
--
ALTER TABLE `game_genre`
  ADD CONSTRAINT `fk_gg_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_gg_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_platform`
--
ALTER TABLE `game_platform`
  ADD CONSTRAINT `fk_gp_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_gp_platform` FOREIGN KEY (`platform_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `fk_lib_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `fk_lib_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `fk_lib_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_oi_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `fk_oi_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_ticket`
--
ALTER TABLE `support_ticket`
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wl_game` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wl_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
