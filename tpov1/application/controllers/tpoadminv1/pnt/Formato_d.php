<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

include 'Webservices.php';
class Formato_d extends Webservices
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    function index(){
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

    function enviar_pnt(){
        $table = "rel_pnt_campana_aviso";
        $nombre_id_interno = "id_campana_aviso";
        
        $this->agregar_pnt($table, $nombre_id_interno);

    }



}
