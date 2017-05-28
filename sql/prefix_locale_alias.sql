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
-- Struktura tabulky `prefix_locale_alias`
--

CREATE TABLE `prefix_locale_alias` (
  `id` int(11) NOT NULL,
  `id_locale` int(11) NOT NULL COMMENT 'vazba na jazyk',
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
