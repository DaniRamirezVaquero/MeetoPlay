-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 26-11-2023 a las 20:51:27
-- Versión del servidor: 8.1.0
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `MeetoPlayDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE `event` (
  `eventId` int NOT NULL,
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
  `dateInscriptionEnd` date NOT NULL,
  `hourInscriptionEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`eventId`, `eventTitle`, `gameId`, `gameMode`, `platform`, `eventOwnerId`, `dateBegin`, `dateEnd`, `hourBegin`, `hourEnd`, `eventRequirementId`, `participants`, `slots`, `dateInscriptionEnd`, `hourInscriptionEnd`) VALUES
(1, 'Tardecita de Lol', 1, 'Aram', 'PC', 11, '2023-12-17', '2023-12-17', '17:00:00', '23:00:00', 1, 'Natty,Chriss', 5, '2023-12-17', '15:00:00'),
(2, 'Minecraft Server', 4, 'Moded', 'PC / XBox', 11, '2023-12-11', '2023-12-18', '19:30:00', '24:00:00', NULL, 'Vaker0,!TT7,SerialBan,Natty,Chriss,Pepelu,Joselito67,Rtt62,KillezMAzter,GiveupPaper,NoobPepito,XSunrise,GhostSkill,FreedomShoot,JackpotS,Aeroyep,orundG3,KekPlaie', 20, '2023-12-11', '19:00:00'),
(3, 'Duo Valorant', 2, 'Ranked', 'PC', 13, '2023-12-01', '2023-12-01', '17:00:00', '19:30:00', 2, 'Vaker0', 1, '2023-12-01', '19:30:00'),
(4, 'Torneo CSgo', 3, 'Competitivo', 'PC', 12, '2023-12-13', '2023-12-15', '16:30:00', '21:00:00', NULL, 'KillerZXN,Turkito,AroonP8', 50, '2023-12-13', '16:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventRequirement`
--

CREATE TABLE `eventRequirement` (
  `eventRequirementId` int NOT NULL,
  `maxRank` varchar(50) DEFAULT NULL,
  `minRank` varchar(50) DEFAULT NULL,
  `maxLvl` int DEFAULT NULL,
  `minLvl` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eventRequirement`
--

INSERT INTO `eventRequirement` (`eventRequirementId`, `maxRank`, `minRank`, `maxLvl`, `minLvl`) VALUES
(1, 'Oro II', 'Madera IV', 500, 30),
(2, 'Platino III', 'Oro I', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follower_followed`
--

CREATE TABLE `follower_followed` (
  `followedId` int NOT NULL,
  `followerId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `follower_followed`
--

INSERT INTO `follower_followed` (`followedId`, `followerId`) VALUES
(11, 12),
(13, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game`
--

CREATE TABLE `game` (
  `gameId` int NOT NULL,
  `gameName` varchar(150) NOT NULL,
  `gameLogo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `game`
--

INSERT INTO `game` (`gameId`, `gameName`, `gameLogo`) VALUES
(1, 'League of Legends', 'img/gameLogos/lolLogo.png'),
(2, 'Valorant', 'img/gameLogos/valorantLogo.png'),
(3, 'Counter Strike', 'img/gameLogos/csgoLogo.png'),
(4, 'Minecraft', 'img/gameLogos/minecraftLogo.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `stat`
--

CREATE TABLE `stat` (
  `statId` int NOT NULL,
  `gameId` int NOT NULL,
  `level` int NOT NULL,
  `maxRank` varchar(100) DEFAULT NULL,
  `timePlayed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `favGameMode` varchar(255) NOT NULL,
  `inGameName` varchar(255) NOT NULL,
  `userId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `stat`
--

INSERT INTO `stat` (`statId`, `gameId`, `level`, `maxRank`, `timePlayed`, `favGameMode`, `inGameName`, `userId`) VALUES
(1, 1, 376, 'Diamante II (TFT)', '1596:20', 'Aram', 'Vakerit0', 12),
(2, 2, 183, 'Diamante IV', '693:45', 'Clasificatoria', 'Vakerit0#EUW', 12),
(3, 3, 216, 'Silver III', '123:12', 'Death Match', 'Vakero2000', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `userId` int NOT NULL,
  `userName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profilePic` varchar(255) DEFAULT NULL,
  `userStatus` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `bornDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user`
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
(15, 'nuevoRegistro', 'img/profilePics/defaultProfilePic.jpg', 'Active', 'nuevo@registro.com', '81dc9bdb52d04dc20036dbd8313ed055', '2023-11-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_join_event`
--

CREATE TABLE `user_join_event` (
  `userId` int NOT NULL,
  `eventId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user_join_event`
--

INSERT INTO `user_join_event` (`userId`, `eventId`) VALUES
(13, 1),
(11, 2),
(12, 2),
(13, 2),
(12, 3);

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
  MODIFY `eventId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `userId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
