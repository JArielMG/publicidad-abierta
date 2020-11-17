--
-- Base de datos: `inai`
--

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
(1, 'Administrador', 'Rol encargado de supervisar todo.', 'a', '2018-12-03'),
(2, 'Capturista', 'Rol encargado de alimentar la Base de Datos', 'a', '2018-12-04');
(3, 'Financiero', 'Rol encargado de registrar el presupuesto anual.', 'a', '2020-11-13');

-- --------------------------------------------------------