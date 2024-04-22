-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-04-2024 a las 01:48:08
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `taskmanager`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estadotareas`
--

CREATE TABLE `estadotareas` (
  `id_estadotarea` tinyint(4) NOT NULL,
  `nombre_estadotarea` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historicoestados`
--

CREATE TABLE `historicoestados` (
  `fechacambio_historicoestado` datetime NOT NULL DEFAULT current_timestamp(),
  `id_estadotarea_historicoestado` tinyint(4) NOT NULL,
  `id_tarea_historicoestado` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historicotareas`
--

CREATE TABLE `historicotareas` (
  `nombretarea_historicotarea` varchar(20) NOT NULL,
  `descripciontarea_historicotarea` varchar(100) NOT NULL,
  `observacion_historicotarea` varchar(100) NOT NULL,
  `id_tipotarea_historicotarea` tinyint(4) NOT NULL,
  `id_usuario_historicotarea` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` bigint(20) NOT NULL,
  `nombre_tarea` varchar(20) NOT NULL,
  `descripcion_tarea` varchar(100) NOT NULL,
  `fecharegistro_tarea` datetime NOT NULL DEFAULT current_timestamp(),
  `fechavencimiento_tarea` datetime NOT NULL DEFAULT current_timestamp(),
  `observacion_tarea` varchar(100) NOT NULL,
  `id_usuario_tarea` varchar(20) NOT NULL,
  `id_tipotarea_tarea` tinyint(4) NOT NULL,
  `id_estadotarea_tarea` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipotareas`
--

CREATE TABLE `tipotareas` (
  `id_tipotarea` tinyint(4) NOT NULL,
  `nombre_tipotarea` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` varchar(12) NOT NULL,
  `login_usuario` varchar(30) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `edad_usuario` int(11) DEFAULT NULL,
  `email_usuario` varchar(80) NOT NULL,
  `celular_usuario` varchar(16) DEFAULT NULL,
  `password_usuario` varchar(80) NOT NULL,
  `foto_usuario` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estadotareas`
--
ALTER TABLE `estadotareas`
  ADD PRIMARY KEY (`id_estadotarea`);

--
-- Indices de la tabla `historicoestados`
--
ALTER TABLE `historicoestados`
  ADD KEY `id_estadotarea_historicoestado` (`id_estadotarea_historicoestado`),
  ADD KEY `id_tarea_historicoestado` (`id_tarea_historicoestado`);

--
-- Indices de la tabla `historicotareas`
--
ALTER TABLE `historicotareas`
  ADD KEY `id_tipotarea_historicotarea` (`id_tipotarea_historicotarea`),
  ADD KEY `id_usuario_historicotarea` (`id_usuario_historicotarea`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_usuario_tarea` (`id_usuario_tarea`),
  ADD KEY `id_tipotarea_tarea` (`id_tipotarea_tarea`),
  ADD KEY `id_estadotarea_tarea` (`id_estadotarea_tarea`);

--
-- Indices de la tabla `tipotareas`
--
ALTER TABLE `tipotareas`
  ADD PRIMARY KEY (`id_tipotarea`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estadotareas`
--
ALTER TABLE `estadotareas`
  MODIFY `id_estadotarea` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipotareas`
--
ALTER TABLE `tipotareas`
  MODIFY `id_tipotarea` tinyint(4) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historicoestados`
--
ALTER TABLE `historicoestados`
  ADD CONSTRAINT `fk_estadotareas_historicoestados` FOREIGN KEY (`id_estadotarea_historicoestado`) REFERENCES `estadotareas` (`id_estadotarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tareas_historioestados` FOREIGN KEY (`id_tarea_historicoestado`) REFERENCES `tareas` (`id_tarea`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historicotareas`
--
ALTER TABLE `historicotareas`
  ADD CONSTRAINT `fk_tipotareas_historicotareas` FOREIGN KEY (`id_tipotarea_historicotarea`) REFERENCES `tipotareas` (`id_tipotarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_historicotareas` FOREIGN KEY (`id_usuario_historicotarea`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `fk_estadotareas_tareas` FOREIGN KEY (`id_estadotarea_tarea`) REFERENCES `estadotareas` (`id_estadotarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tipotareas_tareas` FOREIGN KEY (`id_tipotarea_tarea`) REFERENCES `tipotareas` (`id_tipotarea`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuarios_tareas` FOREIGN KEY (`id_usuario_tarea`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
