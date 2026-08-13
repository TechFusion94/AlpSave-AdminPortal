-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 28. Jun 2026 um 16:07
-- Server-Version: 8.4.4
-- PHP-Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `app_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pricing_plans`
--

CREATE TABLE `pricing_plans` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `billing_period` varchar(20) NOT NULL DEFAULT 'month',
  `tagline` varchar(255) NOT NULL DEFAULT '',
  `features` text NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `pricing_plans`
--

INSERT INTO `pricing_plans` (`id`, `name`, `price`, `billing_period`, `tagline`, `features`, `is_featured`, `sort_order`) VALUES
(1, 'Basic', 5.00, 'month', 'A smart overview of your finances and saving goals.', 'Overview dashboard\nWeekly reports\nSmart budgeting', 0, 1),
(2, 'Expert', 20.00, 'month', 'Everything you need for serious, automated saving.', 'Automated planning\n3a optimization\nSaving & projections\nMulti-account support', 1, 2),
(3, 'Plus', 10.00, 'month', 'Advanced insights to take your finances further.', 'Everything in Basic\nAdvanced insights\nInvestment simulator', 0, 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `uploads`
--

CREATE TABLE `uploads` (
  `id` int NOT NULL,
  `path` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `uploads`
--

INSERT INTO `uploads` (`id`, `path`, `alt`) VALUES
(5, 'uploads/2026/06/27/6a4032614ece5.webp', 'AlpSave Logo');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(20) NOT NULL DEFAULT '',
  `department` varchar(20) NOT NULL DEFAULT '',
  `terms` tinyint(1) NOT NULL DEFAULT '0',
  `notifications` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`, `department`, `terms`, `notifications`, `avatar`) VALUES
(1, 'testadmin', 'test@alpsave.ch', '$2y$12$soiYO.tUvOs6hshDLThDd.Rkmjd2Nh0ri6un0osD5yH6IuBlA5K/y', '2026-05-02 22:00:51', 'super_admin', '', 0, 0, NULL),
(9, 'smueller', 's.mueller@alpsave.ch', '$2y$12$OFjiX0/Jm.hEgt3685S6YuIVJUYqCs6NeFoBz58NULtZ3VS0EFz6K', '2026-06-18 09:14:00', 'data_manager', 'finance', 1, 1, NULL),
(10, 'jpfeiffer', 'j.pfeiffer@alpsave.ch', '$2y$12$OFjiX0/Jm.hEgt3685S6YuIVJUYqCs6NeFoBz58NULtZ3VS0EFz6K', '2026-06-19 11:02:00', 'admin', 'engineering', 1, 0, NULL),
(11, 'akeller', 'a.keller@alpsave.ch', '$2y$12$OFjiX0/Jm.hEgt3685S6YuIVJUYqCs6NeFoBz58NULtZ3VS0EFz6K', '2026-06-20 15:40:00', 'read_only', 'operations', 1, 1, NULL),
(12, 'rbecker', 'r.becker@alpsave.ch', '$2y$12$OFjiX0/Jm.hEgt3685S6YuIVJUYqCs6NeFoBz58NULtZ3VS0EFz6K', '2026-06-21 08:25:00', 'admin', 'hr', 1, 0, NULL),
(13, 'lweber', 'l.weber@alpsave.ch', '$2y$12$OFjiX0/Jm.hEgt3685S6YuIVJUYqCs6NeFoBz58NULtZ3VS0EFz6K', '2026-06-22 13:10:00', 'super_admin', 'marketing', 1, 1, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `pricing_plans`
--
ALTER TABLE `pricing_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pricing_plans`
--
ALTER TABLE `pricing_plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT für Tabelle `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
