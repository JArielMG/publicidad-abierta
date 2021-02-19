CREATE ALGORITHM=UNDEFINED DEFINER=`usr_publicidad`@`%` SQL SECURITY DEFINER VIEW `vout_presupuestos_desglose_descarga`  AS  
select `a`.`id_presupuesto_desglose` AS `ID de desglose`,`a`.`id_presupuesto` AS `ID de presupuesto`,
(select `b`.`partida` from `cat_presupuesto_conceptos` `b` where (`a`.`id_presupuesto_concepto` = `b`.`id_presupesto_concepto`)) AS `Partida presupuestal`,
`a`.`fuente_federal`, `a`.`monto_fuente_federal`, `a`.`fuente_local`, `a`.`monto_fuente_local`, `a`.`fecha_validacion`, `a`.`area_responsable`, `a`.`fecha_actualizacion`,
`a`.`nota`, `a`.`periodo`, `a`.`monto_presupuesto` AS `Monto asignado`,`a`.`monto_modificacion` AS `Monto de modificación`,
(select `j`.`name_active` from `sys_active` `j` where (`a`.`active` = `j`.`id_active`)) AS `Estatus` from `tab_presupuestos_desglose` `a` ;
