-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-01-2022 a las 09:26:08
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reto_covid`
--
CREATE DATABASE IF NOT EXISTS `reto_covid` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `reto_covid`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `spLoginDNI`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spLoginDNI` (IN `getDni` VARCHAR(9), IN `getPassword` VARCHAR(50))  SELECT u.cod_user_u, s.*, r.nombre_r
FROM user u
INNER JOIN sanitario s ON s.dni_s = u.dni_sanitario_u
INNER JOIN rol r ON r.cod_r = u.cod_rol_u
WHERE u.dni_sanitario_u = getDni AND u.password_u = getPassword$$

DROP PROCEDURE IF EXISTS `spLoginTIS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `spLoginTIS` (IN `getTis` INT(8), IN `getFecha_nac` DATE)  SELECT *
FROM datos_paciente d
INNER JOIN localidad l ON l.cod_localidad_l = d.cod_localidad_p
INNER JOIN centro c ON c.cod_localidad_ce = l.cod_localidad_l
INNER JOIN cita ci ON ci.tis_paciente_ci = d.tis_datos_p
INNER JOIN registro_vacunacion r ON r.tis_registro_rg = d.tis_datos_p
INNER JOIN vacuna v ON v.cod_vacuna_v = r.cod_vacuna_rg
WHERE d.tis_datos_p =getTis  AND d.fecha_nacimiento_p = getFecha_nac$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro`
--

DROP TABLE IF EXISTS `centro`;
CREATE TABLE IF NOT EXISTS `centro` (
  `cod_centro_ce` int(5) NOT NULL AUTO_INCREMENT,
  `cod_localidad_ce` int(5) NOT NULL,
  `nombre_ce` varchar(25) NOT NULL,
  `telefono_ce` int(9) NOT NULL,
  `email_ce` varchar(50) NOT NULL,
  `horario_temprano_ce` varchar(11) NOT NULL,
  `horario_tarde_ce` varchar(11) NOT NULL,
  `horario_noche_ce` varchar(11) NOT NULL,
  `dias_ce` varchar(25) NOT NULL,
  PRIMARY KEY (`cod_centro_ce`),
  KEY `cod_localidad` (`cod_localidad_ce`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `centro`
--

INSERT INTO `centro` (`cod_centro_ce`, `cod_localidad_ce`, `nombre_ce`, `telefono_ce`, `email_ce`, `horario_temprano_ce`, `horario_tarde_ce`, `horario_noche_ce`, `dias_ce`) VALUES
(3, 1, 'Ambulatorio Durango', 68867022, 'durango@gmail.com', '7:00-13:00', '16:00-19:00', '20:00-00:00', 'l,m,x,j,v,s,d'),
(4, 2, 'Centro de Gernika', 612120088, 'gernika@gmail.com', '8:00-12:00', '16:00-18:30', '20:00-22:00', 'l,m,x,j,v'),
(5, 3, 'Centro de Indautxu', 643450081, 'indautxu@gmail.com', '7:30-11:30', '17:00-19:00', '21:00-23:00', 'l,m,x,j'),
(6, 4, 'Ondarroko osasunetxea', 612120089, 'ondarroa@gmail.com', '7:00-12:00', '16:30-18:30', '', 'l,m,x,j,v,s'),
(7, 5, 'Ambulatorio Galdakao', 600612129, 'galdakao@gmail.com', '8:00-12:30', '14:00-19:30', '', 'l,m,x,j,v,s,d'),
(8, 6, 'Centro salud Mungia', 677761200, 'mungia@gmail.com', '8:30-14:00', '17:00-19:00', '21:00-23:30', 'l,m,x,j,v');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE IF NOT EXISTS `cita` (
  `cod_cita_ci` int(5) NOT NULL AUTO_INCREMENT,
  `tis_paciente_ci` int(5) NOT NULL,
  `cod_sanitario_ci` int(5) NOT NULL,
  `fecha_ci` date NOT NULL,
  `hora_ci` time NOT NULL,
  `cod_centro_ci` int(5) NOT NULL,
  PRIMARY KEY (`cod_cita_ci`),
  KEY `tis_paciente` (`tis_paciente_ci`),
  KEY `cod_centro` (`cod_centro_ci`),
  KEY `cod_sanitario` (`cod_sanitario_ci`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`cod_cita_ci`, `tis_paciente_ci`, `cod_sanitario_ci`, `fecha_ci`, `hora_ci`, `cod_centro_ci`) VALUES
(3, 1989660, 5, '2021-01-20', '12:56:00', 6),
(4, 2324758, 6, '2022-01-02', '09:40:00', 3),
(5, 4990916, 4, '2020-11-11', '17:00:00', 4),
(6, 2324666, 1, '2021-03-26', '12:35:00', 6),
(7, 2699012, 5, '2022-02-09', '16:15:00', 3),
(8, 3090114, 5, '2022-01-28', '08:30:00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_paciente`
--

DROP TABLE IF EXISTS `datos_paciente`;
CREATE TABLE IF NOT EXISTS `datos_paciente` (
  `tis_datos_p` int(8) NOT NULL AUTO_INCREMENT,
  `nombre_p` varchar(25) NOT NULL,
  `apellido_p` varchar(50) NOT NULL,
  `fecha_nacimiento_p` date NOT NULL,
  `email_p` varchar(50) NOT NULL,
  `telefono_p` int(9) NOT NULL,
  `foto_perfil_p` longtext NOT NULL,
  `direccion_p` varchar(25) NOT NULL,
  `cod_localidad_p` int(5) NOT NULL,
  `status_p` tinyint(4) NOT NULL,
  PRIMARY KEY (`tis_datos_p`),
  KEY `cod_localidad` (`cod_localidad_p`)
) ENGINE=InnoDB AUTO_INCREMENT=4990917 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `datos_paciente`
--

INSERT INTO `datos_paciente` (`tis_datos_p`, `nombre_p`, `apellido_p`, `fecha_nacimiento_p`, `email_p`, `telefono_p`, `foto_perfil_p`, `direccion_p`, `cod_localidad_p`, `status_p`) VALUES
(1989660, 'Fali', 'Gutierrez', '1953-04-17', 'fali@gmail.com', 688659090, 'img1.jpg', 'Ondarroa, Zaldupe kalea', 4, 1),
(2324666, 'Maria', 'Casas', '2001-03-26', 'maria@gmail.com', 611653211, 'img2.jpg', 'Mungia, Maule kalea', 6, 1),
(2324758, 'Juan', 'Vázquez', '1965-07-12', 'juan@gmail.com', 666610853, 'img3.jpg', 'Durango, Ambrosio Meabe', 1, 1),
(2699012, 'Miren', 'Martín', '2016-10-08', 'miren@gmail.com', 612400112, 'img4.jpg', 'Gernika, Calle Huarte', 2, 1),
(3090114, 'Roberto', 'Torres', '1940-04-04', 'roberto@gmail.com', 600612702, 'img5.jpg', 'Bilbao, Abando', 3, 1),
(4990916, 'Lorea', 'Barrenetxea', '2018-03-17', 'lorea@gmail.com', 690801561, 'img6.jpg', 'Galdako, Zamakoa', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

DROP TABLE IF EXISTS `formulario`;
CREATE TABLE IF NOT EXISTS `formulario` (
  `id_formulario_f` int(9) NOT NULL AUTO_INCREMENT,
  `nombre_f` varchar(25) NOT NULL,
  `correo_f` varchar(50) NOT NULL,
  `motivo_f` varchar(25) NOT NULL,
  `otro_f` varchar(25) NOT NULL,
  `mensaje_f` varchar(500) NOT NULL,
  PRIMARY KEY (`id_formulario_f`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_formulario_f`, `nombre_f`, `correo_f`, `motivo_f`, `otro_f`, `mensaje_f`) VALUES
(1, 'test', ' a@a', '', '', ''),
(2, 'test', ' test@test.test', '', '', 'a'),
(3, 'test', ' test@test.test', '', '', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

DROP TABLE IF EXISTS `localidad`;
CREATE TABLE IF NOT EXISTS `localidad` (
  `cod_localidad_l` int(5) NOT NULL AUTO_INCREMENT,
  `nombre_l` varchar(25) NOT NULL,
  PRIMARY KEY (`cod_localidad_l`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`cod_localidad_l`, `nombre_l`) VALUES
(1, 'Durango'),
(2, 'Gernika'),
(3, 'Bilbao'),
(4, 'Ondarroa'),
(5, 'Galdakao'),
(6, 'Mungia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_vacunacion`
--

DROP TABLE IF EXISTS `registro_vacunacion`;
CREATE TABLE IF NOT EXISTS `registro_vacunacion` (
  `cod_registro_rg` int(5) NOT NULL AUTO_INCREMENT,
  `tis_registro_rg` int(8) NOT NULL,
  `cod_vacuna_rg` int(5) NOT NULL,
  `dosis_rg` int(5) NOT NULL,
  `fecha_ultima_vacuna_rg` date NOT NULL,
  PRIMARY KEY (`cod_registro_rg`),
  KEY `tis` (`tis_registro_rg`),
  KEY `cod_vacuna` (`cod_vacuna_rg`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `registro_vacunacion`
--

INSERT INTO `registro_vacunacion` (`cod_registro_rg`, `tis_registro_rg`, `cod_vacuna_rg`, `dosis_rg`, `fecha_ultima_vacuna_rg`) VALUES
(3, 1989660, 1, 1, '2021-12-15'),
(4, 2324758, 3, 2, '2022-01-02'),
(5, 4990916, 6, 2, '2021-08-17'),
(6, 2324666, 2, 3, '2021-05-05'),
(7, 2699012, 1, 2, '2021-09-07'),
(8, 3090114, 6, 2, '2021-08-18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `cod_r` int(5) NOT NULL AUTO_INCREMENT,
  `nombre_r` varchar(25) NOT NULL,
  `descripcion_r` varchar(90) NOT NULL,
  PRIMARY KEY (`cod_r`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`cod_r`, `nombre_r`, `descripcion_r`) VALUES
(1, 'administrador', 'Tiene acceso a toda la página con roles superiores'),
(2, 'usuario', 'Tiene acceso a la pagina web logenadose'),
(3, 'invitado', 'Puede ver la página web sin registrarse');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sanitario`
--

DROP TABLE IF EXISTS `sanitario`;
CREATE TABLE IF NOT EXISTS `sanitario` (
  `cod_sanitario_s` int(5) NOT NULL AUTO_INCREMENT,
  `nombre_s` varchar(25) NOT NULL,
  `apellido_s` varchar(50) NOT NULL,
  `dni_s` varchar(9) NOT NULL,
  `cargo_s` varchar(25) NOT NULL,
  `cod_centro_s` int(5) NOT NULL,
  `foto_perfil_s` longtext NOT NULL,
  PRIMARY KEY (`cod_sanitario_s`),
  UNIQUE KEY `dni` (`dni_s`),
  KEY `cod_centro` (`cod_centro_s`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sanitario`
--

INSERT INTO `sanitario` (`cod_sanitario_s`, `nombre_s`, `apellido_s`, `dni_s`, `cargo_s`, `cod_centro_s`, `foto_perfil_s`) VALUES
(1, 'Pablo', 'Quiroga', '45612348Z', 'Vacunador', 3, 'imgs1.jpg'),
(2, 'Onintze', 'Basozabal', '4120071B', 'Celador', 8, 'imgs2.jpg'),
(4, 'Aitor', 'Mentagoitia', '63410929G', 'Vacunador', 7, 'imgs3.jpg'),
(5, 'Joseba', 'Martínez', '54812091P', 'Vacunador', 5, 'imgs4.jpg'),
(6, 'Sara', 'López', '12916756T', 'Celador', 6, 'imgs5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `cod_user_u` int(5) NOT NULL AUTO_INCREMENT,
  `cod_rol_u` int(5) NOT NULL DEFAULT 0,
  `password_u` text NOT NULL,
  `dni_sanitario_u` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`cod_user_u`),
  KEY `dni_sanitario` (`dni_sanitario_u`),
  KEY `cod_rol` (`cod_rol_u`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`cod_user_u`, `cod_rol_u`, `password_u`, `dni_sanitario_u`) VALUES
(1, 1, 'admin', '54812091P'),
(2, 2, 'user', '12916756T'),
(3, 2, 'user', '63410929G'),
(4, 3, 'invitado', '4120071B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacuna`
--

DROP TABLE IF EXISTS `vacuna`;
CREATE TABLE IF NOT EXISTS `vacuna` (
  `cod_vacuna_v` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_v` varchar(25) NOT NULL,
  `max_v` int(5) NOT NULL,
  `intervalo_v` int(5) NOT NULL,
  PRIMARY KEY (`cod_vacuna_v`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `vacuna`
--

INSERT INTO `vacuna` (`cod_vacuna_v`, `nombre_v`, `max_v`, `intervalo_v`) VALUES
(1, 'Pfizer', 4, 4),
(2, 'Moderna', 3, 4),
(3, 'AstraZeneca', 3, 6),
(4, 'Janssen', 2, 6),
(5, 'Novavax', 3, 4),
(6, 'Sanofi', 2, 6),
(7, 'Valneva', 2, 4);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `centro`
--
ALTER TABLE `centro`
  ADD CONSTRAINT `centro_ibfk_1` FOREIGN KEY (`cod_localidad_ce`) REFERENCES `localidad` (`cod_localidad_l`);

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`cod_centro_ci`) REFERENCES `centro` (`cod_centro_ce`),
  ADD CONSTRAINT `cita_ibfk_3` FOREIGN KEY (`cod_sanitario_ci`) REFERENCES `sanitario` (`cod_sanitario_s`),
  ADD CONSTRAINT `cita_ibfk_4` FOREIGN KEY (`tis_paciente_ci`) REFERENCES `datos_paciente` (`tis_datos_p`);

--
-- Filtros para la tabla `datos_paciente`
--
ALTER TABLE `datos_paciente`
  ADD CONSTRAINT `datos_paciente_ibfk_1` FOREIGN KEY (`cod_localidad_p`) REFERENCES `localidad` (`cod_localidad_l`);

--
-- Filtros para la tabla `registro_vacunacion`
--
ALTER TABLE `registro_vacunacion`
  ADD CONSTRAINT `registro_vacunacion_ibfk_1` FOREIGN KEY (`cod_vacuna_rg`) REFERENCES `vacuna` (`cod_vacuna_v`),
  ADD CONSTRAINT `registro_vacunacion_ibfk_2` FOREIGN KEY (`tis_registro_rg`) REFERENCES `datos_paciente` (`tis_datos_p`);

--
-- Filtros para la tabla `sanitario`
--
ALTER TABLE `sanitario`
  ADD CONSTRAINT `sanitario_ibfk_1` FOREIGN KEY (`cod_centro_s`) REFERENCES `centro` (`cod_centro_ce`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`dni_sanitario_u`) REFERENCES `sanitario` (`dni_s`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`cod_rol_u`) REFERENCES `rol` (`cod_r`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
