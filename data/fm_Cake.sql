-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Erstellungszeit: 03. Mrz 2016 um 15:48
-- Server-Version: 5.5.42
-- PHP-Version: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fm_Cake`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `components`
--

CREATE TABLE `components` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `components_pois`
--

CREATE TABLE `components_pois` (
  `id` int(11) NOT NULL,
  `components_id` int(11) NOT NULL,
  `pois_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modiefied` datetime NOT NULL,
  `stage` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `components_scenarios`
--

CREATE TABLE `components_scenarios` (
  `id` int(11) NOT NULL,
  `components_id` int(11) NOT NULL,
  `scenarios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pois`
--

CREATE TABLE `pois` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `google_place` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `vicinity` varchar(45) DEFAULT NULL,
  `formatted_phone_number` varchar(45) DEFAULT NULL,
  `mail` varchar(45) DEFAULT NULL,
  `website` varchar(209) DEFAULT NULL,
  `social` varchar(209) DEFAULT NULL,
  `description` tinytext,
  `user_ratings_total` int(11) DEFAULT NULL,
  `opening_hours` varchar(45) DEFAULT NULL,
  `weekday_text` varchar(45) DEFAULT NULL,
  `photos` int(11) DEFAULT NULL,
  `reviews` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pois_tags`
--

CREATE TABLE `pois_tags` (
  `id` int(11) NOT NULL COMMENT '		',
  `pois_id` int(11) NOT NULL,
  `tags_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `scenarios`
--

CREATE TABLE `scenarios` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `thumbnail` varchar(45) DEFAULT NULL,
  `counter` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `scenarios`
--

INSERT INTO `scenarios` (`id`, `created`, `modified`, `name`, `description`, `thumbnail`, `counter`) VALUES
(0, '2016-02-25 10:42:46', '2016-02-25 10:42:46', 'sdfsdf', 'sfdfsdf', 'sdffdsg', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `tags`
--

INSERT INTO `tags` (`id`, `title`, `created`, `modified`) VALUES
(25, 'store', '2016-03-03 12:00:00', '2016-03-03 12:00:00');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `components`
--
ALTER TABLE `components`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `components_pois`
--
ALTER TABLE `components_pois`
  ADD PRIMARY KEY (`id`,`components_id`,`pois_id`),
  ADD KEY `fk_c_length_components1_idx` (`components_id`),
  ADD KEY `fk_c_length_POIS1_idx` (`pois_id`);

--
-- Indizes für die Tabelle `components_scenarios`
--
ALTER TABLE `components_scenarios`
  ADD PRIMARY KEY (`id`,`components_id`,`scenarios_id`),
  ADD KEY `fk_ScenarioComponents_scenarios1_idx` (`scenarios_id`),
  ADD KEY `fk_ScenarioComponents_components1_idx` (`components_id`);

--
-- Indizes für die Tabelle `pois`
--
ALTER TABLE `pois`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pois_tags`
--
ALTER TABLE `pois_tags`
  ADD PRIMARY KEY (`id`,`pois_id`,`tags_id`),
  ADD KEY `fk_POITags_POIS1_idx` (`pois_id`),
  ADD KEY `fk_POITags_tags1_idx` (`tags_id`);

--
-- Indizes für die Tabelle `scenarios`
--
ALTER TABLE `scenarios`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `pois`
--
ALTER TABLE `pois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT für Tabelle `pois_tags`
--
ALTER TABLE `pois_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '		';
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `components_pois`
--
ALTER TABLE `components_pois`
  ADD CONSTRAINT `fk_c_length_components1` FOREIGN KEY (`components_id`) REFERENCES `components` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_c_length_POIS1` FOREIGN KEY (`pois_id`) REFERENCES `pois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `components_scenarios`
--
ALTER TABLE `components_scenarios`
  ADD CONSTRAINT `fk_ScenarioComponents_components1` FOREIGN KEY (`components_id`) REFERENCES `components` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ScenarioComponents_scenarios1` FOREIGN KEY (`scenarios_id`) REFERENCES `scenarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `pois_tags`
--
ALTER TABLE `pois_tags`
  ADD CONSTRAINT `fk_POITags_POIS1` FOREIGN KEY (`pois_id`) REFERENCES `pois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_POITags_tags1` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
