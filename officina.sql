-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 08, 2026 alle 09:55
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officina`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `accessorio`
--

CREATE TABLE `accessorio` (
  `id_accessorio` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `accessorio`
--

INSERT INTO `accessorio` (`id_accessorio`, `descrizione`, `costo_unitario`) VALUES
(0, '22', 2.00),
(1, 'Chiave inglese', 1.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `autoveicolo`
--

CREATE TABLE `autoveicolo` (
  `targa` varchar(10) NOT NULL,
  `telaio` varchar(50) DEFAULT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `anno_costruzione` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL,
  `cognome` varchar(50) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `comprende`
--

CREATE TABLE `comprende` (
  `id_intervento` int(11) NOT NULL,
  `id_servizio` int(11) NOT NULL,
  `ore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `dipendente`
--

CREATE TABLE `dipendente` (
  `id_dipendente` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_officina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `dipendente`
--

INSERT INTO `dipendente` (`id_dipendente`, `username`, `password`, `id_officina`) VALUES
(1, 'w', 'w', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `intervento`
--

CREATE TABLE `intervento` (
  `id_intervento` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `id_officina` int(11) DEFAULT NULL,
  `targa` varchar(10) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `magazzino_accessori`
--

CREATE TABLE `magazzino_accessori` (
  `id_officina` int(11) NOT NULL,
  `id_accessorio` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `magazzino_pezzi`
--

CREATE TABLE `magazzino_pezzi` (
  `id_officina` int(11) NOT NULL,
  `id_pezzo` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `officina`
--

CREATE TABLE `officina` (
  `id_officina` int(11) NOT NULL,
  `denominazione` varchar(100) DEFAULT NULL,
  `indirizzo` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `officina`
--

INSERT INTO `officina` (`id_officina`, `denominazione`, `indirizzo`) VALUES
(1, 'letsgo', 'Via Mariano'),
(2, 'mao', 'Via Mao'),
(3, 'Becc & Co', 'Via Becc');

-- --------------------------------------------------------

--
-- Struttura della tabella `offre`
--

CREATE TABLE `offre` (
  `id_officina` int(11) NOT NULL,
  `id_servizio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `pezzo_ricambio`
--

CREATE TABLE `pezzo_ricambio` (
  `id_pezzo` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `pezzo_ricambio`
--

INSERT INTO `pezzo_ricambio` (`id_pezzo`, `descrizione`, `costo_unitario`) VALUES
(1, 'Luci abbaglianti', 21.00),
(2, 'Freni', 11.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `servizio`
--

CREATE TABLE `servizio` (
  `id_servizio` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `costo_orario` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dump dei dati per la tabella `servizio`
--

INSERT INTO `servizio` (`id_servizio`, `descrizione`, `costo_orario`) VALUES
(0, 'ss', 11.00),
(1, 'Cambio gomme', 10.00),
(2, 'Cambio luci', 5.00),
(3, 'Cambio olio', 67.00),
(4, 'Controllo freni', 21.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `tipo_intervento`
--

CREATE TABLE `tipo_intervento` (
  `id_tipo` int(11) NOT NULL,
  `descrizione` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `usa`
--

CREATE TABLE `usa` (
  `id_intervento` int(11) NOT NULL,
  `id_accessorio` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struttura della tabella `utilizza`
--

CREATE TABLE `utilizza` (
  `id_intervento` int(11) NOT NULL,
  `id_pezzo` int(11) NOT NULL,
  `quantita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `accessorio`
--
ALTER TABLE `accessorio`
  ADD PRIMARY KEY (`id_accessorio`);

--
-- Indici per le tabelle `autoveicolo`
--
ALTER TABLE `autoveicolo`
  ADD PRIMARY KEY (`targa`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indici per le tabelle `comprende`
--
ALTER TABLE `comprende`
  ADD PRIMARY KEY (`id_intervento`,`id_servizio`),
  ADD KEY `id_servizio` (`id_servizio`);

--
-- Indici per le tabelle `dipendente`
--
ALTER TABLE `dipendente`
  ADD PRIMARY KEY (`id_dipendente`),
  ADD KEY `id_officina` (`id_officina`);

--
-- Indici per le tabelle `intervento`
--
ALTER TABLE `intervento`
  ADD PRIMARY KEY (`id_intervento`),
  ADD KEY `id_officina` (`id_officina`),
  ADD KEY `targa` (`targa`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_tipo` (`id_tipo`);

--
-- Indici per le tabelle `magazzino_accessori`
--
ALTER TABLE `magazzino_accessori`
  ADD PRIMARY KEY (`id_officina`,`id_accessorio`),
  ADD KEY `id_accessorio` (`id_accessorio`);

--
-- Indici per le tabelle `magazzino_pezzi`
--
ALTER TABLE `magazzino_pezzi`
  ADD PRIMARY KEY (`id_officina`,`id_pezzo`),
  ADD KEY `id_pezzo` (`id_pezzo`);

--
-- Indici per le tabelle `officina`
--
ALTER TABLE `officina`
  ADD PRIMARY KEY (`id_officina`);

--
-- Indici per le tabelle `offre`
--
ALTER TABLE `offre`
  ADD PRIMARY KEY (`id_officina`,`id_servizio`),
  ADD KEY `id_servizio` (`id_servizio`);

--
-- Indici per le tabelle `pezzo_ricambio`
--
ALTER TABLE `pezzo_ricambio`
  ADD PRIMARY KEY (`id_pezzo`);

--
-- Indici per le tabelle `servizio`
--
ALTER TABLE `servizio`
  ADD PRIMARY KEY (`id_servizio`);

--
-- Indici per le tabelle `tipo_intervento`
--
ALTER TABLE `tipo_intervento`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indici per le tabelle `usa`
--
ALTER TABLE `usa`
  ADD PRIMARY KEY (`id_intervento`,`id_accessorio`),
  ADD KEY `id_accessorio` (`id_accessorio`);

--
-- Indici per le tabelle `utilizza`
--
ALTER TABLE `utilizza`
  ADD PRIMARY KEY (`id_intervento`,`id_pezzo`),
  ADD KEY `id_pezzo` (`id_pezzo`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `autoveicolo`
--
ALTER TABLE `autoveicolo`
  ADD CONSTRAINT `autoveicolo_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`);

--
-- Limiti per la tabella `comprende`
--
ALTER TABLE `comprende`
  ADD CONSTRAINT `comprende_ibfk_1` FOREIGN KEY (`id_intervento`) REFERENCES `intervento` (`id_intervento`),
  ADD CONSTRAINT `comprende_ibfk_2` FOREIGN KEY (`id_servizio`) REFERENCES `servizio` (`id_servizio`);

--
-- Limiti per la tabella `dipendente`
--
ALTER TABLE `dipendente`
  ADD CONSTRAINT `dipendente_ibfk_1` FOREIGN KEY (`id_officina`) REFERENCES `officina` (`id_officina`);

--
-- Limiti per la tabella `intervento`
--
ALTER TABLE `intervento`
  ADD CONSTRAINT `intervento_ibfk_1` FOREIGN KEY (`id_officina`) REFERENCES `officina` (`id_officina`),
  ADD CONSTRAINT `intervento_ibfk_2` FOREIGN KEY (`targa`) REFERENCES `autoveicolo` (`targa`),
  ADD CONSTRAINT `intervento_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  ADD CONSTRAINT `intervento_ibfk_4` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_intervento` (`id_tipo`);

--
-- Limiti per la tabella `magazzino_accessori`
--
ALTER TABLE `magazzino_accessori`
  ADD CONSTRAINT `magazzino_accessori_ibfk_1` FOREIGN KEY (`id_officina`) REFERENCES `officina` (`id_officina`),
  ADD CONSTRAINT `magazzino_accessori_ibfk_2` FOREIGN KEY (`id_accessorio`) REFERENCES `accessorio` (`id_accessorio`);

--
-- Limiti per la tabella `magazzino_pezzi`
--
ALTER TABLE `magazzino_pezzi`
  ADD CONSTRAINT `magazzino_pezzi_ibfk_1` FOREIGN KEY (`id_officina`) REFERENCES `officina` (`id_officina`),
  ADD CONSTRAINT `magazzino_pezzi_ibfk_2` FOREIGN KEY (`id_pezzo`) REFERENCES `pezzo_ricambio` (`id_pezzo`);

--
-- Limiti per la tabella `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `offre_ibfk_1` FOREIGN KEY (`id_officina`) REFERENCES `officina` (`id_officina`),
  ADD CONSTRAINT `offre_ibfk_2` FOREIGN KEY (`id_servizio`) REFERENCES `servizio` (`id_servizio`);

--
-- Limiti per la tabella `usa`
--
ALTER TABLE `usa`
  ADD CONSTRAINT `usa_ibfk_1` FOREIGN KEY (`id_intervento`) REFERENCES `intervento` (`id_intervento`),
  ADD CONSTRAINT `usa_ibfk_2` FOREIGN KEY (`id_accessorio`) REFERENCES `accessorio` (`id_accessorio`);

--
-- Limiti per la tabella `utilizza`
--
ALTER TABLE `utilizza`
  ADD CONSTRAINT `utilizza_ibfk_1` FOREIGN KEY (`id_intervento`) REFERENCES `intervento` (`id_intervento`),
  ADD CONSTRAINT `utilizza_ibfk_2` FOREIGN KEY (`id_pezzo`) REFERENCES `pezzo_ricambio` (`id_pezzo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
