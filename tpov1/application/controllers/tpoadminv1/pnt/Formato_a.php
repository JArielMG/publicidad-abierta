<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Formato_a extends CI_Controller
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function is_logged_in() 
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('tpoadminv1/cms');
        }
    }
    
    // Funcion para cerrar session
    function logout() 
    {
        $this->session->sess_destroy();
        $this->session->sess_create();
        redirect('/');
    }
    
    
    function permiso_administrador()
    {
        //Revisamos que el usuario sea administrador
        if($this->session->userdata('usuario_rol') != '1')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

    /**
     * Redirect with POST data.
     *
     * @param string $url URL.
     * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)
     * @param array $headers Optional. Extra headers to send.
     */
    private function redirect_post($url, array $data, array $headers = null) {
        $params = array(
            'http' => array(
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        if (!is_null($headers)) {
            $params['http']['header'] = '';
            foreach ($headers as $k => $v) {
                $params['http']['header'] .= "$k: $v\n";
            }
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if ($fp) {
            echo @stream_get_contents($fp);
            die();
        } else {
            // Error
            throw new Exception("Error loading '$url', $php_errormsg");
        }
    }

    function registros(){ 
        $cols = array("pnt.id_tpo", "pnt.id_pnt", "p.id_presupuesto", "e.ejercicio", 
                      "p.fecha_inicio_periodo", "p.id_sujeto_obligado", "p.fecha_termino_periodo", "p.denominacion", 
                      "p.fecha_publicacion", "p.file_programa_anual", "p.area_responsable", 
                      "p.fecha_validacion", "p.fecha_actualizacion", "p.nota_planeacion", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }
        
        $cond = "WHERE p.id_sujeto_obligado = " . $_SESSION["id_sujeto_obligado"];
        if($_SESSION["rol"] == "admin"){
            $cond .= " OR p.id_sujeto_obligado IN"
                  . "   (SELECT id_sujeto_obligado FROM unidades_so WHERE id_concentrador = " .  $_SESSION["id_sujeto_obligado"] . ")";
        }

        $stm = "SELECT " . join(", ", $cols) . " FROM tab_presupuestos p "
             . "JOIN cat_ejercicios e ON p.id_ejercicio = e.id_ejercicio "
             . "LEFT JOIN rel_pnt_presupuesto pnt ON p.id_presupuesto = pnt.id_presupuesto ";
             //. $cond;
        

        $query = $this->db->query($stm);
        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }


    
    function registros2(){
        $cols = array("pnt.id_tpo", "pnt.id_pnt", "f.id_factura", "e.ejercicio", 
                      "fd.area_administrativa",  "fd.id_servicio_clasificacion", 
                      "scat.nombre_servicio_categoria",  "sscat.id_servicio_subcategoria", 
                      "suni.nombre_servicio_unidad", "cam.nombre_campana_aviso", "cam.periodo", 
                      "ctem.nombre_campana_tema", "cobj.campana_objetivo", "cam.objetivo_comunicacion", 
                      "fd.precio_unitarios", "cam.clave_campana", "cam.autoridad", 
                      "cam.campana_ambito_geo", "cam.fecha_inicio fecha_inicio_cam", 
                      "cam.fecha_termino fecha_termino_cam", "lugar.poblaciones", "edu.nivel_educativo", 
                      "edad.rangos_edad", "neco.poblacion_nivel", "f.area_responsable", 
                      "f.fecha_validacion", "f.fecha_actualizacion", "f.nota", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ", 
                    CONCAT(CASE 
                        WHEN f.id_trimestre = NULL THEN '' WHEN f.id_trimestre = 1 THEN '01/01/'
                        WHEN f.id_trimestre = 2 THEN '01/04/' WHEN f.id_trimestre = 3 THEN '01/07/'
                        WHEN f.id_trimestre = 4 THEN '01/10/'
                    END, IFNULL(e.ejercicio, '') ) fecha_inicio, 
                    CONCAT(CASE 
                        WHEN f.id_trimestre = NULL THEN '' WHEN f.id_trimestre = 1 THEN '31/03/'
                        WHEN f.id_trimestre = 2 THEN '30/06/'  WHEN f.id_trimestre = 3 THEN '30/09/'
                        WHEN f.id_trimestre = 4 THEN '31/12/'
                    END, IFNULL(e.ejercicio, '') ) fecha_termino, 
                    (CASE 
                        WHEN ( (fd.id_so_contratante IS NULL) && (fd.id_so_solicitante IS NULL) ) THEN ''
                        WHEN ( (fd.id_so_contratante IS NOT NULL) && (fd.id_so_solicitante IS NOT NULL) ) THEN 2
                        WHEN ( (fd.id_so_contratante IS NOT NULL) && (fd.id_so_solicitante IS NULL) ) THEN 0
                        WHEN ( (fd.id_so_contratante IS NULL) && (fd.id_so_solicitante IS NOT NULL) ) THEN 1
                    END) funcion_sujeto,
                    (CASE 
                        WHEN cam.id_campana_tipo= NULL THEN '' 
                        WHEN cam.id_campana_tipo = 1 THEN 1
                        WHEN cam.id_campana_tipo = 2 THEN 0
                    END) 'tipo',
                    (CASE 
                        WHEN ccob.id_campana_cobertura = NULL THEN '' 
                        WHEN ccob.id_campana_cobertura = 1 THEN 3
                        WHEN ccob.id_campana_cobertura = 2 THEN 2 
                        WHEN ccob.id_campana_cobertura = 3 THEN 1
                        WHEN ccob.id_campana_cobertura = 4 THEN 0
                    END) 'cobertura', 
                    (CASE 
                        WHEN sexo.poblacion_sexo = NULL THEN '' 
                        WHEN sexo.poblacion_sexo = 1 THEN 1
                        WHEN sexo.poblacion_sexo = 2 THEN 0 
                        WHEN sexo.poblacion_sexo = 3 THEN 2
                    END) 'sexo', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_pro_con', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_rec_pre', 
                    CONCAT(f.id_ejercicio, '-', f.id_factura, '-', f.id_orden_compra, '-', f.id_contrato, '-', f.id_proveedor) 'resp_con_mon'
                FROM tab_facturas f
                JOIN tab_facturas_desglose fd ON fd.id_factura = f.id_factura
                JOIN tab_campana_aviso cam ON cam.id_campana_aviso = fd.id_campana_aviso
                JOIN cat_servicios_clasificacion scla ON scla.id_servicio_clasificacion = fd.id_servicio_clasificacion
                JOIN cat_servicios_categorias scat ON scat.id_servicio_categoria = fd.id_servicio_categoria 
                JOIN cat_servicios_subcategorias sscat ON sscat.id_servicio_subcategoria = fd.id_servicio_subcategoria 
                JOIN cat_servicios_unidades suni ON suni.id_servicio_unidad = fd.id_servicio_unidad 
                JOIN cat_campana_coberturas ccob ON ccob.id_campana_cobertura = cam.id_campana_cobertura
                JOIN cat_ejercicios e ON e.id_ejercicio = cam.id_ejercicio 
                JOIN cat_campana_temas ctem ON ctem.id_campana_tema = cam.id_campana_tema 
                JOIN cat_campana_objetivos cobj ON cobj.id_campana_objetivo = cam.id_campana_objetivo 
                LEFT JOIN (SELECT reda.id_campana_aviso, GROUP_CONCAT(eda.nombre_poblacion_grupo_edad) rangos_edad
                    FROM rel_campana_grupo_edad reda
                    JOIN cat_poblacion_grupo_edad eda ON eda.id_poblacion_grupo_edad = reda.id_poblacion_grupo_edad
                    GROUP BY reda.id_campana_aviso
                ) edad ON edad.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT rsex.id_campana_aviso, GROUP_CONCAT(sex.id_poblacion_sexo) poblacion_sexo
                    FROM rel_campana_sexo rsex
                    JOIN cat_poblacion_sexo sex ON sex.id_poblacion_sexo = rsex.id_poblacion_sexo
                    GROUP BY rsex.id_campana_aviso
                ) sexo ON sexo.id_campana_aviso = cam.id_campana_aviso 
                LEFT JOIN rel_campana_sexo rsex ON rsex.id_campana_aviso = cam.id_campana_aviso 
                LEFT JOIN ( SELECT id_campana_aviso, GROUP_CONCAT(poblacion_lugar) poblaciones 
                    FROM rel_campana_lugar GROUP BY id_campana_aviso) lugar ON lugar.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT cne.id_campana_aviso, GROUP_CONCAT(ne.nombre_poblacion_nivel_educativo) nivel_educativo 
                    FROM rel_campana_nivel_educativo cne
                    JOIN cat_poblacion_nivel_educativo ne ON ne.id_poblacion_nivel_educativo = cne.id_poblacion_nivel_educativo
                    GROUP BY cne.id_campana_aviso) edu ON edu.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN (SELECT cn.id_campana_aviso, GROUP_CONCAT(pn.nombre_poblacion_nivel) poblacion_nivel 
                    FROM rel_campana_nivel cn
                    JOIN cat_poblacion_nivel pn ON pn.id_poblacion_nivel = cn.id_poblacion_nivel
                    GROUP BY cn.id_campana_aviso) neco ON neco.id_campana_aviso = cam.id_campana_aviso
                LEFT JOIN rel_pnt_factura pnt ON pnt.id_factura = f.id_factura
                ORDER BY pnt.id_tpo DESC");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros21(){
        $cols = array("pnt.id_tpo", "pnt.id_proveedor id", "f.id_factura", "con.descripcion_justificacion", 
                      "e.ejercicio", "proc.nombre_procedimiento", "con.fundamento_juridico", 
                      "prov.nombre_razon_social", "prov.nombres", "prov.primer_apellido", 
                      "prov.segundo_apellido", "prov.nombre_comercial", "prov.rfc", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }


        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_facturas f
                    JOIN tab_facturas_desglose fd ON fd.id_factura = f.id_factura
                    JOIN tab_campana_aviso cam ON cam.id_campana_aviso = fd.id_campana_aviso
                    JOIN cat_ejercicios e ON e.id_ejercicio = cam.id_ejercicio 
                    JOIN tab_proveedores prov ON prov.id_proveedor = f.id_proveedor
                    LEFT JOIN tab_contratos con ON con.id_proveedor = prov.id_proveedor
                    LEFT JOIN cat_procedimientos proc ON proc.id_procedimiento = con.id_procedimiento
                    LEFT JOIN rel_pnt_proveedor pnt ON pnt.id_proveedor = prov.id_proveedor;");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros50(){
        $data = $this->_subtabla2($_GET["id_contrato"], $_GET["id_factura"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    function registros51(){
        $data = $this->_subtabla3($_GET["id_factura_desglose"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    function registros22(){
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                       "pcon.partida", "pcon.capitulo", "pcon.nombre_concepto", "total.presupuesto", 
                       "total.modificado total_modificado", "pdes.monto_presupuesto", 
                       "pdes.monto_modificacion", "fact.total_ejercido", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) .  
                  " FROM tab_presupuestos_desglose pdes 
                    JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                    JOIN (SELECT p.id_presupesto_concepto, c.capitulo, c.denominacion 'nombre_concepto', 
                               p.partida, p.id_presupesto_concepto 'denominacion_partida'
                          FROM (SELECT id_presupesto_concepto, capitulo, partida, denominacion FROM cat_presupuesto_conceptos pc
                              WHERE trim(coalesce(capitulo, '')) <> '' AND trim(coalesce(partida, '')) <> '' AND trim(coalesce(concepto, '')) <> '' ) p 
                          JOIN (SELECT capitulo, denominacion FROM cat_presupuesto_conceptos 
                              WHERE trim(coalesce(capitulo, '')) <> '' AND trim(coalesce(partida, '')) = '') c
                          ON c.capitulo = p.capitulo) pcon 
                    ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    JOIN (
                        ( SELECT pcon.id_presupesto_concepto, pcon.concepto, 
                                  SUM(pdes.monto_presupuesto) presupuesto, SUM(pdes.monto_modificacion) modificado
                           FROM tab_presupuestos_desglose pdes
                           JOIN (SELECT id_presupesto_concepto, p.concepto
                                 FROM (SELECT id_presupesto_concepto, concepto FROM cat_presupuesto_conceptos pc
                                     WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' AND trim(coalesce(concepto, '')) <> '' ) p 
                                 JOIN (SELECT concepto FROM cat_presupuesto_conceptos
                                     WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                                 ON c.concepto = p.concepto) pcon 
                           ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                           GROUP BY pcon.concepto, pcon.id_presupesto_concepto)
                    ) total ON total.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (SELECT numero_partida, SUM(monto_desglose) total_ejercido 
                               FROM tab_facturas_desglose GROUP BY numero_partida) fact 
                         ON fact.numero_partida = pcon.partida 
                    LEFT JOIN rel_pnt_presupuesto_desglose pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros23(){
        $cols = array("pnt.id_contrato id_tpo", "pnt.id_pnt id_pnt", "pnt.id", "ej.ejercicio", 
                      "cont.fecha_celebracion", "cont.numero_contrato", "cont.objeto_contrato", 
                      "f.numeros_factura", "f.files_factura_pdf", "conv.file_convenio",
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ",
                IFNULL(vcon.`Archivo contrato en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al contrato firmado',
                IFNULL(vcon.`Monto original del contrato` , '') AS 'Monto total del contrato',
                IFNULL(vcon.`Monto pagado a la fecha` , '') AS 'Monto pagado al periodo publicado',
                IFNULL(vcon.`Fecha inicio` , '') AS 'Fecha de inicio de los servicios contratados',
                IFNULL(vcon.`Fecha fin` , '') AS 'Fecha de término de los servicios contratados'
            FROM tab_contratos cont
            LEFT JOIN vout_contratos vcon ON vcon.`ID (Número de contrato)` = cont.id_contrato
            LEFT JOIN vout_convenios_modificatorios vcmod ON vcmod.`ID (Número de contrato)` = cont.id_contrato
            LEFT JOIN (SELECT f.id_contrato, f.numero_factura numeros_factura, 
                       f.file_factura_pdf files_factura_pdf, f.id_ejercicio
                       FROM tab_facturas f ) f ON f.id_contrato = cont.id_contrato
            LEFT JOIN cat_ejercicios ej ON ej.id_ejercicio = f.id_ejercicio
            LEFT JOIN rel_pnt_contrato pnt ON pnt.id_contrato = cont.id_contrato
            LEFT JOIN tab_convenios_modificatorios conv ON conv.id_contrato = cont.id_contrato
            WHERE cont.numero_contrato != 'Sin contrato'; ");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros3(){
        $cols = array("cam.id_campana_aviso id", "cam.autoridad", "cam.fecha_inicio_periodo", 
                      "cam.fecha_termino_periodo", "cam.clave_campana", "cam.descripcion_unidad", 
                      "cam.nombre_campana_aviso", "cam.campana_ambito_geo", "cam.responsable_publisher", 
                      "cam.name_comercial", "cam.razones_supplier", "cam.monto_tiempo", "cam.difusion_mensaje", 
                      "cam.fecha_inicio", "cam.fecha_termino", "cam.num_factura", "cam.area_responsable",
                      "cam.fecha_validacion", "cam.fecha_actualizacion", "cam.nota");

        $cols = array("pnt.id_campana_aviso id_tpo", "pnt.id_pnt", "cam.id_campana_aviso id", "ej.ejercicio", 
                      "cam.autoridad", "cam.fecha_inicio_periodo", "cam.fecha_termino_periodo", 
                      "so.nombre_sujeto_obligado", "ctip.nombre_campana_tipoTO", "cscat.nombre_servicio_categoria", 
                      "cam.clave_campana", "cam.descripcion_unidad", "cam.nombre_campana_aviso", 
                      "cam.campana_ambito_geo", "ccob.nombre_campana_cobertura", "sex.nombre_poblacion_sexo", 
                      "lug.poblacion_lugar", "edu.nombre_poblacion_nivel_educativo", "eda.nombre_poblacion_grupo_edad", 
                      "niv.nombre_poblacion_nivel", "cam.responsable_publisher", "cam.name_comercial", 
                      "cam.razones_supplier", "cam.monto_tiempo", "cam.difusion_mensaje", "cam.fecha_inicio", 
                      "cam.fecha_termino", /*"fac.id_factura", */"cam.num_factura", "cam.area_responsable",/*"fac.area_responsable", */
                      "cam.fecha_validacion", "cam.fecha_actualizacion", "pnt.estatus_pnt", "cam.nota");



        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }
        $query = $this->db->query("SELECT " . join(", ", $cols) . " 
                    -- 'Presupuesto total asignado y ejercido de cada partida',
                  FROM tab_campana_aviso cam
                   JOIN cat_ejercicios ej ON ej.id_ejercicio = cam.id_ejercicio
                  --  JOIN tab_facturas_desglose fdes ON fdes.id_campana_aviso = cam.id_campana_aviso
                  -- JOIN tab_facturas fac ON fac.id_factura = fdes.id_factura
                    -- JOIN tab_proveedores prov ON prov.id_proveedor = fac.id_proveedor
                    -- JOIN tab_ordenes_compra ord ON ord.id_proveedor = fac.id_proveedor
                   LEFT JOIN cat_servicios_categorias cscat ON cscat.id_servicio_categoria = cam.id_servicio_categoria
                   LEFT JOIN tab_sujetos_obligados so ON so.id_sujeto_obligado = cam.id_so_solicitante
                  LEFT JOIN cat_campana_tiposTO ctip ON ctip.id_campana_tipoTO = cam.id_campana_tipoTO
                  LEFT JOIN cat_campana_coberturas ccob ON ccob.id_campana_cobertura = cam.id_campana_cobertura
                  LEFT JOIN (SELECT csex.id_campana_aviso, sex.nombre_poblacion_sexo
                         FROM rel_campana_sexo csex
                         JOIN cat_poblacion_sexo sex ON sex.id_poblacion_sexo = csex.id_poblacion_sexo) sex 
                   ON sex.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT clug.id_campana_aviso, clug.poblacion_lugar
                         FROM rel_campana_lugar clug
                         JOIN cat_poblacion_lugar lug ON lug.id_poblacion_lugar = clug.id_campana_lugar) lug
                   ON lug.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT cedu.id_campana_aviso, edu.id_poblacion_nivel_educativo nombre_poblacion_nivel_educativo
                         FROM rel_campana_nivel_educativo cedu
                         JOIN cat_poblacion_nivel_educativo edu ON edu.id_poblacion_nivel_educativo = cedu.id_rel_campana_nivel_educativo) edu
                   ON edu.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT ceda.id_campana_aviso, eda.nombre_poblacion_grupo_edad
                         FROM rel_campana_grupo_edad ceda
                         JOIN cat_poblacion_grupo_edad eda ON eda.id_poblacion_grupo_edad = ceda.id_rel_campana_grupo_edad) eda
                   ON eda.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT cniv.id_campana_aviso, GROUP_CONCAT(niv.nombre_poblacion_nivel) nombre_poblacion_nivel
                         FROM rel_campana_nivel cniv
                         JOIN cat_poblacion_nivel niv ON niv.id_poblacion_nivel = cniv.id_poblacion_nivel
                         GROUP BY cniv.id_campana_aviso) niv ON niv.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN rel_pnt_campana_aviso2 pnt ON pnt.id_campana_aviso = cam.id_campana_aviso ;");


        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_campana_aviso cam
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = cam.id_ejercicio
                    LEFT JOIN tab_sujetos_obligados so ON so.id_sujeto_obligado = cam.id_so_solicitante
                  LEFT JOIN cat_campana_tiposTO ctip ON ctip.id_campana_tipoTO = cam.id_campana_tipoTO
                  LEFT JOIN cat_campana_coberturas ccob ON ccob.id_campana_cobertura = cam.id_campana_cobertura
                   LEFT JOIN cat_servicios_categorias cscat ON cscat.id_servicio_categoria = cam.id_servicio_categoria
                   LEFT JOIN (SELECT ceda.id_campana_aviso, eda.nombre_poblacion_grupo_edad
                         FROM rel_campana_grupo_edad ceda
                         JOIN cat_poblacion_grupo_edad eda ON eda.id_poblacion_grupo_edad = ceda.id_rel_campana_grupo_edad) eda
                   ON eda.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT cniv.id_campana_aviso, GROUP_CONCAT(niv.nombre_poblacion_nivel) nombre_poblacion_nivel
                         FROM rel_campana_nivel cniv
                         JOIN cat_poblacion_nivel niv ON niv.id_poblacion_nivel = cniv.id_poblacion_nivel
                         GROUP BY cniv.id_campana_aviso) niv ON niv.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN rel_pnt_campana_aviso2 pnt ON pnt.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (  SELECT cedu.id_campana_aviso, GROUP_CONCAT(edu.nombre_poblacion_nivel_educativo) nombre_poblacion_nivel_educativo
                        FROM rel_campana_nivel_educativo cedu
                        LEFT JOIN cat_poblacion_nivel_educativo edu 
                          ON edu.id_poblacion_nivel_educativo = cedu.id_poblacion_nivel_educativo
                        GROUP BY id_campana_aviso) edu
                   ON edu.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT clug.id_campana_aviso, GROUP_CONCAT(lug.nombre_poblacion_lugar) poblacion_lugar
                        FROM rel_campana_lugar clug 
                        JOIN cat_poblacion_lugar lug ON lug.id_poblacion_lugar = clug.id_campana_lugar
                        GROUP BY clug.id_campana_aviso) lug
                   ON lug.id_campana_aviso = cam.id_campana_aviso
                   LEFT JOIN (SELECT csex.id_campana_aviso, GROUP_CONCAT(sex.nombre_poblacion_sexo) nombre_poblacion_sexo
                        FROM rel_campana_sexo csex
                        JOIN cat_poblacion_sexo sex ON sex.id_poblacion_sexo = csex.id_poblacion_sexo
                        GROUP BY id_campana_aviso) sex 
                   ON sex.id_campana_aviso = cam.id_campana_aviso;");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }

    function registros31(){
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                      "pcon.denominacion_partida", "fact2.total_monto_presupuesto", "fact.total_ejercido", 
                      "pnt.estatus_pnt");

        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                      "pcon.denominacion_partida", "fact2.total_monto_presupuesto", "fact.total_ejercido", 
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes
                JOIN (SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', 
                           p.partida, p.denominacion 'denominacion_partida'
                      FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion FROM cat_presupuesto_conceptos pc
                          WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                      JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos
                          WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                      ON c.concepto = p.concepto
                ) pcon ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                LEFT JOIN (SELECT numero_partida, SUM(cantidad) total_ejercido 
                           FROM tab_facturas_desglose GROUP BY numero_partida
                ) fact ON fact.numero_partida = pcon.partida
                LEFT JOIN (SELECT numero_partida, SUM(monto_desglose) total_monto_presupuesto
                           FROM tab_facturas_desglose GROUP BY numero_partida
                ) fact2 ON fact2.numero_partida = pcon.partida
                JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                LEFT JOIN rel_pnt_presupuesto_desglose2 pnt 
                ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");

        $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }
//"pnt.id_tpo", "pnt.id_pnt", "f.id_factura"
    function registros4(){
        $cols = array("pnt.id_campana_aviso id_tpo", "pnt.id_pnt", "cam.id_campana_aviso id", "pnt.estatus_pnt", "ej.ejercicio", 
                      "cam.fecha_inicio_periodo", "cam.fecha_termino_periodo", "cam.mensajeTO", "cam.fecha_validacion", 
                      "cam.publicacion_segob", "cam.fecha_actualizacion", "cam.area_responsable", "cam.nota");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . "
                FROM tab_campana_aviso cam 
                JOIN cat_ejercicios ej ON ej.id_ejercicio = cam.id_ejercicio 
                LEFT JOIN rel_pnt_campana_aviso pnt ON pnt.id_campana_aviso = cam.id_campana_aviso;"); 

       $rows = $query->result_array();

        header('Content-Type: application/json');
        echo json_encode( $rows ); 
    }
   
    function agregar_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/mantenimiento/agrega";
        $table = "rel_pnt_presupuesto";
        $nombre_id_interno = "id_presupuesto";


        $data = array(
            'idFormato' => $_POST["idFormato"], 
            'token' => $_POST["token"], 
            'correoUnidadAdministrativa' => $_POST["correoUnidadAdministrativa"], 
            'unidadAdministrativa' => $_POST["unidadAdministrativa"], 
            'SujetoObligado' => $_POST["SujetoObligado"], 
            'registros' => $_POST["registros"]
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $res = file_get_contents( $URL, false, $context );

        $result = json_decode( $res, true );

        $post_data = array();
        $post_data[$nombre_id_interno] = $_POST["_id_interno"];
        $post_data['id_pnt'] = $result['mensaje']['registros'][0]['idRegistro'];
        $post_data['estatus_pnt'] ='SUBIDO';
        
        if( $result["success"] ){
            $this->db->insert($table, $post_data);
            $result['id_tpo'] =  $this->db->insert_id();
        }

        $response = json_encode($result);
        header('Content-Type: application/json');
        echo json_encode($response);
    }


}
