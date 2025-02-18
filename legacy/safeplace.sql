-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-11-2024 a las 23:32:06
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
-- Base de datos: `safeplace`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_roles`
--

CREATE TABLE `acl_roles` (
  `cod_acl_role` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `perm1` tinyint(1) NOT NULL DEFAULT 0,
  `perm2` tinyint(1) NOT NULL DEFAULT 0,
  `perm3` tinyint(1) NOT NULL DEFAULT 0,
  `perm4` tinyint(1) NOT NULL DEFAULT 0,
  `perm5` tinyint(1) NOT NULL DEFAULT 0,
  `perm6` tinyint(1) NOT NULL DEFAULT 0,
  `perm7` tinyint(1) NOT NULL DEFAULT 0,
  `perm8` tinyint(1) NOT NULL DEFAULT 0,
  `perm9` tinyint(1) NOT NULL DEFAULT 0,
  `perm10` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_roles`
--

INSERT INTO `acl_roles` (`cod_acl_role`, `nombre`, `perm1`, `perm2`, `perm3`, `perm4`, `perm5`, `perm6`, `perm7`, `perm8`, `perm9`, `perm10`) VALUES
(1, 'admin total', 1, 0, 1, 1, 1, 1, 1, 0, 0, 0),
(2, 'usuario', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'admin auxiliar', 0, 0, 1, 1, 1, 1, 1, 0, 0, 0),
(4, 'gest_sugerencias', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0),
(5, 'gest_reportes', 0, 0, 1, 0, 1, 0, 0, 0, 0, 0),
(6, 'gest_resenias', 0, 0, 1, 0, 0, 1, 0, 0, 0, 0),
(7, 'gest_total_sitios', 0, 0, 1, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `cod_acl_role` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`, `borrado_fecha`, `borrado_por`) VALUES
(0, '--', '--', '--', 2, 1, '2024-10-01 22:08:42', 1),
(1, 'CleoNavarro', 'Cleo Navarro Molina', 'f1575b49081d7abe41fd7f150f4a2d0a7c22a96b', 1, 0, NULL, 0),
(2, 'AdminAux', 'Administrador Auxiliar', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 3, 0, NULL, 0),
(3, 'PlaceGestor', 'Gestor de Sitios', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 7, 0, NULL, 0),
(4, 'Sugestions', 'Gestor de Sugerencias', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 4, 0, NULL, 0),
(5, 'Reports', 'Gestión de Reportes', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 5, 0, NULL, 0),
(6, 'Reviews', 'Gestor de Reseñas', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 6, 0, NULL, 0),
(7, 'UserTest', 'Usuario Test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 2, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `cod_caracteristica` int(11) NOT NULL,
  `nombre_caract` varchar(60) NOT NULL,
  `descripcion_caract` varchar(400) NOT NULL,
  `icono_caract` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `caracteristicas`
--

INSERT INTO `caracteristicas` (`cod_caracteristica`, `nombre_caract`, `descripcion_caract`, `icono_caract`) VALUES
(1, 'Adaptado para ciegos', 'Este sitio está adaptado para ayudar a personas con dificultades visuales: carta y cartelería en braile, avisos sonoros, adaptación para ciegos...', ''),
(2, 'Adaptado para movilidad reducida', 'Este sitio tiene elementos que facilitan la movilidad a personas con dificultades de movimiento: rampas, barandas, sillas móviles, ascensores...', ''),
(3, 'Adaptado para silla de ruedas', 'Este sitio tiene elementos que facilitan la movilidad a personas en sillas de ruedas: rampas, ascensores, espacio en los pasillos, plazas especiales...', ''),
(4, 'Adaptado para sordos', 'Este sitio tiene elementos que ayudan a las personas con dificultades en la escucha y el habla: atención en lenguaje de signos, protocolos de comunicación...', ''),
(5, 'Zona sin humos', 'Este establecimiento está libre de humos y no permite fumadores.', ''),
(6, 'Zona sin ruido', 'Este sitio es silencioso, tiene una zona de cero ruido o tiene horarios diarios de silencio', ''),
(7, 'Protocolo contra abusos', 'El personal de este establecimiento está preparado para atender a víctimas de abuso sexual, violencia de género, maltrato infantil y homofobia, entre otros.', ''),
(8, 'Baño unisex', 'Este establecimiento cuenta con baño unisex', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cod_categoria` int(11) NOT NULL,
  `nombre_cat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cod_categoria`, `nombre_cat`) VALUES
(1, 'Restaurante'),
(2, 'Cafeteria'),
(3, 'Centro de Salud'),
(4, 'Centro Educativo'),
(5, 'Biblioteca'),
(6, 'Tienda de ropa'),
(7, 'Tienda de regalos'),
(8, 'Zona de ocio'),
(9, 'Sala de cine'),
(10, 'Estación de Tren');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comunidades`
--

CREATE TABLE `comunidades` (
  `cod_comunidad` int(11) NOT NULL,
  `nombre_comu` varchar(60) NOT NULL,
  `descripcion_comu` varchar(400) NOT NULL,
  `icono_comu` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `comunidades`
--

INSERT INTO `comunidades` (`cod_comunidad`, `nombre_comu`, `descripcion_comu`, `icono_comu`) VALUES
(1, 'LGBT Friendly', 'Este es un lugar seguro para personas LGBT (lesbianas, gays, bisexuales y transgénero, entre otras identidades)', ''),
(2, 'Atención en varios idiomas', 'El personal te atiende en varios idiomas extranjeros (además del español y el inglés)', ''),
(3, 'Seguro para comunidades racializadas', 'Este sitio es seguro para personas de otras etnias: personas de color, gitanos, latinoamericanos...', ''),
(4, 'Comunidades de odio', 'En este sitio se ha permitido la entrada a, o es frecuentado por, personas que apoyan discursos de odio hacia comunidades vulnerables', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `cod_reporte` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_sitio` int(11) NOT NULL,
  `cod_resenia` int(11) NOT NULL DEFAULT 0,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `titulo` varchar(120) NOT NULL,
  `motivo` varchar(2000) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `leido_fecha` datetime DEFAULT NULL,
  `leido_por` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenias`
--

CREATE TABLE `resenias` (
  `cod_resenia` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_sitio` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `puntuacion` int(11) NOT NULL,
  `titulo` varchar(120) DEFAULT NULL,
  `descripcion` varchar(800) DEFAULT NULL,
  `nuevo` datetime DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `resenias`
--

INSERT INTO `resenias` (`cod_resenia`, `cod_usuario`, `cod_sitio`, `fecha`, `puntuacion`, `titulo`, `descripcion`, `nuevo`, `borrado`, `borrado_fecha`, `borrado_por`) VALUES
(1, 0, 0, '2024-10-21', 1, '--', '--', '2024-10-21 22:21:39', 1, '2024-10-21 22:21:39', 0),
(2, 7, 4, '2024-10-21', 5, 'Muy contentos', 'Nuestros dos hijos han pasado por este instituto en Antequera y han salido muy bien preparados. Estamos muy contentos y agradecidos.', NULL, 0, NULL, 0),
(3, 7, 4, '2024-10-26', 4, 'Buen instituto', NULL, NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `cod_respuesta` int(11) NOT NULL,
  `cod_reporte` int(11) NOT NULL,
  `respondido_por` int(11) NOT NULL,
  `fecha_respuesta` datetime NOT NULL DEFAULT current_timestamp(),
  `mensaje` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios`
--

CREATE TABLE `sitios` (
  `cod_sitio` int(11) NOT NULL,
  `coor_x` decimal(8,5) NOT NULL,
  `coor_y` decimal(8,5) NOT NULL,
  `nombre_sitio` varchar(120) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `poblacion` varchar(60) NOT NULL,
  `cp` varchar(6) NOT NULL,
  `provincia` varchar(60) NOT NULL,
  `pais` varchar(60) NOT NULL,
  `descripcion` varchar(480) NOT NULL,
  `contacto` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `alta` datetime NOT NULL DEFAULT current_timestamp(),
  `alta_por` int(11) NOT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_borrado` datetime DEFAULT NULL,
  `borrado_por` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sitios`
--

INSERT INTO `sitios` (`cod_sitio`, `coor_x`, `coor_y`, `nombre_sitio`, `direccion`, `poblacion`, `cp`, `provincia`, `pais`, `descripcion`, `contacto`, `foto`, `alta`, `alta_por`, `borrado`, `fecha_borrado`, `borrado_por`) VALUES
(0, 0.00000, 0.00000, '--', '--', '--', '--', '--', '--', '--', '--', '--', '2024-10-20 22:09:47', 0, 1, '2024-10-21 22:09:47', 0),
(4, 37.01894, -4.55572, 'IES Pedro Espinosa', 'C. Carrera Madre Carmen, 12, 29200 Antequera, Málaga', 'Antequera', '29200', 'Málaga', 'España', 'Instituto de Secundaria, Bachillerato y Formación Profesional', 'http://www.iespedroespinosa.es/', 'fotoPorDefecto.jpg', '2024-10-21 22:12:01', 1, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios_caracteristicas`
--

CREATE TABLE `sitios_caracteristicas` (
  `cod_sitio_caracteristica` int(11) NOT NULL,
  `cod_sitio` int(11) NOT NULL,
  `cod_caracteristica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sitios_caracteristicas`
--

INSERT INTO `sitios_caracteristicas` (`cod_sitio_caracteristica`, `cod_sitio`, `cod_caracteristica`) VALUES
(1, 4, 2),
(2, 4, 3),
(3, 4, 7),
(4, 4, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios_categorias`
--

CREATE TABLE `sitios_categorias` (
  `cod_sitio_categoria` int(11) NOT NULL,
  `cod_sitio` int(11) NOT NULL,
  `cod_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sitios_categorias`
--

INSERT INTO `sitios_categorias` (`cod_sitio_categoria`, `cod_sitio`, `cod_categoria`) VALUES
(1, 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sitios_comunidades`
--

CREATE TABLE `sitios_comunidades` (
  `cod_sitio_comunidad` int(11) NOT NULL,
  `cod_sitio` int(11) NOT NULL,
  `cod_comunidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `sitios_comunidades`
--

INSERT INTO `sitios_comunidades` (`cod_sitio_comunidad`, `cod_sitio`, `cod_comunidad`) VALUES
(1, 4, 1),
(2, 4, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencias`
--

CREATE TABLE `sugerencias` (
  `cod_sugerencia` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre_sitio` varchar(120) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `poblacion` varchar(60) NOT NULL,
  `comentario` varchar(4000) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `mail_contacto` varchar(255) NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `leido_fecha` datetime DEFAULT NULL,
  `leido_por` int(11) DEFAULT 0,
  `anulado` tinyint(1) NOT NULL DEFAULT 0,
  `anulado_fecha` datetime DEFAULT NULL,
  `anulado_por` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `descripcion` varchar(480) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `pronombres` varchar(15) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `fecha_registrado` datetime NOT NULL DEFAULT current_timestamp(),
  `verificado` datetime DEFAULT NULL,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`cod_usuario`, `nombre`, `nick`, `descripcion`, `mail`, `telefono`, `pronombres`, `foto`, `fecha_registrado`, `verificado`, `borrado`, `borrado_fecha`, `borrado_por`) VALUES
(0, '--', '--', '--', '--', '--', '--', '--', '2024-10-20 22:17:08', '2024-10-20 22:17:08', 1, '2024-10-21 22:17:08', 1),
(1, 'Cleo Navarro Molina', 'CleoNavarro', 'Administradora de SafePlace. Creando un lugar seguro en la red', 'latitacleo@gmail.com', '656928992', 'She/Her', 'fotoUsuarioPorDefecto.png', '2024-05-22 20:11:33', '2024-10-18 12:47:33', 0, NULL, 0),
(2, 'Administrador Auxiliar', 'AdminAux', 'Administrador de SafePlace', 'adminaux@sfpl.com', '612345678', 'He/HIm', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-19 12:47:33', 0, NULL, 0),
(3, 'Gestor de Sitios', 'PlaceGestor', 'Gestor de Sitios', 'places@sfpl.com', '654987321', 'They/Them', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(4, 'Gestor de Sugerencias', 'Sugestions', 'Gestor de Sugerencias', 'sugestions@sfpl.com', '612378945', 'She/Her', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(5, 'Gestión de Reportes', 'Reports', 'Gestión de Reportes', 'reports@sfpl.com', '693582471', 'She/They', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(6, 'Gestor de Reseñas', 'Reviews', 'Gestor de Reseñas', 'reviews@sfpl.com', '645987312', 'He/They', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(7, 'Usuario Test', 'UserTest', 'Usuario Test', 'user@test.com', '656656656', 'She/Her', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_reportes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_reportes` (
`cod_reporte` int(11)
,`cod_usuario` int(11)
,`cod_sitio` int(11)
,`cod_resenia` int(11)
,`fecha` datetime
,`titulo` varchar(120)
,`motivo` varchar(2000)
,`leido` tinyint(1)
,`leido_fecha` datetime
,`leido_por` int(11)
,`nick_reportador` varchar(100)
,`pronombres` varchar(15)
,`foto` varchar(255)
,`nombre_sitio` varchar(120)
,`cod_usuario_reseniador` int(11)
,`fecha_resenia` date
,`titulo_resenia` varchar(120)
,`descripcion_resenia` varchar(800)
,`nick_reseniador` varchar(100)
,`nick_lector` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_resenias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_resenias` (
`cod_resenia` int(11)
,`cod_usuario` int(11)
,`cod_sitio` int(11)
,`fecha` date
,`puntuacion` int(11)
,`titulo` varchar(120)
,`descripcion` varchar(800)
,`nuevo` datetime
,`borrado` tinyint(1)
,`borrado_fecha` datetime
,`borrado_por` int(11)
,`nick_reseniador` varchar(100)
,`pronombres` varchar(15)
,`foto` varchar(255)
,`nombre_sitio` varchar(120)
,`nick_borrador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_respuestas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_respuestas` (
`cod_respuesta` int(11)
,`cod_reporte` int(11)
,`respondido_por` int(11)
,`fecha_respuesta` datetime
,`mensaje` varchar(2000)
,`nick_respuesta` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_sitios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_sitios` (
`cod_sitio` int(11)
,`coor_x` decimal(8,5)
,`coor_y` decimal(8,5)
,`nombre_sitio` varchar(120)
,`direccion` varchar(255)
,`poblacion` varchar(60)
,`cp` varchar(6)
,`provincia` varchar(60)
,`pais` varchar(60)
,`descripcion` varchar(480)
,`contacto` varchar(255)
,`foto` varchar(255)
,`alta` datetime
,`alta_por` int(11)
,`borrado` tinyint(1)
,`fecha_borrado` datetime
,`borrado_por` int(11)
,`puntuacion` decimal(12,1)
,`nombre_alta` varchar(100)
,`nombre_baja` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_sitios_caracteristicas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_sitios_caracteristicas` (
`cod_sitio_caracteristica` int(11)
,`cod_sitio` int(11)
,`cod_caracteristica` int(11)
,`nombre_sitio` varchar(120)
,`nombre_caract` varchar(60)
,`descripcion_caract` varchar(400)
,`icono_caract` varchar(400)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_sitios_categorias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_sitios_categorias` (
`cod_sitio_categoria` int(11)
,`cod_sitio` int(11)
,`cod_categoria` int(11)
,`nombre_sitio` varchar(120)
,`nombre_cat` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_sitios_comunidades`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_sitios_comunidades` (
`cod_sitio_comunidad` int(11)
,`cod_sitio` int(11)
,`cod_comunidad` int(11)
,`nombre_sitio` varchar(120)
,`nombre_comu` varchar(60)
,`descripcion_comu` varchar(400)
,`icono_comu` varchar(400)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_sugerencias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_sugerencias` (
`cod_sugerencia` int(11)
,`fecha` timestamp
,`nombre_sitio` varchar(120)
,`direccion` varchar(255)
,`poblacion` varchar(60)
,`comentario` varchar(4000)
,`foto` varchar(255)
,`mail_contacto` varchar(255)
,`leido` tinyint(1)
,`leido_fecha` datetime
,`leido_por` int(11)
,`anulado` tinyint(1)
,`anulado_fecha` datetime
,`anulado_por` int(11)
,`nick_lector` varchar(100)
,`nick_anulador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_reportes`
--
DROP TABLE IF EXISTS `vista_reportes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_reportes`  AS   (select `r`.`cod_reporte` AS `cod_reporte`,`r`.`cod_usuario` AS `cod_usuario`,`r`.`cod_sitio` AS `cod_sitio`,`r`.`cod_resenia` AS `cod_resenia`,`r`.`fecha` AS `fecha`,`r`.`titulo` AS `titulo`,`r`.`motivo` AS `motivo`,`r`.`leido` AS `leido`,`r`.`leido_fecha` AS `leido_fecha`,`r`.`leido_por` AS `leido_por`,`u`.`nick` AS `nick_reportador`,`u`.`pronombres` AS `pronombres`,`u`.`foto` AS `foto`,`s`.`nombre_sitio` AS `nombre_sitio`,`rs`.`cod_usuario` AS `cod_usuario_reseniador`,`rs`.`fecha` AS `fecha_resenia`,`rs`.`titulo` AS `titulo_resenia`,`rs`.`descripcion` AS `descripcion_resenia`,`u`.`nick` AS `nick_reseniador`,`a`.`nick` AS `nick_lector` from ((((`reportes` `r` join `sitios` `s`) join `resenias` `rs`) join `usuarios` `u`) join `acl_usuarios` `a`) where `r`.`cod_sitio` = `s`.`cod_sitio` and `r`.`cod_usuario` = `u`.`cod_usuario` and `rs`.`cod_usuario` = `u`.`cod_usuario` and `r`.`leido_por` = `a`.`cod_acl_usuario`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_resenias`
--
DROP TABLE IF EXISTS `vista_resenias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_resenias`  AS   (select `r`.`cod_resenia` AS `cod_resenia`,`r`.`cod_usuario` AS `cod_usuario`,`r`.`cod_sitio` AS `cod_sitio`,`r`.`fecha` AS `fecha`,`r`.`puntuacion` AS `puntuacion`,`r`.`titulo` AS `titulo`,`r`.`descripcion` AS `descripcion`,`r`.`nuevo` AS `nuevo`,`r`.`borrado` AS `borrado`,`r`.`borrado_fecha` AS `borrado_fecha`,`r`.`borrado_por` AS `borrado_por`,`u`.`nick` AS `nick_reseniador`,`u`.`pronombres` AS `pronombres`,`u`.`foto` AS `foto`,`s`.`nombre_sitio` AS `nombre_sitio`,`a`.`nick` AS `nick_borrador` from (((`resenias` `r` join `sitios` `s`) join `usuarios` `u`) join `acl_usuarios` `a`) where `r`.`cod_sitio` = `s`.`cod_sitio` and `r`.`cod_usuario` = `u`.`cod_usuario` and `r`.`borrado_por` = `a`.`cod_acl_usuario`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_respuestas`
--
DROP TABLE IF EXISTS `vista_respuestas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_respuestas`  AS SELECT `r`.`cod_respuesta` AS `cod_respuesta`, `r`.`cod_reporte` AS `cod_reporte`, `r`.`respondido_por` AS `respondido_por`, `r`.`fecha_respuesta` AS `fecha_respuesta`, `r`.`mensaje` AS `mensaje`, `u`.`nick` AS `nick_respuesta` FROM (`respuestas` `r` join `acl_usuarios` `u`) WHERE `r`.`respondido_por` = `u`.`cod_acl_usuario` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_sitios`
--
DROP TABLE IF EXISTS `vista_sitios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sitios`  AS   (select `s`.`cod_sitio` AS `cod_sitio`,`s`.`coor_x` AS `coor_x`,`s`.`coor_y` AS `coor_y`,`s`.`nombre_sitio` AS `nombre_sitio`,`s`.`direccion` AS `direccion`,`s`.`poblacion` AS `poblacion`,`s`.`cp` AS `cp`,`s`.`provincia` AS `provincia`,`s`.`pais` AS `pais`,`s`.`descripcion` AS `descripcion`,`s`.`contacto` AS `contacto`,`s`.`foto` AS `foto`,`s`.`alta` AS `alta`,`s`.`alta_por` AS `alta_por`,`s`.`borrado` AS `borrado`,`s`.`fecha_borrado` AS `fecha_borrado`,`s`.`borrado_por` AS `borrado_por`,(select round(avg(`r`.`puntuacion`),1) from `resenias` `r` where `r`.`cod_sitio` = `s`.`cod_sitio` group by `r`.`cod_sitio`) AS `puntuacion`,`al`.`nick` AS `nombre_alta`,`bj`.`nick` AS `nombre_baja` from ((`sitios` `s` join `acl_usuarios` `al`) join `acl_usuarios` `bj`) where `s`.`alta_por` = `al`.`cod_acl_usuario` and `s`.`borrado_por` = `bj`.`cod_acl_usuario`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_sitios_caracteristicas`
--
DROP TABLE IF EXISTS `vista_sitios_caracteristicas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sitios_caracteristicas`  AS   (select `sc`.`cod_sitio_caracteristica` AS `cod_sitio_caracteristica`,`s`.`cod_sitio` AS `cod_sitio`,`c`.`cod_caracteristica` AS `cod_caracteristica`,`s`.`nombre_sitio` AS `nombre_sitio`,`c`.`nombre_caract` AS `nombre_caract`,`c`.`descripcion_caract` AS `descripcion_caract`,`c`.`icono_caract` AS `icono_caract` from ((`sitios` `s` join `caracteristicas` `c`) join `sitios_caracteristicas` `sc`) where `s`.`cod_sitio` = `sc`.`cod_sitio` and `c`.`cod_caracteristica` = `sc`.`cod_caracteristica`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_sitios_categorias`
--
DROP TABLE IF EXISTS `vista_sitios_categorias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sitios_categorias`  AS   (select `sc`.`cod_sitio_categoria` AS `cod_sitio_categoria`,`s`.`cod_sitio` AS `cod_sitio`,`c`.`cod_categoria` AS `cod_categoria`,`s`.`nombre_sitio` AS `nombre_sitio`,`c`.`nombre_cat` AS `nombre_cat` from ((`sitios` `s` join `categorias` `c`) join `sitios_categorias` `sc`) where `s`.`cod_sitio` = `sc`.`cod_sitio` and `c`.`cod_categoria` = `sc`.`cod_categoria`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_sitios_comunidades`
--
DROP TABLE IF EXISTS `vista_sitios_comunidades`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sitios_comunidades`  AS   (select `sc`.`cod_sitio_comunidad` AS `cod_sitio_comunidad`,`s`.`cod_sitio` AS `cod_sitio`,`c`.`cod_comunidad` AS `cod_comunidad`,`s`.`nombre_sitio` AS `nombre_sitio`,`c`.`nombre_comu` AS `nombre_comu`,`c`.`descripcion_comu` AS `descripcion_comu`,`c`.`icono_comu` AS `icono_comu` from ((`sitios` `s` join `comunidades` `c`) join `sitios_comunidades` `sc`) where `s`.`cod_sitio` = `sc`.`cod_sitio` and `c`.`cod_comunidad` = `sc`.`cod_comunidad`)  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_sugerencias`
--
DROP TABLE IF EXISTS `vista_sugerencias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_sugerencias`  AS SELECT `s`.`cod_sugerencia` AS `cod_sugerencia`, `s`.`fecha` AS `fecha`, `s`.`nombre_sitio` AS `nombre_sitio`, `s`.`direccion` AS `direccion`, `s`.`poblacion` AS `poblacion`, `s`.`comentario` AS `comentario`, `s`.`foto` AS `foto`, `s`.`mail_contacto` AS `mail_contacto`, `s`.`leido` AS `leido`, `s`.`leido_fecha` AS `leido_fecha`, `s`.`leido_por` AS `leido_por`, `s`.`anulado` AS `anulado`, `s`.`anulado_fecha` AS `anulado_fecha`, `s`.`anulado_por` AS `anulado_por`, `ul`.`nick` AS `nick_lector`, `ua`.`nick` AS `nick_anulador` FROM ((`sugerencias` `s` join `acl_usuarios` `ul`) join `acl_usuarios` `ua`) WHERE `s`.`leido_por` = `ul`.`cod_acl_usuario` AND `s`.`anulado_por` = `ua`.`cod_acl_usuario` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  ADD PRIMARY KEY (`cod_acl_role`);

--
-- Indices de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD PRIMARY KEY (`cod_acl_usuario`),
  ADD KEY `fk_acl_usuarios1` (`cod_acl_role`),
  ADD KEY `fk_acl_usuarios2` (`borrado_por`);

--
-- Indices de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`cod_caracteristica`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cod_categoria`);

--
-- Indices de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  ADD PRIMARY KEY (`cod_comunidad`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`cod_reporte`),
  ADD KEY `fk_reportes1` (`cod_usuario`),
  ADD KEY `fk_reportes2` (`cod_sitio`),
  ADD KEY `fk_reportes3` (`leido_por`),
  ADD KEY `fk_reportes4` (`cod_resenia`);

--
-- Indices de la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD PRIMARY KEY (`cod_resenia`),
  ADD KEY `fk_resenias1` (`cod_usuario`),
  ADD KEY `fk_resenias2` (`cod_sitio`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`cod_respuesta`),
  ADD KEY `fk_respuestas1` (`cod_reporte`),
  ADD KEY `fk_respuestas2` (`respondido_por`);

--
-- Indices de la tabla `sitios`
--
ALTER TABLE `sitios`
  ADD PRIMARY KEY (`cod_sitio`),
  ADD KEY `fk_sitios1` (`alta_por`),
  ADD KEY `fk_sitios2` (`borrado_por`);

--
-- Indices de la tabla `sitios_caracteristicas`
--
ALTER TABLE `sitios_caracteristicas`
  ADD PRIMARY KEY (`cod_sitio_caracteristica`),
  ADD KEY `fk_sitios_caract1` (`cod_sitio`),
  ADD KEY `fk_sitios_caract2` (`cod_caracteristica`);

--
-- Indices de la tabla `sitios_categorias`
--
ALTER TABLE `sitios_categorias`
  ADD PRIMARY KEY (`cod_sitio_categoria`),
  ADD KEY `fk_sitios_cat1` (`cod_sitio`),
  ADD KEY `fk_sitios_cat2` (`cod_categoria`);

--
-- Indices de la tabla `sitios_comunidades`
--
ALTER TABLE `sitios_comunidades`
  ADD PRIMARY KEY (`cod_sitio_comunidad`),
  ADD KEY `fk_sitios_comun1` (`cod_sitio`),
  ADD KEY `fk_sitios_comun2` (`cod_comunidad`);

--
-- Indices de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD PRIMARY KEY (`cod_sugerencia`),
  ADD KEY `fk_sugerencias1` (`leido_por`),
  ADD KEY `fk_sugerencias2` (`anulado_por`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD UNIQUE KEY `un_usuarios1` (`mail`),
  ADD KEY `fk_usuarios1` (`borrado_por`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl_roles`
--
ALTER TABLE `acl_roles`
  MODIFY `cod_acl_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `cod_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cod_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `comunidades`
--
ALTER TABLE `comunidades`
  MODIFY `cod_comunidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `cod_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resenias`
--
ALTER TABLE `resenias`
  MODIFY `cod_resenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `cod_respuesta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sitios`
--
ALTER TABLE `sitios`
  MODIFY `cod_sitio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sitios_caracteristicas`
--
ALTER TABLE `sitios_caracteristicas`
  MODIFY `cod_sitio_caracteristica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sitios_categorias`
--
ALTER TABLE `sitios_categorias`
  MODIFY `cod_sitio_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sitios_comunidades`
--
ALTER TABLE `sitios_comunidades`
  MODIFY `cod_sitio_comunidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  MODIFY `cod_sugerencia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  ADD CONSTRAINT `fk_acl_usuarios1` FOREIGN KEY (`cod_acl_role`) REFERENCES `acl_roles` (`cod_acl_role`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_acl_usuarios2` FOREIGN KEY (`borrado_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD CONSTRAINT `fk_reportes1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reportes2` FOREIGN KEY (`cod_sitio`) REFERENCES `sitios` (`cod_sitio`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reportes3` FOREIGN KEY (`leido_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reportes4` FOREIGN KEY (`cod_resenia`) REFERENCES `resenias` (`cod_resenia`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `resenias`
--
ALTER TABLE `resenias`
  ADD CONSTRAINT `fk_resenias1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resenias2` FOREIGN KEY (`cod_sitio`) REFERENCES `sitios` (`cod_sitio`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `fk_respuestas1` FOREIGN KEY (`cod_reporte`) REFERENCES `reportes` (`cod_reporte`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respuestas2` FOREIGN KEY (`respondido_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `sitios`
--
ALTER TABLE `sitios`
  ADD CONSTRAINT `fk_sitios1` FOREIGN KEY (`alta_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sitios2` FOREIGN KEY (`borrado_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `sitios_caracteristicas`
--
ALTER TABLE `sitios_caracteristicas`
  ADD CONSTRAINT `fk_sitios_caract1` FOREIGN KEY (`cod_sitio`) REFERENCES `sitios` (`cod_sitio`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sitios_caract2` FOREIGN KEY (`cod_caracteristica`) REFERENCES `caracteristicas` (`cod_caracteristica`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `sitios_categorias`
--
ALTER TABLE `sitios_categorias`
  ADD CONSTRAINT `fk_sitios_cat1` FOREIGN KEY (`cod_sitio`) REFERENCES `sitios` (`cod_sitio`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sitios_cat2` FOREIGN KEY (`cod_categoria`) REFERENCES `categorias` (`cod_categoria`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `sitios_comunidades`
--
ALTER TABLE `sitios_comunidades`
  ADD CONSTRAINT `fk_sitios_comun1` FOREIGN KEY (`cod_sitio`) REFERENCES `sitios` (`cod_sitio`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sitios_comun2` FOREIGN KEY (`cod_comunidad`) REFERENCES `comunidades` (`cod_comunidad`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `sugerencias`
--
ALTER TABLE `sugerencias`
  ADD CONSTRAINT `fk_sugerencias1` FOREIGN KEY (`leido_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sugerencias2` FOREIGN KEY (`anulado_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios1` FOREIGN KEY (`borrado_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
