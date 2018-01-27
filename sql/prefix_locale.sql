-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Sob 27. led 2018, 20:27
-- Verze serveru: 10.1.26-MariaDB-0+deb9u1
-- Verze PHP: 7.0.27-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `netteweb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `prefix_locale`
--

CREATE TABLE `prefix_locale` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) DEFAULT NULL COMMENT 'kod jazyka',
  `name` varchar(50) DEFAULT NULL COMMENT 'jmeno jazyka',
  `plural` varchar(255) DEFAULT NULL,
  `main` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='jazyky';

--
-- Vypisuji data pro tabulku `prefix_locale`
--

INSERT INTO `prefix_locale` (`id`, `code`, `name`, `plural`, `main`, `active`) VALUES
(1, 'cs', 'Čeština', '$nplurals=3; $plural=($n==1) ? 1 : (($n>=2 && $n<=4) ? 2 : 0);', 1, 1),
(2, 'en', 'English', '$nplurals=2; $plural=($n != 1) ? 0 : 1;', 0, 1),
(3, 'de', 'Deutsch', '$nplurals=2; $plural=($n != 1) ? 0 : 1;', 0, 1);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_locale`
--
ALTER TABLE `prefix_locale`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code_UNIQUE` (`code`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_locale`
--
ALTER TABLE `prefix_locale`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
