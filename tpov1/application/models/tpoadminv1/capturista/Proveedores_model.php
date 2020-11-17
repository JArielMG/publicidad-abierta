<?php

/**
 * Description of Proveedores_model
 * INAI TPO
 * DIC 2018
 */
class Proveedores_Model extends CI_Model
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

    function dame_todos_proveedores($activos)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        if($activos == true){
            $this->db->order_by('nombre_razon_social', 'ASC');
            $this->db->where('active', '1');
        }
        $query = $this->db->get('tab_proveedores');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_proveedor'] = $row['id_proveedor'];
                $array_items[$cont]['id_personalidad_juridica'] = $row['id_personalidad_juridica'];
                $array_items[$cont]['nombre_personalidad_juridica'] = $this->Catalogos_model->dame_nombre_personalidad_juridica($row['id_personalidad_juridica']);
                $array_items[$cont]['nombre_razon_social'] = $row['nombre_razon_social'];
                $array_items[$cont]['nombre_comercial'] = $row['nombre_comercial'];
                $array_items[$cont]['rfc'] = $row['rfc'];
                $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function dame_proveedor_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->db->where('id_proveedor', $id);
        
        $query = $this->db->get('tab_proveedores');
        
        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                $register = array(
                    'id_proveedor' => $row['id_proveedor'],
                    'id_personalidad_juridica' => $row['id_personalidad_juridica'],
                    'nombre_personalidad_juridica' => $this->Catalogos_model->dame_nombre_personalidad_juridica($row['id_personalidad_juridica']),
                    'nombre_razon_social' => $row['nombre_razon_social'],
                    'nombre_comercial' => $row['nombre_comercial'],
                    'rfc' => $row['rfc'],
                    'primer_apellido' => $row['primer_apellido'],
                    'segundo_apellido' => $row['segundo_apellido'],
                    'nombres' => $row['nombres'],
                    'fecha_validacion' => $this->dateToString($row['fecha_validacion']),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == '0' ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->dateToString($row['fecha_actualizacion']),
                    'descripcion_servicios' => $row['descripcion_servicios'],
                    'nota' => $row['nota'],
                    'estatus' => $this->get_estatus_name($row['active']),
                    'active' => $row['active']
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function dame_nombre_proveedor($id)
    {
        $query = $this->db->select('nombre_razon_social');
        $query = $this->db->where('id_proveedor', $id);
        $query = $this->db->get('tab_proveedores');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['nombre_razon_social'];
        }else{
            return '';
        }
    }

    function dame_nombre_comercial_proveedor($id)
    {
        $query = $this->db->select('nombre_comercial');
        $query = $this->db->where('id_proveedor', $id);
        $query = $this->db->get('tab_proveedores');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row['nombre_comercial'];
        }else{
            return '';
        }
    }

    function eliminar_proveedor($id)
    {
        $reg_eliminado = $this->dame_proveedor_id($id);

        $this->db->where('id_proveedor', $id);
        $this->db->delete('tab_proveedores');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->registro_bitacora('Proveedores', 'Eliminación proveedor : ' . $reg_eliminado['nombre_razon_social']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function existe_proveedor_razon_social($nombre_razon_social, $id_proveedor)
    {
        $this->db->where('nombre_razon_social', $nombre_razon_social);

        if(!empty($id_proveedor))
        {
            $this->db->where_not_in('id_proveedor', $id_proveedor);
        }

        $query = $this->db->get('tab_proveedores');

        if($query->num_rows() > 0){
            return true; // field is duplicated
        }else{
            return false; 
        }
    }

    function existe_proveedor_rfc($rfc, $id_proveedor)
    {
        $this->db->where('rfc', $rfc);

        if(!empty($id_proveedor))
        {
            $this->db->where_not_in('id_proveedor', $id_proveedor);
        }

        $query = $this->db->get('tab_proveedores');

        if($query->num_rows() > 0){
            return true; // field is duplicated
        }else{
            return false; 
        }
    }

    function descarga_proveedores()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = 'dist/csv/proveedores.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_proveedores');
        $csv_header = array('#',
                    utf8_decode('Personalidad jurídica'),
                    utf8_decode('Nombre o razón social'),
                    utf8_decode('Nombre comercial'),
                    utf8_decode('R.F.C.'),
                    utf8_decode('Primer apellido'),
                    utf8_decode('Segundo apellido'),
                    utf8_decode('Nombres'),
                    utf8_decode('Descripción de sus servicios'),
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
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_personalidad_juridica($row['id_personalidad_juridica'])),
                    utf8_decode($row['nombre_razon_social']),
                    utf8_decode($row['nombre_comercial']),
                    utf8_decode($row['rfc']),
                    utf8_decode($row['primer_apellido']),
                    utf8_decode($row['segundo_apellido']),
                    utf8_decode($row['nombres']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_servicios'])),
                    utf8_decode($this->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == '0' ? '' : $row['periodo']),
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

    function agregar_proveedor()
    {

        $existeRZ = $this->existe_proveedor_razon_social($this->input->post('nombre_razon_social'), '');
        $existeRFC = $this->existe_proveedor_rfc($this->input->post('rfc'), '');
        
        if($existeRFC || $existeRZ){
            // numero, existe razon social, existe rfc
            return array(2, $existeRZ ,$existeRFC); // field is duplicated
        }else{
            $dateFV = '';
            if(!empty($this->input->post('fecha_validacion')))
            {
                $fecha =  str_replace('.', '-', $this->input->post('fecha_validacion')); 
                $aux = DateTime::createFromFormat('d-m-Y', $fecha);
                if($aux !== false)
                    $dateFV = $aux->format('Y-m-d'); 
            }
            $dateFA = '';
            if(!empty($this->input->post('fecha_actualizacion')))
            {
                $fecha =  str_replace('.', '-', $this->input->post('fecha_actualizacion')); 
                $aux = DateTime::createFromFormat('d-m-Y', $fecha);
                if($aux !== false)
                    $dateFA = $aux->format('Y-m-d'); 
            }
            
            $data_new = array(
                'id_proveedor' => '',
                'id_personalidad_juridica' => $this->input->post('id_personalidad_juridica'),
                'nombre_razon_social' => trim($this->input->post('nombre_razon_social')),
                'nombre_comercial' => trim($this->input->post('nombre_comercial')),
                'rfc' => trim($this->input->post('rfc')),
                'primer_apellido' => trim($this->input->post('primer_apellido')),
                'segundo_apellido' => trim($this->input->post('segundo_apellido')),
                'nombres' => trim($this->input->post('nombres')),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => trim($this->input->post('area_responsable')),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'descripcion_servicios' => $this->input->post('descripcion_servicios'),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_proveedores', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Proveedores', 'Alta proveedor: ' . $data_new['nombre_razon_social']);
                // numero, existe razon social, existe rfc
                return array(1, false , false); // is correct
            }else
            {
                // numero, existe razon social, existe rfc
                return array(0, false , false); // sometime is wrong
            }
        }
    }

    function editar_proveedor()
    {
        $existeRZ = $this->existe_proveedor_razon_social($this->input->post('nombre_razon_social'), $this->input->post('id_proveedor'));
        $existeRFC = $this->existe_proveedor_rfc($this->input->post('rfc'), $this->input->post('id_proveedor'));
     
        if($existeRFC || $existeRZ){
            // numero, existe razon social, existe rfc
            return array(2, $existeRZ ,$existeRFC); // field is duplicated
        }else{
            $dateFV = '';
            if(!empty($this->input->post('fecha_validacion')))
            {
                $fecha =  str_replace('.', '-', $this->input->post('fecha_validacion')); 
                $aux = DateTime::createFromFormat('d-m-Y', $fecha);
                if($aux !== false)
                    $dateFV = $aux->format('Y-m-d'); 
            }
            $dateFA = '';
            if(!empty($this->input->post('fecha_actualizacion')))
            {
                $fecha =  str_replace('.', '-', $this->input->post('fecha_actualizacion')); 
                $aux = DateTime::createFromFormat('d-m-Y', $fecha);
                if($aux !== false)
                    $dateFA = $aux->format('Y-m-d');  
            }
            
            $data_update = array(
                'id_personalidad_juridica' => $this->input->post('id_personalidad_juridica'),
                'nombre_razon_social' => trim($this->input->post('nombre_razon_social')),
                'nombre_comercial' => trim($this->input->post('nombre_comercial')),
                'rfc' => trim($this->input->post('rfc')),
                'primer_apellido' => trim($this->input->post('primer_apellido')),
                'segundo_apellido' => trim($this->input->post('segundo_apellido')),
                'nombres' => trim($this->input->post('nombres')),
                'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => trim($this->input->post('area_responsable')),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
                'descripcion_servicios' => $this->input->post('descripcion_servicios'),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_proveedor', $this->input->post('id_proveedor'));
            $this->db->update('tab_proveedores', $data_update);

            
           // echo  $this->db->last_query();
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Proveedores', 'Edición proveedor: ' . $data_update['nombre_razon_social']);
                // numero, existe razon social, existe rfc
                return array(1, false , false); // is correct
            }else
            {  
                // any trans error?
                if ($this->db->trans_status() === FALSE) {
                    return array(0, false , false); // something is not correct
                }else{
                    return array(1, false , false); // is correct
                }
            }
        }
    }

    function crear_archivo_proveedores($path, $namefile)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $filename = $path . $namefile;
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_proveedores');
        $csv_header = array('#',
                    utf8_decode('Personalidad jurídica'),
                    utf8_decode('Nombre o razón social'),
                    utf8_decode('Nombre comercial'),
                    utf8_decode('R.F.C.'),
                    utf8_decode('Primer apellido'),
                    utf8_decode('Segundo apellido'),
                    utf8_decode('Nombres'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable de la información'),
                    utf8_decode('Año'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Descripción de sus servicios'),
                    utf8_decode('Nota'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $count = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_personalidad_juridica($row['id_personalidad_juridica'])),
                    utf8_decode($row['nombre_razon_social']),
                    utf8_decode($row['nombre_comercial']),
                    utf8_decode($row['rfc']),
                    utf8_decode($row['primer_apellido']),
                    utf8_decode($row['segundo_apellido']),
                    utf8_decode($row['nombres']),
                    utf8_decode($this->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == '0' ? '' : $row['periodo']),
                    utf8_decode($this->dateToString($row['fecha_actualizacion'])),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_servicios'])),
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
    
}

?>