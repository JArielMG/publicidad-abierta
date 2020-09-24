--
-- Modificaciones en las tablas `tab_contratos`, `tab_convenios_modificatorios`
--

ALTER TABLE tab_contratos ADD COLUMN `url_contrato` text AFTER `file_contrato`;

ALTER TABLE tab_convenios_modificatorios ADD COLUMN `url_convenio` text AFTER `file_convenio`;


--
-- Modificaciones en las tabla `tab_facturas`
--

ALTER TABLE tab_facturas ADD COLUMN `url_factura_pdf` text AFTER `file_factura_pdf`;

ALTER TABLE tab_facturas ADD COLUMN `url_factura_xml` text AFTER `file_factura_xml`;

--
-- Modificaciones en las tabla `tab_ordenes_compra`
--

ALTER TABLE tab_ordenes_compra ADD COLUMN `url_orden` text AFTER `file_orden`;

--
-- Modificaciones en las tabla `tab_presupuestos`
--

ALTER TABLE tab_presupuestos ADD COLUMN `url_programa_anual` text AFTER `file_programa_anual`;
