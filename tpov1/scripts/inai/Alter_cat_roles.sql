-- 
-- Eliminar en caso de que exista un dato en la posición 3 de la tabla
--

delete from cat_roles_administracion where id_rol = '3';

--
-- Volcado de datos para la tabla `cat_roles_administracion` rol Financiero
--

insert into cat_roles_administracion values ('3', 'Financiero', 'Rol encargado de registrar el presupuesto anual.', 'a', '2020-11-13');