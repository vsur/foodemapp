-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Erstellungszeit: 08. Mrz 2016 um 15:32
-- Server-Version: 5.5.42
-- PHP-Version: 5.5.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fm_cake`
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
  `component_id` int(11) NOT NULL,
  `poi_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modiefied` datetime NOT NULL,
  `stage` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `components_scenarios`
--

CREATE TABLE `components_scenarios` (
  `component_id` int(11) NOT NULL,
  `scenario_id` int(11) NOT NULL
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pois_tags`
--

CREATE TABLE `pois_tags` (
  `poi_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  ADD PRIMARY KEY (`component_id`,`poi_id`),
  ADD KEY `fk_cp_poi_key(poi_id)` (`poi_id`),
  ADD KEY `fk_cp_component_key(component_id)` (`component_id`);

--
-- Indizes für die Tabelle `components_scenarios`
--
ALTER TABLE `components_scenarios`
  ADD PRIMARY KEY (`component_id`,`scenario_id`),
  ADD KEY `fk_cs_scenario_key(scenario_id)` (`scenario_id`),
  ADD KEY `fk_cs_components_key(component_id)` (`component_id`);

--
-- Indizes für die Tabelle `pois`
--
ALTER TABLE `pois`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pois_tags`
--
ALTER TABLE `pois_tags`
  ADD PRIMARY KEY (`poi_id`,`tag_id`),
  ADD KEY `fk_pt_tag_key(tag_id)` (`tag_id`),
  ADD KEY `fk_pt_poi_key(poi_id)` (`poi_id`);

--
-- Indizes für die Tabelle `scenarios`
--
ALTER TABLE `scenarios`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `components`
--
ALTER TABLE `components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `pois`
--
ALTER TABLE `pois`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `scenarios`
--
ALTER TABLE `scenarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `components_pois`
--
ALTER TABLE `components_pois`
  ADD CONSTRAINT `fk_cp_component_key(component_id)` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cp_poi_key(poi_id)` FOREIGN KEY (`poi_id`) REFERENCES `pois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `components_scenarios`
--
ALTER TABLE `components_scenarios`
  ADD CONSTRAINT `fk_cs_scenario_key(scenario_id)` FOREIGN KEY (`scenario_id`) REFERENCES `scenarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cs_components_key(component_id)` FOREIGN KEY (`component_id`) REFERENCES `components` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `pois_tags`
--
ALTER TABLE `pois_tags`
  ADD CONSTRAINT `fk_pt_tag_key(tag_id)` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pt_poi_key(poi_id)` FOREIGN KEY (`poi_id`) REFERENCES `pois` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
