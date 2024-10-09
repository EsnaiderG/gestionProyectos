-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2024 a las 22:40:56
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
-- Base de datos: `bd_proyectos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL,
  `responsable` int(11) DEFAULT NULL,
  `estado` text DEFAULT NULL,
  `presupuesto` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id_actividad`, `descripcion`, `fecha_inicio`, `fecha_final`, `id_proyecto`, `responsable`, `estado`, `presupuesto`) VALUES
(637, 'Actividad 4', '2024-03-23', '2024-03-30', 1234, 30661550, 'En Progreso', 200000),
(4321, 'Actividad 1', '2024-03-12', '2024-05-30', 1234, 123456789, 'En Progreso', 230000),
(6667, 'Actividad 3', '2024-02-12', '2024-07-23', 1234, 123456789, 'En Progreso', 500000),
(9898, 'Actividad 2', '2024-01-01', '2024-05-05', 6898, 30661550, 'En Progreso', 900000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadxpersona`
--

CREATE TABLE `actividadxpersona` (
  `id_actividad` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `duracion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividadxpersona`
--

INSERT INTO `actividadxpersona` (`id_actividad`, `id_persona`, `duracion`) VALUES
(4321, 123, '12'),
(4321, 30661550, '10'),
(9898, 123, '45'),
(9898, 30661550, '12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividadxrecurso`
--

CREATE TABLE `actividadxrecurso` (
  `id_actividad` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividadxrecurso`
--

INSERT INTO `actividadxrecurso` (`id_actividad`, `id_recurso`, `cantidad`) VALUES
(4321, 23456, 1),
(4321, 67899, 20),
(9898, 23456, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellidos` text DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` text DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `profesion` text DEFAULT NULL,
  `rol` varchar(20) DEFAULT 'trabajador',
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `nombre`, `apellidos`, `direccion`, `telefono`, `sexo`, `fecha_nacimiento`, `profesion`, `rol`, `password`) VALUES
(123, 'Wendy', 'Espinosa', 'Cra 12a #2-242', '3003964879', 'F', '2000-06-12', 'Estudiante', 'trabajador', '$2y$10$EFAT5EorvittB99W409jLOvy3HORRZf5RA478wKCLSIT5vJ1aJx9W'),
(30661550, 'Ana', 'Perez', 'Cra 3a #3-33', '3206608978', 'F', '2000-01-01', 'Estudiante', 'trabajador', '$2y$10$n3rCvrqLUZdCX8vJl.6kTeNHuzNe8e6Ybz4HBkNvz59AO8xS7wsmK'),
(123456789, 'Esnaider', 'Guzman Peñata', 'Cra 12a #2-24', '3003964879', 'M', '2001-11-20', 'Ingeniero de Sistemas', 'gerente', '$2y$10$6T2.5SslzZaQZqz7QE0uXOrw3dVmpSMeLCu1EO/cfbDQS2ID/JEpC'),
(1003789002, 'Dely ', 'Lopez', 'Cra 3a #3-33', '3202608999', 'M', '2000-12-20', 'Ingeniero de Sistemas', 'trabajador', '$2y$10$tupxgx6SOtk5ii1abEUi/eXElmcp8s4fl2gK1fpoUtpr78/KgzpHK'),
(1234567890, 'Prueba dos', 'Prueba dos', 'Prueba 2', '3206608978', 'M', '2000-02-12', 'Ingeniero de Sistemas', 'trabajador', '$2y$10$M2elCn6kPdVpW19RVBeHaOF7ae8u8fCb6ZwPSXBPyPyfhrtKqEo/e');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `valor` decimal(10,0) DEFAULT NULL,
  `lugar` text DEFAULT NULL,
  `responsable` int(11) DEFAULT NULL,
  `estado` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `descripcion`, `fecha_inicio`, `fecha_entrega`, `valor`, `lugar`, `responsable`, `estado`) VALUES
(1234, 'Proyecto 1', '2024-03-20', '2024-05-27', 900000, 'Unicordoba', 1234567890, 'En Progreso'),
(6898, 'Proyecto 2', '2024-05-20', '2024-06-25', 300000, 'Lorica', 1003789002, 'En Progreso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursos`
--

CREATE TABLE `recursos` (
  `id_recurso` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `valor` decimal(10,0) DEFAULT NULL,
  `unidad_medida` text DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recursos`
--

INSERT INTO `recursos` (`id_recurso`, `descripcion`, `valor`, `unidad_medida`, `nombre`) VALUES
(23456, 'Arena', 13000, 'Metro', 'Arena'),
(45454, 'Recurso 1 1', 30000, 'metros', 'Recurso 2'),
(67899, 'Ladrillo', 1500, '100', 'Ladrillo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `id_actividad` int(11) DEFAULT NULL,
  `estado` text DEFAULT NULL,
  `presupuesto` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `descripcion`, `fecha_inicio`, `fecha_final`, `id_actividad`, `estado`, `presupuesto`) VALUES
(3233, 'Tarea 1', '2024-03-11', '2024-05-04', 9898, 'En Progreso', 34000),
(3333, 'Tarea 2', '2024-03-14', '2024-04-19', 4321, 'Completada', 50000),
(3434, 'Tarea 3', '2024-01-12', '2024-01-30', 9898, 'En Progreso', 30000),
(4444, 'Tarea 4', '2024-03-23', '2024-04-23', 4321, 'Completada', 50000),
(5655, 'Tarea 5', '2024-02-13', '2024-02-29', 6667, 'En Progreso', 120000),
(565511, 'Tarea 6', '2024-03-15', '2024-04-15', 4321, 'En Progreso', 120000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareaxpersona`
--

CREATE TABLE `tareaxpersona` (
  `id_tarea` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `duracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareaxpersona`
--

INSERT INTO `tareaxpersona` (`id_tarea`, `id_persona`, `duracion`) VALUES
(3233, 30661550, 13),
(3233, 1234567890, 365),
(3333, 123, 34),
(3333, 30661550, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareaxrecurso`
--

CREATE TABLE `tareaxrecurso` (
  `id_tarea` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareaxrecurso`
--

INSERT INTO `tareaxrecurso` (`id_tarea`, `id_recurso`, `cantidad`) VALUES
(3233, 45454, 23),
(4444, 67899, 55);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_proyecto` (`id_proyecto`),
  ADD KEY `fk_responsable_persona` (`responsable`);

--
-- Indices de la tabla `actividadxpersona`
--
ALTER TABLE `actividadxpersona`
  ADD PRIMARY KEY (`id_actividad`,`id_persona`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `actividadxrecurso`
--
ALTER TABLE `actividadxrecurso`
  ADD PRIMARY KEY (`id_actividad`,`id_recurso`),
  ADD KEY `id_recurso` (`id_recurso`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `fk_responsable` (`responsable`);

--
-- Indices de la tabla `recursos`
--
ALTER TABLE `recursos`
  ADD PRIMARY KEY (`id_recurso`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_actividad` (`id_actividad`);

--
-- Indices de la tabla `tareaxpersona`
--
ALTER TABLE `tareaxpersona`
  ADD PRIMARY KEY (`id_tarea`,`id_persona`),
  ADD KEY `id_persona` (`id_persona`);

--
-- Indices de la tabla `tareaxrecurso`
--
ALTER TABLE `tareaxrecurso`
  ADD PRIMARY KEY (`id_tarea`,`id_recurso`),
  ADD KEY `id_recurso` (`id_recurso`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`),
  ADD CONSTRAINT `fk_responsable_persona` FOREIGN KEY (`responsable`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `actividadxpersona`
--
ALTER TABLE `actividadxpersona`
  ADD CONSTRAINT `actividadxpersona_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  ADD CONSTRAINT `actividadxpersona_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `actividadxrecurso`
--
ALTER TABLE `actividadxrecurso`
  ADD CONSTRAINT `actividadxrecurso_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`),
  ADD CONSTRAINT `actividadxrecurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recursos` (`id_recurso`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_responsable` FOREIGN KEY (`responsable`) REFERENCES `personas` (`id_persona`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id_actividad`);

--
-- Filtros para la tabla `tareaxpersona`
--
ALTER TABLE `tareaxpersona`
  ADD CONSTRAINT `tareaxpersona_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id_tarea`),
  ADD CONSTRAINT `tareaxpersona_ibfk_2` FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

--
-- Filtros para la tabla `tareaxrecurso`
--
ALTER TABLE `tareaxrecurso`
  ADD CONSTRAINT `tareaxrecurso_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id_tarea`),
  ADD CONSTRAINT `tareaxrecurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recursos` (`id_recurso`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
