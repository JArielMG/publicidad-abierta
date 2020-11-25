<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
include 'Webservices.php';
class Formato_b extends Webservices
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function index(){
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

    function registrosb1(){
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

    function registrosb2(){
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

    function registrosb3(){
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

    function subtabla(){
        $data = $this->_subtabla($_GET["id_contrato"], $_GET["id_factura"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    private function _subtabla($id_contrato, $id_factura){
        $data = array();
        //Datos de Factura
        $cols = array("pnt.id_tpo", "pnt.id_proveedor id", "pnt.id_pnt", "con.descripcion_justificacion", 
                      "e.ejercicio", "proc.nombre_procedimiento", "con.fundamento_juridico", 
                      "prov.nombre_razon_social", "prov.nombres", "prov.primer_apellido", 
                      "prov.segundo_apellido", "prov.nombre_comercial", "prov.rfc", "pnt.estatus_pnt", 
                      "fd.id_presupuesto_concepto");

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
                    LEFT JOIN rel_pnt_proveedor pnt ON pnt.id_proveedor = prov.id_proveedor
                    WHERE f.id_factura = " . $id_factura . ";");

        $data["facturas"] = $query->result_array();

        // Datos del presupuesto
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                       "pcon.partida", "pcon.concepto", "pcon.nombre_concepto", "total.presupuesto", 
                       "total.modificado", "pcon.denominacion_partida", "pdes.monto_presupuesto", 
                       "pdes.monto_modificacion", "fact.total_ejercido", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes 
                    JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio
                    LEFT JOIN (SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', 
                               p.partida, p.denominacion 'denominacion_partida'
                          FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion FROM cat_presupuesto_conceptos pc
                              WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                          JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos
                              WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                          ON c.concepto = p.concepto) pcon 
                    ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (
                        ( SELECT pcon.id_presupesto_concepto, pcon.concepto, 
                                  SUM(pdes.monto_presupuesto) presupuesto, SUM(pdes.monto_modificacion) modificado
                           FROM tab_presupuestos_desglose pdes
                           JOIN (SELECT id_presupesto_concepto, p.concepto
                                 FROM (SELECT id_presupesto_concepto, concepto FROM cat_presupuesto_conceptos pc
                                     WHERE trim(coalesce(concepto, '')) <> '' AND trim(coalesce(partida, '')) <> '' ) p 
                                 JOIN (SELECT concepto FROM cat_presupuesto_conceptos
                                     WHERE trim(coalesce(concepto, '')) <>'' AND trim(coalesce(partida, '')) = '') c
                                 ON c.concepto = p.concepto) pcon 
                           ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto
                           GROUP BY pcon.concepto, pcon.id_presupesto_concepto)
                    ) total ON total.id_presupesto_concepto = pdes.id_presupuesto_concepto
                    LEFT JOIN (SELECT numero_partida, id_factura, SUM(cantidad) total_ejercido 
                        FROM tab_facturas_desglose WHERE id_factura = " . $id_factura . " 
                        GROUP BY numero_partida, id_factura 
                    ) fact ON fact.numero_partida = pcon.partida 
                    LEFT JOIN rel_pnt_presupuesto_desglose pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose");
        
        $rows = $query->result_array();
        $data["presupuestos"] = $query->result_array();

        //Datos de Contrato
        $cols = array("pnt.id_contrato id_tpo", "pnt.id_pnt id_pnt", "pnt.id", "ej.ejercicio", 
                      "cont.fecha_celebracion", "cont.numero_contrato", "cont.objeto_contrato", 
                      "f.numeros_factura", "f.files_factura_pdf", "cont.area_responsable", 
                      "cont.fecha_validacion", "cont.fecha_actualizacion", "cont.nota", "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $tag = array_pop($col_arr); $col = join(" ", $col_arr);
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . ",
              IFNULL(vcon.`Archivo contrato en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al contrato firmado',
              IFNULL(vcmod.`Archivo convenio en PDF (Vinculo al archivo)` , '') AS 'Hipervínculo al convenio modificatorio en su caso',
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
          WHERE cont.id_contrato = " . $id_contrato . ";");

        $data["contratos"] = $query->result_array();
        return $data;
    }

    function enviar_pnt(){
        $table = "rel_pnt_factura";
        $nombre_id_interno = "id_factura";
        $data = $this->_subtabla($_POST["id_contrato"], $_POST["id_factura"]);

        $d1 = $data['contratos'][0];
        $d2 = $data['presupuestos'][0];
        $d3 = $data['facturas'][0]; 

        $d1["fecha_validacion"] = $this->date_format($d1["fecha_validacion"]);
        $d1["fecha_actualizacion"] = $this->date_format($d1["fecha_actualizacion"]);
        $d1["Fecha de inicio de los servicios contratados"] = $this->date_format($d1["Fecha de inicio de los servicios contratados"]);
        /*
        $con = array(
            "idCampo" => "333959", 
            "valor" => array(
                array(
                    "numeroRegistro" => 1,
                    "IdRegistro" => "",
                    "campos" => array(
                        array("idCampo" => "43275", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                        array("idCampo" => "43276", "valor" => $d1["numero_contrato"] ),
                        array("idCampo" => "43277", "valor" => $d1["objeto_contrato"] ),
                        array("idCampo" => "43278", "valor" => $d1["Hipervínculo al contrato firmado"] ),
                        array("idCampo" => "43279", "valor" => $d1["Hipervínculo al convenio modificatorio en su caso"] ),
                        array("idCampo" => "43280", "valor" => $d1["Monto total del contrato"] ),
                        array("idCampo" => "43281", "valor" => $d1["Monto pagado al periodo publicado"] ),
                        array("idCampo" => "43282", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                        array("idCampo" => "43283", "valor" => $d1["Fecha de término de los servicios contratados"] ),
                        array("idCampo" => "43284", "valor" => $d1["numeros_factura"] ),
                        array("idCampo" => "43285", "valor" => $d1["files_factura_pdf"] ),
                        array("idCampo" => "333967", "valor" => $d1["area_responsable"] ),
                        array("idCampo" => "333961", "valor" => $d1["fecha_actualizacion"] ),
                        array("idCampo" => "333954", "valor" => $d1["fecha_validacion"] ),
                        array("idCampo" => "333966", "valor" => $d1["nota"] )
                    ) 
                ) 
            ) 
        );
        */

        $con = array(
            "idCampo" => "333959", 
            "valor" => array(
                array(
                    "numeroRegistro" => 1,
                    "IdRegistro" => "",
                    "campos" => array(
                        array("idCampo" => "43275", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                        array("idCampo" => "43276", "valor" => $d1["numero_contrato"] ),
                        array("idCampo" => "43277", "valor" => $d1["objeto_contrato"] ),
                        array("idCampo" => "43278", "valor" => $d1["Hipervínculo al contrato firmado"] ),
                        array("idCampo" => "43279", "valor" => $d1["Hipervínculo al convenio modificatorio en su caso"] ),
                        array("idCampo" => "43280", "valor" => $d1["Monto total del contrato"] ),
                        array("idCampo" => "43281", "valor" => $d1["Monto pagado al periodo publicado"] ),
                        array("idCampo" => "43282", "valor" => $d1["Fecha de inicio de los servicios contratados"] ),
                        array("idCampo" => "43283", "valor" => $d1["Fecha de término de los servicios contratados"] ),
                        array("idCampo" => "43284", "valor" => $d1["numeros_factura"] ),
                        array("idCampo" => "43285", "valor" => $d1["files_factura_pdf"] )
                    ) 
                ) 
            ) 
        );
        
        $pro = array(
            "idCampo" => "333958", 
            "valor" => array(
                array(
                    "numeroRegistro" => 1,
                    "IdRegistro" => "",
                    "campos" => array(
                        array("idCampo" => "43265", "valor" => $d2['partida'] ), //Partida
                        array("idCampo" => "43266", "valor" => $d2['concepto'] ), //Clave de Concepto
                        array("idCampo" => "43267", "valor" => $d2['nombre_concepto'] ), //Nombre del concepto
                        array("idCampo" => "43268", "valor" => $d2['presupuesto'] ), //Presupuesto asignado por concepto
                        array("idCampo" => "43269", "valor" => $d2['total_ejercido'] ), //Presupuesto ejercido al periodo reportado de cada partida
                        array("idCampo" => "43270", "valor" => $d2['modificado'] ), //presupuesto total ejercido por concepto
                        array("idCampo" => "43271", "valor" => $d2['denominacion_partida'] ), //Denominación de cada partida
                        array("idCampo" => "43272", "valor" => $d2['monto_presupuesto'] ), //Presupuesto total asignado a cada partida
                        array("idCampo" => "43273", "valor" => $d2['monto_modificacion'] ), //Presupuesto modificado por partida
                        array("idCampo" => "43274", "valor" => $d2['presupuesto'] ) //Presupuesto modificado por concepto
                    ) 
                ) 
            ) 
        );


        switch( $d3['nombre_procedimiento'] ) {
            case "Licitación pública": $d3['nombre_procedimiento'] = 0; break;
            case "Adjudicación directa": $d3['nombre_procedimiento'] = 1; break;
            case "Invitación restringida": $d3['nombre_procedimiento'] = 2; break;
            default: break;
        }
                    
        $fac = array(
            "idCampo" => "333957", 
            "valor" => array(
                array(
                    "numeroRegistro" => 1,
                    "IdRegistro" => "",
                    "campos" => array(
                        array("idCampo" => "43256", "valor" => $d3['nombre_razon_social'] ),
                        array("idCampo" => "43257", "valor" => $d3['nombres'] ),
                        array("idCampo" => "43258", "valor" => $d3['primer_apellido'] ),
                        array("idCampo" => "43259", "valor" => $d3['segundo_apellido'] ),
                        array("idCampo" => "43260", "valor" => $d3['rfc'] ),
                        array("idCampo" => "43261", "valor" => $d3['nombre_procedimiento'] ), //AQUI
                        array("idCampo" => "43262", "valor" => $d3['fundamento_juridico'] ),
                        array("idCampo" => "43263", "valor" => $d3['descripcion_justificacion'] ),
                        array("idCampo" => "43264", "valor" => $d3['nombre_comercial'] )
                    ) 
                ) 
            ) 
        );

        array_push( $_POST["registros"][0]['campos'], $con, $pro, $fac );
        $this->agregar_pnt($table, $nombre_id_interno);
    }

}
