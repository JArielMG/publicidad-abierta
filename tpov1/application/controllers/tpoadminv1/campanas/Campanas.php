<?php

/*
INAI / CAMPANAS
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Campanas extends CI_Controller
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
        $this->load->model('tpoadminv1/usuarios/Usuario_model');
        $is_rol_active = $this->Usuario_model->Is_Rol_Active($this->session->userdata('usuario_rol'));
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!isset($is_logged_in) || $is_logged_in != true) {
            redirect('tpoadminv1/cms');
        }else if(!isset($is_rol_active) || $is_rol_active != true){
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

    function permiso_capturista()
    {
        //Revisamos que el usuario sea administrador
        if($this->session->userdata('usuario_rol') != '2')
        {
            redirect('tpoadminv1/securecms/sin_permiso');
        }else if($this->session->userdata('usuario_id_so_atribucion') != 2 && $this->session->userdata('usuario_id_so_atribucion') != 3){
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }
    
    //Validamos las opciones que son necesarias
    function validate_tipo($str)
    {
        if($str != '0')
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function validate_subtipo($str)
    {
        if($str != '0')
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function validate_ejercicio($str)
    {
        if($str != '0')
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    function validate_trimestre($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_so_contratante($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_so_solicitante($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_tema($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_objetivo($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_cobertura($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    function validate_tipoTO($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_tiempo_oficial($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_estatus($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
       
    function validate_orden($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_estado($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    function validate_atribucion($str)
    {
        if($str != '0'){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    //Mostramos la vista cargada
    function busqueda_camp_edades()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_edad'] = $this->Campana_model->dame_todas_edades_campana();
        $data['edades'] = $this->Campana_model->dame_edades_campana_id($data['id_campana_aviso']);

        $this->load->view('tpoadminv1/campanas/alta_campana_edad', $data);
    }

    function dame_dif_edades_campana()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        
        $result = $this->Campana_model->dame_grupos_dif_campana();
        
        if($result != '0')
        {
            $sel_usuario = '';            
            echo '<option value="0">- Selecciona -</option>';            
				for($z = 0; $z < sizeof($result); $z++)
				{
					$sel_usuario .= '<option value="' . $result[$z]['id_poblacion_grupo_edad'] . '">'.$result[$z]['nombre_poblacion_grupo_edad']. '</option>';
				}            
            echo $sel_usuario;
        }
        else
        {
            echo '<option value="0">No hay valores</option>';
        }       
    }

    //Guardamos la edad en la BD
    function guarda_valor_camp()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $alta = $this->Campana_model->guarda_rel_camp();
        
        switch ($alta) 
        {
            case '1': $this->session->set_flashdata('exito', "Se ha agregado correctamente");
            
            //pasar el valor en una session para el redirect
            $this->session->set_userdata('id_campana_aviso', $this->input->post('id_campana_aviso'));
            
            redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos');

                break;
            case 2: $this->session->set_flashdata('error', "El correo " . $this->input->post('usuario_email') . " ya existe, ingresa otro");
                break;
            default: $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                break;
        }
    }

    function actualizar_valor_camp()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $actualiza = $this->Campana_model->actualiza_rel_camp();
        
        switch ($actualiza) 
        {
            case '1': $this->session->set_flashdata('exito', "Se ha actualizado correctamente");
                
                //pasar el valor en una session para el redirect
                $this->session->set_userdata('id_campana_aviso', $this->input->post('id_campana_aviso'));
                redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos');
                break;
            case 2: $this->session->set_flashdata('error', "El correo " . $this->input->post('usuario_email') . " ya existe, ingresa otro");
                redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos');
                break;
            default: $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos');
                break;
        }
    }

    function alta_camp_lugar()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['lugares'] = $this->Campana_model->dame_lugares_campana_id($data['id_campana_aviso']);   
        $this->load->view('tpoadminv1/campanas/alta_campana_lugar', $data);
    }

    function alta_camp_nivel()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];
        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_niveles'] = $this->Campana_model->dame_todos_niveles();
        
        $data['niveles'] = $this->Campana_model->dame_niveles_campana_id($data['id_campana_aviso']);

        $data['scripts'] = "<script type='text/javascript'>
                                $(function () {
                                
                            });
                            </script>";
        
        $this->load->view('tpoadminv1/campanas/alta_campana_nivel', $data);
    }
    
    function alta_camp_educacion()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_niveles_educativos'] = $this->Campana_model->dame_todos_niveles_educativos();

        $data['niveles_educativos'] = $this->Campana_model->dame_niveles_educativos_campana_id($data['id_campana_aviso']);

        $this->load->view('tpoadminv1/campanas/alta_campana_nivel_educativo', $data);
    }

    function alta_camp_sexo()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];
        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_sexos'] = $this->Campana_model->dame_todos_sexos();

        $data['sexos'] = $this->Campana_model->dame_sexos_campana_id($data['id_campana_aviso']);

        $this->load->view('tpoadminv1/campanas/alta_campana_sexo', $data);
    }

    function alta_camp_audios()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_tipo_liga'] = $this->Campana_model->dame_todos_tipos_ligas($data['id_campana_aviso']);
        $data['audios'] = $this->Campana_model->dame_audios_campana_id($data['id_campana_aviso']);
        
        $data['registro'] = array(
            'name_file_audio_edita' => '',
            'campana_file_audio_edita' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file_audios" => 'Formatos permitidos MP3, ACC, WMA y WAV.'
        );

        $data['scripts'] = "<script type='text/javascript'>
                                $(function () {
                                    $('input:file').change(function (){
                                        upload_file();
                                    });
                                     
                                });
                            </script>";
    
        $this->load->view('tpoadminv1/campanas/alta_campana_audios',$data);
    }

    function alta_camp_imagenes()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_tipo_liga'] = $this->Campana_model->dame_todos_tipos_ligas($data['id_campana_aviso']);
        $data['imagenes'] = $this->Campana_model->dame_imagenes_campana_id($data['id_campana_aviso']);
        
        $data['registro'] = array(
            'name_file_campana_imagen' => '',
            'name_file_campana_imagen_edita' => '',
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file_imagenes" => 'Formatos permitidos PDF, JPG y PNG.'
        );

        $data['scripts'] = "<script type='text/javascript'>
                                $(function () {
                                    $('input:file').change(function (){
                                        upload_file_edita_imagen();
                                    });
                                     
                                });
                            </script>";
    
        $this->load->view('tpoadminv1/campanas/alta_campana_imagenes',$data);
    }

    function alta_camp_imagenes2()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_tipo_liga'] = $this->Campana_model->dame_todos_tipos_ligas($data['id_campana_aviso']);
        
        $data['imagenes'] = $this->Campana_model->dame_imagenes_campana_id($data['id_campana_aviso']);

        $data['registro'] = array(
            'name_imagen_file' => '',
            'active' => 'null'
        );
        
        // poner true para ocultar los botones
        $data['control_update'] = array (
            'imagen_file_by_save' => false,
            'imagen_file_saved' => true,
            'imagen_file_see' => true,
            'imagen_file_load' => true, 
            "imagen_mensaje_file" => 'Formatos permitidos PDF, JPG y PNG.'
        );


        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    
                                "});" .
                            "</script>";
    
        $this->load->view('tpoadminv1/campanas/alta_campana_imagenes',$data);
    }

    function alta_camp_videos()
    {
        $data['id_campana_aviso'] = $_GET['id_campana_aviso'];

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data['cat_tipo_liga'] = $this->Campana_model->dame_todos_tipos_ligas($data['id_campana_aviso']);
        $data['videos'] = $this->Campana_model->dame_videos_campana_id($data['id_campana_aviso']);
        
        $data['registro'] = array(
            'name_file_campana_video' => '',
            'name_file_campana_video_edita' => '',
        );
        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file_videos" => 'Formatos permitidos AVI, MPEG, MOV y WMV.'
        );

        $data['scripts'] = "<script type='text/javascript'>
                                $(function () {
                                    $('input:file').change(function (){
                                        upload_file_video();
                                    });
                                     
                                });
                            </script>";
    
        $this->load->view('tpoadminv1/campanas/alta_campana_videos',$data);
    }
    
    function upload_file2()
    {
        $tipo_archivo = $_GET['tipo_archivo'];
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_anual']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){

                //Dependiendo del tipo de archivo que se va a subir, restringiremos los formatos permitidos
                switch ($tipo_archivo) 
                {
                    case 'audio':
                        $config['upload_path'] = './data/campanas/audios';
                        $extenciones = array('mp4');
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/audios/', utf8_decode($name_file));
                        break;
                    case 'imagen':
                        $config['upload_path'] = './data/campanas/imagenes';
                        $extenciones = array('jpg','png','pdf');   
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/imagenes/', utf8_decode($name_file));
                        break;
                    case 'video':
                        $config['upload_path'] = './data/campanas/videos';
                        $extenciones = array('mp4','3gp');
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/videos/', utf8_decode($name_file));
                        break;
                }

                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    // se guarda el archivo
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '1000';
                    $config['max_width']  = '1600';
                    $config['max_height']  = '1600';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_programa_anual')){
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

    function upload_file_documento()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {
            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_imagen']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('xlsx','xls','pdf','doc','docx');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/evaluacion/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/evaluacion';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

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
    }

    function upload_file_documento_edita()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');
        
        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {
            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_evaluacion']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('xlsx','xls','pdf','doc','docx');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/evaluacion/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/evaluacion';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_programa_evaluacion')){
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
    }

    function upload_file()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {
            //Validamos que el usuario tenga acceso
            $this->permiso_capturista();
            $this->load->model('tpoadminv1/Generales_model');

            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_anual']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('mp3','wma','wav','acc');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/audios/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/audios';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_programa_anual')){
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
    }

    function upload_file_edita_audio()
    {       
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {

            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_anual_edita']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('mp3','wma','wav','acc');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/audios/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/audios';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_programa_anual_edita')){
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
    }

    function upload_file_edita_imagen()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_campana_edita_imagen']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    //$extenciones = array('xlsx','xls','pdf','doc','docx');
                    $extenciones = array('png','jpg', 'pdf');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/imagenes/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/imagenes';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_campana_edita_imagen')){
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

    function upload_file_edita_video()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {   
            //Validamos que el usuario tenga acceso
            $this->permiso_capturista();
            $this->load->model('tpoadminv1/Generales_model');
            
            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_campana_video_edita']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('avi','mpeg','mov','wmv');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/videos/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/videos';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_campana_video_edita')){
                            $registro = array('alert', '<span class="text-warning">' . $this->upload->display_errors() . '<span>');
                        }
                        else{
                            $registro = array('exito', $name_file);
                        }
                    }else{
                        $registro = array('alert', '<span class="text-danger">Tipo de archivo no permitido</span>');
                    }
                }

                header('Content-type: application/json');
                echo json_encode( $registro );
            }
        }
    }

    function upload_file_imagen()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_campana_imagen']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('jpg','png','pdf');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/imagenes/', utf8_decode($name_file));
                    // se guarda el archivo
                    $config['upload_path'] = './data/campanas/imagenes';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '1600';
                    $config['max_height']  = '1600';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_campana_imagen')){
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

    function upload_file_imagen22()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_programa_imagen']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('jpg','png');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/imagenes/', utf8_decode($name_file));
                    // se guarda el archivo
                    $config['upload_path'] = './data/campanas/imagenes';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '1600';
                    $config['max_height']  = '1600';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_imagen')){
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

    function upload_file_video()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
        empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0)
        {
            echo "Error";
        }
        else
        {
            $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_campana_video']['name']), false);
            $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
            if(isset($name_file) && !empty($name_file))
            {
                $porciones = explode(".", $name_file);
                $size = sizeof($porciones);
                if($size >= 2){
                    $extenciones = array('avi','mpeg','mov','wmv');
                    $aux = strtolower($porciones[$size-1]); 
                    if(in_array($aux, $extenciones)){
                        $name_file = $this->Generales_model->existe_nombre_archivo('./data/campanas/videos/', utf8_decode($name_file));
                        // se guarda el archivo
                        $config['upload_path'] = './data/campanas/videos';
                        $config['allowed_types']        = '*';
                        $config['detect_mime']          = false;
                        $config['max_size']	= '20000';
                        $config['max_width']  = '1600';
                        $config['max_height']  = '1600';
                        $config['overwrite']  = TRUE;
                        $config['file_name']  = $name_file;

                        $this->load->library('upload', $config);

                        if(!$this->upload->do_upload('file_campana_video')){
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
    }

    function clear_file_documento()
    {
        $clear_path = './data/campanas/evaluacion' . $this->input->post('file_programa_imagen'); //utf8_decode($this->input->post('file_programa_anual'));
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function clear_file_agregar()
    {
        $clear_path = './data/campanas/audios/' . $this->input->post('name_file_input'); 

        if(file_exists($clear_path))
        {
            unlink($clear_path);

            $registro = array('exito','Eliminado');
            header('Content-type: application/json');
        }        
        echo json_encode( $registro );
    }

    function clear_file()
    {
        $clear_path = './data/campanas/audios/' . $this->input->post('name_file_programa_anual');

        if(file_exists($clear_path))
        {
            unlink($clear_path);

            $registro = array('exito','Eliminado');
            header('Content-type: application/json');
        }        
        echo json_encode( $registro );
    }

    function clear_file_imagen()
    {
        $clear_path = './data/campanas/imagenes/' . $this->input->post('name_file_campana_imagen'); //utf8_decode($this->input->post('file_programa_anual'));
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function clear_file_video()
    {
        $clear_path = './data/campanas/videos/' . $this->input->post('name_file_campana_video'); //utf8_decode($this->input->post('file_programa_anual'));
        
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function busqueda_campanas_avisos()    //Version con json
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/campanas/Campana_model');
                
        $data['title'] = "Campa&ntilde;as y avisos institucionales";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'campanas'; // solo active 
        $data['subactive'] = 'busqueda_campanas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/campanas/busqueda_campanas';
        $print_url = base_url() . "index.php/tpoadminv1/usuarios/print_ci/print_campanas";
        $print_url_exp = base_url() . "index.php/tpoadminv1/print_ci/exportar_facturas";
        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/campanas/campanas/preparar_exportacion_campanas";

        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['print_onclick_exp'] = "onclick=\"window.open('" . $print_url_exp . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['ejercicios'] = $this->Campana_model->dame_all_ejercicios(true);
        
        $data['registros'] = '';//$this->Facturas_model->dame_todas_facturas(false);
        $data['yearSelected'] = $this->uri->segment(5);
        $data['statusSelected'] = $this->uri->segment(6);
        
        
        $data['path_file_csv'] = ''; //$this->Facturas_model->descarga_facturas();
        $data['name_file_csv'] = "campanasyavisos.csv";
        $serviceSide = base_url() . "index.php/tpoadminv1/campanas/campanas/lista_campanas";

        $data['serviceSide'] = $serviceSide;
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'tipo' => 'Indica si se trata de una Campaña o de un Aviso Institucional.',
            'subtipo' => 'Indicar el subtipo de campaña o aviso institucional, según sea el caso.',
            'nombre' => 'Indica el nombre de la Campaña o Aviso Institucional',
            'autoridad' => 'Autoridad que proporcion&oacute; la clave.',
            'ejercicio' => 'Año en que se lleva a cabo la difusión de la campaña.',
            'trimestre' => 'Trimeste en que se lleva a cabo la difusión de la campaña.',
            'soc' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'sos' => 'Indica el nombre del sujeto que solicitó el producto o servicio aunque éste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretaría de Cultura; sujeto obligado contratante: Coordinación General de Comunicación Social).',
            'active' => 'Identifica si la campaña esta activa o inactiva.',
			'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa',            
            'tema' => 'Indica el tema de la campa&ntilde;a o aviso institucional (Ej. Salud, Educaci&oacute;n, etc.)',
            'objetivo_institucional' => 'Objetivo institucional de la campa&ntilde;a o aviso institucional',
            'objetivo_comunicacion' => 'Objetivo de comunicaci&oacute;n de la campa&ntilde;a o aviso institucional',
            'cobertura' => 'Alcance geogr&aacute;fico de la campa&ntilde;a o aviso institucional',
            'ambito_geo' => 'Descripci&oacute;n detalla de la campa&ntilde;a o aviso institucional',
            'fecha_inicio' => 'Fecha de inicio de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional',
            'fecha_termino' => 'Fecha de termino de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional',
            'evaluacion' => 'Evaluaci&oacute;n de la campa&ntilde;a de la campa&ntilde;a y/o aviso institucional',
            'tiempo_oficial' => 'Indica si se utiliz&oacute; o no, tiempo oficial en la transmisi&oacute;n de esa campa&ntilde;a o aviso institucional ',
            'monto_tiempo' => 'Monto total del tiempo de estado o tiempo fiscal consumidos',
            'hora_to' => '',
            'minutos_to' => '',
            'segundos_to' => '',
            'tipoTO' => '',
            'mensajeTO' => '',
            'descripcion_unidad' => '',
            'responsable_publisher' => '',
            'name_comercial' => '',
            'razones_supplier' => '',
            'difusion_mensaje' => '',
            'num_factura' => '',
            'fecha_inicio_tiempo_oficial' => 'Fecha de inicio del uso del tiempo oficial de la campa&ntilde;a de la campa&ntilde;a o aviso institucional',
            'fecha_termino_tiempo_oficial' => 'Fecha de termino del uso del tiempo oficial de la campa&ntilde;a de la campa&ntilde;a o aviso institucional',
            'segob' => 'Hiperv&iacute;nculo a la informaci&oacute;n sobre la utilizaci&oacute;n de Tiempo Oficial, publicada por la Direcci&oacute;n General de Radio, Televisi&oacute;n y Cinematograf&iacute;a, adscrita a la Secretar&iacute;a de Gobernaci&oacute;n',
            'pacs' => 'Nombre o denominaci&oacute;n del documento del programa anual de comunicaci&oacute;n social.',
            'fecha_publicacion' => 'Fecha en la que se public&oacute; en el Diario Oficial de la Federaci&oacute;n, peri&oacute;dico o gaceta, o portal de Internet institucional correspondiente ',
            'documento' => 'Documento de evaluaci&oacute;n',            
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'anio' => 'Año en que se lleva a cabo la difusión de la campaña.',
            'fecha_actualizacion' => 'Fecha de actualización',
            'nota' => 'Nota',
            'id_ejercicio' => 'Indica el año del ejercicio presupuestario.',
            'cambiar_estatus' => 'Cambia el estatus de todos los registros de acuerdo al año seleccionado.',
            'select_ejercicio' => 'Periodo que muestra los registros del año seleccionado.',
            'select_estatus' => 'Condición del registro de acuerdo al periodo seleccionado.'
        );
       
        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "$('[data-toggle=\"tooltip\"]').tooltip();
                                    setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                    "init();" .
                                "});" .
                                "$(function () {" .
                                    "inicializar_componentes();" .
                                "});" .
                                "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                    "inicializar_componentes();" .
                                 "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function lista_campanas($yearSelected = "",$statusSelected = ""){

        $yearSelected = $this->input->post('yearSelected');
        $statusSelected = $this->input->post('statusSelected');

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $data = $this->Campana_model->dame_todas_campanas($yearSelected,$statusSelected);



        
        header('Content-type: application/json');
        
        echo json_encode( $data );
    }

    function preparar_exportacion_campanas()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $path = $this->Campana_model->descarga_campanas_avisos();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path );
    }

	function edita_campanas_avisos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/campanas/Campana_model');
        
        $data['title'] = "Campa&ntilde;as y Avisos";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'campanas'; // solo active 
        $data['subactive'] = 'busqueda_campanas_avisos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/campanas/edita_campana';
        
        //Si la campana/aviso fue dado de alta y se redirecciono a esta pantalla, entonces tomamos el valor de data
        if(null !== $this->session->userdata('alta_campana_id'))
        {
            $this->session->set_userdata('id_campana_aviso', $this->session->userdata('alta_campana_id'));
        }

        if(null !== $this->input->post('id_campana_aviso'))
        {
            $this->session->set_userdata('id_campana_aviso', $this->input->post('id_campana_aviso'));
        }

        $data['campana'] = $this->Campana_model->dame_campana_id($this->session->userdata('id_campana_aviso'));
        $data['mensaje'] = $data['campana']['nombre_campana_aviso'];
        $data['camp_tipo'] = $this->Campana_model->dame_todos_camp_tipos();
        $data['camp_subtipo'] = $this->Campana_model->dame_todos_camp_subtipos();
        $data['ejercicios'] = $this->Campana_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Campana_model->dame_todos_trimestres();
        $data['so_contratantes'] = $this->Campana_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Campana_model->dame_todos_so_solicitantes(true);
        $data['temas'] = $this->Campana_model->dame_todos_temas();
        $data['objetivos'] = $this->Campana_model->dame_todos_objetivos();
        $data['coberturas'] = $this->Campana_model->dame_todas_coberturas();
        $data['tiposTO'] = $this->Campana_model->dame_todos_tiposTO();
        $data['categorias'] = $this->Campana_model->dame_todos_mediosCat();
		$data['docpacs'] = $this->Campana_model->dame_todos_docpacs();
        
        // poner true para ocultar los botones
        if(!empty($data['campana']['evaluacion_documento']))
        {
            $data['control_update'] = array(
                'file_by_save_documento' => true,
                'file_saved_documento' => false,
                'file_see_documento' => true,
                'file_load_documento' => true,
                'mensaje_file_documento' => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update'] = array(
                'file_by_save_documento' => false,
                'file_saved_documento' => true,
                'file_see_documento' => true,
                'file_load_documento' => true,
                'mensaje_file_documento' => 'Formatos permitidos PDF, WORD Y EXCEL.'
            );
        }

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'tipo' => 'Indica si se registra una campa&ntilde;a o un aviso institucional',
            'subtipo' => 'Indica el subtipo de la campa&ntilde;a o aviso institucional, de acuerdo al tipo',
            'nombre' => 'Título de la campa&ntilde;a o aviso institucional.',
            'autoridad' => 'Autoridad que proporcion&oacute; la clave',
            'ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'trimestre' => 'Indica el trimestre que se reporta (enero-marzo, abril-junio, julio-septiembre, octubre-diciembre).',
            'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa',
            'sos' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'soc' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque éste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretaría de Cultura sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'tema' => 'Indica el tema de la campa&ntilde;a o aviso institucional (Ej. Salud, Educaci&oacute;n, etc).',
            'obj_institucional' => 'Objetivo institucional de la campa&ntilde;a o aviso institucional.',
            'obj_comunicacion' => 'Objetivo de comunicaci&oacute;n de la campa&ntilde;a o aviso institucional.',
            'cobertura' => 'Alcance geográfico de la campa&ntilde;a o aviso institucional.',
            'amb_geografico' => 'Descripci&oacute;n detallada de la campa&ntilde;a o aviso institucional.',
            'fecha_inicio' => 'Fecha de inicio de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'fecha_termino' => 'Fecha de término de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'tiempo_oficial' => 'Indica si se utiliz&oacute; o no, tiempo oficial en la transmisi&oacute;n de esa campa&ntilde;a o aviso institucional.',
            'monto_tiempo' => 'Monto total del tiempo de estado o tiempo fiscal consumidos',
            'hora_to' => '',
            'minutos_to' => '',
            'segundos_to' => '',
            'tipoTO' => '',
            'mensajeTO' => '',
            'descripcion_unidad' => '',
            'responsable_publisher' => '',
            'name_comercial' => '',
            'razones_supplier' => '',
            'difusion_mensaje' => '',
            'num_factura' => '',
            'fecha_inicio_to' => 'Fecha de inicio del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'fecha_termino_to' => 'Fecha de término del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'segob' => 'Hipervínculo a la informaci&oacute;n sobre la utilizaci&oacute;n de Tiempo Oficial, publicada por Direcci&oacute;n General de Radio, Televisi&oacute;n y Cinematografía, adscrita a la Secretaría de Gobernaci&oacute;n.',
            'pacs' => 'Nombre o denominaci&oacute;n del documento del programa anual de comunicaci&oacute;n social.',
            'fecha_publicacion' => 'Fecha en la que se public&oacute; en el Diario Oficial de la Federaci&oacute;n, peri&oacutedico o gaceta, o portal de Internet institucional correspondiente.',
            'evaluacion' => '&#34;Evaluaci&oacute;n de la campa&ntilde;a y/o aviso institucional&#34;.',
            'doc_evaluacion' => 'Documento de evaluaci&oacute;n',
            'estatus' => 'Indica el estado de la informaci&oacute;n &#34;Activa&#34; o &#34;Inactiva&#34;.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => 'Área responsable de la informaci&oacute;n',
            'anio' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota'
        );

        $data['scripts'] = " ";
        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');".
                                    "jQuery('input[name=\"fecha_inicio_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" . 
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_inicio_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_dof\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha('#fecha_termino_periodo');" .
                                        "limitar_fecha('#fecha_inicio_periodo');" .
                                        "limitar_fecha('#fecha_termino');" .
                                        "limitar_fecha('#fecha_inicio');" .
                                        "limitar_fecha('#fecha_dof');" .
                                     "});" .
                                    
                                    "limitar_fecha('#fecha_termino_periodo');" .
                                    "limitar_fecha('#fecha_inicio_periodo');" .
                                    "limitar_fecha('#fecha_inicio');" .
                                    "limitar_fecha('#fecha_termino');" .
                                    "limitar_fecha('#fecha_dof');".
                                "});" .
                            "</script>";
            
        $data['scripts'] .= "<script type='text/javascript'>
                            $('#id_campana_tipo').on('change',function()
                            {
                                 var campana_tipo =  $(this).val();
                                 var tipo = 'id_campana_tipo=' + campana_tipo;
                                 $.ajax({
                                     type:'POST',
                                     url:'".site_url('tpoadminv1/campanas/campanas/busqueda_subtipo')." ',
                                     data: tipo,
                                     success:function(html){
                                         $('#id_campana_subtipo').html(html);
                                     }
                                 }); 
                             });
                            $(function () {
                                dame_subtipos('#id_campana_tipo');
                            });
                        </script>";

        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
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
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                "});" .
                            "</script>";

        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_edita_campanas_avisos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre_campana_aviso', 'Nombre', 'required|min_length[3]');

        //Creamos nuestros propios Form Validation 
        $this->form_validation->set_rules('id_campana_tipo', '"Tipo"', 'required|callback_validate_tipo');
        $this->form_validation->set_message('validate_tipo','Debes seleccionar un tipo.');
        $this->form_validation->set_rules('id_campana_subtipo', '"Subtipo"', 'required|callback_validate_subtipo');
        $this->form_validation->set_message('validate_subtipo','Debes seleccionar un subtipo.');
        $this->form_validation->set_rules('id_ejercicio', '"Ejercicio"', 'required|callback_validate_ejercicio');
        $this->form_validation->set_message('validate_ejercicio','Debes seleccionar un ejercicio.');
        $this->form_validation->set_rules('id_trimestre', '"Trimestre"', 'required|callback_validate_trimestre');
        $this->form_validation->set_message('validate_trimestre','Debes seleccionar un trimestre.');
        $this->form_validation->set_rules('id_so_contratante', 'Sujeto Obligado Contratante', 'required|callback_validate_so_contratante');
        $this->form_validation->set_message('validate_so_contratante','Debes seleccionar un Sujeto Obligado Contratante.');
        $this->form_validation->set_rules('id_so_solicitante', 'Sujeto Obligado Solicitante', 'required|callback_validate_so_solicitante');
        $this->form_validation->set_message('validate_so_solicitante','Debes seleccionar un Sujeto Obligado Solicitante.');
        $this->form_validation->set_rules('id_campana_tema', 'Tema', 'required|callback_validate_tema');
        $this->form_validation->set_message('validate_tema','Debes seleccionar un Tema.');
        $this->form_validation->set_rules('id_tiempo_oficial', 'Tiempo Oficial', 'required|callback_validate_tiempo_oficial');
        $this->form_validation->set_message('validate_tiempo_oficial','Debes seleccionar un tiempo oficial.');
        $this->form_validation->set_rules('active', 'Estatus', 'required|callback_validate_estatus');
        $this->form_validation->set_message('validate_estatus','Debes seleccionar un estatus.');
        $this->form_validation->set_rules('id_campana_objetivo', 'Objetivo', 'required|callback_validate_objetivo');
        $this->form_validation->set_message('validate_objetivo','Debes seleccionar un Objetivo.');
        $this->form_validation->set_rules('id_campana_cobertura', 'Objetivo', 'required|callback_validate_cobertura');
        $this->form_validation->set_message('validate_cobertura','Debes seleccionar una cobertura.');
        $this->form_validation->set_rules('fecha_inicio_periodo', 'Fecha de inicio del periodo que se informa', 'required|callback_fecha_inicio_periodo_check');
        $this->form_validation->set_rules('fecha_termino_periodo', 'Fecha de termino del periodo que se informa', 'required|callback_fecha_termino_periodo_check');
        $this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'callback_fecha_inicio_check');
        $this->form_validation->set_rules('fecha_termino', 'fecha de termino', 'callback_fecha_termino_check');
        $this->form_validation->set_rules('fecha_dof', 'fecha de publicación', 'callback_fecha_dof_check');
        $this->form_validation->set_rules('fecha_actualizacion', 'fecha de actualización', 'callback_fecha_actualizacion_check');
        $this->form_validation->set_rules('fecha_inicio_to', 'fecha de inicio tiempo oficial', 'callback_fecha_inicio_to_check');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Campa&ntilde;as y Avisos";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'campanas'; // solo active 
        $data['subactive'] = 'busqueda_campanas_avisos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/campanas/edita_campana';
        $data['campana'] = $this->Campana_model->dame_campana_id($this->session->userdata('id_campana_aviso'));
        $data['mensaje'] = $data['campana']['nombre_campana_aviso'];
        $data['camp_tipo'] = $this->Campana_model->dame_todos_camp_tipos();
        $data['camp_subtipo'] = $this->Campana_model->dame_todos_camp_subtipos();
        $data['ejercicios'] = $this->Campana_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Campana_model->dame_todos_trimestres();
        $data['so_contratantes'] = $this->Campana_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Campana_model->dame_todos_so_solicitantes(true);
        $data['temas'] = $this->Campana_model->dame_todos_temas();
        $data['objetivos'] = $this->Campana_model->dame_todos_objetivos();
        $data['coberturas'] = $this->Campana_model->dame_todas_coberturas();
        $data['tiposTO'] = $this->Campana_model->dame_todos_tiposTO();
        $data['categorias'] = $this->Campana_model->dame_todos_mediosCat();
		$data['docpacs'] = $this->Campana_model->dame_todos_docpacs();
        $data['registro'] = array(
            'id_presupuesto' => $this->input->post('id_presupuesto'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'denominacion' => $this->input->post('denominacion'),
            'fecha_publicacion' => $this->input->post('fecha_publicacion'),
            'file_programa_anual' => $this->input->post('file_programa_anual'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'fecha_inicio_periodo' => $this->input->post('fecha_inicio_periodo'),
            'fecha_termino_periodo' => $this->input->post('fecha_termino_periodo'),
            'area_responsable' => $this->input->post('area_responsable'),
            'anio' => $this->input->post('anio'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'monto_tiempo' => $this->input->post('monto_tiempo'),
            'hora_to' => $this->input->post('hota_to'),
            'minutos_to' => $this->input->post('minutos_to'),
            'segundos_to' => $this->input->post('segundos_to'),
            'mensajeTO' => $this->input->post('mensajeTO'),
            'descripcion_unidad' => $this->input->post('descripcion_unidad'),
            'responsable_publisher' => $this->input->post('responsable_publisher'),
            'name_comercial' => $this->input->post('name_comercial'),
            'razones_supplier' => $this->input->post('razones_supplier'),
            'difusion_mensaje' => $this->input->post('difusion_mensaje'),
            'num_factura' => $this->input->post('num_factura'),
            'nota' => $this->input->post('nota'),
            'mision' => $this->input->post('mision'),
            'objetivo' => $this->input->post('objetivo'),
            'metas' => $this->input->post('metas'),
            'programas' => $this->input->post('programas'),
            'objetivo_transversal' => $this->input->post('objetivo_transversal'),
            'temas' => $this->input->post('temas'),
            'conjunto_campanas' => $this->input->post('conjunto_campanas'),
            'nota_planeacion' => $this->input->post('nota_planeacion'),
            'name_file_programa_anual' => $this->input->post('name_file_programa_anual'),
            'active' => $this->input->post('active')
        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'tipo' => 'Indica si se registra una campa&ntilde;a o un aviso institucional',
            'subtipo' => 'Indica el subtipo de la campa&ntilde;a o aviso institucional, de acuerdo al tipo',
            'nombre' => 'Título de la campa&ntilde;a o aviso institucional.',
            'autoridad' => 'Autoridad que proporcion&oacute; la clave',
            'ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre, octubre-diciembre ).',
            'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa',
            'sos' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'soc' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque éste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretaría de Cultura sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'tema' => 'Indica el tema de la campa&ntilde;a o aviso institucional (Ej. Salud, Educaci&oacute;n, etc).',
            'obj_institucional' => 'Objetivo institucional de la campa&ntilde;a o aviso institucional.',
            'obj_comunicacion' => 'Objetivo de comunicaci&oacute;n de la campa&ntilde;a o aviso institucional.',
            'cobertura' => 'Alcance geográfico de la campa&ntilde;a o aviso institucional.',
            'amb_geografico' => 'Descripci&oacute;n detallada de la campa&ntilde;a o aviso institucional.',
            'fecha_inicio' => 'Fecha de inicio de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'fecha_termino' => 'Fecha de término de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'tiempo_oficial' => 'Indica si se utiliz&oacute o no, tiempo oficial en la transmisi&oacute;n de esa campa&ntilde;a o aviso institucional.',
            'monto_tiempo' => 'Monto total del tiempo de estado o tiempo fiscal consumidos',
            'hora_to' => '',
            'minutos_to' => '',
            'segundos_to' => '',
            'tipoTO' => '',
            'mensajeTO' => '',
            'descripcion_unidad' => '',
            'responsable_publisher' => '',
            'name_comercial' => '',
            'razones_supplier' => '',
            'difusion_mensaje' => '',
            'num_factura' => '', 
            'fecha_inicio_to' => 'Fecha de inicio del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'fecha_termino_to' => 'Fecha de término del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'segob' => 'Hipervínculo a la informaci&oacute;n sobre la utilizaci&oacute;n de Tiempo Oficial, publicada por Direcci&oacute;n General de Radio, Televisi&oacute;n y Cinematografía, adscrita a la Secretaría de Gobernaci&oacute;n.',
            'pacs' => 'Nombre o denominaci&oacute;n del documento del programa anual de comunicaci&oacute;n social.',
            'fecha_publicacion' => 'Fecha en la que se public&oacute en el Diario Oficial de la Federaci&oacute;n, peri&oacutedico o gaceta, o portal de Internet institucional correspondiente.',
            'evaluacion' => '&#34;Evaluaci&oacute;n de la campa&ntilde;a y/o aviso institucional&#34;.',
            'doc_evaluacion' => 'Documento de evaluaci&oacute;n',
            'estatus' => 'Indica el estado de la informaci&oacute;n &#34;Activa&#34; o &#34;Inactiva&#34;.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => 'Área responsable de la informaci&oacute;n',
            'anio' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota'
        );

        // poner true para ocultar los botones
        if(!empty($data['campana']['evaluacion_documento']))
        {
            $data['control_update'] = array(
                'file_by_save_documento' => true,
                'file_saved_documento' => false,
                'file_see_documento' => true,
                'file_load_documento' => true,
                'mensaje_file_documento' => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update'] = array(
                'file_by_save_documento' => false,
                'file_saved_documento' => true,
                'file_see_documento' => true,
                'file_load_documento' => true,
                'mensaje_file_documento' => 'Formatos permitidos PDF, WORD Y EXCEL.'
            );
        }

        $data['scripts'] = " ";
        
        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_inicio_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_inicio_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_dof\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha('#fecha_termino_periodo');" .
                                        "limitar_fecha('#fecha_inicio_periodo');" .
                                        "limitar_fecha('#fecha_termino');" .
                                        "limitar_fecha('#fecha_inicio');" .
                                        "limitar_fecha('#fecha_dof');" .
                                     "});" .
                                    
                                    "limitar_fecha('#fecha_termino_periodo');" .
                                    "limitar_fecha('#fecha_inicio_periodo');" .
                                    "limitar_fecha('#fecha_inicio');" .
                                    "limitar_fecha('#fecha_termino');" .
                                    "limitar_fecha('#fecha_dof');".
                                "});" .
                            "</script>";
            
        $data['scripts'] .= "<script>
                            $('#id_campana_tipo').on('change',function()
                             {
                                 var campana_tipo =  $(this).val();
                                 var tipo = 'id_campana_tipo=' + campana_tipo;
                                 $.ajax({
                                     type:'POST',
                                     url:'".site_url('tpoadminv1/campanas/campanas/busqueda_subtipo')." ',
                                     data: tipo,
                                     success:function(html){
                                         $('#id_campana_subtipo').html(html);
                                     }
                                 }); 
                             });

                             $(function () {
                                 dame_subtipos_post('#id_campana_tipo');
                             });
                         </script>";

        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "$('#partidas').dataTable({" .
                                        "'bPaginate': true," .
                                        "'bLengthChange': false," .
                                        "'bFilter': true," .
                                        "'bSort': true," .
                                        "'bInfo': true," .
                                        "'bAutoWidth': false," .
                                        "'oLanguage': { " .
                                            "'sSearch': 'Busqueda '," .
                                            "'sInfoFiltered': '(filtrado de un total de _MAX_ registros)'," .
                                            "'sInfo': 'Mostrando registros del <b>_START_</b> al <b>_END_</b> de un total de <b>_TOTAL_</b> registros'," .
                                            "'sZeroRecords': 'No se encontraron resultados'," .
                                            "'EmptyTable': 'Ningún dato disponible en esta tabla'," .
                                            "'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros'," .
                                            "'oPaginate': {" .
                                                "'sFirst': 'Primero'," .
                                                "'sLast': 'Último'," .
                                                "'sNext': 'Siguiente'," .
                                                "'sPrevious': 'Anterior'" .
                                            "}" .
                                        "}" .
                                    "});" .
                                    "'columnDefs': [ " .
                                            "{ 'orderable': false, 'targets': [8,9,10] } " .
                                        "],".
                                    "tinymce.init({ selector:'textarea' });" .
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
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                     "});" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;
       
        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $alta = $this->Campana_model->edita_campana($this->session->userdata('id_campana_aviso'));

            //print_r($edita_campana);

            $longitud_return = strlen($alta);
            
            if($longitud_return > 1)
            {
                $alta_1 = explode("|", $alta);
                $alta = $alta_1[0]; // return 1
                //echo $alta_1[1]; // return id ultima campana insertada
            }
            
            switch ($alta)
            {
                case '1':
                    $this->session->set_flashdata('exito', "El aviso institucional ".$this->input->post('nombre_campana_aviso')." ha sido modificado exitosamente.");
                    $this->session->set_flashdata('alta_campana_id',$alta_1[1]);
                    redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos', $alta_1[1]);
                    break;
                case '2':
                    $this->session->set_flashdata('exito', "La campa&ntilde;a ".$this->input->post('nombre_campana_aviso')." ha sido modificada exitosamente.");
                    $this->session->set_flashdata('alta_campana_id',$alta_1[1]);
                    redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos', $alta_1[1]);
                    break;
                case '3':
                    $this->session->set_flashdata('error', "Ya existe el aviso institucional ".$this->input->post('nombre_campana_aviso'));
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                case '4':
                    $this->session->set_flashdata('error', "Ya existe la campa&ntilde;a ".$this->input->post('nombre_campana_aviso'));
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                case '5':
                    $this->session->set_flashdata('error', "Ya existe una campaña o aviso institucional con la clave ".$this->input->post('clave_campana').", ingrese otra.");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                case '6':
                    $this->session->set_flashdata('error', "Ya existe una campaña o aviso institucional con el nombre ".$this->input->post('nombre_campana_aviso').", ingrese otro.");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                default: 
                    $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
            }
        }
    }

    function validate_edita_status_campanas_avisos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/campanas/Campana_model');
        $this->load->library('form_validation');

        $alta = $this->Campana_model->edita_status_campana();

        switch ($alta)
        {
            case '1':
                $this->session->set_flashdata('exito', "Los datos han sido modificados exitosamente.");
                redirect('/tpoadminv1/campanas/campanas/busqueda_campanas_avisos', $alta);
                break;
            default: 
                $this->session->set_flashdata('alert', "Hubo un error intente de nuevo");
                redirect('/tpoadminv1/campanas/campanas/busqueda_campanas_avisos');
                break;
        }
        
    }

    function dame_edad_rel_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_edad_edita($this->uri->segment(5),$this->uri->segment(6));

        print_r($detalles);
    }

    function dame_edad_disponibles_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_edad_alta($this->uri->segment(5));

        print_r($detalles);
    }

    function dame_nivel_rel_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_nivel_edita($this->uri->segment(5),$this->uri->segment(6));

        print_r($detalles);
    }

    function dame_nivel_disponibles_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_nivel_alta($this->uri->segment(5));

        print_r($detalles);
    }

    function dame_educacion_disponibles_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_educacion_alta($this->uri->segment(5));

        print_r($detalles);
    }

    function dame_educacion_rel_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_educacion_edita($this->uri->segment(5),$this->uri->segment(6));

        print_r($detalles);
    }

    function dame_sexo_disponibles_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_sexo_alta($this->uri->segment(5));

        print_r($detalles);
    }

    function dame_sexo_rel_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_sexo_edita($this->uri->segment(5),$this->uri->segment(6));

        print_r($detalles);
    }

    //AUDIOS
    function dame_tipo_liga_audio()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->tipo_liga_audio($this->uri->segment(5));

        print_r($detalles);
    }

    //VIDEOS
    function dame_tipo_liga_video_rel_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_opciones_tipo_liga_video($this->uri->segment(5));

        print_r($detalles);
    }

    //IMAGENES
    function dame_tipo_liga_imagen()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->tipo_liga_imagen($this->uri->segment(5));

        print_r($detalles);
    }

    function dame_detalles_campana_id()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $detalles = $this->Campana_model->dame_campana_id($this->uri->segment(5));

        print_r($detalles);
    }

    function obten_campana_nombre()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $campana = $this->Campana_model->dame_campana_nombre($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $campana );
    }

    function obten_campana_info()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $campana = $this->Campana_model->dame_campana_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $campana );
    }

	function fecha_inicio_periodo_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_inicio_periodo_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_inicio_periodo_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_inicio_periodo_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function fecha_termino_periodo_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_termino_periodo_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_termino_periodo_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_termino_periodo_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function fecha_inicio_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_inicio_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_inicio_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_inicio_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function fecha_termino_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_termino_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_termino_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_termino_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function fecha_dof_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_dof_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_dof_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_dof_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function fecha_actualizacion_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_actualizacion_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_actualizacion_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function fecha_inicio_to_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_inicio_to_check', 'El campo {field} es obligatorio');
            return TRUE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_inicio_to_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function eliminar_campana_aviso()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/campanas/Campana_model');

        $eliminar = $this->Campana_model->eliminar_campana($this->uri->segment(5));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "El registro no se pudo eliminar");
        }

        redirect('/tpoadminv1/campanas/campanas/busqueda_campanas_avisos');
    }

    function eliminar_relacion_campana()
    {
        
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/campanas/Campana_model');

        $eliminar = $this->Campana_model->elimina_rel_camp($this->uri->segment(5),$this->uri->segment(6));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "El registro no se pudo eliminar");
        }

        //redirect('/tpoadminv1/campanas/campanas/busqueda_campanas_avisos');
        redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos', $this->uri->segment(5));
    }

    function alta_campanas_avisos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/campanas/Campana_model');

        $data['title'] = "Campa&ntilde;as y Avisos";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'campanas'; // solo active 
        $data['subactive'] = 'busqueda_campanas_avisos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/campanas/alta_campana';
        $data['camp_tipo'] = $this->Campana_model->dame_todos_camp_tipos();
        $data['camp_subtipo'] = $this->Campana_model->dame_todos_camp_subtipos();
        $data['ejercicios'] = $this->Campana_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Campana_model->dame_todos_trimestres();
        $data['so_contratantes'] = $this->Campana_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Campana_model->dame_todos_so_solicitantes(true);
        $data['temas'] = $this->Campana_model->dame_todos_temas();
        $data['objetivos'] = $this->Campana_model->dame_todos_objetivos();
        $data['coberturas'] = $this->Campana_model->dame_todas_coberturas();
        $data['tiposTO'] = $this->Campana_model->dame_todos_tiposTO();
        $data['categorias'] = $this->Campana_model->dame_todos_mediosCat();
		$data['docpacs'] = $this->Campana_model->dame_todos_docpacs();

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'tipo' => 'Indica si se registra una campa&ntilde;a o un aviso institucional',
            'subtipo' => 'Indica el subtipo de la campa&ntilde;a o aviso institucional, de acuerdo al tipo',
            'nombre' => 'Título de la campa&ntilde;a o aviso institucional.',
            'autoridad' => 'Autoridad que proporcion&oacute; la clave',
            'ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre, octubre-diciembre ).',
            'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa', 
            'sos' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'soc' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque éste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretaría de Cultura sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'tema' => 'Indica el tema de la campa&ntilde;a o aviso institucional (Ej. Salud, Educaci&oacute;n, etc).',
            'obj_institucional' => 'Objetivo institucional de la campa&ntilde;a o aviso institucional.',
            'obj_comunicacion' => 'Objetivo de comunicaci&oacute;n de la campa&ntilde;a o aviso institucional.',
            'cobertura' => 'Alcance geográfico de la campa&ntilde;a o aviso institucional.',
            'amb_geografico' => 'Descripci&oacute;n detallada de la campa&ntilde;a o aviso institucional.',
            'fecha_inicio' => 'Fecha de inicio de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'fecha_termino' => 'Fecha de término de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'tiempo_oficial' => 'Indica si se utiliz&oacute o no, tiempo oficial en la transmisi&oacute;n de esa campa&ntilde;a o aviso institucional.',
            'monto_tiempo' => 'Monto total del tiempo de estado o tiempo fiscal consumidos',
            'hora_to' => '',
            'minutos_to' => '',
            'segundos_to' => '',
            'tipoTO' => '',
            'mensajeTO' => '',
            'descripcion_unidad' => '',
            'responsable_publisher' => '',
            'name_comercial' => '',
            'razones_supplier' => '',
            'difusion_mensaje' => '',
            'num_factura' => '',
            'fecha_inicio_to' => 'Fecha de inicio del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'fecha_termino_to' => 'Fecha de término del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'segob' => 'Hipervínculo a la informaci&oacute;n sobre la utilizaci&oacute;n de Tiempo Oficial, publicada por Direcci&oacute;n General de Radio, Televisi&oacute;n y Cinematografía, adscrita a la Secretaría de Gobernaci&oacute;n.',
            'pacs' => 'Nombre o denominaci&oacute;n del documento del programa anual de comunicaci&oacute;n social.',
            'fecha_publicacion' => 'Fecha en la que se public&oacute en el Diario Oficial de la Federaci&oacute;n, peri&oacutedico o gaceta, o portal de Internet institucional correspondiente.',
            'evaluacion' => '&#34;Evaluaci&oacute;n de la campa&ntilde;a y/o aviso institucional&#34;.',
            'doc_evaluacion' => 'Documento de evaluaci&oacute;n',
            'estatus' => 'Indica el estado de la informaci&oacute;n &#34;Activa&#34; o &#34;Inactiva&#34;.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => 'Área responsable de la informaci&oacute;n',
            'anio' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota'
        );

        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_presupuestos_partidas/".$this->uri->segment(5);
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['name_file_csv'] = "partidas_".$this->uri->segment(5).".csv";
        
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
            "mensaje_file" => 'Formatos permitidos PDF, WORD y EXCEL.'
        );

        $data['scripts'] = " ";
        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');".
                                    "jQuery('input[name=\"fecha_inicio_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" . 
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_inicio_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_dof\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha('#fecha_termino_periodo');" .
                                        "limitar_fecha('#fecha_inicio_periodo');" .
                                        "limitar_fecha('#fecha_termino');" .
                                        "limitar_fecha('#fecha_inicio');" .
                                        "limitar_fecha('#fecha_dof');" .
                                     "});" .
                                    
                                    "limitar_fecha('#fecha_termino_periodo');" .
                                    "limitar_fecha('#fecha_inicio_periodo');" .
                                    "limitar_fecha('#fecha_termino');" .
                                    "limitar_fecha('#fecha_inicio');" .
                                    "limitar_fecha('#fecha_dof');" .
                                    
                                "});" .
                            "</script>";
            
        $data['scripts'] .= "<script type='text/javascript'>
                                $('#id_campana_tipo').on('change',function()
                                {
                                    var campana_tipo =  $(this).val();
                                    var tipo = 'id_campana_tipo=' + campana_tipo;
                                    
                                    //if(campana_tipo != '0')
                                    //{
                                        $.ajax({
                                            type:'POST',
                                            url:'".site_url('tpoadminv1/campanas/campanas/busqueda_subtipo')." ',
                                            data: tipo,

                                            success:function(html){
                                                $('#id_campana_subtipo').html(html); 
                                            }
                                        }); 
                                    //}
                                });
                            </script>";

        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "$('#partidas').dataTable({" .
                                        "'bPaginate': true," .
                                        "'bLengthChange': false," .
                                        "'bFilter': true," .
                                        "'bSort': true," .
                                        "'bInfo': true," .
                                        "'bAutoWidth': false," .
                                        "'oLanguage': { " .
                                            "'sSearch': 'Busqueda '," .
                                            "'sInfoFiltered': '(filtrado de un total de _MAX_ registros)'," .
                                            "'sInfo': 'Mostrando registros del <b>_START_</b> al <b>_END_</b> de un total de <b>_TOTAL_</b> registros'," .
                                            "'sZeroRecords': 'No se encontraron resultados'," .
                                            "'EmptyTable': 'Ningún dato disponible en esta tabla'," .
                                            "'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros'," .
                                            "'oPaginate': {" .
                                                "'sFirst': 'Primero'," .
                                                "'sLast': 'Último'," .
                                                "'sNext': 'Siguiente'," .
                                                "'sPrevious': 'Anterior'" .
                                            "}" .
                                        "}" .
                                    "});" .
                                    "'columnDefs': [ " .
                                            "{ 'orderable': false, 'targets': [8,9,10] } " .
                                        "],".
                                    "tinymce.init({ selector:'textarea' });" .
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
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                     "});" .
                                "});" .
                            "</script>";

        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_alta_campanas_avisos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nombre_campana_aviso', 'Nombre', 'required|min_length[3]');

        //Creamos nuestros propios Form Validation 
        $this->form_validation->set_rules('id_campana_tipo', 'Tipo', 'required|callback_validate_tipo');
        $this->form_validation->set_message('validate_tipo','Debes seleccionar un tipo.');
        $this->form_validation->set_rules('id_campana_subtipo', 'Subtipo', 'required|callback_validate_subtipo');
        $this->form_validation->set_message('validate_subtipo','Debes seleccionar un subtipo.');
        $this->form_validation->set_rules('id_ejercicio', 'Ejercicio', 'required|callback_validate_ejercicio');
        $this->form_validation->set_message('validate_ejercicio','Debes seleccionar un ejercicio.');
        $this->form_validation->set_rules('id_trimestre', '"Trimestre"', 'required|callback_validate_trimestre');
        $this->form_validation->set_message('validate_trimestre','Debes seleccionar un trimestre.');
        $this->form_validation->set_rules('id_so_contratante', 'Sujeto Obligado Contratante', 'required|callback_validate_so_contratante');
        $this->form_validation->set_message('validate_so_contratante','Debes seleccionar un Sujeto Obligado Contratante.');
        $this->form_validation->set_rules('id_so_solicitante', 'Sujeto Obligado Solicitante', 'required|callback_validate_so_solicitante');
        $this->form_validation->set_message('validate_so_solicitante','Debes seleccionar un Sujeto Obligado Solicitante.');
        $this->form_validation->set_rules('id_campana_tema', 'Tema', 'required|callback_validate_tema');
        $this->form_validation->set_message('validate_tema','Debes seleccionar un Tema.');
        $this->form_validation->set_rules('id_tiempo_oficial', 'Tiempo Oficial', 'required|callback_validate_tiempo_oficial');
        $this->form_validation->set_message('validate_tiempo_oficial','Debes seleccionar un tiempo oficial.');
        $this->form_validation->set_rules('active', 'Estatus', 'required|callback_validate_estatus');
        $this->form_validation->set_message('validate_estatus','Debes seleccionar un estatus.');
        $this->form_validation->set_rules('id_campana_objetivo', 'Objetivo', 'required|callback_validate_objetivo');
        $this->form_validation->set_message('validate_objetivo','Debes seleccionar un Objetivo.');
        $this->form_validation->set_rules('id_campana_cobertura', 'Objetivo', 'required|callback_validate_cobertura');
        $this->form_validation->set_message('validate_cobertura','Debes seleccionar una cobertura.');
        $this->form_validation->set_rules('fecha_inicio_periodo', 'Fecha de inicio del periodo que se informa', 'required|callback_fecha_inicio_periodo_check');
        $this->form_validation->set_rules('fecha_termino_periodo', 'Fecha de termino del periodo que se informa', 'required|callback_fecha_termino_periodo_check');        
        $this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'callback_fecha_inicio_check');
        $this->form_validation->set_rules('fecha_termino', 'fecha de termino', 'callback_fecha_termino_check');
        $this->form_validation->set_rules('fecha_dof', 'fecha de publicación', 'callback_fecha_dof_check');
        $this->form_validation->set_rules('fecha_actualizacion', 'fecha de actualización', 'callback_fecha_actualizacion_check');
        $this->form_validation->set_rules('fecha_inicio_to', 'fecha de inicio tiempo oficial', 'callback_fecha_inicio_to_check');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agrega Campa&ntilde;a";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'campanas'; // solo active 
        $data['subactive'] = 'busqueda_campanas_aviso'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/campanas/alta_campana';

        $this->load->model('tpoadminv1/campanas/Campana_model');

        $data['camp_tipo'] = $this->Campana_model->dame_todos_camp_tipos();
        $data['camp_subtipo'] = $this->Campana_model->dame_todos_camp_subtipos();
        $data['ejercicios'] = $this->Campana_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Campana_model->dame_todos_trimestres();
        $data['so_contratantes'] = $this->Campana_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Campana_model->dame_todos_so_solicitantes(true);
        $data['temas'] = $this->Campana_model->dame_todos_temas();
        $data['objetivos'] = $this->Campana_model->dame_todos_objetivos();
        $data['coberturas'] = $this->Campana_model->dame_todas_coberturas();
        $data['tiposTO'] = $this->Campana_model->dame_todos_tiposTO();
        $data['categorias'] = $this->Campana_model->dame_todos_mediosCat();
		$data['docpacs'] = $this->Campana_model->dame_todos_docpacs();

        $data['registro'] = array(
            'id_factura' => '',
            'id_proveedor' => '',
            'id_contrato' => '',
            'id_orden_compra' => '',
            'id_ejercicio' => '',
            'id_trimestre' => '',
            'id_so_contratante' => '',
            'id_so_solicitante' => '',
            'id_presupuesto_concepto' => '',
            'numero_factura' => '',
            'fecha_erogacion' => '',
            'fecha_inicio_periodo' => '',
            'fecha_termino_periodo' => '',
            'file_factura_pdf' => '',
            'file_factura_xml' => '',
            'name_file_factura_pdf' => '',
            'name_file_factura_xml' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'active' => 'null',
            'fecha_dof' => 'null'
        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'tipo' => 'Indica si se registra una campa&ntilde;a o un aviso institucional',
            'subtipo' => 'Indica el subtipo de la campa&ntilde;a o aviso institucional, de acuerdo al tipo',
            'nombre' => 'Título de la campa&ntilde;a o aviso institucional.',
            'autoridad' => 'Autoridad que proporcion&oacute; la clave',
            'ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre, octubre-diciembre ).',
            'fecha_inicio_periodo' => 'Fecha de inicio del periodo que se informa',
            'fecha_termino_periodo' => 'Fecha de termino del periodo que se informa',       
            'sos' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'soc' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque éste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretaría de Cultura sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'tema' => 'Indica el tema de la campa&ntilde;a o aviso institucional (Ej. Salud, Educaci&oacute;n, etc).',
            'obj_institucional' => 'Objetivo institucional de la campa&ntilde;a o aviso institucional.',
            'obj_comunicacion' => 'Objetivo de comunicaci&oacute;n de la campa&ntilde;a o aviso institucional.',
            'cobertura' => 'Alcance geográfico de la campa&ntilde;a o aviso institucional.',
            'amb_geografico' => 'Descripci&oacute;n detallada de la campa&ntilde;a o aviso institucional.',
            'fecha_inicio' => 'Fecha de inicio de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'fecha_termino' => 'Fecha de término de la transmisi&oacute;n de la campa&ntilde;a o aviso institucional.',
            'tiempo_oficial' => 'Indica si se utiliz&oacute o no, tiempo oficial en la transmisi&oacute;n de esa campa&ntilde;a o aviso institucional.',
            'monto_tiempo' => 'Monto total del tiempo de estado o tiempo fiscal consumidos',
            'hora_to' => '',
            'minutos_to' => '',
            'segundos_to' => '',
            'tipoTO' => '',
            'mensajeTO' => '',
            'descripcion_unidad' => '',
            'responsable_publisher' => '',
            'name_comercial' => '',
            'razones_supplier' => '',
            'difusion_mensaje' => '',
            'num_factura' => '',
            'fecha_inicio_to' => 'Fecha de inicio del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'fecha_termino_to' => 'Fecha de término del uso de tiempo oficial de la campa&ntilde;a o aviso institucional.',
            'segob' => 'Hipervínculo a la informaci&oacute;n sobre la utilizaci&oacute;n de Tiempo Oficial, publicada por Direcci&oacute;n General de Radio, Televisi&oacute;n y Cinematografía, adscrita a la Secretaría de Gobernaci&oacute;n.',
            'pacs' => 'Nombre o denominaci&oacute;n del documento del programa anual de comunicaci&oacute;n social.',
            'fecha_publicacion' => 'Fecha en la que se public&oacute en el Diario Oficial de la Federaci&oacute;n, peri&oacutedico o gaceta, o portal de Internet institucional correspondiente.',
            'evaluacion' => '&#34;Evaluaci&oacute;n de la campa&ntilde;a y/o aviso institucional&#34;.',
            'doc_evaluacion' => 'Documento de evaluaci&oacute;n',
            'estatus' => 'Indica el estado de la informaci&oacute;n &#34;Activa&#34; o &#34;Inactiva&#34;.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => 'Área responsable de la informaci&oacute;n',
            'anio' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota'
        );
        
        $data['registro'] = array(
            'fecha_dof' => '',
            'name_file_imagen' => $this->input->post('name_file_imagen'),

            'name_file_evaluacion' => $this->input->post('name_file_evaluacion'),
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_imagen']))
        {
            $data['control_update'] = array(
                'file_by_save' => true,
                'file_saved' => false,
                'file_see' => true,
                'file_load' => true,
                "mensaje_file" => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update'] = array(
                'file_by_save' => false,
                'file_saved' => true,
                'file_see' => true,
                'file_load' => true,
                "mensaje_file" => 'Formatos permitidos PDF, WORD Y EXCEL.'
            );
        }
        
        $data['scripts'] = " ";
        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');".
                                    "jQuery('input[name=\"fecha_inicio_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_periodo\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" . 
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_inicio_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_termino_to\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_dof\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha('#fecha_termino_periodo');" .
                                        "limitar_fecha('#fecha_inicio_periodo');" .
                                        "limitar_fecha('#fecha_termino');" .
                                        "limitar_fecha('#fecha_inicio');" .
                                        "limitar_fecha('#fecha_dof');" .
                                     "});" .
                                    
                                    "limitar_fecha('#fecha_termino_periodo');" .
                                    "limitar_fecha('#fecha_inicio_periodo');" .
                                    "limitar_fecha('#fecha_inicio');" .
                                    "limitar_fecha('#fecha_termino');" .
                                    "limitar_fecha('#fecha_dof');".
                                "});" .
                            "</script>";
        
        $data['scripts'] .= "<script>
                               $('#id_campana_tipo').on('change',function()
                                {
                                    var campana_tipo =  $(this).val();
                                    var tipo = 'id_campana_tipo=' + campana_tipo;
                                    $.ajax({
                                        type:'POST',
                                        url:'".site_url('tpoadminv1/campanas/campanas/busqueda_subtipo')." ',
                                        data: tipo,
                                        success:function(html){
                                            $('#id_campana_subtipo').html(html);
                                        }
                                    }); 
                                });

                                $(function () {
                                    dame_subtipos('#id_campana_tipo');
                                });
                            </script>";

        $data['scripts'] .= "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' ".
                                    "});" .
                                    "$('.datepicker1').datepicker({ " .
                                        "daysNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']," .
		                                "daysNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],".
		                                "daysNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do']," .
		                                "months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],".
		                                "monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],".
		                                "today: 'Hoy'," .
                                        "todayHighlight: true " .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                "});" .
                            "</script>";

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }
        else 
        {
            $alta = $this->Campana_model->alta_campana();

            $longitud_return = strlen($alta);
            
            if($longitud_return > 1)
            {
                $alta_1 = explode("|", $alta);
                $alta = $alta_1[0]; // return 1
            }
            
            switch ($alta)
            {
                case '1':
                    $this->session->set_flashdata('exito', "El aviso institucional ".$this->input->post('nombre_campana_aviso')." ha sido dado de alta exitosamente.");
                    $this->session->set_flashdata('alta_campana_id',$alta_1[1]);
                    redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos', $alta_1[1]);
                    break;
                case '2':
                    $this->session->set_flashdata('exito', "La campa&ntilde;a ".$this->input->post('nombre_campana_aviso')." ha sido dada de alta exitosamente.");
                    $this->session->set_flashdata('alta_campana_id',$alta_1[1]);
                    redirect('/tpoadminv1/campanas/campanas/edita_campanas_avisos', $alta_1[1]);
                    break;
                case '3':
                    $this->session->set_flashdata('error', "Ya existe el aviso institucional ".$this->input->post('nombre_campana_aviso'));
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                case '4':
                    $this->session->set_flashdata('error', "Ya existe la campa&ntilde;a ".$this->input->post('nombre_campana_aviso'));
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                case '5':
                    $this->session->set_flashdata('error', "Ya existe una campaña o aviso institucional con la clave ".$this->input->post('clave_campana').", ingrese otra.");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
                default: 
                    $this->session->set_flashdata('alerta', "Hubo un error intente de nuevo");
                    $this->load->view('tpoadminv1/includes/template', $data);
                    break;
            }
        }
    }

    function campana_edades()
    {
        $data['title'] = "";
        $data['heading'] = "";
        $data['mensaje'] = "";
        $data['job'] = "";
        $data['active'] = "";
        $data['subactive'] = "";
        $data['body_class'] = "";
        $data['main_content'] = 'tpoadminv1/campanas/busqueda_campana_edad';

        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function get_sujeto()
    {
        $this->load->model('tpoadminv1/sujetos/Sujeto_model');
        $usuario_info = $this->Sujeto_model->get_sujeto_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $usuario_info );
    }
    
    function busqueda_subtipo()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $result = $this->Campana_model->dame_subtipo();
        
        if($result != '0')
        {
            $sel_subtipo = '';
            
            echo '<option value="0">- Selecciona -</option>';
            
            for($z = 0; $z < sizeof($result); $z++)
            {
                $sel_subtipo .= '<option value="' . $result[$z]['id_campana_subtipo'] . '">'.$result[$z]['nombre_campana_subtipo']. '</option>';
            }
            
            echo $sel_subtipo;
        }
        else
        {
            echo '<option value="0">No hay valores</option>';
        }
    }

    function busqueda_subtipo_edita()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $result = $this->Campana_model->dame_subtipo_post();
        
        if($result != '0')
        {
            $sel_subtipo = '';
            echo '<option value="0">- Selecciona -</option>';

            $selected = '';
            for($z = 0; $z < sizeof($result); $z++)
            {
                if($this->input->post('id_campana_subtipo') == $result[$z]['id_campana_subtipo'])
                {
                    $selected = 'selected';
                }
                else
                {
                    $selected = '';
                }

                $sel_subtipo .= '<option value="' . $result[$z]['id_campana_subtipo'] . '" '.$selected.'>'.$result[$z]['nombre_campana_subtipo']. '</option>';
            }
            
            echo $sel_subtipo;
        }
        else
        {
            echo '<option value="0">No hay valores</option>';
        }
    }

    function busqueda_subtipo_post()
    {
        $this->load->model('tpoadminv1/campanas/Campana_model');
        $result = $this->Campana_model->dame_subtipo_post();
        
        if($result != '0')
        {
            $sel_subtipo = '';
            echo '<option value="0">- Selecciona -</option>';

            $id_campana_tipo = $this->input->post('id_campana_subtipo');

            for($z = 0; $z < sizeof($result); $z++)
            {
                if($id_campana_tipo == $result[$z]['id_campana_subtipo'])
                {
                    $selected = 'selected';
                }
                else
                {
                    $selected = '';
                }
                $sel_subtipo .= '<option value="' . $result[$z]['id_campana_subtipo'] . '" '.$selected.'>
                                    '.$result[$z]['nombre_campana_subtipo']. '
                                </option>';
            }           
            echo $sel_subtipo;
        }
        else
        {
            echo '<option value="0">No hay valores</option>';
        }
    }

}