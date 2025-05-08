-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2025 at 01:17 AM
-- Server version: 5.7.17
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieheavenphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbestellingen`
--

CREATE TABLE `tblbestellingen` (
  `bestellingid` int(11) NOT NULL,
  `klantid` int(11) NOT NULL,
  `bestellingsdatum` date NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbestellingen`
--

INSERT INTO `tblbestellingen` (`bestellingid`, `klantid`, `bestellingsdatum`, `status`) VALUES
(1, 1, '2025-05-08', 'Voltooid'),
(2, 1, '2025-05-08', 'Voltooid'),
(3, 1, '2025-05-08', 'Voltooid'),
(4, 1, '2025-05-08', 'Voltooid'),
(5, 1, '2025-05-08', 'Voltooid'),
(6, 3, '2025-05-08', 'Voltooid'),
(7, 3, '2025-05-08', 'Voltooid'),
(8, 3, '2025-05-08', 'Voltooid'),
(9, 3, '2025-05-08', 'Voltooid'),
(10, 3, '2025-05-08', 'Voltooid'),
(11, 3, '2025-05-08', 'Voltooid'),
(12, 3, '2025-05-08', 'Voltooid'),
(13, 3, '2025-05-08', 'Voltooid'),
(14, 3, '2025-05-08', 'Voltooid'),
(15, 3, '2025-05-08', 'Voltooid'),
(16, 3, '2025-05-08', 'Voltooid'),
(17, 3, '2025-05-08', 'Voltooid'),
(18, 3, '2025-05-08', 'Voltooid'),
(19, 3, '2025-05-08', 'Voltooid'),
(20, 3, '2025-05-08', 'Voltooid'),
(21, 3, '2025-05-08', 'Voltooid'),
(22, 3, '2025-05-08', 'Voltooid'),
(23, 3, '2025-05-08', 'Voltooid'),
(24, 3, '2025-05-09', 'Voltooid'),
(25, 3, '2025-05-09', 'Voltooid');

-- --------------------------------------------------------

--
-- Table structure for table `tblbestellingslijnen`
--

CREATE TABLE `tblbestellingslijnen` (
  `bestellingsid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `aantal` int(11) NOT NULL,
  `verkoopprijs` decimal(10,0) NOT NULL,
  `korting` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblbestellingslijnen`
--

INSERT INTO `tblbestellingslijnen` (`bestellingsid`, `productid`, `aantal`, `verkoopprijs`, `korting`) VALUES
(7, 1, 2, '25', 0),
(7, 4, 1, '11', 0),
(7, 9, 1, '20', 0),
(8, 6, 1, '25', 0),
(8, 7, 1, '19', 0),
(8, 3, 1, '23', 0),
(8, 5, 2, '16', 0),
(9, 9, 1, '20', 0),
(10, 4, 1, '11', 0),
(11, 4, 1, '11', 0),
(11, 1, 2, '25', 0),
(12, 4, 1, '11', 0),
(12, 1, 2, '25', 0),
(13, 4, 1, '11', 0),
(13, 1, 2, '25', 0),
(14, 4, 1, '11', 0),
(14, 1, 2, '25', 0),
(15, 4, 1, '11', 0),
(15, 1, 2, '25', 0),
(16, 4, 1, '11', 0),
(16, 1, 2, '25', 0),
(17, 4, 1, '11', 0),
(17, 1, 2, '25', 0),
(18, 4, 1, '11', 0),
(18, 1, 2, '25', 0),
(19, 4, 1, '11', 0),
(19, 1, 2, '25', 0),
(20, 4, 1, '11', 0),
(20, 1, 2, '25', 0),
(21, 4, 1, '11', 0),
(21, 1, 2, '25', 0),
(22, 4, 1, '11', 0),
(22, 1, 2, '25', 0),
(23, 9, 3, '20', 0),
(24, 1, 1, '25', 0),
(24, 6, 1, '25', 0),
(25, 1, 1, '25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategorie`
--

CREATE TABLE `tblcategorie` (
  `categorieid` int(11) NOT NULL,
  `categorie` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcategorie`
--

INSERT INTO `tblcategorie` (`categorieid`, `categorie`) VALUES
(1, 'Actie'),
(2, 'Drama'),
(3, 'Horror'),
(4, 'Mysterie'),
(5, 'Komedie'),
(6, 'Fanstasie'),
(7, 'Romantiek'),
(8, 'Thriller'),
(9, 'Science Fiction'),
(10, 'Avontuur');

-- --------------------------------------------------------

--
-- Table structure for table `tblklanten`
--

CREATE TABLE `tblklanten` (
  `klantid` int(11) NOT NULL,
  `naam` varchar(255) NOT NULL,
  `adres` varchar(255) NOT NULL,
  `postcodeid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblklanten`
--

INSERT INTO `tblklanten` (`klantid`, `naam`, `adres`, `postcodeid`, `email`) VALUES
(1, 'Ayse Uckuyulu', 'Kortrijksesteenweg 12', 2, 'kendet@gmail.com'),
(2, 'Pieter', 'Sesamstraat 1', 5, 'pieterjan@gmail.com'),
(3, 'Testklant', 'Teststraat 1', 9000, 'test@klant.be');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducten`
--

CREATE TABLE `tblproducten` (
  `productid` int(10) NOT NULL,
  `titel` varchar(25) NOT NULL,
  `omschrijving` longtext,
  `prijs` double DEFAULT NULL,
  `categorieid` int(11) NOT NULL,
  `foto` text NOT NULL,
  `beoordeling` int(11) NOT NULL,
  `aantalinvoorraad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblproducten`
--

INSERT INTO `tblproducten` (`productid`, `titel`, `omschrijving`, `prijs`, `categorieid`, `foto`, `beoordeling`, `aantalinvoorraad`) VALUES
(1, 'Deadpool & Wolverine', 'Bereid je voor op een ongekend avontuur met Deadpool en Wolverine! In deze spectaculaire film vol actie en humor, keert de geliefde antiheld Wade Wilson (Deadpool) terug om zich aan te sluiten bij de iconische mutant Wolverine. Samen vechten ze tegen tijd en vijanden in een episch verhaal dat je op het puntje van je stoel houdt. Mis deze unieke superheldenervaring niet!', 24.99, 1, 'deadpool.jpg', 1, 1),
(2, 'The Hangover', 'The Hangover is een hilarische komedie over vier vrienden die naar Las Vegas gaan voor een vrijgezellenfeest dat ze nooit zullen vergeten als ze zich nog konden herinneren wat er eigenlijk gebeurde. Na een nacht vol wilde avonturen, worden ze wakker met een kater en missen ze de bruidegom. Wat volgt is een krankzinnige zoektocht door de stad om de ontbrekende uren en hun vriend terug te vinden. Beleef de chaos, de humor en de onvergetelijke momenten met deze iconische film.', 19.99, 2, 'thehangover.jpg', 3, 1),
(3, 'Interstellar', 'Interstellar is een adembenemende sciencefictionfilm die de grenzen van ons universum verkent. Volg Cooper (gespeeld door Matthew McConaughey) en zijn team van onderzoekers terwijl ze door een wormgat reizen op zoek naar een nieuwe bewoonbare planeet voor de mensheid. De film combineert baanbrekende visuele effecten met een meeslepend verhaal over liefde, opoffering en de kracht van de menselijke geest. Laat je meevoeren op een epische reis die je kijk op het universum voor altijd zal veranderen.', 22.99, 3, 'interstellar.jpg', 5, 1),
(4, 'Cars', 'Cars is een levendige animatiefilm die je meeneemt naar de wereld van levende auto\'s. Volg de ambitieuze racewagen Lightning McQueen terwijl hij onverwacht terechtkomt in het slaperige stadje Radiator Springs. Terwijl hij vrienden maakt en levenslessen leert, ontdekt Lightning dat er meer is in het leven dan winnen. Beleef het avontuur, de vriendschap en de opwinding van racen in deze hartverwarmende film van Disney-Pixar.', 10.99, 4, 'cars.jpg', 3, 1),
(5, 'The Nun', 'The Nun is een spookachtige horrorfilm die je meeneemt naar een afgelegen klooster in Roemenie. Na de mysterieuze dood van een jonge non, worden Vader Burke en Zuster Irene gestuurd om de zaak te onderzoeken. Wat ze ontdekken is een kwaadaardige kracht die hen confronteert met hun grootste angsten. Bereid je voor op een film vol duisternis, spanning en bovennatuurlijke verschrikkingen die je ademloos zal achterlaten.', 15.99, 8, 'thenun.jpg', 1, 4),
(6, 'The Godfather', 'The Godfather is een epische misdaadfilm die de machtige familie Corleone volgt in het naoorlogse Amerika. Don Vito Corleone (gespeeld door Marlon Brando) leidt de familie met ijzeren hand en diepe loyaliteit. Wanneer zijn jongste zoon Michael (Al Pacino) zich bij de familiezaken voegt, wordt hij meegezogen in de gevaarlijke wereld van georganiseerde misdaad. Deze film is een boeiende mix van geweld, intriges en familiedrama, en wordt beschouwd als een van de grootste films aller tijden.', 24.99, 6, 'thegodfather.jpg', 1, 1),
(7, 'Lord Of The Rings', 'Lord of the Rings: The Fellowship of the Ring is een epische fantasyfilm gebaseerd op de geliefde boeken van J.R.R. Tolkien. Volg de jonge hobbit Frodo Baggins terwijl hij samen met een diverse groep metgezellen op een gevaarlijke queeste gaat om de machtige Ene Ring te vernietigen. Dit spectaculaire avontuur zit vol magie, gevechten en diepe vriendschappen, en neemt je mee naar de betoverende wereld van Midden-aarde. Ontdek het begin van een tijdloos verhaal dat je verbeelding zal overtreffen.', 18.99, 7, 'lordoftherings.jpg', 3, 1),
(8, 'The Substance', 'Met The Substance kun je een andere versie van jezelf genereren, jonger, mooier, perfecter. Deel gewoon de tijd. Een week voor de een, een week voor de ander. Een perfecte balans van zeven dagen.', 20.99, 8, 'substance.jpg', 4, 1),
(9, 'Godzilla Minus One', 'Kort na de Tweede Wereldoorlog duikt er voor de kust van Tokio een gigantisch monster op. De deserteur Koichi, getraumatiseerd door zijn eerste confrontatie met Godzilla, ziet dit als een kans om zijn gedrag tijdens de oorlog te vergoeden.', 19.99, 9, 'godzilla.jpg', 2, 1),
(10, 'Wicked', 'In WICKED maken we kennis met het nog onbekende verhaal van de Witches of Oz. Cynthia Erivo is te zien als als Elphaba, een jonge vrouw die zich onzeker voelt vanwege haar ongebruikelijke groene huid en die haar ware kracht nog moet ontdekken. Grammy-winnares en mondiale superster Ariana Grande speelt Glinda, een populaire, geprivilegieerde en ambitieuze jonge vrouw die er nog achter moet komen wie ze zelf echt is. De twee leren elkaar kennen als studenten aan de Shiz Universiteit in het magische Land van Oz en sluiten een onwaarschijnlijke maar innige vriendschap. Na een ontmoeting met de Wizard of Oz wordt hun vriendschap op de proef gesteld en zullen ze heel verschillende paden bewandelen.', 25.99, 5, 'wicked.jpg', 3, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbestellingen`
--
ALTER TABLE `tblbestellingen`
  ADD PRIMARY KEY (`bestellingid`);

--
-- Indexes for table `tblcategorie`
--
ALTER TABLE `tblcategorie`
  ADD PRIMARY KEY (`categorieid`);

--
-- Indexes for table `tblklanten`
--
ALTER TABLE `tblklanten`
  ADD PRIMARY KEY (`klantid`);

--
-- Indexes for table `tblproducten`
--
ALTER TABLE `tblproducten`
  ADD PRIMARY KEY (`productid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbestellingen`
--
ALTER TABLE `tblbestellingen`
  MODIFY `bestellingid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tblcategorie`
--
ALTER TABLE `tblcategorie`
  MODIFY `categorieid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tblklanten`
--
ALTER TABLE `tblklanten`
  MODIFY `klantid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tblproducten`
--
ALTER TABLE `tblproducten`
  MODIFY `productid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
