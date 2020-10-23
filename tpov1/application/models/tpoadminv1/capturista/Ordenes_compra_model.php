<?php

/**
 * Description of Contratos_model
 *
 * INAI TPO 
 * 
 */
class Ordenes_compra_Model extends CI_Model
{

    function registro_bitacora($seccion,$accion){
        $this->load->model('tpoadminv1/bitacora/Bitacora_model');

        $reg_bitacora = array(
            'seccion' => $seccion, 
            'accion' => $accion 
        );

        $this->Bitacora_model->guardar_bitacora_general($reg_bitacora);

    }

    function dame_campanas_by_ejercicio($id_ejercicio)
    {
        $this->db->where('id_ejercicio', $id_ejercicio);
        $this->db->order_by('nombre_campana_aviso', 'ASC');
        $query = $this->db->get('tab_campana_aviso');
        
        $array_items = [];
        if ($query->num_rows() > 0)
        {
            $count = 0;
            foreach ($query->result_array() as $row) {
                $array_items[$count]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_items[$count]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $count++;
            }
        }

        return $array_items;
    }

    function get_default_orden_compra()
    {
        $this->db->like('numero_orden_compra', 'Sin orden de compra');
        $query = $this->db->get('tab_ordenes_compra');

        if($query->num_rows() == 1)
        {
            $array_items = [];
            foreach ($query->result_array() as $row) { }
            $array_items[0]['id_orden_compra'] = $row['id_orden_compra'];
            $array_items[0]['numero_orden_compra'] = $row['numero_orden_compra'];
            return $array_items;
        }
    }

    function dame_ordenes_by_ejercicio_proveedor_contrato($id_ejercicio, $id_proveedor, $id_contrato)
    {
        if(!empty($id_ejercicio))
        {
            $this->db->where('id_ejercicio', $id_ejercicio);
        }

        if(!empty($id_proveedor))
        {
            $this->db->where('id_proveedor', $id_proveedor);
        }

        if($id_contrato == 1)
        {
            $this->db->where('id_contrato', $id_contrato);
        }

        $this->db->where('active', '1');
        $this->db->order_by('numero_orden_compra', 'ASC');
        $query = $this->db->get('tab_ordenes_compra');

        $array_items = $this->get_default_orden_compra();

        $id_orden_compra = 0;  
        if(!empty($array_items) && count($array_items) > 0){
            $id_orden_compra = $array_items[0]['id_orden_compra'];  
        }else{
            $array_items[0]['id_orden_compra'] = 0; 
            $array_items[0]['numero_orden_compra'] = 'No existe un registro Sin orden de compra';
        }
        
        if ($query->num_rows() >= 1)
        {
            $cont = 1;

            foreach ($query->result_array() as $row) {
                if($id_orden_compra != $row['id_orden_compra']){
                    $array_items[$cont]['id_orden_compra'] = $row['id_orden_compra'];
                    $array_items[$cont]['numero_orden_compra'] = $row['numero_orden_compra'];
                    $cont++;
                }
            }
            
        }
        return $array_items;
    }

    function dame_nombre_campana_aviso($id)
    {
        $this->db->select('nombre_campana_aviso');
        $this->db->where('id_campana_aviso', $id);
        
        $query = $this->db->get('tab_campana_aviso');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['nombre_campana_aviso'];
        }else{
            return '';
        }
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

    function dame_nombre_orden_compra($id)
    {
        $this->db->select('numero_orden_compra');
        $this->db->where('id_orden_compra', $id);
        
        $query = $this->db->get('tab_ordenes_compra');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['numero_orden_compra'];
        }else{
            return '';
        }
    }

    function dame_todos_ordenes_compra($activos)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/Generales_model');

        if($activos)
        {
            $this->db->where('active', '1');
        }

        $this->db->where('id_orden_compra > ', '1');

        $query = $this->db->get('tab_ordenes_compra');

        if ($query->num_rows() >= 1)
        {
            $array_items = [];
            $cont = 0;

            foreach ($query->result_array() as $row) {
                $array_items[$cont]['id'] = $cont +1;
                $array_items[$cont]['id_orden_compra'] = $row['id_orden_compra'];
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']);
                $array_items[$cont]['campana'] = $this->dame_nombre_campana_aviso($row['id_campana_aviso']);
                $array_items[$cont]['numero_orden_compra'] = $row['numero_orden_compra'];
                $array_items[$cont]['active'] = $this->Generales_model->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_orden_compra_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_orden_compra', $id);
        $query = $this->db->get('tab_ordenes_compra');

        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
    
                $register = array(
                    'id_contrato' => $row['id_contrato'],
                    'nombre_contrato' => $this->Contratos_model->dame_nombre_contrato($row['id_contrato']),
                    'id_orden_compra' => $row['id_orden_compra'],
                    'id_proveedor' => $row['id_proveedor'],
                    'nombre_proveedor' => $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']),
                    'nombre_comercial_proveedor' => $this->Proveedores_model->dame_nombre_comercial_proveedor($row['id_proveedor']),
                    'id_procedimiento' => $row['id_procedimiento'],
                    'nombre_procedimiento' => $this->Catalogos_model->dame_nombre_procedimiento($row['id_procedimiento']),
                    'id_ejercicio' => $row['id_ejercicio'],
                    'ejercicio' => $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'trimestre' => $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'nombre_so_contratante' => $this->dame_nombre_contratante($row['id_so_contratante']),
                    'id_so_solicitante' => $row['id_so_solicitante'],
                    'nombre_so_solicitante' => $this->dame_nombre_solicitante($row['id_so_solicitante']),
                    'numero_orden_compra' => $row['numero_orden_compra'],
                    'id_campana_aviso' => $row['id_campana_aviso'],
                    'nombre_campana_aviso' => $this->dame_nombre_campana_aviso($row['id_campana_aviso']),
                    'descripcion_justificacion' => $row['descripcion_justificacion'],
                    'motivo_adjudicacion' => $row['motivo_adjudicacion'],
                    'fecha_orden' => $this->Generales_model->dateToString($row['fecha_orden']),
                    'fecha_validacion' => $this->Generales_model->dateToString($row['fecha_validacion']),
                    'url_orden' => $row['url_orden'],
                    'file_orden' => $row['file_orden'],
                    'name_file_orden' => $row['file_orden'],
                    'path_file_orden' => $this->Generales_model->ruta_descarga_archivos($row['file_orden'],  'data/ordenes/'),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == '0' ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->Generales_model->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'monto' => $this->dame_monto_oc($row['id_orden_compra']),
                    'active' => $row['active'],
                    'estatus' => $this->Generales_model->get_estatus_name($row['active']),
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function descarga_ordenes_compra()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $filename = 'dist/csv/ordenes_compra.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $this->db->where('id_orden_compra > ', '1');
        $query = $this->db->get('tab_ordenes_compra');
        
        $csv_header = array('#',
                    utf8_decode('Nombre o razón social del proveedor'),
                    utf8_decode('Procedimiento'),
                    utf8_decode('Contrato'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Sujeto obligado ordenante'),
                    utf8_decode('Campaña o aviso institucional'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Orden de compra'),
                    utf8_decode('Justificación'),
                    utf8_decode('Motivo de adjudicación'),
                    utf8_decode('Fecha de orden'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Hipervínculo a la orden de compra'),
                    utf8_decode('Archivo de la orden de compra en PDF'),
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
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_procedimiento($row['id_procedimiento'])),
                    utf8_decode($this->Contratos_model->dame_nombre_contrato($row['id_contrato'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre'])),
                    utf8_decode($this->dame_nombre_contratante($row['id_so_contratante'])),
                    utf8_decode($this->dame_nombre_campana_aviso($row['id_campana_aviso'])),
                    utf8_decode($this->dame_nombre_solicitante($row['id_so_solicitante'])),
                    utf8_decode($row['numero_orden_compra']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_justificacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['motivo_adjudicacion'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_orden'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['url_orden']),
                    utf8_decode($row['file_orden']),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == '0' ? '' : $row['periodo']),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['nota'])),
                    utf8_decode($this->Generales_model->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
                $count += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function agregar_orden_compra()
    {
        $this->db->where('numero_orden_compra', $this->input->post('numero_orden_compra'));
        $query = $this->db->get('tab_ordenes_compra');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_new = array(
                'id_orden_compra' => '',
                'id_contrato' => $this->input->post('id_contrato'),
                'id_proveedor' => $this->input->post('id_proveedor'),
                'id_procedimiento' => $this->input->post('id_procedimiento'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'numero_orden_compra' => $this->input->post('numero_orden_compra'),
                'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
                'motivo_adjudicacion' => $this->input->post('motivo_adjudicacion'),
                'fecha_orden' => $this->Generales_model->stringToDate($this->input->post('fecha_orden')),
                'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                'url_orden' => $this->input->post('url_orden'),
                'file_orden' => $this->input->post('name_file_orden'),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_ordenes_compra', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Ordenes de compra', 'Alta de la orden de compra: ' . $data_new['numero_orden_compra']);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_orden_compra()
    {
        $this->db->where('numero_orden_compra', $this->input->post('numero_orden_compra'));
        $this->db->where_not_in('id_orden_compra', $this->input->post('id_orden_compra'));
        $query = $this->db->get('tab_ordenes_compra');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_update = array(
                'id_contrato' => $this->input->post('id_contrato'),
                'id_proveedor' => $this->input->post('id_proveedor'),
                'id_procedimiento' => $this->input->post('id_procedimiento'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'numero_orden_compra' => $this->input->post('numero_orden_compra'),
                'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
                'motivo_adjudicacion' => $this->input->post('motivo_adjudicacion'),
                'fecha_orden' => $this->Generales_model->stringToDate($this->input->post('fecha_orden')),
                'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                'url_orden' => $this->input->post('url_orden'),
                'file_orden' => $this->input->post('name_file_orden'),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_orden_compra', $this->input->post('id_orden_compra'));
            $this->db->update('tab_ordenes_compra', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Ordenes de compra', 'Edición de la orden de compra: ' . $data_update['numero_orden_compra']);
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

    function eliminar_orden_compra($id)
    {
        $reg_eliminado = $this->dame_orden_compra_id($id);

        $this->db->where('id_orden_compra', $id);
        $this->db->delete('tab_ordenes_compra');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Ordenes de compra', 'Eliminación orden de compra : ' . $reg_eliminado['numero_orden_compra']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function dame_todos_ordenes_compra_by_contrato($id_contrato)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/Generales_model');

        if($id_contrato)
        {
            $this->db->where('id_contrato', $id_contrato);
        }

        $this->db->where('active', '1');
        $query = $this->db->get('tab_ordenes_compra');

        $array_items = [];
        if ($query->num_rows() >= 1)
        {
            $cont = 0;

            foreach ($query->result_array() as $row) {
                $array_items[$cont]['id'] = $cont +1;
                $array_items[$cont]['id_orden_compra'] = $row['id_orden_compra'];
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['fecha_orden'] = $this->Generales_model->dateToString($row['fecha_orden']);
                $array_items[$cont]['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                $array_items[$cont]['campana_aviso'] = $this->dame_nombre_campana_aviso($row['id_campana_aviso']);
                $array_items[$cont]['numero_orden_compra'] = $row['numero_orden_compra'];
                $array_items[$cont]['monto'] = $this->dame_monto_oc($row['id_orden_compra']);
                $array_items[$cont]['link_detalle'] = base_url() . "index.php/tpov1/contratos_ordenes/orden_detalle/" . $row['id_orden_compra'];
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_monto_oc($id_orden_compra)
    {
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_orden_compra', $id_orden_compra);
        $query = $this->db->get('vmonto_oc');   
        $monto = 0;
        if ($query->num_rows() >= 1)
        {
            foreach ($query->result_array() as $row) {}
            $monto = floatval($row['monto']);    
        }

        return  $this->Generales_model->money_format("%.2n", $monto);
    }

}

?>