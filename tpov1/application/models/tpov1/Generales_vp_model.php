<?php

/*
INAI / Generales model vista publica
 */

class Generales_vp_model extends CI_Model
{

    function dateToFormat($fecha)
    {
        if(!empty($fecha) && $fecha != '0000-00-00'){
            $aux = DateTime::createFromFormat('Y-m-d', $fecha);
            if($aux !== false)  
                return $aux->format('d/m/Y'); 
        }
        return '';
        
    }

    function get_fecha_actualizacion()
    {

        $this->db->where('active', 'a');
        $query = $this->db->get('tab_fecha_actualizacion_manual');

        $fecha_actualizacion = '';
        if($query->num_rows() > 0){
            foreach($query->result_array() as $row){
                $fecha_actualizacion = $row['fecha_act'];
            }
        }
        return $this->dateToFormat($fecha_actualizacion);
    }

    /* Obtiene el último ejercicio */
    function get_ultimo_id_ejercicio_con_erogacion()
    {
        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $this->db->where('active', '1');
        $this->db->order_by('id_ejercicio', 'DESC');
        $query = $this->db->get('cat_ejercicios');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) { 
                $reg = $this->Facturas_model->get_monto_factura_by_idejercicio($row['id_ejercicio']);
                if(!empty($reg) && count($reg) > 0){
                    $total = intval($reg[0]['total']);
                    $monto = floatval($reg[0]['monto_erogado']);

                    if($total > 0 && $monto > 0 ){
                        return $row['id_ejercicio'];
                    }
                }
            }
        }
    }

    function get_indicadores_ayuda()
    {
        $texto = array(
            'ejercicio' => 'Selecciona un ejercicio fiscal para visualizar las cifras correspondientes a ese a&ntilde;o. Tambi&eacute;n puedes seleccionar “Todos” los a&ntilde;os.',
            'monto_servicio_difucion' => 'Muestra el monto gastado en servicios de difusi&oacute;n, estos pueden ser: radio, televisi&oacute;n, cine, medios impresos, medios complementarios, Internet, otros, en el periodo seleccionado.',
            'monto_servicio_otro' => 'Muestra el monto gastado en otros servicios relacionados con la comunicaci&oacute;n, como son: producci&oacute;n de contenidos, impresiones, estudios y m&eacute;tricas, en el periodo seleccionado.',
            'tabla_porservicio' => 'Se muestra cada erogaci&oacute;n asociada  por tipo de servicio, como son: televisi&oacute;n, medios impresos, Internet, entre otros.',
            'grafica_servicio' => 'Muestra el gasto por tipo de difusi&oacute;n: radio, televisi&oacute;n, cine, medios impresos, medios complementarios, Internet, otros, en el periodo seleccionado. ',
            'numero_contratos' => 'Muestra el n&uacute;mero total de contratos en el periodo seleccionado.',
            'numero_ordenes' => 'Muestra el n&uacute;mero de &oacute;rdenes de compra que no est&aacute;n asociadas a un contrato, las &oacute;rdenes de compra pueden ser &oacute;rdenes de transmisi&oacute;n para radio y televisi&oacute;n, &oacute;rdenes de inserci&oacute;n para medios impresos, &oacute;rdenes de servicios para medios complementarios, internet y cine, en el periodo seleccionado.',
            'monto_contratos_ordenes' => 'Muestra el monto total gastado en contratos y &oacute;rdenes de compra que no están asociadas a un contrato, en el periodo seleccionado.',
            'tabla_contratos' => 'Se muestran los contratos por proveedor, as&iacute; como el monto ejercido.',
            'tabla_ordenes' => 'Se muestran las &oacute;rdenes de compra por proveedor, as&iacute; como el monto ejercido.',
            'grafica_co' => 'Se muestra el pocentaje de contratos vs ordenes de compra en el periodo seleccionado.',
            'facturas' => 'Muestra el n&uacute;mero de facturas del periodo seleccionado.',
            'monto_facturas' => 'Muestra el monto total gastado en erogaciones en el periodo seleccionado.',
            'grafica_facturas' => 'Se muestran las erogaciones del sujeto por mes.',
            'tabla_factura' => 'Se muestran los registros de cada erogaci&oacute;n realizada al periodo seleccionado.',
            'so_contratantes' => 'Muestra el n&uacute;mero de sujetos obligados  que tienen la atribuci&oacute;n de contratar servicios o productos, y que son usuarios de la plataforma.',
            'so_solicitantes' => 'Muestra el n&uacute;mero de sujetos obligados  que tienen la atribuci&oacute;n de solicitar servicios o productos, y que son usuarios de la plataforma.',
            'so_contratantes_solicitantes' => 'Muestra el n&uacute;mero de sujetos obligados  que tienen la atribuci&oacute;n de solicitar y contratar servicios o productos, y que son usuarios de la plataforma.',
            'grafica_so' => 'Muestra las campañas o avisos institucionales en las que, los sujetos obligados, han ejercido recursos en publicidad oficial, al periodo seleccionado.',
            'tabla_so' => 'Se muestran enlistados los sujetos obligados, as&iacute; como el presupuesto ejercido en publicidad oficial por cada uno de ellos.',
            'ejercicio_n' => 'Ejercicio.',
            'presupuesto_n' => 'Presupuesto original.',
            'modificacion_n' => 'presupuesto modificado.',
            'ejercido_n' => 'Presupuesto gastado.',
            'proveedores_n' => 'Proveedores',
            'campanas_avisos_n' => 'Campa&ntilde;as/avisos.',
            'gasto_por_partida_n' => 'Gasto por partida (gr&aacute;fica).',
            'recursos_ejercidos_n' => 'Recursos ejercidos (gr&aacute;fica).',
            'gasto_por_servicio_n' => 'Gasto por tipo de servicio (gr&aacute;fica).',
            'campanas_avisos_g_n' => 'Campa&ntilde;as o avisos insitucionales (gr&aacute;fica).',
            'top_10_campanas_n' => 'Muestra de forma global las 10 campa&ntilde;as o avisos institucionales que registran el mayor gasto, de acuerdo al ejercicio seleccionado en el filtro &quot;Ejercicio&quot;.',
            'top_10_proveedores_n' => 'Muestra de forma global los 10 proveedores con mayor gasto, de acuerdo al ejercicio seleccionado en el filtro &quot;Ejercicio&quot;.',
            'tabla_presupuestos' => 'Muestra el desglose de presupuesto organizado por partida y por año, con los siguientes datos: presupuesto original, monto modificado, presupuesto modificado y presupuesto ejercido a la fecha.',
            'btn_download' => 'Datos abiertos: descarga los datos publicados en esta p&aacute;gina en formato CSV para facilitar su uso y reutilizaci&oacute;n.',
            'proveedores_n' => 'Muestra el n&uacute;mero de proveedores contratados en el periodo seleccionado.',
            'monto_gastado_n' => 'Muestra el monto total gastado en el periodo seleccionado por el total de proveedores.',
            'tabla_proveedores_n' => 'Se muestra el presupuesto ejercido en publicidad oficial por proveedor.',
            'grafica_proveedores_n' => 'Se muestran los tipos de servicio, como son: televisi&oacute;n, medios, impresos, internet, entre otros, adquiridos por contrato u orden de compra, asociados a los proveedores cuya erogaci&oacute;n total, por cada tipo de servicio sea mayor al valor selecciona en el filtro &quot;Montos mayores a&quot;.',
            'montos_mayores_n' => 'El valor del filtro de inicia en el promedio del monto total ejercido en el ejercicio seleccionado. Se puede manipular el filtro a montos mayores del promedio.',
            'grafica_co_meses' => 'Se muestran las cantidades totales, por mes, de contratos y &oacute;rdenes de compra en el periodo seleccionado.',
            'grafica_co_total' => 'Se muestra el monto ejercido de contratos  y &oacute;rdenes de compra en el periodo seleccionado.',
            'btn_descarga_pnt' => 'Descarga en formato de la Plataforma Nacional de Transparencia.',
            'proveedores_inicio' => 'Proveedores.',
            'presupuesto_ejercido_presupuesto' => 'Presupuesto ejercido.',
            'grafica_presupuesto' => 'Gr&aacute;fica.',
            'so_contratante_n' => 'Sujetos obligados contratantes.',
            'so_solicitante_n' => 'Sujetos obligados solicitantes.',
            'so_grafica' => 'Muestra los sujetos obligados que hayan ejercido recursos en publicidad oficial, al periodo seleccionado.',
            'erogaciones_monto' => 'Monto gastado.',
            'erogaciones_facturas' => 'Facturas.',
            'grafica_campanas_avisos' => 'Muestra las campa&ntilde;as o avisos institucionales al periodo seleccionado.',
            'tabla_campanas' => 'Se muestran enlistadas las campa&ntilde;as, as&iacute; como el presupuesto ejercido en cada elemento por trimestre y al per&iacute;odo seleccionado.',
            'tabla_avisos' => 'Se muestran enlistados los avisos institucionales, as&iacute como el presupuesto ejercido en cada elemento por trimestre y al per&iacute;odo seleccionado.',
            'monto_total_ejercido' => 'Monto total ejercido.',
            'avisos_institucionales' => 'Avisos institucionales.',
            'campanas' => 'Campa&ntilde;as.',
            'monto_oc' => 'Monto total de la orden de compra, con I.V.A. incluido.',
            '' => ''
        );

        return $texto;
    }

    function get_texto_ayuda()
    {
        $texto = array(
            'ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
            contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'monto_original' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado' => 'Monto pagado a la fecha del periodo publicado.',
            'proveedor' => 'Nombre o raz&oacute;n social del proveedor.',
            'nombre_comercial_proveedor' => 'Nombre comercial del proveedor.',
            'numero_convenio' => 'N&uacute;mero del convenio',
            'monto_convenio' => 'Indica el monto del convenio modificatorio, en caso que aplique.',
            'monto_orden_compra' => 'Indica el monto de la orden de compra.',
            'fecha_orden_compra' => 'Fecha de la orden de compra con el formato dd/mm/yyyy (por ej. 31/12/2016).',
            'numero_factura' => 'N&uacute;mero de factura.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n.',
            'clasificacion_n' => 'Clasificaci&oacute;n del servicio.',
            'categoria' => 'Categor&iacute;a del servicio.',
            'subcategoria' => 'Subcategor&iacute;a del servicio.',
            'monto_gastado' => 'Monto gastado.',
            'objeto_contrato' => 'Indica el objeto del contrato',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios contratados, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_fin' => 'Indica la fecha de t&eacute;rmino de los servicios contratados, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado' => 'Monto pagado al periodo publicado.',
            'monto_factura' => 'Indica el monto total correspondiente a la factura.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo del contrato en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nombre_procedimiento' => 'Indica el tipo de procedimiento administrativo que se llevó a cabo para la contrataci&oacute;n.',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF',
            'file_factura_pdf' => 'Archivo eletr&oacute;nico de la factura en formato PDF',
            'url_factura_xml' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo eletr&oacute;nico de la factura en formato XML',
            'monto_subconcepto' => 'Indica el monto correspondiente a cada subconcepto, calculado con la multiplicaci&oacute;n de la cantidad por el precio unitario con IVA incluido del producto o servicio adquirido.',
            'partida' => 'Indica la clave y el nombre del concepto o partida presupuestal',
            'clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio encargada de solicitar el servicio',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'sin_definir' => 'sin definir',
            'monto_oc' => 'Monto total de la orden de compra, con I.V.A. incluido.'
        );

        return $texto;
    }

    function limpiar_Cadena($str)
    {
        return htmlspecialchars(addslashes($this->limpiarCadena($this->mysql_escape_mimic(strip_tags($str)))));
    }

    private function limpiarCadena($valor){
        $valor = str_ireplace("javascript:alert","",$valor);
        $valor = str_ireplace("alert","",$valor);
        $valor = str_ireplace("SELECT","",$valor);
            $valor = str_ireplace("INSERT","",$valor); 
        $valor = str_ireplace("COPY","",$valor);
        $valor = str_ireplace("DELETE","",$valor);
        $valor = str_ireplace("DROP","",$valor);
        $valor = str_ireplace("DUMP","",$valor);
        $valor = str_ireplace(" OR ","",$valor);
        $valor = str_ireplace(" AND ","",$valor);
        $valor = str_ireplace("%","",$valor);
        $valor = str_ireplace("LIKE","",$valor);
        $valor = str_ireplace("--","",$valor);
        $valor = str_ireplace("^","",$valor);
        $valor = str_ireplace("[","",$valor);
        $valor = str_ireplace("]","",$valor);
        $valor = str_ireplace("\\","",$valor);
        $valor = str_ireplace("!","",$valor);
        $valor = str_ireplace("¡","",$valor);
        $valor = str_ireplace("?","",$valor);
        $valor = str_ireplace("=","",$valor);
        $valor = str_ireplace("&","",$valor);
        $valor = str_ireplace("<?php","",$valor);
        $valor = str_ireplace("?>","",$valor);
        
        return $valor;
    }
    
    private function mysql_escape_mimic($inp) { 
        if(is_array($inp)) 
            return array_map(__METHOD__, $inp); 
     
        if(!empty($inp) && is_string($inp)) { 
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp); 
        } 
        return $inp; 
    } 
}

?>