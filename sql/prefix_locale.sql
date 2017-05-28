-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vytvořeno: Ned 28. kvě 2017, 23:51
-- Verze serveru: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- Verze PHP: 7.0.15-0ubuntu0.16.04.4

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
  `id` int(11) NOT NULL,
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
