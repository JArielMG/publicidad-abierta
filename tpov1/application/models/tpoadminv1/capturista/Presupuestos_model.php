<?php

/**
 * Description of Presupuestos_model
 *
 * INAI TPO 
 * 
 * DIC 2018
 */
class Presupuestos_Model extends CI_Model
{

    function registro_bitacora($seccion,$accion){
        $this->load->model('tpoadminv1/bitacora/Bitacora_model');

        $reg_bitacora = array(
            'seccion' => $seccion, 
            'accion' => $accion 
        );

        $this->Bitacora_model->guardar_bitacora_general($reg_bitacora);

    }

    function get_estatus_name($estatus)
    {
        if($estatus == 1){
            return 'Activo';
        }else if($estatus == 2){
            return 'Inactivo';
        }else if($estatus == 3){
            return 'En Proceso';
        }else if($estatus == 4){
            return 'Pago Emitido';
        }else {
            return '-Seleccione-';
        }
    }

    function dateToString($fecha)
    {
        if(!empty($fecha) && $fecha != '0000-00-00'){
            $aux = DateTime::createFromFormat('Y-m-d', $fecha);
            if($aux !== false)  
                return $aux->format('d.m.Y'); 
        }
        return '';
        
    }

    function stringToDate($fecha)
    {
        $date = '';
        if(!empty($fecha))
        {
            $cad_date = str_replace('.', '-', $fecha);
            $aux = DateTime::createFromFormat('d-m-Y', $cad_date);
            if($aux !== false)  
                $date = $aux->format('Y-m-d'); 
                
        }
        return $date;
    }

    function getMontosPartidas($id_presupuesto)
    {

        $this->load->model('tpoadminv1/Generales_model');
        $registros = $this->dame_presupuestos_desglose_id_presupuesto($id_presupuesto);
        
        $montos = array(
            'monto_presupuesto' => '$0.00',
            'monto_modificacion' => '$0.00',
            'presupuesto_modificado' => '$0.00'
        );

        if(isset($registros))
        {
            $mp = 0;
            $mm = 0;
            for($z = 0; $z < sizeof($registros); $z++)
            {
                if($registros[$z]['active'] == 'Activo'){
                    $mp += $registros[$z]['monto_presupuesto'];
                    $mm += $registros[$z]['monto_modificacion'];
                }
            }
            //setlocale(LC_MONETARY,"es_ES");
            $montos['monto_presupuesto'] = $this->Generales_model->money_format("%.2n", $mp);
            $montos['monto_modificacion'] =  $this->Generales_model->money_format("%.2n", $mm);
            $montos['presupuesto_modificado'] = $this->Generales_model->money_format("%.2n", ($mm + $mp));
        }
        return $montos;
    }

    function dame_todos_presupuestos()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        $query = $this->db->get('tab_presupuestos');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontosPartidas($row['id_presupuesto']);
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_presupuesto'] = $row['id_presupuesto'];
                $array_items[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $array_items[$cont]['nombre_sujeto_obligado'] = $this->dame_nombre_sujeto($row['id_sujeto_obligado']);
                $array_items[$cont]['monto_presupuesto'] = $montos['monto_presupuesto'];
                $array_items[$cont]['monto_modificacion'] = $montos['monto_modificacion'];
                $array_items[$cont]['presupuesto_modificado'] = $montos['presupuesto_modificado'];
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_presupuesto_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->db->where('id_presupuesto', $id);
        
        $query = $this->db->get('tab_presupuestos');
        
        if ($query->num_rows() == 1)
        {
            $registro = '';
            foreach ($query->result_array() as $row) { 
                $montos = $this->getMontosPartidas($row['id_presupuesto']);
                $registro = array(
                    'id_presupuesto' => $row['id_presupuesto'],
                    'id_ejercicio' => $row['id_ejercicio'],
                    'ejercicio' => $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']),
                    'id_sujeto_obligado' => $row['id_sujeto_obligado'],
                    'nombre_sujeto_obligado' => $this->dame_nombre_sujeto($row['id_sujeto_obligado']),
                    'denominacion' => $row['denominacion'],
                    'fecha_publicacion' => $this->dateToString($row['fecha_publicacion']),
                    'url_programa_anual' => $row['url_programa_anual'],
                    'file_programa_anual' => $row['file_programa_anual'],
                    'fecha_validacion' => $this->dateToString($row['fecha_validacion']),
					'fecha_inicio_periodo' => $this->dateToString($row['fecha_inicio_periodo']),
                    'fecha_termino_periodo' => $this->dateToString($row['fecha_termino_periodo']),
                    'area_responsable' => $row['area_responsable'],
                    'anio' => $row['anio'],
                    'fecha_actualizacion' => $this->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'mision' => $row['mision'],
                    'objetivo' => $row['objetivo'],
                    'metas' => $row['metas'],
                    'temas' => $row['temas'],
                    'programas' => $row['programas'],
                    'objetivo_transversal' => $row['objetivo_transversal'],
                    'conjunto_campanas' => $row['conjunto_campanas'],
                    'nota_planeacion' => $row['nota_planeacion'],
                    'monto_presupuesto' => $montos['monto_presupuesto'],
                    'monto_modificacion' => $montos['monto_modificacion'],
                    'presupuesto_modificado' => $montos['presupuesto_modificado'],
                    'name_file_programa_anual' => $row['file_programa_anual'],
                    'estatus' => $this->get_estatus_name($row['active']),
                    'active' => $row['active']
                );
            }
            return $registro;
        }else{
            return '';
        }
    }

    function descarga_presupuestos()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = 'dist/csv/presupuestos.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_presupuestos');
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Sujeto obligado'),
                    utf8_decode('Fecha de inicio del periodo que se informa'),
                    utf8_decode('Fecha de termino del periodo que se informa'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable'),
                    utf8_decode('Año'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'),
                    utf8_decode('Denominación del documento'),
                    utf8_decode('Misión y Visión oficiales del Ente Público'),
                    utf8_decode('Objetivo u objetivos institucionales'),
                    utf8_decode('Metas nacionales y/o Estrategias transversales establecidas en el Plan Nacional de Desarrollo'),
                    utf8_decode('Programa o programas sectoriales'),
                    utf8_decode('Objetivo estratégico o transversal'),
                    utf8_decode('Temas específicos derivados de los objetivos estratégicos o transversales'),
                    utf8_decode('Conjunto de Campañas de Comunicación Social a difundirse en el ejercicio fiscal respectivo'),
                    utf8_decode('Hipervínculo al programa anual'),
                    utf8_decode('Archivo del programa anual'),
                    utf8_decode('Fecha publicación'),
                    utf8_decode('Nota'),
                    utf8_decode('Presupuesto original'),
                    utf8_decode('Monto modificado'),
                    utf8_decode('Presupuesto modificado'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontosPartidas($row['id_presupuesto']);
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->dame_nombre_sujeto($row['id_sujeto_obligado'])),
		            utf8_decode($this->dateToString($row['fecha_inicio_periodo'])),
                    utf8_decode($this->dateToString($row['fecha_termino_periodo'])),
                    utf8_decode($this->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['anio']),
                    utf8_decode($this->dateToString($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota'])),
                    utf8_decode($row['denominacion']),
                    utf8_decode($row['mision']),
                    utf8_decode($row['objetivo']),
                    utf8_decode($row['metas']),
                    utf8_decode($row['programas']),
                    utf8_decode($row['objetivo_transversal']),
                    utf8_decode($row['temas']),
                    utf8_decode($row['conjunto_campanas']),
                    utf8_decode($row['url_programa_anual']),
                    utf8_decode($row['file_programa_anual']),
                    utf8_decode($this->dateToString($row['fecha_publicacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota_planeacion'])),
                    utf8_decode($montos['monto_presupuesto']),
                    utf8_decode($montos['monto_modificacion']),
                    utf8_decode($montos['presupuesto_modificado']),
                    utf8_decode($this->get_estatus_name($row['active']))
                    
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function agregar_presupuesto()
    {
        $this->db->where('id_ejercicio', $this->input->post('id_ejercicio'));
        $this->db->where('id_sujeto_obligado', $this->input->post('id_sujeto_obligado'));
        
        $query = $this->db->get('tab_presupuestos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_presupuesto' => '',
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_sujeto_obligado' => $this->input->post('id_sujeto_obligado'),
                'denominacion' => $this->input->post('denominacion'),
                'fecha_publicacion' => $this->stringToDate($this->input->post('fecha_publicacion')),
                'url_programa_anual' => $this->input->post('url_programa_anual'),
                'file_programa_anual' => $this->input->post('name_file_programa_anual'),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
				'fecha_inicio_periodo' => $this->stringToDate($this->input->post('fecha_inicio_periodo')),
                'fecha_termino_periodo' => $this->stringToDate($this->input->post('fecha_termino_periodo')),
                'area_responsable' => $this->input->post('area_responsable'),
                'anio' => $this->input->post('anio'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'mision' => $this->input->post('mision'),
                'objetivo' => $this->input->post('objetivo'),
                'metas' => $this->input->post('metas'),
                'temas' => $this->input->post('temas'),
                'programas' => $this->input->post('programas'),
                'objetivo_transversal' => $this->input->post('objetivo_transversal'),
                'conjunto_campanas' => $this->input->post('conjunto_campanas'),
                'nota_planeacion' => $this->input->post('nota_planeacion'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_presupuestos', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $ejercicio = $this->Catalogos_model->dame_nombre_ejercicio($data_new['id_ejercicio']);
                $sujeto = $this->dame_nombre_sujeto($data_new['id_sujeto_obligado']);
                $this->registro_bitacora('Planeación y presupuestos', 'Alta presupuesto ' . $ejercicio . " " . $sujeto);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_presupuesto()
    {
        $this->db->where('id_ejercicio', $this->input->post('id_ejercicio'));
        $this->db->where('id_sujeto_obligado', $this->input->post('id_sujeto_obligado'));
        $this->db->where_not_in('id_presupuesto', $this->input->post('id_presupuesto'));
        
        $query = $this->db->get('tab_presupuestos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_sujeto_obligado' => $this->input->post('id_sujeto_obligado'),
                'denominacion' => $this->input->post('denominacion'),
                'fecha_publicacion' => $this->stringToDate($this->input->post('fecha_publicacion')),
                'url_programa_anual' => $this->input->post('url_programa_anual'),
                'file_programa_anual' => $this->input->post('name_file_programa_anual'),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
				'fecha_inicio_periodo' => $this->stringToDate($this->input->post('fecha_inicio_periodo')),
                'fecha_termino_periodo' => $this->stringToDate($this->input->post('fecha_termino_periodo')),
                'area_responsable' => $this->input->post('area_responsable'),
                'anio' => $this->input->post('anio'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'mision' => $this->input->post('mision'),
                'objetivo' => $this->input->post('objetivo'),
                'metas' => $this->input->post('metas'),
                'temas' => $this->input->post('temas'),
                'programas' => $this->input->post('programas'),
                'objetivo_transversal' => $this->input->post('objetivo_transversal'),
                'conjunto_campanas' => $this->input->post('conjunto_campanas'),
                'nota_planeacion' => $this->input->post('nota_planeacion'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_presupuesto', $this->input->post('id_presupuesto'));
            $this->db->update('tab_presupuestos', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $ejercicio = $this->Catalogos_model->dame_nombre_ejercicio($data_new['id_ejercicio']);
                $sujeto = $this->dame_nombre_sujeto($data_new['id_sujeto_obligado']);
                $this->registro_bitacora('Planeación y presupuestos', 'Edición presupuesto: ' . $ejercicio . " " . $sujeto);
                return 1; // is correct
            }else
            {
                // any trans error?
                if ($this->db->trans_status() === FALSE) {
                    return 0; // sometime is wrong
                }else{
                    return 1;
                }
            }
        }
    }


    function dame_presupuestos_desglose_id_presupuesto($id)
    {
        $this->db->where('id_presupuesto', $id);
        $query = $this->db->get('tab_presupuestos_desglose');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_presupuesto_desglose'] = $row['id_presupuesto_desglose'];
                $array_items[$cont]['id_presupuesto'] = $row['id_presupuesto'];
                $array_items[$cont]['id_presupuesto_concepto'] = $row['id_presupuesto_concepto'];
                $array_items[$cont]['fuente_federal'] = $row['fuente_federal'];
                $array_items[$cont]['monto_fuente_federal'] = $row['monto_fuente_federal'];
                $array_items[$cont]['fuente_local'] = $row['fuente_local'];
                $array_items[$cont]['monto_fuente_local'] = $row['monto_fuente_local'];
                $array_items[$cont]['monto_presupuesto'] = $row['monto_presupuesto'];
                $array_items[$cont]['monto_modificacion'] = $row['monto_modificacion'];
                $array_items[$cont]['fecha_validacion'] = $row['fecha_validacion'];
                $array_items[$cont]['area_responsable'] = $row['area_responsable'];
                $array_items[$cont]['periodo'] = $row['periodo'] == '0' ? '' : $row['periodo'];
                $array_items[$cont]['fecha_actualizacion'] = $row['fecha_actualizacion'];
                $array_items[$cont]['nota'] = $row['nota'];
                $array_items[$cont]['denominacion'] = $row['denominacion'];
                $array_items[$cont]['fecha_publicacion'] = $row['fecha_publicacion'];
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function tiene_facturas_presupuesto_desglose($id_presupuesto_desglose){
        $query = "select a.numero_factura, d.id_presupuesto, c.id_presupuesto_desglose, c.id_presupuesto_concepto  FROM  vact_facturas a
                join vact_facturas_desglose_v2 b 
                join vact_presupuestos_desglose c 
                join vact_presupuestos d 
                where (a.id_factura = b.id_factura)
                    AND ((b.id_so_contratante = d.id_sujeto_obligado) 
                        OR (b.id_so_solicitante = d.id_sujeto_obligado))
                    AND ((b.id_presupuesto_concepto = c.id_presupuesto_concepto)
                        OR (b.id_presupuesto_concepto_solicitante = c.id_presupuesto_concepto))
                    AND (d.id_presupuesto = c.id_presupuesto)
                    AND (d.id_ejercicio = a.id_ejercicio)
                    AND (c.id_presupuesto_desglose = " . $id_presupuesto_desglose . ")";

        $this->db->query($query);

        if($this->db->affected_rows() > 0)
        {
            return true; // tiene facturas asosiadas
        }else
        {
            return false; //se puede eliminar
        }
    }

    function get_monto_ejercido($id_presupuesto){
        $this->load->model('tpoadminv1/Generales_model');

        $sqltext = "
            SELECT 
                IFNULL(SUM(`y`.`monto_desglose`), 0) as monto
            FROM
                ((`tab_facturas_desglose` `y`
                JOIN `tab_facturas` `x`)
                JOIN `tab_presupuestos_desglose` `b`)
                JOIN `tab_presupuestos` `a`
            WHERE
                ((`x`.`id_factura` = `y`.`id_factura`)
                    AND (`y`.`id_so_contratante` = `a`.`id_sujeto_obligado` OR `y`.`id_so_solicitante` = `a`.`id_sujeto_obligado`)
                    AND (`y`.`id_presupuesto_concepto` = `b`.`id_presupuesto_concepto` OR `y`.`id_presupuesto_concepto_solicitante` = `b`.`id_presupuesto_concepto`)
                    AND (`a`.`id_presupuesto` = `b`.`id_presupuesto`)
                    AND (`a`.`id_ejercicio` = `x`.`id_ejercicio`)
                    AND (`a`.`id_presupuesto` = " . $id_presupuesto . "))
        ";

        $query = $this->db->query( $sqltext );

        $row = $query->row();
        
        $total = 0;
        if(isset($row)){
            $total = $row->monto;
        }

        return $this->Generales_model->money_format("%.2n", $total);
    }

    function dependencia_presupuesto_id($id)
    {
        $this->db->where('id_presupuesto', $id);
        $this->db->get('tab_presupuestos_desglose');

        if($this->db->affected_rows() > 0)
        {
            return false; // tiene partidas presupuestarias asosiadas
        }else
        {
            return true; //se puede eliminar
        }
    }

    function eliminar_presupuesto($id)
    {
        $reg_eliminado = $this->dame_presupuesto_id($id);

        $this->db->where('id_presupuesto', $id);
        $this->db->delete('tab_presupuestos');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Planeación y presupuestos', 'Eliminación presupuesto : ' . $reg_eliminado['presupuesto_modificado']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }


    function dame_todos_sujetos($activos)
    {
        if($activos == true){
            $this->db->where('active', '1');
            $query = $this->db->order_by('nombre_sujeto_obligado', 'ASC');
        }
        //los presupuestos solo se listan losso contratantes
        $query = $this->db->get('tab_sujetos_obligados');
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $array_items[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_nombre_sujeto($id)
    {
        $this->db->select('nombre_sujeto_obligado');
        $this->db->where('id_sujeto_obligado', $id);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_sujeto_obligado'];
        }else
        {
            return '';
        }
    }

    function dame_todos_presupuestos_conceptos($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_presupuesto', $id);
        $query = $this->db->get('tab_presupuestos_desglose');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_presupuesto'] = $row['id_presupuesto'];
                $array_items[$cont]['id_presupuesto_desglose'] = $row['id_presupuesto_desglose'];
                $array_items[$cont]['id_presupuesto_concepto'] = $row['id_presupuesto_concepto'];
                $array_items[$cont]['nombre_presupuesto_concepto'] = $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto']);
                $array_items[$cont]['fuente_federal'] = $row['fuente_federal'];
                $array_items[$cont]['monto_fuente_federal'] = $row['monto_fuente_federal'];
                $array_items[$cont]['monto_fuente_federal_format'] = $this->Generales_model->money_format("%.2n", $row['monto_fuente_federal']);
                $array_items[$cont]['fuente_local'] = $row['fuente_local'];
                $array_items[$cont]['monto_fuente_local'] = $row['monto_fuente_local'];
                $array_items[$cont]['monto_fuente_local_format'] = $this->Generales_model->money_format("%.2n", $row['monto_fuente_local']);
                $array_items[$cont]['monto_presupuesto'] = $row['monto_presupuesto'];
                $array_items[$cont]['monto_presupuesto_format'] = $this->Generales_model->money_format("%.2n", $row['monto_presupuesto']);
                $array_items[$cont]['monto_modificacion'] = $row['monto_modificacion'];
                $array_items[$cont]['monto_modificacion_format'] = $this->Generales_model->money_format("%.2n", $row['monto_modificacion']);
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_todos_presupuestos_conceptos_option($id, $id_ejercicio, $id_so, $extra)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_presupuesto', $id);
        $query = $this->db->get('tab_presupuestos_desglose');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $monto_total = $row['monto_presupuesto'] + $row['monto_modificacion'];
                $array_items[$cont]['id_presupuesto_concepto'] = $row['id_presupuesto_concepto'];
                $array_items[$cont]['nombre_presupuesto_concepto'] = $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto']);
                $array_items[$cont]['presupuesto_disponible'] = $this->disponible_presupuesto_partida($id_ejercicio, $row['id_presupuesto_concepto'], $id_so, $monto_total);
                $cont++;
            };
            $array_items[$cont]['id_presupuesto_concepto'] = '-1';
            $array_items[$cont]['nombre_presupuesto_concepto'] = $extra;
            $array_items[$cont]['presupuesto_disponible'] = true;
            return $array_items;
        }else{
            $registro[0]['id_presupuesto_concepto'] = '-1';
            $registro[0]['nombre_presupuesto_concepto'] = $extra;
            $array_items[$cont]['presupuesto_disponible'] = true;

            return $registro;
        }
    }

    

    function descarga_presupuestos_conceptos($id){
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $filename = 'dist/csv/partidas_'.$id.'.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $this->db->where('id_presupuesto', $id);
        $query = $this->db->get('tab_presupuestos_desglose');

        $csv_header = array('#',
                    utf8_decode('Partida presupuestal'),
                    utf8_decode('Fuente presupuestaria federal'),
                    utf8_decode('monto asignado'),
                    utf8_decode('Fuente presupuestaria local'),
                    utf8_decode('monto asignado'),
                    utf8_decode('Monto asignado total'),
                    utf8_decode('Monto de modificación'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable de la información'),
                    utf8_decode('Año'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontosPartidas($row['id_presupuesto']);
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto'])),
                    utf8_decode($row['fuente_federal']),
                    utf8_decode($this->Generales_model->money_format("%.2n", $row['monto_fuente_federal'])),
                    utf8_decode($row['fuente_local']),
                    utf8_decode($this->Generales_model->money_format("%.2n", $row['monto_fuente_local'])),
                    utf8_decode($this->Generales_model->money_format("%.2n", $row['monto_presupuesto'])),
                    utf8_decode($this->Generales_model->money_format("%.2n", $row['monto_modificacion'])),
                    utf8_decode($this->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == 0 ? '' : $row['periodo']),
                    utf8_decode($this->dateToString($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota'])),
                    utf8_decode($this->get_estatus_name($row['active']))
                    
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_presupuestos_desglose_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_presupuesto_desglose', $id);
        $query = $this->db->get('tab_presupuestos_desglose');
        
        if ($query->num_rows() == 1)
        {
            $registro = [];
            foreach ($query->result_array() as $row){
                $registro  = array(
                    'id_presupuesto_desglose' => $row['id_presupuesto_desglose'],
                    'id_presupuesto' => $row['id_presupuesto'],
                    'id_presupuesto_concepto' => $row['id_presupuesto_concepto'],
                    'nombre_presupuesto_concepto' => $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto']),
                    'fuente_federal' => $row['fuente_federal'],
                    'monto_fuente_federal' => $row['monto_fuente_federal'],
                    'monto_fuente_federal_format' => $this->Generales_model->money_format("%.2n", $row['monto_fuente_federal']),
                    'fuente_local' => $row['fuente_local'],
                    'monto_fuente_local' => $row['monto_fuente_local'],
                    'monto_fuente_local_format' => $this->Generales_model->money_format("%.2n", $row['monto_fuente_local']),
                    'monto_presupuesto' => $row['monto_presupuesto'],
                    'monto_presupuesto_format' => $this->Generales_model->money_format("%.2n", $row['monto_presupuesto']),
                    'monto_modificacion' => $row['monto_modificacion'],
                    'monto_modificacion_format' => $this->Generales_model->money_format("%.2n", $row['monto_modificacion']),
                    'fecha_validacion' => $this->dateToString($row['fecha_validacion']),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == 0 ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'denominacion' => $row['denominacion'],
                    'fecha_publicacion' => $this->dateToString($row['fecha_publicacion']),
                    'active' => $row['active'],
                    'estatus' => $this->get_estatus_name($row['active'])
                );
            }
            return $registro;
        }else
        {
            return '';
        }
    }

    function agregar_presupuesto_partida()
    {
        $this->db->where('id_presupuesto_concepto', $this->input->post('id_presupuesto_concepto'));
        $this->db->where('id_presupuesto', $this->input->post('id_presupuesto'));
        
        $query = $this->db->get('tab_presupuestos_desglose');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_presupuesto' => $this->input->post('id_presupuesto'),
                'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
                'fuente_federal' => $this->input->post('fuente_federal'),
                'monto_fuente_federal' => $this->input->post('monto_fuente_federal'),
                'fuente_local' => $this->input->post('fuente_local'),
                'monto_fuente_local' => $this->input->post('monto_fuente_local'),
                'monto_presupuesto' => $this->input->post('monto_presupuesto'),
                'monto_modificacion' => $this->input->post('monto_modificacion'),
                'fecha_validacion' => $this->input->post('fecha_validacion'),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
                'nota' => $this->input->post('nota'),
                'denominacion' => $this->input->post('denominacion'),
                'fecha_publicacion' => $this->input->post('fecha_publicacion'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_presupuestos_desglose', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $pc = $this->Catalogos_model->dame_presupuestos_concepto_nombre($data_new['id_presupuesto_concepto']);
                $monto = $this->Generales_model->money_format("%.2n", $data_new['monto_presupuesto']);
                $this->registro_bitacora('Planeación y presupuestos', 'Alta presupuesto desglose ' . $monto . " " . $pc);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_presupuesto_partida()
    {
        $this->db->where('id_presupuesto_concepto', $this->input->post('id_presupuesto_concepto'));
        $this->db->where('id_presupuesto', $this->input->post('id_presupuesto'));
        $this->db->where_not_in('id_presupuesto_desglose', $this->input->post('id_presupuesto_desglose'));
        
        $query = $this->db->get('tab_presupuestos_desglose');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'id_presupuesto' => $this->input->post('id_presupuesto'),
                'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
                'fuente_federal' => $this->input->post('fuente_federal'),
                'monto_fuente_federal' => $this->input->post('monto_fuente_federal'),
                'fuente_local' => $this->input->post('fuente_local'),
                'monto_fuente_local' => $this->input->post('monto_fuente_local'),
                'monto_presupuesto' => $this->input->post('monto_presupuesto'),
                'monto_modificacion' => $this->input->post('monto_modificacion'),
                'fecha_validacion' => $this->input->post('fecha_validacion'),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
                'nota' => $this->input->post('nota'),
                'denominacion' => $this->input->post('denominacion'),
                'fecha_publicacion' => $this->input->post('fecha_publicacion'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_presupuesto_desglose', $this->input->post('id_presupuesto_desglose'));
            $this->db->update('tab_presupuestos_desglose', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                $pc = $this->Catalogos_model->dame_presupuestos_concepto_nombre($data_update['id_presupuesto_concepto']);
                $monto = $this->Generales_model->money_format("%.2n", $data_update['monto_presupuesto']);
                $this->registro_bitacora('Planeación y presupuestos', 'Edición presupuesto desglose ' . $monto . " " . $pc);
                return 1; // is correct
            }else
            {
                // any trans error?
                if ($this->db->trans_status() === FALSE) {
                    return 0; // sometime is wrong
                }else{
                    return 1;
                }
            }
        }
    }

    function eliminar_presupuesto_desglose($id)
    {
        $reg_eliminado = $this->dame_presupuestos_desglose_id($id);
        $this->db->where('id_presupuesto_desglose', $id);
        $this->db->delete('tab_presupuestos_desglose');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Planeación y presupuestos', 'Eliminación presupuesto desglose con presupuesto original ' . $reg_eliminado['monto_presupuesto_format'] .
                    ' de la partida ' .  $reg_eliminado['nombre_presupuesto_concepto']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function dame_presupuestos_by_ejercicio_so_contratante($id_ejercicio, $id_so_contratante)
    {
        $this->db->where('id_ejercicio', $id_ejercicio);
        $this->db->where('id_sujeto_obligado', $id_so_contratante);
        
        $query = $this->db->get('tab_presupuestos');
    
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {}
            return $this->dame_todos_presupuestos_conceptos($row['id_presupuesto']);
        }
    }

    function dame_nombres_partidas_presupuestos($id_ejercicio, $id_so_contratante, $tipo)
    {
        $this->db->where('id_ejercicio', $id_ejercicio);
        $this->db->where('id_sujeto_obligado', $id_so_contratante);
        
        $query = $this->db->get('tab_presupuestos');

        $tipo_contrario = 'El recurso se tomar&aacute; del sujeto obligado';
        if($tipo == 'contratante')
            $tipo_contrario .= ' solicitante';
        else if($tipo == 'solicitante')
            $tipo_contrario .= ' contratante';

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {}
            $registros = $this->dame_todos_presupuestos_conceptos_option($row['id_presupuesto'], $id_ejercicio, $id_so_contratante, $tipo_contrario);    
            return $registros; 
        }else{
            $registro[0]['id_presupuesto_concepto'] = '-1';
            $registro[0]['nombre_presupuesto_concepto'] = $tipo_contrario;
            $registro[0]['presupuesto_disponible'] = true;

            return $registro;
        }
    }

    function get_id_presupuesto_by_ejercicio_so_contratante($id_ejercicio, $id_so_contratante)
    {
        $this->db->where('id_ejercicio', $id_ejercicio);
        $this->db->where('id_sujeto_obligado', $id_so_contratante);  
        $query = $this->db->get('tab_presupuestos');

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
            }
            return $row['id_presupuesto'];
        }
    }

    function dame_presupuestos_desglose_by_id_presupuesto_concepto($id_presupuesto, $id_presupuesto_concepto)
    {
        $this->db->where('id_presupuesto', $id_presupuesto);
        $this->db->where('id_presupuesto_concepto', $id_presupuesto_concepto);
        
        $query = $this->db->get('tab_presupuestos_desglose');
    
        if ($query->num_rows() > 0)
        {
            $registro = [];
            foreach ($query->result_array() as $row)
            {
                $registro['id_presupuesto'] = $row['id_presupuesto'];
                $registro['id_presupuesto_desglose'] = $row['id_presupuesto_desglose'];
                $registro['id_presupuesto_concepto'] = $row['id_presupuesto_concepto'];
                $registro['monto_presupuesto'] = $row['monto_presupuesto'];
                $registro['monto_modificacion'] = $row['monto_modificacion'];
                break;
            }
            return $registro;
        }
    }

    function disponible_presupuesto_partida($id_ejercicio, $id_presupuesto_concepto, $id_so, $monto_total)
    {
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $disponible = false;

        $desgloses = $this->Facturas_model->dame_facturas_desglose($id_ejercicio, $id_so, $id_presupuesto_concepto);
        if(!empty($desgloses)){
            $monto_gastado = 0;
            for($z = 0; $z < sizeof($desgloses); $z++)
            {
                $monto_gastado += floatval($desgloses[$z]['monto_desglose']);
            }
            if($monto_gastado < $monto_total)
            {
                $disponible = true; 
            }
        }else{
            $disponible = true;
        }

        return $disponible;
    }

    //devuelve el monto gastado de una partida
    function partidad_presupuesto_gastado($id_ejercicio, $id_presupuesto_concepto, $id_so )
    {
        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $desgloses = $this->Facturas_model->dame_facturas_desglose($id_ejercicio, $id_so, $id_presupuesto_concepto);
        $monto_gastado = 0;
        if(!empty($desgloses)){
            for($z = 0; $z < sizeof($desgloses); $z++)
            {
                $monto_gastado += floatval($desgloses[$z]['monto_desglose']);
            }
        }

        return $monto_gastado;
    }

    function last_id_presupuesto()
    {
        $query_str = 'select * from tab_presupuestos order by id_presupuesto desc limit 1'; 
        
        $query = $this->db->query($query_str);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) { }
            return $row['id_presupuesto'];
        }else{
            return 0;
        }   
    }

    function crear_archivo_presupuesto($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_presupuestos');
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Sujeto obligado'),
                    utf8_decode('Presupuesto original'),
                    utf8_decode('Monto modificado'),
                    utf8_decode('Presupuesto modificado'),
                    utf8_decode('Presupuesto ejercido'),
                    utf8_decode('Programa anual '),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontosPartidas($row['id_presupuesto']);
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->dame_nombre_sujeto($row['id_sujeto_obligado'])),
                    utf8_decode($montos['monto_presupuesto']),
                    utf8_decode($montos['monto_modificacion']),
                    utf8_decode($montos['presupuesto_modificado']),
                    utf8_decode($this->get_monto_ejercido($row['id_presupuesto'])),
                    utf8_decode($row['file_programa_anual']),
                    utf8_decode($this->get_estatus_name($row['active']))
            
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }
}

?>