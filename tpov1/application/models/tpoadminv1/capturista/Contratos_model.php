<?php

/**
 * Description of Contratos_model
 *
 * INAI TPO
 * 
 * 
 */
class Contratos_Model extends CI_Model
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

    function getMontosContrato_id($id_contrato) //manda las cantidades sin formato
    {

        $this->load->model('tpoadminv1/Generales_model');
        $contrato = $this->dame_contrato_id($id_contrato);

        if(!empty($contrato)){
            $registros = $this->dame_contratos_convenios($id_contrato);
        
        
            $montos = array(
                'monto_modificado' => 0,
                'monto_contrato' =>  floatval($contrato['monto_contrato']),
                'monto_pagado' => $this->obtener_monto_pagado($id_contrato)
            );
    
            if(isset($registros))
            {
                $monto_convenio = 0;
				$mm = 0;
                $mt = 0;
                for($z = 0; $z < sizeof($registros); $z++)
                {
                    if($registros[$z]['active'] == '1'){
                        $mm += $registros[$z]['monto_convenio'];
                    }
                }
                $monto_total = $monto_convenio + $mm;
                $montos['monto_modificado'] = $mm;
                $montos['monto_total'] = $monto_total;
            }
            return $montos;
        }
        
        return null;
    }

    function getMontos($id, $monto_convenio)//manda las cantidades con formato
    {

        $this->load->model('tpoadminv1/Generales_model');
        $registros = $this->dame_contratos_convenios($id);

        
        $montos = array(
            'monto_modificado' => '$0.00',
            'monto_total' =>  $this->Generales_model->money_format("%.2n", $monto_convenio),
            'monto_pagado' => $this->Generales_model->money_format("%.2n", $this->obtener_monto_pagado($id))
        );

        if(isset($registros))
        {
            $mm = 0;
            $mt = 0;
            for($z = 0; $z < sizeof($registros); $z++)
            {
                if($registros[$z]['active'] == '1'){
                    $mm += $registros[$z]['monto_convenio'];
                }
            }
            $monto_total = $monto_convenio + $mm;
            $montos['monto_modificado'] = $this->Generales_model->money_format("%.2n", $mm);
            $montos['monto_total'] = $this->Generales_model->money_format("%.2n", $monto_total);
        }
        return $montos;
    }


    function dame_nombre_contratante($id){
        $this->db->select('nombre_sujeto_obligado');
        $this->db->where('id_sujeto_obligado', $id);
        
        $query = $this->db->get('vso_contratante');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['nombre_sujeto_obligado'];
        }else{
            return '';
        }
    }

    function dame_nombre_solicitante($id){
        $this->db->select('nombre_sujeto_obligado');
        $this->db->where('id_sujeto_obligado', $id);
        
        $query = $this->db->get('vso_solicitante');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['nombre_sujeto_obligado'];
        }else{
            return '';
        }
    }

    function dame_todos_so_contratantes($activos){
        
        if($activos == true){
            $this->db->order_by('nombre_sujeto_obligado', 'ASC');
            $this->db->where('active', '1');
        }
        $query = $this->db->get('vso_contratante');
        

        if ($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;

            foreach ($query->result_array() as $row) {
                $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $array_items[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                $cont++;
            }
            return $array_items;
        }else{
            return '';
        }
    }

    function dame_todos_so_solicitantes($activos){
        
        if($activos == true){
            $this->db->order_by('nombre_sujeto_obligado', 'ASC');
            $this->db->where('active', '1');
        }
        $query = $this->db->get('vso_solicitante');
        
        if ($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;

            foreach ($query->result_array() as $row) {
                $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $array_items[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                $cont++;
            }
            return $array_items;
        }else{
            return '';
        }
    }



    function dame_nombre_contrato($id){
        $this->db->select('numero_contrato');
        $this->db->where('id_contrato', $id);
        
        $query = $this->db->get('tab_contratos');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['numero_contrato'];
        }else{
            return '';
        }
    }

    function dame_todos_contratos($activos)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/Generales_model');

        if($activos){
            $this->db->where('active', '1');
        }
        $this->db->where('id_contrato > ', '1');

        $query = $this->db->get('tab_contratos');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontos($row['id_contrato'], $row['monto_contrato']);
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_contrato'] = $row['id_contrato'];
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['nombre_so_contratante'] = $this->dame_nombre_contratante($row['id_so_contratante']);
                $array_items[$cont]['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                $array_items[$cont]['numero_contrato'] = $row['numero_contrato'];
                $array_items[$cont]['nombre_proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']);
                $array_items[$cont]['monto_contrato'] = $this->Generales_model->money_format("%.2n",$row['monto_contrato']);
                $array_items[$cont]['monto_modificado'] = $montos['monto_modificado'];
                $array_items[$cont]['monto_total'] = $montos['monto_total'];
                $array_items[$cont]['monto_pagado'] = $montos['monto_pagado'];
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function descarga_contratos()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $filename = 'dist/csv/contratos.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $this->db->where('id_contrato > ', '1');
        $query = $this->db->get('tab_contratos');
        
        $csv_header = array('#',
                    utf8_decode('Procedimiento'),
                    utf8_decode('Nombre o razón social del proveedor'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Sujeto obligado contratante'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Número de contrato'),
                    utf8_decode('Objeto del contrato'),
                    utf8_decode('Descripción'),
                    utf8_decode('Fundamento jurídico'),
                    utf8_decode('Fecha de celebración'),
                    utf8_decode('Fecha de inicio'),
                    utf8_decode('Fecha de término'),
                    utf8_decode('Monto original de contrato'),
                    utf8_decode('Monto modificado'),
                    utf8_decode('Monto total'),
                    utf8_decode('Monto pagado a la fecha'),
                    utf8_decode('Hipervínculo al contrato firmado'),
                    utf8_decode('Archivo del contrato en PDF'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable de la información'),
                    utf8_decode('Año'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'),
                    utf8_decode('Estatus'));
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontos($row['id_contrato'], $row['monto_contrato']);
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_procedimiento($row['id_procedimiento'])),
                    utf8_decode($this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre'])),
                    utf8_decode($this->dame_nombre_contratante($row['id_so_contratante'])),
                    utf8_decode($this->dame_nombre_solicitante($row['id_so_solicitante'])),
                    utf8_decode($row['numero_contrato']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['objeto_contrato'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_justificacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['fundamento_juridico'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_celebracion'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_inicio'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_fin'])),
                    utf8_decode($this->Generales_model->money_format("%.2n",$row['monto_contrato'])),
                    $montos['monto_modificado'],
                    $montos['monto_total'],
                    $montos['monto_pagado'],
                    utf8_decode($row['url_contrato']),
                    utf8_decode( empty($row['file_contrato']) ? 'No hay archivo' :  $row['file_contrato']),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == 0 ? '' : $row['periodo']),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_actualizacion'])),
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

    function dame_numero_contrato($id){
        $this->db->select('numero_contrato');
        $this->db->where('id_contrato', $id);
        
        $query = $this->db->get('tab_contratos');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['numero_contrato'];
        }else{
            return '';
        }
    }

    function get_default_contrato()
    {
        $this->db->like('numero_contrato', 'sin contrato');
        $query = $this->db->get('tab_contratos');

        if($query->num_rows() == 1)
        {
            $array_items = [];
            foreach ($query->result_array() as $row) { }
            $array_items[0]['id_contrato'] = $row['id_contrato'];
            $array_items[0]['numero_contrato'] = $row['numero_contrato'];
            return $array_items;
        }
    }

    function dame_contrato_by_ejercicio_proveedor($id_ejercicio, $id_proveedor)
    {
        if(isset($id_ejercicio)){
            $this->db->where('id_ejercicio', $id_ejercicio);
        }

        if(isset($id_proveedor) && !empty($id_proveedor)){
            $this->db->where('id_proveedor', $id_proveedor);
        }

        // $this->db->where('active', '1'); //Muestra solo los registros con estatus activos
        $this->db->order_by('numero_contrato', 'ASC');
        $query = $this->db->get('tab_contratos');

        $array_items = $this->get_default_contrato();

        $id_contrato = 0;
        if(!empty($array_items) && count($array_items) > 0){
            $id_contrato = $array_items[0]['id_contrato'];  
        }else{
            $array_items[0]['id_contrato'] = 0; 
            $array_items[0]['numero_contrato'] = 'No existe un registro Sin Contrato';
        }
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                if($id_contrato != $row['id_contrato']){
                    $array_items[$count]['id_contrato'] = $row['id_contrato'];
                    $array_items[$count]['numero_contrato'] = $row['numero_contrato'];
                    $array_items[$count]['id_proveedor'] = $row['id_proveedor'];
                    $count++;
                }
            }
        }
        return $array_items;
    }

    function dame_contrato_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_contrato', $id);   
        $query = $this->db->get('tab_contratos');
        
        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                $montos = $this->getMontos($row['id_contrato'], $row['monto_contrato']);
                $register = array(
                    'id_contrato' => $row['id_contrato'],
                    'id_procedimiento' => $row['id_procedimiento'],
                    'nombre_procedimiento' => $this->Catalogos_model->dame_nombre_procedimiento($row['id_procedimiento']),
                    'id_proveedor' => $row['id_proveedor'],
                    'nombre_proveedor' => $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']),
                    'nombre_comercial_proveedor' => $this->Proveedores_model->dame_nombre_comercial_proveedor($row['id_proveedor']),
                    'id_ejercicio' => $row['id_ejercicio'],
                    'ejercicio' => $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'trimestre' => $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'nombre_so_contratante' => $this->dame_nombre_contratante($row['id_so_contratante']),
                    'id_so_solicitante' => $row['id_so_solicitante'],
                    'nombre_so_solicitante' => $this->dame_nombre_solicitante($row['id_so_solicitante']),
                    'numero_contrato' => $row['numero_contrato'],
                    'objeto_contrato' => $row['objeto_contrato'],
                    'descripcion_justificacion' => $row['descripcion_justificacion'],
                    'fundamento_juridico' => $row['fundamento_juridico'],
                    'fecha_celebracion' => $this->dateToString($row['fecha_celebracion']),
                    'fecha_inicio' => $this->dateToString($row['fecha_inicio']),
                    'fecha_fin' => $this->dateToString($row['fecha_fin']),
                    'monto_contrato' => $row['monto_contrato'],
                    'monto_contrato_formato' => $this->Generales_model->money_format("%.2n",$row['monto_contrato']),
                    'url_contrato' => $row['url_contrato'],
                    'file_contrato' => $row['file_contrato'],
                    'name_file_contrato' => $row['file_contrato'],
                    'name_file_contrato_vista' => empty($row['file_contrato']) ? 'No hay archivo' : $row['file_contrato'] ,
                    'path_file_contrato' => $this->ruta_descarga_archivos($row['file_contrato'],  'data/contratos/'),
                    'fecha_validacion' => $this->dateToString($row['fecha_validacion']),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == '0' ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'active' => $row['active'],
                    'estatus' => $this->get_estatus_name($row['active']),
                    'monto_modificado' => $montos['monto_modificado'],
                    'monto_total' => $montos['monto_total'],
                    'monto_pagado' => $montos['monto_pagado']
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function eliminar_contrato($id)
    {
        $reg_eliminado = $this->dame_contrato_id($id);

        $this->db->where('id_contrato', $id);
        $this->db->delete('tab_contratos');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Contratos', 'Eliminación contrato : ' . $reg_eliminado['numero_contrato']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_contrato()
    {
        $this->db->where('numero_contrato', $this->input->post('numero_contrato'));
        $query = $this->db->get('tab_contratos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_new = array(
                'id_contrato' => '',
                'id_procedimiento' => $this->input->post('id_procedimiento'),
                'id_proveedor' => $this->input->post('id_proveedor'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'numero_contrato' => $this->input->post('numero_contrato'),
                'objeto_contrato' => $this->input->post('objeto_contrato'),
                'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
                'fundamento_juridico' => $this->input->post('fundamento_juridico'),
                'fecha_celebracion' => $this->stringToDate($this->input->post('fecha_celebracion')),
                'fecha_inicio' => $this->stringToDate($this->input->post('fecha_inicio')),
                'fecha_fin' => $this->stringToDate($this->input->post('fecha_fin')),
                'monto_contrato' => $this->input->post('monto_contrato'),
                'url_contrato' => $this->input->post('url_contrato'),
                'file_contrato' => $this->input->post('name_file_contrato'),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_contratos', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Contratos', 'Alta del contrato con número: ' . $data_new['numero_contrato']);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_contrato()
    {
        $this->db->where('numero_contrato', $this->input->post('numero_contrato'));
        $this->db->where_not_in('id_contrato', $this->input->post('id_contrato'));
        $query = $this->db->get('tab_contratos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_update = array(
                'id_procedimiento' => $this->input->post('id_procedimiento'),
                'id_proveedor' => $this->input->post('id_proveedor'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'numero_contrato' => $this->input->post('numero_contrato'),
                'objeto_contrato' => $this->input->post('objeto_contrato'),
                'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
                'fundamento_juridico' => $this->input->post('fundamento_juridico'),
                'fecha_celebracion' => $this->stringToDate($this->input->post('fecha_celebracion')),
                'fecha_inicio' => $this->stringToDate($this->input->post('fecha_inicio')),
                'fecha_fin' => $this->stringToDate($this->input->post('fecha_fin')),
                'monto_contrato' => $this->input->post('monto_contrato'),
                'url_contrato' => $this->input->post('url_contrato'),
                'file_contrato' => $this->input->post('name_file_contrato'),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_contrato', $this->input->post('id_contrato'));
            $this->db->update('tab_contratos', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Contratos', 'Edición del contrato con número: ' . $data_update['numero_contrato']);
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

    function tiene_contratos_dependencia($id_contrato)
    {

        $this->db->where('id_contrato', $id_contrato);
        $query_convenios = $this->db->get('tab_convenios_modificatorios');
        
        $this->db->where('id_contrato', $id_contrato);
        $query_facturas = $this->db->get('tab_facturas');

        // posicion 1: para mensaje de convenios, position 2 de facturas
        $response = array(false, '', '');
        if($query_convenios->num_rows() > 0 )
        {
            $response[0] = true;
            $response[1] = 'El contrato tiene convenios relacionados, primero debe eliminar &eacute;stos. <br />';
        }
        if($query_facturas->num_rows() > 0 ){
            $response[0] = true;
            $response[2] = 'El contrato tiene facturas relacionadas, primero debe eliminar &eacute;stas.';
        }

        return $response;
    }

    /** Convenios modificatorios  **/
    function dame_todos_convenios_modificatorios($id_contrato)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_contrato', $id_contrato);
        $query = $this->db->get('tab_convenios_modificatorios');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_convenio_modificatorio'] = $row['id_convenio_modificatorio'];
                $array_items[$cont]['id_contrato'] = $row['id_contrato'];
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['numero_convenio'] = $row['numero_convenio'];
                $array_items[$cont]['monto_convenio'] = $row['monto_convenio'];
                $array_items[$cont]['monto_convenio_format'] = $this->Generales_model->money_format("%.2n",$row['monto_convenio']);
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }

    }

    function descarga_convenios_modificatorios($id_contrato)
    {
    
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $filename = 'dist/csv/convenios_modificatorios_'. $id_contrato .'.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $this->db->where('id_contrato', $id_contrato);
        $query = $this->db->get('tab_convenios_modificatorios');

        $csv_header = array('#',
                        utf8_decode('Ejercicio'),
                        utf8_decode('Trimestre'),
                        utf8_decode('Convenio modificatorio'),
                        utf8_decode('Objeto'),
                        utf8_decode('Fundamento jurídico'),
                        utf8_decode('Fecha de celebración'),
                        utf8_decode('Monto'),
                        utf8_decode('Hipervínculo al convenio modificatorio, en su caso'),
                        utf8_decode('Archivo del convenio en PDF'),
                        utf8_decode('Fecha de validación'),
                        utf8_decode('Área responsable de la información'),
                        utf8_decode('Año'),
                        utf8_decode('Fecha de actualización'),
                        utf8_decode('Nota'),
                        utf8_decode('Estatus')
                    );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $montos = $this->getMontos($row['id_contrato'], $row['monto_contrato']);
                $csv = array(
                        utf8_decode($count),
                        utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                        utf8_decode($this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre'])),
                        utf8_decode($row['numero_convenio']),
                        utf8_decode($this->Generales_model->clear_html_tags($row['objeto_convenio'])),
                        utf8_decode($this->Generales_model->clear_html_tags($row['fundamento_juridico'])),
                        utf8_decode($this->dateToString($row['fecha_celebracion'])),
                        utf8_decode($this->Generales_model->money_format("%.2n", $row['monto_convenio'])),
                        utf8_decode($row['url_convenio']),
                        utf8_decode($row['file_convenio']),
                        utf8_decode($this->dateToString($row['fecha_validacion'])),
                        utf8_decode($row['area_responsable']),
                        utf8_decode($row['periodo']),
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


    function dame_contratos_convenios($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        $this->db->where('id_contrato', $id);
        $query = $this->db->get('tab_convenios_modificatorios');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id_convenio_modificatorio'] = $row['id_convenio_modificatorio'];
                $array_items[$cont]['id_contrato'] = $row['id_contrato'];
                $array_items[$cont]['numero_convenio'] = $row['numero_convenio'];
                $array_items[$cont]['monto_convenio'] = $row['monto_convenio'];
                $array_items[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_items;
        }

    }

    function agregar_convenio_modificatorio()
    {
        $this->db->where('numero_convenio', $this->input->post('numero_convenio'));
        $query = $this->db->get('tab_convenios_modificatorios');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_new = array(
                'id_convenio_modificatorio' => '',
                'id_contrato' => $this->input->post('id_contrato'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'numero_convenio' => $this->input->post('numero_convenio'),
                'objeto_convenio' => $this->input->post('objeto_convenio'),
                'fundamento_juridico' => $this->input->post('fundamento_juridico'),
                'fecha_celebracion' =>  $this->stringToDate($this->input->post('fecha_celebracion')),
                'monto_convenio' => $this->input->post('monto_convenio'),
                'url_convenio' => $this->input->post('url_convenio'),
                'file_convenio' => $this->input->post('name_file_convenio'),
                'fecha_validacion' =>  $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' =>  $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_convenios_modificatorios', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Contratos', 'Alta del convenio modificatorio con número: ' . $data_new['numero_convenio']);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_convenio_modificatorio()
    {
        $this->db->where('numero_convenio', $this->input->post('numero_convenio'));
        $this->db->where_not_in('id_convenio_modificatorio', $this->input->post('id_convenio_modificatorio'));
        $query = $this->db->get('tab_convenios_modificatorios');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_update = array(
                'id_contrato' => $this->input->post('id_contrato'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'numero_convenio' => $this->input->post('numero_convenio'),
                'objeto_convenio' => $this->input->post('objeto_convenio'),
                'fundamento_juridico' => $this->input->post('fundamento_juridico'),
                'fecha_celebracion' =>  $this->stringToDate($this->input->post('fecha_celebracion')),
                'monto_convenio' => $this->input->post('monto_convenio'),
                'url_convenio' => $this->input->post('url_convenio'),
                'file_convenio' => $this->input->post('name_file_convenio'),
                'fecha_validacion' =>  $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' =>  $this->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );

            $this->db->where('id_convenio_modificatorio', $this->input->post('id_convenio_modificatorio'));
            $this->db->update('tab_convenios_modificatorios', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Contratos', 'Edición del convenio modificatorio con número: ' . $data_update['numero_convenio']);
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

    function dame_convenio_modificatorio_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_convenio_modificatorio', $id);   
        $query = $this->db->get('tab_convenios_modificatorios');
        
        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                $register = array(
                    'id_convenio_modificatorio' => $row['id_convenio_modificatorio'],
                    'id_contrato' => $row['id_contrato'],
                    'id_ejercicio' => $row['id_ejercicio'],
                    'ejercicio' =>  $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'trimestre' => $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']),
                    'numero_convenio' => $row['numero_convenio'],
                    'objeto_convenio' => $row['objeto_convenio'],
                    'fundamento_juridico' => $row['fundamento_juridico'],
                    'fecha_celebracion' =>   $this->dateToString($row['fecha_celebracion']),
                    'monto_convenio' => $row['monto_convenio'],
                    'monto_convenio_format' => $this->Generales_model->money_format("%.2n", $row['monto_convenio']),
                    'url_convenio' => $row['url_convenio'],
                    'file_convenio' => $row['file_convenio'],
                    'fecha_validacion' =>  $this->dateToString($row['fecha_validacion']),
                    'area_responsable' =>$row['area_responsable'],
                    'periodo' => $row['periodo'] == '0' ? '' : $row['periodo'],
                    'fecha_actualizacion' =>  $this->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'name_file_convenio' => $row['file_convenio'],
                    'ruta_file_convenio' =>  $this->ruta_descarga_archivos($row['file_convenio'],  'data/convenios/'),
                    'active' => $row['active'],
                    'estatus' => $this->get_estatus_name($row['active'])
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function eliminar_convenio_modificatorio($id)
    {
        $reg_eliminado = $this->dame_convenio_modificatorio_id($id);

        $this->db->where('id_convenio_modificatorio', $id);
        $this->db->delete('tab_convenios_modificatorios');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Contratos', 'Eliminación convenio modificatorio : ' . $reg_eliminado['numero_convenio']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function ruta_descarga_archivos($name_file, $path_file)
    {
        if(isset($name_file)){
            return base_url() . $path_file . $name_file;
        }else{
            return '';
        }
    }

    /** get facturas **/

    function obtener_monto_pagado($id_contrato){

        $query_string = "
            select 
                ifnull(sum(b.monto_desglose), 0) as monto_pagado
            from vact_facturas as a
            join vact_facturas_desglose as b
            on a.id_factura = b.id_factura
            where a.id_contrato = " . $id_contrato . "
        ";

        $query = $this->db->query($query_string);

        $row = $query->row();

        if(isset($row)){
            return $row->monto_pagado;
        }else{
            return 0.00;
        }
    }
}
?>