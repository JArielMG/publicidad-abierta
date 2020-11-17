<?php

/*
* INAI / Tablas información de vista publica
* Se listan los metodos que hacen uso de vistas/mysql
*/

class Tablas_model extends CI_Model
{

    /* Tabla de contratos asociados a un sujeto obligado */
    function get_contratos_so($nombre_sujeto_obligado, $ejercicio){
        
        $this->load->model('tpoadminv1/Generales_model');

        if(!empty($ejercicio)){
            $this->db->where('ejercicio', $ejercicio);
        }

        $this->db->where('contratante', $nombre_sujeto_obligado);
        $query = $this->db->get('vlista_contratos');
        
        $array_items = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_contrato'] = $row['id_contrato'];
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['trimestre'] = $row['trimestre'];
                $array_items[$cont]['numero_contrato'] = $row['numero_contrato'];
                $array_items[$cont]['nombre_so_solicitante'] = $row['solicitante'];
                $array_items[$cont]['nombre_so_contratante'] = $row['contratante'];
                $array_items[$cont]['nombre_proveedor'] = $row['proveedor'];
                $array_items[$cont]['monto_contrato'] = $this->Generales_model->money_format("%.2n", $row['monto_contrato']);
                $array_items[$cont]['monto_ejercido'] = $this->Generales_model->money_format("%.2n", $row['monto_ejercido']);
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/contratos_ordenes/contrato_detalle/" . $row['id_contrato'];
                $cont++;
            }
        }

        return $array_items;

    }

    /* Tabla de ordenes de compra asociadas a un sujeto obligado */
    function get_ordenes_compra_so($nombre_sujeto_obligado, $ejercicio){
        
        $this->load->model('tpoadminv1/Generales_model');

        if(!empty($ejercicio)){
            $this->db->where('ejercicio', $ejercicio);
        }

        $this->db->where('contratante', $nombre_sujeto_obligado);
        $query = $this->db->get('vlista_oc');
        
        $array_items = [];
        if($query->num_rows() > 0)
        {
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['id_orden_compra'] = $row['id_orden_compra'];
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['trimestre'] = $row['trimestre'];
                $array_items[$cont]['numero_orden_compra'] = $row['numero_orden_compra'];
                $array_items[$cont]['nombre_so_solicitante'] = $row['solicitante'];
                $array_items[$cont]['nombre_so_contratante'] = $row['contratante'];
                $array_items[$cont]['nombre_proveedor'] = $row['proveedor'];
                $array_items[$cont]['monto_ejercido'] = $this->Generales_model->money_format("%.2n", $row['monto_ejercido']);
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/contratos_ordenes/orden_detalle/" . $row['id_orden_compra'];
                $cont++;
            }
        }

        return $array_items;

    }

    /* Tabla de sujetos obligados */

    function get_sujetos_montos($id_ejercicio)
    {
        $this->load->model('tpoadminv1/sujetos/Sujeto_model');
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $sujetos = $this->Sujeto_model->dame_todos_sujetos();

        $array_items = [];
        $ejercicio = ""; 
        if(!empty($id_ejercicio)){
            $ejercicio = $this->Catalogos_model->dame_nombre_ejercicio($id_ejercicio);
            if(sizeof($sujetos) > 0)
            {
                $cont = 0;
                foreach($sujetos as $row){
                    $monto = $this->get_so_monto($id_ejercicio, $row['id_so_atribucion'], $row['id_sujeto_obligado']);
                    $array_items[$cont]['id'] = $cont + 1;
                    $array_items[$cont]['ejercicio'] = $ejercicio;
                    $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                    $array_items[$cont]['funcion'] = $row['funcion'];
                    $array_items[$cont]['orden'] = $row['orden'];
                    $array_items[$cont]['estado'] = $row['estado'];
                    $array_items[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                    $array_items[$cont]['siglas_sujeto_obligado'] = $row['siglas_sujeto_obligado'];
                    $array_items[$cont]['url_sujeto_obligado'] = $row['url_sujeto_obligado'];
                    $array_items[$cont]['monto'] = $monto;
                    $array_items[$cont]['monto_formato'] = $this->Generales_model->money_format("%.2n", $monto);
                    $array_items[$cont]['link'] = base_url() . "index.php/tpov1/sujetos_obligados/detalle/".$row['id_sujeto_obligado'];
                    $cont += 1;
                }
            }
        }
        else {
            $lista_ejercicios = $this->Catalogos_model->dame_todos_ejercicios(true);
            if(!empty($lista_ejercicios) && sizeof($lista_ejercicios) > 0 && sizeof($sujetos) > 0){
                $cont = 0;
                foreach($lista_ejercicios as $ejercicio_aux){
                    foreach($sujetos as $row){
                        $monto = $this->get_so_monto($ejercicio_aux['id_ejercicio'], $row['id_so_atribucion'], $row['id_sujeto_obligado']);
                        $array_items[$cont]['id'] = $cont + 1;
                        $array_items[$cont]['ejercicio'] = $ejercicio_aux['ejercicio'];
                        $array_items[$cont]['id_sujeto_obligado'] = $row['id_sujeto_obligado'];
                        $array_items[$cont]['funcion'] = $row['funcion'];
                        $array_items[$cont]['orden'] = $row['orden'];
                        $array_items[$cont]['estado'] = $row['estado'];
                        $array_items[$cont]['nombre_sujeto_obligado'] = $row['nombre_sujeto_obligado'];
                        $array_items[$cont]['siglas_sujeto_obligado'] = $row['siglas_sujeto_obligado'];
                        $array_items[$cont]['url_sujeto_obligado'] = $row['url_sujeto_obligado'];
                        $array_items[$cont]['monto'] = $monto;
                        $array_items[$cont]['monto_formato'] = $this->Generales_model->money_format("%.2n", $monto);
                        $array_items[$cont]['link'] = base_url() . "index.php/tpov1/sujetos_obligados/detalle/".$row['id_sujeto_obligado'];
                        $cont += 1;
                    }
                }
            }
        }
        return $array_items;
    }

    function get_so_monto($id_ejercicio, $id_so_atribucion, $id_sujeto_obligado){
        
        $aux_ejercicio = "";
        if(!empty($id_ejercicio)){
            $aux_ejercicio = " a.id_ejercicio = " . $id_ejercicio . " and ";
        }
        $aux_so = '';
        switch($id_so_atribucion){
            case 1: // so_contratante
            case 3: // so_contratante_solicitante
                $aux_so = "
                    b.id_so_contratante = d.id_sujeto_obligado and
                    b.id_presupuesto_concepto is not null and
                ";
                break;
            case 2: // so_solicitante
                $aux_so = "
                    b.id_so_solicitante = d.id_sujeto_obligado and
                    b.id_presupuesto_concepto_solicitante is not null and
                ";
                break;
        }

        $sqltext = "
            select 
                a.id_ejercicio,
                d.id_sujeto_obligado,
                sum(b.monto_desglose) as monto
            from 
                tab_facturas as a,
                tab_facturas_desglose as b,
                vact_campana_aviso as c,
                vact_sujetos_obligados as d,
                cat_so_atribucion as e
            where
                a.id_factura = b.id_factura and
                b.id_campana_aviso = c.id_campana_aviso and
                " . $aux_so . "
                d.id_so_atribucion = e.id_so_atribucion and
                d.id_sujeto_obligado =  " . $id_sujeto_obligado . " and
                e.id_so_atribucion = " . $id_so_atribucion . " and
                " . $aux_ejercicio . "
                a.active = 1 and
                b.active = 1
            group by d.id_sujeto_obligado, a.id_ejercicio
        ";

        $query = $this->db->query( $sqltext );
        $monto = 0;
        if($query->num_rows() > 0)
        {
            foreach($query->result_array() as $row){}

            $monto = $row['monto'];
        }

        return $monto;

    }

    /* Tabla de erogaciones */

    function get_erogaciones($ejercicio)
    {
        $this->load->model('tpoadminv1/Generales_model');

        if(!empty($ejercicio)){
            $this->db->where('ejercicio', $ejercicio);
        }
        $query = $this->db->get('vfacturas');

        $array_items = [];
        if($query->num_rows() > 0){
            
            $cont = 0;
            foreach($query->result_array() as $row)
            {
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['trimestre'] = $row['trimestre'];
                $array_items[$cont]['proveedor'] = $row['proveedor'];
                $array_items[$cont]['numero_factura'] = $row['numero_factura'];
                $array_items[$cont]['fecha_erogacion'] = $row['fecha_erogacion'];
                $array_items[$cont]['monto'] = $this->Generales_model->money_format("%.2n", $row['monto_ejercido']);
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/erogaciones/detalle/" .$row['id_factura'];
                $cont += 1;
            }
        }
        return $array_items;
    }

    /* Sección de Contratos y ordenes de compra  -- detalle */
    function get_servicios_ordenes_gasto($id_orden_compra, $tipo_servicio)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_orden_compra', $id_orden_compra);
        $this->db->where('id_servicio_clasificacion', $tipo_servicio);
        $query = $this->db->get('vgasto_clasf_servicio');

        $array_items = [];
        $total = $query->num_rows(); 
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['factura'] = $row['factura'];
                $array_items[$cont]['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                $array_items[$cont]['proveedor'] = $row['proveedor'];
                $array_items[$cont]['nombre_servicio_categoria'] = $row['nombre_servicio_categoria'];
                $array_items[$cont]['nombre_servicio_subcategoria'] = $row['nombre_servicio_subcategoria'];
                $array_items[$cont]['tipo'] = $row['tipo'];
                $array_items[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $array_items[$cont]['monto_servicio'] = $this->Generales_model->money_format("%.2n", $row['monto_servicio']);
                $array_items[$cont]['link_factura'] = base_url() . "index.php/tpov1/erogaciones/detalle/" .$row['id_factura']; 
                $array_items[$cont]['link_proveedor'] = base_url() . "index.php/tpov1/proveedores/proveedor_detalle/" .$row['id_proveedor'];
                $array_items[$cont]['link_campana'] = base_url() ."index.php/tpov1/campana_aviso/campana_detalle/" .$row['id_campana_aviso'];
                $cont++;
            }
        }

        return $array_items;
    }

    /* Sección de Contratos y ordenes de compra -- detalle */
    function get_servicios_contratos_gasto($id_contrato, $tipo_servicio)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_contrato', $id_contrato);
        $this->db->where('id_servicio_clasificacion', $tipo_servicio);
        $query = $this->db->get('vgasto_clasf_servicio');

        $array_items = [];
        $total = $query->num_rows(); 
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['factura'] = $row['factura'];
                $array_items[$cont]['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                $array_items[$cont]['proveedor'] = $row['proveedor'];
                $array_items[$cont]['nombre_servicio_categoria'] = $row['nombre_servicio_categoria'];
                $array_items[$cont]['nombre_servicio_subcategoria'] = $row['nombre_servicio_subcategoria'];
                $array_items[$cont]['tipo'] = $row['tipo'];
                $array_items[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $array_items[$cont]['monto_servicio'] = $this->Generales_model->money_format("%.2n", $row['monto_servicio']);
                $array_items[$cont]['link_factura'] = base_url() . "index.php/tpov1/erogaciones/detalle/" .$row['id_factura'];
                $array_items[$cont]['link_proveedor'] = base_url() . "index.php/tpov1/proveedores/proveedor_detalle/" .$row['id_proveedor'];
                $array_items[$cont]['link_campana'] = base_url() . "index.php/tpov1/campana_aviso/campana_detalle/" .$row['id_campana_aviso'];
                $cont++;
            }
        }

        return $array_items;
    }

    /* Gasto relacionados a servicios -- detalle */
    function get_servicios_gasto($ejercicio)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        if(!empty($ejercicio)){
            $this->db->where('ejercicio', $ejercicio);
        }
        $query = $this->db->get('vgasto_clasf_servicio');

        $array_items = [];
        $total = $query->num_rows(); 
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['factura'] = $row['factura'];
                $array_items[$cont]['fecha_erogacion'] = $this->Generales_model->dateToString($row['fecha_erogacion']);
                $array_items[$cont]['proveedor'] = $row['proveedor'];
                $array_items[$cont]['nombre_servicio_clasificacion'] = $row['nombre_servicio_clasificacion'];
                $array_items[$cont]['nombre_servicio_categoria'] = $row['nombre_servicio_categoria'];
                $array_items[$cont]['nombre_servicio_subcategoria'] = $row['nombre_servicio_subcategoria'];
                $array_items[$cont]['tipo'] = $row['tipo'];
                $array_items[$cont]['nombre_campana_aviso'] = $row['nombre_campana_aviso'];
                $array_items[$cont]['monto_servicio'] = $this->Generales_model->money_format("%.2n", $row['monto_servicio']);
                $array_items[$cont]['link_factura'] = base_url() . "index.php/tpov1/erogaciones/detalle/" . $row['id_factura']; 
                $array_items[$cont]['link_proveedor'] = base_url() . "index.php/tpov1/proveedores/proveedor_detalle/" .$row['id_proveedor'];
                $array_items[$cont]['link_campana'] = base_url() . "index.php/tpov1/campana_aviso/campana_detalle/" .$row['id_campana_aviso'];
                $cont++;
            }
        }

        return $array_items;
    }

    /* Sesión de proveedores */
    /* Obtiene los contratos en base un proveedor */
    function get_contratos_proveedor($id_proveedor)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->where('id_contrato >', 1 );
        $this->db->where('active', 1 );
        $query = $this->db->get('tab_contratos');

        $array_items = [];
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $montos = $this->Contratos_model->getMontos($row['id_contrato'], $row['monto_contrato']);
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['so_contratante'] = $this->Contratos_model->dame_nombre_contratante($row['id_so_contratante']);
                $array_items[$cont]['so_solicitante'] = $this->Contratos_model->dame_nombre_solicitante($row['id_so_solicitante']);
                $array_items[$cont]['numero_contrato'] = $row['numero_contrato'];
                $array_items[$cont]['monto_contrato'] = $this->Generales_model->money_format("%.2n", $row['monto_contrato']);
                $array_items[$cont]['monto_modificado'] = $montos['monto_modificado'];
                $array_items[$cont]['monto_total'] = $montos['monto_total'];
                $array_items[$cont]['monto_pagado'] = $montos['monto_pagado'];
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/contratos_ordenes/contrato_detalle/" . $row['id_contrato'];
                $cont++;
            }
        }

        return $array_items;
    }

    /* Obtiene las ordenes de compra en base un proveedor */
    function get_ordenes_proveedor($id_proveedor)
    {
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/Generales_model');

        $this->db->where('id_proveedor', $id_proveedor);
        $this->db->where('id_orden_compra >', 1);
        $this->db->where('id_contrato', 1 );
        $query = $this->db->get('vact_ordenes_compra_montos');

        $array_items = [];
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont + 1;
                $array_items[$cont]['ejercicio'] = $this->Catalogos_model->dame_nombre_ejercicio($row['id_ejercicio']);
                $array_items[$cont]['trimestre'] = $this->Catalogos_model->dame_nombre_trimestre($row['id_trimestre']);
                $array_items[$cont]['numero_orden_compra'] = $row['numero_orden_compra'];
                $array_items[$cont]['proveedor'] = $this->Proveedores_model->dame_nombre_proveedor($row['id_trimestre']);
                $array_items[$cont]['nombre_campana_aviso'] = $this->Ordenes_compra_model->dame_nombre_campana_aviso($row['id_campana_aviso']);
                $array_items[$cont]['monto'] = $this->Generales_model->money_format("%.2n", $row['monto']);
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/contratos_ordenes/orden_detalle/" . $row['id_orden_compra'];
                $cont++;
            }
        }

        return $array_items;
    }

    /* Obtener los proveedores  */
    function get_valores_tabla_proveedores($ejercicio)
    {
        $this->load->model('tpoadminv1/Generales_model');

        if(!empty($ejercicio)){
            $this->db->where('ejercicio', $ejercicio);
        }
        $query = $this->db->get('vtab_proveedores');

        $array_items = [];
        if($query->num_rows() > 0){
            $cont = 0;
            foreach($query->result_array() as $row){
                $array_items[$cont]['id'] = $cont;
                $array_items[$cont]['link'] = base_url() . "index.php/tpov1/proveedores/proveedor_detalle/" . $row['id_proveedor'];
                $array_items[$cont]['ejercicio'] = $row['ejercicio'];
                $array_items[$cont]['nombre'] = $row['nombre'];
                $array_items[$cont]['contratos'] = $row['contratos'];
                $array_items[$cont]['ordenes'] = $row['ordenes'];
                $array_items[$cont]['monto_sin_formato'] = floatval($row['monto']);
                $array_items[$cont]['monto'] = $this->Generales_model->money_format("%.2n", $row['monto']);
                $cont++;
            }
        }
        
        return $array_items;
    }


    /* Consultas para la descarga de archivos PNT */

    function F70FXXIIIA()   //Formato A
    {
        $sqltext = "select 
            (select c.ejercicio from cat_ejercicios as c where c.id_ejercicio= a.id_ejercicio) as ejercicio,
            a.fecha_inicio_periodo,
			a.fecha_termino_periodo,
			a.denominacion as denominacion,
            a.fecha_publicacion as publicacion,
            a.file_programa_anual as hipervinculo,
            a.fecha_validacion as validacion,
            a.area_responsable as area_responsable,
            a.anio as periodo, 
            a.fecha_actualizacion as actualizacion,
            a.nota as nota
            from 
            tab_presupuestos as a";

        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }
    
    function F70FXXIIIB()   //Formato B
    {
        $sqltext = 'select
			(select h.ejercicio from cat_ejercicios as h where a.id_ejercicio=h.id_ejercicio)  as ejercicio,
			(select i.trimestre from cat_trimestres as i where a.id_trimestre=i.id_trimestre)  as trimestre, 
            a.id_trimestre,
            (select f.nombre_so_atribucion from cat_so_atribucion as f where c.id_so_atribucion=f.id_so_atribucion)  as funcion, 
            b.area_administrativa, 		
            (select g.nombre_servicio_clasificacion from cat_servicios_clasificacion as g where b.id_servicio_clasificacion=g.id_servicio_clasificacion) 
					as id_servicio_clasificacion, 
            (select j.nombre_servicio_categoria from cat_servicios_categorias as j where b.id_servicio_categoria=j.id_servicio_categoria ) 
					as id_servicio_categoria, 
            (select k.nombre_servicio_subcategoria from cat_servicios_subcategorias as k where b.id_servicio_subcategoria=k.id_servicio_subcategoria ) 
					as id_servicio_subcategoria, 
            b.descripcion_servicios, 
		   (select l.nombre_campana_tipo from cat_campana_tipos as l where d.id_campana_tipo=l.id_campana_tipo) as id_campana_tipo, 
			d.nombre_campana_aviso, 
            d.periodo, 
            (select n.nombre_campana_tema from cat_campana_temas as n where d.id_campana_tema=n.id_campana_tema)  as id_campana_tema, 
            (select o.campana_objetivo from cat_campana_objetivos as o where d.id_campana_objetivo=o.id_campana_objetivo)  as id_campana_objetivo, 
            d.objetivo_comunicacion, 
            b.precio_unitarios, 
            d.clave_campana, 
            d.autoridad, 
            (select p.nombre_campana_cobertura from cat_campana_coberturas as p where d.id_campana_cobertura = p.id_campana_cobertura) as id_campana_cobertura, 
            d.campana_ambito_geo,
            d.fecha_inicio, 
            d.fecha_termino, 
            (SELECT GROUP_CONCAT(g.nombre_poblacion_sexo SEPARATOR " * ") FROM rel_campana_sexo as f, cat_poblacion_sexo as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_sexo = g.id_poblacion_sexo ) as sexo, 

            (SELECT GROUP_CONCAT(f.poblacion_lugar SEPARATOR " * ") FROM rel_campana_lugar as f 
            WHERE  f.id_campana_aviso = b.id_campana_aviso) as lugar, 

            (SELECT GROUP_CONCAT(g.nombre_poblacion_nivel_educativo SEPARATOR " * ") FROM rel_campana_nivel_educativo as f, cat_poblacion_nivel_educativo as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_nivel_educativo = g.id_poblacion_nivel_educativo ) as educacion, 

            (SELECT GROUP_CONCAT(g.nombre_poblacion_grupo_edad SEPARATOR " * ") FROM rel_campana_grupo_edad as f, cat_poblacion_grupo_edad as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_grupo_edad = g.id_poblacion_grupo_edad ) as grupo_edad, 

            (SELECT GROUP_CONCAT(g.nombre_poblacion_nivel SEPARATOR " * ") FROM rel_campana_nivel as f, cat_poblacion_nivel as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_nivel = g.id_poblacion_nivel ) as nivel_socioeconomico, 
			
            concat(a.id_ejercicio,"-",a.id_factura,"-",a.id_orden_compra,"-",a.id_contrato,"-",a.id_proveedor) as id_respecto_proveedor, 
            concat(a.id_ejercicio,"-",a.id_factura,"-",a.id_orden_compra,"-",a.id_contrato,"-",a.id_proveedor) as id_respecto_presupuesto, 
            concat(a.id_ejercicio,"-",a.id_factura,"-",a.id_orden_compra,"-",a.id_contrato,"-",a.id_proveedor) as id_respecto_contrato, 
            a.fecha_validacion, 
            a.area_responsable,
            a.periodo, 
            a.fecha_actualizacion, 
            a.nota
            from 
            tab_facturas as a,
            tab_facturas_desglose as b,
            tab_sujetos_obligados as c,
            tab_campana_aviso as d,
            tab_proveedores as e
            where
            a.id_factura = b.id_factura and
            (b.id_so_contratante = c.id_sujeto_obligado or 
                b.id_so_solicitante = c.id_sujeto_obligado ) and
            b.id_campana_aviso = d.id_campana_aviso and
            a.id_proveedor = e.id_proveedor';

        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

    function F70FXXIIIB_tabla_10633() {

        $sqltext = '
            select 
                concat(g.ejercicio,"-",c.partida) as "id_respecto_presupuesto", 
                c.concepto as "Partida genérica",
                c.capitulo as "Clave del concepto",
                c.denominacion as "Nombre del concepto",
                (IFNULL(sum(e.monto_presupuesto), 0)) as "Presupuesto asignado por concepto",
				(IFNULL(sum(e.monto_presupuesto), 0)+IFNULL(sum(e.monto_modificacion), 0)) as "Presupuesto modificado por concepto",
				( select IFNULL(sum(b.monto_desglose), 0) from tab_facturas as a, tab_facturas_desglose as b 
					where a.id_factura = b.id_factura 
					and (b.id_presupuesto_concepto = e.id_presupuesto_concepto 
					or b.id_presupuesto_concepto_solicitante = e.id_presupuesto_concepto )
					and a.id_ejercicio = d.id_ejercicio) as "Presupuesto total ejercido por concepto", 
                c.denominacion as "Denominación de cada partida",
                (IFNULL(sum(e.monto_presupuesto), 0)) as "Presupuesto total asignado a cada partida",
                (IFNULL(sum(e.monto_presupuesto), 0) + IFNULL(sum(e.monto_modificacion), 0)) as "Presupuesto modificado por partida",
                (select IFNULL(sum(b.monto_desglose), 0) 
					from tab_facturas as a, tab_facturas_desglose as b 
                    where a.id_factura = b.id_factura 
                    and (b.id_presupuesto_concepto = e.id_presupuesto_concepto or
                    b.id_presupuesto_concepto_solicitante = e.id_presupuesto_concepto)
                    and a.id_ejercicio = d.id_ejercicio 
                    and a.id_trimestre = (select max(a2.id_trimestre) from tab_facturas as a2 where  a2.id_ejercicio = d.id_ejercicio) ) as "Presupuesto ejercido al periodo"
				FROM tab_presupuestos d
				JOIN tab_presupuestos_desglose e ON d.id_presupuesto = e.id_presupuesto
				JOIN cat_presupuesto_conceptos c ON e.id_presupuesto_concepto = c.id_presupesto_concepto
				JOIN cat_ejercicios g ON g.id_ejercicio = d.id_ejercicio
				GROUP BY c.capitulo, d.id_ejercicio
				ORDER BY d.id_ejercicio';
        
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

    function F70FXXIIIB_tabla_10656(){
        $sqltext = 'select 
            concat(IFNULL(a.id_factura, ""), "-", IFNULL(a.id_orden_compra, ""), "-", IFNULL( a.id_contrato, "" ), "-", IFNULL( a.id_proveedor, "" ) ) as id_respecto_contrato, 
            b.fecha_celebracion as "Fecha de firma de contrato",
            b.numero_contrato as  "Número o referencia de identificación del contrato",
            e.descripcion_servicios as "Objeto del contrato",
            b.file_contrato as "Hipervínculo al contrato firmado",
            (select GROUP_CONCAT(c.file_convenio," * ") from tab_convenios_modificatorios as c where c.id_contrato=b.id_contrato) as "Hipervínculo al convenio modificatorio, en su caso",
            sum(e.monto_desglose) as  "Monto total del contrato",
            sum(e.monto_desglose) as "Monto pagado al periodo publicado",
            b.fecha_inicio as "Fecha de inicio",
            b.fecha_fin as "Fecha de término", 
            a.numero_factura as "Número de Factura",
            a.file_factura_pdf as  "Hipervínculo a la factura"
            from 
            tab_facturas as a,
            tab_facturas_desglose as e,
            tab_contratos as b
            where
            a.id_factura = e.id_factura and
            a.id_contrato = b.id_contrato and
            a.id_contrato > 1
            group by 
            concat(IFNULL(a.id_factura, ""), "-", IFNULL(a.id_orden_compra, ""), "-", IFNULL( a.id_contrato, "" ), "-", IFNULL( a.id_proveedor, "" ) ), 
            b.fecha_fin, 
            e.descripcion_servicios,
            b.numero_contrato,
            a.numero_factura,
            b.file_contrato,
            a.file_factura_pdf,
            b.fecha_celebracion,
            b.fecha_inicio
            union
            select 
            concat(IFNULL(a.id_factura, ""), "-", IFNULL(a.id_orden_compra, ""), "-", IFNULL( a.id_contrato, "" ), "-", IFNULL( a.id_proveedor, "" ) ) as id_respecto_contrato, 
            b.fecha_orden as "Fecha de firma de contrato",
            b.numero_orden_compra as  "Número o referencia de identificación del contrato",
            e.descripcion_servicios as "Objeto del contrato",
            "" as "Hipervínculo al contrato firmado",
            (select GROUP_CONCAT( IFNULL(c.file_convenio, "") ," * ") from tab_convenios_modificatorios as c where c.id_contrato=b.id_contrato) as "Hipervínculo al convenio modificatorio, en su caso",
            sum(e.monto_desglose) as  "Monto total del contrato",
            sum(e.monto_desglose) as "Monto pagado al periodo publicado",
            b.fecha_orden as "Fecha de inicio",
            IFNULL(c.fecha_fin, "") as "Fecha de término", 
            a.numero_factura as "Número de Factura",
            a.file_factura_pdf as  "Hipervínculo a la factura"
            from 
            tab_facturas as a,
            tab_facturas_desglose as e,
            tab_ordenes_compra as b,
            tab_contratos as c
            where
            a.id_factura = e.id_factura and
            a.id_orden_compra = b.id_orden_compra and
            a.id_orden_compra > 1 and 
            c.id_contrato = b.id_contrato
            group by 
            concat(IFNULL(a.id_factura, ""), "-", IFNULL(a.id_orden_compra, ""), "-", IFNULL( a.id_contrato, "" ), "-", IFNULL( a.id_proveedor, "" ) ), 
            e.descripcion_servicios,
            b.numero_orden_compra,
            a.numero_factura,
            a.file_factura_pdf,
            b.fecha_orden';
            
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

    function F70FXXIIIB_tabla_10632(){

        $sqltext = '
            SELECT CONCAT(a.id_factura,"-",a.id_orden_compra,"-",a.id_contrato,"-",a.id_proveedor) as id_respecto_proveedor, 
            e.nombre_razon_social as razon_social, 
            e.nombres, 
            e.primer_apellido, 
            e.segundo_apellido,
            e.nombre_comercial,			
            e.rfc, 
            p.procedimiento,
            f.motivo,
            r.razones
            FROM tab_facturas AS a, tab_proveedores AS e,
            ( SELECT DISTINCT IFNULL(motivo_adjudicacion, "") AS motivo, id_orden_compra FROM tab_ordenes_compra AS c) AS f,
            ( SELECT DISTINCT IFNULL(descripcion_justificacion, "") AS razones, id_orden_compra FROM tab_ordenes_compra AS b  ) AS r,
            ( SELECT DISTINCT IFNULL(p.nombre_procedimiento, "") AS procedimiento, c.id_contrato FROM cat_procedimientos AS p, tab_contratos AS c WHERE p.id_procedimiento = c.id_procedimiento) AS p
            WHERE a.id_proveedor = e.id_proveedor AND f.id_orden_compra = a.id_orden_compra AND a.id_orden_compra IS NOT NULL  AND r.id_orden_compra = a.id_orden_compra AND p.id_contrato = a.id_contrato ';
    
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }
	
	function F70FXXIIIC()   //Formato C
    {
        $sqltext = "select
            (select c.ejercicio from cat_ejercicios as c where c.id_ejercicio= b.id_ejercicio) as ejercicio,
            (select i.trimestre from cat_trimestres as i where a.id_trimestre=i.id_trimestre)  as trimestre, 
            a.id_trimestre,
           	(select s.nombre_sujeto_obligado from tab_sujetos_obligados as s where s.id_sujeto_obligado= b.id_so_contratante) as nombre_sujeto_obligado,
            (select h.nombre_campana_tipoTO from cat_campana_tiposTO as h where h.id_campana_tipoTO = b.id_campana_tipoTO) as id_campana_tipoTO,
            (select j.nombre_servicio_categoria from cat_servicios_categorias as j where j.id_servicio_categoria=d.id_servicio_categoria) as id_servicio_categoria,
            (select i.nombre_servicio_unidad from cat_servicios_unidades as i where i.id_servicio_unidad=d.id_servicio_unidad) as id_servicio_unidad,
            b.nombre_campana_aviso,
            b.clave_campana,
            b.autoridad,
            (select h.nombre_campana_cobertura from cat_campana_coberturas as h where h.id_campana_cobertura = b.id_campana_cobertura) as id_campana_cobertura, 
            b.campana_ambito_geo,            
            (SELECT GROUP_CONCAT(g.nombre_poblacion_sexo SEPARATOR ' * ') FROM rel_campana_sexo as f, cat_poblacion_sexo as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_sexo = g.id_poblacion_sexo ) as sexo, 
            (SELECT GROUP_CONCAT(f.poblacion_lugar SEPARATOR ' * ') FROM rel_campana_lugar as f 
            WHERE  f.id_campana_aviso = b.id_campana_aviso) as lugar, 
            (SELECT GROUP_CONCAT(g.nombre_poblacion_nivel_educativo SEPARATOR ' * ') 
            FROM rel_campana_nivel_educativo as f, cat_poblacion_nivel_educativo as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_nivel_educativo = g.id_poblacion_nivel_educativo ) as educacion,
            (SELECT GROUP_CONCAT(g.nombre_poblacion_grupo_edad SEPARATOR ' * ') FROM rel_campana_grupo_edad as f, cat_poblacion_grupo_edad as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_grupo_edad = g.id_poblacion_grupo_edad ) as grupo_edad,           
            (SELECT GROUP_CONCAT(g.nombre_poblacion_nivel SEPARATOR ' * ') 
            FROM rel_campana_nivel as f, cat_poblacion_nivel as g 
            WHERE  f.id_campana_aviso = b.id_campana_aviso and f.id_poblacion_nivel = g.id_poblacion_nivel ) as nivel_socioeconomico,            
            e.nombre_razon_social as razon_social,
            e.nombre_comercial,
            f.descripcion_justificacion as 'razones',
			b.monto_tiempo,
            b.area_responsable as 'Area 2',
            b.fecha_inicio, 
            b.fecha_termino,
            a.numero_factura,
            a.area_responsable as 'Area 1',
            b.fecha_validacion,
            b.fecha_actualizacion, 
            b.nota as nota
            from
            tab_facturas as a,
            tab_campana_aviso as b,
            tab_sujetos_obligados as c,
            tab_facturas_desglose as d,
            tab_proveedores as e,
            tab_ordenes_compra as f            
            where
            a.id_factura = d.id_factura and
            a.id_proveedor = e.id_proveedor and
            a.id_orden_compra = f.id_orden_compra and
            d.id_so_contratante = c.id_sujeto_obligado and
            d.id_so_solicitante = c.id_sujeto_obligado and
            b.id_campana_aviso = d.id_campana_aviso";
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

    function F70FXXIIIC_tabla_333914() {

        $sqltext = '
            select 
                concat(g.ejercicio,"-",c.partida) as id_respecto_presupuesto, 
                c.denominacion as "Denominación de cada partida",
                (IFNULL(sum(e.monto_presupuesto), 0)) as "Presupuesto total asignado a cada partida",
                (select IFNULL(sum(b.monto_desglose), 0) 
                    from tab_facturas as a, tab_facturas_desglose as b 
                    where a.id_factura = b.id_factura 
                        and (b.id_presupuesto_concepto = e.id_presupuesto_concepto or
                                b.id_presupuesto_concepto_solicitante = e.id_presupuesto_concepto)
                        and a.id_ejercicio = d.id_ejercicio 
                        and a.id_trimestre = (select max(a2.id_trimestre) from tab_facturas as a2 where  a2.id_ejercicio = d.id_ejercicio) ) as "Presupuesto ejercido al periodo"
            from tab_presupuestos as d
            JOIN tab_presupuestos_desglose e ON e.id_presupuesto = d.id_presupuesto
            JOIN cat_presupuesto_conceptos c ON c.id_presupesto_concepto = e.id_presupuesto_concepto
            JOIN cat_ejercicios g ON g.id_ejercicio = d.id_ejercicio
            GROUP BY g.ejercicio, e.id_presupuesto_concepto
        ';
        
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

    function F70FXXIIID()
    {
        $sqltext = "select
            (select c.ejercicio from cat_ejercicios as c where c.id_ejercicio= b.id_ejercicio) as ejercicio,
            (select i.trimestre from cat_trimestres as i where a.id_trimestre=i.id_trimestre)  as trimestre, 
            a.id_trimestre,
			b.mensajeTO,
           	b.publicacion_segob,
            b.area_responsable,
            b.fecha_validacion,
            b.fecha_actualizacion, 
            b.nota as nota
            from
            tab_facturas as a,
            tab_campana_aviso as b,
            tab_facturas_desglose as c
            where
            a.id_factura = c.id_factura and
            b.id_campana_aviso = c.id_campana_aviso";
        $query = $this->db->query( $sqltext );
        return $query->result_array();
    }

}

?>