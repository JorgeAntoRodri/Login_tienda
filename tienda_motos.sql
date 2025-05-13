-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-05-2025 a las 20:32:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_motos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` enum('cascos_integrales','cascos_abatibles','accesorios') NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `categoria`, `imagen`, `fecha_registro`, `stock`) VALUES
(9, 'Casco Obsidian', '', 2500.00, 'cascos_integrales', 'images/Casco_Obsidian_Oro.JPG', '2025-03-10 06:00:00', 2),
(14, 'Casco Hax Jaguar', '', 2150.00, 'cascos_integrales', 'images/Casco_jaguar.jpg', '2025-03-11 06:00:00', 1),
(19, 'GUANTE EXTREMO AMARILLO', '', 590.00, 'cascos_integrales', 'images/FIGHTER-amarillo1.png', '2025-03-12 06:00:00', 2),
(20, 'Casco Noss Rosa', '', 1500.00, 'cascos_integrales', 'images/noss-rosa.jpg', '2025-03-12 06:00:00', 2),
(21, 'GUANTES LS2 ', '', 1200.00, 'cascos_integrales', 'images/Guantes_LS2.jpg', '2025-03-12 06:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('usuario','administrador') NOT NULL DEFAULT 'usuario',
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `rol`, `email`) VALUES
(4, 'Marcelo Bernal', 'marcelo07@gmail.com', '$2y$10$T/.3/xIz290LwGoV1FkdQer.HGce/MH2mIYB5ZE1aBw0gAtEYlxFi', 'usuario', 'bernal@gmail.com'),
(5, 'Antonio Rodriguez', 'antonio11snam@gmail.com', '$2y$10$GsFDrIYxBDpphSqFSsoJJu5QuX.ATS0COa/TIU.YDw97vfCM0gKWe', 'administrador', ''),
(6, 'Eslava', 'eslava04@gmail.com', '$2y$10$OIF9SvjKQm6qpgxok18VsuBlD5yaGP.DDnnQiqg115GgYMocskRzm', 'usuario', ''),
(7, 'KISS', 'jorge11snam@gmail.com', '$2y$10$UREgCDw.2MFz088HggBQneIU.UkqxoFgsQp8IsbII76LbYFJKkViO', 'usuario', 'jorge11snam@gmail.com'),
(8, 'Jonathan', 'jona07@gmail.com', '$2y$10$d/QbqN4b6UZJVOUNHaQf/u61V6.945hVtIcb48mAPnnqV5FTuYeQi', 'usuario', 'jona07@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `usuario_id`, `total`, `fecha`) VALUES
(1, 5, 1200.00, '2025-03-18 19:36:04'),
(2, 7, 2150.00, '2025-03-18 19:58:24'),
(3, 5, 1200.00, '2025-03-18 19:59:22'),
(4, 7, 3090.00, '2025-03-27 17:53:56'),
(5, 7, 3350.00, '2025-03-27 19:31:51'),
(6, 5, 1500.00, '2025-05-08 15:21:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
