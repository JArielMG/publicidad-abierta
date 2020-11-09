<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Listado extends CI_Controller
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

    function index(){
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
        $validpntformato = array("a","b","b1","b2","b3","c","c1","d",42, 46, 44);
        if( isset($_GET["formato"]) and in_array( $_GET["formato"], $validpntformato) ){
            $formato = $_GET["formato"];
        }

        $data['main_content'] = 'tpoadminv1/pnt/formato_' . $formato;
        //$data['main_content'] = 'tpoadminv1/logo/pnt' . $formato;
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