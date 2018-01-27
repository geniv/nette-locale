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
-- Struktura tabulky `prefix_locale_alias`
--

CREATE TABLE `prefix_locale_alias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_locale` bigint(20) UNSIGNED NOT NULL COMMENT 'vazba na jazyk',
  `alias` varchar(10) DEFAULT NULL COMMENT 'alias jazyka'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='aliasy jazyku';

--
-- Vypisuji data pro tabulku `prefix_locale_alias`
--

INSERT INTO `prefix_locale_alias` (`id`, `id_locale`, `alias`) VALUES
(1, 1, 'sk'),
(2, 2, 'de');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `prefix_locale_alias`
--
ALTER TABLE `prefix_locale_alias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_locale_alias_locale_idx` (`id_locale`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `prefix_locale_alias`
--
ALTER TABLE `prefix_locale_alias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `prefix_locale_alias`
--
ALTER TABLE `prefix_locale_alias`
  ADD CONSTRAINT `fk_locale_alias_locale` FOREIGN KEY (`id_locale`) REFERENCES `prefix_locale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
