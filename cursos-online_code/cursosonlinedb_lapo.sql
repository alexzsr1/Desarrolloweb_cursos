-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 11:43 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cursosonlinedb_lapo`
--

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE IF NOT EXISTS `cursos` (
  `id` int(6) unsigned NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` mediumtext,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `reg_date`) VALUES
(1, 'Introducción a la programación con Python', 'Este curso está diseñado para principiantes interesados en aprender los fundamentos de la programación utilizando Python, uno de los lenguajes más populares y versátiles. Aprenderás conceptos clave como variables, estructuras de control, funciones y manejo de datos. Al finalizar, serás capaz de crear programas básicos y sentarás las bases para avanzar hacia áreas más complejas como el análisis de datos, desarrollo web y automatización.', '2024-11-29 03:38:12'),
(2, 'Curso de Programación Básica', 'Aprende los fundamentos de la programación.', '2024-11-29 04:45:23'),
(3, 'Curso de Desarrollo Web', 'Conviértete en un experto desarrollador web.', '2024-11-29 04:45:23'),
(4, 'Desarrollo Web Full Stack con JavaScript', 'Aprende a crear aplicaciones web modernas dominando tanto el frontend como el backend. Curso práctico que cubre HTML5, CSS3, JavaScript, Node.js, React y bases de datos.', '2024-12-01 09:55:50'),
(5, 'Python para Análisis de Datos', 'Sumérgete en el mundo del análisis de datos con Python. Aprenderás bibliotecas como Pandas, NumPy, Matplotlib y técnicas de manipulación y visualización de datos.', '2024-12-01 09:55:50'),
(6, 'Diseño UX/UI Profesional', 'Domina las mejores prácticas de diseño de experiencia de usuario. Aprenderás herramientas como Figma, principios de diseño centrado en el usuario y creación de prototipos.', '2024-12-01 09:55:50'),
(7, 'Inglés Conversacional', 'Mejora tu fluidez en inglés con clases interactivas. Enfoque en conversación, gramática práctica y vocabulario para situaciones cotidianas y profesionales.', '2024-12-01 09:55:50'),
(8, 'Criptomonedas y Blockchain', 'Comprende el mundo de las criptomonedas, tecnología blockchain, trading y conceptos de finanzas descentralizadas (DeFi).', '2024-12-01 09:55:50');

-- --------------------------------------------------------

--
-- Table structure for table `inscripciones`
--

CREATE TABLE IF NOT EXISTS `inscripciones` (
  `id` int(6) unsigned NOT NULL,
  `usuario_id` int(6) unsigned NOT NULL,
  `curso_id` int(6) unsigned NOT NULL,
  `nivel_experiencia` enum('Principiante','Intermedio','Avanzado') DEFAULT 'Principiante',
  `fecha_inicio` date DEFAULT NULL,
  `modalidad` enum('Online','Presencial') DEFAULT 'Online',
  `comentarios` text,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inscripciones`
--

INSERT INTO `inscripciones` (`id`, `usuario_id`, `curso_id`, `nivel_experiencia`, `fecha_inicio`, `modalidad`, `comentarios`, `reg_date`) VALUES
(21, 6, 1, 'Avanzado', '2024-12-20', 'Online', 'Buenos días', '2024-12-01 10:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(6) unsigned NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `usuario`, `clave`, `reg_date`) VALUES
(1, 'Admin', 'Admin', 'admin123@gmail.com', 'admin', 'test123', '2024-11-28 04:44:53'),
(2, 'Test', 'Test', 'Test@mail.com', 'tester', '$2y$10$8XHprIkij85WkNpbErhvgO2bMlUNIa7hDccwY6BT.SMV6e/bE15Ie', '2024-11-28 08:40:49'),
(6, 'Brayan', 'Lapo', 'balapo@mail.com', 'balapo', '$2y$10$va/BdA7fhcTPis4tEneuduqi/Pl5aGBMbjZL3BeYzBJqzzxesTrD2', '2024-12-01 07:24:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`curso_id`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `inscripciones`
--
ALTER TABLE `inscripciones`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
