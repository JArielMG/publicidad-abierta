<?php

/* 
INAI / CAMPANAS Y AVISOS INSTITUCIONALES
 */

class Campana_Model extends CI_Model
{

    function ruta_descarga_archivos($name_file, $path_file)
    {
        if(isset($name_file)){
            return base_url() . $path_file . $name_file;
        }else{
            return '';
        }
    }

    function dame_todas_facturas($activos)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        if($activos){
            $this->db->where('active', '1');
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

    function dame_todas_campanas($idEjercicio = "", $idStatus = "")
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        if ($idEjercicio == "" && $idStatus == ""){

            $estatus = array('1', '2','3','4');
            $this->db->where_in('active', $estatus);


            $ejercicios = $this->Catalogos_model->dame_todos_ejercicios(true);
            $ejercicios = array_reverse($ejercicios);
            for ($i = 0; $i < count($ejercicios); $i++) {
                $idEjercicio = $ejercicios[$i]["id_ejercicio"];
                if ($idEjercicio != "" && $idEjercicio != "0"){
                    $this->db->where('id_ejercicio', $idEjercicio);
                }
                
                $this->db->order_by('id_campana_aviso', 'desc');
                $query = $this->db->get('tab_campana_aviso');
                
                if($query->num_rows() > 0)
                {
                    $array_camp_avisos = [];
                    $cont = 0;
                    foreach ($query->result_array() as $row) 
                    {
                        $array_camp_avisos[$cont]['conteo'] = $cont+1;
                        $array_camp_avisos[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                        $array_camp_avisos[$cont]['id_campana_cobertura'] = $row['id_campana_cobertura'];
                        $array_camp_avisos[$cont]['id_campana_tipo'] = $row['id_campana_tipo'];
                        $array_camp_avisos[$cont]['nombre_campana_tipo'] = $this->dame_camp_tipo_nombre($row['id_campana_tipo']);
                        $array_camp_avisos[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                        $array_camp_avisos[$cont]['nombre_campana_subtipo'] = $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']);
                        $array_camp_avisos[$cont]['id_campana_tema'] = $row['id_campana_tema'];
                        $array_camp_avisos[$cont]['id_campana_objetivo'] = $row['id_campana_objetivo'];
                        $array_camp_avisos[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                        $array_camp_avisos[$cont]['nombre_ejercicio'] = $this->dame_ejercicio_nombre($row['id_ejercicio']);
                        $array_camp_avisos[$cont]['id_trimestre'] = $row['id_trimestre'];
                        $array_camp_avisos[$cont]['nombre_trimestre'] = $this->dame_trimestre_nombre($row['id_trimestre']);
                        $array_camp_avisos[$cont]['fecha_inicio_periodo'] = $row['fecha_inicio_periodo'];
                        $array_camp_avisos[$cont]['fecha_termino_periodo'] = $row['fecha_termino_periodo'];
                        $array_camp_avisos[$cont]['id_so_contratante'] = $row['id_so_contratante'];
                        //$array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_soc_nombre($row['id_so_contratante']);
                        $array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_nombre_contratante($row['id_so_contratante']);
                        $array_camp_avisos[$cont]['id_so_solicitante'] = $row['id_so_solicitante'];
                        //$array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_sos_nombre($row['id_so_solicitante']);
                        $array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                        $array_camp_avisos[$cont]['id_tiempo_oficial'] = $row['id_tiempo_oficial'];
                        $array_camp_avisos[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                        $array_camp_avisos[$cont]['objetivo_comunicacion'] = $row['objetivo_comunicacion'];
                        $array_camp_avisos[$cont]['fecha_inicio'] = $row['fecha_inicio'];
                        $array_camp_avisos[$cont]['fecha_termino'] = $row['fecha_termino'];
                        $array_camp_avisos[$cont]['fecha_inicio_to'] = $row['fecha_inicio_to'];
                        $array_camp_avisos[$cont]['fecha_termino_to'] = $row['fecha_termino_to'];
                        $array_camp_avisos[$cont]['id_campana_tipoTO'] = $row['id_campana_tipoTO'];
                        $array_camp_avisos[$cont]['id_presupuesto'] = $row['id_presupuesto'];
                        $array_camp_avisos[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                        $array_camp_avisos[$cont]['monto_tiempo'] = $row['monto_tiempo'];
                        $array_camp_avisos[$cont]['hora_to'] = $row['hora_to'];
                        $array_camp_avisos[$cont]['minutos_to'] = $row['minutos_to'];
                        $array_camp_avisos[$cont]['segundos_to'] = $row['segundos_to'];
                        $array_camp_avisos[$cont]['mensajeTO'] = $row['mensajeTO'];
                        $array_camp_avisos[$cont]['descripcion_unidad'] = $row['descripcion_unidad'];
                        $array_camp_avisos[$cont]['responsable_publisher'] = $row['responsable_publisher'];
                        $array_camp_avisos[$cont]['name_comercial'] = $row['name_comercial'];
                        $array_camp_avisos[$cont]['razones_supplier'] = $row['razones_supplier'];
                        $array_camp_avisos[$cont]['difusion_mensaje'] = $row['difusion_mensaje'];
                        $array_camp_avisos[$cont]['num_factura'] = $row['num_factura'];
                        $array_camp_avisos[$cont]['publicacion_segob'] = $row['publicacion_segob'];
                        $array_camp_avisos[$cont]['campana_ambito_geo'] = $row['campana_ambito_geo'];
                        $array_camp_avisos[$cont]['plan_acs'] = $row['plan_acs'];
                        $array_camp_avisos[$cont]['fecha_dof'] = $row['fecha_dof'];
                        $array_camp_avisos[$cont]['evaluacion'] = $row['evaluacion'];
                        $array_camp_avisos[$cont]['evaluacion_documento'] = $row['evaluacion_documento'];
                        $array_camp_avisos[$cont]['fecha_validacion'] = $row['fecha_validacion'];
                        $array_camp_avisos[$cont]['area_responsable'] = $row['area_responsable'];
                        $array_camp_avisos[$cont]['periodo'] = $row['periodo'];
                        $array_camp_avisos[$cont]['fecha_actualizacion'] = $row['fecha_actualizacion'];
                        $array_camp_avisos[$cont]['nota'] = $row['nota'];
                        $array_camp_avisos[$cont]['autoridad'] = $row['autoridad'];
                        $array_camp_avisos[$cont]['clave_campana'] = $row['clave_campana'];
                        $array_camp_avisos[$cont]['active'] = $this->get_estatus_name($row['active']);
                        $cont++;
                    }
                    return $array_camp_avisos;
                }
            }




        }else{

            $estatus = array('1', '2','3','4');
            $this->db->where_in('active', $estatus);

            if ($idEjercicio != "" && $idEjercicio != "0"){
                $this->db->where('id_ejercicio', $idEjercicio);
            }

            if ($idStatus != "" && $idStatus != "0"){
                $this->db->where('active', $idStatus);
            }

            $this->db->order_by('id_campana_aviso', 'desc');
            $query = $this->db->get('tab_campana_aviso');
            
            if($query->num_rows() > 0)
            {
                $array_camp_avisos = [];
                $cont = 0;
                foreach ($query->result_array() as $row) 
                {
                    $array_camp_avisos[$cont]['conteo'] = $cont+1;
                    $array_camp_avisos[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                    $array_camp_avisos[$cont]['id_campana_cobertura'] = $row['id_campana_cobertura'];
                    $array_camp_avisos[$cont]['id_campana_tipo'] = $row['id_campana_tipo'];
                    $array_camp_avisos[$cont]['nombre_campana_tipo'] = $this->dame_camp_tipo_nombre($row['id_campana_tipo']);
                    $array_camp_avisos[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                    $array_camp_avisos[$cont]['nombre_campana_subtipo'] = $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']);
                    $array_camp_avisos[$cont]['id_campana_tema'] = $row['id_campana_tema'];
                    $array_camp_avisos[$cont]['id_campana_objetivo'] = $row['id_campana_objetivo'];
                    $array_camp_avisos[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                    $array_camp_avisos[$cont]['nombre_ejercicio'] = $this->dame_ejercicio_nombre($row['id_ejercicio']);
                    $array_camp_avisos[$cont]['id_trimestre'] = $row['id_trimestre'];
                    $array_camp_avisos[$cont]['nombre_trimestre'] = $this->dame_trimestre_nombre($row['id_trimestre']);
                    $array_camp_avisos[$cont]['fecha_inicio_periodo'] = $row['fecha_inicio_periodo'];
                    $array_camp_avisos[$cont]['fecha_termino_periodo'] = $row['fecha_termino_periodo'];
                    $array_camp_avisos[$cont]['id_so_contratante'] = $row['id_so_contratante'];
                    //$array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_soc_nombre($row['id_so_contratante']);
                    $array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_nombre_contratante($row['id_so_contratante']);
                    $array_camp_avisos[$cont]['id_so_solicitante'] = $row['id_so_solicitante'];
                    //$array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_sos_nombre($row['id_so_solicitante']);
                    $array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                    $array_camp_avisos[$cont]['id_tiempo_oficial'] = $row['id_tiempo_oficial'];
                    $array_camp_avisos[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                    $array_camp_avisos[$cont]['objetivo_comunicacion'] = $row['objetivo_comunicacion'];
                    $array_camp_avisos[$cont]['fecha_inicio'] = $row['fecha_inicio'];
                    $array_camp_avisos[$cont]['fecha_termino'] = $row['fecha_termino'];
                    $array_camp_avisos[$cont]['fecha_inicio_to'] = $row['fecha_inicio_to'];
                    $array_camp_avisos[$cont]['fecha_termino_to'] = $row['fecha_termino_to'];
                    $array_camp_avisos[$cont]['id_campana_tipoTO'] = $row['id_campana_tipoTO'];
    				$array_camp_avisos[$cont]['id_presupuesto'] = $row['id_presupuesto'];
    				$array_camp_avisos[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                    $array_camp_avisos[$cont]['monto_tiempo'] = $row['monto_tiempo'];
                    $array_camp_avisos[$cont]['hora_to'] = $row['hora_to'];
                    $array_camp_avisos[$cont]['minutos_to'] = $row['minutos_to'];
                    $array_camp_avisos[$cont]['segundos_to'] = $row['segundos_to'];
                    $array_camp_avisos[$cont]['mensajeTO'] = $row['mensajeTO'];
                    $array_camp_avisos[$cont]['descripcion_unidad'] = $row['descripcion_unidad'];
                    $array_camp_avisos[$cont]['responsable_publisher'] = $row['responsable_publisher'];
                    $array_camp_avisos[$cont]['name_comercial'] = $row['name_comercial'];
                    $array_camp_avisos[$cont]['razones_supplier'] = $row['razones_supplier'];
                    $array_camp_avisos[$cont]['difusion_mensaje'] = $row['difusion_mensaje'];
                    $array_camp_avisos[$cont]['num_factura'] = $row['num_factura'];
                    $array_camp_avisos[$cont]['publicacion_segob'] = $row['publicacion_segob'];
                    $array_camp_avisos[$cont]['campana_ambito_geo'] = $row['campana_ambito_geo'];
                    $array_camp_avisos[$cont]['plan_acs'] = $row['plan_acs'];
                    $array_camp_avisos[$cont]['fecha_dof'] = $row['fecha_dof'];
                    $array_camp_avisos[$cont]['evaluacion'] = $row['evaluacion'];
                    $array_camp_avisos[$cont]['evaluacion_documento'] = $row['evaluacion_documento'];
                    $array_camp_avisos[$cont]['fecha_validacion'] = $row['fecha_validacion'];
                    $array_camp_avisos[$cont]['area_responsable'] = $row['area_responsable'];
                    $array_camp_avisos[$cont]['periodo'] = $row['periodo'];
                    $array_camp_avisos[$cont]['fecha_actualizacion'] = $row['fecha_actualizacion'];
                    $array_camp_avisos[$cont]['nota'] = $row['nota'];
                    $array_camp_avisos[$cont]['autoridad'] = $row['autoridad'];
                    $array_camp_avisos[$cont]['clave_campana'] = $row['clave_campana'];
                    $array_camp_avisos[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
                }
                return $array_camp_avisos;
            }

        }
    }
	
	function dame_all_ejercicios($activos)
    {
        $this->load->model('tpoadminv1/Generales_model');

        if($activos == true){
            $this->db->where('active', '1');
        }
        $query = $this->db->get('cat_ejercicios');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                    $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                    $array_items[$cont]['active'] = $this->Generales_model->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }
	
    function descarga_campanas()
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
                    utf8_decode('Archivo de factura en PDF'),
                    utf8_decode('Archivo de factura en XML'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Área responsable de la información'),
                    utf8_decode('Fecha de validación'),
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
                    utf8_decode($this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio'])),
                    utf8_decode($this->Proveedores_model->dame_nombre_proveedor($row['id_proveedor'])),
                    utf8_decode($this->Contratos_model->dame_nombre_contrato($row['id_contrato'])),
                    utf8_decode($this->Ordenes_compra_model->dame_nombre_orden_compra($row['id_orden_compra'])),
                    utf8_decode($this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre'])),
                    utf8_decode($row['numero_factura']),
                    utf8_decode('$0.00'),
                    utf8_decode($this->Generales_model->dateToString($row['fecha_erogacion'])),
                    utf8_decode($row['file_factura_pdf']),
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

    function guardar_bitacora($accion)
    {
        $data = array(
            'id_bitacora' => '0',
            'usuario_bitacora' => $this->session->userdata('usuario_id'),
            'seccion_bitacora' => 'Campañas y Avisos Institucionales',
            'accion_bitacora' => $accion,
            'fecha_bitacora' => date("Y-m-d H:i:s")
        );

        $this->db->insert('bitacora', $data);
        
        if($this->db->affected_rows() > 0)
        {
            return 1; 
        }
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

    function dame_edades_campana()
    {
        $this->db->where('id_campana_aviso', '1');
        $query = $this->db->get('rel_campana_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_camp_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_edades[$cont]['id_rel_campana_grupo_edad'] = $row['id_rel_campana_grupo_edad'];
                $array_camp_edades[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_camp_edades[$cont]['nombre_grupo_edad'] = $this->dame_nombre_grupo_edad($row['id_poblacion_grupo_edad']);
                $array_camp_edades[$cont]['id_poblacion_grupo_edad'] = $row['id_poblacion_grupo_edad'];
                $cont++;
            }
            return $array_camp_edades;
        }  
    }

    function dame_todas_edades_campana()
    {
        $this->db->where('active', '1');
        $this->db->order_by("nombre_poblacion_grupo_edad", "ASC");
        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_cat_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_cat_edades[$cont]['id_poblacion_grupo_edad'] = $row['id_poblacion_grupo_edad'];
                $array_cat_edades[$cont]['nombre_poblacion_grupo_edad'] = $row['nombre_poblacion_grupo_edad'];
                $array_cat_edades[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_cat_edades;
        }  
    }

    function dame_edades_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_edades_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_edades_camp[$cont]['id_rel_campana_grupo_edad'] = $row['id_rel_campana_grupo_edad'];
                    $array_edades_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                    $array_edades_camp[$cont]['id_poblacion_grupo_edad'] = $row['id_poblacion_grupo_edad'];
                    $array_edades_camp[$cont]['nombre_grupo_edad'] = $this->dame_nombre_grupo_edad($row['id_poblacion_grupo_edad']);
                    $cont++;
            }
            return $array_edades_camp;
        }
    }

    function dame_grupos_dif_campana()
    {
        $id_campana_aviso = '2961';
        //Omitir los grupos de edades con los que la campana ya cuenta
        $this->db->where('id_poblacion_grupo_edad !=', '5');
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_edades_camp = '';

            foreach ($query->result_array() as $row) 
            {
                $array_edades_camp .= $row['id_poblacion_grupo_edad'].'|';
            }

            $edades_usadas = explode ('|', $array_edades_camp);
            
            //Obtenemos el resto de los grupos
            $this->db->where('active', '1');
            $query = $this->db->get('cat_poblacion_grupo_edad');

            $array_usuarios = [];
            $cont = 0;

            if($query->num_rows() > 0)
            {
                foreach ($query->result_array() as $row) 
                {
                    if (in_array($row['id_poblacion_grupo_edad'], $edades_usadas)) {
                    }
                    else
                    {
                        $array_usuarios[$cont]['id_poblacion_grupo_edad'] = $row['id_poblacion_grupo_edad'];
                        $array_usuarios[$cont]['nombre_poblacion_grupo_edad'] = $row['nombre_poblacion_grupo_edad'];
                        $cont++;
                    }
                }
                return $array_usuarios;
            }
        }
    }

    function dame_lugares_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_lugar');
        
        if($query->num_rows() > 0)
        {
            $array_lugares_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_lugares_camp[$cont]['id_campana_lugar'] = $row['id_campana_lugar'];
                    $array_lugares_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                    $array_lugares_camp[$cont]['poblacion_lugar'] = $row['poblacion_lugar'];
                    $cont++;
            }
            return $array_lugares_camp;
        }
    }

    function dame_niveles_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel');
        
        if($query->num_rows() > 0)
        {
            $array_niveles_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_niveles_camp[$cont]['id_rel_campana_nivel'] = $row['id_rel_campana_nivel'];
                    $array_niveles_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                    $array_niveles_camp[$cont]['id_poblacion_nivel'] = $row['id_poblacion_nivel'];
                    $array_niveles_camp[$cont]['nombre_poblacion_nivel'] = $this->dame_nombre_nivel($row['id_poblacion_nivel']);
                    $cont++;
            }
            return $array_niveles_camp;
        }
    }

    function dame_niveles_educativos_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel_educativo');
        
        if($query->num_rows() > 0)
        {
            $array_niveles_educativos_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_niveles_educativos_camp[$cont]['id_rel_campana_nivel_educativo'] = $row['id_rel_campana_nivel_educativo'];
                    $array_niveles_educativos_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                    $array_niveles_educativos_camp[$cont]['id_poblacion_nivel_educativo'] = $row['id_poblacion_nivel_educativo'];
                    $array_niveles_educativos_camp[$cont]['nombre_nivel_educativo'] = $this->dame_nombre_nivel_educativo($row['id_poblacion_nivel_educativo']);
                    $cont++;
            }
            return $array_niveles_educativos_camp;
        }
    }

    function dame_sexos_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_sexo');
        
        if($query->num_rows() > 0)
        {
            $array_sexos_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_sexos_camp[$cont]['id_rel_campana_sexo'] = $row['id_rel_campana_sexo'];
                $array_sexos_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_sexos_camp[$cont]['id_poblacion_sexo'] = $row['id_poblacion_sexo'];
                $array_sexos_camp[$cont]['nombre_sexo'] = $this->dame_nombre_sexo($row['id_poblacion_sexo']);
                $cont++;
            }
            return $array_sexos_camp;
        }
    }

    function dame_audios_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_maudio');
        
        if($query->num_rows() > 0)
        {
            $array_sexos_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_sexos_camp[$cont]['id_campana_maudio'] = $row['id_campana_maudio'];
                $array_sexos_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_sexos_camp[$cont]['id_tipo_liga'] = $row['id_tipo_liga'];
                $array_sexos_camp[$cont]['nombre_tipo_liga'] = $this->dame_nombre_liga($row['id_tipo_liga']);
                $array_sexos_camp[$cont]['nombre_campana_maudio'] = $row['nombre_campana_maudio'];
                $array_sexos_camp[$cont]['url_audio'] = $row['url_audio'];
                $array_sexos_camp[$cont]['file_audio'] = $row['file_audio'];
                $array_sexos_camp[$cont]['name_file_programa_anual'] = $row['url_audio'];
                $cont++;
            }
            return $array_sexos_camp;
        }
    }

    function dame_imagenes_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_mimagenes');
        
        if($query->num_rows() > 0)
        {
            $array_imagenes_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_imagenes_camp[$cont]['id_campana_mimagen'] = $row['id_campana_mimagen'];
                $array_imagenes_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_imagenes_camp[$cont]['id_tipo_liga'] = $row['id_tipo_liga'];
                $array_imagenes_camp[$cont]['nombre_tipo_liga'] = $this->dame_nombre_liga($row['id_tipo_liga']);
                $array_imagenes_camp[$cont]['nombre_campana_mimagen'] = $row['nombre_campana_mimagen'];
                $array_imagenes_camp[$cont]['url_imagen'] = $row['url_imagen'];
                $array_imagenes_camp[$cont]['file_imagen'] = $row['file_imagen'];
                $cont++;
            }
            return $array_imagenes_camp;
        }
    }

    function dame_videos_campana_id($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_mvideo');
        
        if($query->num_rows() > 0)
        {
            $array_videos_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_videos_camp[$cont]['id_campana_mvideo'] = $row['id_campana_mvideo'];
                $array_videos_camp[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_videos_camp[$cont]['id_tipo_liga'] = $row['id_tipo_liga'];
                $array_videos_camp[$cont]['nombre_tipo_liga'] = $this->dame_nombre_liga($row['id_tipo_liga']);
                $array_videos_camp[$cont]['nombre_campana_mvideo'] = $row['nombre_campana_mvideo'];
                $array_videos_camp[$cont]['url_video'] = $row['url_video'];
                $array_videos_camp[$cont]['file_video'] = $row['file_video'];
                $cont++;
            }
            return $array_videos_camp;
        }
    }

    function dame_tema_nombre($id)
    {
        $this->db->select('nombre_campana_tema');
        $this->db->where('id_campana_tema', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_temas');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_campana_tema'];
        }else
        {
            return '';
        }
    }

    function dame_cobertura_nombre($id)
    {
        $this->db->select('nombre_campana_cobertura');
        $this->db->where('id_campana_cobertura', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_coberturas');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_campana_cobertura'];
        }else
        {
            return '';
        }
    }

	function dame_tipoTO_nombre($id)
    {
        $this->db->select('nombre_campana_tipoTO');
        $this->db->where('id_campana_tipoTO', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_tiposTO');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_campana_tipoTO'];
        }else
        {
            return '';
        }
    }
	
	function dame_medioComunicacion_nombre($id)
    {
        $this->db->select('nombre_servicio_categoria');
        $this->db->where('id_servicio_categoria', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_servicios_categorias');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_servicio_categoria'];
        }else
        {
            return '';
        }
    }
	
	function dame_docs_nombre($id)
    {
        $this->db->select('denominacion');
        $this->db->where('id_presupuesto', $id);
        $query = $this->db->get('vtab_presupuesto_PACS');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['denominacion'];
        }else
        {
            return '';
        }
    }
	
    function dame_tiempo_oficial_nombre($id)
    {
        if ($id == 1)
        {
            return 'Sí';
        }else
        {
            return 'No';
        }
    }

    function dame_nombre_grupo_edad($id_poblacion)
    {
        $this->db->where('id_poblacion_grupo_edad', $id_poblacion);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }

            return $row['nombre_poblacion_grupo_edad'];
        }
    }

    function dame_nombre_nivel($id_nivel)
    {
        $this->db->where('id_poblacion_nivel', $id_nivel);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_nivel');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }

            return $row['nombre_poblacion_nivel'];
        }
    }

    function dame_nombre_nivel_educativo($id_nivel_educativo)
    {
        $this->db->where('id_poblacion_nivel_educativo', $id_nivel_educativo);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }

            return $row['nombre_poblacion_nivel_educativo'];
        }
    }

    function dame_nombre_sexo($id_sexo)
    {
        $this->db->where('id_poblacion_sexo', $id_sexo);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_sexo');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }

            return $row['nombre_poblacion_sexo'];
        }
    }

    function dame_nombre_liga($id_tipo_liga)
    {
        $this->db->where('id_tipo_liga', $id_tipo_liga);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_tipo_liga');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }
            return $row['tipo_liga'];
        }
    }

    function dame_nombre_campana($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('tab_campana_aviso');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
                
            }
            return $row['nombre_campana_aviso'];
        }
    }

    function dame_todos_niveles()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_nivel');
        
        if($query->num_rows() > 0)
        {
            $array_camp_nivel = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_nivel[$cont]['id_poblacion_nivel'] = $row['id_poblacion_nivel'];
                $array_camp_nivel[$cont]['nombre_poblacion_nivel'] = $row['nombre_poblacion_nivel'];
                $array_camp_nivel[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_camp_nivel;
        }  
    }

    function dame_todos_niveles_educativos()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        
        if($query->num_rows() > 0)
        {
            $array_camp_nivel_educativo = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_nivel_educativo[$cont]['id_poblacion_nivel_educativo'] = $row['id_poblacion_nivel_educativo'];
                $array_camp_nivel_educativo[$cont]['nombre_poblacion_nivel_educativo'] = $row['nombre_poblacion_nivel_educativo'];
                $array_camp_nivel_educativo[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_camp_nivel_educativo;
        }  
    }

    function dame_todos_sexos()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_poblacion_sexo');
        
        if($query->num_rows() > 0)
        {
            $array_camp_sexo = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_sexo[$cont]['id_poblacion_sexo'] = $row['id_poblacion_sexo'];
                $array_camp_sexo[$cont]['nombre_poblacion_sexo'] = $row['nombre_poblacion_sexo'];
                $array_camp_sexo[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_camp_sexo;
        }  
    }

    function dame_todos_tipos_ligas()
    {
        $this->db->where('active', '1');
        $this->db->order_by('tipo_liga', 'ASC');
        $query = $this->db->get('cat_tipo_liga');
        
        if($query->num_rows() > 0)
        {
            $array_camp_sexo = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_sexo[$cont]['id_tipo_liga'] = $row['id_tipo_liga'];
                $array_camp_sexo[$cont]['tipo_liga'] = $row['tipo_liga'];
                $array_camp_sexo[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_camp_sexo;
        }  
    }

    function dame_nombres_tipos_ligas()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_tipo_liga');
        
        if($query->num_rows() > 0)
        {
            $array_tipo_liga = [];
            
            foreach ($query->result_array() as $row) 
            {
                $array_tipo_liga[] = $row['id_tipo_liga'];
            }
            return $array_tipo_liga;
        }  
    }

    function dame_todas_campanas_avisos()
    {
        $estatus = array('1', '2','3','4');
        $this->db->where_in('active', $estatus);
        //$this->db->limit('100');
        $this->db->order_by('id_campana_aviso', 'desc');
        $query = $this->db->get('tab_campana_aviso');
        
        if($query->num_rows() > 0)
        {
            $array_camp_avisos = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_avisos[$cont]['conteo'] = $cont+1;
                $array_camp_avisos[$cont]['id_campana_aviso'] = $row['id_campana_aviso'];
                $array_camp_avisos[$cont]['id_campana_cobertura'] = $row['id_campana_cobertura'];
                $array_camp_avisos[$cont]['id_campana_tipo'] = $row['id_campana_tipo'];
                $array_camp_avisos[$cont]['nombre_campana_tipo'] = $this->dame_camp_tipo_nombre($row['id_campana_tipo']);
                $array_camp_avisos[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                $array_camp_avisos[$cont]['nombre_campana_subtipo'] = $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']);
                $array_camp_avisos[$cont]['id_campana_tema'] = $row['id_campana_tema'];
                $array_camp_avisos[$cont]['id_campana_objetivo'] = $row['id_campana_objetivo'];
                $array_camp_avisos[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                $array_camp_avisos[$cont]['nombre_ejercicio'] = $this->dame_ejercicio_nombre($row['id_ejercicio']);
                $array_camp_avisos[$cont]['id_trimestre'] = $row['id_trimestre'];
                $array_camp_avisos[$cont]['nombre_trimestre'] = $this->dame_trimestre_nombre($row['id_trimestre']);
                $array_camp_avisos[$cont]['fecha_inicio_periodo'] = $row['fecha_inicio_periodo'];
                $array_camp_avisos[$cont]['fecha_termino_periodo'] = $row['fecha_termino_periodo'];
                $array_camp_avisos[$cont]['id_so_contratante'] = $row['id_so_contratante'];
                //$array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_soc_nombre($row['id_so_contratante']);
                $array_camp_avisos[$cont]['nombre_so_contratante'] = $this->dame_nombre_contratante($row['id_so_contratante']);
                $array_camp_avisos[$cont]['id_so_solicitante'] = $row['id_so_solicitante'];
                //$array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_sos_nombre($row['id_so_solicitante']);
                $array_camp_avisos[$cont]['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                $array_camp_avisos[$cont]['id_tiempo_oficial'] = $row['id_tiempo_oficial'];
                $array_camp_avisos[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $array_camp_avisos[$cont]['objetivo_comunicacion'] = $row['objetivo_comunicacion'];
                $array_camp_avisos[$cont]['id_campana_tipoTO'] = $row['id_campana_tipoTO'];
				$array_camp_avisos[$cont]['id_presupuesto'] = $row['id_presupuesto'];
				$array_camp_avisos[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                $array_camp_avisos[$cont]['monto_tiempo'] = $row['monto_tiempo'];
                $array_camp_avisos[$cont]['hora_to'] = $row['hora_to'];
                $array_camp_avisos[$cont]['minutos_to'] = $row['minutos_to'];
                $array_camp_avisos[$cont]['segundos_to'] = $row['segundos_to'];
                $array_camp_avisos[$cont]['mensajeTO'] = $row['mensajeTO'];
                $array_camp_avisos[$cont]['descripcion_unidad'] = $row['descripcion_unidad'];
                $array_camp_avisos[$cont]['responsable_publisher'] = $row['responsable_publisher'];
                $array_camp_avisos[$cont]['name_comercial'] = $row['name_comercial'];
                $array_camp_avisos[$cont]['razones_supplier'] = $row['razones_supplier'];
                $array_camp_avisos[$cont]['difusion_mensaje'] = $row['difusion_mensaje'];
                $array_camp_avisos[$cont]['num_factura'] = $row['num_factura'];
                $array_camp_avisos[$cont]['fecha_inicio'] = $row['fecha_inicio'];
                $array_camp_avisos[$cont]['fecha_termino'] = $row['fecha_termino'];
                $array_camp_avisos[$cont]['fecha_inicio_to'] = $row['fecha_inicio_to'];
                $array_camp_avisos[$cont]['fecha_termino_to'] = $row['fecha_termino_to'];
                $array_camp_avisos[$cont]['publicacion_segob'] = $row['publicacion_segob'];
                $array_camp_avisos[$cont]['campana_ambito_geo'] = $row['campana_ambito_geo'];
                $array_camp_avisos[$cont]['plan_acs'] = $row['plan_acs'];
                $array_camp_avisos[$cont]['fecha_dof'] = $row['fecha_dof'];
                $array_camp_avisos[$cont]['evaluacion'] = $row['evaluacion'];
                $array_camp_avisos[$cont]['evaluacion_documento'] = $row['evaluacion_documento'];
                $array_camp_avisos[$cont]['fecha_validacion'] = $row['fecha_validacion'];
                $array_camp_avisos[$cont]['area_responsable'] = $row['area_responsable'];
                $array_camp_avisos[$cont]['periodo'] = $row['periodo'];
                $array_camp_avisos[$cont]['fecha_actualizacion'] = $row['fecha_actualizacion'];
                $array_camp_avisos[$cont]['nota'] = $row['nota'];
                $array_camp_avisos[$cont]['autoridad'] = $row['autoridad'];
                $array_camp_avisos[$cont]['clave_campana'] = $row['clave_campana'];
                $array_camp_avisos[$cont]['active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_camp_avisos;
        }
    }

    function dame_camp_tipo_nombre($id_tipo)
    {
        $this->db->where('id_campana_tipo', $id_tipo);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_tipos');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
            }

            return $row['nombre_campana_tipo'];
        }
    }

    function dame_camp_subtipo_nombre($id_subtipo)
    {
        $this->db->where('id_campana_subtipo', $id_subtipo);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_subtipos');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
            }
            
            return $row['nombre_campana_subtipo'];
        }
    }

    function dame_ejercicio_nombre($id_ejercicio)
    {
        $this->db->where('id_ejercicio', $id_ejercicio);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_ejercicios');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
            }
            
            return $row['ejercicio'];
        }
    }
    
    function dame_trimestre_nombre($id_trimestre)
    {
        $this->db->where('id_trimestre', $id_trimestre);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_trimestres');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row){
            }
            
            return $row['trimestre'];
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
	
    function descarga_campanas_avisos()
    {
        $filename = 'dist/csv/campanasyavisos.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $estatus = array('1', '2','3','4');
        $this->db->where_in('active', $estatus);
        $query = $this->db->get('tab_campana_aviso');

        $csv_header = array('#',
                    utf8_decode('Tipo'),
                    utf8_decode('Subtipo'),
                    utf8_decode('Nombre'),
                    utf8_decode('Clave de campaña o aviso institucional'),
                    utf8_decode('Autoridad que proporcionó la clave'),
                    utf8_decode('Ejercicio'),
                    utf8_decode('Trimestre'),
                    utf8_decode('Fecha de inicio del periodo que se informa'),
                    utf8_decode('Fecha de término del periodo que se informa'),
                    utf8_decode('Sujeto Obligado Solicitante'),
                    utf8_decode('Sujeto Obligado Contratante'),
                    utf8_decode('Tema'),
                    utf8_decode('Objetivo institucional'),
                    utf8_decode('Objetivo de comunicación'),
                    utf8_decode('Cobertura'),
                    utf8_decode('Ámbito geográfico'),
                    utf8_decode('Fecha de inicio'),
                    utf8_decode('Fecha de término'),
                    utf8_decode('Tiempo oficial'),
                    utf8_decode('Monto total del tiempo de estado o tiempo fiscal consumidos'),
                    utf8_decode('Tipo de tiempo oficial'),
                    utf8_decode('Mensaje sobre el tiempo oficial'),
                    utf8_decode('Fecha inicio tiempo oficial'),
                    utf8_decode('Fecha término tiempo oficial'),
                    utf8_decode('Medio de comunicación'),
                    utf8_decode('Descripción de unidad, por ejemplo: spot de 30 segundos (radio); mensaje en TV 20 segundos'),
                    utf8_decode('Concesionario responsable de publicar la campaña o la comunicación correspondiente (razón social)'),
                    utf8_decode('Distintivo y/o nombre comercial del concesionario responsable de publicar la campaña o comunicación'),
                    utf8_decode('Descripción breve de las razones que justifican la elección del proveedor'),
                    utf8_decode('Área administrativa encargada de solicitar la difusión del mensaje o producto, en su caso'),
                    utf8_decode('Número de factura, en su caso'),
                    utf8_decode('Publicación SEGOB.'),
                    utf8_decode('Documento del PACS'),
                    utf8_decode('Fecha publicación'),
                    utf8_decode('Evaluación'),
                    utf8_decode('Documento de evaluación'),
                    utf8_decode('Fecha de validación'),
                    utf8_decode('Año'),
                    utf8_decode('Fecha de actualización'),
                    utf8_decode('Nota'),
                    utf8_decode('Estatus')
                        );       
        fputcsv($myfile, $csv_header);

        $csv = [];
        
        if($query->num_rows() > 0)
        {
            $cont = 1;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_avisos[$cont]['conteo'] = $cont+1;

                $csv = array(
                    utf8_decode($cont),
                    utf8_decode($this->dame_camp_tipo_nombre($row['id_campana_tipo'])),
                    utf8_decode($this->dame_camp_subtipo_nombre($row['id_campana_subtipo'])),
                    utf8_decode($row['nombre_campana_aviso']),
                    utf8_decode($row['clave_campana']),
                    utf8_decode($row['autoridad']),
                    utf8_decode($this->dame_ejercicio_nombre($row['id_ejercicio'])),
                    utf8_decode($this->dame_trimestre_nombre($row['id_trimestre'])),
                    utf8_decode($row['fecha_inicio_periodo']),
                    utf8_decode($row['fecha_termino_periodo']),
                    utf8_decode($this->dame_nombre_solicitante($row['id_so_solicitante'])),
                    utf8_decode($this->dame_nombre_contratante($row['id_so_contratante'])),
                    utf8_decode($this->dame_tema_nombre($row['id_campana_tema'])),
                    utf8_decode($this->dame_objetivo_nombre($row['id_campana_objetivo'])),
                    utf8_decode($row['objetivo_comunicacion']),
                    utf8_decode($this->dame_cobertura_nombre($row['id_campana_cobertura'])),
                    utf8_decode($row['campana_ambito_geo']),
                    utf8_decode($row['fecha_inicio']),
                    utf8_decode($row['fecha_termino']),
                    utf8_decode($this->dame_tiempo_oficial_nombre($row['id_tiempo_oficial'])),
                    utf8_decode($row['monto_tiempo']),
                    utf8_decode($this->dame_tipoTO_nombre($row['id_campana_tipoTO'])),
                    utf8_decode($row['mensajeTO']),
                    utf8_decode($row['fecha_inicio_to']),
                    utf8_decode($row['fecha_termino_to']),
                    utf8_decode($this->dame_medioComunicacion_nombre($row['id_servicio_categoria'])),
                    utf8_decode($row['descripcion_unidad']),
                    utf8_decode($row['responsable_publisher']),
                    utf8_decode($row['name_comercial']),
                    utf8_decode($row['razones_supplier']),
                    utf8_decode($row['difusion_mensaje']),
                    utf8_decode($row['num_factura']),
                    utf8_decode($row['publicacion_segob']),
                    utf8_decode($row['plan_acs']),
                    utf8_decode($row['fecha_dof']),
                    utf8_decode($row['evaluacion']),
                    utf8_decode($row['evaluacion_documento']),
                    utf8_decode($row['fecha_validacion']),
                    utf8_decode($row['periodo'] == '0' ? '' : $row['periodo']),
                    utf8_decode($row['fecha_actualizacion']),
                    utf8_decode($row['nota']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
                $cont += 1;
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_edad_rel_id($id_rel)
    {
        $this->db->where('id_rel_campana_grupo_edad', $id_rel);
        $query = $this->db->get('rel_campana_grupo_edad');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $grupo_edad = $row['id_poblacion_grupo_edad'];
            }

            return $grupo_edad;
        }
    }

    function dame_nivel_rel_id($id_rel)
    {
        $this->db->where('id_rel_campana_nivel', $id_rel);
        $query = $this->db->get('rel_campana_nivel');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $grupo_nivel = $row['id_poblacion_nivel'];
            }

            return $grupo_nivel;
        }
    }

    function dame_nivel_educativo_rel_id($id_rel)
    {
        $this->db->where('id_rel_campana_nivel_educativo', $id_rel);
        $query = $this->db->get('rel_campana_nivel_educativo');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $grupo_nivel = $row['id_poblacion_nivel_educativo'];
            }

            return $grupo_nivel;
        }
    }

    function dame_sexo_rel_id($id_rel)
    {
        $this->db->where('id_rel_campana_sexo', $id_rel);
        $query = $this->db->get('rel_campana_sexo');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $grupo_sexo = $row['id_poblacion_sexo'];
            }

            return $grupo_sexo;
        }
    }

    function dame_tipo_liga_video_rel_id($id_rel)
    {
        $this->db->where('id_campana_mvideo', $id_rel);
        $query = $this->db->get('rel_campana_mvideo');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $grupo_edad = $row['id_tipo_liga'];
            }

            return $grupo_edad;
        }
    }
 
    function tipo_liga_audio_rel_id($id_rel)
    {
        $this->db->where('id_campana_maudio', $id_rel);
        $query = $this->db->get('rel_campana_maudio');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $tipo_liga_audio = $row['id_tipo_liga'];
            }

            return $tipo_liga_audio;
        }
    }

    function tipo_liga_imagen_rel_id($id_rel)
    {
        $this->db->where('id_campana_mimagen', $id_rel);
        $query = $this->db->get('rel_campana_mimagenes');
                
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) {
                $tipo_liga_audio = $row['id_tipo_liga'];
            }

            return $tipo_liga_audio;
        }
    }

    function campana_id_alta_edades($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_edades_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_edades_camp[$cont] = $row['id_poblacion_grupo_edad'];
                $cont++;
            }
            return $array_edades_camp;
        }
        else
        {
            return 0;
        }
    }

    function campana_id_alta_niveles($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel');
        
        if($query->num_rows() > 0)
        {
            $array_niveles_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_niveles_camp[$cont] = $row['id_poblacion_nivel'];
                $cont++;
            }
            return $array_niveles_camp;
        }
        else
        {
            return 0;
        }
    }

    function campana_id_alta_educacion($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel_educativo');
        
        if($query->num_rows() > 0)
        {
            $array_educacion_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_educacion_camp[$cont] = $row['id_poblacion_nivel_educativo'];
                $cont++;
            }
            return $array_educacion_camp;
        }
        else
        {
            return 0;
        }
    }

    function campana_id_alta_sexo($id_campana_aviso)
    {
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_sexo');
        
        if($query->num_rows() > 0)
        {
            $array_educacion_camp = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_educacion_camp[$cont] = $row['id_poblacion_sexo'];
                $cont++;
            }
            return $array_educacion_camp;
        }
        else
        {
            return 0;
        }
    }

    function campana_id_edades($id_rel, $id_campana_aviso)
    {
        $this->db->where('id_rel_campana_grupo_edad !=', $id_rel);
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_grupo_edad');
        
        $array_edades_camp = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_edades_camp[$cont] = $row['id_poblacion_grupo_edad'];
                $cont++;
            }
        }
        return $array_edades_camp;
    }

    function campana_id_niveles($id_rel, $id_campana_aviso)
    {
        $this->db->where('id_rel_campana_nivel !=', $id_rel);
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel');
        
        $array_niveles_camp = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_niveles_camp[$cont] = $row['id_poblacion_nivel'];
                $cont++;
            }
        }
        return $array_niveles_camp;
    }

    function campana_id_nivel_educativo($id_rel, $id_campana_aviso)
    {
        $this->db->where('id_rel_campana_nivel_educativo !=', $id_rel);
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_nivel_educativo');
        
        $array_niveles_camp = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_niveles_camp[$cont] = $row['id_poblacion_nivel_educativo'];
                $cont++;
            }
        }
        return $array_niveles_camp;
    }

    function campana_id_sexo($id_rel, $id_campana_aviso)
    {
        $this->db->where('id_rel_campana_sexo !=', $id_rel);
        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $query = $this->db->get('rel_campana_sexo');
        
        $array_sexos_camp = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_sexos_camp[$cont] = $row['id_poblacion_sexo'];
                $cont++;
            }
        }
        return $array_sexos_camp;
    }

    function dame_todas_edades_alta()
    {
        $this->db->where('active', '1');
        $this->db->order_by("nombre_poblacion_grupo_edad", "ASC");
        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        $array_edades = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_edades[] = $row['id_poblacion_grupo_edad'];
            }
        }
        return $array_edades;
    }

    function dame_todos_niveles_alta()
    {
        $this->db->where('active', '1');
        $this->db->order_by("nombre_poblacion_nivel", "ASC");
        $query = $this->db->get('cat_poblacion_nivel');
        
        $array_niveles_alta = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_niveles_alta[] = $row['id_poblacion_nivel'];
            }
            
        }
        return $array_niveles_alta;
    }

    function dame_todos_educacion_alta()
    {
        $this->db->where('active', '1');
        $this->db->order_by("nombre_poblacion_nivel_educativo", "ASC");
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        
        $array_niveles_alta = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_niveles_alta[] = $row['id_poblacion_nivel_educativo'];
            }
        }
        return $array_niveles_alta;
    }

    function dame_todos_sexo_alta()
    {
        $this->db->where('active', '1');
        $this->db->order_by("nombre_poblacion_sexo", "ASC");
        $query = $this->db->get('cat_poblacion_sexo');
        
        $array_sexo_alta = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_sexo_alta[] = $row['id_poblacion_sexo'];
            }
        }
        return $array_sexo_alta;
    }

    function dame_opciones_edad_alta($id_campana_aviso)
    {
        $sel_cat_edad = '';
        $edades_guardadas = $this->campana_id_alta_edades($id_campana_aviso);
        $todas_edades = $this->dame_todas_edades_alta($id_campana_aviso);

        if($edades_guardadas != 0)
        {
            $edades_disponibles = array_diff($todas_edades, $edades_guardadas);
        }
        else
        {
            $edades_disponibles = $todas_edades;
        }
        
        foreach ($edades_disponibles as $edad_disp) 
        {
            $detalle_edad = $this->dame_edad_id($edad_disp);
            $sel_cat_edad .= '<option value="'.$detalle_edad['id_poblacion_grupo_edad'].'">' . $detalle_edad['nombre_poblacion_grupo_edad'] . '</option>';
        }
        
        return $sel_cat_edad;
    }

    function dame_opciones_edad_edita($id_rel, $id_campana_aviso)
    {
        $sel_cat_edad = '';
        $edades_guardadas = $this->campana_id_edades($id_rel, $id_campana_aviso);
        $todas_edades = $this->dame_todas_edades_alta($id_campana_aviso);
        $edad_rel = $this->dame_edad_rel_id($id_rel);
        
        $edades_disponibles = array_diff($todas_edades, $edades_guardadas);
        
        foreach ($edades_disponibles as $edad_disp) 
        {
            $detalle_edad = $this->dame_edad_id($edad_disp);

            if($edad_rel == $edad_disp)
            {
                $sel_cat_edad .= '<option value="'.$detalle_edad['id_poblacion_grupo_edad'].'" selected>' . $detalle_edad['nombre_poblacion_grupo_edad'] . '</option>';
            }else
            {
                $sel_cat_edad .= '<option value="'.$detalle_edad['id_poblacion_grupo_edad'].'">' . $detalle_edad['nombre_poblacion_grupo_edad'] . '</option>';
            }
        }
        
        return $sel_cat_edad;
    }
    
    function dame_opciones_tipo_liga_video($id_rel)
    {
        $sel_tipo_liga = '';
        $todos_tipos_liga = $this->dame_nombres_tipos_ligas();
        $tipo_liga_rel = $this->dame_tipo_liga_video_rel_id($id_rel);

        foreach ($todos_tipos_liga as $tipo_liga) 
        {
            $detalle_tipo = $this->dame_liga_id($tipo_liga);

            if($tipo_liga_rel == $tipo_liga)
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'" selected>' . $detalle_tipo['tipo_liga'] . '</option>';
            }else
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'">' . $detalle_tipo['tipo_liga'] . '</option>';
            }
        }       
        return $sel_tipo_liga;
    }

    //OPCIONES VIDEO EDITA
    function tipo_liga_audio($id_rel)
    {
        $sel_tipo_liga = '';
        $todos_tipos_liga = $this->dame_nombres_tipos_ligas();
        $tipo_liga_rel = $this->tipo_liga_audio_rel_id($id_rel);

        foreach ($todos_tipos_liga as $tipo_liga) 
        {
            $detalle_tipo = $this->dame_liga_id($tipo_liga);

            if($tipo_liga_rel == $tipo_liga)
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'" selected>' . $detalle_tipo['tipo_liga'] . '</option>';
            }else
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'">' . $detalle_tipo['tipo_liga'] . '</option>';
            }
        }
        return $sel_tipo_liga;
    }

    //OPCIONES IMAGEN EDITA
    function tipo_liga_imagen($id_rel)
    {
        $sel_tipo_liga = '';
        $todos_tipos_liga = $this->dame_nombres_tipos_ligas();
        $tipo_liga_rel = $this->tipo_liga_imagen_rel_id($id_rel);

        foreach ($todos_tipos_liga as $tipo_liga) 
        {
            $detalle_tipo = $this->dame_liga_id($tipo_liga);

            if($tipo_liga_rel == $tipo_liga)
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'" selected>' . $detalle_tipo['tipo_liga'] . '</option>';
            }else
            {
                $sel_tipo_liga .= '<option value="'.$detalle_tipo['id_tipo_liga'].'">' . $detalle_tipo['tipo_liga'] . '</option>';
            }
        }

        return $sel_tipo_liga;
    }

    function dame_opciones_edad_edita2($id_rel, $id_campana_aviso)
    {
        $edades_guardadas = $this->campana_id_edades($id_rel, $id_campana_aviso);
        $edad_rel = $this->dame_edad_rel_id($id_rel);
        $sel_cat_edad = '';

        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                if($edades_guardadas != '')
                {
                    foreach ($edades_guardadas as $edad)
                    {
                        if($edad != $row['id_poblacion_grupo_edad'])
                        {
                            if($edad_rel == $row['id_poblacion_grupo_edad'])
                            {
                                $sel_cat_edad .= '<option value="'.$row['id_poblacion_grupo_edad'].'" selected>' . $row['nombre_poblacion_grupo_edad'] . '</option>';
                            }else
                            {
                                $sel_cat_edad .= '<option value="'.$row['id_poblacion_grupo_edad'].'">' . $row['nombre_poblacion_grupo_edad'] . '</option>';
                            }
                        }
                    }
                }
                else
                {
                    if($edad_rel == $row['id_poblacion_grupo_edad'])
                    {
                        $sel_cat_edad .= '<option value="'.$row['id_poblacion_grupo_edad'].'" selected>' . $row['nombre_poblacion_grupo_edad'] . '</option>';
                    }else
                    {
                        $sel_cat_edad .= '<option value="'.$row['id_poblacion_grupo_edad'].'">' . $row['nombre_poblacion_grupo_edad'] . '</option>';
                    }
                }
            }
            return $sel_cat_edad;
        }
    }

    function dame_opciones_nivel_alta($id_campana_aviso)
    {
        $sel_cat_nivel = '';
        $niveles_guardados = $this->campana_id_alta_niveles($id_campana_aviso);
        $todos_niveles = $this->dame_todos_niveles_alta($id_campana_aviso);
        
        if($niveles_guardados != 0)
        {
            $niveles_disponibles = array_diff($todos_niveles, $niveles_guardados);
        }
        else
        {
            $niveles_disponibles = $todos_niveles;
        }
        
        foreach ($niveles_disponibles as $nivel_disp) 
        {
            $detalle_nivel = $this->dame_nivel_id($nivel_disp);
            $sel_cat_nivel .= '<option value="'.$detalle_nivel['id_poblacion_nivel'].'">' . $detalle_nivel['nombre_poblacion_nivel'] . '</option>';
        }       
        return $sel_cat_nivel;
    }

    function dame_opciones_nivel_edita($id_rel, $id_campana_aviso)
    {
        $sel_cat_nivel = '';
        $niveles_guardados = $this->campana_id_niveles($id_rel, $id_campana_aviso);
        $todos_niveles = $this->dame_todos_niveles_alta($id_campana_aviso);
        $nivel_rel = $this->dame_nivel_rel_id($id_rel);
        
        $niveles_disponibles = array_diff($todos_niveles, $niveles_guardados);
        
        foreach ($niveles_disponibles as $nivel_disp) 
        {
            $detalle_nivel = $this->dame_nivel_id($nivel_disp);

            if($nivel_rel == $nivel_disp)
            {
                $sel_cat_nivel .= '<option value="'.$detalle_nivel['id_poblacion_nivel'].'" selected>' . $detalle_nivel['nombre_poblacion_nivel'] . '</option>';
            }else
            {
                $sel_cat_nivel .= '<option value="'.$detalle_nivel['id_poblacion_nivel'].'">' . $detalle_nivel['nombre_poblacion_nivel'] . '</option>';
            }
        }
        
        return $sel_cat_nivel;
    }

    function dame_opciones_educacion_alta($id_campana_aviso)
    {
        $sel_cat_educacion = '';
        $educacion_guardados = $this->campana_id_alta_educacion($id_campana_aviso);
        $todos_educacion = $this->dame_todos_educacion_alta($id_campana_aviso);
        
        if($educacion_guardados != 0)
        {
            $educacion_disponibles = array_diff($todos_educacion, $educacion_guardados);
        }
        else
        {
            $educacion_disponibles = $todos_educacion;
        }
        
        foreach ($educacion_disponibles as $educacion_disp) 
        {
            $detalle_educacion = $this->dame_educacion_id($educacion_disp);
            $sel_cat_educacion .= '<option value="'.$detalle_educacion['id_poblacion_nivel_educativo'].'">' . $detalle_educacion['nombre_poblacion_nivel_educativo'] . '</option>';
        }
        
        return $sel_cat_educacion;
    }

    function dame_opciones_educacion_edita($id_rel, $id_campana_aviso)
    {
        $sel_cat_educacion = '';
        $educacion_guardados = $this->campana_id_nivel_educativo($id_rel, $id_campana_aviso);
        $todos_educacion = $this->dame_todos_educacion_alta($id_campana_aviso);
        $educacion_rel = $this->dame_nivel_educativo_rel_id($id_rel);
        
        $educacion_disponibles = array_diff($todos_educacion, $educacion_guardados);
        
        foreach ($educacion_disponibles as $educacion_disp) 
        {
            $detalle_educacion = $this->dame_educacion_id($educacion_disp);

            if($educacion_rel == $educacion_disp)
            {
                $sel_cat_educacion .= '<option value="'.$detalle_educacion['id_poblacion_nivel_educativo'].'" selected>' . $detalle_educacion['nombre_poblacion_nivel_educativo'] . '</option>';
            }else
            {
                $sel_cat_educacion .= '<option value="'.$detalle_educacion['id_poblacion_nivel_educativo'].'">' . $detalle_educacion['nombre_poblacion_nivel_educativo'] . '</option>';
            }
        }
        
        return $sel_cat_educacion;
    }
      
    function dame_opciones_sexo_alta($id_campana_aviso)
    {
        $sel_cat_sexo = '';
        $sexos_guardados = $this->campana_id_alta_sexo($id_campana_aviso);
        $todos_sexos = $this->dame_todos_sexo_alta($id_campana_aviso);

        if($sexos_guardados != 0)
        {
            $sexo_disponibles = array_diff($todos_sexos, $sexos_guardados);
        }
        else
        {
            $sexo_disponibles = $todos_sexos;
        }

        foreach ($sexo_disponibles as $sexo_disp) 
        {
            $detalle_sexo = $this->dame_sexo_id($sexo_disp);
            $sel_cat_sexo .= '<option value="'.$detalle_sexo['id_poblacion_sexo'].'">' . $detalle_sexo['nombre_poblacion_sexo'] . '</option>';
        }
        
        return $sel_cat_sexo;
    }
    
    function dame_opciones_sexo_edita($id_rel, $id_campana_aviso)
    {
        $sel_cat_sexo = '';
        $sexos_guardados = $this->campana_id_sexo($id_rel, $id_campana_aviso);
        $todos_sexos = $this->dame_todos_sexo_alta($id_campana_aviso);
        $sexo_rel = $this->dame_sexo_rel_id($id_rel);
        
        $sexo_disponibles = array_diff($todos_sexos, $sexos_guardados);
        
        foreach ($sexo_disponibles as $sexo_disp) 
        {
            $detalle_sexo = $this->dame_sexo_id($sexo_disp);

            if($sexo_rel == $sexo_disp)
            {
                $sel_cat_sexo .= '<option value="'.$detalle_sexo['id_poblacion_sexo'].'" selected>' . $detalle_sexo['nombre_poblacion_sexo'] . '</option>';
            }else
            {
                $sel_cat_sexo .= '<option value="'.$detalle_sexo['id_poblacion_sexo'].'">' . $detalle_sexo['nombre_poblacion_sexo'] . '</option>';
            }
        }       
        return $sel_cat_sexo;
    }

    function dame_campana_id($id_campana)
    {
        $this->load->model('tpoadminv1/Generales_model');

        $estatus = array('1', '2','3','4');
        $this->db->where_in('active', $estatus);
        $this->db->where('id_campana_aviso', $id_campana);
        $query = $this->db->get('tab_campana_aviso');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $camp_aviso['id_campana_aviso'] = $row['id_campana_aviso'];
                $camp_aviso['id_campana_cobertura'] = $row['id_campana_cobertura'];
                $camp_aviso['nombre_cobertura'] = $this->dame_cobertura_nombre($row['id_campana_cobertura']);
                $camp_aviso['id_campana_tipo'] = $row['id_campana_tipo'];
                $camp_aviso['nombre_campana_tipo'] = $this->dame_camp_tipo_nombre($row['id_campana_tipo']);
                $camp_aviso['id_campana_subtipo'] = $row['id_campana_subtipo'];
                $camp_aviso['nombre_campana_subtipo'] = $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']);
                $camp_aviso['id_campana_tema'] = $row['id_campana_tema'];
                $camp_aviso['nombre_tema'] = $this->dame_tema_nombre($row['id_campana_tema']);
                $camp_aviso['id_campana_objetivo'] = $row['id_campana_objetivo'];
                $camp_aviso['objetivo_institucional'] = $this->dame_objetivo_nombre($row['id_campana_objetivo']);
                $camp_aviso['id_ejercicio'] = $row['id_ejercicio'];
                $camp_aviso['nombre_ejercicio'] = $this->dame_ejercicio_nombre($row['id_ejercicio']);
                $camp_aviso['id_trimestre'] = $row['id_trimestre'];
                $camp_aviso['nombre_trimestre'] = $this->dame_trimestre_nombre($row['id_trimestre']);
                $camp_aviso['fecha_inicio_periodo'] = $this->Generales_model->dateToString($row['fecha_inicio_periodo']);
                $camp_aviso['fecha_termino_periodo'] = $this->Generales_model->dateToString($row['fecha_termino_periodo']);
                $camp_aviso['id_so_solicitante'] = $row['id_so_solicitante'];
                $camp_aviso['nombre_so_solicitante'] = $this->dame_nombre_solicitante($row['id_so_solicitante']);
                $camp_aviso['id_so_contratante'] = $row['id_so_contratante'];
                $camp_aviso['nombre_so_contratante'] = $this->dame_nombre_contratante($row['id_so_contratante']);
                $camp_aviso['id_tiempo_oficial'] = $row['id_tiempo_oficial'];
                $camp_aviso['nombre_tiempo_oficial'] = $this->dame_tiempo_oficial_nombre($row['id_tiempo_oficial']);
                $camp_aviso['id_campana_tipoTO'] = $row['id_campana_tipoTO'];
                $camp_aviso['nombre_tipoTO'] = $this->dame_tipoTO_nombre($row['id_campana_tipoTO']);
				$camp_aviso['denominacion'] = $this->dame_docs_nombre($row['id_presupuesto']);
				$camp_aviso['id_presupuesto'] = $row['id_presupuesto'];
				$camp_aviso['nombre_servicioCat'] = $this->dame_medioComunicacion_nombre($row['id_servicio_categoria']);
				$camp_aviso['id_servicio_categoria'] = $row['id_servicio_categoria'];
                $camp_aviso['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $camp_aviso['objetivo_comunicacion'] = $row['objetivo_comunicacion'];
                $camp_aviso['monto_tiempo'] = $row['monto_tiempo'];
                $camp_aviso['hora_to'] = $row['hora_to'];
                $camp_aviso['minutos_to'] = $row['minutos_to'];
                $camp_aviso['segundos_to'] = $row['segundos_to'];
                $camp_aviso['mensajeTO'] = $row['mensajeTO'];
                $camp_aviso['descripcion_unidad'] = $row['descripcion_unidad'];
                $camp_aviso['responsable_publisher'] = $row['responsable_publisher'];
                $camp_aviso['name_comercial'] = $row['name_comercial'];
                $camp_aviso['razones_supplier'] = $row['razones_supplier'];
                $camp_aviso['difusion_mensaje'] = $row['difusion_mensaje'];
                $camp_aviso['num_factura'] = $row['num_factura'];
                $camp_aviso['fecha_inicio'] = $this->Generales_model->dateToString($row['fecha_inicio']);
                $camp_aviso['fecha_termino'] = $this->Generales_model->dateToString($row['fecha_termino']);
                $camp_aviso['fecha_inicio_to'] = $this->Generales_model->dateToString($row['fecha_inicio_to']);
                $camp_aviso['fecha_termino_to'] = $this->Generales_model->dateToString($row['fecha_termino_to']);
                $camp_aviso['publicacion_segob'] = $row['publicacion_segob'];
                $camp_aviso['campana_ambito_geo'] = $row['campana_ambito_geo'];
                $camp_aviso['plan_acs'] = $row['plan_acs'];
                $camp_aviso['fecha_dof'] = $row['fecha_dof'];
                $camp_aviso['evaluacion'] = $row['evaluacion'];
                $camp_aviso['evaluacion_documento'] = $row['evaluacion_documento'];
                $camp_aviso['path_file_evaluacion'] = $this->ruta_descarga_archivos($row['evaluacion_documento'],  'data/campanas/evaluacion/');
                $camp_aviso['fecha_validacion'] = $this->Generales_model->dateToString($row['fecha_validacion']);
                $camp_aviso['fecha_dof'] = $this->Generales_model->dateToString($row['fecha_dof']);
                $camp_aviso['area_responsable'] = $row['area_responsable'];
                $camp_aviso['periodo'] = $row['periodo'];
                $camp_aviso['fecha_actualizacion'] = $this->Generales_model->dateToString($row['fecha_actualizacion']);
                $camp_aviso['nota'] = $row['nota'];
                $camp_aviso['autoridad'] = $row['autoridad'];
                $camp_aviso['clave_campana'] = $row['clave_campana'];
                $camp_aviso['active'] = $row['active'];
                $camp_aviso['active_nombre'] = $this->get_estatus_name($row['active']);
            }
            return $camp_aviso;
        }
    }

    function dame_campana_nombre($id_campana)
    {
        $estatus = array('1', '2','3','4');
        $this->db->where_in('active', $estatus);
        $this->db->where('id_campana_aviso', $id_campana);
        $query = $this->db->get('tab_campana_aviso');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $nombre_campana = $row['nombre_campana_aviso'];
                
            }
            return $nombre_campana;
        }
    }

    function dame_eliminar_campana_id($id)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->db->where('id_campana_aviso', $id);
        
        $query = $this->db->get('tab_campana_aviso');
        
        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                $register = array(
                    'id_campana_aviso' => $row['id_campana_aviso'],
                    'id_campana_cobertura' => $row['id_campana_cobertura'],
                    'nombre_cobertura' => $this->dame_cobertura_nombre($row['id_campana_cobertura']),
                    'id_campana_tipo' => $row['id_campana_tipo'],
                    'nombre_campana_tipo' => $this->dame_camp_tipo_nombre($row['id_campana_tipo']),
                    'id_campana_subtipo' => $row['id_campana_subtipo'],
                    'nombre_campana_subtipo' => $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']),
                    'id_campana_tema' => $row['id_campana_tema'],
                    'nombre_tema' => $this->dame_tema_nombre($row['id_campana_tema']),
                    'id_campana_objetivo' => $row['id_campana_objetivo'],
                    'id_ejercicio' => $row['id_ejercicio'],
                    'nombre_ejercicio' => $this->dame_ejercicio_nombre($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'nombre_trimestre' => $this->dame_trimestre_nombre($row['id_trimestre']),
                    'fecha_inicio_periodo' => $row['fecha_inicio_periodo'],
                    'fecha_termino_periodo' => $row['fecha_termino_periodo'],
                    'id_so_solicitante' => $row['id_so_solicitante'],
                    'nombre_so_solicitante' => $this->dame_nombre_solicitante($row['id_so_solicitante']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'nombre_so_contratante' => $this->dame_nombre_contratante($row['id_so_contratante']),
                    'id_tiempo_oficial' => $row['id_tiempo_oficial'],
                    'nombre_tiempo_oficial' => $this->dame_tiempo_oficial_nombre($row['id_tiempo_oficial']),
                    'id_campana_tipoTO' => $row['id_campana_tipoTO'],
                    'nombre_tipoTO' => $this->dame_tipoTO_nombre($row['id_campana_tipoTO']),
					'id_presupuesto' => $row['id_presupuesto'],
					'denominacion' => $this->dame_docs_nombre($row['id_presupuesto']),
					
					'id_servicio_categoria' => $row['id_servicio_categoria'],
					'nombre_servicioCat' => $this->dame_medioComunicacion_nombre($row['id_servicio_categoria']),
					
                    'nombre_campana_aviso' => $row['nombre_campana_aviso'],
                    'objetivo_comunicacion' => $row['objetivo_comunicacion'],
                    'monto_tiempo' => $row['monto_tiempo'],
                    'hora_to' => $row['hora_to'],
                    'minutos_to' => $row['minutos_to'],
                    'segundos_to' => $row['segundos_to'],
                    'mensajeTO' => $row['mensajeTO'],
                    'descripcion_unidad' => $row['descripcion_unidad'],
                    'responsable_publisher' => $row['responsable_publisher'],
                    'name_comercial' => $row['name_comercial'],
                    'razones_supplier' => $row['razones_supplier'],
                    'difusion_mensaje' => $row['difusion_mensaje'],
                    'num_factura' => $row['num_factura'],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_termino' => $row['fecha_termino'],
                    'fecha_inicio_to' => $row['fecha_inicio_to'],
                    'fecha_termino_to' => $row['fecha_termino_to'],
                    'publicacion_segob' => $row['publicacion_segob'],
                    'campana_ambito_geo' => $row['campana_ambito_geo'],
                    'plan_acs' => $row['plan_acs'],
                    'fecha_dof' => $row['fecha_dof'],
                    'evaluacion' => $row['evaluacion'],
                    'evaluacion_documento' => $row['evaluacion_documento'],
                    'fecha_validacion' => $row['fecha_validacion'],
                    'fecha_dof' => $row['fecha_dof'],
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'],
                    'fecha_actualizacion' => $row['fecha_actualizacion'],
                    'nota' => $row['nota'],
                    'autoridad' => $row['autoridad'],
                    'clave_campana' => $row['clave_campana'],
                    'active' => $row['active'],
                    'active_nombre' => $this->get_estatus_name($row['active'])
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function dame_nombre_atributo_eliminado($id_rel, $atributo)
    {
        switch ($atributo) 
        {
            case 'edad':
                    
                $this->db->where('id_rel_campana_grupo_edad', $id_rel);
                $query = $this->db->get('rel_campana_grupo_edad');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $nombre_grupo_edad = $this->dame_nombre_grupo_edad($row['id_poblacion_grupo_edad']);
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del grupo de edad: '.$nombre_grupo_edad.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }

                break;

            case 'lugar':
                    
                $this->db->where('id_campana_lugar', $id_rel);
                $query = $this->db->get('rel_campana_lugar');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $lugar = $row['poblacion_lugar'];
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del lugar: '.$lugar.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }

                break;

            case 'nivel':
                    
                $this->db->where('id_rel_campana_nivel', $id_rel);
                $query = $this->db->get('rel_campana_nivel');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $nivel = $this->dame_nombre_nivel($row['id_poblacion_nivel']);
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del nivel socioecónomico: '.$nivel.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }
                break;

            case 'educacion':
                    
                $this->db->where('id_rel_campana_nivel_educativo', $id_rel);
                $query = $this->db->get('rel_campana_nivel_educativo');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $nivel_educativo = $this->dame_nombre_nivel_educativo($row['id_poblacion_nivel_educativo']);
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del nivel educativo: '.$nivel_educativo.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }

                break;

            case 'sexo':
                    
                $this->db->where('id_rel_campana_sexo', $id_rel);
                $query = $this->db->get('rel_campana_sexo');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $sexo = $this->dame_nombre_sexo($row['id_poblacion_sexo']);
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del sexo: '.$sexo.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }

                break;

            case 'audios':
                    
                $this->db->where('id_campana_maudio', $id_rel);
                $query = $this->db->get('rel_campana_maudio');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $audio = $row['nombre_campana_maudio'];
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación del audio: '.$audio.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }
                
                break;

            case 'imagenes':
                    
                $this->db->where('id_campana_mimagen', $id_rel);
                $query = $this->db->get('rel_campana_mimagenes');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $imagen = $row['nombre_campana_mimagen'];
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación de la imagen: '.$imagen.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }

                break;

            case 'videos':
                    
                $this->db->where('id_campana_mvideo', $id_rel);
                $query = $this->db->get('rel_campana_mvideo');
                
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row) {
                        $imagen = $row['nombre_campana_mvideo'];
                        $campana_nombre = $this->dame_campana_nombre($row['id_campana_aviso']);
                    }

                    $detalle = 'Eliminación de lal video: '.$imagen.' de la campaña/aviso '.$campana_nombre;
                    return $detalle;
                }
                
                break;
            default: return 'Guardar valor';
                break;
        }
    }

    function dame_eliminar_rel_edad($id_rel)
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->db->where('id_campana_aviso', $id);
        
        $query = $this->db->get('tab_campana_aviso');
        
        if ($query->num_rows() == 1)
        {
            $register = [];
            foreach ($query->result_array() as $row) {
                $register = array(
                    'id_campana_aviso' => $row['id_campana_aviso'],
                    'id_campana_cobertura' => $row['id_campana_cobertura'],
                    'nombre_cobertura' => $this->dame_cobertura_nombre($row['id_campana_cobertura']),
                    'id_campana_tipo' => $row['id_campana_tipo'],
                    'nombre_campana_tipo' => $this->dame_camp_tipo_nombre($row['id_campana_tipo']),
                    'id_campana_subtipo' => $row['id_campana_subtipo'],
                    'nombre_campana_subtipo' => $this->dame_camp_subtipo_nombre($row['id_campana_subtipo']),
                    'id_campana_tema' => $row['id_campana_tema'],
                    'nombre_tema' => $this->dame_tema_nombre($row['id_campana_tema']),
                    'id_campana_objetivo' => $row['id_campana_objetivo'],
                    'id_ejercicio' => $row['id_ejercicio'],
                    'nombre_ejercicio' => $this->dame_ejercicio_nombre($row['id_ejercicio']),
                    'id_trimestre' => $row['id_trimestre'],
                    'nombre_trimestre' => $this->dame_trimestre_nombre($row['id_trimestre']),
                    'fecha_inicio_periodo' => $row['fecha_inicio_periodo'],
                    'fecha_termino_periodo' => $row['fecha_termino_periodo'],
                    'id_so_solicitante' => $row['id_so_solicitante'],
                    'nombre_so_solicitante' => $this->dame_nombre_solicitante($row['id_so_solicitante']),
                    'id_so_contratante' => $row['id_so_contratante'],
                    'nombre_so_contratante' => $this->dame_nombre_contratante($row['id_so_contratante']),
                    'id_tiempo_oficial' => $row['id_tiempo_oficial'],
                    'nombre_tiempo_oficial' => $this->dame_tiempo_oficial_nombre($row['id_tiempo_oficial']),
                    'id_campana_tipoTO' => $row['id_campana_tipoTO'],
                    'nombre_tipoTO' => $this->dame_tipoTO_nombre($row['id_campana_tipoTO']),
					'id_presupuesto' => $row['id_presupuesto'],
					'denominacion' => $this->dame_docs_nombre($row['id_presupuesto']),
					
					'id_servicio_categoria' => $row['id_servicio_categoria'],
					'nombre_servicioCat' => $this->dame_medioComunicacion_nombre($row['id_servicio_categoria']),
					
                    'nombre_campana_aviso' => $row['nombre_campana_aviso'],
                    'objetivo_comunicacion' => $row['objetivo_comunicacion'],
                    'monto_tiempo' => $row['monto_tiempo'],
                    'hora_to' => $row['hora_to'],
                    'minutos_to' => $row['minutos_to'],
                    'segundos_to' => $row['segundos_to'],
                    'mensajeTO' => $row['mensajeTO'],
                    'descripcion_unidad' => $row['descripcion_unidad'],
                    'responsable_publisher' => $row['responsable_publisher'],
                    'name_comercial' => $row['name_comercial'],
                    'razones_supplier' => $row['razones_supplier'],
                    'difusion_mensaje' => $row['difusion_mensaje'],
                    'num_factura' => $row['num_factura'],
                    'fecha_inicio' => $row['fecha_inicio'],
                    'fecha_termino' => $row['fecha_termino'],
                    'fecha_inicio_to' => $row['fecha_inicio_to'],
                    'fecha_termino_to' => $row['fecha_termino_to'],
                    'publicacion_segob' => $row['publicacion_segob'],
                    'campana_ambito_geo' => $row['campana_ambito_geo'],
                    'plan_acs' => $row['plan_acs'],
                    'fecha_dof' => $row['fecha_dof'],
                    'evaluacion' => $row['evaluacion'],
                    'evaluacion_documento' => $row['evaluacion_documento'],
                    'fecha_validacion' => $row['fecha_validacion'],
                    'fecha_dof' => $row['fecha_dof'],
                    'area_responsable' => $row['area_responsable'],
                    'periodo' => $row['periodo'],
                    'fecha_actualizacion' => $row['fecha_actualizacion'],
                    'nota' => $row['nota'],
                    'autoridad' => $row['autoridad'],
                    'clave_campana' => $row['clave_campana'],
                    'active' => $row['active'],
                    'active_nombre' => $this->get_estatus_name($row['active'])
                );
            }
            return $register;
        }else{
            return '';
        }
    }

    function eliminar_campana($id)
    {
        $reg_eliminado = $this->dame_eliminar_campana_id($id);

        $this->db->where('id_campana_aviso', $id);
        $this->db->delete('tab_campana_aviso');
        
        if($this->db->affected_rows() > 0)
        {
            if(!empty($reg_eliminado))
                $this->guardar_bitacora('Campañas', 'Eliminación campana/aviso institucional : ' . $reg_eliminado['nombre_campana_aviso']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function edita_campana($id_campana_aviso)
    {
        //Los nombres tambien deben ser unicos
        $this->db->where('nombre_campana_aviso', $this->input->post('nombre_campana_aviso'));
        $this->db->where('active !=', '2');
        $this->db->where('id_campana_aviso !=', $id_campana_aviso);
        $query = $this->db->get('tab_campana_aviso');
            
        if ($query->num_rows() > 0)
        {
            return 6;   //Ya se encuentra una campana o aviso con ese nombre
        }

        //Dependiendo si se esta dando de alta una campana o un aviso, validaremos la existencia de ellas en la BD
        //Validamos la existencia de la campana
        if($this->input->post('id_campana_tipo') == '1')
        {
            $this->db->where('nombre_campana_aviso', $this->input->post('nombre_campana_aviso'));
            $this->db->where('active !=', '2');
            $this->db->where('id_campana_aviso !=', $id_campana_aviso);
            $this->db->where('id_campana_tipo', $this->input->post('id_campana_tipo'));
            $query = $this->db->get('tab_campana_aviso');
            
            if ($query->num_rows() > 0)
            {
                return 3;   //Ya existe un aviso institucional
            }
        }

        if($this->input->post('id_campana_tipo') == '2')
        {
            $this->db->where('nombre_campana_aviso', $this->input->post('nombre_campana_aviso'));
            $this->db->where('active !=', '2');
            $this->db->where('id_campana_aviso !=', $id_campana_aviso);
            $this->db->where('id_campana_tipo', $this->input->post('id_campana_tipo'));
            $query = $this->db->get('tab_campana_aviso');
            
            if ($query->num_rows() > 0)
            {
                return 4;   //Ya existe una campana
            }
        }

        //Validamos si la clave ya existe
        $this->db->where('id_campana_aviso !=', $id_campana_aviso);
        $this->db->where('active !=', '2');
        $this->db->where('id_campana_tipo', $this->input->post('id_campana_tipo'));
        $query = $this->db->get('tab_campana_aviso');
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                if($row['clave_campana'] != '')
                {
                    if($row['clave_campana'] == $this->input->post('clave_campana'))
                    {
                        return 5;   //Ya existe la clave de campana/aviso institucional
                    }
                }
            }
        }

        $data = array(
            'id_campana_cobertura' => $this->input->post('id_campana_cobertura'),
            'id_campana_tipo' => $this->input->post('id_campana_tipo'),
            'id_campana_subtipo' => $this->input->post('id_campana_subtipo'),
            'id_campana_tema' => $this->input->post('id_campana_tema'),
            'id_campana_objetivo' => $this->input->post('id_campana_objetivo'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'fecha_inicio_periodo' => $this->stringToDate($this->input->post('fecha_inicio_periodo')),
            'fecha_termino_periodo' => $this->stringToDate($this->input->post('fecha_termino_periodo')),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'id_tiempo_oficial' => $this->input->post('id_tiempo_oficial'),
            'id_campana_tipoTO' => $this->input->post('id_campana_tipoTO'),
			'id_presupuesto' => $this->input->post('id_presupuesto'),
			'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
            'nombre_campana_aviso' => $this->input->post('nombre_campana_aviso'),
            'objetivo_comunicacion' => $this->input->post('objetivo_comunicacion'),
            'monto_tiempo' => $this->input->post('monto_tiempo'),
            'hora_to' => $this->input->post('hora_to'),
            'minutos_to' => $this->input->post('minutos_to'),
            'segundos_to' => $this->input->post('segundos_to'),
            'mensajeTO' => $this->input->post('mensajeTO'),
            'descripcion_unidad' => $this->input->post('descripcion_unidad'),
            'responsable_publisher' => $this->input->post('responsable_publisher'),
            'name_comercial' => $this->input->post('name_comercial'),
            'razones_supplier' => $this->input->post('razones_supplier'),
            'difusion_mensaje' => $this->input->post('difusion_mensaje'),
            'num_factura' => $this->input->post('num_factura'),
            'fecha_inicio' =>  $this->stringToDate($this->input->post('fecha_inicio')),
            'fecha_termino' => $this->stringToDate($this->input->post('fecha_termino')),
            'fecha_inicio_to' => $this->stringToDate($this->input->post('fecha_inicio_to')),
            'fecha_termino_to' => $this->stringToDate($this->input->post('fecha_termino_to')),
            'publicacion_segob' => $this->input->post('publicacion_segob'),
            'campana_ambito_geo' => $this->input->post('campana_ambito_geo'),
            'plan_acs' => $this->input->post('plan_acs'),
            'fecha_dof' => $this->stringToDate($this->input->post('fecha_dof')),
            'evaluacion' => $this->input->post('evaluacion'),
            'evaluacion_documento' => $this->input->post('file_evaluacion_nombre'),
            'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
            'nota' => $this->input->post('nota'),
            'autoridad' => $this->input->post('autoridad'),
            'clave_campana' => $this->input->post('clave_campana'),
            'active' => $this->input->post('active'),
        );

        $this->db->where('id_campana_aviso', $id_campana_aviso);
        $this->db->update('tab_campana_aviso', $data);
        
        if($this->db->affected_rows() > 0)
        {
            if($this->input->post('id_campana_tipo') == '1')
            {
                $bitacora = $this->guardar_bitacora('Modificación Aviso Institucional');
            }else{
                $bitacora = $this->guardar_bitacora('Modificación Campaña');
            }

            if($bitacora == '1')
            {
                if($this->input->post('id_campana_tipo') == '1')
                {
                    return '1|'.$id_campana_aviso;
                }
                else{
                    return '2|'.$id_campana_aviso;
                }
            }
        }
    }

    function edita_status_campana()
    {
        
        $data = array(
            'active' => $this->input->post('active'),
        );

        if ($this->input->post('id_year_selected') != "" && $this->input->post('id_year_selected') != "0"){
            $this->db->where('id_ejercicio', $this->input->post('id_year_selected'));
        }

        $this->db->update('tab_campana_aviso', $data);
        
        if($this->db->affected_rows() > 0)
        {
            
            $bitacora = $this->guardar_bitacora('Se modificaron todos los datos');

            return 1;
        }else{
            return 0;
        }
                
    }

    //Guardamos los detalles de las pestañas
    function guarda_rel_camp()
    {
        switch ($this->input->post('atributo')) 
        {
            case 'edad':
                    
                $data_new = array(
                    'id_rel_campana_grupo_edad' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_poblacion_grupo_edad' => $this->input->post('id_poblacion_grupo_edad'),
                );
                        
                $this->db->insert('rel_campana_grupo_edad', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Alta grupo edad');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'lugar':
                    
                $data_new = array(
                    'id_campana_lugar' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'poblacion_lugar' => $this->input->post('poblacion_lugar'),
                );
                        
                $this->db->insert('rel_campana_lugar', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Alta lugar');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'nivel':
                    
                $data_new = array(
                    'id_rel_campana_nivel' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_poblacion_nivel' => $this->input->post('id_poblacion_nivel'),
                );
                        
                $this->db->insert('rel_campana_nivel', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Alta nivel socioeconómico');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'educacion':
                    
                $data_new = array(
                    'id_rel_campana_nivel_educativo' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_poblacion_nivel_educativo' => $this->input->post('id_poblacion_nivel_educativo'),
                );
                        
                $this->db->insert('rel_campana_nivel_educativo', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    $bitacora = $this->guardar_bitacora('Alta nivel educativo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'sexo':
                    
                $data_new = array(
                    'id_rel_campana_sexo' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_poblacion_sexo' => $this->input->post('id_poblacion_sexo'),
                );
                        
                $this->db->insert('rel_campana_sexo', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    $bitacora = $this->guardar_bitacora('Alta grupo sexo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'audios':
                    
                $data_new = array(
                    'id_campana_maudio' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_tipo_liga' => $this->input->post('id_tipo_liga'),
                    'nombre_campana_maudio' => $this->input->post('nombre_campana_maudio'),
                    'url_audio' => $this->input->post('url_audio'),
                    'file_audio' => $this->input->post('name_file_programa_anual'),
                );
                        
                $this->db->insert('rel_campana_maudio', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    $bitacora = $this->guardar_bitacora('Alta archivo de audio');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'imagenes':
                    
                $data_new = array(
                    'id_campana_mimagen' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_tipo_liga' => $this->input->post('id_tipo_liga'),
                    'nombre_campana_mimagen' => $this->input->post('nombre_campana_mimagen'),
                    'url_imagen' => $this->input->post('url_imagen'),
                    'file_imagen' => $this->input->post('name_file_campana_imagen'),
                );
                        
                $this->db->insert('rel_campana_mimagenes', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    $bitacora = $this->guardar_bitacora('Alta archivo de imagen');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'videos':
                    
                $data_new = array(
                    'id_campana_mvideo' => '0',
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'id_tipo_liga' => $this->input->post('id_tipo_liga'),
                    'nombre_campana_mvideo' => $this->input->post('nombre_campana_mvideo'),
                    'url_video' => $this->input->post('url_video'),
                    'file_video' => $this->input->post('name_file_campana_video'),
                );
                        
                $this->db->insert('rel_campana_mvideo', $data_new);
                
                if($this->db->affected_rows() > 0)
                {
                    $bitacora = $this->guardar_bitacora('Alta archivo de vídeo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;
            default: return 'Guardar valor';
                break;
        }
    }

    //Actualizamos los detalles de las pestanas
    function actualiza_rel_camp()
    {
        switch ($this->input->post('atributo')) 
        {
            case 'edad':
                
                $data_act = array(
                    'id_poblacion_grupo_edad' => $this->input->post('id_poblacion_grupo_edad'),
                );
                        
                $this->db->where('id_rel_campana_grupo_edad', $this->input->post('id_rel_campana_grupo_edad'));
                $this->db->update('rel_campana_grupo_edad', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Se actualizó el grupo de edad');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                
                break;

            case 'lugar':
                    
                $data_act = array(
                    'id_campana_aviso' => $this->input->post('id_campana_aviso'),
                    'poblacion_lugar' => $this->input->post('poblacion_lugar'),
                );

                $this->db->where('id_campana_lugar', $this->input->post('id_rel'));        
                $this->db->update('rel_campana_lugar', $data_act);
                
                //Guardamos accion en la bitacora
                $bitacora = $this->guardar_bitacora('Modificación de lugar');
                if($bitacora == '1')
                {
                    return 1;   //is correct
                }

                break;

            case 'nivel':
                    
                $data_act = array(
                    'id_poblacion_nivel' => $this->input->post('id_poblacion_nivel'),
                );

                $this->db->where('id_rel_campana_nivel', $this->input->post('id_rel_campana_nivel'));        
                $this->db->update('rel_campana_nivel', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de nivel');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }

                break;
            
            case 'educacion':
                    
                $data_act = array(
                    'id_poblacion_nivel_educativo' => $this->input->post('id_poblacion_nivel_educativo'),
                );

                $this->db->where('id_rel_campana_nivel_educativo', $this->input->post('id_rel_campana_nivel_educativo'));        
                $this->db->update('rel_campana_nivel_educativo', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de nivel educativo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }

                break;
            case 'sexo':
                    
                $data_act = array(
                    'id_poblacion_sexo' => $this->input->post('id_poblacion_sexo'),
                );

                $this->db->where('id_rel_campana_sexo', $this->input->post('id_rel_campana_sexo'));        
                $this->db->update('rel_campana_sexo', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de grupo de sexo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;
            
            case 'audios':                   
                $data_act = array(
                    'id_tipo_liga' => $this->input->post('id_tipo_liga_edita'),
                    'nombre_campana_maudio' => $this->input->post('nombre_campana_maudio_edita'),
                    'url_audio' => $this->input->post('url_audio_edita'),
                    'file_audio' => $this->input->post('campana_file_audio_edita')
                );

                $this->db->where('id_campana_maudio', $this->input->post('id_campana_maudio'));        
                $this->db->update('rel_campana_maudio', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de audios');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;
				
            case 'imagenes':                   
                $data_act = array(
                    'id_tipo_liga' => $this->input->post('id_tipo_liga_edita'),
                    'nombre_campana_mimagen' => $this->input->post('nombre_campana_mimagen_edita'),
                    'url_imagen' => $this->input->post('url_edita_imagen'),
                    'file_imagen' => $this->input->post('name_file_campana_edita_imagen')
                );

                $this->db->where('id_campana_mimagen', $this->input->post('id_campana_mimagen'));        
                $this->db->update('rel_campana_mimagenes', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de imágen');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            case 'videos':                    
                $data_act = array(
                    'id_tipo_liga' => $this->input->post('id_tipo_liga_edita'),
                    'nombre_campana_mvideo' => $this->input->post('nombre_campana_mvideo_edita'),
                    'url_video' => $this->input->post('url_video'),
                    'file_video' => $this->input->post('name_file_campana_video_edita')
                );

                $this->db->where('id_campana_mvideo', $this->input->post('id_campana_mvideo'));        
                $this->db->update('rel_campana_mvideo', $data_act);
                
                if($this->db->affected_rows() > 0)
                {
                    //Guardamos accion en la bitacora
                    $bitacora = $this->guardar_bitacora('Modificación de vídeo');
                    if($bitacora == '1')
                    {
                        return 1;   //is correct
                    }
                }
                break;

            default: 'No hay nada a modificar';
                break;
        }
    }

    //Eliminamos los detalles de las pestanas
    function elimina_rel_camp($id_rel, $atributo)
    {
        switch ($atributo) 
        {
            case 'edad':
                
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                
                $this->db->where('id_rel_campana_grupo_edad', $id_rel);
                $this->db->delete('rel_campana_grupo_edad');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }
                break;

            case 'lugar':                    
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                
                $this->db->where('id_campana_lugar', $id_rel);
                $this->db->delete('rel_campana_lugar');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }
                break;

            case 'nivel':                    
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                
                $this->db->where('id_rel_campana_nivel', $id_rel);
                $this->db->delete('rel_campana_nivel');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }
                break;

            case 'educacion':                    
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                    
                $this->db->where('id_rel_campana_nivel_educativo', $id_rel);
                $this->db->delete('rel_campana_nivel_educativo');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }
                break;

            case 'sexo':                        
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                        
                $this->db->where('id_rel_campana_sexo', $id_rel);
                $this->db->delete('rel_campana_sexo');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }
                break;

            case 'audios':                    
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                            
                $this->db->where('id_campana_maudio', $id_rel);
                $this->db->delete('rel_campana_maudio');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }                
                break;

            case 'imagenes':                    
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                                
                $this->db->where('id_campana_mimagen', $id_rel);
                $this->db->delete('rel_campana_mimagenes');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }                
                break;

            case 'videos':                  
                $reg_eliminado = $this->dame_nombre_atributo_eliminado($id_rel, $atributo);
                                    
                $this->db->where('id_campana_mvideo', $id_rel);
                $this->db->delete('rel_campana_mvideo');
                
                if($this->db->affected_rows() > 0)
                {
                    $this->guardar_bitacora($reg_eliminado);
                    return 1; // is correct
                }else
                {
                    return 0; // sometime is wrong
                }    
                break;
				
            default: return 'Guardar valor';
                break;
        }
    }

    function dame_todos_camp_tipos()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_tipos');
        
        if($query->num_rows() > 0)
        {
            $array_camp_tipo = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_tipo[$cont]['id_campana_tipo'] = $row['id_campana_tipo'];
                $array_camp_tipo[$cont]['nombre_campana_tipo'] = $row['nombre_campana_tipo'];
                $array_camp_tipo[$cont]['active'] = $row['active'];
                $array_camp_tipo[$cont]['nombre_active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_camp_tipo;
        }
    }

    function dame_todos_camp_subtipos()
    {
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_subtipo', 'ASC');
        $query = $this->db->get('cat_campana_subtipos');

        if($query->num_rows() > 0)
        {
            $array_camp_subtipo = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_camp_subtipo[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                $array_camp_subtipo[$cont]['nombre_campana_subtipo'] = $row['nombre_campana_subtipo'];
                $array_camp_subtipo[$cont]['active'] = $row['active'];
                $array_camp_subtipo[$cont]['nombre_active'] = $this->get_estatus_name($row['active']);
                $cont++;
            }
            return $array_camp_subtipo;
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

    function dame_todos_temas()
    {
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_tema', 'ASC');
        $query = $this->db->get('cat_campana_temas');
        
        if($query->num_rows() > 0)
        {
            $array_temas = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_temas[$cont]['id_campana_tema'] = $row['id_campana_tema'];
                $array_temas[$cont]['nombre_campana_tema'] = $row['nombre_campana_tema'];
                $array_temas[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_temas;
        }
    }

    function dame_todos_objetivos()
    {
        $this->db->where('active', '1');
        $this->db->order_by('campana_objetivo', 'ASC');
        $query = $this->db->get('cat_campana_objetivos');
        
        if($query->num_rows() > 0)
        {
            $array_temas = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_objetivos[$cont]['id_campana_objetivo'] = $row['id_campana_objetivo'];
                $array_objetivos[$cont]['campana_objetivo'] = $row['campana_objetivo'];
                $array_objetivos[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_objetivos;
        }
    }

    function dame_todas_coberturas()
    {
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_cobertura', 'ASC');
        $query = $this->db->get('cat_campana_coberturas');
        
        if($query->num_rows() > 0)
        {
            $array_coberturas = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_coberturas[$cont]['id_campana_cobertura'] = $row['id_campana_cobertura'];
                $array_coberturas[$cont]['nombre_campana_cobertura'] = $row['nombre_campana_cobertura'];
                $array_coberturas[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_coberturas;
        }
    }

	function dame_todos_tiposTO()
    {
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_tipoTO', 'ASC');
        $query = $this->db->get('cat_campana_tiposTO');
        
        if($query->num_rows() > 0)
        {
            $array_tiposTO = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_tiposTO[$cont]['id_campana_tipoTO'] = $row['id_campana_tipoTO'];
                $array_tiposTO[$cont]['nombre_campana_tipoTO'] = $row['nombre_campana_tipoTO'];
                $array_tiposTO[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_tiposTO;
        }
    }
    
    function dame_todos_mediosCat()
    {
        $this->db->where('active', '1');
        $this->db->order_by('nombre_servicio_categoria', 'ASC');
        $query = $this->db->get('cat_servicios_categorias');
        
        if($query->num_rows() > 0)
        {
            $array_categorias = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_categorias[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                $array_categorias[$cont]['nombre_servicio_categoria'] = $row['nombre_servicio_categoria'];
                $array_categorias[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_categorias;
        }
    }
    
    
    
	function dame_todos_docpacs()
    {
        $this->db->order_by('denominacion', 'ASC');
        $query = $this->db->get('vtab_presupuesto_PACS');
        
        if($query->num_rows() > 0)
        {
            $array_docpacs = [];
            $cont = 0;
			foreach ($query->result_array() as $row)
			{
				$array_docpacs[$cont]['id_presupuesto'] = $row['id_presupuesto'];
                $array_docpacs[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                $array_docpacs[$cont]['denominacion'] = $row['denominacion'];
                $cont++;
			}           
            return $array_docpacs;
        }
    }
	
    function dame_subtipo()
    {
        $id_tipo = $this->input->post('id_campana_tipo');

        $this->db->where('id_campana_tipo', $id_tipo);
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_subtipo','ASC');

        $query = $this->db->get('cat_campana_subtipos');
        if($query->num_rows() > 0)
        {
            $array_subtipo = [];
            $cont = 0;
            foreach ($query->result_array() as $row)
            {
                $array_subtipo[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                $array_subtipo[$cont]['nombre_campana_subtipo'] = $row['nombre_campana_subtipo'];
                $cont++;
            }
            
            return $array_subtipo;
        }
        else
        {
            return 0;
        }
    }

    function dame_subtipo_post()
    {
        $id_tipo = $this->input->post('id_campana_tipo');
        $this->db->where('id_campana_tipo', $id_tipo);
        $this->db->where('active', '1');
        $this->db->order_by('nombre_campana_subtipo', 'ASC');
        $query = $this->db->get('cat_campana_subtipos');
        if($query->num_rows() > 0)
        {
            $array_subtipo = [];
            $cont = 0;
            foreach ($query->result_array() as $row)
            {
                $array_subtipo[$cont]['id_campana_subtipo'] = $row['id_campana_subtipo'];
                $array_subtipo[$cont]['nombre_campana_subtipo'] = $row['nombre_campana_subtipo'];
                $cont++;
            }
            
            return $array_subtipo;
        }
        else
        {
            return 0;
        }
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
            return '-nada-';
        }
    }

    function get_estatus_captura($estatus)
    {
        if($estatus == 1){
            return 'Si';
        }else if($estatus == 2){
            return 'No';
        }else {
            return '-nada-';
        }
    }

    function dame_todas_edades()
    {
        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        if($query->num_rows() > 0)
        {
            $array_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_edades[$cont]['id_poblacion_grupo_edad'] = $row['id_poblacion_grupo_edad'];
                    $array_edades[$cont]['nombre_poblacion_grupo_edad'] = $row['nombre_poblacion_grupo_edad'];
                    $array_edades[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_edades;
        }
    }

    /** Funcion para la descarga a .csv de objetivos institucionales **/
    function descarga_edades()
    {
        $filename = 'dist/csv/edades.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_poblacion_grupo_edad');
        $csv_header = array('#',utf8_decode('Segmentación de edad'), 'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_poblacion_grupo_edad']),
                    utf8_decode($row['nombre_poblacion_grupo_edad']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }
        fclose($myfile);

        return $filename;
    }
    
    function eliminar_edad($id)
    {
        $this->db->where('id_poblacion_grupo_edad', $id);
        $this->db->delete('cat_poblacion_grupo_edad');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function dame_edad_id($id)
    {
        $this->db->where('id_poblacion_grupo_edad', $id);
        
        $query = $this->db->get('cat_poblacion_grupo_edad');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function dame_nivel_id($id)
    {
        $this->db->where('id_poblacion_nivel', $id);
        
        $query = $this->db->get('cat_poblacion_nivel');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function agregar_edad()
    {
        $this->db->where('nombre_poblacion_grupo_edad', $this->input->post('nombre_poblacion_grupo_edad'));
        
        $query = $this->db->get('cat_poblacion_grupo_edad');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_poblacion_grupo_edad' => '',
                'nombre_poblacion_grupo_edad' => $this->input->post('nombre_poblacion_grupo_edad'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_poblacion_grupo_edad', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_edad()
    {

        $this->db->where('nombre_poblacion_grupo_edad', $this->input->post('nombre_poblacion_grupo_edad'));
        $this->db->where_not_in('id_poblacion_grupo_edad', $this->input->post('id_poblacion_grupo_edad'));
        $query = $this->db->get('cat_poblacion_grupo_edad');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_poblacion_grupo_edad' => $this->input->post('nombre_poblacion_grupo_edad'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_poblacion_grupo_edad', $this->input->post('id_poblacion_grupo_edad'));
            $this->db->update('cat_poblacion_grupo_edad', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todas_socioeconomicos()
    {
        $query = $this->db->get('cat_poblacion_nivel');
        
        if($query->num_rows() > 0)
        {
            $array_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_edades[$cont]['id_poblacion_nivel'] = $row['id_poblacion_nivel'];
                    $array_edades[$cont]['nombre_poblacion_nivel'] = $row['nombre_poblacion_nivel'];
                    $array_edades[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_edades;
        }
    }

    /** Funcion para la descarga a .csv de objetivos institucionales **/
    function descarga_socioeconomicos()
    {
        $filename = 'dist/csv/nivel_socioeconomicos.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_poblacion_nivel');
        $csv_header = array('#',utf8_decode('Nivel socioeconómico'), 'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_poblacion_nivel']),
                    utf8_decode($row['nombre_poblacion_nivel']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function eliminar_socioeconomico($id)
    {
        $this->db->where('id_poblacion_nivel', $id);
        $this->db->delete('cat_poblacion_nivel');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_nivel_socioeconomico()
    {
        $this->db->where('nombre_poblacion_nivel', $this->input->post('nombre_poblacion_nivel'));
        
        $query = $this->db->get('cat_poblacion_nivel');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_poblacion_nivel' => '',
                'nombre_poblacion_nivel' => $this->input->post('nombre_poblacion_nivel'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_poblacion_nivel', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_nivel_socioeconomico()
    {

        $this->db->where('nombre_poblacion_nivel', $this->input->post('nombre_poblacion_nivel'));
        $this->db->where_not_in('id_poblacion_nivel', $this->input->post('id_poblacion_nivel'));
        $query = $this->db->get('cat_poblacion_nivel');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_poblacion_nivel' => $this->input->post('nombre_poblacion_nivel'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_poblacion_nivel', $this->input->post('id_poblacion_nivel'));
            $this->db->update('cat_poblacion_nivel', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_socioeconomico_id($id)
    {
        $this->db->where('id_poblacion_nivel', $id);
        
        $query = $this->db->get('cat_poblacion_nivel');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function dame_todas_educacion()
    {
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        
        if($query->num_rows() > 0)
        {
            $array_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_edades[$cont]['id_poblacion_nivel_educativo'] = $row['id_poblacion_nivel_educativo'];
                    $array_edades[$cont]['nombre_poblacion_nivel_educativo'] = $row['nombre_poblacion_nivel_educativo'];
                    $array_edades[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_edades;
        }
    }

    function alta_campana()
    {
        //Dependiendo si se esta dando de alta una campana o un aviso, validaremos la existencia de ellas en la BD
        //Validamos la existencia de la campana
        if($this->input->post('id_campana_tipo') == '1')
        {
            $this->db->where('nombre_campana_aviso', $this->input->post('nombre_campana_aviso'));
            $this->db->where('active !=', '2');
            $this->db->where('id_campana_tipo', $this->input->post('id_campana_tipo'));
            $query = $this->db->get('tab_campana_aviso');
            
            if ($query->num_rows() > 0)
            {
                return 3;   //Ya existe un aviso institucional
            }
        }

        if($this->input->post('id_campana_tipo') == '2')
        {
            $this->db->where('nombre_campana_aviso', $this->input->post('nombre_campana_aviso'));
            $this->db->where('active !=', '2');
            $this->db->where('id_campana_tipo', $this->input->post('id_campana_tipo'));
            $query = $this->db->get('tab_campana_aviso');
            
            if ($query->num_rows() > 0)
            {
                return 4;   //Ya existe una campana
            }
        }

        //Validamos si la clave ya existe
        $this->db->where('active !=', '2');
        $query = $this->db->get('tab_campana_aviso');
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                if($row['clave_campana'] != '')
                {
                    if($row['clave_campana'] == $this->input->post('clave_campana'))
                    {
                        return 5;   //Ya existe la clave de campana/aviso institucional
                    }
                }
            }
        }

        $data = array(
            'id_campana_aviso' => '0',
            'id_campana_cobertura' => $this->input->post('id_campana_cobertura'),
            'id_campana_tipoTO' => $this->input->post('id_campana_tipoTO'),
			'id_presupuesto' => $this->input->post('id_presupuesto'),
			'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
            'id_campana_tipo' => $this->input->post('id_campana_tipo'),
            'id_campana_subtipo' => $this->input->post('id_campana_subtipo'),
            'id_campana_tema' => $this->input->post('id_campana_tema'),
            'id_campana_objetivo' => $this->input->post('id_campana_objetivo'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'fecha_inicio_periodo' =>  $this->stringToDate($this->input->post('fecha_inicio_periodo')),
            'fecha_termino_periodo' => $this->stringToDate($this->input->post('fecha_termino_periodo')),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'id_tiempo_oficial' => $this->input->post('id_tiempo_oficial'),
            'nombre_campana_aviso' => $this->input->post('nombre_campana_aviso'),
            'objetivo_comunicacion' => $this->input->post('objetivo_comunicacion'),
            'monto_tiempo' => $this->input->post('monto_tiempo'),
            'hora_to' => $this->input->post('hora_to'),
            'minutos_to' => $this->input->post('minutos_to'),
            'segundos_to' => $this->input->post('segundos_to'),
            'mensajeTO' => $this->input->post('mensajeTO'),
            'descripcion_unidad' => $this->input->post('descripcion_unidad'),
            'responsable_publisher' => $this->input->post('responsable_publisher'),
            'name_comercial' => $this->input->post('name_comercial'),
            'razones_supplier' => $this->input->post('razones_supplier'),
            'difusion_mensaje' => $this->input->post('difusion_mensaje'),
            'num_factura' => $this->input->post('num_factura'),
            'fecha_inicio' =>  $this->stringToDate($this->input->post('fecha_inicio')),
            'fecha_termino' => $this->stringToDate($this->input->post('fecha_termino')),
            'fecha_inicio_to' => $this->stringToDate($this->input->post('fecha_inicio_to')),
            'fecha_termino_to' => $this->stringToDate($this->input->post('fecha_termino_to')),
            'publicacion_segob' => $this->input->post('publicacion_segob'),
            'campana_ambito_geo' => $this->input->post('campana_ambito_geo'),
            'plan_acs' => $this->input->post('plan_acs'),
            'fecha_dof' => $this->stringToDate($this->input->post('fecha_dof')),
            'evaluacion' => $this->input->post('evaluacion'),
            'evaluacion_documento' => $this->input->post('name_file_imagen'),
            'fecha_validacion' => $this->stringToDate($this->input->post('fecha_validacion')),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->stringToDate($this->input->post('fecha_actualizacion')),
            'nota' => $this->input->post('nota'),
            'autoridad' => $this->input->post('autoridad'),
            'clave_campana' => $this->input->post('clave_campana'),
            'active' => $this->input->post('active'),
        );

        $this->db->insert('tab_campana_aviso', $data);
        
        if($this->db->affected_rows() > 0)
        {
            if($this->input->post('id_campana_tipo') == '1')
            {
                $bitacora = $this->guardar_bitacora('Alta Aviso Institucional');
            }else{
                $bitacora = $this->guardar_bitacora('Alta Campaña');
            }

            if($bitacora == '1')
            {
                //Obtenemos el ultimo registro insertado en la tabla tab_campana_aviso
                $query = $this->db->query("SELECT id_campana_aviso, id_campana_tipo FROM tab_campana_aviso ORDER BY id_campana_aviso desc limit 1");
                if ($query->num_rows() > 0)
                {
                    foreach ($query->result_array() as $row)
                    {
                        if($row['id_campana_tipo'] == '1')
                        {
                            $id_campana_aviso = $row['id_campana_aviso'];
                            return '1|'.$id_campana_aviso;
                        }
                        else{
                            $id_campana_aviso = $row['id_campana_aviso'];
                            return '2|'.$id_campana_aviso;
                        }
                        
                    }
                }
            }
        }
    }
    
    /** Funcion para la descarga a .csv de objetivos institucionales **/
    function descarga_educacion()
    {
        $filename = 'dist/csv/nivel_educativo.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        $csv_header = array('#',utf8_decode('Nivel de educación'), 'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_poblacion_nivel_educativo']),
                    utf8_decode($row['nombre_poblacion_nivel_educativo']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function eliminar_educacion($id)
    {
        $this->db->where('id_poblacion_nivel_educativo', $id);
        $this->db->delete('cat_poblacion_nivel_educativo');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_nivel_educacion()
    {
        $this->db->where('nombre_poblacion_nivel_educativo', $this->input->post('nombre_poblacion_nivel_educativo'));
        
        $query = $this->db->get('cat_poblacion_nivel_educativo');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_poblacion_nivel_educativo' => '',
                'nombre_poblacion_nivel_educativo' => $this->input->post('nombre_poblacion_nivel_educativo'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_poblacion_nivel_educativo', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function dame_educacion_id($id)
    {
        $this->db->where('id_poblacion_nivel_educativo', $id);
        
        $query = $this->db->get('cat_poblacion_nivel_educativo');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function editar_nivel_educacion()
    {

        $this->db->where('nombre_poblacion_nivel_educativo', $this->input->post('nombre_poblacion_nivel_educativo'));
        $this->db->where_not_in('id_poblacion_nivel_educativo', $this->input->post('id_poblacion_nivel_educativo'));
        $query = $this->db->get('cat_poblacion_nivel_educativo');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_poblacion_nivel_educativo' => $this->input->post('nombre_poblacion_nivel_educativo'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_poblacion_nivel_educativo', $this->input->post('id_poblacion_nivel_educativo'));
            $this->db->update('cat_poblacion_nivel_educativo', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_sexo()
    {
        $query = $this->db->get('cat_poblacion_sexo');
        
        if($query->num_rows() > 0)
        {
            $array_sexos = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_sexos[$cont]['id_poblacion_sexo'] = $row['id_poblacion_sexo'];
                    $array_sexos[$cont]['nombre_poblacion_sexo'] = $row['nombre_poblacion_sexo'];
                    $array_sexos[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_sexos;
        }
    }

    /** Funcion para la descarga a .csv de objetivos institucionales **/
    function descarga_sexo()
    {
        $filename = 'dist/csv/segmentacion_sexo.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_poblacion_sexo');
        $csv_header = array('#',utf8_decode('Segmentación por sexo'), 'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_poblacion_sexo']),
                    utf8_decode($row['nombre_poblacion_sexo']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_sexo_id($id)
    {
        $this->db->where('id_poblacion_sexo', $id);
        
        $query = $this->db->get('cat_poblacion_sexo');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_sexo($id)
    {
        $this->db->where('id_poblacion_sexo', $id);
        $this->db->delete('cat_poblacion_sexo');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_sexo()
    {
        $this->db->where('nombre_poblacion_sexo', $this->input->post('nombre_poblacion_sexo'));
        
        $query = $this->db->get('cat_poblacion_sexo');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_poblacion_sexo' => '',
                'nombre_poblacion_sexo' => $this->input->post('nombre_poblacion_sexo'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_poblacion_sexo', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_sexo()
    {
        $this->db->where('nombre_poblacion_sexo', $this->input->post('nombre_poblacion_sexo'));
        $this->db->where_not_in('id_poblacion_sexo', $this->input->post('id_poblacion_sexo'));
        $query = $this->db->get('cat_poblacion_sexo');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_poblacion_sexo' => $this->input->post('nombre_poblacion_sexo'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_poblacion_sexo', $this->input->post('id_poblacion_sexo'));
            $this->db->update('cat_poblacion_sexo', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todas_clasificaciones()
    {
        $query = $this->db->get('cat_servicios_clasificacion');
        
        if($query->num_rows() > 0)
        {
            $array_edades = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $array_edades[$cont]['id_servicio_clasificacion'] = $row['id_servicio_clasificacion'];
                    $array_edades[$cont]['nombre_servicio_clasificacion'] = $row['nombre_servicio_clasificacion'];
                    $array_edades[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_edades;
        }
    }

    function descarga_clasificaciones()
    {
        $filename = 'dist/csv/clasificaciones_servicio.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_servicios_clasificacion');
        $csv_header = array('#',utf8_decode('Clasificación del servicio'), 'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_servicio_clasificacion']),
                    utf8_decode($row['nombre_servicio_clasificacion']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function agregar_clasificacion()
    {
        $this->db->where('nombre_servicio_clasificacion', $this->input->post('nombre_servicio_clasificacion'));
        
        $query = $this->db->get('cat_servicios_clasificacion');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_servicio_clasificacion' => '',
                'nombre_servicio_clasificacion' => $this->input->post('nombre_servicio_clasificacion'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_servicios_clasificacion', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_clasificacion()
    {
        $this->db->where('nombre_servicio_clasificacion', $this->input->post('nombre_servicio_clasificacion'));
        $this->db->where_not_in('id_servicio_clasificacion', $this->input->post('id_servicio_clasificacion'));
        $query = $this->db->get('cat_servicios_clasificacion');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_servicio_clasificacion' => $this->input->post('nombre_servicio_clasificacion'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_servicio_clasificacion', $this->input->post('id_servicio_clasificacion'));
            $this->db->update('cat_servicios_clasificacion', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function eliminar_clasificacion($id)
    {
        $this->db->where('id_servicio_clasificacion', $id);
        $this->db->delete('cat_servicios_clasificacion');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function dame_clasificacion_id($id)
    {
        $this->db->where('id_servicio_clasificacion', $id);
        
        $query = $this->db->get('cat_servicios_clasificacion');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function dame_todas_categorias()
    {
        $query = $this->db->get('cat_servicios_categorias');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $clasificacion = $this->dame_clasificacion_id($row['id_servicio_clasificacion']);

                    $array_items[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                    $array_items[$cont]['id_servicio_clasificacion'] = $row['id_servicio_clasificacion'];
                    $array_items[$cont]['nombre_servicio_categoria'] = $row['nombre_servicio_categoria'];
                    $array_items[$cont]['nombre_servicio_clasificacion'] = $clasificacion != '' ? $clasificacion['nombre_servicio_clasificacion'] : ''; 
                    $array_items[$cont]['titulo_grafica'] = $row['titulo_grafica'];
                    $array_items[$cont]['color_grafica'] = $row['color_grafica'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_categorias()
    {
        $filename = 'dist/csv/categorias.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_servicios_categorias');
        $csv_header = array('#',
                    utf8_decode('Clasificación del servicio'),
                    utf8_decode('Categorías del servicio'),
                    utf8_decode('Título gráfica'),
                    utf8_decode('Color gráfica'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $clasificacion = $this->dame_clasificacion_id($row['id_servicio_clasificacion']);
                $csv = array(
                    utf8_decode($row['id_servicio_categoria']),
                    utf8_decode($clasificacion != '' ? $clasificacion['nombre_servicio_clasificacion'] : ''),
                    utf8_decode($row['nombre_servicio_categoria']),
                    utf8_decode($row['titulo_grafica']),
                    utf8_decode($row['color_grafica']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_categoria_id($id)
    {
        $this->db->where('id_servicio_categoria', $id);
        
        $query = $this->db->get('cat_servicios_categorias');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_categoria($id)
    {
        $this->db->where('id_servicio_categoria', $id);
        $this->db->delete('cat_servicios_categorias');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_categoria()
    {
        $this->db->where('nombre_servicio_categoria', $this->input->post('nombre_servicio_categoria'));
        $this->db->where('id_servicio_clasificacion', $this->input->post('id_servicio_clasificacion'));
        
        $query = $this->db->get('cat_servicios_categorias');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_servicio_categoria' => '',
                'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
                'nombre_servicio_categoria' => $this->input->post('nombre_servicio_categoria'),
                'titulo_grafica' => $this->input->post('titulo_grafica'),
                'color_grafica' => $this->input->post('color_grafica'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_servicios_categorias', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_categoria()
    {
        $this->db->where('nombre_servicio_categoria', $this->input->post('nombre_servicio_categoria'));
        $this->db->where('id_servicio_clasificacion', $this->input->post('id_servicio_clasificacion'));
        $this->db->where_not_in('id_servicio_categoria', $this->input->post('id_servicio_categoria'));
        $query = $this->db->get('cat_servicios_categorias');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
                'nombre_servicio_categoria' => $this->input->post('nombre_servicio_categoria'),
                'titulo_grafica' => $this->input->post('titulo_grafica'),
                'color_grafica' => $this->input->post('color_grafica'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_servicio_categoria', $this->input->post('id_servicio_categoria'));
            $this->db->update('cat_servicios_categorias', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todas_subcategorias()
    {
        $query = $this->db->get('cat_servicios_subcategorias');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $categoria = $this->dame_categoria_id($row['id_servicio_categoria']);

                    $array_items[$cont]['id_servicio_categoria'] = $row['id_servicio_categoria'];
                    $array_items[$cont]['id_servicio_subcategoria'] = $row['id_servicio_subcategoria'];
                    $array_items[$cont]['nombre_servicio_subcategoria'] = $row['nombre_servicio_subcategoria'];
                    $array_items[$cont]['nombre_servicio_categoria'] = $categoria != '' ? $categoria['nombre_servicio_categoria'] : '';
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_subcategorias()
    {
        $filename = 'dist/csv/subcategorias.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_servicios_subcategorias');
        $csv_header = array('#',
                    utf8_decode('Categorías del servicio'),
                    utf8_decode('Subcategorías del servicio'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $categoria = $this->dame_categoria_id($row['id_servicio_categoria']);
                $csv = array(
                    utf8_decode($row['id_servicio_subcategoria']),
                    utf8_decode($categoria != '' ? $categoria['nombre_servicio_categoria'] : ''),
                    utf8_decode($row['nombre_servicio_subcategoria']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_subcategoria_id($id)
    {
        $this->db->where('id_servicio_subcategoria', $id);
        
        $query = $this->db->get('cat_servicios_subcategorias');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_subcategoria($id)
    {
        $this->db->where('id_servicio_subcategoria', $id);
        $this->db->delete('cat_servicios_subcategorias');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_subcategoria()
    {
        $this->db->where('nombre_servicio_subcategoria', $this->input->post('nombre_servicio_subcategoria'));
        $this->db->where('id_servicio_categoria', $this->input->post('id_servicio_categoria'));
        
        $query = $this->db->get('cat_servicios_subcategorias');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_servicio_subcategoria' => '',
                'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
                'nombre_servicio_subcategoria' => $this->input->post('nombre_servicio_subcategoria'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_servicios_subcategorias', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_subcategoria()
    {
        $this->db->where('nombre_servicio_subcategoria', $this->input->post('nombre_servicio_subcategoria'));
        $this->db->where('id_servicio_categoria', $this->input->post('id_servicio_categoria'));
        $this->db->where_not_in('id_servicio_subcategoria', $this->input->post('id_servicio_subcategoria'));
        $query = $this->db->get('cat_servicios_subcategorias');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
                'nombre_servicio_subcategoria' => $this->input->post('nombre_servicio_subcategoria'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_servicio_subcategoria', $this->input->post('id_servicio_subcategoria'));
            $this->db->update('cat_servicios_subcategorias', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todas_unidades()
    {
        $query = $this->db->get('cat_servicios_unidades');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                    $subcategoria = $this->dame_subcategoria_id($row['id_servicio_subcategoria']);

                    $array_items[$cont]['id_servicio_unidad'] = $row['id_servicio_unidad'];
                    $array_items[$cont]['id_servicio_subcategoria'] = $row['id_servicio_subcategoria'];
                    $array_items[$cont]['nombre_servicio_unidad'] = $row['nombre_servicio_unidad'];
                    $array_items[$cont]['nombre_servicio_subcategoria'] = $subcategoria != '' ? $subcategoria['nombre_servicio_subcategoria'] : '';
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_unidades()
    {
        $filename = 'dist/csv/unidades.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_servicios_unidades');
        $csv_header = array('#',
                    utf8_decode('Subcategorías del servicio'),
                    utf8_decode('Unidades del servicio'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $subcategoria = $this->dame_subcategoria_id($row['id_servicio_subcategoria']);
                $csv = array(
                    utf8_decode($row['id_servicio_unidad']),
                    utf8_decode($subcategoria != '' ? $subcategoria['nombre_servicio_subcategoria'] : ''),
                    utf8_decode($row['nombre_servicio_unidad']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_unidad_id($id)
    {
        $this->db->where('id_servicio_unidad', $id);
        
        $query = $this->db->get('cat_servicios_unidades');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_unidad($id)
    {
        $this->db->where('id_servicio_unidad', $id);
        $this->db->delete('cat_servicios_unidades');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_unidad()
    {
        $this->db->where('nombre_servicio_unidad', $this->input->post('nombre_servicio_unidad'));
        $this->db->where('id_servicio_subcategoria', $this->input->post('id_servicio_subcategoria'));
        
        $query = $this->db->get('cat_servicios_unidades');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_servicio_unidad' => '',
                'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
                'nombre_servicio_unidad' => $this->input->post('nombre_servicio_unidad'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_servicios_unidades', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_unidad()
    {
        $this->db->where('nombre_servicio_unidad', $this->input->post('nombre_servicio_unidad'));
        $this->db->where('id_servicio_subcategoria', $this->input->post('id_servicio_subcategoria'));
        $this->db->where_not_in('id_servicio_unidad', $this->input->post('id_servicio_unidad'));
        $query = $this->db->get('cat_servicios_unidades');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
                'nombre_servicio_unidad' => $this->input->post('nombre_servicio_unidad'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_servicio_unidad', $this->input->post('id_servicio_unidad'));
            $this->db->update('cat_servicios_unidades', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todas_atribuciones()
    {
        $query = $this->db->get('cat_so_atribucion');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_so_atribucion'] = $row['id_so_atribucion'];
                    $array_items[$cont]['nombre_so_atribucion'] = $row['nombre_so_atribucion'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_atribuciones()
    {
        $filename = 'dist/csv/atribuciones.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_so_atribucion');
        $csv_header = array('#',
                    utf8_decode('Funciónes del sujeto obligado'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_so_atribucion']),
                    utf8_decode($row['nombre_so_atribucion']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_atribucion_id($id)
    {
        $this->db->where('id_so_atribucion', $id);
        
        $query = $this->db->get('cat_so_atribucion');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_atribucion($id)
    {
        $this->db->where('id_so_atribucion', $id);
        $this->db->delete('cat_so_atribucion');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_atribucion()
    {
        $this->db->where('nombre_so_atribucion', $this->input->post('nombre_so_atribucion'));
        
        $query = $this->db->get('cat_so_atribucion');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_so_atribucion' => '',
                'nombre_so_atribucion' => $this->input->post('nombre_so_atribucion'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_so_atribucion', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_atribucion()
    {

        $this->db->where('nombre_so_atribucion', $this->input->post('nombre_so_atribucion'));
        $this->db->where_not_in('id_so_atribucion', $this->input->post('id_so_atribucion'));
        $query = $this->db->get('cat_so_atribucion');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_so_atribucion' => $this->input->post('nombre_so_atribucion'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_so_atribucion', $this->input->post('id_so_atribucion'));
            $this->db->update('cat_so_atribucion', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_estados()
    {
        $query = $this->db->get('cat_so_estados');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_so_estado'] = $row['id_so_estado'];
                    $array_items[$cont]['nombre_so_estado'] = $row['nombre_so_estado'];
                    $array_items[$cont]['codigo_so_estado'] = $row['codigo_so_estado'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_estados()
    {
        $filename = 'dist/csv/estados.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_so_estados');
        $csv_header = array('#',
                    utf8_decode('Nombre del estado'),
                    utf8_decode('Código del estado'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_so_estado']),
                    utf8_decode($row['nombre_so_estado']),
                    utf8_decode($row['codigo_so_estado']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_estado_id($id)
    {
        $this->db->where('id_so_estado', $id);
        
        $query = $this->db->get('cat_so_estados');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_estado($id)
    {
        $this->db->where('id_so_estado', $id);
        $this->db->delete('cat_so_estados');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_estado()
    {
        $this->db->where('nombre_so_estado', $this->input->post('nombre_so_estado'));
        
        $query = $this->db->get('cat_so_estados');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_so_estado' => '',
                'nombre_so_estado' => $this->input->post('nombre_so_estado'),
                'codigo_so_estado' => $this->input->post('codigo_so_estado'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_so_estados', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_estado()
    {

        $this->db->where('nombre_so_estado', $this->input->post('nombre_so_estado'));
        $this->db->where_not_in('id_so_estado', $this->input->post('id_so_estado'));
        $query = $this->db->get('cat_so_estados');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_so_estado' => $this->input->post('nombre_so_estado'),
                'codigo_so_estado' => $this->input->post('codigo_so_estado'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_so_estado', $this->input->post('id_so_estado'));
            $this->db->update('cat_so_estados', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_ordenes()
    {
        $query = $this->db->get('cat_so_ordenes_gobierno');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_so_orden_gobierno'] = $row['id_so_orden_gobierno'];
                    $array_items[$cont]['nombre_so_orden_gobierno'] = $row['nombre_so_orden_gobierno'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_ordenes()
    {
        $filename = 'dist/csv/ordenes_gobierno.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_so_ordenes_gobierno');
        $csv_header = array('#',
                    utf8_decode('Órdenes de gobierno'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_so_orden_gobierno']),
                    utf8_decode($row['nombre_so_orden_gobierno']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_orden_id($id)
    {
        $this->db->where('id_so_orden_gobierno', $id);
        
        $query = $this->db->get('cat_so_ordenes_gobierno');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_orden($id)
    {
        $this->db->where('id_so_orden_gobierno', $id);
        $this->db->delete('cat_so_ordenes_gobierno');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_orden()
    {
        $this->db->where('nombre_so_orden_gobierno', $this->input->post('nombre_so_orden_gobierno'));
        
        $query = $this->db->get('cat_so_ordenes_gobierno');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_so_orden_gobierno' => '',
                'nombre_so_orden_gobierno' => $this->input->post('nombre_so_orden_gobierno'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_so_ordenes_gobierno', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_orden()
    {
        $this->db->where('nombre_so_orden_gobierno', $this->input->post('nombre_so_orden_gobierno'));
        $this->db->where_not_in('id_so_orden_gobierno', $this->input->post('id_so_orden_gobierno'));
        $query = $this->db->get('cat_so_ordenes_gobierno');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_so_orden_gobierno' => $this->input->post('nombre_so_orden_gobierno'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_so_orden_gobierno', $this->input->post('id_so_orden_gobierno'));
            $this->db->update('cat_so_ordenes_gobierno', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_presupuestos()
    {
        $query = $this->db->get('cat_presupuesto_conceptos');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_presupesto_concepto'] = $row['id_presupesto_concepto'];
                    $array_items[$cont]['capitulo'] = $row['capitulo'];
                    $array_items[$cont]['concepto'] = $row['concepto'];
                    $array_items[$cont]['partida'] = $row['partida'];
                    $array_items[$cont]['denominacion'] = $row['denominacion'];
                    $array_items[$cont]['descripcion'] = $row['descripcion'];
                    $array_items[$cont]['id_captura'] = $this->get_estatus_captura($row['id_captura']);
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function dame_todos_presupuestos_active()
    {        
        $this->db->where('active', '1');
        $query = $this->db->get('cat_presupuesto_conceptos');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_presupesto_concepto'] = $row['id_presupesto_concepto'];
                    $array_items[$cont]['capitulo'] = $row['capitulo'];
                    $array_items[$cont]['concepto'] = $row['concepto'];
                    $array_items[$cont]['partida'] = $row['partida'];
                    $array_items[$cont]['denominacion'] = $row['denominacion'];
                    $array_items[$cont]['descripcion'] = $row['descripcion'];
                    $array_items[$cont]['id_captura'] = $this->get_estatus_captura($row['id_captura']);
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function dame_presupuestos_concepto_nombre($id)
    {
        $this->db->where('id_presupesto_concepto', $id);
        $query = $this->db->get('cat_presupuesto_conceptos');
        

        if ($query->num_rows() == 1)
        {
            $registro = [];
            foreach ($query->result_array() as $row) { 
                $registro['id_presupesto_concepto'] = $row['id_presupesto_concepto'];
                $registro['nombre'] = $row['capitulo'] . ' - ' . $row['concepto'] . ' - ' . $row['partida'] . ' - ' . $row['denominacion'];
            }
            return $registro['nombre'];
        }else{
            return '';
        }
    }

    function descarga_presupuestos()
    {
        $filename = 'dist/csv/partidas_presupuestarias.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_presupuesto_conceptos');
        $csv_header = array('#',
                    utf8_decode('Capítulo'),
                    utf8_decode('Concepto'),
                    utf8_decode('Partida'),
                    utf8_decode('Denominación'),
                    utf8_decode('Descripción'),
                    utf8_decode('Captura'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_presupesto_concepto']),
                    utf8_decode($row['capitulo']),
                    utf8_decode($row['concepto']),
                    utf8_decode($row['partida']),
                    utf8_decode($row['denominacion']),
                    utf8_decode($row['descripcion']),
                    utf8_decode($this->get_estatus_captura($row['id_captura'])),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_presupuesto_id($id)
    {
        $this->db->where('id_presupesto_concepto', $id);
        
        $query = $this->db->get('cat_presupuesto_conceptos');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function get_presupuesto_id($id)
    {
        $this->db->where('id_presupesto_concepto', $id);
        
        $query = $this->db->get('cat_presupuesto_conceptos');
        
        if ($query->num_rows() == 1)
        {
            $presupuesto = '';
            foreach ($query->result_array() as $row) { 
                $presupuesto = array( 
                    'id_presupesto_concepto' => $row['id_presupesto_concepto'],
                    'capitulo' => $row['capitulo'],
                    'concepto' => $row['concepto'],
                    'partida' =>$row['partida'],
                    'denominacion' => $row['denominacion'],
                    'descripcion' => $row['descripcion'],
                    'id_captura' => $this->get_estatus_captura($row['id_captura']),
                    'active' => $this->get_estatus_name($row['active'])
                ); 
            }
            return $presupuesto;
        }else{
            return '';
        }
    }

    function eliminar_presupuesto($id)
    {
        $this->db->where('id_presupesto_concepto', $id);
        $this->db->delete('cat_presupuesto_conceptos');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_presupuesto()
    {
        $this->db->where('capitulo', $this->input->post('capitulo'));
        $this->db->where('concepto', $this->input->post('concepto'));
        $this->db->where('partida', $this->input->post('partida'));
        $this->db->where('denominacion', $this->input->post('denominacion'));
        $this->db->where('descripcion', $this->input->post('descripcion'));

        $query = $this->db->get('cat_presupuesto_conceptos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_presupesto_concepto' => '',
                'capitulo' => $this->input->post('capitulo'),
                'concepto' => $this->input->post('concepto'),
                'partida' => $this->input->post('partida'),
                'denominacion' => $this->input->post('denominacion'),
                'descripcion' => $this->input->post('descripcion'),
                'id_captura' => $this->input->post('id_captura'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_presupuesto_conceptos', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_presupuesto()
    {

        $this->db->where('capitulo', $this->input->post('capitulo'));
        $this->db->where('concepto', $this->input->post('concepto'));
        $this->db->where('partida', $this->input->post('partida'));
        $this->db->where('denominacion', $this->input->post('denominacion'));
        $this->db->where('descripcion', $this->input->post('descripcion'));
        $this->db->where_not_in('id_presupesto_concepto', $this->input->post('id_presupesto_concepto'));
        $query = $this->db->get('cat_presupuesto_conceptos');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'capitulo' => $this->input->post('capitulo'),
                'concepto' => $this->input->post('concepto'),
                'partida' => $this->input->post('partida'),
                'denominacion' => $this->input->post('denominacion'),
                'descripcion' => $this->input->post('descripcion'),
                'id_captura' => $this->input->post('id_captura'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_presupesto_concepto', $this->input->post('id_presupesto_concepto'));
            $this->db->update('cat_presupuesto_conceptos', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_trimestres()
    {
        $query = $this->db->get('cat_trimestres');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_trimestre'] = $row['id_trimestre'];
                    $array_items[$cont]['trimestre'] = $row['trimestre'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_trimestres()
    {
        $filename = 'dist/csv/trimestres.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_trimestres');
        $csv_header = array('#',
                    utf8_decode('Trimestre'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_trimestre']),
                    utf8_decode($row['trimestre']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_trimestre_id($id)
    {
        $this->db->where('id_trimestre', $id);
        
        $query = $this->db->get('cat_trimestres');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_trimestre($id)
    {
        $this->db->where('id_trimestre', $id);
        $this->db->delete('cat_trimestres');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_trimestre()
    {
        $this->db->where('trimestre', $this->input->post('trimestre'));
        
        $query = $this->db->get('cat_trimestres');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_trimestre' => '',
                'trimestre' => $this->input->post('trimestre'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_trimestres', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_trimestre()
    {

        $this->db->where('trimestre', $this->input->post('trimestre'));
        $this->db->where_not_in('id_trimestre', $this->input->post('id_trimestre'));
        $query = $this->db->get('cat_trimestres');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'trimestre' => $this->input->post('trimestre'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_trimestre', $this->input->post('id_trimestre'));
            $this->db->update('cat_trimestres', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_ejercicios($activos)
    {
        if($activos == true){
            $this->db->where('active', '1');
        }
        $query = $this->db->get('cat_ejercicios');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_ejercicio'] = $row['id_ejercicio'];
                    $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function dame_nombre_ejercicio($id)
    {
        $this->db->select('ejercicio');
        $this->db->where('id_ejercicio', $id);
        $query = $this->db->get('cat_ejercicios');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['ejercicio'];
        }else
        {
            return '';
        }
    }

    function dame_objetivo_nombre($id)
    {
        $this->db->where('id_campana_objetivo', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_campana_objetivos');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['campana_objetivo'];
        }else
        {
            return '';
        }
    }

    function descarga_ejercicios()
    {
        $filename = 'dist/csv/ejercicios.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_ejercicios');
        $csv_header = array('#',
                    utf8_decode('Ejercicio'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_ejercicio']),
                    utf8_decode($row['ejercicio']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_ejercicio_id($id)
    {
        $this->db->where('id_ejercicio', $id);
        
        $query = $this->db->get('cat_ejercicios');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_ejercicio($id)
    {
        $this->db->where('id_ejercicio', $id);
        $this->db->delete('cat_ejercicios');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_ejercicio()
    {
        $this->db->where('ejercicio', $this->input->post('ejercicio'));
        
        $query = $this->db->get('cat_ejercicios');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_ejercicio' => '',
                'ejercicio' => $this->input->post('ejercicio'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_ejercicios', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_ejercicio()
    {

        $this->db->where('ejercicio', $this->input->post('ejercicio'));
        $this->db->where_not_in('id_ejercicio', $this->input->post('id_ejercicio'));
        $query = $this->db->get('cat_ejercicios');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'ejercicio' => $this->input->post('ejercicio'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_ejercicio', $this->input->post('id_ejercicio'));
            $this->db->update('cat_ejercicios', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_personalidades($activos)
    {
        if($activos == true){
            $this->db->where('active', '1');
        }
        $query = $this->db->get('cat_personalidad_juridica');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_personalidad_juridica'] = $row['id_personalidad_juridica'];
                    $array_items[$cont]['nombre_personalidad_juridica'] = $row['nombre_personalidad_juridica'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_personalidades()
    {
        $filename = 'dist/csv/personalidad_juridica.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_personalidad_juridica');
        $csv_header = array('#',
                    utf8_decode('Personalidad jurídica'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_personalidad_juridica']),
                    utf8_decode($row['nombre_personalidad_juridica']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_personalidad_id($id)
    {
        $this->db->where('id_personalidad_juridica', $id);
        
        $query = $this->db->get('cat_personalidad_juridica');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_personalidad($id)
    {
        $this->db->where('id_personalidad_juridica', $id);
        $this->db->delete('cat_personalidad_juridica');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_personalidad()
    {
        $this->db->where('nombre_personalidad_juridica', $this->input->post('nombre_personalidad_juridica'));
        
        $query = $this->db->get('cat_personalidad_juridica');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_personalidad_juridica' => '',
                'nombre_personalidad_juridica' => $this->input->post('nombre_personalidad_juridica'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_personalidad_juridica', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_personalidad()
    {

        $this->db->where('nombre_personalidad_juridica', $this->input->post('nombre_personalidad_juridica'));
        $this->db->where_not_in('id_personalidad_juridica', $this->input->post('id_personalidad_juridica'));
        $query = $this->db->get('cat_personalidad_juridica');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_personalidad_juridica' => $this->input->post('nombre_personalidad_juridica'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_personalidad_juridica', $this->input->post('id_personalidad_juridica'));
            $this->db->update('cat_personalidad_juridica', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_nombre_personalidad_juridica($id)
    {
        $this->db->select('nombre_personalidad_juridica');
        $this->db->where('id_personalidad_juridica', $id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_personalidad_juridica');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_personalidad_juridica'];
        }else
        {
            return '';
        }
    }

    function dame_todos_procedimientos($activos)
    {
        if($activos == true){
            $this->db->where('active', '1');
        }
        $query = $this->db->get('cat_procedimientos');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_procedimiento'] = $row['id_procedimiento'];
                    $array_items[$cont]['nombre_procedimiento'] = $row['nombre_procedimiento'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_procedimientos()
    {
        $filename = 'dist/csv/procedimientos_contratacion.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_procedimientos');
        $csv_header = array('#',
                    utf8_decode('Procedimiento de contratación'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_procedimiento']),
                    utf8_decode($row['nombre_procedimiento']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_procedimiento_id($id)
    {
        $this->db->where('id_procedimiento', $id);
        
        $query = $this->db->get('cat_procedimientos');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_procedimiento($id)
    {
        $this->db->where('id_procedimiento', $id);
        $this->db->delete('cat_procedimientos');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_procedimiento()
    {
        $this->db->where('nombre_procedimiento', $this->input->post('nombre_procedimiento'));
        
        $query = $this->db->get('cat_procedimientos');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_procedimiento' => '',
                'nombre_procedimiento' => $this->input->post('nombre_procedimiento'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_procedimientos', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_procedimiento()
    {

        $this->db->where('nombre_procedimiento', $this->input->post('nombre_procedimiento'));
        $this->db->where_not_in('id_procedimiento', $this->input->post('id_procedimiento'));
        $query = $this->db->get('cat_procedimientos');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'nombre_procedimiento' => $this->input->post('nombre_procedimiento'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_procedimiento', $this->input->post('id_procedimiento'));
            $this->db->update('cat_procedimientos', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }

    function dame_todos_ligas($activos)
    {
        if($activos == true){
            $this->db->where('active', '1');
        }
        $query = $this->db->get('cat_tipo_liga');
        
        if($query->num_rows() > 0)
        {
            $array_items = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
    
                    $array_items[$cont]['id_tipo_liga'] = $row['id_tipo_liga'];
                    $array_items[$cont]['tipo_liga'] = $row['tipo_liga'];
                    $array_items[$cont]['active'] = $this->get_estatus_name($row['active']);
                    $cont++;
            }
            return $array_items;
        }
    }

    function descarga_ligas()
    {
        $filename = 'dist/csv/tipos_ligas.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $query = $this->db->get('cat_tipo_liga');
        $csv_header = array('#',
                    utf8_decode('Tipo de liga'),
                    'Estatus');
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($row['id_tipo_liga']),
                    utf8_decode($row['tipo_liga']),
                    utf8_decode($this->get_estatus_name($row['active']))
                );
                fputcsv($myfile, $csv);
            }
        }

        fclose($myfile);

        return $filename;
    }

    function dame_liga_id($id)
    {
        $this->db->where('id_tipo_liga', $id);
        
        $query = $this->db->get('cat_tipo_liga');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }else{
            return '';
        }
    }

    function eliminar_liga($id)
    {
        $this->db->where('id_tipo_liga', $id);
        $this->db->delete('cat_tipo_liga');
        
        if($this->db->affected_rows() > 0)
        {
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }

    function agregar_liga()
    {
        $this->db->where('tipo_liga', $this->input->post('tipo_liga'));
        
        $query = $this->db->get('cat_tipo_liga');

        if($query->num_rows() > 0){
            return 2; // field is duplicated
        }else{
            $data_new = array(
                'id_tipo_liga' => '',
                'tipo_liga' => $this->input->post('tipo_liga'),
                'active' => $this->input->post('active'),
            );
            
            $this->db->insert('cat_tipo_liga', $data_new);
    
            if($this->db->affected_rows() > 0)
            {
                return 1; // is correct
            }else
            {
                return 0; // sometime is wrong
            }
        }
    }

    function editar_liga()
    {

        $this->db->where('tipo_liga', $this->input->post('tipo_liga'));
        $this->db->where_not_in('id_tipo_liga', $this->input->post('id_tipo_liga'));
        $query = $this->db->get('cat_tipo_liga');

        if($query->num_rows() > 0 ){
            return 2; // field is duplicated
        }else{
            $data_update = array(
                'tipo_liga' => $this->input->post('tipo_liga'),
                'active' => $this->input->post('active'),
            );
    
            $this->db->where('id_tipo_liga', $this->input->post('id_tipo_liga'));
            $this->db->update('cat_tipo_liga', $data_update);
    
            if($this->db->affected_rows() > 0)
            {
                return 1;
            }else
            {
                return 0;
            }
        }
    }
}

?>