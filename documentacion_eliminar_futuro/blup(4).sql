-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-03-2022 a las 18:47:38
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blup`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_local` int(11) DEFAULT NULL,
  `hora_apertura` char(255) DEFAULT NULL,
  `hora_cierre` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_local`, `hora_apertura`, `hora_cierre`) VALUES
(4, 2, '10:00', '20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_local`
--

CREATE TABLE `imagenes_local` (
  `id_local` int(11) DEFAULT NULL,
  `linea_imagen` int(11) DEFAULT NULL,
  `ruta` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `locales`
--

CREATE TABLE `locales` (
  `id_local` int(11) NOT NULL,
  `id_gerente` int(11) DEFAULT NULL,
  `direccion` char(255) DEFAULT NULL,
  `nombre_local` char(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `num_mesas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `locales`
--

INSERT INTO `locales` (`id_local`, `id_gerente`, `direccion`, `nombre_local`, `descripcion`, `num_mesas`) VALUES
(2, 3, 'madrid (valle de los caidos)', 'Francisco bar', 'El bar mas facha de  españa', 20),
(3, 3, 'aaa', 'aaa', 'aaa', 0),
(4, 3, 'aaa', 'aaa', 'aaa', 0),
(5, 3, 'aaa', 'aaa', 'aaa', 0),
(6, 3, 'aaa', 'aaa', 'aaa', 0),
(7, 3, 'aaa', 'aaa', 'aaa', 0),
(8, 3, 'aaa', 'aaa', 'aaa', 0),
(10, 3, 'aaa', 'aaa', 'aaa', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nombre_usuario` char(255) NOT NULL,
  `nombre_publico` varchar(255) DEFAULT NULL,
  `primerape_usuario` char(255) NOT NULL,
  `segundoape_usuario` char(255) NOT NULL,
  `telefono_user` varchar(255) DEFAULT NULL,
  `email_user` char(255) DEFAULT NULL,
  `pass` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `nombre_usuario`, `nombre_publico`, `primerape_usuario`, `segundoape_usuario`, `telefono_user`, `email_user`, `pass`) VALUES
(0, 'Ramon', 'Rami', 'Rami', 'Malito', '251654654', 'rami@blup.com', '1234'),
(1, 'Eduardo', 'kiddie', 'buleo', 'blasco', '663643515', 'eduardo@gmail.com', '1234'),
(2, 'a', 'a', 'a', 'a', '123456789', 'eduardo@ijdb.com', '1234'),
(3, 'Franco', 'Viva españa', 'franco', 'españa', '000000000', 'franciscofranco@gmail.com', 'daniel'),
(12, 'ami', 'imar', 'mia', 'iai', '654654531', 'ramon@ijdb.com', '1234'),
(13, 'sadasasd', 'asasdsada', 'asdasdasd', 'asdasdsa', 'asdasdad', 'asda@gmail.com', '123');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_local` (`id_local`);

--
-- Indices de la tabla `imagenes_local`
--
ALTER TABLE `imagenes_local`
  ADD KEY `imagenes_local` (`id_local`);

--
-- Indices de la tabla `locales`
--
ALTER TABLE `locales`
  ADD PRIMARY KEY (`id_local`),
  ADD KEY `id_gerente` (`id_gerente`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email_user` (`email_user`),
  ADD UNIQUE KEY `nombre_publico` (`nombre_publico`),
  ADD UNIQUE KEY `telefono` (`telefono_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `locales`
--
ALTER TABLE `locales`
  MODIFY `id_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`id_local`) REFERENCES `locales` (`id_local`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes_local`
--
ALTER TABLE `imagenes_local`
  ADD CONSTRAINT `imagenes_local` FOREIGN KEY (`id_local`) REFERENCES `locales` (`id_local`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `locales`
--
ALTER TABLE `locales`
  ADD CONSTRAINT `locales_ibfk_1` FOREIGN KEY (`id_gerente`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
