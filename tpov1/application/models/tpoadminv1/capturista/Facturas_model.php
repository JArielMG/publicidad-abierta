<?php

/**
 * Description of Facturas
 *
 * INAI TPO
 * 
 * 
 */
class Facturas_Model extends CI_Model
{
    function registro_bitacora($seccion,$accion){
        $this->load->model('tpoadminv1/bitacora/Bitacora_model');

        $reg_bitacora = array(
            'seccion' => $seccion, 
            'accion' => $accion 
        );

        $this->Bitacora_model->guardar_bitacora_general($reg_bitacora);

    }

    function dame_total_facturas()
    {
        return $this->db->count_all('tab_facturas');
    }

    function dame_paginacion_facturas($activos, $iDisplayStart, $iDisplayLength)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $this->db->limit($iDisplayLength, $iDisplayStart);
        //$this->db->limit(10, 1);

        $query = $this->db->get('tab_facturas');
        
        $iTotal = $this->Facturas_model->dame_total_facturas();
        $output = array(
            'sEcho' => intval($_GET['sEcho']),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iTotal,
            'aaData' => array()
        );

        if($query->num_rows() > 0)
        {
            $c_replace = array('\'', '"');
            $array_items = array();
            $cont = 0;
            $numeracion = $iDisplayStart;
            foreach ($query->result_array() as $row) 
            {
                $url_editar =  base_url() . "index.php/tpoadminv1/capturista/facturas/editar_factura/". $row['id_factura']; 
                $array_items['id'] = ++$numeracion;
                $array_items['id_factura'] = $row['id_factura'];
                $array_items['orden'] = $this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra']);
                $array_items['contrato'] = $this->Contratos_model->dame_nombre_contrato($row['id_contrato']);
                $array_items['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items['proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']);
                $array_items['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items['numero_factura'] = $row['numero_factura'];
                $array_items['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                $array_items['monto_factura'] = $this->Generales_model->money_format("%.2n", $this->get_monto_factura($row['id_factura']));;
                $array_items['active'] = $this->Generales_model->get_estatus_name($row['active']);
                $array_items['btn_ver'] = "<span class='btn-group btn btn-info btn-sm' onclick=\"abrirModal(" . $row['id_factura'] . ")\"> <i class='fa fa-search'></i></span>";
                $array_items['btn_editar'] = "<a href='" . $url_editar . "'><button class='btn btn-warning btn-sm' title='Editar'><i class=\"fa fa-edit\"></i></button></a>";
                $array_items['btn_eliminar'] = "<span class='btn-group btn btn-danger btn-sm' onclick=\"eliminarModal(" . $row['id_factura'] . ", '". str_replace($c_replace, "", $row['numero_factura']) . "')\"> <i class='fa fa-close'></i></span>";
                $output['aaData'][] = $array_items;
                $cont++;
            }
            
        }

        //print_r($output);
        return $output;
    }

    function dame_todas_facturas($activos, $idEjercicio = "", $idStatus = "")
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        if ($this->db->table_exists('vlista_facturas')){

            if ($idEjercicio == "" && $idStatus == ""){
                $ejercicios = $this->Catalogos_model->dame_todos_ejercicios(true);
                $ejercicios = array_reverse($ejercicios);
                for ($i = 0; $i < count($ejercicios); $i++) {
                    $idEjercicio = $ejercicios[$i]["id_ejercicio"];
                    if ($idEjercicio != "" && $idEjercicio != "0"){
                        $this->db->where('ejercicio', $this->Catalogos_model->dame_nombre_ejercicio($idEjercicio));
                    }

                    $query = $this->db->get('vlista_facturas');

                    if($query->num_rows() > 0)
                    {
                        $array_items = [];
                        $cont = 0;
                        foreach ($query->result_array() as $row) 
                        {
                            $row['selected'] = $idEjercicio;
                            $array_items[] = $row;
                        }
                        return $array_items;
                    }
                }
            }else{
            
                if ($idEjercicio != "" && $idEjercicio != "0"){
                    $this->db->where('ejercicio', $this->Catalogos_model->dame_nombre_ejercicio($idEjercicio));
                }

                if ($idStatus != "" && $idStatus != "0"){
                    $this->db->where('active', $this->Generales_model->get_estatus_name($idStatus));
                }else{
                    if($activos){
                        $this->db->where('active', '1');
                    }
                }

                $query = $this->db->get('vlista_facturas');
                return $query->result_array();
            }
        }else{
            if ($idEjercicio == "" && $idStatus == ""){
                $ejercicios = $this->Catalogos_model->dame_todos_ejercicios(true);
                $ejercicios = array_reverse($ejercicios);
                for ($i = 0; $i < count($ejercicios); $i++) {
                    $idEjercicio = $ejercicios[$i]["id_ejercicio"];
                    if ($idEjercicio != "" && $idEjercicio != "0"){
                        $this->db->where('id_ejercicio', $this->Catalogos_model->dame_nombre_ejercicio($idEjercicio));
                    }
                }

                $query = $this->db->get('tab_facturas');
            
                if($query->num_rows() > 0)
                {
                    $array_items = [];
                    $cont = 0;
                    foreach ($query->result_array() as $row) 
                    {
                        $array_items[$cont]['id'] = $cont + 1;
                        $array_items[$cont]['id_factura'] = $row['id_factura'];
                        $array_items[$cont]['orden'] = $this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra']);
                        $array_items[$cont]['contrato'] = $this->Contratos_model->dame_nombre_contrato($row['id_contrato']);
                        $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                        $array_items[$cont]['proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']);
                        $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                        $array_items[$cont]['numero_factura'] = $row['numero_factura'];
                        $array_items[$cont]['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                        $array_items[$cont]['monto_factura'] = $this->Generales_model->money_format("%.2n", $this->get_monto_factura($row['id_factura']));
                        $array_items[$cont]['link'] = base_url() . "index.php/tpoadminv1/capturista/facturas/editar_factura/".$row['id_factura'];
                        $array_items[$cont]['active'] = $this->Generales_model->get_estatus_name($row['active']);
                        $array_items[$cont]['selected'] = $idEjercicio;
                        $cont++;
                    }
                    return $array_items;
                }
            }else{
                if ($idEjercicio != "" && $idEjercicio != "0"){
                    $this->db->where('id_ejercicio', $idEjercicio);
                }

                if ($idStatus != "" && $idStatus != "0"){
                    $this->db->where('active', $idStatus);
                }else{
                    if($activos){
                        $this->db->where('active', '1');
                    }
                }

                $query = $this->db->get('tab_facturas');
            
                if($query->num_rows() > 0)
                {
                    $array_items = [];
                    $cont = 0;
                    foreach ($query->result_array() as $row) 
                    {
                        $array_items[$cont]['id'] = $cont + 1;
                        $array_items[$cont]['id_factura'] = $row['id_factura'];
                        $array_items[$cont]['orden'] = $this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra']);
                        $array_items[$cont]['contrato'] = $this->Contratos_model->dame_nombre_contrato($row['id_contrato']);
                        $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                        $array_items[$cont]['proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']);
                        $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                        $array_items[$cont]['numero_factura'] = $row['numero_factura'];
                        $array_items[$cont]['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                        $array_items[$cont]['monto_factura'] = $this->Generales_model->money_format("%.2n", $this->get_monto_factura($row['id_factura']));
                        $array_items[$cont]['link'] = base_url() . "index.php/tpoadminv1/capturista/facturas/editar_factura/".$row['id_factura'];
                        $array_items[$cont]['active'] = $this->Generales_model->get_estatus_name($row['active']);
                        $cont++;
                    }
                    return $array_items;
                }
            }
        }
    }

    function dame_factura_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_factura', $id);
        $query = $this->db->get('tab_facturas');

        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
    
                $register = array(
                    'id_factura' => $row['id_factura'],
                    'id_contrato' => $row['id_contrato'],
                    'nombre_contrato' => $this->Contratos_model->dame_nombre_contrato($row['id_contrato']),
                    'id_orden_compra' => $row['id_orden_compra'],
                    'numero_orden_compra' => $this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra']),
                    'id_proveedor' => $row['id_proveedor'],
                    'nombre_proveedor' => $this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor']),
                    'nombre_comercial_proveedor' => $this->Proveedores_model->dame_nombre_comercial_proveedor($row['id_proveedor']),
                    'id_presupuesto_concepto' => $row['id_presupuesto_concepto'],
                    'id_ejercicio' => $row['id_ejercicio'],
                    'ejercicio' => $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'trimestre' => $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'numero_factura' => $row['numero_factura'],
                    'fecha_erogacion' => $this->Generales_model->dateToString($row['fecha_erogacion']),
                    'url_factura_pdf' => $row['url_factura_pdf'],
                    'file_factura_pdf' => $row['file_factura_pdf'],
                    'name_file_factura_pdf' => $row['file_factura_pdf'],
                    'path_file_factura_pdf' => $this->Generales_model->ruta_descarga_archivos($row['file_factura_pdf'],  'data/facturas/'),
                    'url_factura_xml' => $row['url_factura_xml'],
                    'file_factura_xml' => $row['file_factura_xml'],
                    'name_file_factura_xml' => $row['file_factura_xml'],
                    'path_file_factura_xml' => $this->Generales_model->ruta_descarga_archivos($row['file_factura_xml'],  'data/facturas/'),
                    'fecha_validacion' => $this->Generales_model->dateToString($row['fecha_validacion']),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == '0' ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->Generales_model->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'active' => $row['active'],
                    'estatus' => $this->Generales_model->get_estatus_name($row['active']),
                    'monto' => $this->Generales_model->money_format("%.2n", $this->get_monto_factura($row['id_factura']))
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function descarga_facturas()
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $filename = 'dist/csv/facturas.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('tab_facturas');
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    utf8_decode('Proveedor'),
                    utf8_decode('Contrato'),
                    utf8_decode('Orden'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Número de factura'),
                    utf8_decode('Monto'),
                    utf8_decode('Fecha de erogación'),
                    utf8_decode('Hipervínculo a la factura en formato PDF'),
                    utf8_decode('Archivo de factura en PDF'),
                    utf8_decode('Hipervínculo a la factura en formato XML'),
                    utf8_decode('Archivo de factura en XML'),
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
                //$montos = $this->getMontos($row['id_contrato'], $row['monto_contrato']);
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor'])),
                    utf8_decode($this->Contratos_model->dame_nombre_contrato($row['id_contrato'])),
                    utf8_decode($this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre'])),
                    utf8_decode($row['numero_factura']),
                    utf8_decode($this->Generales_model->money_format("%.2n", $this->get_monto_factura($row['id_factura']))),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_erogacion'])),
                    utf8_decode($row['url_factura_pdf']),
                    utf8_decode($row['file_factura_pdf']),
                    utf8_decode($row['url_factura_xml']),
                    utf8_decode($row['file_factura_xml']),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo']),
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

    function agregar_factura()
    {
        $this->load->model('tpoadminv1/Generales_model');
        $this->db->where('numero_factura', $this->input->post('numero_factura'));
        $query = $this->db->get('tab_facturas');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            
            $data_new = array(
                'id_factura' => '',
                'id_proveedor' => $this->input->post('id_proveedor'),
                'id_contrato' => $this->input->post('id_contrato'),
                'id_orden_compra' => $this->input->post('id_orden_compra'),
                'id_ejercicio' => $this->input->post('id_ejercicio'),
                'id_trimestre' => $this->input->post('id_trimestre'),
                'id_so_contratante' => NULL,
                'id_presupuesto_concepto' => NULL,
                'numero_factura' => $this->input->post('numero_factura'),
                'fecha_erogacion' => $this->Generales_model->stringToDate($this->input->post('fecha_erogacion')),
                'url_factura_pdf' => $this->input->post('url_factura_pdf'),
                'file_factura_pdf' => $this->input->post('name_file_factura_pdf'),
                'url_factura_xml' => $this->input->post('url_factura_xml'),
                'file_factura_xml' => $this->input->post('name_file_factura_xml'),
                'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_facturas', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Facturas', 'Alta de la factura: ' . $data_new['numero_factura']);
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_factura()
    {

        $idFactura = $this->input->post('id_factura');
        $regAnt = $this->dame_factura_id($idFactura);

        $this->load->model('tpoadminv1/Generales_model');
        $this->db->where('numero_factura', $this->input->post('numero_factura'));
        $this->db->where_not_in('id_factura', $this->input->post('id_factura'));
        $query = $this->db->get('tab_facturas');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{

            $continueUpdate = true;

            if ($regAnt['active'] != $this->input->post('active')){
                if($this->editar_status_factura_desglose($idFactura,"") == 0){
                    $continueUpdate = false;
                }
            }

            if ($continueUpdate){
            
                $data_update = array(
                    'id_proveedor' => $this->input->post('id_proveedor'),
                    'id_contrato' => $this->input->post('id_contrato'),
                    'id_orden_compra' => $this->input->post('id_orden_compra'),
                    'id_ejercicio' => $this->input->post('id_ejercicio'),
                    'id_trimestre' => $this->input->post('id_trimestre'),
                    'id_so_contratante' => NULL,
                    'id_presupuesto_concepto' => NULL,
                    'numero_factura' => $this->input->post('numero_factura'),
                    'fecha_erogacion' => $this->Generales_model->stringToDate($this->input->post('fecha_erogacion')),
                    'url_factura_pdf' => $this->input->post('url_factura_pdf'),
                    'file_factura_pdf' => $this->input->post('name_file_factura_pdf'),
                    'url_factura_xml' => $this->input->post('url_factura_xml'),
                    'file_factura_xml' => $this->input->post('name_file_factura_xml'),
                    'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                    'area_responsable' => $this->input->post('area_responsable'),
                    'periodo' => $this->input->post('periodo'),
                    'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                    'nota' => $this->input->post('nota'),
                    'active' => $this->input->post('active')
                );

                $this->db->where('id_factura', $this->input->post('id_factura'));
                $this->db->update('tab_facturas', $data_update);
        
                if($this->db->affected_rows() > 0)
                {
                    $this->registro_bitacora('Facturas', 'Edición de la factura: ' . $data_update['numero_factura']);
                    return 1; // is correct
                }else
                {
                    // any trans error?
                    if ($this->db->trans_status() === FALSE) {
                        return 0; // something is not correct
                    }else{ 
                        return 1; // is correct
                    }
                }
            }
        }
    }

    function editar_status_factura()
    {
        $this->load->model('tpoadminv1/Generales_model');
        $query = $this->db->get('tab_facturas');
    
        $data_update = array(
            'active' => $this->input->post('active')
        );

        if ($this->input->post('id_year_selected') != "" && $this->input->post('id_year_selected') != "0"){
            $this->db->where('id_ejercicio', $this->input->post('id_year_selected'));
        }

        $this->db->update('tab_facturas', $data_update);

        if($this->db->affected_rows() > 0)
        {

            if ($this->input->post('id_year_selected') != ""){
                $presupuestosArray = $this->dame_todas_facturas("",$this->input->post('id_year_selected'), "");

                foreach ( $presupuestosArray as $row) {
                    $this->editar_status_factura_desglose($row['id_factura'],$this->input->post('active'));
                }
            }else{
                $this->editar_status_factura_desglose("","");
            }

            $this->registro_bitacora('Facturas', 'Edición de las facturas');
            return 1; // is correct
        }else
        {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return 0; // something is not correct
            }else{
                return 1; // is correct
            }
        }
        
    }

    function get_monto_factura($id_factura)
    {
        $monto = 0.00;
        $facturas_desgloses = $this->dame_todas_facturas_desglose($id_factura, true);

        if (is_array($facturas_desgloses)){
            for($z = 0; $z < sizeof($facturas_desgloses); $z++)
            {
                $monto += floatval($facturas_desgloses[$z]['monto_desglose']);
            }
        }

        return $monto;
    }

    function dame_todas_facturas_desglose($id_factura, $activos)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');

        if($activos){
            $this->db->where('active', '1');
        }

        $this->db->where('id_factura', $id_factura);
        $query = $this->db->get('tab_facturas_desglose');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_factura_desglose'] = $row['id_factura_desglose'];
                $array_items[$cont]['id_factura'] = $row['id_factura'];
                $array_items[$cont]['nombre_campana_aviso'] = $this->Ordenes_compra_model->dame_nombre_campana_aviso($row['id_campana_aviso']);
                $array_items[$cont]['monto_subconcepto'] = $this->Generales_model->money_format("%.2n", $row['monto_desglose']);
                $array_items[$cont]['nombre_so_contratante'] = $this->Contratos_model->dame_nombre_contratante($row['id_so_contratante']);
                $array_items[$cont]['nombre_so_solicitante'] = $this->Contratos_model->dame_nombre_contratante($row['id_so_solicitante']);
                $array_items[$cont]['presupuesto_concepto'] = $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto']);
                $array_items[$cont]['presupuesto_concepto_solicitante'] = $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto_solicitante']);
                $array_items[$cont]['nombre_servicio_categoria'] = $this->Catalogos_model->dame_nombre_servicio_categoria($row['id_servicio_categoria']);
                $array_items[$cont]['nombre_servicio_clasificacion'] = $this->Catalogos_model->dame_nombre_servicio_clasificacion($row['id_servicio_clasificacion']);
                $array_items[$cont]['monto_desglose'] = $row['monto_desglose'];
                $array_items[$cont]['monto_desglose_format'] = $this->Generales_model->money_format("%.2n", $row['monto_desglose']);
                $array_items[$cont]['active'] = $this->Generales_model->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_items;
        }
    }

    function get_value_indefinido_partida($valor)
    {
        if($valor == NULL || $valor == 0 )
            return -1;
        else
            return $valor;
    }

    function dame_factura_desglose_id($id)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_factura_desglose', $id);
        $query = $this->db->get('tab_facturas_desglose');

        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                
                $register = array(
                    'id_factura_desglose' => $row['id_factura_desglose'],
                    'id_factura' => $row['id_factura'],
                    'id_campana_aviso' => $row['id_campana_aviso'],
                    'nombre_campana_aviso' => $this->Ordenes_compra_model->dame_nombre_campana_aviso($row['id_campana_aviso']),
                    'id_servicio_clasificacion' => $row['id_servicio_clasificacion'],
                    'nombre_servicio_clasificacion' => $this->Catalogos_model->dame_nombre_servicio_clasificacion($row['id_servicio_clasificacion']),
                    'id_servicio_categoria' => $row['id_servicio_categoria'],
                    'nombre_servicio_categoria' => $this->Catalogos_model->dame_nombre_servicio_categoria($row['id_servicio_categoria']),
                    'id_servicio_subcategoria' => $row['id_servicio_subcategoria'],
                    'nombre_servicio_subcategoria' => $this->Catalogos_model->dame_nombre_servicio_subcategoria($row['id_servicio_subcategoria']),
                    'id_servicio_unidad' => $row['id_servicio_unidad'],
                    'nombre_servicio_unidad' => $this->Catalogos_model->dame_nombre_servicio_unidad($row['id_servicio_unidad']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'nombre_so_contratante' => $this->Contratos_model->dame_nombre_contratante($row['id_so_contratante']),
                    'id_presupuesto_concepto' => $this->get_value_indefinido_partida($row['id_presupuesto_concepto']),
                    'nombre_presupuesto_concepto' => $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto']),
                    'id_so_solicitante' => $row['id_so_solicitante'],
                    'nombre_so_solicitante' => $this->Contratos_model->dame_nombre_solicitante($row['id_so_solicitante']),
                    'id_presupuesto_concepto_solicitante' => $this->get_value_indefinido_partida($row['id_presupuesto_concepto_solicitante']),
                    'nombre_presupuesto_concepto_solicitante' => $this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto_solicitante']),
                    'numero_partida' => $row['numero_partida'],
                    'descripcion_servicios' => $row['descripcion_servicios'],
                    'cantidad' => $row['cantidad'],
                    'precio_unitarios' => $row['precio_unitarios'],
                    'precio_unitarios_format' => $this->Generales_model->money_format("%.2n", $row['precio_unitarios']),
                    'monto_desglose' => $row['monto_desglose'],
                    'monto_desglose_format' => $this->Generales_model->money_format("%.2n", $row['monto_desglose']),
                    'area_administrativa' => $row['area_administrativa'],
                    'fecha_validacion' =>  $this->Generales_model->dateToString($row['fecha_validacion']),
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'] == 0 ? '' : $row['periodo'],
                    'fecha_actualizacion' => $this->Generales_model->dateToString($row['fecha_actualizacion']),
                    'nota' => $row['nota'],
                    'active' => $row['active'],
                    'estatus' => $this->Generales_model->get_estatus_name($row['active']),
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function agregar_factura_desglose()
    {
        $this->load->model('tpoadminv1/Generales_model');

        $monto_desglose = floatval($this->input->post('cantidad')) * floatval($this->input->post('precio_unitarios'));

        $id_sujeto = '';
        $id_presupuesto = '';
        if($this->input->post('id_presupuesto_concepto') != '-1'){
            $id_sujeto = $this->input->post('id_so_contratante');
            $id_presupuesto = $this->input->post('id_presupuesto_concepto');
        }else if($this->input->post('id_presupuesto_concepto_solicitante') != '-1'){
            $id_sujeto = $this->input->post('id_so_solicitante');
            $id_presupuesto = $this->input->post('id_presupuesto_concepto_solicitante');
        }

        $monto_fd_actual = 0;
        $procede_presupuesto = $this->es_correcto_monto_presupuesto(
                $this->input->post('id_factura'), $id_sujeto, $id_presupuesto, $monto_desglose, $monto_fd_actual);
        
        $result = array(1, 'Exito');
        if($procede_presupuesto[0] == false){
            $result[0] = 2;
            $result[1] = $procede_presupuesto[1]; //mensaje de error
            return $result; // presupuesto insuficiente
        }else{
            
            $id_unidad = $this->input->post('id_servicio_unidad');
            if($this->input->post('id_servicio_unidad') == '0' )
                $id_unidad = NULL;

            $data_new = array(
                'id_factura_desglose' => '',
                'id_factura' => $this->input->post('id_factura'),
                'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
                'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
                'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
                'id_servicio_unidad' => $id_unidad,
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'id_presupuesto_concepto_solicitante' => $this->input->post('id_presupuesto_concepto_solicitante'),
                'numero_partida' => '0',
                'descripcion_servicios' => $this->input->post('descripcion_servicios'),
                'cantidad' => $this->input->post('cantidad'),
                'precio_unitarios' => $this->input->post('precio_unitarios'),
                'monto_desglose' => $monto_desglose,
                'area_administrativa' => $this->input->post('area_administrativa'),
                'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->insert('tab_facturas_desglose', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Facturas', 'Alta de la factura con desglose: ' . $data_new['monto_desglose']);
                return $result; // is correct
            }else
            {
                $result[0] = 0;
                $result[1] = 'algo salio mal'; //mensaje de error
                return $result; // sometime is wrong
            }
        }
    }

    function editar_factura_desglose()
    {
        $this->load->model('tpoadminv1/Generales_model');
        $monto_desglose = floatval($this->input->post('cantidad')) * floatval($this->input->post('precio_unitarios'));

        $id_sujeto = '';
        $id_presupuesto = '';
        if($this->input->post('id_presupuesto_concepto') != '-1'){
            $id_sujeto = $this->input->post('id_so_contratante');
            $id_presupuesto = $this->input->post('id_presupuesto_concepto');
        }else if($this->input->post('id_presupuesto_concepto_solicitante') != '-1'){
            $id_sujeto = $this->input->post('id_so_solicitante');
            $id_presupuesto = $this->input->post('id_presupuesto_concepto_solicitante');
        }

        $fd_actual = $this->dame_factura_desglose_id($this->input->post('id_factura_desglose'));
        $monto_fd_actual = 0;
        if(!empty($fd_actual)){
            $monto_fd_actual  = floatval($fd_actual['monto_desglose']);
        }

        $procede_presupuesto = $this->es_correcto_monto_presupuesto(
                $this->input->post('id_factura'), $id_sujeto, $id_presupuesto, $monto_desglose, $monto_fd_actual);
        
        $result = array(1, 'Exito');
        if($procede_presupuesto[0] == false){
            $result[0] = 2;
            $result[1] = $procede_presupuesto[1]; //mensaje de error
            return $result; // presupuesto insuficiente
        }else{
            
            $id_unidad = $this->input->post('id_servicio_unidad');
            if($this->input->post('id_servicio_unidad') == '0' )
                $id_unidad = NULL;

            $data_update = array(
                'id_factura' => $this->input->post('id_factura'),
                'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
                'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
                'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
                'id_servicio_unidad' => $id_unidad,
                'id_so_contratante' => $this->input->post('id_so_contratante'),
                'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
                'id_so_solicitante' => $this->input->post('id_so_solicitante'),
                'id_presupuesto_concepto_solicitante' => $this->input->post('id_presupuesto_concepto_solicitante'),
                'numero_partida' => '0',
                'descripcion_servicios' => $this->input->post('descripcion_servicios'),
                'cantidad' => $this->input->post('cantidad'),
                'precio_unitarios' => $this->input->post('precio_unitarios'),
                'monto_desglose' => $monto_desglose,
                'area_administrativa' => $this->input->post('area_administrativa'),
                'fecha_validacion' => $this->Generales_model->stringToDate($this->input->post('fecha_validacion')),
                'area_responsable' => $this->input->post('area_responsable'),
                'periodo' => $this->input->post('periodo'),
                'fecha_actualizacion' => $this->Generales_model->stringToDate($this->input->post('fecha_actualizacion')),
                'nota' => $this->input->post('nota'),
                'active' => $this->input->post('active')
            );
            
            $this->db->where('id_factura_desglose', $this->input->post('id_factura_desglose'));
            $this->db->update('tab_facturas_desglose', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                $this->registro_bitacora('Facturas', 'Edición de la factura con desglose: ' . $data_update['monto_desglose']);
                return $result; // is correct
            }else
            {
                // any trans error?
                if ($this->db->trans_status() === FALSE) {
                    $result[0] = 0;
                    $result[1] = 'algo salio mal'; //mensaje de error
                }
                return $result; // sometime is wrong
            }
        }
    }


    function editar_status_factura_desglose($id = "", $status = "")
    {
        if ($status == ""){
            $data_update = array(
                'active' => $this->input->post('active')
            );
        }else {
            $data_update = array(
                'active' => $status
            );
        }

        if ($id != ""){
            $this->db->where('id_factura', $id);
        }

        $this->db->update('tab_facturas_desglose', $data_update);

        if($this->db->affected_rows() > 0)
        {
            $this->registro_bitacora('Facturas', 'Edición de las facturas con desglose');
            $result[0] = 1;
            return $result; // is correct
        }else
        {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                $result[0] = 0;
                $result[1] = 'algo salio mal'; //mensaje de error
            }else{
                $this->registro_bitacora('Facturas', 'Edición de las facturas con desglose');
                $result[0] = 1;
            }
            return $result; // sometime is wrong
        }
        
    }


    function eliminar_factura($id)
    {
        $reg_eliminado = $this->dame_factura_id($id);

        $this->db->where('id_factura', $id);
        $this->db->delete('tab_facturas');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado)){
                $this->registro_bitacora('Facturas', 'Eliminación factura con número: ' . $reg_eliminado['numero_factura'] );
            }
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function eliminar_factura_desglose($id)
    {
        $reg_eliminado = $this->dame_factura_desglose_id($id);
        $this->db->where('id_factura_desglose', $id);
        $this->db->delete('tab_facturas_desglose');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado)){
                $ca = "campaña " . $reg_eliminado['nombre_campana_aviso'];
                $fac = $this->dame_factura_id($reg_eliminado['id_factura']);
                if(!empty($fac)){
                    $ca .= " de la factura con número " . $fac['numero_factura'];
                }
                $this->registro_bitacora('Facturas', 'Eliminación factura detalle: ' . $ca );
            }
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function descarga_facturas_desglose($id_factura)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $filename = 'dist/csv/factura_desglose_' . $id_factura . '.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $this->db->where('id_factura', $id_factura);
        $query = $this->db->get('tab_facturas_desglose');
        $csv_header = array('#',
                    utf8_decode('Campaña o aviso institucional'),
                    utf8_decode('Clasificación del servicio'),
                    utf8_decode('Categoría del servicio'),
                    utf8_decode('Subcategoría del servicio'),
                    utf8_decode('Unidad'),
                    utf8_decode('Sujeto obligado contratante'),
                    utf8_decode('Partida del contratante'),
                    utf8_decode('Sujeto obligado solicitante'),
                    utf8_decode('Partida del solicitante'),
                    utf8_decode('Área administrativa encargada de solicitar el servicio'),
                    utf8_decode('Descripción del servicio o producto adquirido'),
                    utf8_decode('Cantidad'),
                    utf8_decode('Precio unitario con I.V.A. incluido'),
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
                $csv = array(
                    utf8_decode($count),
                    utf8_decode($this->Ordenes_compra_model->dame_nombre_campana_aviso($row['id_campana_aviso'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_servicio_clasificacion($row['id_servicio_clasificacion'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_servicio_categoria($row['id_servicio_categoria'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_servicio_subcategoria($row['id_servicio_subcategoria'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_servicio_unidad($row['id_servicio_unidad'])),
                    utf8_decode($this->Contratos_model->dame_nombre_contratante($row['id_so_contratante'])),
                    utf8_decode($this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto'])),
                    utf8_decode($this->Contratos_model->dame_nombre_solicitante($row['id_so_solicitante'])),
                    utf8_decode($this->Catalogos_model->dame_presupuestos_concepto_nombre($row['id_presupuesto_concepto_solicitante'])),
                    utf8_decode($row['area_administrativa']),
                    utf8_decode($this->Generales_model->clear_html_tags($row['descripcion_servicios'])),
                    utf8_decode($row['cantidad']),
                    utf8_decode($this->Generales_model->money_format("%.2n", $row['precio_unitarios'])),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_validacion'])),
                    utf8_decode($row['area_responsable']),
                    utf8_decode($row['periodo'] == 0 ? '' : $row['periodo']),
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

    function es_correcto_monto_presupuesto($id_factura, $id_sujeto, $id_presupuesto_concepto, $monto, $monto_fd_actual)
    {
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $factura = $this->dame_factura_id($id_factura);
        
        $responde = array(false, 'El presupuesto no cuenta con suficientes fondos');
        if(isset($factura) && !empty($factura))
        {
            $id_presupuesto = $this->Presupuestos_model->get_id_presupuesto_by_ejercicio_so_contratante(
                $factura['id_ejercicio'], $id_sujeto);

            $partida = $this->Presupuestos_model->dame_presupuestos_desglose_by_id_presupuesto_concepto(
                $id_presupuesto, $id_presupuesto_concepto);
            
            if(!empty($partida))
            {   
                
                $monto_total_presupuesto = floatval($partida['monto_presupuesto']) + floatval($partida['monto_modificacion']); 
                $gastado = $this->Presupuestos_model->partidad_presupuesto_gastado($factura['id_ejercicio'], $id_presupuesto_concepto, $id_sujeto);
                $gastado = $gastado - $monto_fd_actual;
                if(($monto + $gastado) <= $monto_total_presupuesto){
                    $responde = array(true, '');
                }
            }

        }

        return $responde;
    }

    function dame_facturas_desglose($id_ejercicio, $id_so, $id_presupuesto_concepto)
    {
        $query = "select b.* from tab_facturas a
            join tab_facturas_desglose b
            where (a.id_factura = b.id_factura)
            and (a.id_ejercicio = " . $id_ejercicio . ")
            and (b.id_so_contratante = " . $id_so . " or b .id_so_solicitante = " . $id_so . ") 
            and (b.id_presupuesto_concepto = " . $id_presupuesto_concepto . " or b.id_presupuesto_concepto_solicitante = " . $id_presupuesto_concepto . ")";

        $query = $this->db->query($query);

        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_items[$cont]['id_factura_desglose'] = $row['id_factura_desglose'];
                $array_items[$cont]['monto_desglose'] = $row['monto_desglose'];
                $cont++;
            }
            return $array_items;
        }
    }

    function revisar_invalides_monto_contrato($id_factura, $cantidad, $precio_unitario, $id_factura_desglose){
        //monto conciderado es cuando se edita un desglose de factura, ese es para eliminarlo y no afecte a lo ejercido
        $factura = $this->dame_factura_id($id_factura);
        $factura_desglose = $this->dame_factura_desglose_id($id_factura_desglose);

        $monto_conciderado = 0;
        if(!empty($factura_desglose)){
            $monto_conciderado = floatval($factura_desglose['monto_desglose']);
        }
        
        if(!empty($factura) && $factura['id_contrato'] > 1){
            $montos = $this->Contratos_model->getMontosContrato_id($factura['id_contrato']);
           
            if(!empty($montos)){
                $monto_totalc = floatval($montos['monto_contrato']) + floatval($montos['monto_modificado']);

                $monto_ejercido = floatval($montos['monto_pagado']);
                $monto_agregar = floatval($cantidad) * floatval($precio_unitario);

                $monto_a_ejercer = $monto_agregar + ($monto_ejercido - $monto_conciderado); 

                if($monto_a_ejercer > $monto_totalc){
                   return true; // regresa como invalido cuando el monto a ejercer es mayor al monto total
                }
            }
        }

        return false;
    }    
	
	function last_id_factura()
    {
        $query_str = 'select * from tab_facturas order by id_factura desc limit 1'; 
        
        $query = $this->db->query($query_str);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) { }
            return $row['id_factura'];
        }else{
            return 0;
        }   
    }
	
    function get_monto_factura_by_idejercicio($id_ejercicio){
        $sqltext = 'select 
                count(*) as total,
                ifnull(sum(b.monto_desglose),0) as monto_erogado
            from vact_facturas as a
            join vact_facturas_desglose_v2 as b 
            on a.id_factura = b.id_factura
            where id_ejercicio = ' . $id_ejercicio;

        $query = $this->db->query( $sqltext );
        
        return $query->result_array();
    }
}
?>