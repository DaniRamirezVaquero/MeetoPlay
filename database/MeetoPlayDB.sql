-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Servidor: db
-- Tiempo de generación: 06-12-2023 a las 10:46:54
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '';

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `event` (
  `eventId` int NOT NULL AUTO_INCREMENT,
  `eventTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gameId` int NOT NULL,
  `gameMode` varchar(255) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `eventOwnerId` int NOT NULL,
  `dateBegin` date NOT NULL,
  `dateEnd` date NOT NULL,
  `hourBegin` time NOT NULL,
  `hourEnd` time NOT NULL,
  `eventRequirementId` int DEFAULT NULL,
  `participants` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `slots` int NOT NULL,
  `dateInscriptionBegin` date DEFAULT NULL,
  `dateInscriptionEnd` date NOT NULL,
  `hourInscriptionBegin` time DEFAULT NULL,
  `hourInscriptionEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`eventId`, `eventTitle`, `gameId`, `gameMode`, `platform`, `eventOwnerId`, `dateBegin`, `dateEnd`, `hourBegin`, `hourEnd`, `eventRequirementId`, `participants`, `slots`, `dateInscriptionBegin`, `dateInscriptionEnd`, `hourInscriptionBegin`, `hourInscriptionEnd`) VALUES
(1, 'Tardecita de Lol', 1, 'Aram', 'PC', 11, '2023-12-17', '2023-12-17', '17:00:00', '23:00:00', 1, 'Natty,Chriss', 5, '2023-12-01', '2023-12-17', '16:08:41', '15:00:00'),
(2, 'Minecraft Server', 4, 'Moded', 'PC / XBox', 11, '2023-12-11', '2023-12-18', '19:30:00', '24:00:00', NULL, 'Vaker0,!TT7,SerialBan,Natty,Chriss,Pepelu,Joselito67,Rtt62,KillezMAzter,GiveupPaper,NoobPepito,XSunrise,GhostSkill,FreedomShoot,JackpotS,Aeroyep,orundG3,KekPlaie', 20, '2023-12-01', '2023-12-11', '11:08:41', '19:00:00'),
(3, 'Duo Valorant', 2, 'Ranked', 'PC', 13, '2023-12-01', '2023-12-01', '17:00:00', '19:30:00', 2, 'Vaker0', 1, '2023-12-01', '2023-12-01', '15:08:41', '19:30:00'),
(4, 'Torneo CSgo', 3, 'Competitivo', 'PC', 12, '2023-12-13', '2023-12-15', '16:30:00', '21:00:00', NULL, 'KillerZXN,Turkito,AroonP8', 50, '2023-12-01', '2023-12-13', '15:08:41', '16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `eventRequirement`
--

DROP TABLE IF EXISTS `eventRequirement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventRequirement` (
  `eventRequirementId` int NOT NULL AUTO_INCREMENT,
  `maxRank` varchar(50) DEFAULT NULL,
  `minRank` varchar(50) DEFAULT NULL,
  `maxLvl` int DEFAULT NULL,
  `minLvl` int DEFAULT NULL,
  PRIMARY KEY (`eventRequirementId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventRequirement`
--

LOCK TABLES `eventRequirement` WRITE;
/*!40000 ALTER TABLE `eventRequirement` DISABLE KEYS */;
INSERT INTO `eventRequirement` VALUES (0,'1','100',1,12),(1,'Oro II','Madera IV',500,30),(2,'Platino III','Oro I',NULL,NULL);
/*!40000 ALTER TABLE `eventRequirement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `follower_followed`
--

DROP TABLE IF EXISTS `follower_followed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `follower_followed` (
  `followedId` int NOT NULL,
  `followerId` int NOT NULL,
  PRIMARY KEY (`followedId`,`followerId`),
  KEY `fk_followerId_userId` (`followerId`),
  CONSTRAINT `fk_followedId_userId` FOREIGN KEY (`followedId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_followerId_userId` FOREIGN KEY (`followerId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follower_followed`
--

LOCK TABLES `follower_followed` WRITE;
/*!40000 ALTER TABLE `follower_followed` DISABLE KEYS */;
INSERT INTO `follower_followed` VALUES (12,1),(12,2),(12,3),(12,4),(12,5),(12,6),(12,7),(12,8),(12,11),(1,12),(2,12),(3,12),(6,12),(11,12),(13,12),(11,13),(12,13);
/*!40000 ALTER TABLE `follower_followed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `game` (
  `gameId` int NOT NULL AUTO_INCREMENT,
  `gameName` varchar(150) NOT NULL,
  `gameLogo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`gameId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'League of Legends','img/gameLogos/lolLogo.png'),(2,'Valorant','img/gameLogos/valorantLogo.png'),(3,'Counter Strike','img/gameLogos/csgoLogo.png'),(4,'Minecraft','img/gameLogos/minecraftLogo.png');
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stat`
--

DROP TABLE IF EXISTS `stat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stat` (
  `statId` int NOT NULL AUTO_INCREMENT,
  `gameId` int NOT NULL,
  `level` int NOT NULL,
  `maxRank` varchar(100) DEFAULT NULL,
  `timePlayed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `favGameMode` varchar(255) NOT NULL,
  `inGameName` varchar(255) NOT NULL,
  `userId` int NOT NULL,
  PRIMARY KEY (`statId`),
  KEY `gameId` (`gameId`),
  CONSTRAINT `stat_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `game` (`gameId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stat`
--

LOCK TABLES `stat` WRITE;
/*!40000 ALTER TABLE `stat` DISABLE KEYS */;
INSERT INTO `stat` VALUES (1,1,376,'Diamante II (TFT)','1596:20','Aram','Vakerit0',12),(2,2,183,'Diamante IV','693:45','Clasificatoria','Vakerit0#EUW',12),(3,3,216,'Silver III','123:12','Death Match','Vakero2000',12);
/*!40000 ALTER TABLE `stat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `userName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `userStatus` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `bornDate` date NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userName`, `profilePic`, `userStatus`, `email`, `password`, `bornDate`) VALUES
(1, 'cingledew0', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'ktulk0@sbwire.com', '1e34f88f592fca06049b38a7190ad162', '1998-06-17'),
(2, 'kelement1', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'rgodball1@state.tx.us', 'b25a540ba78c5d7929ba6ac438b8568c', '2004-12-29'),
(3, 'posborn2', 'img/profilePics/defaultProfilePic.jpg', 'AFK', 'aganiclef2@is.gd', 'a5bec5834592dc1d5619234d7add8b4a', '1997-10-21'),
(4, 'mmolohan3', 'img/profilePics/defaultProfilePic.jpg', 'DND', 'jhyslop3@hc360.com', 'c8ef0e4bdb3f0620b82481b957ac6dd1', '2000-04-03'),
(5, 'dtooker4', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'jkirrens4@wikimedia.org', '665af8fe6576175a1f35c52ff4214f6c', '2001-11-02'),
(6, 'vpirouet5', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'rbroome5@blogger.com', '6aa1150de6a0d41ac271e0f2c236ed95', '1994-09-06'),
(7, 'sromushkin6', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'eleadbetter6@cam.ac.uk', 'aa4df9b0e4708dd726420e547bb710e8', '1996-10-17'),
(8, 'hsarton7', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'sblodg7@thetimes.co.uk', 'dcd814f8ddbc5a2ab01f95e463d5b60c', '2003-11-25'),
(9, 'tfarlow8', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'emarquis8@theatlantic.com', '033e24529c5f76c29a873e5ed4c5d970', '2001-03-19'),
(10, 'egorioli9', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'djermy9@liveinternet.ru', '0672c309adebe8c62dce9770b320b915', '1999-03-11'),
(11, 'Seryix', 'img/profilePics/seryixProfilePic.jpg', 'DND', 'prueba@prueba.es', 'c893bad68927b457dbed39460e6afd62', '2000-01-01'),
(12, 'Vaker0', 'img/profilePics/vakeroProfilePic.jpg', 'Active', 'dani.vakero.1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2000-02-08'),
(13, 'Natty', 'img/profilePics/nattyProfilePic.jpg', 'AFK', 'natty@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '1998-09-10'),
(14, 'nuevoRegistro', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'nuevo@registro.com', '81dc9bdb52d04dc20036dbd8313ed055', '2023-11-01'),
(16, 'makinonBikes', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'alberto@moreno', '202cb962ac59075b964b07152d234b70', '1978-01-01'),
(17, 'titoJuliets', '/var/www/html/MeetoPlay/img/profilePics/defaultProfilePic.jpg', 'Active', 'tito@juliets.es', '81dc9bdb52d04dc20036dbd8313ed055', '2004-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `user_join_event`
--

DROP TABLE IF EXISTS `user_join_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_join_event` (
  `userId` int NOT NULL,
  `eventId` int NOT NULL,
  PRIMARY KEY (`userId`,`eventId`),
  UNIQUE KEY `userId` (`userId`,`eventId`) USING BTREE,
  KEY `eventId` (`eventId`),
  CONSTRAINT `user_join_event_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `user_join_event_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventId`),
  ADD KEY `eventRequirementId` (`eventRequirementId`),
  ADD KEY `gameId` (`gameId`),
  ADD KEY `eventOwnerId` (`eventOwnerId`);

--
-- Indices de la tabla `eventRequirement`
--
ALTER TABLE `eventRequirement`
  ADD PRIMARY KEY (`eventRequirementId`);

--
-- Indices de la tabla `follower_followed`
--
ALTER TABLE `follower_followed`
  ADD PRIMARY KEY (`followedId`,`followerId`),
  ADD KEY `fk_followerId_userId` (`followerId`);

--
-- Indices de la tabla `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`gameId`);

--
-- Indices de la tabla `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`statId`),
  ADD KEY `gameId` (`gameId`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- Indices de la tabla `user_join_event`
--
ALTER TABLE `user_join_event`
  ADD PRIMARY KEY (`userId`,`eventId`),
  ADD UNIQUE KEY `userId` (`userId`,`eventId`) USING BTREE,
  ADD KEY `eventId` (`eventId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `game`
--
ALTER TABLE `game`
  MODIFY `gameId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `stat`
--
ALTER TABLE `stat`
  MODIFY `statId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `userId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`eventRequirementId`) REFERENCES `eventRequirement` (`eventRequirementId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`gameId`) REFERENCES `game` (`gameId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `event_ibfk_3` FOREIGN KEY (`eventOwnerId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `follower_followed`
--
ALTER TABLE `follower_followed`
  ADD CONSTRAINT `fk_followedId_userId` FOREIGN KEY (`followedId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_followerId_userId` FOREIGN KEY (`followerId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `stat`
--
ALTER TABLE `stat`
  ADD CONSTRAINT `stat_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `game` (`gameId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `user_join_event`
--
ALTER TABLE `user_join_event`
  ADD CONSTRAINT `user_join_event_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_join_event_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `event` (`eventId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-10 22:54:05
