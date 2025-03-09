-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-03-2025 a las 15:22:30
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
-- Base de datos: `oddisey web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_admin`
--

CREATE TABLE `productos_admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripción` text NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos_admin`
--

INSERT INTO `productos_admin` (`id`, `nombre`, `descripción`, `precio`, `fecha`) VALUES
(1, 'Computadora Dell Cpu Intel I5 8gb 500gb ', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Dell</li>\r\n<li><b>Modelo:</b> Cpu Intel I5</li>\r\n<li><b>Color:</b> Negro</li>\r\n<li><b>Material corte:</b> Metal de mayor resistencia </li>\r\n<li><b>Procesador:</b> 8gb de RAM</li>\r\n</ul>\r\n', 100, '0000-00-00 00:00:00'),
(2, 'Monitor Touch Screen Tactil 15 Aon Tsm-115ts', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Aon</li>\r\n<li><b>Modelo:</b> Tsm-115ts</li>\r\n<li><b>Material:</b> Vidrio templado y delicado</li>\r\n<li><b>Tamaño:</b> Mediano</li>\r\n<li><b>Color:</b> Negro</li>\r\n</ul>', 110, '0000-00-00 00:00:00'),
(3, 'Toyota Hilux Kavak 4x4 2015', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Toyota</li>\r\n<li><b>Modelo:</b> Hilux Kavak 4x4</li>\r\n<li><b>Color:</b> Blanco</li>\r\n<li><b>Colección:</b> Camionetas a todo terreno 2015</li>\r\n</ul>\r\n\r\n', 300, '0000-00-00 00:00:00'),
(4, 'Silla Multifuncional Taburtes Cocinas Meson Barra Altas', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Taburtes</li>\r\n<li><b>Modelo:</b> Sillas multifuncional para barras altas y bajas</li>\r\n<li><b>Colección:</b> Mueblería-Cocina 2024</li>\r\n<li><b>Color:</b> Blanco</li>\r\n<li><b>Material:</b> Tela blanda y esponjosa</li>\r\n</ul>', 250, '0000-00-00 00:00:00'),
(5, 'Sofa Cama Sophie Dos Puestos Gris', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Sophie</li>\r\n<li><b>Modelo:</b> Sofá cama de dos puestos</li>\r\n<li><b>Colección:</b> Muebleria-Sophie 2022</li>\r\n<li><b>Color:</b> Gris</li>\r\n<li><b>Material:</b> Tela delicada y suave</li>\r\n</ul>', 310, '0000-00-00 00:00:00'),
(6, 'Cortador De Tubería Capilar Everwell', '<ul>\r\n<h5>Características</h5>\r\n<li><b>Marca:</b> Everwell</li>\r\n<li><b>Color:</b> Verde y gris</li>\r\n<li><b>Colección:</b> Utensilios-carpintería 2019</li>\r\n<li><b>Material:</b> Metal resistente y duro</li>\r\n</ul>\r\n', 330, '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos_admin`
--
ALTER TABLE `productos_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos_admin`
--
ALTER TABLE `productos_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
