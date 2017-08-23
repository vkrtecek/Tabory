-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 16. zář 2015, 10:16
-- Verze serveru: 5.6.17
-- Verze PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `vlcata_items`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `popis` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `obrazek` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `platnost` tinyint(4) NOT NULL DEFAULT '1',
  `kategorie` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `verejne` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `kategory`
--

CREATE TABLE IF NOT EXISTS `kategory` (
  `id_kategory` tinyint(4) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `kategorie_nazev` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `garant` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_kategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Vypisuji data pro tabulku `kategory`
--

INSERT INTO `kategory` (`id_kategory`, `jmeno`, `kategorie_nazev`, `garant`) VALUES
(1, 'klubovna', 'Klubovna', 'Salo (733741128)'),
(2, 'naradi', 'Nářadí', 'Krtek (733756575)'),
(3, 'prevleky', 'Převleky', 'Kuba (737666414)'),
(4, 'elektro', 'Elektronika', 'Rony (776817698)'),
(5, 'kroje', 'Krojový bazar', 'Mac (733573315)'),
(6, 'hry', 'Herní náčiní', 'Tazi (605209755)'),
(7, 'prani', 'Přání ke koupi', 'Jeňa (732573281)');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `prezdivka` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`ID`),
  FULLTEXT KEY `heslo` (`heslo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`ID`, `jmeno`, `prijmeni`, `prezdivka`, `email`, `heslo`) VALUES
(1, 'Vojtěch', 'Stuchlík', 'Krtek', 'krtek@zlin6.cz', 'klubovna'),
(2, 'Vojtěch', 'Jurák', 'Broskev', 'broskev@zlin6.cz', 'klubovna'),
(3, 'Jan', 'Fojtů', 'Jeňa', 'jena@zlin6.cz', 'klubovna'),
(4, 'Jakub', 'Doležel', 'Rony', 'rony@zlin6.cz', 'klubovna'),
(5, 'Vojtěch', 'Bernátek', 'Nemo', 'nemo@zlin6.cz', 'klubovna'),
(6, 'Martin', 'Salák', 'Salo', 'salo@zlin6.cz', 'klubovna'),
(7, 'František', 'Chvatík', 'Tazi', 'tazi@zlin6.cz', 'klubovna'),
(8, 'Jakub', 'Fojtů', 'Kuba', 'kuba@zlin6.cz', 'klubovna'),
(9, 'Dominik', 'Koutný', 'Čmelda', 'cmelda@zlin6.cz', 'klubovna'),
(10, 'Martin', 'Šrajer', 'Martin', 'martin@zlin6.cz', 'klubovna'),
(11, 'Jiří', 'Mahdalík', 'Jirka', 'jirka@zlin6.cz', 'klubovna'),
(12, 'Matěj', 'Komínek', 'Matěj', 'matěj@zlin6.cz', 'klubovna'),
(13, 'Lukáš', 'Klinkovský', 'Logen', 'logen@zlin6.cz', 'klubovna'),
(14, 'David', 'Hrubý', 'Dale', 'dale@zlin6.cz', 'klubovna'),
(15, 'Martin', 'Vítek', 'Mac', 'mac@zlin6.cz', 'klubovna'),
(16, 'Zdeněk', 'Hrabčík', 'Zdeňa', 'zdena@zlin6.cz', 'klubovna'),
(17, 'Dominik', 'Caha', 'Dominik', 'dominik@zlin6.cz', 'klubovna'),
(18, 'Jiří', 'Polášek', 'Holub', 'holub@zlin6.cz', 'klubovna');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
