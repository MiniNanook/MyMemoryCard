-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-04-2019 a las 19:24:22
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mygamelist`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friendrequests`
--

CREATE TABLE `friendrequests` (
  `idSender` int(11) NOT NULL,
  `idReceiver` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `friendrequests`
--

INSERT INTO `friendrequests` (`idSender`, `idReceiver`) VALUES
(9, 6),
(9, 99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friends`
--

CREATE TABLE `friends` (
  `idFriendA` int(11) NOT NULL,
  `idFriendB` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `friends`
--

INSERT INTO `friends` (`idFriendA`, `idFriendB`) VALUES
(7, 6),
(9, 7),
(9, 12),
(13, 9),
(14, 9),
(15, 9),
(16, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamegenres`
--

CREATE TABLE `gamegenres` (
  `gameId` int(11) NOT NULL,
  `genre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gamegenres`
--

INSERT INTO `gamegenres` (`gameId`, `genre`) VALUES
(14, 'Mario'),
(14, 'Platforms'),
(71, 'Logic'),
(71, 'Puzzle'),
(71, 'RTS'),
(74, 'Mario'),
(74, 'Racing'),
(74, 'Sport'),
(75, 'Mario'),
(75, 'Soccer'),
(75, 'Sports'),
(76, 'Board'),
(76, 'Mario'),
(76, 'Multiplayer'),
(77, 'FPS'),
(77, 'Shooter'),
(77, 'War'),
(79, 'FPS'),
(79, 'Shooter'),
(79, 'War'),
(84, 'FPS'),
(84, 'Shooter'),
(84, 'War'),
(85, 'FPS'),
(85, 'Shooter'),
(85, 'Space'),
(85, 'War'),
(86, 'Platforms'),
(86, 'Sonic'),
(86, 'Story'),
(87, 'Disney'),
(87, 'Mickey'),
(87, 'Platforms'),
(88, 'Disney'),
(88, 'Enix'),
(88, 'RPG'),
(88, 'Square'),
(89, 'Disney'),
(89, 'Enix'),
(89, 'RPG'),
(89, 'Square');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gamereviews`
--

CREATE TABLE `gamereviews` (
  `idUser` int(11) NOT NULL,
  `idGame` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `review` varchar(420) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gamereviews`
--

INSERT INTO `gamereviews` (`idUser`, `idGame`, `score`, `title`, `review`, `time`) VALUES
(6, 14, 10, '3D Mario\'s Best Title', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt m', '2019-04-27 19:58:38'),
(9, 14, 9, '3D Mario\'s Best Title', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt m', '2019-04-27 19:58:38'),
(9, 89, 10, 'The Best Game Ever', 'This is the best game ever. Period.', '2019-04-28 17:06:57'),
(12, 14, 10, 'Mario Galaxy', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt m', '2019-04-27 19:59:15'),
(15, 14, 10, 'Mario Galaxy', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt m', '2019-04-27 19:59:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `year` date DEFAULT NULL,
  `company` varchar(20) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `average` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`id`, `title`, `year`, `company`, `platform`, `average`) VALUES
(14, 'Mario Galaxy', '2007-11-06', 'Nintendo', 'Wii', '10.00'),
(71, 'Pikmin', '2001-10-26', 'Nintendo', 'GameCube', '7.00'),
(74, 'Mario Kart Wii', '2008-04-10', 'Nintendo', 'Wii', '0.00'),
(75, 'Mario Strikers Charged Football', '2007-05-25', 'Nintendo', 'Wii', '0.00'),
(76, 'Mario Party 8', '2007-05-29', 'Nintendo', 'Wii', '0.00'),
(77, 'Call of Duty: Modern Warfare 2', '2009-11-10', 'Sony', 'PlayStation 3', '7.00'),
(79, 'Call of Duty: Modern Warfare 1', '2007-11-05', 'Sony', 'PlayStation 3', '0.00'),
(84, 'Gears of War 4', '2016-10-11', 'Microsoft', 'XBox One', '0.00'),
(85, 'Mass Effect 3', '2012-03-06', 'Microsoft', 'XBox 360', '0.00'),
(86, 'Sonic The Hedgehog', '2006-11-14', 'Microsoft', 'XBox 360', '0.00'),
(87, 'Epic Mickey', '2010-11-25', 'Nintendo', 'Wii', '9.00'),
(88, 'Kingdom Hearts', '2002-04-28', 'Sony', 'PlayStation 2', '9.00'),
(89, 'Kingdom Hearts II', '2005-12-22', 'Sony', 'PlayStation 2', '10.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `idSender` int(11) NOT NULL,
  `idReceiver` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `message` varchar(280) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `idSender`, `idReceiver`, `title`, `message`, `time`) VALUES
(1, 9, 7, 'Hello!', 'How are you?', '2019-04-21 10:27:55'),
(3, 9, 7, 'dasfas', 'fafsafasf', '2019-04-21 10:27:55'),
(4, 7, 9, 'dasfas', 'fafsafasf', '2019-04-21 10:23:44'),
(5, 6, 7, 'Otro', 'Mas tarde', '2019-04-21 10:31:16'),
(6, 6, 9, 'Otro', 'Mas tarde', '2019-04-21 10:30:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mygames`
--

CREATE TABLE `mygames` (
  `userId` int(11) NOT NULL,
  `gameId` int(11) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `isFavourite` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mygames`
--

INSERT INTO `mygames` (`userId`, `gameId`, `rating`, `status`, `isFavourite`) VALUES
(6, 14, 10, 'Finished', b'1'),
(9, 14, 10, 'Finished', b'1'),
(9, 71, 7, 'Playing', b'1'),
(9, 77, 7, 'Finished', b'0'),
(9, 87, 9, 'Finished', b'1'),
(9, 88, 9, 'Finished', b'1'),
(9, 89, 10, 'Finished', b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `password` varchar(80) NOT NULL,
  `email` varchar(40) NOT NULL,
  `rol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `email`, `rol`) VALUES
(6, 'aaaaa', 'aaaaa', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'adruiz01@ucm.es', 'user'),
(7, 'Nanuk', 'Adrián Ruiz', '$2y$10$1X4kam12YUORObXQAF3JFOa1ahYjCfYNf9XxsBN92MZh5REwFsfJK', 'adruiz01@ucm.es', 'user'),
(9, 'admin', 'admin', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'admin', 'admin'),
(10, 'Teresa', 'Teresa', '$2y$10$CKWYSGEdLnAxw1FOWZravuaP73Z8nMP3gnXwnvWHKIyJSq.g9wY6G', 'teresa@gmail.com', 'user'),
(11, 'Sergio', 'Sergio', '$2y$10$fPYbo2OvVWfkCZSGmbgF0O6cUv2xmOH2k16mB2KNHGpVHFAqdBpJG', 'sergio@ucm.es', 'user'),
(12, 'Carlos', 'Carlos', '$2y$10$8ugUvK7CTAhOBO4NZ5TULeoYmPyMLRg/ZFjZMQJXbDAA7usG20s/.', 'carlos@ucm.es', 'user'),
(13, 'Sarai', 'Sarai', '$2y$10$6nJBTqUzw9SMDxURh9jPve93x7q.D.SpbZfYbRIXFiyBWdoUoNCP2', 'sarai@ucm.es', 'user'),
(14, 'Paula', 'Paula', '$2y$10$Nmxk/cI/SQm8QZGOQRVIS.K4elgiT1ZXrQlwmYgQnqJZrEAL56gIy', 'paula@ucm.es', 'user'),
(15, 'Laura', 'Laura', '$2y$10$sTBjZFfAjQZbo.B0kOM2m.0SgJzAi.0cCm9MYpWLE8gW06tooOU8q', 'laura@ucm.es', 'user'),
(16, 'Manuel', 'Manuel', '$2y$10$nIF1aWeZd9Him/UspELqh.dmfFDzsmBYAyKa5uAqPVdA/4XolmodK', 'manuel@ucm.es', 'user'),
(99, 'Alex', 'Alex', '$2y$10$NPVudwkP4mD5Eai4vzwDIudVI3nDpSEB3ccZq2RiLYrQAOtlTxJSW', 'alex@ucm.es', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `friendrequests`
--
ALTER TABLE `friendrequests`
  ADD PRIMARY KEY (`idSender`,`idReceiver`),
  ADD KEY `idSender` (`idSender`,`idReceiver`),
  ADD KEY `idReceiver` (`idReceiver`);

--
-- Indices de la tabla `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`idFriendA`,`idFriendB`),
  ADD KEY `idFriendA` (`idFriendA`,`idFriendB`),
  ADD KEY `idFriendB` (`idFriendB`);

--
-- Indices de la tabla `gamegenres`
--
ALTER TABLE `gamegenres`
  ADD PRIMARY KEY (`gameId`,`genre`),
  ADD KEY `gameId` (`gameId`);

--
-- Indices de la tabla `gamereviews`
--
ALTER TABLE `gamereviews`
  ADD PRIMARY KEY (`idUser`,`idGame`),
  ADD KEY `idUser` (`idUser`,`idGame`),
  ADD KEY `idGame` (`idGame`);

--
-- Indices de la tabla `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`,`idSender`,`idReceiver`),
  ADD KEY `idSender` (`idSender`,`idReceiver`),
  ADD KEY `idReceiver` (`idReceiver`),
  ADD KEY `id` (`id`,`idSender`,`idReceiver`);

--
-- Indices de la tabla `mygames`
--
ALTER TABLE `mygames`
  ADD PRIMARY KEY (`userId`,`gameId`),
  ADD KEY `gameId` (`gameId`),
  ADD KEY `userId` (`userId`,`gameId`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `friendrequests`
--
ALTER TABLE `friendrequests`
  ADD CONSTRAINT `friendrequests_ibfk_1` FOREIGN KEY (`idSender`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friendrequests_ibfk_2` FOREIGN KEY (`idReceiver`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`idFriendA`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`idFriendB`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gamegenres`
--
ALTER TABLE `gamegenres`
  ADD CONSTRAINT `gamegenres_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gamereviews`
--
ALTER TABLE `gamereviews`
  ADD CONSTRAINT `gamereviews_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gamereviews_ibfk_2` FOREIGN KEY (`idGame`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`idSender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`idReceiver`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `mygames`
--
ALTER TABLE `mygames`
  ADD CONSTRAINT `mygames_ibfk_1` FOREIGN KEY (`gameId`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mygames_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
