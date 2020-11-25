<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}
include 'Webservices.php';
class Formato_c extends Webservices
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function index(){
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

    function date_format($dstring){
        if ( $dstring == "" ) return $dstring;

        try {
          $dstring = explode("-", (string)$dstring );  
          $dstring = array_reverse( $dstring );  
          $dstring = implode("/",  $dstring );  
          return $dstring;
        } catch (Exception $e) {  return $dstring; }
    }

    function enviar_pnt(){
        $table = "rel_pnt_campana_aviso2";
        $nombre_id_interno = "id_campana_aviso";
        $r = $_POST["registros"][0]["campos"];

        $_POST["registros"][0]["campos"][1]["valor"] = (isset($r[1]["valor"]))? $this->date_format($r[1]["valor"]) : "";
        $_POST["registros"][0]["campos"][2]["valor"] = (isset($r[2]["valor"]))? $this->date_format($r[2]["valor"]) : "";
        $_POST["registros"][0]["campos"][5]["valor"] = (isset($r[5]["valor"]))? $this->date_format($r[5]["valor"]) : "";
        $_POST["registros"][0]["campos"][6]["valor"] = (isset($r[6]["valor"]))? $this->date_format($r[6]["valor"]) : "";
        
        $this->agregar_pnt($table, $nombre_id_interno);

    }

    function registrosc1(){
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

    function subtabla(){
        $data = $this->_subtabla($_GET["id_factura_desglose"]);
        header('Content-Type: application/json');
        echo json_encode( $data ); 
    }

    private function _subtabla($id_factura_desglose){
        $data = array();
        $cols = array("pnt.id_presupuesto_desglose id_tpo", "pnt.id_pnt", "pnt.id", "ej.ejercicio", 
                      "pcon.denominacion_partida", "pdes.monto_presupuesto", "fact.total_ejercido", 
                      "pnt.estatus_pnt");

        foreach ($cols as &$col) {
            $tag = $col;
            if( strpos($col, " ") ) {
                $col_arr = explode(" ", $col); $col = $col_arr[0]; $tag = $col_arr[1];
            } else if ( strpos($col, ".") ) $tag = explode(".", $col)[1];
            $col = "IFNULL(" . $col . ", '') AS $tag";
        }

        $query = $this->db->query("SELECT " . join(", ", $cols) . " FROM tab_presupuestos_desglose pdes 
            JOIN ( SELECT p.id_presupesto_concepto, c.concepto, c.denominacion 'nombre_concepto', p.partida, p.denominacion 'denominacion_partida' 
                FROM (SELECT id_presupesto_concepto, concepto, partida, denominacion 
                      FROM cat_presupuesto_conceptos pc 
                      WHERE trim(coalesce(concepto, '')) <> '' 
                      AND trim(coalesce(partida, '')) <> '' ) p 
                JOIN (SELECT concepto, denominacion FROM cat_presupuesto_conceptos 
                      WHERE trim(coalesce(concepto, '')) <>'' 
                      AND trim(coalesce(partida, '')) = '') c 
                ON c.concepto = p.concepto 
            ) pcon ON pcon.id_presupesto_concepto = pdes.id_presupuesto_concepto 
            JOIN tab_presupuestos pre ON pre.id_presupuesto = pdes.id_presupuesto 
            JOIN cat_ejercicios ej ON ej.id_ejercicio = pre.id_ejercicio 
            JOIN ( SELECT  fdes.id_factura_desglose, pc.partida partida, ej.ejercicio, SUM(fdes.cantidad) total_ejercido
                    FROM tab_facturas_desglose fdes 
                    JOIN tab_facturas f ON f.id_factura = fdes.id_factura
                    JOIN cat_ejercicios ej ON ej.id_ejercicio = f.id_ejercicio 
                    JOIN cat_presupuesto_conceptos pc ON pc.id_presupesto_concepto = fdes.id_presupuesto_concepto
                    WHERE fdes.id_factura_desglose = " . $id_factura_desglose . "
                  ) fact ON fact.partida = pcon.partida AND fact.ejercicio = ej.ejercicio
            LEFT JOIN rel_pnt_presupuesto_desglose2 pnt ON pnt.id_presupuesto_desglose = pdes.id_presupuesto_desglose;");
        $data["presupuesto_desglose"] = $query->result_array();
        
        return $data;
    }

}
