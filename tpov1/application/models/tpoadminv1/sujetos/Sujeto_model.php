<?php

/* 
INAI / SUJETO MODEL
*/

class Sujeto_Model extends CI_Model
{
    function guardar_bitacora($accion)
    {
        $data = array(
            'id_bitacora' => '0',
            'usuario_bitacora' => $this->session->userdata('usuario_id'),
            'seccion_bitacora' => 'Sujetos Obligados',
            'accion_bitacora' => $accion,
            'fecha_bitacora' => date("Y-m-d H:i:s")
        );

        $this->db->insert('bitacora', $data);
        
        if($this->db->affected_rows() > 0)
        {
            return 1; 
        }
    }

    function get_estatus_nombre($estatus)
    {
        switch ($estatus) 
        {
            case '1':  return 'Activo';
                break;
            case '2':  return 'Inactivo';
                break;
            default: return 'Otro';
                break;
        }
    }

    function dame_todos_sujetos()
    {
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if($query->num_rows() > 0)
        {
            $array_sujetos = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {   $array_sujetos[$cont]['conteo'] = $cont+1;
                $array_sujetos[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $array_sujetos[$cont]['id_so_atribucion'] = $row['id_so_atribucion'];
                $array_sujetos[$cont]['funcion'] = $this->dame_atribucion_nombre($row['id_so_atribucion']);
                $array_sujetos[$cont]['orden'] = $this->dame_orden_nombre($row['id_so_orden_gobierno']);
                $array_sujetos[$cont]['estado'] = $this->dame_estado_nombre($row['id_so_estado']);
                $array_sujetos[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                $array_sujetos[$cont]['siglas_sujeto_obligado'] = $row['siglas_sujeto_obligado'];
				$array_sujetos[$cont]['url_sujeto_obligado'] = $row['url_sujeto_obligado'];
				$array_sujetos[$cont]['estatus'] = $this->get_estatus_nombre($row['active']);
                $cont++;
            }
            return $array_sujetos;
        }
    }

    function dame_estado_nombre($estado_id)
    {
        $this->db->select('nombre_so_estado');
        $this->db->where('id_so_estado', $estado_id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_estados');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_so_estado'];
        }
        
    }

    function dame_orden_nombre($orden_id)
    {
        $this->db->select('nombre_so_orden_gobierno');
        $this->db->where('id_so_orden_gobierno', $orden_id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_ordenes_gobierno');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_so_orden_gobierno'];
        }
        
    }

    function dame_atribucion_nombre($atribucion_id)
    {
        $this->db->select('nombre_so_atribucion');
        $this->db->where('id_so_atribucion', $atribucion_id);
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_atribucion');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row){
            }
            return $row['nombre_so_atribucion'];
        }
        
    }

    function dame_todos_estados()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_estados');
        
        if($query->num_rows() > 0)
        {
            $array_estados = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_estados[$cont]['id_so_estado'] = $row['id_so_estado'];
                $array_estados[$cont]['nombre_so_estado'] = $row['nombre_so_estado'];
                $array_estados[$cont]['codigo_so_estado'] = $row['codigo_so_estado'];
                $cont++;
            }
            return $array_estados;
        }
    }

    function dame_todos_ordenes()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_ordenes_gobierno');
        
        if($query->num_rows() > 0)
        {
            $array_estados = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_estados[$cont]['id_so_orden_gobierno'] = $row['id_so_orden_gobierno'];
                $array_estados[$cont]['nombre_so_orden_gobierno'] = $row['nombre_so_orden_gobierno'];
                $array_estados[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_estados;
        }
    }

    function dame_todos_funciones()
    {
        $this->db->where('active', '1');
        $query = $this->db->get('cat_so_atribucion');
        
        if($query->num_rows() > 0)
        {
            $array_atribucion = [];
            $cont = 0;
            foreach ($query->result_array() as $row) 
            {
                $array_atribucion[$cont]['id_so_atribucion'] = $row['id_so_atribucion'];
                $array_atribucion[$cont]['nombre_so_atribucion'] = $row['nombre_so_atribucion'];
                $array_atribucion[$cont]['active'] = $row['active'];
                $cont++;
            }
            return $array_atribucion;
        }
    }

    function get_sujeto_id($sujeto_id)
    {
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $this->db->where('id_sujeto_obligado', $sujeto_id);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if ($query->num_rows() == 1)
        {
            $info_sujeto = [];

            foreach ($query->result_array() as $row)
            {
                $info_sujeto['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                $info_sujeto['estado'] = $this->dame_estado_nombre($row['id_so_estado']);
                $info_sujeto['orden'] = $this->dame_orden_nombre($row['id_so_orden_gobierno']);
                $info_sujeto['atribucion'] = $this->dame_atribucion_nombre($row['id_so_atribucion']);
                $info_sujeto['nombre'] = $row['nombre_sujeto_obligado'];
                $info_sujeto['siglas'] = $row['siglas_sujeto_obligado'];
                $info_sujeto['url'] = $row['url_sujeto_obligado'];
                $info_sujeto['estatus'] = $this->get_estatus_nombre($row['active']);
            }
            return $info_sujeto;
        }

    }

    function dame_sujeto_id($sujeto_id)
    {
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $this->db->where('id_sujeto_obligado', $sujeto_id);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if ($query->num_rows() == 1)
        {
            foreach ($query->result_array() as $row) { }
            return $row;
        }
        
    }

    function descarga_sujetos()
    {
        $filename = 'dist/csv/sujetos.csv';
        $myfile = fopen(FCPATH . $filename, 'w');
        
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $query = $this->db->get('tab_sujetos_obligados');
        $csv_header = array('#',
                    utf8_decode('Función'),
                    'Orden',
                    'Nombre',
                    'Siglas',
                    utf8_decode('URL Página'),
                    'Estatus'
                );
        fputcsv($myfile, $csv_header);
        
        $csv = [];
        if($query->num_rows() > 0)
        {
            $cont = 1;
            foreach ($query->result_array() as $row) 
            {
                $csv = array(
                    utf8_decode($cont),
                    utf8_decode($this->dame_atribucion_nombre($row['id_so_atribucion'])),
                    utf8_decode($this->dame_orden_nombre($row['id_so_orden_gobierno'])),
                    utf8_decode($row['nombre_sujeto_obligado']),
                    utf8_decode($row['siglas_sujeto_obligado']),
                    utf8_decode($row['url_sujeto_obligado']),
                    utf8_decode($this->get_estatus_nombre($row['active']))
                );
                fputcsv($myfile, $csv);
                $cont += 1;
            }
        }

        fclose($myfile);
        return $filename;
    }


    function elimina_sujeto($id_sujeto_obligado)
    {
        $sujeto_eliminado = $this->dame_sujeto_id($id_sujeto_obligado);
        $this->db->where('id_sujeto_obligado', $id_sujeto_obligado);
        $this->db->delete('tab_sujetos_obligados');
        
        if($this->db->affected_rows() > 0)
        {
            $this->guardar_bitacora('Eliminación del sujeto obligado: ' . $sujeto_eliminado['nombre_sujeto_obligado']);
            return 1; // is correct
        }else
        {
            return 0; // sometime is wrong
        }
    }


    function alta_sujeto()
    {
        //Validamos que no exista un sujeto obligado con el nombre 
        $this->db->where('nombre_sujeto_obligado', $this->input->post('nombre_sujeto_obligado'));
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if ($query->num_rows() > 0)
        {
            return 2;
        }
        
        $data = array(
            'id_sujeto_obligado' => '0',
            'id_so_atribucion' => $this->input->post('id_so_atribucion'),
            'id_so_orden_gobierno' => $this->input->post('id_so_orden_gobierno'),
            'id_so_estado' => $this->input->post('id_so_estado'),
            'nombre_sujeto_obligado' => $this->input->post('nombre_sujeto_obligado'),
            'siglas_sujeto_obligado' => $this->input->post('siglas_sujeto_obligado'),
            'url_sujeto_obligado' => $this->input->post('url_sujeto_obligado'),
            'active' => '1'
        );

        $this->db->insert('tab_sujetos_obligados', $data);
        
        if($this->db->affected_rows() > 0)
        {
            //Guardamos accion en la bitacora
            $bitacora = $this->guardar_bitacora('Alta Sujeto Obligado: '.$this->input->post('nombre_sujeto_obligado'));
            if($bitacora == '1')
            {
                return 1; 
            }
        }
    }



    function edita_sujeto()
    {
        $this->db->where('id_sujeto_obligado !=', $this->input->post('id_sujeto_obligado'));
        $this->db->where('nombre_sujeto_obligado', $this->input->post('nombre_sujeto_obligado'));
        $estatus = array('1', '2');
        $this->db->where_in('active', $estatus);
        $query = $this->db->get('tab_sujetos_obligados');
        
        if ($query->num_rows() > 0)
        {
            return 2;
        }

        $data = array(
            'id_so_atribucion' => $this->input->post('id_so_atribucion'),
            'id_so_orden_gobierno' => $this->input->post('id_so_orden_gobierno'),
            'id_so_estado' => $this->input->post('id_so_estado'),
            'nombre_sujeto_obligado' => $this->input->post('nombre_sujeto_obligado'),
            'siglas_sujeto_obligado' => $this->input->post('siglas_sujeto_obligado'),
            'url_sujeto_obligado' => $this->input->post('url_sujeto_obligado'),
            'active' => $this->input->post('active')
        );
        
        $this->db->where('id_sujeto_obligado', $this->input->post('id_sujeto_obligado'));
        $this->db->update('tab_sujetos_obligados', $data);
        
        if($this->db->affected_rows() > 0)
        {
            $bitacora = $this->guardar_bitacora('Actualización Sujeto Obligado: '.$this->input->post('nombre_sujeto_obligado'));
            if($bitacora == '1')
            {
                return 1;   //Se ha actualizado correctamente
            }
        }
    }


}