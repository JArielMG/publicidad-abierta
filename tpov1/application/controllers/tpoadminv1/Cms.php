<?php



/**
 * INAI 
 * Description of Cms
 *
 *
 */

if (!defined('BASEPATH'))
{
    exit('No direct script access allowed');
}

class Cms extends CI_Controller
{

    function guardar_bitacora($accion)
    {
        $data = array(
            'id_bitacora' => '0',
            'usuario_bitacora' => $this->session->userdata('usuario_id'),
            'seccion_bitacora' => 'Login',
            'accion_bitacora' => $accion,
            'fecha_bitacora' => date("Y-m-d H:i:s")
        );

        $this->db->insert('bitacora', $data);
        
        if($this->db->affected_rows() > 0)
        {
            return 1; 
        }
    }


    // Controlador principal que manda los datos de inicio a la forma de ingreso del sistema
    function index() 
    {
        $this->load->model('tpoadminv1/logo/Logo_model');
        $data['title'] = "Bienvenido ";
        $data['heading'] = "Ingresa tu usuario y contrase&ntildea";
        $data['body_class'] = 'login-page';
        $data['main_content'] = 'tpoadminv1/login';
        $data['recaptcha'] = $this->Logo_model->get_registro_recaptcha();

        $this->load->view('tpoadminv1/includes/template_login', $data);
    }

    function no_access()
    {
        $data['title'] = "No tienes acceso ";
        $data['heading'] = "No tienes acceso";
        $data['body_class'] = 'login-page';
        $data['main_content'] = 'cms/error';
        
        $data['error_number'] = '403';
        $data['error_description'] = 'No cuentas con el permiso sufiente para acceder a esta area ';

        $this->load->view('tpoadminv1/includes/template_login', $data);
    }
    

    function recaptcha_validate($recaptcha, $clave_secret){
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $clave_secret,
            'response' => $recaptcha
        );

        $options = array(
            'http' => array (
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captcha_success = json_decode($verify);
        return $captcha_success;
    }
    // Validamos que los campos vengan con datos y regresamos una respuesta a la vista
    function validate_credentials() 
    {
        $this->load->model('tpoadminv1/logo/Logo_model');
        $this->load->model('tpoadminv1/usuarios/Usuario_model');
        $this->load->model('tpoadminv1/Membership_model');
        $this->load->library('form_validation');

        $conf_recaptcha = $this->Logo_model->get_registro_recaptcha();
        $recaptcha_estatus = TRUE;
        if(isset($conf_recaptcha) && $conf_recaptcha->active == 1){
            $recaptcha = $this->input->post('g-recaptcha-response');
            $captcha_success = $this->recaptcha_validate($recaptcha, $conf_recaptcha->clave);
            $recaptcha_estatus = $captcha_success->success;
        }

        $this->form_validation->set_rules('username', 'Usuario', 'trim|required');
        $this->form_validation->set_rules('password', 'Contrase&ntilde;a', 'trim|required');
        $this->form_validation->set_error_delimiters('<p>','</p>');
        
        if ($this->form_validation->run() == FALSE || !$recaptcha_estatus) 
        {
            $data['title'] = "Bienvenido ";
            $data['heading'] = "Ingresa tu usuario y contrase&ntildea";
            $data['body_class'] = 'login-page';
            $data['main_content'] = 'tpoadminv1/login';
            $data['recaptcha'] = $conf_recaptcha;
            $data['error_recaptcha'] = '';
            if(!$recaptcha_estatus){
                $data['error_recaptcha'] = '<p>Favor de verificar la reCAPTCHA.</p>';
            }

            $this->load->view('tpoadminv1/includes/template_login', $data);
        } 
        else 
        {
            $query = $this->Membership_model->validate_cms();
            
            if($query == '1')
            {
                $data['title'] = "Bienvenido ";
                $data['heading'] = "Ingresa tu usuario y contrase&ntildea";
                $data['body_class'] = 'login-page';
                $data['main_content'] = 'tpoadminv1/login';
                $data['recaptcha'] = $conf_recaptcha;
                $data['mensaje_error'] = 'usuario';
                $this->load->view('tpoadminv1/includes/template_login', $data);
                
            }
            else if($query == '2')
            {
                $data['title'] = "Bienvenido ";
                $data['heading'] = "Ingresa tu usuario y contrase&ntildea";
                $data['body_class'] = 'login-page';
                $data['main_content'] = 'tpoadminv1/login';
                $data['recaptcha'] = $conf_recaptcha;
                $data['mensaje_error'] = 'contrasena';
                $this->load->view('tpoadminv1/includes/template_login', $data);

            }  
            else
            {
                if($this->Usuario_model->Is_Rol_Active($query['usuario_rol'])){
                    $data = array(
                        'usuario_id' => $query['usuario_id'],
                        'usuario_alias' => $query['usuario_alias'],
                        'usuario_email' => $query['usuario_email'],
                        'usuario_nombre' => $query['usuario_nombre'],
                        'usuario_rol' => $query['usuario_rol'],
                        'usuario_rol_nombre' => $query['usuario_rol_nombre'],
                        'usuario_id_so_atribucion' =>$query['usuario_id_so_atribucion'],
                        'is_logged_in' => true
                    );
    
                    $this->session->set_userdata($data);
    
    
                    $bitacora = $this->guardar_bitacora('Ingreso al sistema');
                    if($bitacora == '1')
                    {
                        //Dependiendo del tipo de rol que sea el usuario, lo redireccionaremos
                        if($data['usuario_rol_nombre'] == 'Administrador')
                        {
                            redirect('tpoadminv1/usuarios/usuarios/busqueda_usuario');
                        }
                        else if($data['usuario_rol_nombre'] == 'Financiero')
                        {
                            redirect('tpoadminv1/capturista/presupuestos/busqueda_presupuestos');
                        }
                        else 
                        {
                            //dependiendo el id de atribucion de redirije
                            if($data['usuario_id_so_atribucion'] == 1){
                                redirect('tpoadminv1/capturista/proveedores/busqueda_proveedores');
                            }else if($data['usuario_id_so_atribucion'] == 2){
                                redirect('tpoadminv1/campanas/campanas/busqueda_campanas_avisos');
                            }else if($data['usuario_id_so_atribucion'] == 3){
                                redirect('tpoadminv1/capturista/proveedores/busqueda_proveedores');
                            }else{
                                redirect('tpoadminv1/securecms/sin_permiso');
                            }
                        }
                    } 
                }else{
                    $data['title'] = "Bienvenido ";
                    $data['heading'] = "Ingresa tu usuario y contrase&ntildea";
                    $data['body_class'] = 'login-page';
                    $data['main_content'] = 'tpoadminv1/login';
                    $data['recaptcha'] = $conf_recaptcha;
                    $data['mensaje_error'] = 'rol';
                    $this->load->view('tpoadminv1/includes/template_login', $data);
                }
            }
        }
    }

}