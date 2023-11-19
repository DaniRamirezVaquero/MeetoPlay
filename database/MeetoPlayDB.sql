-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 18-11-2023 a las 13:42:53
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
-- Estructura de tabla para la tabla `Event`
--

CREATE TABLE `Event` (
  `eventId` int NOT NULL,
  `eventTitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gameId` int NOT NULL,
  `gameMode` varchar(255) NOT NULL,
  `eventOwnerId` int NOT NULL,
  `dateBegin` date NOT NULL,
  `dateEnd` date NOT NULL,
  `hourBegin` time NOT NULL,
  `hourEnd` time NOT NULL,
  `eventRequirementId` int DEFAULT NULL,
  `participants` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `slots` int NOT NULL,
  `dateInscriptionEnd` date NOT NULL,
  `hourInscriptionEnd` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Event`
--

INSERT INTO `Event` (`eventId`, `eventTitle`, `gameId`, `gameMode`, `eventOwnerId`, `dateBegin`, `dateEnd`, `hourBegin`, `hourEnd`, `eventRequirementId`, `participants`, `slots`, `dateInscriptionEnd`, `hourInscriptionEnd`) VALUES
(1, 'Tardecita de Lol', 1, 'Aram', 11, '2023-12-17', '2023-12-17', '17:00:00', '23:00:00', 1, 'Natty, Chriss, y 1 usuario desconociado más..', 5, '2023-12-17', '15:00:00'),
(2, 'Minecraft Server', 4, 'Moded', 11, '2023-12-11', '2023-12-18', '19:30:00', '24:00:00', 2, '!TT7, SerialBan, Natty, Chriss y 11 usuarios desconocidos más...', 15, '2023-12-11', '19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventRequirment`
--

CREATE TABLE `eventRequirment` (
  `eventRequirementId` int NOT NULL,
  `maxRank` varchar(50) DEFAULT NULL,
  `minRank` varchar(50) DEFAULT NULL,
  `maxLvl` int DEFAULT NULL,
  `minLvl` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `eventRequirment`
--

INSERT INTO `eventRequirment` (`eventRequirementId`, `maxRank`, `minRank`, `maxLvl`, `minLvl`) VALUES
(1, 'Oro II', 'Madera IV', 500, 30),
(2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Follower_Followed`
--

CREATE TABLE `Follower_Followed` (
  `followedId` int NOT NULL,
  `followerId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Follower_Followed`
--

INSERT INTO `Follower_Followed` (`followedId`, `followerId`) VALUES
(11, 12),
(13, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Game`
--

CREATE TABLE `Game` (
  `gameId` int NOT NULL,
  `gameName` varchar(150) NOT NULL,
  `gameLogo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Game`
--

INSERT INTO `Game` (`gameId`, `gameName`, `gameLogo`) VALUES
(1, 'League of Leguends', NULL),
(2, 'Valorant', NULL),
(3, 'Counter Strike', NULL),
(4, 'Minecraft', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Stat`
--

CREATE TABLE `Stat` (
  `statId` int NOT NULL,
  `gameId` int NOT NULL,
  `level` int NOT NULL,
  `maxRank` varchar(100) DEFAULT NULL,
  `timePlaying` varchar(255) NOT NULL,
  `favGameMode` varchar(255) NOT NULL,
  `inGameName` varchar(255) NOT NULL,
  `userId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Stat`
--

INSERT INTO `Stat` (`statId`, `gameId`, `level`, `maxRank`, `timePlaying`, `favGameMode`, `inGameName`, `userId`) VALUES
(1, 1, 376, 'Diamante II (TFT)', '1596:20', 'Aram', 'Vakerit0', 11),
(2, 2, 183, 'Diamante IV', '693:45', 'Clasificatoria', 'Vakerit0#EUW', 11),
(3, 3, 216, 'Silver III', '123:12', 'Death Match', 'Vakero2000', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User`
--

CREATE TABLE `User` (
  `userId` int NOT NULL,
  `userName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `userStatus` varchar(20) NOT NULL,
  `profilePic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `bornDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `User`
--

INSERT INTO `User` (`userId`, `userName`, `userStatus`, `profilePic`, `email`, `password`, `bornDate`) VALUES
(1, 'cingledew0', 'Active', NULL, 'ktulk0@sbwire.com', '1e34f88f592fca06049b38a7190ad162', '1998-06-17'),
(2, 'kelement1', 'Active', NULL, 'rgodball1@state.tx.us', 'b25a540ba78c5d7929ba6ac438b8568c', '2004-12-29'),
(3, 'posborn2', 'AFK', NULL, 'aganiclef2@is.gd', 'a5bec5834592dc1d5619234d7add8b4a', '1997-10-21'),
(4, 'mmolohan3', 'DND', NULL, 'jhyslop3@hc360.com', 'c8ef0e4bdb3f0620b82481b957ac6dd1', '2000-04-03'),
(5, 'dtooker4', 'Active', NULL, 'jkirrens4@wikimedia.org', '665af8fe6576175a1f35c52ff4214f6c', '2001-11-02'),
(6, 'vpirouet5', 'Active', NULL, 'rbroome5@blogger.com', '6aa1150de6a0d41ac271e0f2c236ed95', '1994-09-06'),
(7, 'sromushkin6', 'Active', NULL, 'eleadbetter6@cam.ac.uk', 'aa4df9b0e4708dd726420e547bb710e8', '1996-10-17'),
(8, 'hsarton7', 'Active', NULL, 'sblodg7@thetimes.co.uk', 'dcd814f8ddbc5a2ab01f95e463d5b60c', '2003-11-25'),
(9, 'tfarlow8', 'Active', NULL, 'emarquis8@theatlantic.com', '033e24529c5f76c29a873e5ed4c5d970', '2001-03-19'),
(10, 'egorioli9', 'Active', NULL, 'djermy9@liveinternet.ru', '0672c309adebe8c62dce9770b320b915', '1999-03-11'),
(11, 'prueba', 'DND', NULL, 'prueba@prueba.es', 'c893bad68927b457dbed39460e6afd62', '2000-01-01'),
(12, 'Vaker0', 'Active', NULL, 'dani.vakero1@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '2000-02-08'),
(13, 'Natty', 'AFK', NULL, 'natty@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '1998-09-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `User_join_Event`
--

CREATE TABLE `User_join_Event` (
  `userId` int NOT NULL,
  `eventId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `User_join_Event`
--

INSERT INTO `User_join_Event` (`userId`, `eventId`) VALUES
(12, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Event`
--
ALTER TABLE `Event`
  ADD PRIMARY KEY (`eventId`),
  ADD KEY `eventRequirementId` (`eventRequirementId`),
  ADD KEY `gameId` (`gameId`);

--
-- Indices de la tabla `eventRequirment`
--
ALTER TABLE `eventRequirment`
  ADD PRIMARY KEY (`eventRequirementId`);

--
-- Indices de la tabla `Follower_Followed`
--
ALTER TABLE `Follower_Followed`
  ADD PRIMARY KEY (`followedId`,`followerId`),
  ADD KEY `fk_followerId_userId` (`followerId`);

--
-- Indices de la tabla `Game`
--
ALTER TABLE `Game`
  ADD PRIMARY KEY (`gameId`);

--
-- Indices de la tabla `Stat`
--
ALTER TABLE `Stat`
  ADD PRIMARY KEY (`statId`),
  ADD KEY `gameId` (`gameId`);

--
-- Indices de la tabla `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userId`);

--
-- Indices de la tabla `User_join_Event`
--
ALTER TABLE `User_join_Event`
  ADD PRIMARY KEY (`userId`,`eventId`),
  ADD UNIQUE KEY `userId` (`userId`,`eventId`) USING BTREE,
  ADD KEY `eventId` (`eventId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Event`
--
ALTER TABLE `Event`
  MODIFY `eventId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Game`
--
ALTER TABLE `Game`
  MODIFY `gameId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `Stat`
--
ALTER TABLE `Stat`
  MODIFY `statId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `User`
--
ALTER TABLE `User`
  MODIFY `userId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Event`
--
ALTER TABLE `Event`
  ADD CONSTRAINT `Event_ibfk_1` FOREIGN KEY (`eventRequirementId`) REFERENCES `eventRequirment` (`eventRequirementId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Event_ibfk_2` FOREIGN KEY (`gameId`) REFERENCES `Game` (`gameId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Follower_Followed`
--
ALTER TABLE `Follower_Followed`
  ADD CONSTRAINT `fk_followedId_userId` FOREIGN KEY (`followedId`) REFERENCES `User` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_followerId_userId` FOREIGN KEY (`followerId`) REFERENCES `User` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `Stat`
--
ALTER TABLE `Stat`
  ADD CONSTRAINT `Stat_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `Game` (`gameId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `User_join_Event`
--
ALTER TABLE `User_join_Event`
  ADD CONSTRAINT `User_join_Event_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `User_join_Event_ibfk_2` FOREIGN KEY (`eventId`) REFERENCES `Event` (`eventId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
