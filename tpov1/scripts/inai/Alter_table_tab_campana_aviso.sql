--
-- Modificaciones en la tabla `tab_campana_aviso`
--

ALTER TABLE tab_campana_aviso ADD COLUMN `fecha_inicio_periodo` date AFTER `objetivo_comunicacion`;
ALTER TABLE tab_campana_aviso ADD COLUMN `fecha_termino_periodo` date AFTER `fecha_inicio_periodo`;
ALTER TABLE tab_campana_aviso ADD COLUMN `id_campana_tipoTO` bigint(20) UNSIGNED NOT NULL AFTER `id_tiempo_oficial`;
ALTER TABLE tab_campana_aviso ADD COLUMN `id_presupuesto` bigint(20) UNSIGNED NOT NULL AFTER `id_campana_tipoTO`;
ALTER TABLE tab_campana_aviso ADD COLUMN `monto_tiempo` varchar(50) AFTER `fecha_termino_periodo`;
ALTER TABLE tab_campana_aviso ADD COLUMN `hora_to` varchar(50) AFTER `monto_tiempo`;
ALTER TABLE tab_campana_aviso ADD COLUMN `minutos_to` varchar(50) AFTER `hora_to`;
ALTER TABLE tab_campana_aviso ADD COLUMN `segundos_to` varchar(50) AFTER `minutos_to`;
ALTER TABLE tab_campana_aviso ADD COLUMN `mensajeTO` text AFTER `segundos_to`;

--
-- Actualización 14_sep_20
--

ALTER TABLE tab_campana_aviso ADD COLUMN `id_servicio_categoria` bigint(20) UNSIGNED NOT NULL AFTER `id_presupuesto`;
ALTER TABLE tab_campana_aviso ADD COLUMN `descripcion_unidad` text AFTER `mensajeTO`;
ALTER TABLE tab_campana_aviso ADD COLUMN `responsable_publisher` text AFTER `descripcion_unidad`;
ALTER TABLE tab_campana_aviso ADD COLUMN `name_comercial` text AFTER `responsable_publisher`;
ALTER TABLE tab_campana_aviso ADD COLUMN `razones_supplier` text AFTER `name_comercial`;
ALTER TABLE tab_campana_aviso ADD COLUMN `difusion_mensaje` text AFTER `razones_supplier`;
ALTER TABLE tab_campana_aviso ADD COLUMN `num_factura` text AFTER `difusion_mensaje`;