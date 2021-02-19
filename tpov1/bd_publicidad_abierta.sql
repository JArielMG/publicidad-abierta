SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_ejemplo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `usuario_bitacora` text NOT NULL,
  `seccion_bitacora` text NOT NULL,
  `accion_bitacora` text NOT NULL,
  `fecha_bitacora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `usuario_bitacora`, `seccion_bitacora`, `accion_bitacora`, `fecha_bitacora`) VALUES
(0, '1', 'Login', 'Salida del sistema', '2020-06-02 19:45:43'),
(0, '1', 'Login', 'Salida del sistema', '2020-06-02 20:34:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_ambito_geo`
--

CREATE TABLE `cat_campana_ambito_geo` (
  `id_campana_ambito_geo` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_ambito_geo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_ambito_geo`
--

INSERT INTO `cat_campana_ambito_geo` (`id_campana_ambito_geo`, `nombre_campana_ambito_geo`, `active`) VALUES
(1, 'Nacional', 1),
(2, 'Estatal', 1),
(3, 'Municipal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_coberturas`
--

CREATE TABLE `cat_campana_coberturas` (
  `id_campana_cobertura` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_cobertura` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_coberturas`
--

INSERT INTO `cat_campana_coberturas` (`id_campana_cobertura`, `nombre_campana_cobertura`, `active`) VALUES
(1, 'Municipal', 1),
(2, 'Estatal', 1),
(3, 'Nacional', 1),
(4, 'Internacional', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_estatus`
--

CREATE TABLE `cat_campana_estatus` (
  `id_campana_estatus` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_estatus` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_estatus`
--

INSERT INTO `cat_campana_estatus` (`id_campana_estatus`, `nombre_campana_estatus`, `active`) VALUES
(1, 'En proceso', 1),
(2, 'Concluida', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_objetivos`
--

CREATE TABLE `cat_campana_objetivos` (
  `id_campana_objetivo` bigint(20) UNSIGNED NOT NULL,
  `campana_objetivo` text NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_objetivos`
--

INSERT INTO `cat_campana_objetivos` (`id_campana_objetivo`, `campana_objetivo`, `active`) VALUES
(1, 'Garantizar el óptimo cumplimiento de los derechos de acceso a la información pública y la protección de datos personales', 1),
(2, 'Promover el pleno ejercicio de los derechos de acceso a la información pública y de protección de datos personales', 1),
(3, 'Coordinar el Sistema Nacional de Transparencia y de Protección de Datos Personales, para que los órganos garantes establezcan, apliquen y evalúen acciones de acceso a la información pública y de protección y debido tratamiento de datos personales', 1),
(4, 'Impulsar el desempeño organizacional y promover un modelo institucional de servicio público orientado a resultados con un enfoque de derechos humanos y perspectiva de género', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_subtipos`
--

CREATE TABLE `cat_campana_subtipos` (
  `id_campana_subtipo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_tipo` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_subtipo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_subtipos`
--

INSERT INTO `cat_campana_subtipos` (`id_campana_subtipo`, `id_campana_tipo`, `nombre_campana_subtipo`, `active`) VALUES
(1, 1, 'Avisos', 1),
(2, 1, 'Precisiones', 1),
(3, 1, 'Convocatorias', 1),
(4, 1, 'Edictos', 1),
(5, 1, 'Bases', 1),
(6, 1, 'Licitaciones', 1),
(7, 1, 'Padrones de beneficiarios', 1),
(8, 1, 'Concursos', 1),
(9, 1, 'Aclaraciones', 1),
(10, 1, 'Otros', 1),
(11, 2, 'Campaña de comunicación social', 1),
(12, 2, 'Campaña de promoción y publicidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_temas`
--

CREATE TABLE `cat_campana_temas` (
  `id_campana_tema` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_tema` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_temas`
--

INSERT INTO `cat_campana_temas` (`id_campana_tema`, `nombre_campana_tema`, `active`) VALUES
(1, 'Salud', 1),
(2, 'Educación', 1),
(3, 'Deportes', 1),
(4, 'Turismo', 1),
(5, 'Economía y negocios', 1),
(6, 'Agricultura, ganadería, desarrollo rural, pesca y alimentación', 1),
(7, 'Trabajo y Previsión Social', 1),
(8, 'Relaciones Exteriores', 1),
(9, 'Energía e Hidrocarburos', 1),
(10, 'Desarrollo Político, Leyes Constitucionales', 1),
(11, 'Marina', 1),
(12, 'Finanzas públicas', 1),
(13, 'Seguridad nacional', 1),
(14, 'Cultura y artes', 1),
(15, 'Entretenimiento y actividades recreativas', 1),
(16, 'Ciencia y tecnología', 1),
(17, 'Obras públicas', 1),
(18, 'Protección civil, emergencias y desastres naturales', 1),
(19, 'Vialidad y transporte', 1),
(20, 'Seguridad pública y justicia', 1),
(21, 'Informes de gobierno', 1),
(22, 'Civismo y legalidad', 1),
(23, 'Desarrollo social y humano', 1),
(24, 'Trámites y servicios', 1),
(25, 'Derechos humanos', 1),
(26, 'Derechos de los niños', 1),
(27, 'Equidad de género', 1),
(28, 'Pueblos indígenas', 1),
(29, 'Ecología y medio ambiente', 1),
(30, 'Acceso a la información, transparencia y rendición de cuentas', 1),
(31, 'Protección de datos personales', 1),
(32, 'Participación ciudadana', 1),
(33, 'Felicitaciones, esquelas y condolencias', 1),
(34, 'Otro', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_tipos`
--

CREATE TABLE `cat_campana_tipos` (
  `id_campana_tipo` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_tipo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_tipos`
--

INSERT INTO `cat_campana_tipos` (`id_campana_tipo`, `nombre_campana_tipo`, `active`) VALUES
(1, 'Avisos Institucionales', 1),
(2, 'Campaña', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_campana_tiposTO`
--

CREATE TABLE `cat_campana_tiposTO` (
  `id_campana_tipoTO` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_tipoTO` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_campana_tiposTO`
--

INSERT INTO `cat_campana_tiposTO` (`id_campana_tipoTO`, `nombre_campana_tipoTO`, `active`) VALUES
(1, 'Tiempo de estado', 1),
(2, 'Tiempo fiscal', 1),
(3, 'Tiempo oficial', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_ejercicios`
--

CREATE TABLE `cat_ejercicios` (
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `ejercicio` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_ejercicios`
--

INSERT INTO `cat_ejercicios` (`id_ejercicio`, `ejercicio`, `active`) VALUES
(1, '2020', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_meses`
--

CREATE TABLE `cat_meses` (
  `id_mes` bigint(20) UNSIGNED NOT NULL,
  `mes` varchar(50) NOT NULL,
  `mes_corto` varchar(50) NOT NULL,
  `mes_orden` bigint(20) UNSIGNED NOT NULL,
  `active` smallint(5) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_meses`
--

INSERT INTO `cat_meses` (`id_mes`, `mes`, `mes_corto`, `mes_orden`, `active`) VALUES
(1, 'Enero', 'ENE', 1, 1),
(2, 'Febrero', 'FEB', 2, 1),
(3, 'Marzo', 'MAR', 3, 1),
(4, 'Abril', 'ABR', 4, 1),
(5, 'Mayo', 'MAY', 5, 1),
(6, 'Junio', 'JUN', 6, 1),
(7, 'Julio', 'JUL', 7, 1),
(8, 'Agosto', 'AGO', 8, 1),
(9, 'Septiembre', 'SEP', 9, 1),
(10, 'Octubre', 'OCT', 10, 1),
(11, 'Noviembre', 'NOV', 11, 1),
(12, 'Diciembre', 'DIC', 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_personalidad_juridica`
--

CREATE TABLE `cat_personalidad_juridica` (
  `id_personalidad_juridica` bigint(20) UNSIGNED NOT NULL,
  `nombre_personalidad_juridica` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_personalidad_juridica`
--

INSERT INTO `cat_personalidad_juridica` (`id_personalidad_juridica`, `nombre_personalidad_juridica`, `active`) VALUES
(1, 'Persona física', 1),
(2, 'Persona moral', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_poblacion_grupo_edad`
--

CREATE TABLE `cat_poblacion_grupo_edad` (
  `id_poblacion_grupo_edad` bigint(20) UNSIGNED NOT NULL,
  `nombre_poblacion_grupo_edad` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_poblacion_grupo_edad`
--

INSERT INTO `cat_poblacion_grupo_edad` (`id_poblacion_grupo_edad`, `nombre_poblacion_grupo_edad`, `active`) VALUES
(1, '18-35', 1),
(2, '36-60', 1),
(3, '60 en adelante', 1),
(4, '13 - 65', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_poblacion_lugar`
--

CREATE TABLE `cat_poblacion_lugar` (
  `id_poblacion_lugar` bigint(20) UNSIGNED NOT NULL,
  `nombre_poblacion_lugar` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_poblacion_lugar`
--

INSERT INTO `cat_poblacion_lugar` (`id_poblacion_lugar`, `nombre_poblacion_lugar`, `active`) VALUES
(1, 'Nacional', 1),
(2, 'DF', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_poblacion_nivel`
--

CREATE TABLE `cat_poblacion_nivel` (
  `id_poblacion_nivel` bigint(20) UNSIGNED NOT NULL,
  `nombre_poblacion_nivel` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_poblacion_nivel`
--

INSERT INTO `cat_poblacion_nivel` (`id_poblacion_nivel`, `nombre_poblacion_nivel`, `active`) VALUES
(1, 'AB Alta', 1),
(2, 'C+ Media Alta', 1),
(3, 'C Media', 1),
(4, 'D+ Media Baja', 1),
(5, 'D Baja', 1),
(6, 'E Marginada', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_poblacion_nivel_educativo`
--

CREATE TABLE `cat_poblacion_nivel_educativo` (
  `id_poblacion_nivel_educativo` bigint(20) UNSIGNED NOT NULL,
  `nombre_poblacion_nivel_educativo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_poblacion_nivel_educativo`
--

INSERT INTO `cat_poblacion_nivel_educativo` (`id_poblacion_nivel_educativo`, `nombre_poblacion_nivel_educativo`, `active`) VALUES
(1, 'Doctorado', 1),
(2, 'Maestria', 1),
(3, 'Superior', 1),
(4, 'Media Superior', 1),
(5, 'Secundaria', 1),
(6, 'Primaria', 1),
(7, 'Sin educaci', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_poblacion_sexo`
--

CREATE TABLE `cat_poblacion_sexo` (
  `id_poblacion_sexo` bigint(20) UNSIGNED NOT NULL,
  `nombre_poblacion_sexo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_poblacion_sexo`
--

INSERT INTO `cat_poblacion_sexo` (`id_poblacion_sexo`, `nombre_poblacion_sexo`, `active`) VALUES
(1, 'Masculino', 1),
(2, 'Femenino', 1),
(3, 'Ambos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_presupuesto_conceptos`
--

CREATE TABLE `cat_presupuesto_conceptos` (
  `id_presupesto_concepto` bigint(20) UNSIGNED NOT NULL,
  `capitulo` varchar(7) NOT NULL,
  `concepto` varchar(7) NOT NULL DEFAULT ' ',
  `partida` varchar(7) NOT NULL DEFAULT '',
  `denominacion` varchar(255) NOT NULL DEFAULT '',
  `descripcion` mediumtext NOT NULL,
  `id_captura` bigint(20) NOT NULL DEFAULT '1',
  `active` bigint(20) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_presupuesto_conceptos`
--

INSERT INTO `cat_presupuesto_conceptos` (`id_presupesto_concepto`, `capitulo`, `concepto`, `partida`, `denominacion`, `descripcion`, `id_captura`, `active`) VALUES
(1, '3300', '', ' ', 'Servicios profesionales, científicos, técnicos y otros servicios', 'Asignaciones destinadas a cubrir erogaciones por contrataci&oacute;n de personas f&iacute;sicas y morales para la prestaci&oacute;n de servicios profesionales independientes, tales como inform&aacute;tico, de asesor&iacute;a, consultor&iacute;a, capacitaci&oacute;n, estudios e investigaciones, protecci&oacute;n y seguridad; incluye los servicios subrogados que se contraten; se excluyen los estudios de preinversi&oacute;n previstos en el cap&iacute;tulo de Inversi&oacute;n P&uacute;blica, as&iacute; como los honorarios asimilables a salarios.</p>', 1, 1),
(2, '3300', '336', ' ', 'Servicios de apoyo administrativo, traducción, fotocopiado e impresión', 'Asignaciones destinadas a cubrir el costo de la contrataci&oacute;n de servicios de fotocopiado y preparaci&oacute;n de documentos; digitalizaci&oacute;n de documentos oficiales, fax, engargolado, enmicado, encuadernaci&oacute;n, corte de papel, recepci&oacute;n de correspondencia y otros afines. Incluye servicios de apoyo secretarial, servicios de estenograf&iacute;a en los tribunales, transcripci&oacute;n simult&aacute;nea de di&aacute;logos para la televisi&oacute;n, reuniones y conferencias; servicios comerciales no previstos en las dem&aacute;s partidas anteriores. Incluye servicios de impresi&oacute;n de documentos oficiales necesarios tales como: pasaportes, certificados especiales, t&iacute;tulos de cr&eacute;dito, formas fiscales y formas valoradas, y dem&aacute;s documentos para la identificaci&oacute;n, tr&aacute;mites oficiales y servicios a la poblaci&oacute;n; servicios de impresi&oacute;n y elaboraci&oacute;n de material informativo, tales como: padrones de beneficiarios, reglas de operaci&oacute;n, programas sectoriales, regionales, especiales; informes de labores, manuales de organizaci&oacute;n, de procedimientos y de servicios al p&uacute;blico; decretos, convenios, acuerdos, instructivos, proyectos editoriales (libros, revistas y gacetas peri&oacute;dicas), folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, y dem&aacute;s servicios de impresi&oacute;n y elaboraci&oacute;n de material informativo. Incluye gastos como: avisos, precisiones, convocatorias, edictos, bases, licitaciones, diario oficial, concursos y aclaraciones, y dem&aacute;s informaci&oacute;n en medios masivos. Excluye las inserciones derivadas de campa&ntilde;as publicitarias y de comunicaci&oacute;n social, las cuales se deber&aacute;n registrar en las partidas correspondientes al concepto 3600 Servicios de Comunicaci&oacute;n Social y Publicidad.', 1, 1),
(3, '3300', '336', '33604', 'Impresión y elaboración de material informativo derivado de la operación y administración de las dependencias y entidades', 'Asignaciones destinadas a cubrir el costo de los servicios de impresi&oacute;n y elaboraci&oacute;n de material informativo, tales como: padrones de beneficiarios, reglas de operaci&oacute;n, programas sectoriales, regionales, especiales; informes de labores, manuales de organizaci&oacute;n, de procedimientos y de servicios al p&uacute;blico; decretos, convenios, acuerdos, instructivos, proyectos editoriales (libros, revistas y gacetas peri&oacute;dicas), folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, y dem&aacute;s servicios de impresi&oacute;n y elaboraci&oacute;n de material informativo que forma parte de los instrumentos de apoyo para la realizaci&oacute;n de los programas presupuestarios de las dependencias y entidades, distintos de los servicios de comunicaci&oacute;n social y publicidad.', 1, 1),
(4, '3300', '336', '33605', 'Información en medios masivos derivada de la operación y administración de las dependencias y entidades', 'Asignaciones destinadas a cubrir los gastos de difusi&oacute;n, en medios impresos y/o complementarios, de informaci&oacute;n, incluyendo aquellas que se realicen en cumplimiento de disposiciones jur&iacute;dicas, como: avisos, precisiones, convocatorias, edictos, bases, licitaciones, padrones de beneficiarios, reglas de operaci&oacute;n, diario oficial, concursos y aclaraciones, y dem&aacute;s informaci&oacute;n en medios masivos, distinta de las inserciones derivadas de campa&ntilde;as publicitarias y de comunicaci&oacute;n social, las cuales se deber&aacute;n registrar en la partida que corresponda del concepto 3600 Servicios de comunicaci&oacute;n social y publicidad.', 1, 1),
(5, '3600', ' ', ' ', 'Servicios de comunicación social y publicidad', '<p>Asignaciones destinadas a cubrir los gastos de realizaci&oacute;n y difusi&oacute;n de mensajes y campa&ntilde;as para informar a la poblaci&oacute;n sobre los programas, servicios p&uacute;blicos y el quehacer gubernamental en general; as&iacute; como la publicidad comercial de los productos y servicios que generan ingresos para los entes p&uacute;blicos. Incluye la contrataci&oacute;n de servicios de impresi&oacute;n y publicaci&oacute;n de informaci&oacute;n.</p>', 1, 1),
(6, '3600', '361', '', 'Difusión por radio, televisión y otros medios de mensajes sobre programas y actividades gubernamentales', 'Asignaciones destinadas a cubrir el costo de difusi&oacute;n del quehacer gubernamental y de los bienes y servicios p&uacute;blicos que prestan los entes p&uacute;blicos, la publicaci&oacute;n y difusi&oacute;n masiva de las mismas a un p&uacute;blico objetivo determinado a trav&eacute;s de televisi&oacute;n abierta y restringida, radio, cine, prensa, encartes, espectaculares, mobiliario urbano, tarjetas telef&oacute;nicas, medios electr&oacute;nicos e impresos internacionales, folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, producto integrado y otros medios complementarios; estudios para medir la pertinencia y efectividad de las campa&ntilde;as, as&iacute; como los gastos derivados de la contrataci&oacute;n de personas f&iacute;sicas y/o morales que presten servicios afines para la elaboraci&oacute;n, difusi&oacute;n y evaluaci&oacute;n de dichas campa&ntilde;as.', 1, 1),
(7, '3600', '361', '36101', 'Difusión de mensajes sobre programas y actividades gubernamentales', 'Asignaciones destinadas a cubrir el costo de difusi&oacute;n del quehacer gubernamental y de los bienes y servicios p&uacute;blicos que prestan las dependencias o entidades. Incluye el dise&ntilde;o y conceptualizaci&oacute;n de campa&ntilde;as de comunicaci&oacute;n, preproducci&oacute;n, producci&oacute;n, postproducci&oacute;n y copiado; la publicaci&oacute;n y difusi&oacute;n masiva de las mismas a un p&uacute;blico objetivo determinado a trav&eacute;s de televisi&oacute;n abierta y restringida, radio, cine, prensa, encartes, espectaculares, mobiliario urbano, tarjetas telef&oacute;nicas, Internet, medios electr&oacute;nicos e impresos internacionales, folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, producto integrado y otros medios complementarios; estudios para medir la pertinencia y efectividad de las campa&ntilde;as, as&iacute; como los gastos derivados de la contrataci&oacute;n de personas f&iacute;sicas y/o morales que presten servicios afines para la elaboraci&oacute;n, difusi&oacute;n y evaluaci&oacute;n de dichas campa&ntilde;as.', 1, 1),
(8, '3600', '362', '', 'Difusión por radio, televisión y otros medios de mensajes comerciales para promover la venta de bienes o servicios', 'Asignaciones destinadas a cubrir el costo de la publicidad derivada de la comercializaci&oacute;n de los productos o servicios de los entes p&uacute;blicos que generan un ingreso para el Estado. Incluye el dise&ntilde;o y conceptualizaci&oacute;n de campa&ntilde;as publicitarias; preproducci&oacute;n, producci&oacute;n, postproducci&oacute;n y copiado; publicaci&oacute;n y difusi&oacute;n masiva de las mismas a un p&uacute;blico objetivo determinado a trav&eacute;s de televisi&oacute;n abierta y restringida, radio, cine, prensa, encartes, espectaculares, mobiliario urbano, tarjetas telef&oacute;nicas, Internet, medios electr&oacute;nicos e impresos internacionales, folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, producto integrado, puntos de venta, art&iacute;culos promocionales, servicios integrales de promoci&oacute;n y otros medios complementarios, estudios para medir la pertinencia y efectividad de campa&ntilde;as; as&iacute; como los gastos derivados de la contrataci&oacute;n de personas f&iacute;sicas y/o morales que presenten servicios afines para la elaboraci&oacute;n, difusi&oacute;n y evaluaci&oacute;n de dichas campa&ntilde;as publicitarias. Excluye los gastos de difusi&oacute;n de mensajes que no comercializan productos o servicios.', 1, 1),
(9, '3600', '362', '36201', 'Difusión de mensajes comerciales para promover la venta de productos o servicios', '<p>Asignaciones destinadas a cubrir el costo de la publicidad derivada de la comercializaci&oacute;n de los productos o servicios de las entidades que generan un ingreso para el Estado. Incluye el dise&ntilde;o y conceptualizaci&oacute;n de campa&ntilde;as publicitarias; preproducci&oacute;n, producci&oacute;n, postproducci&oacute;n y copiado; publicaci&oacute;n y difusi&oacute;n masiva de las mismas a un p&uacute;blico objetivo determinado a trav&eacute;s de televisi&oacute;n abierta y restringida, radio, cine, prensa, encartes, espectaculares, mobiliario urbano, tarjetas telef&oacute;nicas, Internet, medios electr&oacute;nicos e impresos internacionales, folletos, tr&iacute;pticos, d&iacute;pticos, carteles, mantas, r&oacute;tulos, producto integrado, puntos de venta, art&iacute;culos promocionales, servicios integrales de promoci&oacute;n y otros medios complementarios, estudios para medir la pertinencia y efectividad de campa&ntilde;as; as&iacute; como los gastos derivados de la contrataci&oacute;n de personas f&iacute;sicas y/o morales que presenten servicios afines para la elaboraci&oacute;n, difusi&oacute;n y evaluaci&oacute;n de dichas campa&ntilde;as publicitarias. Excluye los gastos de difusi&oacute;n de mensajes que no comercializan productos o servicios, los cuales deben registrarse en la partida 36101 Difusi&oacute;n de mensajes sobre programas y actividades gubernamentales.</p>', 1, 1),
(10, '3600', '363', '', 'Servicios de creatividad, preproducción y producción de publicidad, excepto internet', '<p>Asignaciones destinadas a cubrir los gastos por dise&ntilde;o y conceptualizaci&oacute;n de campa&ntilde;as de comunicaci&oacute;n, preproducci&oacute;n, producci&oacute;n y copiado.</p>', 1, 1),
(11, '3600', '364', '', 'Servicios de revelado de fotografías', '<p>Asignaciones destinadas a cubrir gastos por concepto de revelado o impresi&oacute;n de fotograf&iacute;as</p>', 1, 1),
(12, '3600', '365', '', 'Servicios de la industria fílmica, del sonido y del video', '<p>Asignaciones destinadas a cubrir el costo por postproducci&oacute;n (doblaje, titulaje, subtitulaje, efectos visuales, animaci&oacute;n, edici&oacute;n, conversi&oacute;n de formato, copiado de videos, entre otros) y otros servicios para la industria f&iacute;lmica y del video (crestomat&iacute;a y servicios prestados por laboratorios f&iacute;lmicos).</p>', 1, 1),
(13, '3600', '366', '', 'Servicio de creación y difusión de contenido exclusivamente a través de internet', '<p>Asignaciones destinadas a cubrir el gasto por creaci&oacute;n, difusi&oacute;n y transmisi&oacute;n de contenido de inter&eacute;s general o espec&iacute;fico a trav&eacute;s de internet exclusivamente</p>', 1, 1),
(14, '3600', '369', '', 'Otros servicios de información', '<p>Asignaciones destinadas a cubrir el costo de la contrataci&oacute;n de servicios profesionales con personas f&iacute;sicas o morales, por concepto de monitoreo de informaci&oacute;n en medios masivos de comunicaci&oacute;n, de las actividades de los entes p&uacute;blicos, que no se encuentren comprendidas en las dem&aacute;s partidas de este Cap&iacute;tulo.</p>', 1, 1),
(15, '3600', '369', '36901', 'Servicios relacionados con monitoreo de información en medios masivos', '<p>Asignaciones destinadas a cubrir el costo de la contrataci&oacute;n de servicios profesionales con personas f&iacute;sicas o morales, por concepto de monitoreo de informaci&oacute;n en medios masivos de comunicaci&oacute;n, de las actividades de las dependencias y entidades, que no se encuentren comprendidas en las dem&aacute;s partidas de este Cap&iacute;tulo.</p>', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_procedimientos`
--

CREATE TABLE `cat_procedimientos` (
  `id_procedimiento` bigint(20) UNSIGNED NOT NULL,
  `nombre_procedimiento` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_procedimientos`
--

INSERT INTO `cat_procedimientos` (`id_procedimiento`, `nombre_procedimiento`, `active`) VALUES
(1, 'Licitación pública', 1),
(2, 'Adjudicación directa', 1),
(3, 'Invitación a cuando menos tres proveedores (restringida)', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_roles_administracion`
--

CREATE TABLE `cat_roles_administracion` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` text NOT NULL,
  `descripcion_rol` text NOT NULL,
  `active` char(1) NOT NULL,
  `fecha_rol` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_roles_administracion`
--

INSERT INTO `cat_roles_administracion` (`id_rol`, `nombre_rol`, `descripcion_rol`, `active`, `fecha_rol`) VALUES
(1, 'Administrador', 'Rol encargado de supervisar todo.', 'a', '2020-06-02'),
(2, 'Capturista', 'Rol encargado de alimentar la Base de Datos', 'a', '2020-06-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_servicios_categorias`
--

CREATE TABLE `cat_servicios_categorias` (
  `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_clasificacion` bigint(20) UNSIGNED NOT NULL,
  `nombre_servicio_categoria` varchar(255) NOT NULL,
  `titulo_grafica` varchar(30) NOT NULL DEFAULT '',
  `color_grafica` varchar(7) NOT NULL DEFAULT '#ACACAC',
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_servicios_categorias`
--

INSERT INTO `cat_servicios_categorias` (`id_servicio_categoria`, `id_servicio_clasificacion`, `nombre_servicio_categoria`, `titulo_grafica`, `color_grafica`, `active`) VALUES
(1, 1, 'Radio', 'Radio', '#004858', 1),
(2, 1, 'Televisión', 'TV', '#699DB3', 1),
(3, 1, 'Cine', 'Cine', '#756EA0', 1),
(4, 1, 'Medios impresos', 'Medios', '#13B6E3', 1),
(5, 1, 'Medios complementarios', 'Complementarios', '#1287C1', 1),
(6, 1, 'Internet', 'Internet', '#81CEF3', 1),
(7, 2, 'Producción de contenidos', 'Contenidos', '#08AFBC', 1),
(8, 2, 'Análisis, estudios y métricas', 'Estudios', '#BBE4E7', 1),
(9, 2, 'Impresiones', 'Impresiones', '#51B27C', 1),
(10, 2, 'Streaming', 'Streaming', '#A2CCAE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_servicios_clasificacion`
--

CREATE TABLE `cat_servicios_clasificacion` (
  `id_servicio_clasificacion` bigint(20) UNSIGNED NOT NULL,
  `nombre_servicio_clasificacion` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_servicios_clasificacion`
--

INSERT INTO `cat_servicios_clasificacion` (`id_servicio_clasificacion`, `nombre_servicio_clasificacion`, `active`) VALUES
(1, 'Servicios de difusión en medios de comunicación', 1),
(2, 'Otros servicios asociados a la comunicación', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_servicios_subcategorias`
--

CREATE TABLE `cat_servicios_subcategorias` (
  `id_servicio_subcategoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL,
  `nombre_servicio_subcategoria` varchar(255) NOT NULL,
  `active` bigint(20) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_servicios_subcategorias`
--

INSERT INTO `cat_servicios_subcategorias` (`id_servicio_subcategoria`, `id_servicio_categoria`, `nombre_servicio_subcategoria`, `active`) VALUES
(1, 3, 'Cine', 1),
(2, 6, 'Medios Digitales', 1),
(3, 6, 'Otro tipo de difusión por Internet', 1),
(4, 6, 'Redes sociales y buscadores', 1),
(5, 5, 'Artículos promocionales', 1),
(6, 5, 'Cenefas', 1),
(7, 5, 'Dovelas', 1),
(8, 5, 'Mobiliario urbano', 1),
(9, 5, 'Muros o bardas', 1),
(10, 5, 'Otros medios complementarios', 1),
(11, 5, 'Parabuses', 1),
(12, 5, 'Publicidad móvil', 1),
(13, 5, 'Rótulos o anuncios exteriores', 1),
(14, 5, 'Tarjetas telefónicas', 1),
(15, 5, 'Vallas', 1),
(16, 5, 'Videobus', 1),
(17, 4, 'Diarios Editados en el D.F.', 1),
(18, 4, 'Diarios Editados en los Estados', 1),
(19, 4, 'Encartes', 1),
(20, 4, 'Medios Impresos Internacionales', 1),
(21, 4, 'Otros medios impresos', 1),
(22, 4, 'Revistas', 1),
(23, 4, 'Suplementos', 1),
(24, 1, 'Cadenas radiofónicas', 1),
(25, 1, 'Radiodifusoras comunitarias e indígenas', 1),
(26, 1, 'Radiodifusoras internacionales', 1),
(27, 1, 'Radiodifusoras locales', 1),
(28, 2, 'Publicidad virtual', 1),
(29, 2, 'Televisión abierta local', 1),
(30, 2, 'Televisión abierta nacional', 1),
(31, 2, 'Televisión internacional', 1),
(32, 2, 'Televisión restringida', 1),
(33, 8, 'Estudios (Pre-Campaña, Post-Campaña)', 1),
(34, 8, 'Plan de medios', 1),
(35, 9, 'Carteles o Pósters', 1),
(36, 9, 'Folletos, Dípticos o Trípticos', 1),
(37, 9, 'Mantas o Lonas', 1),
(38, 9, 'Otro tipo de materiales impresos', 1),
(39, 7, 'Copiado', 1),
(40, 7, 'Diseño y servicios publicitarios', 1),
(41, 7, 'Otro tipo de servicio de producción', 1),
(42, 7, 'Post-Producción', 1),
(43, 7, 'Producción', 1),
(44, 5, 'Espectaculares', 1),
(45, 10, 'Streaming', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_servicios_unidades`
--

CREATE TABLE `cat_servicios_unidades` (
  `id_servicio_unidad` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_subcategoria` bigint(20) UNSIGNED NOT NULL,
  `nombre_servicio_unidad` varchar(255) NOT NULL,
  `active` bigint(20) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_servicios_unidades`
--

INSERT INTO `cat_servicios_unidades` (`id_servicio_unidad`, `id_servicio_subcategoria`, `nombre_servicio_unidad`, `active`) VALUES
(1, 1, 'Cine minutos', 1),
(2, 1, 'Otro formato', 1),
(3, 2, 'Banner', 1),
(4, 2, 'Otro formato', 1),
(5, 3, 'Unidad aplicable', 1),
(6, 4, 'Anuncio de video en YouTube;  Página', 1),
(7, 4, 'Contenido o publicación difundida en Facebook', 1),
(8, 4, 'Cuenta o tuit promovido en Twitter', 1),
(9, 4, 'Anuncios de imagen', 1),
(10, 4, 'Video o carrusel de imágenes en Instagram', 1),
(11, 4, 'Actualización de contenido promocionada en LinkedIn', 1),
(12, 4, 'Contenido promovido en Adwords de Google', 1),
(13, 4, 'Contenido promovido en Anuncios de Bing', 1),
(14, 4, 'Otro', 1),
(15, 5, 'Pieza', 1),
(16, 44, 'Otro formato', 1),
(17, 6, 'Cartelera doble', 1),
(18, 6, 'Cartelera sencilla', 1),
(19, 6, 'Otro formato', 1),
(20, 7, 'Cartelera doble', 1),
(21, 7, 'Cartelera sencilla', 1),
(22, 7, 'Otro formato', 1),
(23, 44, 'Cartelera doble', 1),
(24, 44, 'Cartelera sencilla', 1),
(25, 8, 'Cartelera doble', 1),
(26, 8, 'Cartelera sencilla', 1),
(27, 8, 'Otro formato', 1),
(28, 9, 'Cartelera doble', 1),
(29, 9, 'Cartelera sencilla', 1),
(30, 9, 'Otro formato', 1),
(31, 10, 'Unidades de producto', 1),
(32, 10, 'Unidades de servicio', 1),
(33, 10, 'Otro formato', 1),
(34, 11, 'Cartelera doble', 1),
(35, 11, 'Cartelera sencilla', 1),
(36, 11, 'Otro formato', 1),
(37, 12, 'Cartelera doble', 1),
(38, 12, 'Cartelera sencilla', 1),
(39, 12, 'Otro formato', 1),
(40, 13, 'Cartelera doble', 1),
(41, 14, 'Millar', 1),
(42, 14, 'Otro formato', 1),
(43, 14, 'Unidades de producto', 1),
(44, 15, 'Cartelera doble', 1),
(45, 15, 'Cartelera sencilla', 1),
(46, 15, 'Otro formato', 1),
(47, 16, 'Cartelera doble', 1),
(48, 16, 'Cartelera sencilla', 1),
(49, 16, 'Otro formato', 1),
(50, 17, '1/2 plana', 1),
(51, 17, '1/4 plana', 1),
(52, 17, '1/8 plana', 1),
(53, 17, 'Cintillo', 1),
(54, 17, 'Plana', 1),
(55, 17, 'Robaplana', 1),
(56, 17, 'Otro formato', 1),
(57, 18, '1/2 plana', 1),
(58, 18, '1/4 plana', 1),
(59, 18, '1/8 plana', 1),
(60, 18, 'Cintillo', 1),
(61, 18, 'Plana', 1),
(62, 18, 'Robaplana', 1),
(63, 18, 'Otro formato', 1),
(64, 19, 'Unidades de servicio', 1),
(65, 19, 'Otro formato', 1),
(66, 20, '1/2 plana', 1),
(67, 20, '1/4 plana', 1),
(68, 20, '1/8 plana', 1),
(69, 20, 'Cintillo', 1),
(70, 20, 'Plana', 1),
(71, 20, 'Robaplana', 1),
(72, 20, 'Otro formato', 1),
(73, 21, 'Unidad aplicable', 1),
(74, 22, '1/2 plana', 1),
(75, 22, '1/4 plana', 1),
(76, 22, '1/8 plana', 1),
(77, 22, '2a. Forros', 1),
(78, 22, '3a. Forros', 1),
(79, 22, '4a. Forros', 1),
(80, 22, 'Cintillo', 1),
(81, 22, 'Plana', 1),
(82, 22, 'Robaplana', 1),
(83, 22, 'Otro formato', 1),
(84, 23, 'Unidades de servicio', 1),
(85, 23, 'Otro formato', 1),
(86, 24, 'Cápsula 1 min.', 1),
(87, 24, 'Cápsula 5 min.', 1),
(88, 24, 'Mención', 1),
(89, 24, 'Otro formato', 1),
(90, 24, 'Spot de 20 seg.', 1),
(91, 24, 'Spot de 30 seg.', 1),
(92, 25, 'Cápsula 1 min.', 1),
(93, 25, 'Cápsula 5 min.', 1),
(94, 25, 'Mención', 1),
(95, 25, 'Otro formato', 1),
(96, 25, 'Spot de 20 seg.', 1),
(97, 25, 'Spot de 30 seg.', 1),
(98, 26, 'Cápsula 1 min.', 1),
(99, 26, 'Cápsula 5 min.', 1),
(100, 26, 'Mención', 1),
(101, 26, 'Otro formato', 1),
(102, 26, 'Spot de 20 seg.', 1),
(103, 26, 'Spot de 30 seg.', 1),
(104, 27, 'Cápsula 1 min.', 1),
(105, 27, 'Cápsula 5 min.', 1),
(106, 27, 'Mención', 1),
(107, 27, 'Otro formato', 1),
(108, 27, 'Spot de 20 seg.', 1),
(109, 27, 'Spot de 30 seg.', 1),
(110, 28, 'Cápsula 1 min.', 1),
(111, 28, 'Cápsula 5 min.', 1),
(112, 28, 'Mención', 1),
(113, 28, 'Otro formato', 1),
(114, 28, 'Spot de 20 seg.', 1),
(115, 28, 'Spot de 30 seg.', 1),
(116, 29, 'Cápsula 1 min.', 1),
(117, 29, 'Cápsula 5 min.', 1),
(118, 29, 'Mención', 1),
(119, 29, 'Otro formato', 1),
(120, 29, 'Spot de 20 seg.', 1),
(121, 29, 'Spot de 30 seg.', 1),
(122, 30, 'Cápsula 1 min.', 1),
(123, 30, 'Cápsula 5 min.', 1),
(124, 30, 'Mención', 1),
(125, 30, 'Otro formato', 1),
(126, 30, 'Spot de 20 seg.', 1),
(127, 30, 'Spot de 30 seg.', 1),
(128, 31, 'Cápsula 1 min.', 1),
(129, 31, 'Cápsula 5 min.', 1),
(130, 31, 'Mención', 1),
(131, 31, 'Otro formato', 1),
(132, 31, 'Spot de 20 seg.', 1),
(133, 31, 'Spot de 30 seg.', 1),
(134, 32, 'Cápsula 1 min.', 1),
(135, 32, 'Cápsula 5 min.', 1),
(136, 32, 'Mención', 1),
(137, 32, 'Otro formato', 1),
(138, 32, 'Spot de 20 seg.', 1),
(139, 32, 'Spot de 30 seg.', 1),
(140, 33, 'Otro formato', 1),
(141, 33, 'Unidades de producto', 1),
(142, 33, 'Unidades de servicio', 1),
(143, 34, 'Plan de medios', 1),
(144, 35, 'Pieza', 1),
(145, 36, 'Pieza', 1),
(146, 37, 'Pieza', 1),
(147, 38, 'Pieza', 1),
(148, 39, 'Otro formato', 1),
(149, 39, 'Unidades de producto', 1),
(150, 39, 'Unidades de servicio', 1),
(151, 40, 'Otro formato', 1),
(152, 40, 'Prod. spot radio 20 seg', 1),
(153, 40, 'Prod. spot radio 30 seg', 1),
(154, 40, 'Prod. spot tv 20 seg.', 1),
(155, 40, 'Prod. spot tv 30 seg', 1),
(156, 41, 'Unidades de producto', 1),
(157, 41, 'Unidades de servicio', 1),
(158, 41, 'Otro formato', 1),
(159, 42, 'Otro formato', 1),
(160, 42, 'Prod. spot radio 20 seg', 1),
(161, 42, 'Prod. spot radio 30 seg', 1),
(162, 42, 'Prod. spot tv 20 seg', 1),
(163, 42, 'Prod. spot tv 30 seg', 1),
(164, 43, 'Otro formato', 1),
(165, 43, 'Prod. spot radio 20 seg', 1),
(166, 43, 'Prod. spot radio 30 seg', 1),
(167, 43, 'Prod. spot tv 20 seg', 1),
(168, 43, 'Prod. spot tv 30 seg', 1),
(169, 45, 'Minutos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_so_atribucion`
--

CREATE TABLE `cat_so_atribucion` (
  `id_so_atribucion` bigint(20) UNSIGNED NOT NULL,
  `nombre_so_atribucion` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_so_atribucion`
--

INSERT INTO `cat_so_atribucion` (`id_so_atribucion`, `nombre_so_atribucion`, `active`) VALUES
(1, 'Contratante', 1),
(2, 'Solicitante', 1),
(3, 'Contratante y solicitante', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_so_estados`
--

CREATE TABLE `cat_so_estados` (
  `id_so_estado` bigint(20) UNSIGNED NOT NULL,
  `nombre_so_estado` varchar(255) CHARACTER SET latin1 NOT NULL,
  `codigo_so_estado` varchar(5) NOT NULL,
  `active` tinyint(3) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_so_estados`
--

INSERT INTO `cat_so_estados` (`id_so_estado`, `nombre_so_estado`, `codigo_so_estado`, `active`) VALUES
(1, 'Aguascalientes', 'mx-ag', 1),
(2, 'Baja California', 'mx-bc', 1),
(3, 'Baja California Sur', 'mx-bs', 1),
(4, 'Campeche', 'mx-cm', 1),
(5, 'Coahuila', 'mx-co', 1),
(6, 'Colima', 'mx-cl', 1),
(7, 'Chiapas', 'mx-cs', 1),
(8, 'Chihuahua', 'mx-ch', 1),
(9, 'Ciudad de México', 'mx-df', 1),
(10, 'Durango', 'mx-dg', 1),
(11, 'Guanajuato', 'mx-gj', 1),
(12, 'Guerrero', 'mx-gr', 1),
(13, 'Hidalgo', 'mx-hg', 1),
(14, 'Jalisco', 'mx-ja', 1),
(15, 'México', 'mx-mx', 1),
(16, 'Michoacán', 'mx-mi', 1),
(17, 'Morelos', 'mx-mo', 1),
(18, 'Nayarit', 'mx-na', 1),
(19, 'Nuevo León', 'mx-nl', 1),
(20, 'Oaxaca', 'mx-oa', 1),
(21, 'Puebla', 'mx-pu', 1),
(22, 'Querétaro', 'mx-qt', 1),
(23, 'Quintana Roo', 'mx-qr', 1),
(24, 'San Luis Potosí', 'mx-sl', 1),
(25, 'Sinaloa', 'mx-si', 1),
(26, 'Sonora', 'mx-so', 1),
(27, 'Tabasco', 'mx-tb', 1),
(28, 'Tamaulipas', 'mx-tm', 1),
(29, 'Tlaxcala', 'mx-tl', 1),
(30, 'Veracruz', 'mx-ve', 1),
(31, 'Yucatán', 'mx-yu', 1),
(32, 'Zacatecas', 'mx-za', 1),
(33, 'Federación', 'mx-fe', 1),
(34, 'Internacional', 'int', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_so_ordenes_gobierno`
--

CREATE TABLE `cat_so_ordenes_gobierno` (
  `id_so_orden_gobierno` bigint(20) UNSIGNED NOT NULL,
  `nombre_so_orden_gobierno` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_so_ordenes_gobierno`
--

INSERT INTO `cat_so_ordenes_gobierno` (`id_so_orden_gobierno`, `nombre_so_orden_gobierno`, `active`) VALUES
(1, 'Federal', 1),
(2, 'Estatal', 1),
(3, 'Municipal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tiempo_tipos`
--

CREATE TABLE `cat_tiempo_tipos` (
  `id_tiempo_tipo` bigint(20) UNSIGNED NOT NULL,
  `nombre_tipo_tiempo` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_tiempo_tipos`
--

INSERT INTO `cat_tiempo_tipos` (`id_tiempo_tipo`, `nombre_tipo_tiempo`, `active`) VALUES
(1, 'Tiempo de Estado', 1),
(2, 'Tiempo fiscal', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_tipo_liga`
--

CREATE TABLE `cat_tipo_liga` (
  `id_tipo_liga` bigint(20) UNSIGNED NOT NULL,
  `tipo_liga` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_tipo_liga`
--

INSERT INTO `cat_tipo_liga` (`id_tipo_liga`, `tipo_liga`, `active`) VALUES
(1, 'Referencia de Internet', 1),
(2, 'Archivo Servidor', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_trimestres`
--

CREATE TABLE `cat_trimestres` (
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `trimestre` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_trimestres`
--

INSERT INTO `cat_trimestres` (`id_trimestre`, `trimestre`, `active`) VALUES
(1, 'enero-marzo', 1),
(2, 'abril-junio', 1),
(3, 'julio-septiembre', 1),
(4, 'octubre-diciembre', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_grupo_edad`
--

CREATE TABLE `rel_campana_grupo_edad` (
  `id_rel_campana_grupo_edad` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_poblacion_grupo_edad` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_lugar`
--

CREATE TABLE `rel_campana_lugar` (
  `id_campana_lugar` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `poblacion_lugar` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_maudio`
--

CREATE TABLE `rel_campana_maudio` (
  `id_campana_maudio` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_liga` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `nombre_campana_maudio` varchar(255) NOT NULL,
  `url_audio` varchar(255) DEFAULT NULL,
  `file_audio` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_mimagenes`
--

CREATE TABLE `rel_campana_mimagenes` (
  `id_campana_mimagen` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_liga` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `nombre_campana_mimagen` varchar(255) NOT NULL,
  `url_imagen` varchar(255) DEFAULT NULL,
  `file_imagen` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_mvideo`
--

CREATE TABLE `rel_campana_mvideo` (
  `id_campana_mvideo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_liga` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `nombre_campana_mvideo` varchar(255) NOT NULL,
  `url_video` varchar(255) DEFAULT NULL,
  `file_video` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_nivel`
--

CREATE TABLE `rel_campana_nivel` (
  `id_rel_campana_nivel` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_poblacion_nivel` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_nivel_educativo`
--

CREATE TABLE `rel_campana_nivel_educativo` (
  `id_rel_campana_nivel_educativo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_poblacion_nivel_educativo` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rel_campana_sexo`
--

CREATE TABLE `rel_campana_sexo` (
  `id_rel_campana_sexo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_poblacion_sexo` bigint(20) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sec_users`
--

CREATE TABLE `sec_users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL DEFAULT '',
  `cookie_id` varchar(64) NOT NULL DEFAULT '0',
  `token` varchar(128) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `public_office` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `lastip` varchar(16) DEFAULT NULL,
  `notes` text,
  `record_user` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `last_update` date DEFAULT NULL,
  `rol_user` text NOT NULL,
  `active` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sec_users`
--

INSERT INTO `sec_users` (`id_user`, `username`, `password`, `cookie_id`, `token`, `email`, `fname`, `lname`, `public_office`, `phone`, `created`, `lastlogin`, `lastip`, `notes`, `record_user`, `last_update`, `rol_user`, `active`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '0', '0', 'admin@admin.com', 'admin', 'admin', '', '', NULL, NULL, '127.0.0.1', NULL, 1, '2019-08-10', '1', 'a'),
(2, 'captura', '2f96deee58dae83ace6ecdf1a6a0c31233e0bc7b', '0', '0', 'captura@captura.com', 'captura', 'captura', NULL, '', '2020-06-02 00:00:00', NULL, NULL, NULL, 1, NULL, '2', 'a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_active`
--

CREATE TABLE `sys_active` (
  `id_active` bigint(20) UNSIGNED NOT NULL,
  `name_active` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sys_active`
--

INSERT INTO `sys_active` (`id_active`, `name_active`) VALUES
(1, 'Activo'),
(2, 'Inactivo'),
(3, 'En Proceso'),
(4, 'Pago Emitido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_debug`
--

CREATE TABLE `sys_debug` (
  `id_debug` bigint(20) UNSIGNED NOT NULL,
  `debug` text CHARACTER SET latin1,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_log`
--

CREATE TABLE `sys_log` (
  `id_log` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_bis` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(10) CHARACTER SET latin1 NOT NULL,
  `id_type` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `log` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `log_status_change` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `log_coments` text CHARACTER SET latin1,
  `log_ip` varchar(20) DEFAULT NULL,
  `log_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_logico`
--

CREATE TABLE `sys_logico` (
  `id_logico` bigint(20) UNSIGNED NOT NULL,
  `logico` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sys_logico`
--

INSERT INTO `sys_logico` (`id_logico`, `logico`, `active`) VALUES
(1, 'Si', 1),
(2, 'No', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sys_settings`
--

CREATE TABLE `sys_settings` (
  `id_settings` bigint(20) UNSIGNED NOT NULL,
  `recaptcha` varchar(50) NOT NULL DEFAULT '0',
  `clave` text,
  `tipo` varchar(50) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `url_docs` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_campana_aviso`
--

CREATE TABLE `tab_campana_aviso` (
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `id_campana_cobertura` bigint(20) UNSIGNED NOT NULL,
  `id_campana_tipo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_subtipo` bigint(20) UNSIGNED NOT NULL,
  `id_campana_tema` bigint(20) UNSIGNED NOT NULL,
  `id_campana_objetivo` bigint(20) UNSIGNED NOT NULL,
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `id_so_contratante` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_so_solicitante` bigint(20) UNSIGNED NOT NULL,
  `id_tiempo_oficial` bigint(20) UNSIGNED NOT NULL,
  `id_campana_tipoTO` bigint(20) UNSIGNED NOT NULL,
  `id_presupuesto` bigint(20) UNSIGNED NOT NULL,
  `nombre_campana_aviso` varchar(255) NOT NULL,
  `objetivo_comunicacion` text,
  `fecha_inicio_periodo` date DEFAULT NULL,
  `fecha_termino_periodo` date DEFAULT NULL,
  `monto_tiempo` varchar(50) DEFAULT NULL,
  `hora_to` varchar(50) DEFAULT NULL,
  `minutos_to` varchar(50) DEFAULT NULL,
  `segundos_to` varchar(50) DEFAULT NULL,
  `mensajeTO` text,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_termino` date DEFAULT NULL,
  `fecha_inicio_to` date DEFAULT NULL,
  `fecha_termino_to` date DEFAULT NULL,
  `publicacion_segob` varchar(255) DEFAULT NULL,
  `campana_ambito_geo` varchar(50) DEFAULT NULL,
  `plan_acs` varchar(255) DEFAULT NULL,
  `fecha_dof` date NOT NULL,
  `evaluacion` text,
  `evaluacion_documento` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `autoridad` varchar(255) DEFAULT NULL,
  `clave_campana` varchar(100) DEFAULT NULL,
  `active` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_contratos`
--

CREATE TABLE `tab_contratos` (
  `id_contrato` bigint(20) UNSIGNED NOT NULL,
  `id_procedimiento` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_proveedor` bigint(20) UNSIGNED NOT NULL,
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `id_so_contratante` bigint(20) UNSIGNED NOT NULL,
  `id_so_solicitante` bigint(20) UNSIGNED NOT NULL,
  `numero_contrato` varchar(50) NOT NULL,
  `objeto_contrato` text NOT NULL,
  `descripcion_justificacion` text NOT NULL,
  `fundamento_juridico` text NOT NULL,
  `fecha_celebracion` date NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `monto_contrato` decimal(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `file_contrato` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_contratos`
--

INSERT INTO `tab_contratos` (`id_contrato`, `id_procedimiento`, `id_proveedor`, `id_ejercicio`, `id_trimestre`, `id_so_contratante`, `id_so_solicitante`, `numero_contrato`, `objeto_contrato`, `descripcion_justificacion`, `fundamento_juridico`, `fecha_celebracion`, `fecha_inicio`, `fecha_fin`, `monto_contrato`, `file_contrato`, `fecha_validacion`, `area_responsable`, `periodo`, `fecha_actualizacion`, `nota`, `active`) VALUES
(1, 1, 1, 1, 2, 1, 1, 'Sin contrato', '<p>Sin contrato</p>', '<p>Sin contrato</p>', '<p>Sin contrato</p>', '2015-12-10', '2015-12-15', '2015-12-31', '0.00', 'Ciclo_de_Vida_Proyectos.pdf', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_convenios_modificatorios`
--

CREATE TABLE `tab_convenios_modificatorios` (
  `id_convenio_modificatorio` bigint(20) UNSIGNED NOT NULL,
  `id_contrato` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `numero_convenio` varchar(255) NOT NULL,
  `objeto_convenio` text NOT NULL,
  `fundamento_juridico` text NOT NULL,
  `fecha_celebracion` date NOT NULL,
  `monto_convenio` decimal(15,2) NOT NULL DEFAULT '0.00',
  `file_convenio` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_facturas`
--

CREATE TABLE `tab_facturas` (
  `id_factura` bigint(20) UNSIGNED NOT NULL,
  `id_proveedor` bigint(20) UNSIGNED NOT NULL,
  `id_contrato` bigint(20) UNSIGNED NOT NULL,
  `id_orden_compra` bigint(20) UNSIGNED NOT NULL,
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `id_so_contratante` bigint(20) DEFAULT NULL,
  `id_presupuesto_concepto` bigint(20) DEFAULT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha_erogacion` date NOT NULL,
  `file_factura_pdf` varchar(255) DEFAULT NULL,
  `file_factura_xml` varchar(255) DEFAULT '1',
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_facturas_desglose`
--

CREATE TABLE `tab_facturas_desglose` (
  `id_factura_desglose` bigint(20) UNSIGNED NOT NULL,
  `id_factura` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_clasificacion` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_subcategoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_unidad` bigint(20) UNSIGNED DEFAULT '0',
  `id_so_contratante` bigint(20) UNSIGNED DEFAULT NULL,
  `id_presupuesto_concepto` bigint(20) UNSIGNED DEFAULT NULL,
  `id_so_solicitante` bigint(20) UNSIGNED NOT NULL,
  `id_presupuesto_concepto_solicitante` bigint(20) UNSIGNED DEFAULT NULL,
  `numero_partida` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `descripcion_servicios` text NOT NULL,
  `cantidad` decimal(15,2) NOT NULL DEFAULT '1.00',
  `precio_unitarios` decimal(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `monto_desglose` decimal(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `area_administrativa` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Disparadores `tab_facturas_desglose`
--
DELIMITER $$
CREATE TRIGGER `FDESGLOSE_INTSERT_TRIGGER` BEFORE INSERT ON `tab_facturas_desglose` FOR EACH ROW BEGIN SET NEW.monto_desglose = NEW.cantidad * NEW.precio_unitarios; END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `FDESGLOSE_UPDATE_TRIGGER` BEFORE UPDATE ON `tab_facturas_desglose` FOR EACH ROW BEGIN SET NEW.monto_desglose = NEW.cantidad * NEW.precio_unitarios; END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_fecha_actualizacion_manual`
--

CREATE TABLE `tab_fecha_actualizacion_manual` (
  `id_fecha_act` int(11) NOT NULL,
  `fecha_act` date NOT NULL,
  `comentario_act` text NOT NULL,
  `active` char(1) NOT NULL,
  `fecha_reg` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_fecha_actualizacion_manual`
--

INSERT INTO `tab_fecha_actualizacion_manual` (`id_fecha_act`, `fecha_act`, `comentario_act`, `active`, `fecha_reg`) VALUES
(1, '2020-06-02', 'Esta es la fecha de actualización del código.', 'a', '2020-06-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_ordenes_compra`
--

CREATE TABLE `tab_ordenes_compra` (
  `id_orden_compra` bigint(20) UNSIGNED NOT NULL,
  `id_procedimiento` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_proveedor` bigint(20) UNSIGNED NOT NULL,
  `id_contrato` bigint(20) UNSIGNED DEFAULT NULL,
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_trimestre` bigint(20) UNSIGNED NOT NULL,
  `id_so_contratante` bigint(20) UNSIGNED NOT NULL,
  `id_so_solicitante` bigint(20) UNSIGNED NOT NULL,
  `id_campana_aviso` bigint(20) UNSIGNED NOT NULL,
  `numero_orden_compra` varchar(255) NOT NULL,
  `descripcion_justificacion` text NOT NULL,
  `motivo_adjudicacion` text NOT NULL,
  `fecha_orden` date NOT NULL,
  `file_orden` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_ordenes_compra`
--

INSERT INTO `tab_ordenes_compra` (`id_orden_compra`, `id_procedimiento`, `id_proveedor`, `id_contrato`, `id_ejercicio`, `id_trimestre`, `id_so_contratante`, `id_so_solicitante`, `id_campana_aviso`, `numero_orden_compra`, `descripcion_justificacion`, `motivo_adjudicacion`, `fecha_orden`, `file_orden`, `fecha_validacion`, `area_responsable`, `periodo`, `fecha_actualizacion`, `nota`, `active`) VALUES
(1, 2, 1, 1, 1, 2, 1, 1, 1, 'Sin orden de compra', '<p>Sin Orden de Compra</p>', '', '2015-12-18', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_presupuestos`
--

CREATE TABLE `tab_presupuestos` (
  `id_presupuesto` bigint(20) UNSIGNED NOT NULL,
  `id_ejercicio` bigint(20) UNSIGNED NOT NULL,
  `id_sujeto_obligado` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `denominacion` text,
  `fecha_publicacion` date DEFAULT NULL,
  `file_programa_anual` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `fecha_inicio_periodo` date DEFAULT NULL,
  `fecha_termino_periodo` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `anio` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `mision` text,
  `objetivo` text,
  `metas` text,
  `programas` text,
  `objetivo_transversal` text,
  `conjunto_campanas` text,
  `temas` text,
  `nota_planeacion` text,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_presupuestos_desglose`
--

CREATE TABLE `tab_presupuestos_desglose` (
  `id_presupuesto_desglose` bigint(20) UNSIGNED NOT NULL,
  `id_presupuesto` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `id_presupuesto_concepto` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `fuente_federal` text,
  `monto_fuente_federal` decimal(15,2) DEFAULT '0.00',
  `fuente_local` text,
  `monto_fuente_local` decimal(15,2) DEFAULT '0.00',
  `monto_presupuesto` decimal(15,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `monto_modificacion` decimal(15,2) NOT NULL DEFAULT '0.00',
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `denominacion` varchar(255) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `active` double UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_proveedores`
--

CREATE TABLE `tab_proveedores` (
  `id_proveedor` bigint(20) UNSIGNED NOT NULL,
  `id_personalidad_juridica` bigint(20) UNSIGNED NOT NULL,
  `nombre_razon_social` varchar(255) NOT NULL,
  `nombre_comercial` varchar(255) NOT NULL DEFAULT 'Persona física',
  `rfc` varchar(30) NOT NULL,
  `primer_apellido` varchar(255) DEFAULT NULL,
  `segundo_apellido` varchar(255) DEFAULT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `fecha_validacion` date DEFAULT NULL,
  `area_responsable` varchar(255) DEFAULT NULL,
  `periodo` int(11) DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `nota` text,
  `descripcion_servicios` varchar(255) DEFAULT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_proveedores`
--

INSERT INTO `tab_proveedores` (`id_proveedor`, `id_personalidad_juridica`, `nombre_razon_social`, `nombre_comercial`, `rfc`, `primer_apellido`, `segundo_apellido`, `nombres`, `fecha_validacion`, `area_responsable`, `periodo`, `fecha_actualizacion`, `nota`, `descripcion_servicios`, `active`) VALUES
(1, 2, 'Proveedor', 'Proveedor', 'Proveedor', NULL, NULL, NULL, '2016-09-20', '', 2016, '2016-11-15', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_servicios`
--

CREATE TABLE `tab_servicios` (
  `id_servicio` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_clasificacion` bigint(255) UNSIGNED NOT NULL,
  `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_subcategoria` bigint(20) UNSIGNED NOT NULL,
  `id_servicio_unidad` bigint(20) UNSIGNED NOT NULL,
  `nombre_servicio` varchar(255) NOT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_servicios`
--

INSERT INTO `tab_servicios` (`id_servicio`, `id_servicio_clasificacion`, `id_servicio_categoria`, `id_servicio_subcategoria`, `id_servicio_unidad`, `nombre_servicio`, `active`) VALUES
(1, 1, 3, 1, 1, 'Comercial en cine 120 Seg.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tab_sujetos_obligados`
--

CREATE TABLE `tab_sujetos_obligados` (
  `id_sujeto_obligado` bigint(20) UNSIGNED NOT NULL,
  `id_so_atribucion` bigint(20) UNSIGNED NOT NULL,
  `id_so_orden_gobierno` bigint(20) UNSIGNED NOT NULL,
  `id_so_estado` bigint(20) UNSIGNED NOT NULL,
  `nombre_sujeto_obligado` varchar(255) NOT NULL,
  `siglas_sujeto_obligado` varchar(50) DEFAULT NULL,
  `url_sujeto_obligado` varchar(255) DEFAULT NULL,
  `active` bigint(20) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tab_sujetos_obligados`
--

INSERT INTO `tab_sujetos_obligados` (`id_sujeto_obligado`, `id_so_atribucion`, `id_so_orden_gobierno`, `id_so_estado`, `nombre_sujeto_obligado`, `siglas_sujeto_obligado`, `url_sujeto_obligado`, `active`) VALUES
(1, 3, 1, 33, 'Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales', 'INAI', 'http://www.inai.org.mx', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_campana_aviso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_campana_aviso` (
`id_campana_aviso` bigint(20) unsigned
,`id_campana_cobertura` bigint(20) unsigned
,`id_campana_tipo` bigint(20) unsigned
,`id_campana_subtipo` bigint(20) unsigned
,`id_campana_tema` bigint(20) unsigned
,`id_campana_objetivo` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`id_tiempo_oficial` bigint(20) unsigned
,`nombre_campana_aviso` varchar(255)
,`objetivo_comunicacion` text
,`fecha_inicio` date
,`fecha_termino` date
,`fecha_inicio_to` date
,`fecha_termino_to` date
,`publicacion_segob` varchar(255)
,`campana_ambito_geo` varchar(50)
,`plan_acs` varchar(255)
,`fecha_dof` date
,`evaluacion` text
,`active` bigint(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_contratos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_contratos` (
`id_contrato` bigint(20) unsigned
,`id_procedimiento` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`numero_contrato` varchar(50)
,`objeto_contrato` text
,`descripcion_justificacion` text
,`fundamento_juridico` text
,`fecha_celebracion` date
,`fecha_inicio` date
,`fecha_fin` date
,`monto_contrato` decimal(15,2) unsigned
,`file_contrato` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_convenios_modificatorios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_convenios_modificatorios` (
`id_convenio_modificatorio` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`numero_convenio` varchar(255)
,`objeto_convenio` text
,`fundamento_juridico` text
,`fecha_celebracion` date
,`monto_convenio` decimal(15,2)
,`file_convenio` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_ejercicios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_ejercicios` (
`id_ejercicio` bigint(20) unsigned
,`ejercicio` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_facturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_facturas` (
`id_factura` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_orden_compra` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20)
,`id_presupuesto_concepto` bigint(20)
,`numero_factura` varchar(50)
,`fecha_erogacion` date
,`file_factura_pdf` varchar(255)
,`file_factura_xml` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_facturas_desglose`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_facturas_desglose` (
`id_factura_desglose` bigint(20) unsigned
,`id_factura` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`id_servicio_clasificacion` bigint(20) unsigned
,`id_servicio_categoria` bigint(20) unsigned
,`id_servicio_subcategoria` bigint(20) unsigned
,`id_servicio_unidad` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`numero_partida` bigint(20) unsigned
,`descripcion_servicios` text
,`cantidad` decimal(15,2)
,`precio_unitarios` decimal(15,2) unsigned
,`monto_desglose` decimal(15,2) unsigned
,`area_administrativa` varchar(255)
,`fecha_validacion` date
,`area_responsable` varchar(255)
,`periodo` int(11)
,`fecha_actualizacion` date
,`nota` text
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_facturas_desglose_v2`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_facturas_desglose_v2` (
`id_factura_desglose` bigint(20) unsigned
,`id_factura` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`id_servicio_clasificacion` bigint(20) unsigned
,`id_servicio_categoria` bigint(20) unsigned
,`id_servicio_subcategoria` bigint(20) unsigned
,`id_servicio_unidad` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_presupuesto_concepto` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`id_presupuesto_concepto_solicitante` bigint(20) unsigned
,`numero_partida` bigint(20) unsigned
,`descripcion_servicios` text
,`cantidad` decimal(15,2)
,`precio_unitarios` decimal(15,2) unsigned
,`monto_desglose` decimal(15,2) unsigned
,`area_administrativa` varchar(255)
,`fecha_validacion` date
,`area_responsable` varchar(255)
,`periodo` int(11)
,`fecha_actualizacion` date
,`nota` text
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_ordenes_compra`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_ordenes_compra` (
`id_orden_compra` bigint(20) unsigned
,`id_procedimiento` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`numero_orden_compra` varchar(255)
,`descripcion_justificacion` text
,`fecha_orden` date
,`file_orden` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_ordenes_compra_montos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_ordenes_compra_montos` (
`id_orden_compra` bigint(20) unsigned
,`id_procedimiento` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`numero_orden_compra` varchar(255)
,`descripcion_justificacion` text
,`fecha_orden` date
,`file_orden` varchar(255)
,`active` bigint(20) unsigned
,`monto` decimal(59,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_presupuestos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_presupuestos` (
`id_presupuesto` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_sujeto_obligado` bigint(20) unsigned
,`file_programa_anual` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_presupuestos_desglose`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_presupuestos_desglose` (
`id_presupuesto_desglose` bigint(20) unsigned
,`id_presupuesto` bigint(20) unsigned
,`id_presupuesto_concepto` bigint(20) unsigned
,`monto_presupuesto` decimal(15,2) unsigned
,`monto_modificacion` decimal(15,2)
,`active` double unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_presupuesto_conceptos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_presupuesto_conceptos` (
`id_presupesto_concepto` bigint(20) unsigned
,`capitulo` varchar(7)
,`concepto` varchar(7)
,`partida` varchar(7)
,`denominacion` varchar(255)
,`descripcion` mediumtext
,`id_captura` bigint(20)
,`active` bigint(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_proveedores` (
`id_proveedor` bigint(20) unsigned
,`id_personalidad_juridica` bigint(20) unsigned
,`nombre_razon_social` varchar(255)
,`nombre_comercial` varchar(255)
,`rfc` varchar(30)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_servicios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_servicios` (
`id_servicio` bigint(20) unsigned
,`id_servicio_clasificacion` bigint(255) unsigned
,`id_servicio_categoria` bigint(20) unsigned
,`id_servicio_subcategoria` bigint(20) unsigned
,`id_servicio_unidad` bigint(20) unsigned
,`nombre_servicio` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vact_sujetos_obligados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vact_sujetos_obligados` (
`id_sujeto_obligado` bigint(20) unsigned
,`id_so_atribucion` bigint(20) unsigned
,`id_so_orden_gobierno` bigint(20) unsigned
,`id_so_estado` bigint(20) unsigned
,`nombre_sujeto_obligado` varchar(255)
,`siglas_sujeto_obligado` varchar(50)
,`url_sujeto_obligado` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcampanasyavisos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcampanasyavisos` (
`id_campana_tipo` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`ejercicio` varchar(255)
,`trimestre` varchar(255)
,`nombre_campana_tipo` varchar(255)
,`nombre_campana_aviso` varchar(255)
,`contratante` varchar(255)
,`solicitante` varchar(255)
,`nombre_tipo_tiempo` varchar(255)
,`monto_total` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcapitulo_denominacion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcapitulo_denominacion` (
`id_presupesto_concepto` bigint(20) unsigned
,`capitulo` varchar(7)
,`concepto` varchar(7)
,`partida` varchar(7)
,`denominacion` varchar(255)
,`descripcion` mediumtext
,`id_captura` bigint(20)
,`active` bigint(20)
,`capitulo_denominacion` varchar(285)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcap_conceptos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcap_conceptos` (
`id_presupesto_concepto` bigint(20) unsigned
,`capitulo` varchar(7)
,`concepto` varchar(7)
,`partida` varchar(7)
,`denominacion` varchar(255)
,`descripcion` mediumtext
,`id_captura` bigint(20)
,`active` bigint(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcat_categorias`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcat_categorias` (
`id_categoria` bigint(20) unsigned
,`id_clasificacion` bigint(20) unsigned
,`nombre_categoria` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcat_conceptos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcat_conceptos` (
`id_presupesto_concepto` bigint(20) unsigned
,`capitulo` varchar(7)
,`concepto` varchar(7)
,`partida` varchar(7)
,`denominacion` varchar(255)
,`descripcion` mediumtext
,`id_captura` bigint(20)
,`active` bigint(20)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcontratos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcontratos` (
`id_contrato` bigint(20) unsigned
,`id_procedimiento` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`numero_contrato` varchar(50)
,`objeto_contrato` text
,`descripcion_justificacion` text
,`fundamento_juridico` text
,`fecha_celebracion` date
,`fecha_inicio` date
,`fecha_fin` date
,`monto_contrato` decimal(15,2) unsigned
,`file_contrato` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcontratosyordenes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcontratosyordenes` (
`id_contrato` bigint(20) unsigned
,`id_orden_compra` bigint(20) unsigned
,`ejercicio` varchar(255)
,`trimestre` varchar(255)
,`numero_contrato` varchar(50)
,`numero_orden_compra` varchar(255)
,`contratante` varchar(255)
,`solicitante` varchar(255)
,`proveedor` varchar(255)
,`monto_contrato` decimal(15,2) unsigned
,`monto_ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcont_x_anio_x_prov`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcont_x_anio_x_prov` (
`id_proveedor` bigint(20) unsigned
,`nombre_razon_social` varchar(255)
,`count_contratos` bigint(21)
,`cont_anio` int(4)
,`sum_contratos` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vfacturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vfacturas` (
`id_factura` bigint(20) unsigned
,`ejercicio` varchar(255)
,`trimestre` varchar(255)
,`proveedor` varchar(255)
,`numero_factura` varchar(50)
,`fecha_erogacion` date
,`monto_ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vgasto_clasf_servicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vgasto_clasf_servicio` (
`id_servicio_clasificacion` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_orden_compra` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`id_factura` bigint(20) unsigned
,`ejercicio` varchar(255)
,`factura` varchar(50)
,`fecha_erogacion` date
,`proveedor` varchar(255)
,`nombre_servicio_clasificacion` varchar(255)
,`nombre_servicio_categoria` varchar(255)
,`nombre_servicio_subcategoria` varchar(255)
,`tipo` varchar(255)
,`nombre_campana_aviso` varchar(255)
,`monto_servicio` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vgrafica1`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vgrafica1` (
`ejercicio` int(4)
,`servicio` varchar(255)
,`campana` varchar(255)
,`partida` varchar(265)
,`ejercido` decimal(41,6)
,`tipo` varchar(255)
,`fecha` varchar(10)
,`proveedor` varchar(255)
,`campana_aviso` bigint(20) unsigned
,`presupuesto` decimal(63,6)
,`modificacion` decimal(64,6)
,`proveedores` decimal(24,4)
,`totalcampanas` decimal(24,4)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlimite`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlimite` (
`categoria` varchar(255)
,`tipo` varchar(17)
,`proveedor` varchar(255)
,`total` decimal(37,2)
,`numero` bigint(21)
,`ejercicio` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlimite_act`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlimite_act` (
`limite` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlinks_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlinks_proveedor` (
`tipo` varchar(17)
,`proveedor` varchar(255)
,`total` decimal(59,2)
,`numero` bigint(21)
,`ejercicio` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlinks_tipo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlinks_tipo` (
`categoria` varchar(255)
,`tipo` varchar(17)
,`total` decimal(59,2)
,`numero` bigint(21)
,`ejercicio` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlista_contratos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlista_contratos` (
`id_contrato` bigint(20) unsigned
,`ejercicio` varchar(255)
,`trimestre` varchar(255)
,`numero_contrato` varchar(50)
,`solicitante` varchar(255)
,`contratante` varchar(255)
,`proveedor` varchar(255)
,`monto_contrato` decimal(15,2) unsigned
,`monto_ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlista_facturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlista_facturas` (
`id_factura` bigint(20) unsigned
,`ejercicio` varchar(255)
,`contrato` varchar(50)
,`orden` varchar(255)
,`trimestre` varchar(255)
,`proveedor` varchar(255)
,`numero_factura` varchar(50)
,`fecha_erogacion` date
,`monto_factura` decimal(37,2)
,`active` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlista_oc`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlista_oc` (
`id_orden_compra` bigint(20) unsigned
,`ejercicio` varchar(255)
,`trimestre` varchar(255)
,`numero_orden_compra` varchar(255)
,`solicitante` varchar(255)
,`contratante` varchar(255)
,`proveedor` varchar(255)
,`monto_ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlista_por_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlista_por_proveedor` (
`ejercicio` varchar(255)
,`lista` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vmeses_porservicio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vmeses_porservicio` (
`ejercicio` varchar(255)
,`id_mes` bigint(20) unsigned
,`mes_corto` varchar(50)
,`nombre_servicio_categoria` varchar(30)
,`monto` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vmonto_campana`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vmonto_campana` (
`id_campana_aviso` bigint(20) unsigned
,`monto` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vmonto_oc`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vmonto_oc` (
`id_orden_compra` bigint(20) unsigned
,`monto` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `voc_monto_factura`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `voc_monto_factura` (
`id_orden_compra` bigint(20) unsigned
,`monto` varchar(87)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `voc_monto_factura_sf`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `voc_monto_factura_sf` (
`id_orden_compra` bigint(20) unsigned
,`monto` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vordenes_compra`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vordenes_compra` (
`id_orden_compra` bigint(20) unsigned
,`id_procedimiento` bigint(20) unsigned
,`id_proveedor` bigint(20) unsigned
,`id_contrato` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`id_trimestre` bigint(20) unsigned
,`id_so_contratante` bigint(20) unsigned
,`id_so_solicitante` bigint(20) unsigned
,`id_campana_aviso` bigint(20) unsigned
,`numero_orden_compra` varchar(255)
,`descripcion_justificacion` text
,`fecha_orden` date
,`file_orden` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_aviso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_aviso` (
`ID de campana o aviso institucional` bigint(20) unsigned
,`Campana o aviso institucional` varchar(255)
,`Subtipo` varchar(255)
,`Nombre` varchar(255)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Sujeto obligado contratant` varchar(255)
,`Sujeto obligado solicitante` varchar(255)
,`Tema` varchar(255)
,`Objetivo institucional` text
,`Objetivo de comunicación` text
,`Cobertura` varchar(255)
,`Ámbito geográfico` varchar(50)
,`Fecha inicio` date
,`Fecha término` date
,`Tiempo oficial` varchar(255)
,`Fecha inicio tiempo oficial` date
,`Fecha término tiempo oficial` date
,`Publicación SEGOB.` varchar(255)
,`Documento del PACS` varchar(255)
,`Fecha publicación` date
,`Evaluación` text
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_grupo_edad`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_grupo_edad` (
`ID de grupo de edad` bigint(20) unsigned
,`ID de campaña o aviso institucional` bigint(20) unsigned
,`Grupo de edad` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_lugar`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_lugar` (
`ID de lugar` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Lugar` varchar(250)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_maudio`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_maudio` (
`ID de audios` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Nombre Audio` varchar(255)
,`Audios (Vínculo al archivo)` varchar(255)
,`Audios (Vínculo al repositorio)` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_mimagenes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_mimagenes` (
`ID de imagenes` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Nombre Imagen` varchar(255)
,`Imagenes (Vínculo al archivo)` varchar(255)
,`Imagenes (Vínculo al repositorio)` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_mvideo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_mvideo` (
`ID de Videos` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Nombre Video` varchar(255)
,`Videos(Vínculo al archivo)` varchar(255)
,`Videos(Vínculo al repositorio)` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_nivel`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_nivel` (
`ID de nivel socioeconómico` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Nivel socioeconómico` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_nivel_educativo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_nivel_educativo` (
`ID de educación` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Educación` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_campana_sexo`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_campana_sexo` (
`ID de sexo` bigint(20) unsigned
,`ID de campana o aviso institucional` bigint(20) unsigned
,`Sexo` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_contratos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_contratos` (
`ID (Número de contrato)` varchar(50)
,`Procedimiento` varchar(255)
,`Proveedor` varchar(255)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Contratante` varchar(255)
,`Solicitante` varchar(255)
,`Objeto del contrato` text
,`Descripción` text
,`Fundamento jurídico` text
,`Fecha celebración` date
,`Fecha inicio` date
,`Fecha fin` date
,`Monto original del contrato` decimal(15,2) unsigned
,`Monto modificado` decimal(37,2)
,`Monto total` decimal(38,2)
,`Monto pagado a la fecha` decimal(37,2)
,`Archivo contrato en PDF (Vinculo al archivo)` varchar(255)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_convenios_modificatorios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_convenios_modificatorios` (
`ID (Número de convenio modificatorio)` varchar(255)
,`ID (Número de contrato)` varchar(50)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Objeto` text
,`Fundamento jurídico` text
,`Fecha celebración` date
,`Monto` decimal(15,2)
,`Archivo convenio en PDF (Vinculo al archivo)` varchar(255)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_facturas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_facturas` (
`ID Factura` varchar(50)
,`Proveedor` varchar(255)
,`Contrato` varchar(50)
,`Orden` varchar(255)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Sujeto obligado contratante` varchar(255)
,`Partida` varchar(7)
,`Monto` decimal(37,2)
,`Archivo factura en PDF (Vínculo al archivo)` varchar(255)
,`Archivo factura en XML (Vínculo al archivo)` varchar(255)
,`Fecha de erogación` date
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_facturas_desglose`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_facturas_desglose` (
`ID Detalle Factura` bigint(20) unsigned
,`ID Factura` varchar(50)
,`Campana o aviso institucional` varchar(255)
,`Nombre campana o aviso institucional` varchar(255)
,`Clasificación del servicio` varchar(255)
,`Categoría del servicio` varchar(255)
,`Subcategoría del servicio` varchar(255)
,`Unidad` varchar(255)
,`Sujeto obligado solicitante` varchar(255)
,`Área administrativa solicitante` varchar(255)
,`Descripción del servicio o producto adquirido` text
,`Cantidad` decimal(15,2)
,`Precio unitario con I.V.A incluido` decimal(15,2) unsigned
,`Monto` decimal(15,2) unsigned
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_facturas_desglose_v2`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_facturas_desglose_v2` (
`ID Detalle Factura` bigint(20) unsigned
,`ID Factura` varchar(50)
,`Campana o aviso institucional` varchar(255)
,`Nombre campana o aviso institucional` varchar(255)
,`Clasificación del servicio` varchar(255)
,`Categoría del servicio` varchar(255)
,`Subcategoría del servicio` varchar(255)
,`Unidad` varchar(255)
,`Sujeto obligado contratante` varchar(255)
,`Partida contratante` varchar(7)
,`Sujeto obligado solicitante` varchar(255)
,`Partida solicitante` varchar(7)
,`Área administrativa solicitante` varchar(255)
,`Descripción del servicio o producto adquirido` text
,`Cantidad` decimal(15,2)
,`Precio unitario con I.V.A incluido` decimal(15,2) unsigned
,`Monto` decimal(15,2) unsigned
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_gasto_x_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_gasto_x_proveedor` (
`ID de proveedor` bigint(20) unsigned
,`Personalidad jurídica` varchar(255)
,`Nombre o razón social` varchar(255)
,`Nombre comercial` varchar(255)
,`R.F.C.` varchar(30)
,`Monto total pagado` decimal(37,2)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_oc_x_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_oc_x_proveedor` (
`ID (Orden de compra)` varchar(255)
,`ID de proveedor` bigint(20) unsigned
,`Nombre Proveedor` varchar(255)
,`Procedimiento` varchar(255)
,`ID (Número de contrato)` varchar(50)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Sujeto obligado ordenante` varchar(255)
,`Campana o aviso institucional` varchar(255)
,`Sujeto obligado solicitante` varchar(255)
,`Justificación` text
,`Fecha de orden` date
,`Archivo de la orden de compra en PDF` varchar(255)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_ordenes_compra`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_ordenes_compra` (
`ID_Orden_de_compra)` varchar(255)
,`Proveedor` varchar(255)
,`Procedimiento` varchar(255)
,`Contrato` varchar(50)
,`Ejercicio` varchar(255)
,`Trimestre` varchar(255)
,`Sujeto_obligado_ordenante` varchar(255)
,`Campana o aviso institucional` varchar(255)
,`Sujeto obligado solicitante` varchar(255)
,`numero_orden_de_compra` varchar(255)
,`Justificación` text
,`Fecha_de_orden` date
,`Archivo_de_la_orden_de_compra_en_PDF_(Vínculo_al_documento)` varchar(255)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_presupuestos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_presupuestos` (
`ID de presupuesto` bigint(20) unsigned
,`Ejercicio` varchar(255)
,`Sujeto obligado` varchar(255)
,`Presupuesto original` decimal(37,2)
,`Monto modificado` decimal(37,2)
,`Presupuesto modificado` decimal(38,2)
,`Presupuesto ejercido` decimal(37,2)
,`Programa Anual` varchar(255)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_presupuestos_desglose`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_presupuestos_desglose` (
`ID de desglose` bigint(20) unsigned
,`ID de presupuesto` bigint(20) unsigned
,`Partida presupuestal` varchar(7)
,`Monto asignado` decimal(15,2) unsigned
,`Monto de modificación` decimal(15,2)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_presupuestos_desglose_descarga`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_presupuestos_desglose_descarga` (
`ID de desglose` bigint(20) unsigned
,`ID de presupuesto` bigint(20) unsigned
,`Partida presupuestal` varchar(7)
,`fuente_federal` text
,`monto_fuente_federal` decimal(15,2)
,`fuente_local` text
,`monto_fuente_local` decimal(15,2)
,`fecha_validacion` date
,`area_responsable` varchar(255)
,`fecha_actualizacion` date
,`nota` text
,`periodo` int(11)
,`Monto asignado` decimal(15,2) unsigned
,`Monto de modificación` decimal(15,2)
,`Estatus` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_proveedores` (
`ID` bigint(20) unsigned
,`Personalidad jurídica` varchar(255)
,`Nombre o razón social` varchar(255)
,`Nombre comercial` varchar(255)
,`R.F.C.` varchar(30)
,`Estatus` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vout_sujetos_obligados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vout_sujetos_obligados` (
`ID de S.O.` bigint(20) unsigned
,`Función` varchar(255)
,`Orden (Federal, Estatal, Municipal)` varchar(255)
,`Estado` varchar(255)
,`Nombre` varchar(255)
,`Siglas` varchar(50)
,`URL de página` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vpor_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vpor_proveedor` (
`categoria` varchar(255)
,`tipo` varchar(17)
,`proveedor` varchar(255)
,`total` decimal(37,2)
,`numero` bigint(21)
,`ejercicio` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vpregrafica1`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vpregrafica1` (
`ejercicio` int(4)
,`servicio` varchar(255)
,`campana` varchar(255)
,`partida` varchar(265)
,`ejercido` decimal(37,2)
,`tipo` varchar(255)
,`fecha` varchar(10)
,`proveedor` varchar(255)
,`campana_aviso` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vso_actual`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vso_actual` (
`id_user` bigint(20) unsigned
,`username` varchar(30)
,`password` varchar(50)
,`cookie_id` varchar(64)
,`token` varchar(128)
,`email` varchar(50)
,`fname` varchar(50)
,`lname` varchar(50)
,`public_office` varchar(255)
,`phone` varchar(50)
,`created` datetime
,`lastlogin` datetime
,`lastip` varchar(16)
,`notes` text
,`record_user` bigint(20) unsigned
,`last_update` date
,`active` varchar(1)
,`id_sujeto_obligado` bigint(20) unsigned
,`id_so_atribucion` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vso_contratante`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vso_contratante` (
`id_sujeto_obligado` bigint(20) unsigned
,`id_so_atribucion` bigint(20) unsigned
,`id_so_orden_gobierno` bigint(20) unsigned
,`id_so_estado` bigint(20) unsigned
,`nombre_sujeto_obligado` varchar(255)
,`siglas_sujeto_obligado` varchar(50)
,`url_sujeto_obligado` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vso_solicitante`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vso_solicitante` (
`id_sujeto_obligado` bigint(20) unsigned
,`id_so_atribucion` bigint(20) unsigned
,`id_so_orden_gobierno` bigint(20) unsigned
,`id_so_estado` bigint(20) unsigned
,`nombre_sujeto_obligado` varchar(255)
,`siglas_sujeto_obligado` varchar(50)
,`url_sujeto_obligado` varchar(255)
,`active` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vsujetosobligados`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vsujetosobligados` (
`id_sujeto_obligado` bigint(20) unsigned
,`ejercicio` varchar(255)
,`funcion` varchar(255)
,`orden` varchar(255)
,`estado` varchar(255)
,`nombre` varchar(255)
,`siglas` varchar(50)
,`URL` varchar(255)
,`monto_total` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtable1`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtable1` (
`Clave de partida` varchar(23)
,`Descripción` mediumtext
,`Ejercicio` varchar(255)
,`Prespuesto Original` decimal(37,2)
,`Monto Modificado` decimal(37,2)
,`Presupuesto Modificado` decimal(38,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtable2`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtable2` (
`id_proveedor` bigint(20) unsigned
,`Nombre o razón social` varchar(255)
,`Contratos` bigint(21)
,`Órdenes de compra sin contrato` bigint(21)
,`Monto total pagado` decimal(37,2)
,`Ejercicio` varchar(255)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_contratos_oc`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_contratos_oc` (
`numero_contrato` varchar(50)
,`numero_orden_compra` varchar(255)
,`tipo` varchar(255)
,`nombre` varchar(255)
,`anio` varchar(255)
,`monto_presupuesto` decimal(35,0)
,`id_contrato` bigint(20) unsigned
,`id_orden_compra` bigint(20) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_presupuesto`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_presupuesto` (
`partida` varchar(7)
,`descripcion` varchar(255)
,`ejercicio` varchar(255)
,`original` decimal(37,2)
,`modificaciones` decimal(37,2)
,`presupuesto` decimal(38,2)
,`ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_presupuesto_des`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_presupuesto_des` (
`ejercicio` varchar(255)
,`partida` varchar(7)
,`descripcion` varchar(255)
,`original` decimal(37,2)
,`modificaciones` decimal(37,2)
,`presupuesto` decimal(38,2)
,`ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_presupuesto_desglose`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_presupuesto_desglose` (
`ejercicio` varchar(255)
,`partida` varchar(7)
,`descripcion` varchar(255)
,`original` decimal(37,2)
,`modificaciones` decimal(37,2)
,`presupuesto` decimal(38,2)
,`ejercido` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_presupuesto_PACS`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_presupuesto_PACS` (
`id_presupuesto` bigint(20) unsigned
,`id_ejercicio` bigint(20) unsigned
,`denominacion` text
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtab_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtab_proveedores` (
`id_proveedor` bigint(20) unsigned
,`ejercicio` varchar(255)
,`nombre` varchar(255)
,`contratos` bigint(21)
,`ordenes` bigint(21)
,`monto` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtipo_campana_proveedor`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtipo_campana_proveedor` (
`id_campana_aviso` bigint(20) unsigned
,`campana_aviso` text
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtop10_campanas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtop10_campanas` (
`id_campana_aviso` bigint(20) unsigned
,`sum(a.monto_desglose)` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vtop10_proveedores`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vtop10_proveedores` (
`id_proveedor` bigint(20) unsigned
,`sum(a.monto_desglose)` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_campana_aviso`
--
DROP VIEW IF EXISTS `vact_campana_aviso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_campana_aviso`  AS  select `tab_campana_aviso`.`id_campana_aviso` AS `id_campana_aviso`,`tab_campana_aviso`.`id_campana_cobertura` AS `id_campana_cobertura`,`tab_campana_aviso`.`id_campana_tipo` AS `id_campana_tipo`,`tab_campana_aviso`.`id_campana_subtipo` AS `id_campana_subtipo`,`tab_campana_aviso`.`id_campana_tema` AS `id_campana_tema`,`tab_campana_aviso`.`id_campana_objetivo` AS `id_campana_objetivo`,`tab_campana_aviso`.`id_ejercicio` AS `id_ejercicio`,`tab_campana_aviso`.`id_trimestre` AS `id_trimestre`,`tab_campana_aviso`.`id_so_contratante` AS `id_so_contratante`,`tab_campana_aviso`.`id_so_solicitante` AS `id_so_solicitante`,`tab_campana_aviso`.`id_tiempo_oficial` AS `id_tiempo_oficial`,`tab_campana_aviso`.`nombre_campana_aviso` AS `nombre_campana_aviso`,`tab_campana_aviso`.`objetivo_comunicacion` AS `objetivo_comunicacion`,`tab_campana_aviso`.`fecha_inicio` AS `fecha_inicio`,`tab_campana_aviso`.`fecha_termino` AS `fecha_termino`,`tab_campana_aviso`.`fecha_inicio_to` AS `fecha_inicio_to`,`tab_campana_aviso`.`fecha_termino_to` AS `fecha_termino_to`,`tab_campana_aviso`.`publicacion_segob` AS `publicacion_segob`,`tab_campana_aviso`.`campana_ambito_geo` AS `campana_ambito_geo`,`tab_campana_aviso`.`plan_acs` AS `plan_acs`,`tab_campana_aviso`.`fecha_dof` AS `fecha_dof`,`tab_campana_aviso`.`evaluacion` AS `evaluacion`,`tab_campana_aviso`.`active` AS `active` from `tab_campana_aviso` where (`tab_campana_aviso`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_contratos`
--
DROP VIEW IF EXISTS `vact_contratos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_contratos`  AS  select `tab_contratos`.`id_contrato` AS `id_contrato`,`tab_contratos`.`id_procedimiento` AS `id_procedimiento`,`tab_contratos`.`id_proveedor` AS `id_proveedor`,`tab_contratos`.`id_ejercicio` AS `id_ejercicio`,`tab_contratos`.`id_trimestre` AS `id_trimestre`,`tab_contratos`.`id_so_contratante` AS `id_so_contratante`,`tab_contratos`.`id_so_solicitante` AS `id_so_solicitante`,`tab_contratos`.`numero_contrato` AS `numero_contrato`,`tab_contratos`.`objeto_contrato` AS `objeto_contrato`,`tab_contratos`.`descripcion_justificacion` AS `descripcion_justificacion`,`tab_contratos`.`fundamento_juridico` AS `fundamento_juridico`,`tab_contratos`.`fecha_celebracion` AS `fecha_celebracion`,`tab_contratos`.`fecha_inicio` AS `fecha_inicio`,`tab_contratos`.`fecha_fin` AS `fecha_fin`,`tab_contratos`.`monto_contrato` AS `monto_contrato`,`tab_contratos`.`file_contrato` AS `file_contrato`,`tab_contratos`.`active` AS `active` from `tab_contratos` where (`tab_contratos`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_convenios_modificatorios`
--
DROP VIEW IF EXISTS `vact_convenios_modificatorios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_convenios_modificatorios`  AS  select `tab_convenios_modificatorios`.`id_convenio_modificatorio` AS `id_convenio_modificatorio`,`tab_convenios_modificatorios`.`id_contrato` AS `id_contrato`,`tab_convenios_modificatorios`.`id_ejercicio` AS `id_ejercicio`,`tab_convenios_modificatorios`.`id_trimestre` AS `id_trimestre`,`tab_convenios_modificatorios`.`numero_convenio` AS `numero_convenio`,`tab_convenios_modificatorios`.`objeto_convenio` AS `objeto_convenio`,`tab_convenios_modificatorios`.`fundamento_juridico` AS `fundamento_juridico`,`tab_convenios_modificatorios`.`fecha_celebracion` AS `fecha_celebracion`,`tab_convenios_modificatorios`.`monto_convenio` AS `monto_convenio`,`tab_convenios_modificatorios`.`file_convenio` AS `file_convenio`,`tab_convenios_modificatorios`.`active` AS `active` from `tab_convenios_modificatorios` where (`tab_convenios_modificatorios`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_ejercicios`
--
DROP VIEW IF EXISTS `vact_ejercicios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_ejercicios`  AS  select `cat_ejercicios`.`id_ejercicio` AS `id_ejercicio`,`cat_ejercicios`.`ejercicio` AS `ejercicio`,`cat_ejercicios`.`active` AS `active` from `cat_ejercicios` where (`cat_ejercicios`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_facturas`
--
DROP VIEW IF EXISTS `vact_facturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_facturas`  AS  select `tab_facturas`.`id_factura` AS `id_factura`,`tab_facturas`.`id_proveedor` AS `id_proveedor`,`tab_facturas`.`id_contrato` AS `id_contrato`,`tab_facturas`.`id_orden_compra` AS `id_orden_compra`,`tab_facturas`.`id_ejercicio` AS `id_ejercicio`,`tab_facturas`.`id_trimestre` AS `id_trimestre`,`tab_facturas`.`id_so_contratante` AS `id_so_contratante`,`tab_facturas`.`id_presupuesto_concepto` AS `id_presupuesto_concepto`,`tab_facturas`.`numero_factura` AS `numero_factura`,`tab_facturas`.`fecha_erogacion` AS `fecha_erogacion`,`tab_facturas`.`file_factura_pdf` AS `file_factura_pdf`,`tab_facturas`.`file_factura_xml` AS `file_factura_xml`,`tab_facturas`.`active` AS `active` from `tab_facturas` where (`tab_facturas`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_facturas_desglose`
--
DROP VIEW IF EXISTS `vact_facturas_desglose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_facturas_desglose`  AS  select `tab_facturas_desglose`.`id_factura_desglose` AS `id_factura_desglose`,`tab_facturas_desglose`.`id_factura` AS `id_factura`,`tab_facturas_desglose`.`id_campana_aviso` AS `id_campana_aviso`,`tab_facturas_desglose`.`id_servicio_clasificacion` AS `id_servicio_clasificacion`,`tab_facturas_desglose`.`id_servicio_categoria` AS `id_servicio_categoria`,`tab_facturas_desglose`.`id_servicio_subcategoria` AS `id_servicio_subcategoria`,`tab_facturas_desglose`.`id_servicio_unidad` AS `id_servicio_unidad`,`tab_facturas_desglose`.`id_so_solicitante` AS `id_so_solicitante`,`tab_facturas_desglose`.`numero_partida` AS `numero_partida`,`tab_facturas_desglose`.`descripcion_servicios` AS `descripcion_servicios`,`tab_facturas_desglose`.`cantidad` AS `cantidad`,`tab_facturas_desglose`.`precio_unitarios` AS `precio_unitarios`,`tab_facturas_desglose`.`monto_desglose` AS `monto_desglose`,`tab_facturas_desglose`.`area_administrativa` AS `area_administrativa`,`tab_facturas_desglose`.`fecha_validacion` AS `fecha_validacion`,`tab_facturas_desglose`.`area_responsable` AS `area_responsable`,`tab_facturas_desglose`.`periodo` AS `periodo`,`tab_facturas_desglose`.`fecha_actualizacion` AS `fecha_actualizacion`,`tab_facturas_desglose`.`nota` AS `nota`,`tab_facturas_desglose`.`active` AS `active` from `tab_facturas_desglose` where (`tab_facturas_desglose`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_facturas_desglose_v2`
--
DROP VIEW IF EXISTS `vact_facturas_desglose_v2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_facturas_desglose_v2`  AS  select `tab_facturas_desglose`.`id_factura_desglose` AS `id_factura_desglose`,`tab_facturas_desglose`.`id_factura` AS `id_factura`,`tab_facturas_desglose`.`id_campana_aviso` AS `id_campana_aviso`,`tab_facturas_desglose`.`id_servicio_clasificacion` AS `id_servicio_clasificacion`,`tab_facturas_desglose`.`id_servicio_categoria` AS `id_servicio_categoria`,`tab_facturas_desglose`.`id_servicio_subcategoria` AS `id_servicio_subcategoria`,`tab_facturas_desglose`.`id_servicio_unidad` AS `id_servicio_unidad`,`tab_facturas_desglose`.`id_so_contratante` AS `id_so_contratante`,`tab_facturas_desglose`.`id_presupuesto_concepto` AS `id_presupuesto_concepto`,`tab_facturas_desglose`.`id_so_solicitante` AS `id_so_solicitante`,`tab_facturas_desglose`.`id_presupuesto_concepto_solicitante` AS `id_presupuesto_concepto_solicitante`,`tab_facturas_desglose`.`numero_partida` AS `numero_partida`,`tab_facturas_desglose`.`descripcion_servicios` AS `descripcion_servicios`,`tab_facturas_desglose`.`cantidad` AS `cantidad`,`tab_facturas_desglose`.`precio_unitarios` AS `precio_unitarios`,`tab_facturas_desglose`.`monto_desglose` AS `monto_desglose`,`tab_facturas_desglose`.`area_administrativa` AS `area_administrativa`,`tab_facturas_desglose`.`fecha_validacion` AS `fecha_validacion`,`tab_facturas_desglose`.`area_responsable` AS `area_responsable`,`tab_facturas_desglose`.`periodo` AS `periodo`,`tab_facturas_desglose`.`fecha_actualizacion` AS `fecha_actualizacion`,`tab_facturas_desglose`.`nota` AS `nota`,`tab_facturas_desglose`.`active` AS `active` from `tab_facturas_desglose` where (`tab_facturas_desglose`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_ordenes_compra`
--
DROP VIEW IF EXISTS `vact_ordenes_compra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_ordenes_compra`  AS  select `tab_ordenes_compra`.`id_orden_compra` AS `id_orden_compra`,`tab_ordenes_compra`.`id_procedimiento` AS `id_procedimiento`,`tab_ordenes_compra`.`id_proveedor` AS `id_proveedor`,`tab_ordenes_compra`.`id_contrato` AS `id_contrato`,`tab_ordenes_compra`.`id_ejercicio` AS `id_ejercicio`,`tab_ordenes_compra`.`id_trimestre` AS `id_trimestre`,`tab_ordenes_compra`.`id_so_contratante` AS `id_so_contratante`,`tab_ordenes_compra`.`id_so_solicitante` AS `id_so_solicitante`,`tab_ordenes_compra`.`id_campana_aviso` AS `id_campana_aviso`,`tab_ordenes_compra`.`numero_orden_compra` AS `numero_orden_compra`,`tab_ordenes_compra`.`descripcion_justificacion` AS `descripcion_justificacion`,`tab_ordenes_compra`.`fecha_orden` AS `fecha_orden`,`tab_ordenes_compra`.`file_orden` AS `file_orden`,`tab_ordenes_compra`.`active` AS `active` from `tab_ordenes_compra` where (`tab_ordenes_compra`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_ordenes_compra_montos`
--
DROP VIEW IF EXISTS `vact_ordenes_compra_montos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_ordenes_compra_montos`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,`a`.`id_procedimiento` AS `id_procedimiento`,`a`.`id_proveedor` AS `id_proveedor`,`a`.`id_contrato` AS `id_contrato`,`a`.`id_ejercicio` AS `id_ejercicio`,`a`.`id_trimestre` AS `id_trimestre`,`a`.`id_so_contratante` AS `id_so_contratante`,`a`.`id_so_solicitante` AS `id_so_solicitante`,`a`.`id_campana_aviso` AS `id_campana_aviso`,`a`.`numero_orden_compra` AS `numero_orden_compra`,`a`.`descripcion_justificacion` AS `descripcion_justificacion`,`a`.`fecha_orden` AS `fecha_orden`,`a`.`file_orden` AS `file_orden`,`a`.`active` AS `active`,(select ifnull(sum(`b`.`monto`),0) from `voc_monto_factura_sf` `b` where (`a`.`id_orden_compra` = `b`.`id_orden_compra`)) AS `monto` from `vact_ordenes_compra` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_presupuestos`
--
DROP VIEW IF EXISTS `vact_presupuestos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_presupuestos`  AS  select `tab_presupuestos`.`id_presupuesto` AS `id_presupuesto`,`tab_presupuestos`.`id_ejercicio` AS `id_ejercicio`,`tab_presupuestos`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`tab_presupuestos`.`file_programa_anual` AS `file_programa_anual`,`tab_presupuestos`.`active` AS `active` from `tab_presupuestos` where (`tab_presupuestos`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_presupuestos_desglose`
--
DROP VIEW IF EXISTS `vact_presupuestos_desglose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_presupuestos_desglose`  AS  select `tab_presupuestos_desglose`.`id_presupuesto_desglose` AS `id_presupuesto_desglose`,`tab_presupuestos_desglose`.`id_presupuesto` AS `id_presupuesto`,`tab_presupuestos_desglose`.`id_presupuesto_concepto` AS `id_presupuesto_concepto`,`tab_presupuestos_desglose`.`monto_presupuesto` AS `monto_presupuesto`,`tab_presupuestos_desglose`.`monto_modificacion` AS `monto_modificacion`,`tab_presupuestos_desglose`.`active` AS `active` from `tab_presupuestos_desglose` where (`tab_presupuestos_desglose`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_presupuesto_conceptos`
--
DROP VIEW IF EXISTS `vact_presupuesto_conceptos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_presupuesto_conceptos`  AS  select `cat_presupuesto_conceptos`.`id_presupesto_concepto` AS `id_presupesto_concepto`,`cat_presupuesto_conceptos`.`capitulo` AS `capitulo`,`cat_presupuesto_conceptos`.`concepto` AS `concepto`,`cat_presupuesto_conceptos`.`partida` AS `partida`,`cat_presupuesto_conceptos`.`denominacion` AS `denominacion`,`cat_presupuesto_conceptos`.`descripcion` AS `descripcion`,`cat_presupuesto_conceptos`.`id_captura` AS `id_captura`,`cat_presupuesto_conceptos`.`active` AS `active` from `cat_presupuesto_conceptos` where ((`cat_presupuesto_conceptos`.`concepto` <> '') and (`cat_presupuesto_conceptos`.`partida` <> '')) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_proveedores`
--
DROP VIEW IF EXISTS `vact_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_proveedores`  AS  select `tab_proveedores`.`id_proveedor` AS `id_proveedor`,`tab_proveedores`.`id_personalidad_juridica` AS `id_personalidad_juridica`,`tab_proveedores`.`nombre_razon_social` AS `nombre_razon_social`,`tab_proveedores`.`nombre_comercial` AS `nombre_comercial`,`tab_proveedores`.`rfc` AS `rfc`,`tab_proveedores`.`active` AS `active` from `tab_proveedores` where (`tab_proveedores`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_servicios`
--
DROP VIEW IF EXISTS `vact_servicios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_servicios`  AS  select `tab_servicios`.`id_servicio` AS `id_servicio`,`tab_servicios`.`id_servicio_clasificacion` AS `id_servicio_clasificacion`,`tab_servicios`.`id_servicio_categoria` AS `id_servicio_categoria`,`tab_servicios`.`id_servicio_subcategoria` AS `id_servicio_subcategoria`,`tab_servicios`.`id_servicio_unidad` AS `id_servicio_unidad`,`tab_servicios`.`nombre_servicio` AS `nombre_servicio`,`tab_servicios`.`active` AS `active` from `tab_servicios` where (`tab_servicios`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vact_sujetos_obligados`
--
DROP VIEW IF EXISTS `vact_sujetos_obligados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vact_sujetos_obligados`  AS  select `tab_sujetos_obligados`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`tab_sujetos_obligados`.`id_so_atribucion` AS `id_so_atribucion`,`tab_sujetos_obligados`.`id_so_orden_gobierno` AS `id_so_orden_gobierno`,`tab_sujetos_obligados`.`id_so_estado` AS `id_so_estado`,`tab_sujetos_obligados`.`nombre_sujeto_obligado` AS `nombre_sujeto_obligado`,`tab_sujetos_obligados`.`siglas_sujeto_obligado` AS `siglas_sujeto_obligado`,`tab_sujetos_obligados`.`url_sujeto_obligado` AS `url_sujeto_obligado`,`tab_sujetos_obligados`.`active` AS `active` from `tab_sujetos_obligados` where (`tab_sujetos_obligados`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcampanasyavisos`
--
DROP VIEW IF EXISTS `vcampanasyavisos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcampanasyavisos`  AS  select `g`.`id_campana_tipo` AS `id_campana_tipo`,`g`.`id_campana_aviso` AS `id_campana_aviso`,`c`.`ejercicio` AS `ejercicio`,`d`.`trimestre` AS `trimestre`,`h`.`nombre_campana_tipo` AS `nombre_campana_tipo`,`g`.`nombre_campana_aviso` AS `nombre_campana_aviso`,`e`.`nombre_sujeto_obligado` AS `contratante`,`f`.`nombre_sujeto_obligado` AS `solicitante`,`i`.`nombre_tipo_tiempo` AS `nombre_tipo_tiempo`,(select ifnull(sum(`b`.`monto_desglose`),0) from (`vact_facturas` `a` join `vact_facturas_desglose` `b`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`b`.`id_campana_aviso` = `g`.`id_campana_aviso`))) AS `monto_total` from ((((((`vact_ejercicios` `c` join `cat_trimestres` `d`) join `vact_sujetos_obligados` `e`) join `vact_sujetos_obligados` `f`) join `vact_campana_aviso` `g`) join `cat_campana_tipos` `h`) join `cat_tiempo_tipos` `i`) where ((`g`.`id_campana_tipo` = `h`.`id_campana_tipo`) and (`g`.`id_tiempo_oficial` = `i`.`id_tiempo_tipo`) and (`g`.`id_ejercicio` = `c`.`id_ejercicio`) and (`g`.`id_trimestre` = `d`.`id_trimestre`) and (`g`.`id_so_contratante` = `e`.`id_sujeto_obligado`) and (`g`.`id_so_solicitante` = `f`.`id_sujeto_obligado`) and (`g`.`id_campana_aviso` = `g`.`id_campana_aviso`)) group by `c`.`ejercicio`,`d`.`trimestre`,`g`.`id_campana_tipo`,`g`.`nombre_campana_aviso`,`e`.`nombre_sujeto_obligado`,`f`.`nombre_sujeto_obligado`,`g`.`id_tiempo_oficial` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcapitulo_denominacion`
--
DROP VIEW IF EXISTS `vcapitulo_denominacion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcapitulo_denominacion`  AS  select `a`.`id_presupesto_concepto` AS `id_presupesto_concepto`,`a`.`capitulo` AS `capitulo`,`a`.`concepto` AS `concepto`,`a`.`partida` AS `partida`,`a`.`denominacion` AS `denominacion`,`a`.`descripcion` AS `descripcion`,`a`.`id_captura` AS `id_captura`,`a`.`active` AS `active`,concat_ws(' - ',`a`.`capitulo`,`a`.`concepto`,`a`.`partida`,`a`.`denominacion`) AS `capitulo_denominacion` from `vact_presupuesto_conceptos` `a` where (`a`.`active` = 1) order by `a`.`id_presupesto_concepto` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcap_conceptos`
--
DROP VIEW IF EXISTS `vcap_conceptos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcap_conceptos`  AS  select `vcat_conceptos`.`id_presupesto_concepto` AS `id_presupesto_concepto`,`vcat_conceptos`.`capitulo` AS `capitulo`,`vcat_conceptos`.`concepto` AS `concepto`,`vcat_conceptos`.`partida` AS `partida`,`vcat_conceptos`.`denominacion` AS `denominacion`,`vcat_conceptos`.`descripcion` AS `descripcion`,`vcat_conceptos`.`id_captura` AS `id_captura`,`vcat_conceptos`.`active` AS `active` from `vcat_conceptos` where ((trim(`vcat_conceptos`.`partida`) <> '') and (`vcat_conceptos`.`partida` is not null)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcat_categorias`
--
DROP VIEW IF EXISTS `vcat_categorias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcat_categorias`  AS  select `cat_servicios_categorias`.`id_servicio_categoria` AS `id_categoria`,`cat_servicios_categorias`.`id_servicio_clasificacion` AS `id_clasificacion`,`cat_servicios_categorias`.`nombre_servicio_categoria` AS `nombre_categoria` from `cat_servicios_categorias` where (`cat_servicios_categorias`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcat_conceptos`
--
DROP VIEW IF EXISTS `vcat_conceptos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcat_conceptos`  AS  select `cat_presupuesto_conceptos`.`id_presupesto_concepto` AS `id_presupesto_concepto`,`cat_presupuesto_conceptos`.`capitulo` AS `capitulo`,`cat_presupuesto_conceptos`.`concepto` AS `concepto`,`cat_presupuesto_conceptos`.`partida` AS `partida`,`cat_presupuesto_conceptos`.`denominacion` AS `denominacion`,`cat_presupuesto_conceptos`.`descripcion` AS `descripcion`,`cat_presupuesto_conceptos`.`id_captura` AS `id_captura`,`cat_presupuesto_conceptos`.`active` AS `active` from `cat_presupuesto_conceptos` where (`cat_presupuesto_conceptos`.`active` = 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcontratos`
--
DROP VIEW IF EXISTS `vcontratos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcontratos`  AS  select `tab_contratos`.`id_contrato` AS `id_contrato`,`tab_contratos`.`id_procedimiento` AS `id_procedimiento`,`tab_contratos`.`id_proveedor` AS `id_proveedor`,`tab_contratos`.`id_ejercicio` AS `id_ejercicio`,`tab_contratos`.`id_trimestre` AS `id_trimestre`,`tab_contratos`.`id_so_contratante` AS `id_so_contratante`,`tab_contratos`.`id_so_solicitante` AS `id_so_solicitante`,`tab_contratos`.`numero_contrato` AS `numero_contrato`,`tab_contratos`.`objeto_contrato` AS `objeto_contrato`,`tab_contratos`.`descripcion_justificacion` AS `descripcion_justificacion`,`tab_contratos`.`fundamento_juridico` AS `fundamento_juridico`,`tab_contratos`.`fecha_celebracion` AS `fecha_celebracion`,`tab_contratos`.`fecha_inicio` AS `fecha_inicio`,`tab_contratos`.`fecha_fin` AS `fecha_fin`,`tab_contratos`.`monto_contrato` AS `monto_contrato`,`tab_contratos`.`file_contrato` AS `file_contrato`,`tab_contratos`.`active` AS `active` from `tab_contratos` where (`tab_contratos`.`id_contrato` > 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcontratosyordenes`
--
DROP VIEW IF EXISTS `vcontratosyordenes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcontratosyordenes`  AS  select `e`.`id_contrato` AS `id_contrato`,`f`.`id_orden_compra` AS `id_orden_compra`,`c`.`ejercicio` AS `ejercicio`,`d`.`trimestre` AS `trimestre`,`e`.`numero_contrato` AS `numero_contrato`,`f`.`numero_orden_compra` AS `numero_orden_compra`,`g`.`nombre_sujeto_obligado` AS `contratante`,`h`.`nombre_sujeto_obligado` AS `solicitante`,`i`.`nombre_razon_social` AS `proveedor`,(select `c`.`monto_contrato` from `tab_contratos` `c` where (`a`.`id_contrato` = `c`.`id_contrato`)) AS `monto_contrato`,sum(`b`.`monto_desglose`) AS `monto_ejercido` from ((((((((`vact_facturas` `a` join `vact_facturas_desglose` `b`) join `vact_ejercicios` `c`) join `cat_trimestres` `d`) join `vact_contratos` `e`) join `vact_ordenes_compra` `f`) join `vact_sujetos_obligados` `g`) join `vact_sujetos_obligados` `h`) join `vact_proveedores` `i`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`id_ejercicio` = `c`.`id_ejercicio`) and (`a`.`id_trimestre` = `d`.`id_trimestre`) and (`a`.`id_contrato` = `e`.`id_contrato`) and (`a`.`id_orden_compra` = `f`.`id_orden_compra`) and (`e`.`id_so_contratante` = `g`.`id_sujeto_obligado`) and (`e`.`id_so_solicitante` = `h`.`id_sujeto_obligado`) and (`a`.`id_proveedor` = `i`.`id_proveedor`)) group by `c`.`ejercicio`,`d`.`trimestre`,`e`.`numero_contrato`,`f`.`numero_orden_compra`,`a`.`id_so_contratante`,`b`.`id_so_solicitante`,`a`.`id_proveedor` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vcont_x_anio_x_prov`
--
DROP VIEW IF EXISTS `vcont_x_anio_x_prov`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vcont_x_anio_x_prov`  AS  select `tab_contratos`.`id_proveedor` AS `id_proveedor`,`tab_proveedores`.`nombre_razon_social` AS `nombre_razon_social`,count(`tab_contratos`.`id_contrato`) AS `count_contratos`,year(`tab_contratos`.`fecha_celebracion`) AS `cont_anio`,sum(`tab_contratos`.`monto_contrato`) AS `sum_contratos` from (`tab_contratos` join `tab_proveedores` on((`tab_proveedores`.`id_proveedor` = `tab_contratos`.`id_proveedor`))) group by `tab_contratos`.`id_proveedor`,year(`tab_contratos`.`fecha_celebracion`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vfacturas`
--
DROP VIEW IF EXISTS `vfacturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vfacturas`  AS  select `vact_facturas`.`id_factura` AS `id_factura`,(select `c`.`ejercicio` from `cat_ejercicios` `c` where (`vact_facturas`.`id_ejercicio` = `c`.`id_ejercicio`)) AS `ejercicio`,(select `d`.`trimestre` from `cat_trimestres` `d` where (`vact_facturas`.`id_trimestre` = `d`.`id_trimestre`)) AS `trimestre`,(select `d`.`nombre_razon_social` from `tab_proveedores` `d` where (`vact_facturas`.`id_proveedor` = `d`.`id_proveedor`)) AS `proveedor`,`vact_facturas`.`numero_factura` AS `numero_factura`,`vact_facturas`.`fecha_erogacion` AS `fecha_erogacion`,sum(`vact_facturas_desglose`.`monto_desglose`) AS `monto_ejercido` from (`vact_facturas` left join `vact_facturas_desglose` on((`vact_facturas`.`id_factura` = `vact_facturas_desglose`.`id_factura`))) group by `vact_facturas`.`id_ejercicio`,`vact_facturas`.`id_trimestre`,`vact_facturas`.`numero_factura`,`vact_facturas`.`fecha_erogacion` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vgasto_clasf_servicio`
--
DROP VIEW IF EXISTS `vgasto_clasf_servicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vgasto_clasf_servicio`  AS  select `b`.`id_servicio_clasificacion` AS `id_servicio_clasificacion`,`a`.`id_contrato` AS `id_contrato`,`a`.`id_orden_compra` AS `id_orden_compra`,`a`.`id_proveedor` AS `id_proveedor`,`b`.`id_campana_aviso` AS `id_campana_aviso`,`a`.`id_factura` AS `id_factura`,(select `c`.`ejercicio` from `cat_ejercicios` `c` where (`a`.`id_ejercicio` = `c`.`id_ejercicio`)) AS `ejercicio`,`a`.`numero_factura` AS `factura`,`a`.`fecha_erogacion` AS `fecha_erogacion`,(select `d`.`nombre_razon_social` from `tab_proveedores` `d` where (`a`.`id_proveedor` = `d`.`id_proveedor`)) AS `proveedor`,(select `e`.`nombre_servicio_clasificacion` from `cat_servicios_clasificacion` `e` where (`b`.`id_servicio_clasificacion` = `e`.`id_servicio_clasificacion`)) AS `nombre_servicio_clasificacion`,(select `f`.`nombre_servicio_categoria` from `cat_servicios_categorias` `f` where (`b`.`id_servicio_categoria` = `f`.`id_servicio_categoria`)) AS `nombre_servicio_categoria`,(select `g`.`nombre_servicio_subcategoria` from `cat_servicios_subcategorias` `g` where (`b`.`id_servicio_subcategoria` = `g`.`id_servicio_subcategoria`)) AS `nombre_servicio_subcategoria`,(select `j`.`nombre_campana_tipo` from (`tab_campana_aviso` `i` join `cat_campana_tipos` `j`) where ((`b`.`id_campana_aviso` = `i`.`id_campana_aviso`) and (`i`.`id_campana_tipo` = `j`.`id_campana_tipo`))) AS `tipo`,(select `h`.`nombre_campana_aviso` from `tab_campana_aviso` `h` where (`b`.`id_campana_aviso` = `h`.`id_campana_aviso`)) AS `nombre_campana_aviso`,sum(`b`.`monto_desglose`) AS `monto_servicio` from (`vact_facturas` `a` join `vact_facturas_desglose` `b`) where (`a`.`id_factura` = `b`.`id_factura`) group by `a`.`id_factura`,`a`.`id_ejercicio`,`a`.`numero_factura`,`a`.`fecha_erogacion`,`a`.`id_proveedor`,`b`.`id_servicio_clasificacion`,`b`.`id_servicio_categoria`,`b`.`id_servicio_subcategoria`,`b`.`id_campana_aviso`,`b`.`id_campana_aviso` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vgrafica1`
--
DROP VIEW IF EXISTS `vgrafica1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vgrafica1`  AS  select `a`.`ejercicio` AS `ejercicio`,`a`.`servicio` AS `servicio`,`a`.`campana` AS `campana`,`a`.`partida` AS `partida`,((select sum(`b`.`monto_desglose`) AS `valor2` from ((`vact_facturas` `f` join `vact_facturas_desglose` `b`) join `vact_ejercicios` `c`) where ((`f`.`id_factura` = `b`.`id_factura`) and (`f`.`id_ejercicio` = `c`.`id_ejercicio`) and (`c`.`ejercicio` = `a`.`ejercicio`))) / (select count(0) from `vpregrafica1` `b` where (`b`.`ejercicio` = `a`.`ejercicio`))) AS `ejercido`,`a`.`tipo` AS `tipo`,`a`.`fecha` AS `fecha`,`a`.`proveedor` AS `proveedor`,`a`.`campana_aviso` AS `campana_aviso`,((select sum(`vtab_presupuesto`.`original`) AS `valor1` from `vtab_presupuesto` where (`vtab_presupuesto`.`ejercicio` = `a`.`ejercicio`)) / (select count(0) from `vpregrafica1` `b` where (`b`.`ejercicio` = `a`.`ejercicio`))) AS `presupuesto`,((select sum(`vtab_presupuesto`.`presupuesto`) AS `valor3` from `vtab_presupuesto` where (`vtab_presupuesto`.`ejercicio` = `a`.`ejercicio`)) / (select count(0) from `vpregrafica1` `b` where (`b`.`ejercicio` = `a`.`ejercicio`))) AS `modificacion`,((select count(0) AS `valor1` from `vtab_proveedores` where ((`vtab_proveedores`.`ejercicio` = `a`.`ejercicio`) and (`vtab_proveedores`.`nombre` not in ('AnÃ¡lisis, estudios y mÃ©tricas','Gastos de propaganda e Imagen','Impresiones','Internet','Medios impresos','ProducciÃ³n de contenidos','Radio','TelevisiÃ³n','Contratos','Ã“rdenes de compra')))) / (select count(0) from `vpregrafica1` `b` where ((`b`.`ejercicio` = `a`.`ejercicio`) and (`b`.`proveedor` not in ('AnÃ¡lisis, estudios y mÃ©tricas','Gastos de propaganda e Imagen','Impresiones','Internet','Medios impresos','ProducciÃ³n de contenidos','Radio','TelevisiÃ³n','Contratos','Ã“rdenes de compra'))))) AS `proveedores`,((select count(0) AS `valor1` from ((`vact_campana_aviso` `c` join `vact_ejercicios` `b`) join `cat_ejercicios` `e`) where ((`c`.`id_campana_tipo` in (1,2)) and (`c`.`id_ejercicio` = `b`.`id_ejercicio`) and (`b`.`id_ejercicio` = `e`.`id_ejercicio`) and (`e`.`ejercicio` = `a`.`ejercicio`))) / (select count(0) from `vpregrafica1` `b` where (`b`.`ejercicio` = `a`.`ejercicio`))) AS `totalcampanas` from `vpregrafica1` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlimite`
--
DROP VIEW IF EXISTS `vlimite`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlimite`  AS  select `vpor_proveedor`.`categoria` AS `categoria`,`vpor_proveedor`.`tipo` AS `tipo`,`vpor_proveedor`.`proveedor` AS `proveedor`,`vpor_proveedor`.`total` AS `total`,`vpor_proveedor`.`numero` AS `numero`,`vpor_proveedor`.`ejercicio` AS `ejercicio` from `vpor_proveedor` order by `vpor_proveedor`.`total` desc limit 30 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlimite_act`
--
DROP VIEW IF EXISTS `vlimite_act`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlimite_act`  AS  select `vlimite`.`total` AS `limite` from `vlimite` order by `vlimite`.`total` limit 1 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlinks_proveedor`
--
DROP VIEW IF EXISTS `vlinks_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlinks_proveedor`  AS  select `vpor_proveedor`.`tipo` AS `tipo`,`vpor_proveedor`.`proveedor` AS `proveedor`,sum(`vpor_proveedor`.`total`) AS `total`,count(0) AS `numero`,`vpor_proveedor`.`ejercicio` AS `ejercicio` from `vpor_proveedor` group by `vpor_proveedor`.`tipo`,`vpor_proveedor`.`proveedor`,`vpor_proveedor`.`ejercicio` order by `vpor_proveedor`.`tipo`,`vpor_proveedor`.`proveedor`,`vpor_proveedor`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlinks_tipo`
--
DROP VIEW IF EXISTS `vlinks_tipo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlinks_tipo`  AS  select `vpor_proveedor`.`categoria` AS `categoria`,`vpor_proveedor`.`tipo` AS `tipo`,sum(`vpor_proveedor`.`total`) AS `total`,count(0) AS `numero`,`vpor_proveedor`.`ejercicio` AS `ejercicio` from `vpor_proveedor` group by `vpor_proveedor`.`categoria`,`vpor_proveedor`.`tipo`,`vpor_proveedor`.`ejercicio` order by `vpor_proveedor`.`categoria`,`vpor_proveedor`.`tipo`,`vpor_proveedor`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlista_contratos`
--
DROP VIEW IF EXISTS `vlista_contratos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlista_contratos`  AS  select `a`.`id_contrato` AS `id_contrato`,(select `b`.`ejercicio` from `cat_ejercicios` `b` where (`a`.`id_ejercicio` = `b`.`id_ejercicio`)) AS `ejercicio`,(select `c`.`trimestre` from `cat_trimestres` `c` where (`a`.`id_trimestre` = `c`.`id_trimestre`)) AS `trimestre`,`a`.`numero_contrato` AS `numero_contrato`,(select `d`.`nombre_sujeto_obligado` from `vact_sujetos_obligados` `d` where (`a`.`id_so_solicitante` = `d`.`id_sujeto_obligado`)) AS `solicitante`,(select `e`.`nombre_sujeto_obligado` from `vact_sujetos_obligados` `e` where (`a`.`id_so_contratante` = `e`.`id_sujeto_obligado`)) AS `contratante`,(select `f`.`nombre_razon_social` from `vact_proveedores` `f` where (`a`.`id_proveedor` = `f`.`id_proveedor`)) AS `proveedor`,`a`.`monto_contrato` AS `monto_contrato`,(select ifnull(sum(`g`.`monto_desglose`),0) from (`vact_facturas_desglose` `g` join `vact_facturas` `h`) where ((`g`.`id_factura` = `h`.`id_factura`) and (`h`.`id_contrato` = `a`.`id_contrato`))) AS `monto_ejercido` from `vact_contratos` `a` where (`a`.`id_contrato` > 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlista_facturas`
--
DROP VIEW IF EXISTS `vlista_facturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlista_facturas`  AS  select `tab_facturas`.`id_factura` AS `id_factura`,(select `c`.`ejercicio` from `cat_ejercicios` `c` where (`tab_facturas`.`id_ejercicio` = `c`.`id_ejercicio`)) AS `ejercicio`,(select `e`.`numero_contrato` from `tab_contratos` `e` where (`tab_facturas`.`id_contrato` = `e`.`id_contrato`)) AS `contrato`,(select `f`.`numero_orden_compra` from `tab_ordenes_compra` `f` where (`tab_facturas`.`id_orden_compra` = `f`.`id_orden_compra`)) AS `orden`,(select `d`.`trimestre` from `cat_trimestres` `d` where (`tab_facturas`.`id_trimestre` = `d`.`id_trimestre`)) AS `trimestre`,(select `d`.`nombre_razon_social` from `tab_proveedores` `d` where (`tab_facturas`.`id_proveedor` = `d`.`id_proveedor`)) AS `proveedor`,`tab_facturas`.`numero_factura` AS `numero_factura`,`tab_facturas`.`fecha_erogacion` AS `fecha_erogacion`,(select ifnull(sum(`i`.`monto_desglose`),0) from `tab_facturas_desglose` `i` where ((`tab_facturas`.`id_factura` = `i`.`id_factura`) and (`i`.`active` = 1) and (`tab_facturas`.`active` = 1))) AS `monto_factura`,(select `g`.`name_active` from `sys_active` `g` where (`tab_facturas`.`active` = `g`.`id_active`)) AS `active` from `tab_facturas` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlista_oc`
--
DROP VIEW IF EXISTS `vlista_oc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlista_oc`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,(select `b`.`ejercicio` from `cat_ejercicios` `b` where (`a`.`id_ejercicio` = `b`.`id_ejercicio`)) AS `ejercicio`,(select `c`.`trimestre` from `cat_trimestres` `c` where (`a`.`id_trimestre` = `c`.`id_trimestre`)) AS `trimestre`,`a`.`numero_orden_compra` AS `numero_orden_compra`,(select `d`.`nombre_sujeto_obligado` from `vact_sujetos_obligados` `d` where (`a`.`id_so_solicitante` = `d`.`id_sujeto_obligado`)) AS `solicitante`,(select `e`.`nombre_sujeto_obligado` from `vact_sujetos_obligados` `e` where (`a`.`id_so_contratante` = `e`.`id_sujeto_obligado`)) AS `contratante`,(select `f`.`nombre_razon_social` from `vact_proveedores` `f` where (`a`.`id_proveedor` = `f`.`id_proveedor`)) AS `proveedor`,(select ifnull(sum(`g`.`monto_desglose`),0) from (`vact_facturas_desglose` `g` join `vact_facturas` `h`) where ((`g`.`id_factura` = `h`.`id_factura`) and (`h`.`id_orden_compra` = `a`.`id_orden_compra`))) AS `monto_ejercido` from `vact_ordenes_compra` `a` where ((`a`.`id_orden_compra` > 1) and (`a`.`id_contrato` = 1)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vlista_por_proveedor`
--
DROP VIEW IF EXISTS `vlista_por_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vlista_por_proveedor`  AS  select distinct `vpor_proveedor`.`ejercicio` AS `ejercicio`,`vpor_proveedor`.`tipo` AS `lista` from `vpor_proveedor` union select distinct `vpor_proveedor`.`ejercicio` AS `ejercicio`,`vpor_proveedor`.`categoria` AS `lista` from `vpor_proveedor` union select distinct `vpor_proveedor`.`ejercicio` AS `ejercicio`,`vpor_proveedor`.`proveedor` AS `lista` from `vpor_proveedor` order by `lista` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vmeses_porservicio`
--
DROP VIEW IF EXISTS `vmeses_porservicio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vmeses_porservicio`  AS  select `a`.`ejercicio` AS `ejercicio`,`b`.`id_mes` AS `id_mes`,`b`.`mes_corto` AS `mes_corto`,`c`.`titulo_grafica` AS `nombre_servicio_categoria`,ifnull((select sum(`d`.`monto_desglose`) from (`vact_facturas_desglose` `d` join `vact_facturas` `e`) where ((`d`.`id_factura` = `e`.`id_factura`) and (`d`.`id_servicio_categoria` = `c`.`id_servicio_categoria`) and (`e`.`id_ejercicio` = `a`.`id_ejercicio`) and (month(`e`.`fecha_erogacion`) = `b`.`id_mes`))),0) AS `monto` from ((`vact_ejercicios` `a` join `cat_meses` `b`) join `cat_servicios_categorias` `c`) order by `a`.`id_ejercicio`,`b`.`id_mes` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vmonto_campana`
--
DROP VIEW IF EXISTS `vmonto_campana`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vmonto_campana`  AS  select `b`.`id_campana_aviso` AS `id_campana_aviso`,sum(`b`.`monto_desglose`) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where (`a`.`id_factura` = `b`.`id_factura`) group by `b`.`id_campana_aviso` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vmonto_oc`
--
DROP VIEW IF EXISTS `vmonto_oc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vmonto_oc`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,sum(`b`.`monto_desglose`) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_orden_compra` > 1) and (`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `voc_monto_factura`
--
DROP VIEW IF EXISTS `voc_monto_factura`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `voc_monto_factura`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,concat('$ ',convert(format(sum(`b`.`monto_desglose`),2) using utf8mb4)) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `voc_monto_factura_sf`
--
DROP VIEW IF EXISTS `voc_monto_factura_sf`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `voc_monto_factura_sf`  AS  select `a`.`id_orden_compra` AS `id_orden_compra`,sum(`b`.`monto_desglose`) AS `monto` from (`tab_facturas` `a` join `tab_facturas_desglose` `b`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`active` = 1) and (`b`.`active` = 1)) group by `a`.`id_orden_compra` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vordenes_compra`
--
DROP VIEW IF EXISTS `vordenes_compra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vordenes_compra`  AS  select `tab_ordenes_compra`.`id_orden_compra` AS `id_orden_compra`,`tab_ordenes_compra`.`id_procedimiento` AS `id_procedimiento`,`tab_ordenes_compra`.`id_proveedor` AS `id_proveedor`,`tab_ordenes_compra`.`id_contrato` AS `id_contrato`,`tab_ordenes_compra`.`id_ejercicio` AS `id_ejercicio`,`tab_ordenes_compra`.`id_trimestre` AS `id_trimestre`,`tab_ordenes_compra`.`id_so_contratante` AS `id_so_contratante`,`tab_ordenes_compra`.`id_so_solicitante` AS `id_so_solicitante`,`tab_ordenes_compra`.`id_campana_aviso` AS `id_campana_aviso`,`tab_ordenes_compra`.`numero_orden_compra` AS `numero_orden_compra`,`tab_ordenes_compra`.`descripcion_justificacion` AS `descripcion_justificacion`,`tab_ordenes_compra`.`fecha_orden` AS `fecha_orden`,`tab_ordenes_compra`.`file_orden` AS `file_orden`,`tab_ordenes_compra`.`active` AS `active` from `tab_ordenes_compra` where (`tab_ordenes_compra`.`id_orden_compra` > 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_aviso`
--
DROP VIEW IF EXISTS `vout_campana_aviso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_aviso`  AS  select `a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,(select `l`.`nombre_campana_tipo` from `cat_campana_tipos` `l` where (`a`.`id_campana_tipo` = `l`.`id_campana_tipo`)) AS `Campana o aviso institucional`,(select `l`.`nombre_campana_subtipo` from `cat_campana_subtipos` `l` where (`a`.`id_campana_subtipo` = `l`.`id_campana_subtipo`)) AS `Subtipo`,`a`.`nombre_campana_aviso` AS `Nombre`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`g`.`id_sujeto_obligado` = `a`.`id_so_contratante`)) AS `Sujeto obligado contratant`,(select `i`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `i` where (`i`.`id_sujeto_obligado` = `a`.`id_so_solicitante`)) AS `Sujeto obligado solicitante`,(select `l`.`nombre_campana_tema` from `cat_campana_temas` `l` where (`a`.`id_campana_tema` = `l`.`id_campana_tema`)) AS `Tema`,(select `l`.`campana_objetivo` from `cat_campana_objetivos` `l` where (`a`.`id_campana_objetivo` = `l`.`id_campana_objetivo`)) AS `Objetivo institucional`,`a`.`objetivo_comunicacion` AS `Objetivo de comunicación`,(select `l`.`nombre_campana_cobertura` from `cat_campana_coberturas` `l` where (`a`.`id_campana_cobertura` = `l`.`id_campana_cobertura`)) AS `Cobertura`,`a`.`campana_ambito_geo` AS `Ámbito geográfico`,`a`.`fecha_inicio` AS `Fecha inicio`,`a`.`fecha_termino` AS `Fecha término`,(select `l`.`logico` from `sys_logico` `l` where (`a`.`id_tiempo_oficial` = `l`.`id_logico`)) AS `Tiempo oficial`,`a`.`fecha_inicio_to` AS `Fecha inicio tiempo oficial`,`a`.`fecha_termino_to` AS `Fecha término tiempo oficial`,`a`.`publicacion_segob` AS `Publicación SEGOB.`,`a`.`plan_acs` AS `Documento del PACS`,`a`.`fecha_dof` AS `Fecha publicación`,`a`.`evaluacion` AS `Evaluación`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_campana_aviso` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_grupo_edad`
--
DROP VIEW IF EXISTS `vout_campana_grupo_edad`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_grupo_edad`  AS  select `a`.`id_rel_campana_grupo_edad` AS `ID de grupo de edad`,`a`.`id_campana_aviso` AS `ID de campaña o aviso institucional`,(select `b`.`nombre_poblacion_grupo_edad` from `cat_poblacion_grupo_edad` `b` where (`b`.`id_poblacion_grupo_edad` = `a`.`id_poblacion_grupo_edad`)) AS `Grupo de edad` from `rel_campana_grupo_edad` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_lugar`
--
DROP VIEW IF EXISTS `vout_campana_lugar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_lugar`  AS  select `a`.`id_campana_lugar` AS `ID de lugar`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,`a`.`poblacion_lugar` AS `Lugar` from `rel_campana_lugar` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_maudio`
--
DROP VIEW IF EXISTS `vout_campana_maudio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_maudio`  AS  select `a`.`id_campana_maudio` AS `ID de audios`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,`a`.`nombre_campana_maudio` AS `Nombre Audio`,`a`.`file_audio` AS `Audios (Vínculo al archivo)`,`a`.`url_audio` AS `Audios (Vínculo al repositorio)` from `rel_campana_maudio` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_mimagenes`
--
DROP VIEW IF EXISTS `vout_campana_mimagenes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_mimagenes`  AS  select `a`.`id_campana_mimagen` AS `ID de imagenes`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,`a`.`nombre_campana_mimagen` AS `Nombre Imagen`,`a`.`file_imagen` AS `Imagenes (Vínculo al archivo)`,`a`.`url_imagen` AS `Imagenes (Vínculo al repositorio)` from `rel_campana_mimagenes` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_mvideo`
--
DROP VIEW IF EXISTS `vout_campana_mvideo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_mvideo`  AS  select `a`.`id_campana_mvideo` AS `ID de Videos`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,`a`.`nombre_campana_mvideo` AS `Nombre Video`,`a`.`file_video` AS `Videos(Vínculo al archivo)`,`a`.`url_video` AS `Videos(Vínculo al repositorio)` from `rel_campana_mvideo` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_nivel`
--
DROP VIEW IF EXISTS `vout_campana_nivel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_nivel`  AS  select `a`.`id_rel_campana_nivel` AS `ID de nivel socioeconómico`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,(select `b`.`nombre_poblacion_nivel` from `cat_poblacion_nivel` `b` where (`b`.`id_poblacion_nivel` = `a`.`id_poblacion_nivel`)) AS `Nivel socioeconómico` from `rel_campana_nivel` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_nivel_educativo`
--
DROP VIEW IF EXISTS `vout_campana_nivel_educativo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_nivel_educativo`  AS  select `a`.`id_rel_campana_nivel_educativo` AS `ID de educación`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,(select `b`.`nombre_poblacion_nivel_educativo` from `cat_poblacion_nivel_educativo` `b` where (`b`.`id_poblacion_nivel_educativo` = `a`.`id_poblacion_nivel_educativo`)) AS `Educación` from `rel_campana_nivel_educativo` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_campana_sexo`
--
DROP VIEW IF EXISTS `vout_campana_sexo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_campana_sexo`  AS  select `a`.`id_rel_campana_sexo` AS `ID de sexo`,`a`.`id_campana_aviso` AS `ID de campana o aviso institucional`,(select `b`.`nombre_poblacion_sexo` from `cat_poblacion_sexo` `b` where (`b`.`id_poblacion_sexo` = `a`.`id_poblacion_sexo`)) AS `Sexo` from `rel_campana_sexo` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_contratos`
--
DROP VIEW IF EXISTS `vout_contratos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_contratos`  AS  select `a`.`numero_contrato` AS `ID (Número de contrato)`,(select `c`.`nombre_procedimiento` from `cat_procedimientos` `c` where (`a`.`id_procedimiento` = `c`.`id_procedimiento`)) AS `Procedimiento`,(select `b`.`nombre_razon_social` from `tab_proveedores` `b` where (`a`.`id_proveedor` = `b`.`id_proveedor`)) AS `Proveedor`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`g`.`id_sujeto_obligado` = `a`.`id_so_contratante`)) AS `Contratante`,(select `i`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `i` where (`i`.`id_sujeto_obligado` = `a`.`id_so_solicitante`)) AS `Solicitante`,`a`.`objeto_contrato` AS `Objeto del contrato`,`a`.`descripcion_justificacion` AS `Descripción`,`a`.`fundamento_juridico` AS `Fundamento jurídico`,`a`.`fecha_celebracion` AS `Fecha celebración`,`a`.`fecha_inicio` AS `Fecha inicio`,`a`.`fecha_fin` AS `Fecha fin`,`a`.`monto_contrato` AS `Monto original del contrato`,if(isnull((select sum(`z`.`monto_convenio`) from `tab_convenios_modificatorios` `z` where (`z`.`id_contrato` = `a`.`id_contrato`))),0,(select sum(`z`.`monto_convenio`) from `tab_convenios_modificatorios` `z` where (`z`.`id_contrato` = `a`.`id_contrato`))) AS `Monto modificado`,(`a`.`monto_contrato` + if(isnull((select sum(`z`.`monto_convenio`) from `tab_convenios_modificatorios` `z` where (`z`.`id_contrato` = `a`.`id_contrato`))),0,(select sum(`z`.`monto_convenio`) from `tab_convenios_modificatorios` `z` where (`z`.`id_contrato` = `a`.`id_contrato`)))) AS `Monto total`,(select sum(`y`.`monto_desglose`) from (`tab_facturas_desglose` `y` join `tab_facturas` `x`) where ((`x`.`id_factura` = `y`.`id_factura`) and (`x`.`id_contrato` = `a`.`id_contrato`))) AS `Monto pagado a la fecha`,`a`.`file_contrato` AS `Archivo contrato en PDF (Vinculo al archivo)`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_contratos` `a` where (`a`.`id_contrato` > 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_convenios_modificatorios`
--
DROP VIEW IF EXISTS `vout_convenios_modificatorios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_convenios_modificatorios`  AS  select `a`.`numero_convenio` AS `ID (Número de convenio modificatorio)`,(select `b`.`numero_contrato` from `tab_contratos` `b` where (`a`.`id_contrato` = `b`.`id_contrato`)) AS `ID (Número de contrato)`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,`a`.`objeto_convenio` AS `Objeto`,`a`.`fundamento_juridico` AS `Fundamento jurídico`,`a`.`fecha_celebracion` AS `Fecha celebración`,`a`.`monto_convenio` AS `Monto`,`a`.`file_convenio` AS `Archivo convenio en PDF (Vinculo al archivo)`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_convenios_modificatorios` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_facturas`
--
DROP VIEW IF EXISTS `vout_facturas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_facturas`  AS  select `a`.`numero_factura` AS `ID Factura`,(select `b`.`nombre_razon_social` from `tab_proveedores` `b` where (`a`.`id_proveedor` = `b`.`id_proveedor`)) AS `Proveedor`,(select `c`.`numero_contrato` from `tab_contratos` `c` where (`a`.`id_contrato` = `c`.`id_contrato`)) AS `Contrato`,(select `d`.`numero_orden_compra` from `tab_ordenes_compra` `d` where (`a`.`id_orden_compra` = `d`.`id_orden_compra`)) AS `Orden`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`a`.`id_so_contratante` = `g`.`id_sujeto_obligado`)) AS `Sujeto obligado contratante`,(select `h`.`partida` from `cat_presupuesto_conceptos` `h` where (`a`.`id_presupuesto_concepto` = `h`.`id_presupesto_concepto`)) AS `Partida`,(select sum(`i`.`monto_desglose`) from `tab_facturas_desglose` `i` where (`a`.`id_factura` = `i`.`id_factura`)) AS `Monto`,`a`.`file_factura_pdf` AS `Archivo factura en PDF (Vínculo al archivo)`,`a`.`file_factura_xml` AS `Archivo factura en XML (Vínculo al archivo)`,`a`.`fecha_erogacion` AS `Fecha de erogación`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_facturas` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_facturas_desglose`
--
DROP VIEW IF EXISTS `vout_facturas_desglose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_facturas_desglose`  AS  select `a`.`id_factura_desglose` AS `ID Detalle Factura`,(select `b`.`numero_factura` from `tab_facturas` `b` where (`a`.`id_factura` = `b`.`id_factura`)) AS `ID Factura`,(select `g`.`nombre_campana_tipo` from (`vact_campana_aviso` `b` join `cat_campana_tipos` `g`) where ((`a`.`id_campana_aviso` = `b`.`id_campana_aviso`) and (`b`.`id_campana_tipo` = `g`.`id_campana_tipo`))) AS `Campana o aviso institucional`,(select `b`.`nombre_campana_aviso` from `vact_campana_aviso` `b` where (`a`.`id_campana_aviso` = `b`.`id_campana_aviso`)) AS `Nombre campana o aviso institucional`,(select `c`.`nombre_servicio_clasificacion` from `cat_servicios_clasificacion` `c` where (`c`.`id_servicio_clasificacion` = `a`.`id_servicio_clasificacion`)) AS `Clasificación del servicio`,(select `d`.`nombre_servicio_categoria` from `cat_servicios_categorias` `d` where (`d`.`id_servicio_categoria` = `a`.`id_servicio_categoria`)) AS `Categoría del servicio`,(select `e`.`nombre_servicio_subcategoria` from `cat_servicios_subcategorias` `e` where (`e`.`id_servicio_subcategoria` = `a`.`id_servicio_subcategoria`)) AS `Subcategoría del servicio`,(select `g`.`nombre_servicio_unidad` from `cat_servicios_unidades` `g` where (`a`.`id_servicio_unidad` = `g`.`id_servicio_unidad`)) AS `Unidad`,(select `f`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `f` where (`f`.`id_sujeto_obligado` = `a`.`id_so_solicitante`)) AS `Sujeto obligado solicitante`,`a`.`area_administrativa` AS `Área administrativa solicitante`,`a`.`descripcion_servicios` AS `Descripción del servicio o producto adquirido`,`a`.`cantidad` AS `Cantidad`,`a`.`precio_unitarios` AS `Precio unitario con I.V.A incluido`,`a`.`monto_desglose` AS `Monto`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_facturas_desglose` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_facturas_desglose_v2`
--
DROP VIEW IF EXISTS `vout_facturas_desglose_v2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_facturas_desglose_v2`  AS  select `a`.`id_factura_desglose` AS `ID Detalle Factura`,(select `b`.`numero_factura` from `tab_facturas` `b` where (`a`.`id_factura` = `b`.`id_factura`)) AS `ID Factura`,(select `g`.`nombre_campana_tipo` from (`vact_campana_aviso` `b` join `cat_campana_tipos` `g`) where ((`a`.`id_campana_aviso` = `b`.`id_campana_aviso`) and (`b`.`id_campana_tipo` = `g`.`id_campana_tipo`))) AS `Campana o aviso institucional`,(select `b`.`nombre_campana_aviso` from `vact_campana_aviso` `b` where (`a`.`id_campana_aviso` = `b`.`id_campana_aviso`)) AS `Nombre campana o aviso institucional`,(select `c`.`nombre_servicio_clasificacion` from `cat_servicios_clasificacion` `c` where (`c`.`id_servicio_clasificacion` = `a`.`id_servicio_clasificacion`)) AS `Clasificación del servicio`,(select `d`.`nombre_servicio_categoria` from `cat_servicios_categorias` `d` where (`d`.`id_servicio_categoria` = `a`.`id_servicio_categoria`)) AS `Categoría del servicio`,(select `e`.`nombre_servicio_subcategoria` from `cat_servicios_subcategorias` `e` where (`e`.`id_servicio_subcategoria` = `a`.`id_servicio_subcategoria`)) AS `Subcategoría del servicio`,(select `g`.`nombre_servicio_unidad` from `cat_servicios_unidades` `g` where (`a`.`id_servicio_unidad` = `g`.`id_servicio_unidad`)) AS `Unidad`,(select `j`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `j` where (`j`.`id_sujeto_obligado` = `a`.`id_so_contratante`)) AS `Sujeto obligado contratante`,(select `k`.`partida` from `cat_presupuesto_conceptos` `k` where (`k`.`id_presupesto_concepto` = `a`.`id_presupuesto_concepto`)) AS `Partida contratante`,(select `f`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `f` where (`f`.`id_sujeto_obligado` = `a`.`id_so_solicitante`)) AS `Sujeto obligado solicitante`,(select `h`.`partida` from `cat_presupuesto_conceptos` `h` where (`h`.`id_presupesto_concepto` = `a`.`id_presupuesto_concepto_solicitante`)) AS `Partida solicitante`,`a`.`area_administrativa` AS `Área administrativa solicitante`,`a`.`descripcion_servicios` AS `Descripción del servicio o producto adquirido`,`a`.`cantidad` AS `Cantidad`,`a`.`precio_unitarios` AS `Precio unitario con I.V.A incluido`,`a`.`monto_desglose` AS `Monto`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_facturas_desglose_v2` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_gasto_x_proveedor`
--
DROP VIEW IF EXISTS `vout_gasto_x_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_gasto_x_proveedor`  AS  select `a`.`id_proveedor` AS `ID de proveedor`,(select `b`.`nombre_personalidad_juridica` from `cat_personalidad_juridica` `b` where (`a`.`id_personalidad_juridica` = `b`.`id_personalidad_juridica`)) AS `Personalidad jurídica`,`a`.`nombre_razon_social` AS `Nombre o razón social`,`a`.`nombre_comercial` AS `Nombre comercial`,`a`.`rfc` AS `R.F.C.`,(select sum(`c`.`monto_desglose`) from (`vact_facturas` `b` join `vact_facturas_desglose` `c`) where ((`b`.`id_factura` = `c`.`id_factura`) and (`a`.`id_proveedor` = `b`.`id_proveedor`))) AS `Monto total pagado`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_proveedores` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_oc_x_proveedor`
--
DROP VIEW IF EXISTS `vout_oc_x_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_oc_x_proveedor`  AS  select `a`.`numero_orden_compra` AS `ID (Orden de compra)`,`a`.`id_proveedor` AS `ID de proveedor`,(select `b`.`nombre_razon_social` from `tab_proveedores` `b` where (`a`.`id_proveedor` = `b`.`id_proveedor`)) AS `Nombre Proveedor`,(select `c`.`nombre_procedimiento` from `cat_procedimientos` `c` where (`a`.`id_procedimiento` = `c`.`id_procedimiento`)) AS `Procedimiento`,(select `c`.`numero_contrato` from `tab_contratos` `c` where (`a`.`id_contrato` = `c`.`id_contrato`)) AS `ID (Número de contrato)`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`a`.`id_so_contratante` = `g`.`id_sujeto_obligado`)) AS `Sujeto obligado ordenante`,(select `l`.`nombre_campana_tipo` from (`vact_campana_aviso` `k` join `cat_campana_tipos` `l`) where ((`a`.`id_campana_aviso` = `k`.`id_campana_aviso`) and (`k`.`id_campana_tipo` = `l`.`id_campana_tipo`))) AS `Campana o aviso institucional`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`a`.`id_so_solicitante` = `g`.`id_sujeto_obligado`)) AS `Sujeto obligado solicitante`,`a`.`descripcion_justificacion` AS `Justificación`,`a`.`fecha_orden` AS `Fecha de orden`,`a`.`file_orden` AS `Archivo de la orden de compra en PDF`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_ordenes_compra` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_ordenes_compra`
--
DROP VIEW IF EXISTS `vout_ordenes_compra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_ordenes_compra`  AS  select `a`.`numero_orden_compra` AS `ID_Orden_de_compra)`,(select `b`.`nombre_razon_social` from `tab_proveedores` `b` where (`a`.`id_proveedor` = `b`.`id_proveedor`)) AS `Proveedor`,(select `c`.`nombre_procedimiento` from `cat_procedimientos` `c` where (`a`.`id_procedimiento` = `c`.`id_procedimiento`)) AS `Procedimiento`,(select `d`.`numero_contrato` from `tab_contratos` `d` where (`a`.`id_contrato` = `d`.`id_contrato`)) AS `Contrato`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `f`.`trimestre` from `cat_trimestres` `f` where (`a`.`id_trimestre` = `f`.`id_trimestre`)) AS `Trimestre`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`g`.`id_sujeto_obligado` = `a`.`id_so_contratante`)) AS `Sujeto_obligado_ordenante`,(select `l`.`nombre_campana_aviso` from (`vact_campana_aviso` `k` join `tab_campana_aviso` `l`) where ((`a`.`id_campana_aviso` = `k`.`id_campana_aviso`) and (`k`.`nombre_campana_aviso` = `l`.`nombre_campana_aviso`))) AS `Campana o aviso institucional`,(select `i`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `i` where (`i`.`id_sujeto_obligado` = `a`.`id_so_solicitante`)) AS `Sujeto obligado solicitante`,`a`.`numero_orden_compra` AS `numero_orden_de_compra`,`a`.`descripcion_justificacion` AS `Justificación`,`a`.`fecha_orden` AS `Fecha_de_orden`,`a`.`file_orden` AS `Archivo_de_la_orden_de_compra_en_PDF_(Vínculo_al_documento)`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_ordenes_compra` `a` where (`a`.`id_orden_compra` > 1) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_presupuestos`
--
DROP VIEW IF EXISTS `vout_presupuestos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_presupuestos`  AS  select `a`.`id_presupuesto` AS `ID de presupuesto`,(select `e`.`ejercicio` from `cat_ejercicios` `e` where (`a`.`id_ejercicio` = `e`.`id_ejercicio`)) AS `Ejercicio`,(select `g`.`nombre_sujeto_obligado` from `tab_sujetos_obligados` `g` where (`g`.`id_sujeto_obligado` = `a`.`id_sujeto_obligado`)) AS `Sujeto obligado`,(select ifnull(sum(`b`.`monto_presupuesto`),0) from `tab_presupuestos_desglose` `b` where (`b`.`id_presupuesto` = `a`.`id_presupuesto`)) AS `Presupuesto original`,(select ifnull(sum(`b`.`monto_modificacion`),0) from `tab_presupuestos_desglose` `b` where (`b`.`id_presupuesto` = `a`.`id_presupuesto`)) AS `Monto modificado`,(select ifnull((sum(`b`.`monto_presupuesto`) + sum(`b`.`monto_modificacion`)),0) from `tab_presupuestos_desglose` `b` where (`b`.`id_presupuesto` = `a`.`id_presupuesto`)) AS `Presupuesto modificado`,(select ifnull(sum(`y`.`monto_desglose`),0) from ((`tab_facturas_desglose` `y` join `tab_facturas` `x`) join `tab_presupuestos_desglose` `b`) where ((`x`.`id_factura` = `y`.`id_factura`) and (`x`.`id_so_contratante` = `a`.`id_sujeto_obligado`) and (`x`.`id_presupuesto_concepto` = `b`.`id_presupuesto_concepto`) and (`a`.`id_presupuesto` = `b`.`id_presupuesto`) and (`a`.`id_ejercicio` = `x`.`id_ejercicio`))) AS `Presupuesto ejercido`,ifnull(`a`.`file_programa_anual`,'') AS `Programa Anual`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_presupuestos` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_presupuestos_desglose`
--
DROP VIEW IF EXISTS `vout_presupuestos_desglose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_presupuestos_desglose`  AS  select `a`.`id_presupuesto_desglose` AS `ID de desglose`,`a`.`id_presupuesto` AS `ID de presupuesto`,(select `b`.`partida` from `cat_presupuesto_conceptos` `b` where (`a`.`id_presupuesto_concepto` = `b`.`id_presupesto_concepto`)) AS `Partida presupuestal`,`a`.`monto_presupuesto` AS `Monto asignado`,`a`.`monto_modificacion` AS `Monto de modificación`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_presupuestos_desglose` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_presupuestos_desglose_descarga`
--
DROP VIEW IF EXISTS `vout_presupuestos_desglose_descarga`;

CREATE ALGORITHM=UNDEFINED DEFINER=`dbo759732442`@`%` SQL SECURITY DEFINER VIEW `vout_presupuestos_desglose_descarga`  AS SELECT `a`.`id_presupuesto_desglose` AS `ID de desglose`, `a`.`id_presupuesto` AS `ID de presupuesto`, (select `b`.`partida` from `cat_presupuesto_conceptos` `b` where (`a`.`id_presupuesto_concepto` = `b`.`id_presupesto_concepto`)) AS `Partida presupuestal`, `a`.`fuente_federal` AS `fuente_federal`, `a`.`monto_fuente_federal` AS `monto_fuente_federal`, `a`.`fuente_local` AS `fuente_local`, `a`.`monto_fuente_local` AS `monto_fuente_local`, `a`.`fecha_validacion` AS `fecha_validacion`, `a`.`area_responsable` AS `area_responsable`, `a`.`fecha_actualizacion` AS `fecha_actualizacion`, `a`.`nota` AS `nota`, `a`.`periodo` AS `periodo`, `a`.`monto_presupuesto` AS `Monto asignado`, `a`.`monto_modificacion` AS `Monto de modificación`, (select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` FROM `tab_presupuestos_desglose` AS `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_proveedores`
--
DROP VIEW IF EXISTS `vout_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_proveedores`  AS  select `a`.`id_proveedor` AS `ID`,(select `b`.`nombre_personalidad_juridica` from `cat_personalidad_juridica` `b` where (`a`.`id_personalidad_juridica` = `b`.`id_personalidad_juridica`)) AS `Personalidad jurídica`,`a`.`nombre_razon_social` AS `Nombre o razón social`,`a`.`nombre_comercial` AS `Nombre comercial`,`a`.`rfc` AS `R.F.C.`,(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `vact_proveedores` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vout_sujetos_obligados`
--
DROP VIEW IF EXISTS `vout_sujetos_obligados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vout_sujetos_obligados`  AS  select `a`.`id_sujeto_obligado` AS `ID de S.O.`,(select `b`.`nombre_so_atribucion` from `cat_so_atribucion` `b` where (`b`.`id_so_atribucion` = `a`.`id_so_atribucion`)) AS `Función`,(select `b`.`nombre_so_orden_gobierno` from `cat_so_ordenes_gobierno` `b` where (`b`.`id_so_orden_gobierno` = `a`.`id_so_orden_gobierno`)) AS `Orden (Federal, Estatal, Municipal)`,(select `b`.`nombre_so_estado` from `cat_so_estados` `b` where (`b`.`id_so_estado` = `a`.`id_so_estado`)) AS `Estado`,`a`.`nombre_sujeto_obligado` AS `Nombre`,`a`.`siglas_sujeto_obligado` AS `Siglas`,`a`.`url_sujeto_obligado` AS `URL de página` from `vact_sujetos_obligados` `a` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vpor_proveedor`
--
DROP VIEW IF EXISTS `vpor_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vpor_proveedor`  AS  select `a`.`nombre_servicio_categoria` AS `categoria`,'Contratos' AS `tipo`,`d`.`nombre_razon_social` AS `proveedor`,sum(`b`.`monto_desglose`) AS `total`,count(0) AS `numero`,`e`.`ejercicio` AS `ejercicio` from ((((`cat_servicios_categorias` `a` join `vact_facturas_desglose` `b`) join `vact_facturas` `c`) join `vact_proveedores` `d`) join `vact_ejercicios` `e`) where ((`a`.`id_servicio_categoria` = `b`.`id_servicio_categoria`) and (`b`.`id_factura` = `c`.`id_factura`) and (`c`.`id_proveedor` = `d`.`id_proveedor`) and (`c`.`id_ejercicio` = `e`.`id_ejercicio`) and (`c`.`id_contrato` > 1)) group by `e`.`ejercicio`,`a`.`nombre_servicio_categoria`,'Contrato',`d`.`nombre_razon_social` union select `a`.`nombre_servicio_categoria` AS `categoria`,'Órdenes de compra' AS `tipo`,`d`.`nombre_razon_social` AS `proveedor`,sum(`b`.`monto_desglose`) AS `total`,count(0) AS `numero`,`e`.`ejercicio` AS `ejercicio` from ((((`cat_servicios_categorias` `a` join `vact_facturas_desglose` `b`) join `vact_facturas` `c`) join `vact_proveedores` `d`) join `vact_ejercicios` `e`) where ((`a`.`id_servicio_categoria` = `b`.`id_servicio_categoria`) and (`b`.`id_factura` = `c`.`id_factura`) and (`c`.`id_proveedor` = `d`.`id_proveedor`) and (`c`.`id_ejercicio` = `e`.`id_ejercicio`) and (`c`.`id_contrato` = 1) and (`c`.`id_orden_compra` > 1)) group by `e`.`ejercicio`,`a`.`nombre_servicio_categoria`,'Ordenes',`d`.`nombre_razon_social` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vpregrafica1`
--
DROP VIEW IF EXISTS `vpregrafica1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vpregrafica1`  AS  select year(`a`.`fecha_erogacion`) AS `ejercicio`,`e`.`nombre_servicio_categoria` AS `servicio`,if(`d`.`id_campana_aviso` in (select `vtop10_campanas`.`id_campana_aviso` from `vtop10_campanas`),`d`.`nombre_campana_aviso`,'Otras') AS `campana`,concat(`h`.`partida`,' - ',`h`.`denominacion`) AS `partida`,sum(`b`.`monto_desglose`) AS `ejercido`,`i`.`nombre_campana_tipo` AS `tipo`,date_format(`a`.`fecha_erogacion`,'%d/%m/%Y') AS `fecha`,if(`j`.`id_proveedor` in (select `vtop10_proveedores`.`id_proveedor` from `vtop10_proveedores`),`j`.`nombre_razon_social`,'Otros') AS `proveedor`,`d`.`id_campana_tipo` AS `campana_aviso` from ((((((((`vact_facturas` `a` join `vact_facturas_desglose` `b`) join `vact_ordenes_compra` `c`) join `vact_campana_aviso` `d`) join `cat_servicios_categorias` `e`) join `cat_campana_temas` `g`) join `cat_presupuesto_conceptos` `h`) join `cat_campana_tipos` `i`) join `tab_proveedores` `j`) where ((`a`.`id_factura` = `b`.`id_factura`) and (`a`.`id_proveedor` = `j`.`id_proveedor`) and (`a`.`id_orden_compra` = `c`.`id_orden_compra`) and (`b`.`id_campana_aviso` = `d`.`id_campana_aviso`) and (`b`.`id_servicio_categoria` = `e`.`id_servicio_categoria`) and (`d`.`id_campana_tema` = `g`.`id_campana_tema`) and (`a`.`id_presupuesto_concepto` = `h`.`id_presupesto_concepto`) and (`d`.`id_campana_tipo` = `i`.`id_campana_tipo`)) group by year(`a`.`fecha_erogacion`),`e`.`nombre_servicio_categoria`,if(`d`.`id_campana_aviso` in (select `vtop10_campanas`.`id_campana_aviso` from `vtop10_campanas`),`d`.`nombre_campana_aviso`,'Otras'),`h`.`partida`,`i`.`nombre_campana_tipo`,date_format(`a`.`fecha_erogacion`,'%d/%m/%Y'),if(`j`.`id_proveedor` in (select `vtop10_proveedores`.`id_proveedor` from `vtop10_proveedores`),`j`.`nombre_razon_social`,'Otros'),`d`.`id_campana_tipo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vso_actual`
--
DROP VIEW IF EXISTS `vso_actual`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vso_actual`  AS  select `a`.`id_user` AS `id_user`,`a`.`username` AS `username`,`a`.`password` AS `password`,`a`.`cookie_id` AS `cookie_id`,`a`.`token` AS `token`,`a`.`email` AS `email`,`a`.`fname` AS `fname`,`a`.`lname` AS `lname`,`a`.`public_office` AS `public_office`,`a`.`phone` AS `phone`,`a`.`created` AS `created`,`a`.`lastlogin` AS `lastlogin`,`a`.`lastip` AS `lastip`,`a`.`notes` AS `notes`,`a`.`record_user` AS `record_user`,`a`.`last_update` AS `last_update`,`a`.`active` AS `active`,`b`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`b`.`id_so_atribucion` AS `id_so_atribucion` from (`sec_users` `a` join `tab_sujetos_obligados` `b`) where (`a`.`record_user` = `b`.`id_sujeto_obligado`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vso_contratante`
--
DROP VIEW IF EXISTS `vso_contratante`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vso_contratante`  AS  select `tab_sujetos_obligados`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`tab_sujetos_obligados`.`id_so_atribucion` AS `id_so_atribucion`,`tab_sujetos_obligados`.`id_so_orden_gobierno` AS `id_so_orden_gobierno`,`tab_sujetos_obligados`.`id_so_estado` AS `id_so_estado`,`tab_sujetos_obligados`.`nombre_sujeto_obligado` AS `nombre_sujeto_obligado`,`tab_sujetos_obligados`.`siglas_sujeto_obligado` AS `siglas_sujeto_obligado`,`tab_sujetos_obligados`.`url_sujeto_obligado` AS `url_sujeto_obligado`,`tab_sujetos_obligados`.`active` AS `active` from `tab_sujetos_obligados` where (`tab_sujetos_obligados`.`id_so_atribucion` in (1,3)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vso_solicitante`
--
DROP VIEW IF EXISTS `vso_solicitante`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vso_solicitante`  AS  select `tab_sujetos_obligados`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`tab_sujetos_obligados`.`id_so_atribucion` AS `id_so_atribucion`,`tab_sujetos_obligados`.`id_so_orden_gobierno` AS `id_so_orden_gobierno`,`tab_sujetos_obligados`.`id_so_estado` AS `id_so_estado`,`tab_sujetos_obligados`.`nombre_sujeto_obligado` AS `nombre_sujeto_obligado`,`tab_sujetos_obligados`.`siglas_sujeto_obligado` AS `siglas_sujeto_obligado`,`tab_sujetos_obligados`.`url_sujeto_obligado` AS `url_sujeto_obligado`,`tab_sujetos_obligados`.`active` AS `active` from `tab_sujetos_obligados` where (`tab_sujetos_obligados`.`id_so_atribucion` in (2,3)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vsujetosobligados`
--
DROP VIEW IF EXISTS `vsujetosobligados`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vsujetosobligados`  AS  select `a`.`id_sujeto_obligado` AS `id_sujeto_obligado`,`b`.`ejercicio` AS `ejercicio`,`d`.`nombre_so_atribucion` AS `funcion`,`e`.`nombre_so_orden_gobierno` AS `orden`,`f`.`nombre_so_estado` AS `estado`,`a`.`nombre_sujeto_obligado` AS `nombre`,`a`.`siglas_sujeto_obligado` AS `siglas`,`a`.`url_sujeto_obligado` AS `URL`,(select ifnull(sum(`g`.`monto_desglose`),0) from (`vact_facturas` `h` join `vact_facturas_desglose` `g`) where ((`h`.`id_factura` = `g`.`id_factura`) and (`h`.`id_so_contratante` = `a`.`id_sujeto_obligado`) and (`h`.`id_ejercicio` = `b`.`id_ejercicio`))) AS `monto_total` from ((((`vact_sujetos_obligados` `a` join `cat_ejercicios` `b`) join `cat_so_atribucion` `d`) join `cat_so_ordenes_gobierno` `e`) join `cat_so_estados` `f`) where ((`b`.`active` = 1) and (`a`.`id_so_atribucion` = `d`.`id_so_atribucion`) and (`a`.`id_so_orden_gobierno` = `e`.`id_so_orden_gobierno`) and (`a`.`id_so_estado` = `f`.`id_so_estado`)) order by `a`.`id_sujeto_obligado`,`b`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtable1`
--
DROP VIEW IF EXISTS `vtable1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtable1`  AS  select concat(`b`.`capitulo`,'.',`b`.`concepto`,'.',`b`.`partida`) AS `Clave de partida`,`b`.`descripcion` AS `Descripción`,`d`.`ejercicio` AS `Ejercicio`,sum(`a`.`monto_presupuesto`) AS `Prespuesto Original`,sum(`a`.`monto_modificacion`) AS `Monto Modificado`,sum((`a`.`monto_presupuesto` + `a`.`monto_modificacion`)) AS `Presupuesto Modificado` from (((`tab_presupuestos_desglose` `a` join `cat_presupuesto_conceptos` `b`) join `tab_presupuestos` `c`) join `cat_ejercicios` `d`) where ((`a`.`id_presupuesto_concepto` = `b`.`id_presupesto_concepto`) and (`a`.`id_presupuesto` = `c`.`id_presupuesto`) and (`c`.`id_ejercicio` = `d`.`id_ejercicio`)) group by `b`.`partida`,`b`.`descripcion`,`d`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtable2`
--
DROP VIEW IF EXISTS `vtable2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtable2`  AS  select `b`.`id_proveedor` AS `id_proveedor`,`b`.`nombre_comercial` AS `Nombre o razón social`,(select count(0) from `tab_contratos` `c` where ((`c`.`id_ejercicio` = `a`.`id_ejercicio`) and (`c`.`id_proveedor` = `b`.`id_proveedor`))) AS `Contratos`,(select count(0) from `tab_ordenes_compra` `d` where ((`d`.`id_ejercicio` = `a`.`id_ejercicio`) and (`d`.`id_proveedor` = `b`.`id_proveedor`) and (`d`.`id_contrato` = 1))) AS `Órdenes de compra sin contrato`,(select if(isnull(sum(`e`.`monto_desglose`)),0,sum(`e`.`monto_desglose`)) from (`tab_facturas_desglose` `e` join `tab_facturas` `f`) where ((`e`.`id_factura` = `f`.`id_factura`) and (`f`.`id_ejercicio` = `a`.`id_ejercicio`) and (`f`.`id_proveedor` = `b`.`id_proveedor`))) AS `Monto total pagado`,`a`.`ejercicio` AS `Ejercicio` from (`cat_ejercicios` `a` join `tab_proveedores` `b`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_contratos_oc`
--
DROP VIEW IF EXISTS `vtab_contratos_oc`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_contratos_oc`  AS  select `a`.`numero_contrato` AS `numero_contrato`,`b`.`numero_orden_compra` AS `numero_orden_compra`,`d`.`nombre_campana_tipo` AS `tipo`,`c`.`nombre_campana_aviso` AS `nombre`,`e`.`ejercicio` AS `anio`,truncate((sum(`a`.`monto_contrato`) / 1000),0) AS `monto_presupuesto`,`a`.`id_contrato` AS `id_contrato`,`b`.`id_orden_compra` AS `id_orden_compra` from ((((`tab_contratos` `a` join `tab_ordenes_compra` `b`) join `tab_campana_aviso` `c`) join `cat_campana_tipos` `d`) join `cat_ejercicios` `e`) where ((`b`.`id_contrato` = `a`.`id_contrato`) and (`b`.`id_campana_aviso` = `c`.`id_campana_aviso`) and (`d`.`id_campana_tipo` = `c`.`id_campana_tipo`) and (`a`.`id_ejercicio` = `e`.`id_ejercicio`) and (`a`.`id_contrato` <> 1) and (`b`.`id_orden_compra` <> 1)) group by `a`.`numero_contrato`,`b`.`numero_orden_compra`,`d`.`nombre_campana_tipo`,`c`.`nombre_campana_aviso`,`e`.`ejercicio`,`a`.`id_contrato`,`b`.`id_orden_compra` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_presupuesto`
--
DROP VIEW IF EXISTS `vtab_presupuesto`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_presupuesto`  AS  select `b`.`partida` AS `partida`,`b`.`denominacion` AS `descripcion`,`d`.`ejercicio` AS `ejercicio`,sum(`a`.`monto_presupuesto`) AS `original`,sum(`a`.`monto_modificacion`) AS `modificaciones`,(sum(`a`.`monto_presupuesto`) + sum(`a`.`monto_modificacion`)) AS `presupuesto`,ifnull((select sum(`f`.`monto_desglose`) from (`tab_facturas` `e` join `tab_facturas_desglose` `f`) where ((`e`.`active` = 1) and (`f`.`active` = 1) and (`e`.`id_factura` = `f`.`id_factura`) and (`e`.`id_presupuesto_concepto` = `a`.`id_presupuesto_concepto`))),0) AS `ejercido` from (((`tab_presupuestos_desglose` `a` join `cat_presupuesto_conceptos` `b`) join `tab_presupuestos` `c`) join `cat_ejercicios` `d`) where ((`a`.`active` = 1) and (`b`.`active` = 1) and (`c`.`active` = 1) and (`d`.`active` = 1) and (`a`.`id_presupuesto` = `c`.`id_presupuesto`) and (`a`.`id_presupuesto_concepto` = `b`.`id_presupesto_concepto`) and (`d`.`id_ejercicio` = `c`.`id_ejercicio`)) group by `d`.`ejercicio`,`b`.`denominacion` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_presupuesto_des`
--
DROP VIEW IF EXISTS `vtab_presupuesto_des`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_presupuesto_des`  AS  select `ej`.`ejercicio` AS `ejercicio`,`con`.`partida` AS `partida`,`con`.`denominacion` AS `descripcion`,sum(`des`.`monto_presupuesto`) AS `original`,sum(`des`.`monto_modificacion`) AS `modificaciones`,(sum(`des`.`monto_presupuesto`) + sum(`des`.`monto_modificacion`)) AS `presupuesto`,(select sum(`fglo`.`monto_desglose`) from (`tab_facturas` `fac` join `tab_facturas_desglose` `fglo` on((`fac`.`id_factura` = `fglo`.`id_factura`))) where ((`fac`.`active` = 1) and (`fglo`.`active` = 1) and (`fac`.`id_ejercicio` = `ej`.`id_ejercicio`) and (`fac`.`id_presupuesto_concepto` = `des`.`id_presupuesto_concepto`))) AS `ejercido` from (((`tab_presupuestos_desglose` `des` join `tab_presupuestos` `pres` on((`pres`.`id_presupuesto` = `des`.`id_presupuesto`))) join `cat_ejercicios` `ej` on((`ej`.`id_ejercicio` = `pres`.`id_ejercicio`))) join `cat_presupuesto_conceptos` `con` on((`con`.`id_presupesto_concepto` = `des`.`id_presupuesto_concepto`))) group by `con`.`denominacion`,`ej`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_presupuesto_desglose`
--
DROP VIEW IF EXISTS `vtab_presupuesto_desglose`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_presupuesto_desglose`  AS  select `ej`.`ejercicio` AS `ejercicio`,`con`.`partida` AS `partida`,`con`.`denominacion` AS `descripcion`,sum(`des`.`monto_presupuesto`) AS `original`,sum(`des`.`monto_modificacion`) AS `modificaciones`,(sum(`des`.`monto_presupuesto`) + sum(`des`.`monto_modificacion`)) AS `presupuesto`,(select sum(`fglo`.`monto_desglose`) from (`tab_facturas` `fac` join `tab_facturas_desglose` `fglo` on((`fac`.`id_factura` = `fglo`.`id_factura`))) where ((`fac`.`active` = 1) and (`fglo`.`active` = 1) and (`fac`.`id_ejercicio` = `ej`.`id_ejercicio`) and ((`fglo`.`id_presupuesto_concepto` = `des`.`id_presupuesto_concepto`) or (`fglo`.`id_presupuesto_concepto_solicitante` = `des`.`id_presupuesto_concepto`)))) AS `ejercido` from (((`tab_presupuestos_desglose` `des` join `tab_presupuestos` `pres` on((`pres`.`id_presupuesto` = `des`.`id_presupuesto`))) join `cat_ejercicios` `ej` on((`ej`.`id_ejercicio` = `pres`.`id_ejercicio`))) join `cat_presupuesto_conceptos` `con` on((`con`.`id_presupesto_concepto` = `des`.`id_presupuesto_concepto`))) group by `con`.`denominacion`,`ej`.`ejercicio` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_presupuesto_PACS`
--
DROP VIEW IF EXISTS `vtab_presupuesto_PACS`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_presupuesto_PACS`  AS  select `c`.`id_presupuesto` AS `id_presupuesto`,`c`.`id_ejercicio` AS `id_ejercicio`,`c`.`denominacion` AS `denominacion` from (`tab_presupuestos` `c` join `cat_ejercicios` `a`) where ((`a`.`active` = 1) and (`c`.`active` = 1) and (`c`.`denominacion` <> '')) group by `c`.`denominacion`,`c`.`id_presupuesto` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtab_proveedores`
--
DROP VIEW IF EXISTS `vtab_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtab_proveedores`  AS  select `a`.`id_proveedor` AS `id_proveedor`,`b`.`ejercicio` AS `ejercicio`,`a`.`nombre_razon_social` AS `nombre`,(select count(0) from `tab_contratos` `c` where ((`a`.`id_proveedor` = `c`.`id_proveedor`) and (`c`.`id_ejercicio` = `b`.`id_ejercicio`) and (`c`.`id_contrato` > 1))) AS `contratos`,(select count(0) from `tab_ordenes_compra` `f` where ((`a`.`id_proveedor` = `f`.`id_proveedor`) and (`f`.`id_ejercicio` = `b`.`id_ejercicio`) and (`f`.`id_orden_compra` > 1) and (`f`.`id_contrato` = 1))) AS `ordenes`,(select ifnull(sum(`e`.`monto_desglose`),0) from (`tab_facturas` `d` join `tab_facturas_desglose` `e`) where ((`d`.`id_factura` = `e`.`id_factura`) and (`a`.`id_proveedor` = `d`.`id_proveedor`) and (`d`.`id_ejercicio` = `b`.`id_ejercicio`) and (`e`.`active` = 1) and (`d`.`active` = 1))) AS `monto` from (`tab_proveedores` `a` join `cat_ejercicios` `b`) having (`monto` <> 0) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtipo_campana_proveedor`
--
DROP VIEW IF EXISTS `vtipo_campana_proveedor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtipo_campana_proveedor`  AS  select `tab_campana_aviso`.`id_campana_aviso` AS `id_campana_aviso`,concat(`cat_campana_tipos`.`nombre_campana_tipo`,' - ',`tab_campana_aviso`.`nombre_campana_aviso`,' <a href=\'Sys_Detalle5?campana=',`tab_campana_aviso`.`id_campana_aviso`,'\' target=\'_blank\'></a>') AS `campana_aviso` from (`tab_campana_aviso` join `cat_campana_tipos`) where (`cat_campana_tipos`.`id_campana_tipo` = `tab_campana_aviso`.`id_campana_tipo`) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtop10_campanas`
--
DROP VIEW IF EXISTS `vtop10_campanas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtop10_campanas`  AS  select `a`.`id_campana_aviso` AS `id_campana_aviso`,sum(`a`.`monto_desglose`) AS `sum(a.monto_desglose)` from `vact_facturas_desglose` `a` group by `a`.`id_campana_aviso` order by sum(`a`.`monto_desglose`) desc limit 10 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vtop10_proveedores`
--
DROP VIEW IF EXISTS `vtop10_proveedores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`user_bd`@`%` SQL SECURITY DEFINER VIEW `vtop10_proveedores`  AS  select `b`.`id_proveedor` AS `id_proveedor`,sum(`a`.`monto_desglose`) AS `sum(a.monto_desglose)` from (`vact_facturas_desglose` `a` join `vact_facturas` `b`) where (`a`.`id_factura` = `b`.`id_factura`) group by `b`.`id_proveedor` order by sum(`a`.`monto_desglose`) desc limit 10 ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cat_campana_ambito_geo`
--
ALTER TABLE `cat_campana_ambito_geo`
  ADD PRIMARY KEY (`id_campana_ambito_geo`);

--
-- Indices de la tabla `cat_campana_coberturas`
--
ALTER TABLE `cat_campana_coberturas`
  ADD PRIMARY KEY (`id_campana_cobertura`);

--
-- Indices de la tabla `cat_campana_estatus`
--
ALTER TABLE `cat_campana_estatus`
  ADD PRIMARY KEY (`id_campana_estatus`);

--
-- Indices de la tabla `cat_campana_objetivos`
--
ALTER TABLE `cat_campana_objetivos`
  ADD PRIMARY KEY (`id_campana_objetivo`);

--
-- Indices de la tabla `cat_campana_subtipos`
--
ALTER TABLE `cat_campana_subtipos`
  ADD PRIMARY KEY (`id_campana_subtipo`),
  ADD KEY `id_campana_tipo` (`id_campana_tipo`);

--
-- Indices de la tabla `cat_campana_temas`
--
ALTER TABLE `cat_campana_temas`
  ADD PRIMARY KEY (`id_campana_tema`);

--
-- Indices de la tabla `cat_campana_tipos`
--
ALTER TABLE `cat_campana_tipos`
  ADD PRIMARY KEY (`id_campana_tipo`);

--
-- Indices de la tabla `cat_campana_tiposTO`
--
ALTER TABLE `cat_campana_tiposTO`
  ADD PRIMARY KEY (`id_campana_tipoTO`);

--
-- Indices de la tabla `cat_ejercicios`
--
ALTER TABLE `cat_ejercicios`
  ADD PRIMARY KEY (`id_ejercicio`);

--
-- Indices de la tabla `cat_meses`
--
ALTER TABLE `cat_meses`
  ADD PRIMARY KEY (`id_mes`);

--
-- Indices de la tabla `cat_personalidad_juridica`
--
ALTER TABLE `cat_personalidad_juridica`
  ADD PRIMARY KEY (`id_personalidad_juridica`);

--
-- Indices de la tabla `cat_poblacion_grupo_edad`
--
ALTER TABLE `cat_poblacion_grupo_edad`
  ADD PRIMARY KEY (`id_poblacion_grupo_edad`);

--
-- Indices de la tabla `cat_poblacion_lugar`
--
ALTER TABLE `cat_poblacion_lugar`
  ADD PRIMARY KEY (`id_poblacion_lugar`);

--
-- Indices de la tabla `cat_poblacion_nivel`
--
ALTER TABLE `cat_poblacion_nivel`
  ADD PRIMARY KEY (`id_poblacion_nivel`);

--
-- Indices de la tabla `cat_poblacion_nivel_educativo`
--
ALTER TABLE `cat_poblacion_nivel_educativo`
  ADD PRIMARY KEY (`id_poblacion_nivel_educativo`);

--
-- Indices de la tabla `cat_poblacion_sexo`
--
ALTER TABLE `cat_poblacion_sexo`
  ADD PRIMARY KEY (`id_poblacion_sexo`);

--
-- Indices de la tabla `cat_presupuesto_conceptos`
--
ALTER TABLE `cat_presupuesto_conceptos`
  ADD PRIMARY KEY (`id_presupesto_concepto`);

--
-- Indices de la tabla `cat_procedimientos`
--
ALTER TABLE `cat_procedimientos`
  ADD PRIMARY KEY (`id_procedimiento`);

--
-- Indices de la tabla `cat_servicios_categorias`
--
ALTER TABLE `cat_servicios_categorias`
  ADD PRIMARY KEY (`id_servicio_categoria`),
  ADD KEY `fk_clasifica_cate` (`id_servicio_clasificacion`);

--
-- Indices de la tabla `cat_servicios_clasificacion`
--
ALTER TABLE `cat_servicios_clasificacion`
  ADD PRIMARY KEY (`id_servicio_clasificacion`);

--
-- Indices de la tabla `cat_servicios_subcategorias`
--
ALTER TABLE `cat_servicios_subcategorias`
  ADD PRIMARY KEY (`id_servicio_subcategoria`),
  ADD KEY `FK_cat_servicios_subcategorias_cat_servicios_categorias` (`id_servicio_categoria`);

--
-- Indices de la tabla `cat_servicios_unidades`
--
ALTER TABLE `cat_servicios_unidades`
  ADD PRIMARY KEY (`id_servicio_unidad`),
  ADD KEY `FK_cat_servicios_unidades_cat_servicios_subcategorias` (`id_servicio_subcategoria`);

--
-- Indices de la tabla `cat_so_atribucion`
--
ALTER TABLE `cat_so_atribucion`
  ADD PRIMARY KEY (`id_so_atribucion`);

--
-- Indices de la tabla `cat_so_estados`
--
ALTER TABLE `cat_so_estados`
  ADD PRIMARY KEY (`id_so_estado`);

--
-- Indices de la tabla `cat_so_ordenes_gobierno`
--
ALTER TABLE `cat_so_ordenes_gobierno`
  ADD PRIMARY KEY (`id_so_orden_gobierno`);

--
-- Indices de la tabla `cat_tiempo_tipos`
--
ALTER TABLE `cat_tiempo_tipos`
  ADD PRIMARY KEY (`id_tiempo_tipo`);

--
-- Indices de la tabla `cat_tipo_liga`
--
ALTER TABLE `cat_tipo_liga`
  ADD PRIMARY KEY (`id_tipo_liga`);

--
-- Indices de la tabla `cat_trimestres`
--
ALTER TABLE `cat_trimestres`
  ADD PRIMARY KEY (`id_trimestre`);

--
-- Indices de la tabla `rel_campana_grupo_edad`
--
ALTER TABLE `rel_campana_grupo_edad`
  ADD PRIMARY KEY (`id_rel_campana_grupo_edad`),
  ADD UNIQUE KEY `id_campana_aviso` (`id_campana_aviso`,`id_poblacion_grupo_edad`),
  ADD KEY `FK_rel_campana_grupo_edad_cat_poblacion_grupo_edad` (`id_poblacion_grupo_edad`);

--
-- Indices de la tabla `rel_campana_lugar`
--
ALTER TABLE `rel_campana_lugar`
  ADD PRIMARY KEY (`id_campana_lugar`),
  ADD UNIQUE KEY `id_campana_aviso` (`id_campana_aviso`,`poblacion_lugar`);

--
-- Indices de la tabla `rel_campana_maudio`
--
ALTER TABLE `rel_campana_maudio`
  ADD PRIMARY KEY (`id_campana_maudio`),
  ADD KEY `fk_campana_meadios` (`id_campana_aviso`),
  ADD KEY `fk_maudio_tipo` (`id_tipo_liga`);

--
-- Indices de la tabla `rel_campana_mimagenes`
--
ALTER TABLE `rel_campana_mimagenes`
  ADD PRIMARY KEY (`id_campana_mimagen`),
  ADD KEY `fk_campana_mimg` (`id_campana_aviso`),
  ADD KEY `fk_mimg_tipo` (`id_tipo_liga`);

--
-- Indices de la tabla `rel_campana_mvideo`
--
ALTER TABLE `rel_campana_mvideo`
  ADD PRIMARY KEY (`id_campana_mvideo`),
  ADD KEY `fk_campana_mvideo` (`id_campana_aviso`),
  ADD KEY `fk_mvideo_tipo` (`id_tipo_liga`);

--
-- Indices de la tabla `rel_campana_nivel`
--
ALTER TABLE `rel_campana_nivel`
  ADD PRIMARY KEY (`id_rel_campana_nivel`),
  ADD UNIQUE KEY `id_campana_aviso` (`id_campana_aviso`,`id_poblacion_nivel`),
  ADD KEY `FK_rel_campana_nivel_cat_poblacion_nivel` (`id_poblacion_nivel`);

--
-- Indices de la tabla `rel_campana_nivel_educativo`
--
ALTER TABLE `rel_campana_nivel_educativo`
  ADD PRIMARY KEY (`id_rel_campana_nivel_educativo`),
  ADD UNIQUE KEY `id_campana_aviso` (`id_campana_aviso`,`id_poblacion_nivel_educativo`),
  ADD KEY `FK_rel_campana_nivel_educativo_cat_poblacion_nivel_educativo` (`id_poblacion_nivel_educativo`);

--
-- Indices de la tabla `rel_campana_sexo`
--
ALTER TABLE `rel_campana_sexo`
  ADD PRIMARY KEY (`id_rel_campana_sexo`),
  ADD UNIQUE KEY `Índice 2` (`id_campana_aviso`,`id_poblacion_sexo`),
  ADD KEY `FK_rel_campana_sexo_cat_poblacion_sexo` (`id_poblacion_sexo`);

--
-- Indices de la tabla `sec_users`
--
ALTER TABLE `sec_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `index_username` (`username`) USING BTREE,
  ADD UNIQUE KEY `index_mail` (`email`) USING BTREE,
  ADD KEY `FK_sec_users_tab_sujetos_obligados` (`record_user`);

--
-- Indices de la tabla `sys_active`
--
ALTER TABLE `sys_active`
  ADD PRIMARY KEY (`id_active`);

--
-- Indices de la tabla `sys_debug`
--
ALTER TABLE `sys_debug`
  ADD PRIMARY KEY (`id_debug`);

--
-- Indices de la tabla `sys_log`
--
ALTER TABLE `sys_log`
  ADD PRIMARY KEY (`id_log`);

--
-- Indices de la tabla `sys_logico`
--
ALTER TABLE `sys_logico`
  ADD PRIMARY KEY (`id_logico`);

--
-- Indices de la tabla `sys_settings`
--
ALTER TABLE `sys_settings`
  ADD PRIMARY KEY (`id_settings`);

--
-- Indices de la tabla `tab_campana_aviso`
--
ALTER TABLE `tab_campana_aviso`
  ADD PRIMARY KEY (`id_campana_aviso`),
  ADD KEY `fk_cobertura` (`id_campana_cobertura`),
  ADD KEY `fk_tipo` (`id_campana_tipo`),
  ADD KEY `fk_subtipo` (`id_campana_subtipo`),
  ADD KEY `fk_tema` (`id_campana_tema`),
  ADD KEY `fk_objetivo` (`id_campana_objetivo`),
  ADD KEY `fk_ejercicio` (`id_ejercicio`),
  ADD KEY `fk_trimestre` (`id_trimestre`),
  ADD KEY `fk_contratante` (`id_so_contratante`),
  ADD KEY `fk_solicitante` (`id_so_solicitante`),
  ADD KEY `fk_campana_ambito_geo` (`campana_ambito_geo`),
  ADD KEY `fk_tiempo` (`id_tiempo_oficial`);

--
-- Indices de la tabla `tab_contratos`
--
ALTER TABLE `tab_contratos`
  ADD PRIMARY KEY (`id_contrato`),
  ADD UNIQUE KEY `fl_numero` (`numero_contrato`) USING BTREE,
  ADD KEY `fk_procedimiento_contra` (`id_procedimiento`),
  ADD KEY `fk_ejercicio_contra` (`id_ejercicio`),
  ADD KEY `fk_proveedor_contra` (`id_proveedor`),
  ADD KEY `fk_trimestre_contra` (`id_trimestre`),
  ADD KEY `fk_so_contratante` (`id_so_contratante`),
  ADD KEY `fk_so_solicitante` (`id_so_solicitante`),
  ADD KEY `id_contrato` (`id_contrato`,`id_proveedor`);

--
-- Indices de la tabla `tab_convenios_modificatorios`
--
ALTER TABLE `tab_convenios_modificatorios`
  ADD PRIMARY KEY (`id_convenio_modificatorio`),
  ADD UNIQUE KEY `lk_numero` (`numero_convenio`) USING BTREE,
  ADD KEY `fk_contrato_convenio` (`id_contrato`),
  ADD KEY `fk_ejercicio_convenio` (`id_ejercicio`),
  ADD KEY `fk_trimestre_convenio` (`id_trimestre`);

--
-- Indices de la tabla `tab_facturas`
--
ALTER TABLE `tab_facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `fk_proveedor_fac` (`id_proveedor`),
  ADD KEY `fk_contrato_fac` (`id_contrato`),
  ADD KEY `fk_oc_fac` (`id_orden_compra`),
  ADD KEY `fk_ejercicio_fac` (`id_ejercicio`),
  ADD KEY `fk_trimestre_fac` (`id_trimestre`),
  ADD KEY `fk_so_contratante_fac` (`id_so_contratante`),
  ADD KEY `FK_tab_facturas_tab_presupuestos_desglose` (`id_presupuesto_concepto`);

--
-- Indices de la tabla `tab_facturas_desglose`
--
ALTER TABLE `tab_facturas_desglose`
  ADD PRIMARY KEY (`id_factura_desglose`),
  ADD KEY `fk_factura_df` (`id_factura`),
  ADD KEY `fk_campana_df` (`id_campana_aviso`),
  ADD KEY `FK_tab_facturas_desglose_tab_sujetos_obligados` (`id_so_solicitante`),
  ADD KEY `FK1` (`id_servicio_categoria`),
  ADD KEY `FK2` (`id_servicio_clasificacion`),
  ADD KEY `FK3` (`id_servicio_subcategoria`),
  ADD KEY `FK_tab_facturas_desglose_cat_servicios_unidades` (`id_servicio_unidad`);

--
-- Indices de la tabla `tab_fecha_actualizacion_manual`
--
ALTER TABLE `tab_fecha_actualizacion_manual`
  ADD PRIMARY KEY (`id_fecha_act`);

--
-- Indices de la tabla `tab_ordenes_compra`
--
ALTER TABLE `tab_ordenes_compra`
  ADD PRIMARY KEY (`id_orden_compra`),
  ADD KEY `lk_numero_oc` (`numero_orden_compra`) USING BTREE,
  ADD KEY `fk_proveedor_oc` (`id_proveedor`),
  ADD KEY `fk_contrato_oc` (`id_contrato`,`id_proveedor`),
  ADD KEY `fk_ejercicio_oc` (`id_ejercicio`),
  ADD KEY `fk_trimestre_oc` (`id_trimestre`),
  ADD KEY `fk_so_contratante_oc` (`id_so_contratante`),
  ADD KEY `fk_so_solicitante_oc` (`id_so_solicitante`),
  ADD KEY `fk_campana_oc` (`id_campana_aviso`),
  ADD KEY `FK_tab_ordenes_compra_cat_procedimientos` (`id_procedimiento`);

--
-- Indices de la tabla `tab_presupuestos`
--
ALTER TABLE `tab_presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD UNIQUE KEY `uk_ejercicio_sujeto` (`id_ejercicio`,`id_sujeto_obligado`),
  ADD KEY `FK_tab_presupuestos_tab_sujetos_obligados` (`id_sujeto_obligado`);

--
-- Indices de la tabla `tab_presupuestos_desglose`
--
ALTER TABLE `tab_presupuestos_desglose`
  ADD PRIMARY KEY (`id_presupuesto_desglose`),
  ADD UNIQUE KEY `uk_preusouesto` (`id_presupuesto`,`id_presupuesto_concepto`),
  ADD KEY `FK_tab_presupuestos_desglose_cat_presupuesto_conceptos` (`id_presupuesto_concepto`);

--
-- Indices de la tabla `tab_proveedores`
--
ALTER TABLE `tab_proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD UNIQUE KEY `rfc` (`rfc`),
  ADD KEY `fk_persona_pro` (`id_personalidad_juridica`);

--
-- Indices de la tabla `tab_servicios`
--
ALTER TABLE `tab_servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `fk_clasi` (`id_servicio_clasificacion`),
  ADD KEY `fk_catego` (`id_servicio_categoria`),
  ADD KEY `FK_tab_servicios_cat_servicios_subcategorias` (`id_servicio_subcategoria`),
  ADD KEY `FK_tab_servicios_cat_servicios_unidades` (`id_servicio_unidad`);

--
-- Indices de la tabla `tab_sujetos_obligados`
--
ALTER TABLE `tab_sujetos_obligados`
  ADD PRIMARY KEY (`id_sujeto_obligado`),
  ADD KEY `fk_atribucion` (`id_so_atribucion`),
  ADD KEY `fk_orden_gobierno` (`id_so_orden_gobierno`),
  ADD KEY `fk_estado` (`id_so_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cat_campana_ambito_geo`
--
ALTER TABLE `cat_campana_ambito_geo`
  MODIFY `id_campana_ambito_geo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_campana_coberturas`
--
ALTER TABLE `cat_campana_coberturas`
  MODIFY `id_campana_cobertura` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_campana_estatus`
--
ALTER TABLE `cat_campana_estatus`
  MODIFY `id_campana_estatus` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_campana_objetivos`
--
ALTER TABLE `cat_campana_objetivos`
  MODIFY `id_campana_objetivo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_campana_subtipos`
--
ALTER TABLE `cat_campana_subtipos`
  MODIFY `id_campana_subtipo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `cat_campana_temas`
--
ALTER TABLE `cat_campana_temas`
  MODIFY `id_campana_tema` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `cat_campana_tipos`
--
ALTER TABLE `cat_campana_tipos`
  MODIFY `id_campana_tipo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_campana_tiposTO`
--
ALTER TABLE `cat_campana_tiposTO`
  MODIFY `id_campana_tipoTO` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_ejercicios`
--
ALTER TABLE `cat_ejercicios`
  MODIFY `id_ejercicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_personalidad_juridica`
--
ALTER TABLE `cat_personalidad_juridica`
  MODIFY `id_personalidad_juridica` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_poblacion_grupo_edad`
--
ALTER TABLE `cat_poblacion_grupo_edad`
  MODIFY `id_poblacion_grupo_edad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cat_poblacion_lugar`
--
ALTER TABLE `cat_poblacion_lugar`
  MODIFY `id_poblacion_lugar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_poblacion_nivel`
--
ALTER TABLE `cat_poblacion_nivel`
  MODIFY `id_poblacion_nivel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cat_poblacion_nivel_educativo`
--
ALTER TABLE `cat_poblacion_nivel_educativo`
  MODIFY `id_poblacion_nivel_educativo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cat_poblacion_sexo`
--
ALTER TABLE `cat_poblacion_sexo`
  MODIFY `id_poblacion_sexo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_presupuesto_conceptos`
--
ALTER TABLE `cat_presupuesto_conceptos`
  MODIFY `id_presupesto_concepto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `cat_procedimientos`
--
ALTER TABLE `cat_procedimientos`
  MODIFY `id_procedimiento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_servicios_categorias`
--
ALTER TABLE `cat_servicios_categorias`
  MODIFY `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cat_servicios_clasificacion`
--
ALTER TABLE `cat_servicios_clasificacion`
  MODIFY `id_servicio_clasificacion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_servicios_subcategorias`
--
ALTER TABLE `cat_servicios_subcategorias`
  MODIFY `id_servicio_subcategoria` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `cat_servicios_unidades`
--
ALTER TABLE `cat_servicios_unidades`
  MODIFY `id_servicio_unidad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT de la tabla `cat_so_atribucion`
--
ALTER TABLE `cat_so_atribucion`
  MODIFY `id_so_atribucion` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_so_estados`
--
ALTER TABLE `cat_so_estados`
  MODIFY `id_so_estado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `cat_so_ordenes_gobierno`
--
ALTER TABLE `cat_so_ordenes_gobierno`
  MODIFY `id_so_orden_gobierno` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cat_tiempo_tipos`
--
ALTER TABLE `cat_tiempo_tipos`
  MODIFY `id_tiempo_tipo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_tipo_liga`
--
ALTER TABLE `cat_tipo_liga`
  MODIFY `id_tipo_liga` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cat_trimestres`
--
ALTER TABLE `cat_trimestres`
  MODIFY `id_trimestre` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `rel_campana_grupo_edad`
--
ALTER TABLE `rel_campana_grupo_edad`
  MODIFY `id_rel_campana_grupo_edad` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_lugar`
--
ALTER TABLE `rel_campana_lugar`
  MODIFY `id_campana_lugar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_maudio`
--
ALTER TABLE `rel_campana_maudio`
  MODIFY `id_campana_maudio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_mimagenes`
--
ALTER TABLE `rel_campana_mimagenes`
  MODIFY `id_campana_mimagen` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_mvideo`
--
ALTER TABLE `rel_campana_mvideo`
  MODIFY `id_campana_mvideo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_nivel`
--
ALTER TABLE `rel_campana_nivel`
  MODIFY `id_rel_campana_nivel` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_nivel_educativo`
--
ALTER TABLE `rel_campana_nivel_educativo`
  MODIFY `id_rel_campana_nivel_educativo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rel_campana_sexo`
--
ALTER TABLE `rel_campana_sexo`
  MODIFY `id_rel_campana_sexo` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sec_users`
--
ALTER TABLE `sec_users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sys_active`
--
ALTER TABLE `sys_active`
  MODIFY `id_active` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `sys_debug`
--
ALTER TABLE `sys_debug`
  MODIFY `id_debug` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sys_log`
--
ALTER TABLE `sys_log`
  MODIFY `id_log` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sys_logico`
--
ALTER TABLE `sys_logico`
  MODIFY `id_logico` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sys_settings`
--
ALTER TABLE `sys_settings`
  MODIFY `id_settings` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_campana_aviso`
--
ALTER TABLE `tab_campana_aviso`
  MODIFY `id_campana_aviso` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_contratos`
--
ALTER TABLE `tab_contratos`
  MODIFY `id_contrato` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tab_convenios_modificatorios`
--
ALTER TABLE `tab_convenios_modificatorios`
  MODIFY `id_convenio_modificatorio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_facturas`
--
ALTER TABLE `tab_facturas`
  MODIFY `id_factura` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_facturas_desglose`
--
ALTER TABLE `tab_facturas_desglose`
  MODIFY `id_factura_desglose` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_fecha_actualizacion_manual`
--
ALTER TABLE `tab_fecha_actualizacion_manual`
  MODIFY `id_fecha_act` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tab_ordenes_compra`
--
ALTER TABLE `tab_ordenes_compra`
  MODIFY `id_orden_compra` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tab_presupuestos`
--
ALTER TABLE `tab_presupuestos`
  MODIFY `id_presupuesto` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_presupuestos_desglose`
--
ALTER TABLE `tab_presupuestos_desglose`
  MODIFY `id_presupuesto_desglose` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tab_proveedores`
--
ALTER TABLE `tab_proveedores`
  MODIFY `id_proveedor` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tab_servicios`
--
ALTER TABLE `tab_servicios`
  MODIFY `id_servicio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tab_sujetos_obligados`
--
ALTER TABLE `tab_sujetos_obligados`
  MODIFY `id_sujeto_obligado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
