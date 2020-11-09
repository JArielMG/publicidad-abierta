<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Formato_b extends CI_Controller
{
     // Constructor que manda llamar la funcion is_logged_in
    function __construct()
    {
        parent::__construct();
        $this->is_logged_in();
    }

    // Funcion para revisar inicio de session 
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
    
    
   
    function agregar_pnt(){
        $URL = "http://devcarga.inai.org.mx:8080/sipot-web/spring/mantenimiento/agrega";

        switch ($_POST["idFormato"]) {
            case "43322":
                $table = "rel_pnt_presupuesto";
                $nombre_id_interno = "id_presupuesto";
                break;
            case "43320":
                $table = "rel_pnt_factura";
                $nombre_id_interno = "id_factura";
                $data2 = $this->_subtabla2($_POST["id_contrato"], $_POST["id_factura"]);

                $d1 = $data2['contratos'][0];
                $d2 = $data2['presupuestos'][0];
                $d3 = $data2['facturas'][0];

                $d1["fecha_validacion"] = $this->date_format($d1["fecha_validacion"]);
                $d1["fecha_actualizacion"] = $this->date_format($d1["fecha_actualizacion"]);
                $d1["Fecha de inicio de los servicios contratados"] = $this->date_format($d1["Fecha de inicio de los servicios contratados"]);
                
                /*
                if ( isset( $d1["fecha_validacion"]) ){
                    try {
                        $d1["fecha_validacion"] = explode('-', (string)$d1["fecha_validacion"] );  
                        $d1["fecha_validacion"] =  array_reverse( $d1["fecha_validacion"] );  
                        $d1["fecha_validacion"] =  implode("/",  $d1["fecha_validacion"] );  
                    } catch (Exception $e) {  $d1["fecha_validacion"] = ""; }
                }else{ $d1["fecha_validacion"] = "";}

                if ( isset( $d1["fecha_actualizacion"]) ){
                    try {
                        $d1["fecha_actualizacion"] = explode('-', (string)$d1["fecha_actualizacion"] );  
                        $d1["fecha_actualizacion"] =  array_reverse( $d1["fecha_actualizacion"] );  
                        $d1["fecha_actualizacion"] =  implode("/",  $d1["fecha_actualizacion"] );  
                    } catch (Exception $e) {  $d1["fecha_actualizacion"] = ""; }
                }else{ $d1["fecha_actualizacion"] = "";}

                if ( isset( $d1["Fecha de inicio de los servicios contratados"]) ){
                    try {
                        $d1["Fecha de inicio de los servicios contratados"] = explode('-', (string)$d1["Fecha de inicio de los servicios contratados"] );  
                        $d1["Fecha de inicio de los servicios contratados"] =  array_reverse( $d1["Fecha de inicio de los servicios contratados"] );  
                        $d1["Fecha de inicio de los servicios contratados"] =  implode("/",  $d1["Fecha de inicio de los servicios contratados"] );  
                    } catch (Exception $e) {  $d1["Fecha de inicio de los servicios contratados"] = ""; }
                }else{ $d1["Fecha de inicio de los servicios contratados"] = "";}
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
                                array("idCampo" => "43285", "valor" => $d1["files_factura_pdf"] )/*,
                                array("idCampo" => "333967", "valor" => $d1["area_responsable"] ),
                                array("idCampo" => "333961", "valor" => $d1["fecha_actualizacion"] ),
                                array("idCampo" => "333954", "valor" => $d1["fecha_validacion"] ),
                                array("idCampo" => "333966", "valor" => $d1["nota"] )*/
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
                    case "Licitación pública": $d3['nombre_procedimiento'] = 0;
                        break;
                    case "Adjudicación directa": $d3['nombre_procedimiento'] = 1;
                        break;
                    case "Invitación restringida": $d3['nombre_procedimiento'] = 2;
                        break;
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
                break;

            case "43360":
                $table = "rel_pnt_campana_aviso2";
                $nombre_id_interno = "id_campana_aviso";

                $_POST["registros"][0]["campos"][1]["valor"] = $this->date_format($_POST["registros"][0]["campos"][1]["valor"]);
                $_POST["registros"][0]["campos"][2]["valor"] = $this->date_format($_POST["registros"][0]["campos"][2]["valor"]);
                $_POST["registros"][0]["campos"][5]["valor"] = $this->date_format($_POST["registros"][0]["campos"][5]["valor"]);
                $_POST["registros"][0]["campos"][6]["valor"] = $this->date_format($_POST["registros"][0]["campos"][6]["valor"]);
                break;

            case "43321":
                $table = "rel_pnt_campana_aviso";
                $nombre_id_interno = "id_campana_aviso";
                break;
        }

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

    function panel_pnt(){
        $this->load->view('/tpoadminv1/logo/panel_pnt');
    }

    function ejercicios(){ 
        $query = $this->db->query("SELECT ejercicio FROM cat_ejercicios WHERE active = 1");
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


    function pnt(){
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();

        $this->load->model('tpoadminv1/logo/Logo_model');

        $data['title'] = "Plataforma Nacional de Transparencia";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'pnt'; // solo active 
        $data['subactive'] = 'carga_pnt'; // class="active"
        $data['body_class'] = 'skin-blue';

        $formato = 1;
        $validpntformato = array(1,2,21,22,23,3,31,4,42, 46, 44);
        if( isset($_GET["formato"]) and in_array( $_GET["formato"], $validpntformato) ){
            $formato = $_GET["formato"];
        }

        $data['main_content'] = 'tpoadminv1/logo/pnt' . $formato;
        $data['formato'] = $formato;

        $data['url_logo'] = base_url() . "data/logo/logotop.png";
        $data['fecha_act'] = $this->Logo_model->dame_fecha_act_manual();

        $data['recaptcha'] = $this->Logo_model->get_registro_recaptcha();
        $data['grafica'] = $this->Logo_model->get_registro_grafica_presupuesto();
        
        $data['registro'] = array(
            'fecha_dof' => '',
            'name_file_imagen' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formatos permitidos PNG.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_act\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'Y-m-d'," .
                                        "scrollInput: false" .
                                    "});" .
                                    
                                    "$.fn.datepicker.dates['es'] = {" .
                                        "days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']," .
                                        "daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],".
                                        "daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']," .
                                        "months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],".
                                        "monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],".
                                        "today: 'Hoy'," .
                                        "};" .
                                    "setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                    
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }
    

}
