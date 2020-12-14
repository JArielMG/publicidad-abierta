<?php

/*
INAI / USUARIOS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Logo extends CI_Controller
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
    

    function alta_carga_logo(){

        //Validamos que el usuario tenga acceso
        //$this->permiso_administrador();

        $this->load->model('tpoadminv1/logo/Logo_model');

        $data['title'] = "Configuraci&oacute;n";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'logo'; // solo active 
        $data['subactive'] = 'carga_logo'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/logo/carga_logo';

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


    function validate_alta_carga_logo()
    {
        //Validamos que el usuario tenga acceso
        $permiso = $this->permiso_administrador();
        
        $this->load->model('tpoadminv1/logo/Logo_model');
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('fecha_act', 'Fecha de actualizaci&oacute;n ', 'trim|required');
       // $this->form_validation->set_rules('comentario_act', 'Nombre(s)', 'trim|required|min_length[3]');
        
        $this->form_validation->set_error_delimiters('<p>','</p>');
        
        $data['title'] = "Carga logo o Alta fecha de actualizaci&oacute;n manual";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'usuarios'; // solo active 
        $data['subactive'] = 'alta_usuario'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/logo/carga_logo';

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
                                        "format:'d.m.Y'," .
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
                                    "$('.datepicker').datepicker({ " .
                                        "format: 'dd.mm.yyyy'," .
                                        "language: 'es'," .
                                        "todayHighlight: true " .
                                    "});" .
                                    
                                "});" .
                            "</script>";
        
        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }
        else 
        {
            $alta = $this->Logo_model->alta_fecha_manual();
            
            switch($alta)
            {
                case 1:
                    $this->session->set_flashdata('exito', "La fecha de actualizaci&oacute;n ".$this->input->post('fecha_act')." ha sido dado de alta exitosamente");
                    redirect('/tpoadminv1/logo/logo/alta_carga_logo');
                    break;
                case 2: 
                    $this->session->set_flashdata('error', "Ya existe la fecha de actualizaci&oacute;n ".$this->input->post('fecha_act'). " ,ingresa otra");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                default:
                    $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
            }
        }
    }


    
    function upload_file()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_administrador();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_imagen']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            //poner nombre por default 
            //$name_file = "logo.top"
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                //$extenciones = array('xlsx','xls','pdf','doc','docx');
                $extenciones = array('png');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    // se guarda el archivo
                    $config['upload_path'] = './data/logo';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size'] = '20000';
                    $config['max_width']  = '150';
                    $config['max_height']  = '90';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = "logotop.png";

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_programa_imagen')){
                        $registro = array('alert', '<span class="text-warning">' . $this->upload->display_errors() . '<span>');
                    }
                    else{
                        $registro = array('exito', $name_file);
                    }
                }else{
                    $registro = array('alert', '<span class="text-danger">Tipo de archivo no permitido</span>');
                }
            } 
        }

        header('Content-type: application/json');
        
        echo json_encode( $registro );

    }


    function clear_file()
    {
        $clear_path = './data/logo/' . $this->input->post('file_archivo_nombre'); //utf8_decode($this->input->post('file_programa_anual'));
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }


    function actualizar_fecha()
    {
        $this->load->model('tpoadminv1/logo/Logo_model');
        $actualiza = $this->Logo_model->actualiza_fecha();
        
        switch ($actualiza) 
        {   
            case '1': $this->session->set_flashdata('exito', "Se ha actualizado correctamente");
                break;
            case 2: $this->session->set_flashdata('exito', "La fecha de actualizaci&oacute;n " . $this->input->post('fecha_act') . " ha sido inactivada");
               break;
            default: $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                break;
        }
        redirect('/tpoadminv1/logo/logo/alta_carga_logo');
    }

    function actualizar_recaptcha(){
        $this->load->model('tpoadminv1/logo/Logo_model');
        $registro = 0;
        $cad_a = "agregar"; $cad_e = "agregado"; 
        if(!empty($this->input->post('id_settings')) && intval($this->input->post('recaptcha') > 0)){
            $registro = $this->Logo_model->editar_recaptcha();
            $cad_a = "editar"; $cad_e = "editado"; 
        }else{
            $registro = $this->Logo_model->agregar_recaptcha();
        }

        if($registro == 0){
            $this->session->set_flashdata('alerta', "No fue posible ". $cad_a ." la reCATCHA.");
        }else {
            $this->session->set_flashdata('exito', "Se ha ". $cad_e ." la reCATCHA correctamente");
        }

        redirect('/tpoadminv1/logo/logo/alta_carga_logo');
    }

    function habilitarGrafica(){
        $this->load->model('tpoadminv1/logo/Logo_model');

        $registro = $this->Logo_model->habilitar_grafica();
        header('Content-type: application/json');

        echo json_encode( $registro );
    }

    

}
