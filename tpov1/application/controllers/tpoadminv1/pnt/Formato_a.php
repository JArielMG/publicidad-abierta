<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

include 'Webservices.php';
class Formato_a extends Webservices
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function index(){ 
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

    function enviar_pnt(){
        $table = "rel_pnt_presupuesto";
        $nombre_id_interno = "id_presupuesto";
        
        $this->agregar_pnt($table, $nombre_id_interno);
    }


}
