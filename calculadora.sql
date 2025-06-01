-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2025 a las 14:33:06
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
-- Base de datos: `calculadora`
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
(4, 'gestion usuarios', 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(5, 'redactor todos juegos', 0, 0, 0, 0, 1, 1, 1, 0, 0, 0),
(6, 'redactor calculadora', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(7, 'redactor juego2', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(8, 'redactor juego3', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_usuarios`
--

CREATE TABLE `acl_usuarios` (
  `cod_acl_usuario` int(11) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `cod_acl_role` int(11) NOT NULL DEFAULT 2,
  `borrado` tinyint(1) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `acl_usuarios`
--

INSERT INTO `acl_usuarios` (`cod_acl_usuario`, `nick`, `nombre`, `contrasenia`, `cod_acl_role`, `borrado`, `borrado_fecha`, `borrado_por`) VALUES
(0, '--', '--', '--', 2, 1, '2024-10-01 22:08:42', 1),
(1, 'CleoNavarro', 'Cleo Navarro Molina', 'f1575b49081d7abe41fd7f150f4a2d0a7c22a96b', 1, 0, NULL, 0),
(2, 'AdminAux', 'Administrador Auxiliar', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 3, 0, NULL, 0),
(3, 'UserGestor', 'Gestor de Usuarios', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 4, 0, NULL, 0),
(4, 'MainRedactor', 'Redactor Jefe', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 5, 0, NULL, 0),
(5, 'CalcRedactor', 'Redactor Calculadora Humana', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 6, 0, NULL, 0),
(6, 'Game2Redactor', 'Redactor Juego 2', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 7, 0, NULL, 0),
(7, 'Game3Redactor', 'Redactor Juego 3', 'a096961d20e19bb6363a54f97fd5e0b9d655e46e', 8, 0, NULL, 0),
(8, 'Madison-Madcat', 'Irene Muñoz Adán', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 2, 0, NULL, 0),
(9, 'Probando', 'Prueba Probandez Pruebo', 'f2190c5c68029d21f1aa7653d178b0ab2668decf', 2, 0, NULL, 0),
(10, 'Proban2', 'TESTTO Testeo', 'f1575b49081d7abe41fd7f150f4a2d0a7c22a96b', 2, 0, NULL, 0),
(11, 'Ivanovich', 'Ivan Pereira Dole', 'a15f8b81a160b4eebe5c84e9e3b65c87b9b2f18e', 2, 1, '2025-06-01 13:59:21', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `adivina`
--

CREATE TABLE `adivina` (
  `cod_adivina` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `cod_dificultad` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `puntuacion_base` int(11) NOT NULL DEFAULT 0,
  `creado_fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `creado_por` int(11) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `adivina`
--

INSERT INTO `adivina` (`cod_adivina`, `fecha`, `cod_dificultad`, `titulo`, `puntuacion_base`, `creado_fecha`, `creado_por`, `borrado_fecha`, `borrado_por`) VALUES
(1, '2025-05-29', 2, 'Prueba', 12600, '2025-05-29 20:24:01', 0, NULL, 0),
(2, '2025-05-31', 1, 'Sobre Ordenadores', 7600, '2025-05-29 20:24:01', 0, NULL, 0),
(6, '2025-06-03', 3, 'Un verdadero reto', 11600, '2025-05-31 22:16:37', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dificultad`
--

CREATE TABLE `dificultad` (
  `cod_dificultad` int(11) NOT NULL,
  `dificultad` varchar(60) NOT NULL,
  `bonificador` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `dificultad`
--

INSERT INTO `dificultad` (`cod_dificultad`, `dificultad`, `bonificador`) VALUES
(1, 'Fácil', 1.00),
(2, 'Normal', 1.50),
(3, 'Difícil', 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `palabras`
--

CREATE TABLE `palabras` (
  `cod_palabra` int(11) NOT NULL,
  `cod_adivina` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `siglas` varchar(3) NOT NULL,
  `enunciado` varchar(125) NOT NULL,
  `respuesta` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `palabras`
--

INSERT INTO `palabras` (`cod_palabra`, `cod_adivina`, `orden`, `siglas`, `enunciado`, `respuesta`) VALUES
(1, 1, 1, 'PÓL', 'Documento identificativo del contrato de seguros', 'PÓLIZA'),
(2, 1, 2, 'AFA', 'Agradable, dulce, suave en la conversación y el trato', 'AFABLE'),
(3, 1, 3, 'TUL', 'Pantalla de vidrio a modo de panal', 'TULIPA'),
(4, 1, 4, 'DIS', 'Inventar o idear algo', 'DISCURRIR'),
(5, 1, 5, 'HED', 'Olor desagradable y penetrante', 'HEDOR'),
(6, 1, 6, 'VAP', 'Dicho de una tela, como una gasa, muy fina y transparente', 'VAPOROSA'),
(7, 1, 7, 'ENG', 'Captar intensamente la atención de alguien', 'ENGANCHAR'),
(8, 2, 1, 'CON', 'Componente metálico destinado a transmitir electricidad', 'CONDUCTOR'),
(9, 2, 2, 'PLA', 'Plancha a la que se engarzan los distintos componentes de un ordenador', 'PLACA'),
(10, 2, 3, 'ESC', 'Pantalla en una computadora en la cual figuran los iconos que representan archivos y programas', 'ESCRITORIO'),
(11, 2, 4, 'VEN', 'Pieza rotatoria de un sistema de refrigeración de componentes', 'VENTILADOR'),
(12, 2, 5, 'TEC', 'Cada una de las piezas que, por la presión de los dedos, inserta instrucciones en un aparato', 'TECLA'),
(13, 2, 6, 'ALT', 'Aparato electroacústico que transforma la corriente eléctrica en sonido', 'ALTAVOZ'),
(14, 6, 1, 'HIL', 'Orden o formación en línea de un número de personas o cosas', 'HILERA'),
(15, 6, 2, 'ELÁ', 'Dícese de un cuerpo que puede recobrar su forma cuando cesa la acción que la alteraba', 'ELÁSTICO'),
(16, 6, 3, 'DEM', 'Retardar, diferir, dilatar', 'DEMORAR'),
(17, 6, 4, 'PRU', 'Ensayo que se hace de algo para saber cómo resultará en su forma definitiva', 'PRUEBA'),
(18, 6, 5, 'TOT', 'Resultado de una suma u otras operaciones', 'TOTAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `cod_pregunta` int(11) NOT NULL,
  `cod_test` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `cod_tipo` int(11) NOT NULL,
  `enunciado` varchar(255) NOT NULL,
  `operacion` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`cod_pregunta`, `cod_test`, `orden`, `cod_tipo`, `enunciado`, `operacion`, `cantidad`) VALUES
(1, 1, 1, 1, '¿Cuánto es 27 + 57?', 1, 84),
(2, 1, 2, 1, '¿Menos 38?', 2, 46),
(3, 1, 3, 1, '¿Por 3?', 3, 138),
(4, 1, 4, 1, '¿Entre 6?', 4, 23),
(5, 1, 5, 2, '¿Más la cantidad de Super Nenas que han existido?', 1, 27),
(6, 1, 6, 1, '¿Por 7?', 3, 189),
(7, 1, 7, 2, '¿Menos los años que duró la Guerra de los 100 años?', 2, 73),
(8, 5, 1, 2, '¿Cuál es el conocido como \"Número de Sheldon Cooper\"?', 1, 73),
(9, 5, 2, 2, 'Es un número primo, ¿en qué orden está entre los números primos?', 2, 21),
(10, 5, 3, 2, 'Vale, y ya que tenemos el 21, pon el número resultante al cambiar cada cifra de sitio.', 2, 12),
(11, 5, 4, 2, '¡Bien! ¿Podrías decirme cuál es el número primo número 12?', 1, 37),
(12, 5, 5, 2, 'Qué locura. Y para rematar, ¿podrías decirme cuál es el resultado de multiplicar las cifras de este número?', 2, 21),
(18, 20, 1, 2, '¿En qué año nació Federico García Lorca?', 1, 1898),
(19, 20, 2, 1, '¿Entre 26?', 1, 73),
(20, 20, 3, 1, '¿Más 34?', 1, 107),
(21, 20, 4, 2, '¿Menos el tercer decimal del número pi?', 1, 106),
(22, 20, 5, 1, '¿Entre 2?', 1, 53),
(23, 21, 1, 2, '¿A qué edad falleció el presidente de Nintendo Satoru Iwata?', 1, 55),
(24, 21, 2, 1, '¿Menos 3?', 1, 52),
(25, 21, 3, 1, '¿Por 6?', 1, 312),
(26, 21, 4, 2, '¿Menos la cantidad de Pokémon originales en Pokémon Rojo/Azul?', 1, 161),
(27, 21, 5, 1, '¿Entre 7?', 1, 23),
(28, 21, 6, 1, '¿Más 17?', 1, 40),
(29, 21, 7, 2, '¿Entre la cantidad de mundos en el primer Super Mario Bros?', 1, 5),
(30, 21, 8, 1, '¿Por 23?', 1, 115),
(31, 21, 9, 2, '¿Menos la cantidad de grandes templos que hay en Zelda Breath of the Wild?', 1, 111),
(32, 22, 1, 2, '¿Cuál es el valor del billete de euro más común en circulación?', 1, 50),
(33, 22, 2, 1, '¿Menos 12?', 1, 38),
(34, 22, 3, 1, '¿Por 5?', 1, 190),
(35, 22, 4, 2, '¿Menos las pesetas que valían un euro en 2002 (sin decimales)?', 1, 24),
(36, 22, 5, 1, '¿Entre 3?', 1, 8),
(37, 23, 1, 1, '25 más 17', 1, 42),
(38, 23, 2, 1, 'Por 3', 1, 126),
(39, 23, 3, 1, 'Menos 18', 1, 108),
(40, 23, 4, 1, 'Entre 4', 1, 27),
(41, 23, 5, 1, 'Más 48', 1, 75),
(42, 23, 6, 1, 'Entre 5', 1, 15),
(43, 23, 7, 1, 'Por 6', 1, 90),
(50, 24, 1, 1, 'qqqq', 1, 2),
(51, 24, 2, 1, 'qqq', 1, 2),
(52, 24, 3, 1, 'qqq', 1, 2),
(53, 24, 4, 1, 'qqqq', 1, 2),
(54, 24, 5, 1, 'qqqq', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacion_adivina`
--

CREATE TABLE `puntuacion_adivina` (
  `cod_punt_adivina` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_adivina` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `fecha_realizado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `puntuacion_adivina`
--

INSERT INTO `puntuacion_adivina` (`cod_punt_adivina`, `cod_usuario`, `cod_adivina`, `puntos`, `fecha_realizado`) VALUES
(1, 1, 1, 11868, '2025-05-29 21:08:48'),
(3, 4, 2, 6928, '2025-05-31 17:57:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacion_test`
--

CREATE TABLE `puntuacion_test` (
  `cod_punt_test` int(11) NOT NULL,
  `cod_usuario` int(11) NOT NULL,
  `cod_test` int(11) NOT NULL,
  `puntos` int(11) NOT NULL,
  `fecha_realizado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `puntuacion_test`
--

INSERT INTO `puntuacion_test` (`cod_punt_test`, `cod_usuario`, `cod_test`, `puntos`, `fecha_realizado`) VALUES
(1, 4, 5, 7076, '2025-05-10 11:08:50'),
(2, 1, 1, 11600, '2025-05-09 17:27:41'),
(3, 7, 1, 9980, '2025-05-09 17:28:04'),
(4, 4, 1, 11714, '2025-05-10 11:43:34'),
(5, 1, 5, 7436, '2025-05-10 11:53:44'),
(6, 1, 20, 8480, '2025-05-11 20:09:57'),
(7, 9, 21, 21040, '2025-05-27 20:35:15'),
(8, 1, 21, 18126, '2025-05-27 20:57:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test`
--

CREATE TABLE `test` (
  `cod_test` int(11) NOT NULL,
  `fecha` date NOT NULL DEFAULT current_timestamp(),
  `cod_dificultad` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `puntuacion_base` int(11) NOT NULL,
  `creado_fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `creado_por` int(11) NOT NULL DEFAULT 0,
  `borrado_fecha` datetime DEFAULT NULL,
  `borrado_por` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `test`
--

INSERT INTO `test` (`cod_test`, `fecha`, `cod_dificultad`, `titulo`, `puntuacion_base`, `creado_fecha`, `creado_por`, `borrado_fecha`, `borrado_por`) VALUES
(1, '2025-05-18', 2, 'Prueba', 12000, '2025-03-31 00:00:00', 0, NULL, 0),
(5, '2025-05-22', 1, 'Números Increíbles', 7500, '2025-03-31 00:00:00', 0, NULL, 0),
(20, '2025-05-30', 2, 'Probando hacer test', 9000, '2025-04-20 20:41:12', 1, NULL, 0),
(21, '2025-05-27', 3, 'Nintendo', 22000, '2025-04-26 20:02:38', 1, NULL, 0),
(22, '2025-05-31', 1, 'Va de dinero', 6000, '2025-05-15 20:30:32', 1, NULL, 0),
(23, '2025-05-21', 2, 'Una simple', 10500, '2025-05-21 21:46:29', 1, NULL, 0),
(24, '2025-06-27', 1, 'Prueba de actualización', 5000, '2025-06-01 11:46:22', 1, '2025-06-01 12:44:10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `cod_tipo` int(11) NOT NULL,
  `tipo` varchar(60) NOT NULL,
  `puntuacion_base` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipos`
--

INSERT INTO `tipos` (`cod_tipo`, `tipo`, `puntuacion_base`) VALUES
(1, 'Operación', 1000),
(2, 'Pregunta', 1500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `nick` varchar(100) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `telefono` varchar(15) NOT NULL,
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

INSERT INTO `usuarios` (`cod_usuario`, `nombre`, `nick`, `mail`, `telefono`, `foto`, `fecha_registrado`, `verificado`, `borrado`, `borrado_fecha`, `borrado_por`) VALUES
(0, '--', '--', '--', '--', '--', '2024-10-20 22:17:08', '2024-10-20 22:17:08', 1, '2024-10-21 22:17:08', 1),
(1, 'Cleo Navarro Molina', 'CleoNavarro', 'latitacleo@gmail.com', '656928992', 'fotoUsuario1.jpg', '2024-05-22 20:11:33', '2024-10-18 12:47:33', 0, NULL, 0),
(2, 'Administrador Auxiliar', 'AdminAux', 'adminaux@sfpl.com', '612345678', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-19 12:47:33', 0, NULL, 0),
(3, 'Gestor de Usuarios', 'UserGestor', 'places@sfpl.com', '654987321', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(4, 'Redactor Jefe', 'MainRedactor', 'sugestions@sfpl.com', '612378945', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(5, 'Redactor Calculadora Humana', 'CalcRedactor', 'reports@sfpl.com', '693582471', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(6, 'Redactor Juego 2', 'Game2Redactor', 'reviews@sfpl.com', '645987312', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(7, 'Redactor Juego 3', 'Game3Redactor', 'user@test.com', '656656656', 'fotoUsuarioPorDefecto.png', '2024-05-26 14:01:41', '2024-10-18 12:47:33', 0, NULL, 0),
(8, 'Irene Muñoz Adán', 'Madison-Madcat', 'madison-madcat@gmail.com', '--', 'fotoUsuarioPorDefecto.png', '2024-11-27 23:23:41', '2024-11-27 23:21:15', 0, NULL, 0),
(9, 'Prueba Probandez Pruebo', 'Probando', 'probanding@gmail.com', '654321987', 'fotoUsuarioPorDefecto.png', '2025-05-15 19:30:48', NULL, 0, NULL, 0),
(10, 'TESTTO Testeo', 'Proban2', 'testeo@test.test', '987654321', 'fotoUsuarioPorDefecto.png', '2025-05-15 19:35:19', NULL, 0, NULL, 0),
(11, 'Ivan Pereira Dole', 'Ivanovich', 'ivan@juegosdepensar.com', '565456545', 'IMG-20160716-WA0002.jpg', '2025-05-20 20:15:36', NULL, 1, '2025-06-01 13:59:21', 2);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_adivina`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_adivina` (
`cod_adivina` int(11)
,`fecha` date
,`cod_dificultad` int(11)
,`titulo` varchar(255)
,`dificultad` varchar(60)
,`num_palabras` bigint(21)
,`puntuacion_base` int(11)
,`creado_fecha` datetime
,`creado_por` int(11)
,`autor` varchar(100)
,`borrado_fecha` datetime
,`borrado_por` int(11)
,`borrador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_estadisticas_adivina`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_estadisticas_adivina` (
`cod_usuario` int(11)
,`nick` varchar(100)
,`total` bigint(21)
,`facil` bigint(21)
,`normal` bigint(21)
,`dificil` bigint(21)
,`puntuacion_total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_estadísticas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_estadísticas` (
`cod_usuario` int(11)
,`nick` varchar(100)
,`total` bigint(21)
,`facil` bigint(21)
,`normal` bigint(21)
,`dificil` bigint(21)
,`puntuacion_total` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_palabras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_palabras` (
`cod_palabra` int(11)
,`cod_adivina` int(11)
,`orden` int(11)
,`siglas` varchar(3)
,`enunciado` varchar(125)
,`respuesta` varchar(15)
,`fecha` date
,`puntuacion_base` bigint(14)
,`cod_dificultad` int(11)
,`dificultad` varchar(60)
,`bonificador` decimal(4,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_pregunta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_pregunta` (
`cod_pregunta` int(11)
,`cod_test` int(11)
,`orden` int(11)
,`cod_tipo` int(11)
,`enunciado` varchar(255)
,`operacion` int(11)
,`cantidad` int(11)
,`fecha` date
,`des_operacion` varchar(14)
,`tipo` varchar(60)
,`puntuacion_base` int(11)
,`cod_dificultad` int(11)
,`dificultad` varchar(60)
,`bonificador` decimal(4,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_puntuacion_adivina`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_puntuacion_adivina` (
`cod_punt_adivina` int(11)
,`cod_usuario` int(11)
,`cod_adivina` int(11)
,`puntos` int(11)
,`fecha_realizado` datetime
,`nombre` varchar(255)
,`nick` varchar(100)
,`foto` varchar(255)
,`fecha` date
,`titulo` varchar(255)
,`cod_dificultad` int(11)
,`dificultad` varchar(60)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_puntuacion_test`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_puntuacion_test` (
`cod_punt_test` int(11)
,`cod_usuario` int(11)
,`cod_test` int(11)
,`puntos` int(11)
,`fecha_realizado` datetime
,`nombre` varchar(255)
,`nick` varchar(100)
,`foto` varchar(255)
,`fecha` date
,`titulo` varchar(255)
,`cod_dificultad` int(11)
,`dificultad` varchar(60)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_test`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_test` (
`cod_test` int(11)
,`fecha` date
,`cod_dificultad` int(11)
,`titulo` varchar(255)
,`dificultad` varchar(60)
,`num_preguntas` bigint(21)
,`puntuacion_base` int(11)
,`creado_fecha` datetime
,`creado_por` int(11)
,`autor` varchar(100)
,`borrado_fecha` datetime
,`borrado_por` int(11)
,`borrador` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios` (
`cod_usuario` int(11)
,`nombre` varchar(255)
,`nick` varchar(100)
,`mail` varchar(255)
,`telefono` varchar(15)
,`foto` varchar(255)
,`fecha_registrado` datetime
,`verificado` datetime
,`borrado` tinyint(1)
,`borrado_fecha` datetime
,`borrado_por` int(11)
,`cod_usuario_borrador` int(11)
,`nick_borrador` varchar(100)
,`cod_acl_role` int(11)
,`nombre_rol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_adivina`
--
DROP TABLE IF EXISTS `vista_adivina`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_adivina`  AS SELECT `a`.`cod_adivina` AS `cod_adivina`, `a`.`fecha` AS `fecha`, `a`.`cod_dificultad` AS `cod_dificultad`, `a`.`titulo` AS `titulo`, `d`.`dificultad` AS `dificultad`, (select coalesce(count(`a`.`cod_adivina`),0) from `palabras` `p` where `p`.`cod_adivina` = `a`.`cod_adivina`) AS `num_palabras`, `a`.`puntuacion_base` AS `puntuacion_base`, `a`.`creado_fecha` AS `creado_fecha`, `a`.`creado_por` AS `creado_por`, `uc`.`nick` AS `autor`, `a`.`borrado_fecha` AS `borrado_fecha`, `a`.`borrado_por` AS `borrado_por`, `ub`.`nick` AS `borrador` FROM (((`adivina` `a` join `dificultad` `d` on(`a`.`cod_dificultad` = `d`.`cod_dificultad`)) join `usuarios` `uc` on(`a`.`creado_por` = `uc`.`cod_usuario`)) join `usuarios` `ub` on(`a`.`borrado_por` = `ub`.`cod_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_estadisticas_adivina`
--
DROP TABLE IF EXISTS `vista_estadisticas_adivina`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_estadisticas_adivina`  AS WITH a AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_adivina`.`cod_punt_adivina`),0) AS `total` FROM (`usuarios` left join `puntuacion_adivina` on(`puntuacion_adivina`.`cod_usuario` = `usuarios`.`cod_usuario`)) GROUP BY `usuarios`.`cod_usuario`), f AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_adivina`.`cod_punt_adivina`),0) AS `facil` FROM ((`usuarios` left join `puntuacion_adivina` on(`puntuacion_adivina`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `adivina` on(`puntuacion_adivina`.`cod_adivina` = `adivina`.`cod_adivina`)) WHERE `adivina`.`cod_dificultad` = 1 GROUP BY `usuarios`.`cod_usuario`), n AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_adivina`.`cod_punt_adivina`),0) AS `normal` FROM ((`usuarios` left join `puntuacion_adivina` on(`puntuacion_adivina`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `adivina` on(`puntuacion_adivina`.`cod_adivina` = `adivina`.`cod_adivina`)) WHERE `adivina`.`cod_dificultad` = 2 GROUP BY `usuarios`.`cod_usuario`), d AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_adivina`.`cod_punt_adivina`),0) AS `dificil` FROM ((`usuarios` left join `puntuacion_adivina` on(`puntuacion_adivina`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `adivina` on(`puntuacion_adivina`.`cod_adivina` = `adivina`.`cod_adivina`)) WHERE `adivina`.`cod_dificultad` = 3 GROUP BY `usuarios`.`cod_usuario`), pt AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(sum(`puntuacion_adivina`.`puntos`),0) AS `puntuacion_total` FROM (`usuarios` left join `puntuacion_adivina` on(`puntuacion_adivina`.`cod_usuario` = `usuarios`.`cod_usuario`)) GROUP BY `usuarios`.`cod_usuario`)  SELECT `u`.`cod_usuario` AS `cod_usuario`, `u`.`nick` AS `nick`, `a`.`total` AS `total`, coalesce(`f`.`facil`,0) AS `facil`, coalesce(`n`.`normal`,0) AS `normal`, coalesce(`d`.`dificil`,0) AS `dificil`, `pt`.`puntuacion_total` AS `puntuacion_total` FROM (((((`usuarios` `u` left join `a` on(`a`.`cod_usuario` = `u`.`cod_usuario`)) left join `f` on(`f`.`cod_usuario` = `u`.`cod_usuario`)) left join `n` on(`n`.`cod_usuario` = `u`.`cod_usuario`)) left join `d` on(`d`.`cod_usuario` = `u`.`cod_usuario`)) left join `pt` on(`pt`.`cod_usuario` = `u`.`cod_usuario`)))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_estadísticas`
--
DROP TABLE IF EXISTS `vista_estadísticas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_estadísticas`  AS WITH t AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_test`.`cod_punt_test`),0) AS `total` FROM (`usuarios` left join `puntuacion_test` on(`puntuacion_test`.`cod_usuario` = `usuarios`.`cod_usuario`)) GROUP BY `usuarios`.`cod_usuario`), f AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_test`.`cod_punt_test`),0) AS `facil` FROM ((`usuarios` left join `puntuacion_test` on(`puntuacion_test`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `test` on(`puntuacion_test`.`cod_test` = `test`.`cod_test`)) WHERE `test`.`cod_dificultad` = 1 GROUP BY `usuarios`.`cod_usuario`), n AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_test`.`cod_punt_test`),0) AS `normal` FROM ((`usuarios` left join `puntuacion_test` on(`puntuacion_test`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `test` on(`puntuacion_test`.`cod_test` = `test`.`cod_test`)) WHERE `test`.`cod_dificultad` = 2 GROUP BY `usuarios`.`cod_usuario`), d AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(count(`puntuacion_test`.`cod_punt_test`),0) AS `dificil` FROM ((`usuarios` left join `puntuacion_test` on(`puntuacion_test`.`cod_usuario` = `usuarios`.`cod_usuario`)) join `test` on(`puntuacion_test`.`cod_test` = `test`.`cod_test`)) WHERE `test`.`cod_dificultad` = 3 GROUP BY `usuarios`.`cod_usuario`), pt AS (SELECT `usuarios`.`cod_usuario` AS `cod_usuario`, coalesce(sum(`puntuacion_test`.`puntos`),0) AS `puntuacion_total` FROM (`usuarios` left join `puntuacion_test` on(`puntuacion_test`.`cod_usuario` = `usuarios`.`cod_usuario`)) GROUP BY `usuarios`.`cod_usuario`)  SELECT `u`.`cod_usuario` AS `cod_usuario`, `u`.`nick` AS `nick`, `t`.`total` AS `total`, coalesce(`f`.`facil`,0) AS `facil`, coalesce(`n`.`normal`,0) AS `normal`, coalesce(`d`.`dificil`,0) AS `dificil`, `pt`.`puntuacion_total` AS `puntuacion_total` FROM (((((`usuarios` `u` left join `t` on(`t`.`cod_usuario` = `u`.`cod_usuario`)) left join `f` on(`f`.`cod_usuario` = `u`.`cod_usuario`)) left join `n` on(`n`.`cod_usuario` = `u`.`cod_usuario`)) left join `d` on(`d`.`cod_usuario` = `u`.`cod_usuario`)) left join `pt` on(`pt`.`cod_usuario` = `u`.`cod_usuario`)))  ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_palabras`
--
DROP TABLE IF EXISTS `vista_palabras`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_palabras`  AS SELECT `p`.`cod_palabra` AS `cod_palabra`, `p`.`cod_adivina` AS `cod_adivina`, `p`.`orden` AS `orden`, `p`.`siglas` AS `siglas`, `p`.`enunciado` AS `enunciado`, `p`.`respuesta` AS `respuesta`, `a`.`fecha` AS `fecha`, 500 + octet_length(`p`.`respuesta`) * 100 AS `puntuacion_base`, `d`.`cod_dificultad` AS `cod_dificultad`, `d`.`dificultad` AS `dificultad`, `d`.`bonificador` AS `bonificador` FROM ((`palabras` `p` join `adivina` `a`) join `dificultad` `d`) WHERE `p`.`cod_adivina` = `a`.`cod_adivina` AND `a`.`cod_dificultad` = `d`.`cod_dificultad` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_pregunta`
--
DROP TABLE IF EXISTS `vista_pregunta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_pregunta`  AS SELECT `p`.`cod_pregunta` AS `cod_pregunta`, `p`.`cod_test` AS `cod_test`, `p`.`orden` AS `orden`, `p`.`cod_tipo` AS `cod_tipo`, `p`.`enunciado` AS `enunciado`, `p`.`operacion` AS `operacion`, `p`.`cantidad` AS `cantidad`, `ts`.`fecha` AS `fecha`, CASE `p`.`operacion` WHEN 1 THEN 'Suma' WHEN 2 THEN 'Resta' WHEN 3 THEN 'Multiplicación' WHEN 4 THEN 'División' ELSE 'Otro' END AS `des_operacion`, `tp`.`tipo` AS `tipo`, `tp`.`puntuacion_base` AS `puntuacion_base`, `d`.`cod_dificultad` AS `cod_dificultad`, `d`.`dificultad` AS `dificultad`, `d`.`bonificador` AS `bonificador` FROM (((`pregunta` `p` join `test` `ts`) join `tipos` `tp`) join `dificultad` `d`) WHERE `p`.`cod_test` = `ts`.`cod_test` AND `p`.`cod_tipo` = `tp`.`cod_tipo` AND `ts`.`cod_dificultad` = `d`.`cod_dificultad` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_puntuacion_adivina`
--
DROP TABLE IF EXISTS `vista_puntuacion_adivina`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_puntuacion_adivina`  AS SELECT `pa`.`cod_punt_adivina` AS `cod_punt_adivina`, `pa`.`cod_usuario` AS `cod_usuario`, `pa`.`cod_adivina` AS `cod_adivina`, `pa`.`puntos` AS `puntos`, `pa`.`fecha_realizado` AS `fecha_realizado`, `u`.`nombre` AS `nombre`, `u`.`nick` AS `nick`, `u`.`foto` AS `foto`, `a`.`fecha` AS `fecha`, `a`.`titulo` AS `titulo`, `a`.`cod_dificultad` AS `cod_dificultad`, `d`.`dificultad` AS `dificultad` FROM (((`puntuacion_adivina` `pa` join `usuarios` `u`) join `adivina` `a`) join `dificultad` `d`) WHERE `pa`.`cod_usuario` = `u`.`cod_usuario` AND `pa`.`cod_adivina` = `a`.`cod_adivina` AND `a`.`cod_dificultad` = `d`.`cod_dificultad` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_puntuacion_test`
--
DROP TABLE IF EXISTS `vista_puntuacion_test`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_puntuacion_test`  AS SELECT `pt`.`cod_punt_test` AS `cod_punt_test`, `pt`.`cod_usuario` AS `cod_usuario`, `pt`.`cod_test` AS `cod_test`, `pt`.`puntos` AS `puntos`, `pt`.`fecha_realizado` AS `fecha_realizado`, `u`.`nombre` AS `nombre`, `u`.`nick` AS `nick`, `u`.`foto` AS `foto`, `t`.`fecha` AS `fecha`, `t`.`titulo` AS `titulo`, `t`.`cod_dificultad` AS `cod_dificultad`, `d`.`dificultad` AS `dificultad` FROM (((`puntuacion_test` `pt` join `usuarios` `u`) join `test` `t`) join `dificultad` `d`) WHERE `pt`.`cod_usuario` = `u`.`cod_usuario` AND `pt`.`cod_test` = `t`.`cod_test` AND `t`.`cod_dificultad` = `d`.`cod_dificultad` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_test`
--
DROP TABLE IF EXISTS `vista_test`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_test`  AS SELECT `t`.`cod_test` AS `cod_test`, `t`.`fecha` AS `fecha`, `t`.`cod_dificultad` AS `cod_dificultad`, `t`.`titulo` AS `titulo`, `d`.`dificultad` AS `dificultad`, (select coalesce(count(`p`.`cod_test`),0) from `pregunta` `p` where `p`.`cod_test` = `t`.`cod_test`) AS `num_preguntas`, `t`.`puntuacion_base` AS `puntuacion_base`, `t`.`creado_fecha` AS `creado_fecha`, `t`.`creado_por` AS `creado_por`, `uc`.`nick` AS `autor`, `t`.`borrado_fecha` AS `borrado_fecha`, `t`.`borrado_por` AS `borrado_por`, `ub`.`nick` AS `borrador` FROM (((`test` `t` join `dificultad` `d` on(`t`.`cod_dificultad` = `d`.`cod_dificultad`)) join `usuarios` `uc` on(`t`.`creado_por` = `uc`.`cod_usuario`)) join `usuarios` `ub` on(`t`.`borrado_por` = `ub`.`cod_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios`
--
DROP TABLE IF EXISTS `vista_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios`  AS SELECT `u`.`cod_usuario` AS `cod_usuario`, `u`.`nombre` AS `nombre`, `u`.`nick` AS `nick`, `u`.`mail` AS `mail`, `u`.`telefono` AS `telefono`, `u`.`foto` AS `foto`, `u`.`fecha_registrado` AS `fecha_registrado`, `u`.`verificado` AS `verificado`, `u`.`borrado` AS `borrado`, `u`.`borrado_fecha` AS `borrado_fecha`, `u`.`borrado_por` AS `borrado_por`, `ub`.`cod_usuario` AS `cod_usuario_borrador`, `ub`.`nick` AS `nick_borrador`, `au`.`cod_acl_role` AS `cod_acl_role`, `r`.`nombre` AS `nombre_rol` FROM (((`usuarios` `u` join `acl_usuarios` `au`) join `acl_roles` `r`) join `usuarios` `ub`) WHERE `u`.`cod_usuario` = `au`.`cod_acl_usuario` AND `au`.`cod_acl_role` = `r`.`cod_acl_role` AND `u`.`borrado_por` = `ub`.`cod_usuario` ;

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
-- Indices de la tabla `adivina`
--
ALTER TABLE `adivina`
  ADD PRIMARY KEY (`cod_adivina`),
  ADD KEY `fk_test_1` (`cod_dificultad`);

--
-- Indices de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  ADD PRIMARY KEY (`cod_dificultad`);

--
-- Indices de la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`cod_palabra`),
  ADD KEY `fk_palabras1` (`cod_adivina`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`cod_pregunta`),
  ADD KEY `fk_preguntas_1` (`cod_test`),
  ADD KEY `fk_preguntas_2` (`cod_tipo`);

--
-- Indices de la tabla `puntuacion_adivina`
--
ALTER TABLE `puntuacion_adivina`
  ADD PRIMARY KEY (`cod_punt_adivina`),
  ADD KEY `fk_punt_adivina1` (`cod_usuario`),
  ADD KEY `fk_punt_adivina2` (`cod_adivina`);

--
-- Indices de la tabla `puntuacion_test`
--
ALTER TABLE `puntuacion_test`
  ADD PRIMARY KEY (`cod_punt_test`),
  ADD KEY `fk_punt_test1` (`cod_usuario`),
  ADD KEY `fk_punt_test2` (`cod_test`);

--
-- Indices de la tabla `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`cod_test`),
  ADD KEY `fk_test_1` (`cod_dificultad`);

--
-- Indices de la tabla `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`cod_tipo`);

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
  MODIFY `cod_acl_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `acl_usuarios`
--
ALTER TABLE `acl_usuarios`
  MODIFY `cod_acl_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `adivina`
--
ALTER TABLE `adivina`
  MODIFY `cod_adivina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  MODIFY `cod_dificultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `palabras`
--
ALTER TABLE `palabras`
  MODIFY `cod_palabra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `cod_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `puntuacion_adivina`
--
ALTER TABLE `puntuacion_adivina`
  MODIFY `cod_punt_adivina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `puntuacion_test`
--
ALTER TABLE `puntuacion_test`
  MODIFY `cod_punt_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `test`
--
ALTER TABLE `test`
  MODIFY `cod_test` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tipos`
--
ALTER TABLE `tipos`
  MODIFY `cod_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- Filtros para la tabla `adivina`
--
ALTER TABLE `adivina`
  ADD CONSTRAINT `fk_adivina_1` FOREIGN KEY (`cod_dificultad`) REFERENCES `dificultad` (`cod_dificultad`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `palabras`
--
ALTER TABLE `palabras`
  ADD CONSTRAINT `fk_palabras1` FOREIGN KEY (`cod_adivina`) REFERENCES `adivina` (`cod_adivina`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_preguntas_1` FOREIGN KEY (`cod_test`) REFERENCES `test` (`cod_test`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_preguntas_2` FOREIGN KEY (`cod_tipo`) REFERENCES `tipos` (`cod_tipo`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuacion_adivina`
--
ALTER TABLE `puntuacion_adivina`
  ADD CONSTRAINT `fk_punt_adivina1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_punt_adivina2` FOREIGN KEY (`cod_adivina`) REFERENCES `adivina` (`cod_adivina`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuacion_test`
--
ALTER TABLE `puntuacion_test`
  ADD CONSTRAINT `fk_punt_test1` FOREIGN KEY (`cod_usuario`) REFERENCES `usuarios` (`cod_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_punt_test2` FOREIGN KEY (`cod_test`) REFERENCES `test` (`cod_test`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `fk_test_1` FOREIGN KEY (`cod_dificultad`) REFERENCES `dificultad` (`cod_dificultad`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios1` FOREIGN KEY (`borrado_por`) REFERENCES `acl_usuarios` (`cod_acl_usuario`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
