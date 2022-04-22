-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql:3306
-- Tiempo de generación: 22-04-2022 a las 16:14:27
-- Versión del servidor: 8.0.28
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = 'Europe/Paris';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `SIBW`
--

-- --------------------------------------------------------


-- crear usuario y dar permisos
create user 'esther'@'%' identified by '7028';
grant create, delete, drop, index, insert, select, references, update, alter on sibw.* to 'esther'@'%';
--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_com` int NOT NULL,
  `autor` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `texto` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `respuesta` int DEFAULT NULL,
  `id_prod` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_com`, `autor`, `fecha`, `texto`, `respuesta`, `id_prod`) VALUES
(1, 'Juan Alberto Martínez', '2022-01-31 10:50:00', '¿En esta web no se pueden poner tildes o qué?', NULL, 1),
(2, 'Rosa Mª Gallego Calvente', '2022-01-04 16:43:00', 'Producto horrible, lo dejé abierto un par de horas y se secó completamente. No lo recomiendo.', NULL, 1),
(3, 'Salvador Romero', '2022-04-18 18:59:00', 'Pues eso... qué decir... es un lápiz de color amarillo y sirve para lo que sirve. No es que sea mágico como el de Bob Esponja, pero está bien', NULL, 2),
(4, 'Abel Ríos González', '2022-03-17 05:43:00', 'No se puede porque la base de datos no lo admite, pero probemos: ¿Quiénes somos, de dónde venimos?', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes`
--

CREATE TABLE `imagenes` (
  `ruta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `caption` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_prod` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `imagenes`
--

INSERT INTO `imagenes` (`ruta`, `caption`, `id_prod`) VALUES
('../images/imagen1.jpg', 'Apuntes', 1),
('../images/imagen10.jpeg', 'Pintura roja', 6),
('../images/imagen11.jpeg', 'Pintura blanca', 5),
('../images/imagen12.webp', 'Caja de tombow', 1),
('../images/imagen2.webp', 'Pincel', 3),
('../images/imagen3.jpg', 'Caballete', 4),
('../images/imagen4.jpeg', 'Caballete pequeñito', 4),
('../images/imagen5.jpeg', 'Pinceles rotos', 3),
('../images/imagen6.jpeg', 'Lápices amarillos', 2),
('../images/imagen7.jpeg', 'Lápices amarillos', 2),
('../images/imagen8.jpeg', 'Lápiz staedler', 2),
('../images/imagen9.jpeg', 'Pintura roja', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `palabra` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `palabras`
--

INSERT INTO `palabras` (`palabra`) VALUES
('cabrón'),
('coño'),
('follar'),
('imbécil'),
('joder'),
('polla'),
('puta'),
('subnormal'),
('zorra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_prod` int NOT NULL,
  `nombre` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `marca` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fechaPublicacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_prod`, `nombre`, `marca`, `precio`, `fechaPublicacion`, `descripcion`) VALUES
(1, 'Rotulador lettering', 'Tomboy', '3.00', '2022-04-16 00:00:00', 'Un bonito rotulador azul muy aclamado por la crítica, aunque con un precio elevado'),
(2, 'Lápiz amarillo', 'Stabilus', '2.50', '2022-04-16 00:00:00', 'Es un lápiz normal y corriente... tal vez demasiado corriente'),
(3, 'Pincel despeluchado', 'artsy', '1.99', '2022-04-16 00:00:00', 'Si tienes que pintar los pelos que se le quedan a tu gato tras rozarse con un globo este es tu pincel'),
(4, 'Caballete del caballero', 'OldWest', '5.99', '2022-04-16 00:00:00', 'Un caballete con un divertido sombrero que evoca un pasado turbulento (el sombrero no esta incluido)'),
(5, 'Pintura blanco marfil', 'Chiguagua', '19.99', '2022-04-16 00:00:00', 'El por qué este bote de pintura es tan caro es un misterio, a lo mejor esta hecho de marfil de verdad'),
(6, 'Pintura rojo sangre', 'Draculaura', '2.99', '2022-04-16 00:00:00', 'Un bote de color rojizo que recuerda a la sangre... tal vez es por eso que se vende tan bien en Halloween');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_com`),
  ADD KEY `id_prod` (`id_prod`),
  ADD KEY `respuesta` (`respuesta`);

--
-- Indices de la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD PRIMARY KEY (`ruta`),
  ADD KEY `id_prod` (`id_prod`);

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`palabra`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_prod`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_com` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id_prod`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`respuesta`) REFERENCES `comentarios` (`id_com`);

--
-- Filtros para la tabla `imagenes`
--
ALTER TABLE `imagenes`
  ADD CONSTRAINT `imagenes_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `productos` (`id_prod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
