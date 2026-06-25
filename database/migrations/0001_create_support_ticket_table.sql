-- =========================================================
-- Migration: create_support_ticket_table
-- Tabel ini BELUM ada di dump barnowl_store__1_.sql,
-- dibutuhkan oleh fitur Support Center (SupportController + SupportTicket model).
--
-- Cara pakai: import file ini ke database `barnowl_store` yang sudah ada
-- (lewat phpMyAdmin -> Import, atau `mysql -u root barnowl_store < ini.sql`)
-- SETELAH barnowl_store__1_.sql, karena ada FOREIGN KEY ke tabel `user`.
-- =========================================================

CREATE TABLE `support_ticket` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_ticket_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `support_ticket`
  ADD CONSTRAINT `fk_ticket_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;
