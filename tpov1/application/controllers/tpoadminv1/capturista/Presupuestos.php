<?php

/**
 * Description of Presupuestos
 *
 * INAI TPO
 */

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Presupuestos extends CI_Controller
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
        }else if($this->session->userdata('usuario_id_so_atribucion') != 1 && $this->session->userdata('usuario_id_so_atribucion') != 3 ){
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

    function monto_presupuesto_check($num){
        if(empty($num))
        {
            $this->form_validation->set_message('monto_presupuesto_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{

            if(is_numeric($num)){
                $mf = floatval($this->input->post('monto_fuente_federal'));
                $ml = floatval($this->input->post('monto_fuente_local'));


                if( round(floatval($num),2) != round(($mf + $ml),2) ){
                    $this->form_validation->set_message('monto_presupuesto_check', 'En el campo {field}, el valor ingresado no coincide con la suma del "monto asignado federal" y el "monto asignado local", favor de revisar.');
                    return FALSE;
                }
               
            }else{
                $this->form_validation->set_message('monto_presupuesto_check', 'El campo {field} debe ser un valor n&uacute;merico valido');
                return FALSE;
            }
            return TRUE;
        }
    }

    function busqueda_presupuestos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');
                
        $data['title'] = "Planeaci&oacute;n y presupuestos";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/busqueda_presupuestos';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_planeacion_presupuestos";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['registros'] = $this->Presupuestos_model->dame_todos_presupuestos();
        
        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/capturista/presupuestos/preparar_exportacion_presupuestos";
        $data['path_file_csv'] = '';  //$this->Presupuestos_model->descarga_presupuestos();
        $data['name_file_csv'] = "presupuestos.csv";

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = $this->Generales_model->get_texto_ayuda_presupuesto();

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                        
                                    "$('#proveedores').dataTable({" .
                                        "'bPaginate': true," .
                                        "'bLengthChange': true," .
                                        "'bFilter': true," .
                                        "'bSort': true," .
                                        "'bInfo': true," .
                                        "'bAutoWidth': false," .
                                        "'columnDefs': [ " .
                                            "{ 'orderable': false, 'targets': [7,8,9] } " .
                                        "],".
                                        "'aLengthMenu': [[10, 25, 50, -1], [10, 25, 50, 'Todo']], " .   //Paginacion
                                        "'oLanguage': { " .
                                            "'sSearch': 'B&uacute;squeda '," .
                                            "'sInfoFiltered': '(filtrado de un total de _MAX_ registros)'," .
                                            "'sInfo': 'Mostrando registros del <b>_START_</b> al <b>_END_</b> de un total de <b>_TOTAL_</b> registros'," .
                                            "'sZeroRecords': 'No se encontraron resultados'," .
                                            "'EmptyTable': 'Ning&uacute;n dato disponible en esta tabla'," .
                                            "'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros'," .
                                            "'oPaginate': {" .
                                                "'sFirst': 'Primero'," .
                                                "'sLast': '&Uacute;ltimo'," .
                                                "'sNext': 'Siguiente'," .
                                                "'sPrevious': 'Anterior'" .
                                            "}," .
                                            "'sLengthMenu': '_MENU_ Registros por p&aacute;gina'" .
                                        "}" .
                                    "});" .
                                    "$('[data-toggle=\"tooltip\"]').tooltip();
                                    setTimeout(function() { " .
                                        "$('.alert').alert('close');" .
                                    "}, 3000);" .
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);

    }

    function agregar_presupuesto()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $data['title'] = "Agregar planeaci&oacute;n y presupuesto";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/agregar_presupuesto';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['sujetos'] = $this->Presupuestos_model->dame_todos_sujetos(true);
        $data['registro'] = array(
            'id_presupuesto' => '',
            'id_ejercicio' => '',
            'id_sujeto_obligado' => '',
            'denominacion' => '',
            'fecha_publicacion' => '',
            'url_programa_anual' => '',
            'file_programa_anual' => '',
            'fecha_validacion' => '',
			'fecha_inicio_periodo' => '',
            'fecha_termino_periodo' => '',
            'area_responsable' => '',
            'anio' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'mision' => '',
            'objetivo' => '',
            'metas' => '',
            'temas' => '',
            'programas' => '',
            'objetivo_transversal' => '',
            'conjunto_campanas' => '',
            'nota_planeacion' => '',
            'name_file_programa_anual' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = $this->Generales_model->get_texto_ayuda_presupuesto();

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formatos permitidos PDF,  Word y Excel.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_publicacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
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

    function validate_agregar_presupuesto()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_sujeto_obligado', 'Sujeto obligado', 'required');
		$this->form_validation->set_rules('fecha_inicio_periodo', 'Fecha de inicio del periodo que se informa', 'required');
        $this->form_validation->set_rules('fecha_termino_periodo', 'Fecha de termino del periodo que se informa', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar planeaci&oacute;n y presupuesto";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/agregar_presupuesto';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['sujetos'] = $this->Presupuestos_model->dame_todos_sujetos(true);
        $data['registro'] = array(
            'id_presupuesto' => '',
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_sujeto_obligado' => $this->input->post('id_sujeto_obligado'),
            'denominacion' => $this->input->post('denominacion'),
            'fecha_publicacion' => $this->input->post('fecha_publicacion'),
            'url_programa_anual' => $this->input->post('url_programa_anual'),
            'file_programa_anual' => $this->input->post('file_programa_anual'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
			'fecha_inicio_periodo' => $this->input->post('fecha_inicio_periodo'),
            'fecha_termino_periodo' => $this->input->post('fecha_termino_periodo'),
            'area_responsable' => $this->input->post('area_responsable'),
            'anio' => $this->input->post('anio'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
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

        // poner true para ocultar los botones
        if(!empty($this->input->post('name_file_programa_anual')))
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
                "mensaje_file" => 'Formatos permitidos PDF,  Word y Excel.'
            );
        }

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = $this->Generales_model->get_texto_ayuda_presupuesto();

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_publicacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"file\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Presupuestos_model->agregar_presupuesto();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "El presupuesto se ha creado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El presupuesto no se pudo agregar");
            }
            if($redict)
            {
                
                $id = $this->Presupuestos_model->last_id_presupuesto();
                if($id != 0){
                    $this->session->set_flashdata('tab_flag', "desglose");
                    redirect('/tpoadminv1/capturista/presupuestos/editar_presupuesto/'.$id);
                }else{
                    redirect('/tpoadminv1/capturista/presupuestos/busqueda_presupuestos');
                }
            } 
        }
    }

    function editar_presupuesto()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');

        $data['title'] = "Editar planeaci&oacute;n y presupuesto";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/editar_presupuesto';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['sujetos'] = $this->Presupuestos_model->dame_todos_sujetos(true);
        $data['registro'] = $this->Presupuestos_model->dame_presupuesto_id($this->uri->segment(5));
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = $this->Generales_model->get_texto_ayuda_presupuesto();

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_programa_anual']))
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
                "mensaje_file" => 'Formatos permitidos PDF,  Word y Excel.'
            );
        }

        //info para las partidas 
        $data['registros'] = $this->Presupuestos_model->dame_todos_presupuestos_conceptos($this->uri->segment(5));
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_presupuestos_partidas/".$this->uri->segment(5);
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['path_file_csv'] = $this->Presupuestos_model->descarga_presupuestos_conceptos($this->uri->segment(5));
        $data['name_file_csv'] = "partidas_".$this->uri->segment(5).".csv";
        
        $data['scripts'] = "<script type='text/javascript'>" .
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
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_publicacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
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

    function validate_editar_presupuesto()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_sujeto_obligado', 'Sujeto obligado', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar planeaci&oacute;n y presupuesto";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/editar_presupuesto';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['sujetos'] = $this->Presupuestos_model->dame_todos_sujetos(true);
        $data['registro'] = array(
            'id_presupuesto' => $this->input->post('id_presupuesto'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_sujeto_obligado' => $this->input->post('id_sujeto_obligado'),
            'denominacion' => $this->input->post('denominacion'),
            'fecha_publicacion' => $this->input->post('fecha_publicacion'),
            'url_programa_anual' => $this->input->post('url_programa_anual'),
            'file_programa_anual' => $this->input->post('file_programa_anual'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
			'fecha_inicio_periodo' => $this->input->post('fecha_inicio_periodo'),
            'fecha_termino_periodo' => $this->input->post('fecha_termino_periodo'),
            'area_responsable' => $this->input->post('area_responsable'),
            'anio' => $this->input->post('anio'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
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
        $data['texto_ayuda']  = $this->Generales_model->get_texto_ayuda_presupuesto();

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_programa_anual']))
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
                "mensaje_file" => 'Formatos permitidos PDF,  Word y Excel.'
            );
        }

        //info para las partidas 
        $data['registros'] = $this->Presupuestos_model->dame_todos_presupuestos_conceptos($this->uri->segment(5));
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_presupuestos_partidas";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['path_file_csv'] = $this->Presupuestos_model->descarga_presupuestos_conceptos($this->uri->segment(5));
        $data['name_file_csv'] = "partidas_".$this->uri->segment(5).".csv";

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_publicacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"file\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;
       
        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            
            $redict = true;
            $agregar = $this->Presupuestos_model->editar_presupuesto();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "El presupuesto se ha editado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El presupuesto no se pudo editar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/presupuestos/busqueda_presupuestos');
            } 
        }
    }

    function clear_file()
    {
        $clear_path = './data/programas/' . $this->input->post('file_programa_anual'); //utf8_decode($this->input->post('file_programa_anual'));
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function upload_file()
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
                $extenciones = array('xlsx','xls','pdf','doc','docx');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){
                    
                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/programas/', utf8_decode($name_file));
                    
                    // se guarda el archivo
                    $config['upload_path'] = './data/programas';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
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

    function eliminar_presupuesto()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Presupuestos_model');

        $viable_eliminar = $this->Presupuestos_model->dependencia_presupuesto_id($this->uri->segment(5));

        if($viable_eliminar){
            $eliminar = $this->Presupuestos_model->eliminar_presupuesto($this->uri->segment(5));

            if($eliminar == 1){
                $this->session->set_flashdata('exito', "Registro eliminado correctamente");
            }else {
                $this->session->set_flashdata('error', "Registro no se pudo eliminar");
            }
        }else {
            $this->session->set_flashdata('error', "Este presupuesto  tiene partidas asociadas , será necesario eliminar primero las partidas presupuestales.");
        }

        redirect('/tpoadminv1/capturista/presupuestos/busqueda_presupuestos');
    }

    function get_presupuesto()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $registro = $this->Presupuestos_model->dame_presupuesto_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function agregar_presupuesto_partida()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        $data['title'] = "Agregar partida presupuestal";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/agregar_presupuesto_partida';

        $data['conceptos'] = $this->Catalogos_model->dame_todos_presupuestos_active();
        $data['registro'] = array(
            'id_presupuesto_desglose' => '',
            'id_presupuesto' => $this->uri->segment(5),
            'id_presupuesto_concepto' => '',
            'fuente_federal' => '',
            'monto_fuente_federal' => '0.00',
            'fuente_local' => '',
            'monto_fuente_local' => '0.00',
            'monto_presupuesto' => '0.00',
            'monto_modificacion' => '0.00',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'denominacion' => '',
            'fecha_publicacion' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_presupuesto_desglose' => '',
            'id_presupuesto' => '',
            'id_presupesto_concepto' => 'Indica la clave de la partida presupuestal',
            'monto_asignado' => 'Monto asignado a la partida correspondiente.',
            'monto_modificacion' => 'Monto de modificaci&oacute;n, puede ser un n&uacute;mero negativo o positivo.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'denominacion' => '',
            'fuente_federal' => 'Son los que provienen de la Federaci&oacute;n, destinados a las Entidades Federativas y los Municipios, en t&eacute;rminos de la Ley Federal de Presupuesto y Responsabilidad Hacendaria y el Presupuesto de Egresos de la Federaci&oacute;n, que est&aacute;n destinados a un fin espec&iacute;fico por concepto de aportaciones, convenios de recursos federales etiquetados y fondos distintos de aportaciones.',
            'monto_fuente_federal' => 'Monto asignado a la fuente federal.',
            'fuente_local' => 'En el caso de los Municipios, son los que provienen del Gobierno Estatal y que cuentan con un destino espec&iacute;fico, en t&eacute;rminos de la Ley de Ingresos Estatal y del Presupuesto de Egresos Estatal.',
            'monto_fuente_local' => 'Monto asignado a la fuente local.',
            'estatus' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'sin_definir' => 'Sin definir'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"number\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_local\"]').on('input', function(){" .
                                        "monto_total();" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_federal\"]').change(function(){" .
                                        "monto_total();" .
                                    "});" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_presupuesto_partida()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_presupuesto_concepto', 'partida presupuestal', 'required');
        $this->form_validation->set_rules('monto_presupuesto', 'Monto asignado total', 'callback_monto_presupuesto_check');
        $this->form_validation->set_rules('monto_modificacion', 'Monto de modificaci&oacute;n', 'trim|required');
        $this->form_validation->set_rules('fuente_federal', 'fuente presupuestaria federal', 'trim|required');
        $this->form_validation->set_rules('monto_fuente_federal', 'Monto asignado federal', 'trim|required');
        $this->form_validation->set_rules('fuente_local', 'fuente presupuestaria local', 'trim|required');
        $this->form_validation->set_rules('monto_fuente_local', 'Monto asignado local', 'trim|required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar partida presupuestal";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/agregar_presupuesto_partida';
        
        $data['conceptos'] = $this->Catalogos_model->dame_todos_presupuestos_active();
        $data['registro'] = array(
            'id_presupuesto_desglose' => $this->input->post('id_presupuesto_desglose'),
            'id_presupuesto' => $this->input->post('id_presupuesto'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'fuente_federal' => $this->input->post('fuente_federal'),
            'monto_fuente_federal' => $this->input->post('monto_fuente_federal'),
            'fuente_local' => $this->input->post('fuente_local'),
            'monto_fuente_local' => $this->input->post('monto_fuente_local'),
            'monto_presupuesto' => $this->input->post('monto_presupuesto'),
            'monto_modificacion' => $this->input->post('monto_modificacion'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'denominacion' => $this->input->post('denominacion'),
            'fecha_publicacion' => $this->input->post('fecha_publicacion'),
            'active' => $this->input->post('active')
        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_presupuesto_desglose' => '',
            'id_presupuesto' => '',
            'id_presupesto_concepto' => 'Indica la clave de la partida presupuestal',
            'monto_asignado' => 'Monto asignado a la partida correspondiente.',
            'monto_modificacion' => 'Monto de modificaci&oacute;n, puede ser un n&uacute;mero negativo o positivo.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'denominacion' => '',
            'fuente_federal' => 'Son los que provienen de la Federaci&oacute;n, destinados a las Entidades Federativas y los Municipios, en t&eacute;rminos de la Ley Federal de Presupuesto y Responsabilidad Hacendaria y el Presupuesto de Egresos de la Federaci&oacute;n, que est&aacute;n destinados a un fin espec&iacute;fico por concepto de aportaciones, convenios de recursos federales etiquetados y fondos distintos de aportaciones.',
            'monto_fuente_federal' => 'Monto asignado a la fuente federal.',
            'fuente_local' => 'En el caso de los Municipios, son los que provienen del Gobierno Estatal y que cuentan con un destino espec&iacute;fico, en t&eacute;rminos de la Ley de Ingresos Estatal y del Presupuesto de Egresos Estatal.',
            'monto_fuente_local' => 'Monto asignado a la fuente local.',
            'estatus' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'sin_definir' => 'Sin definir'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"number\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_local\"]').on('input', function(){" .
                                        "monto_total();" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_federal\"]').change(function(){" .
                                        "monto_total();" .
                                    "});" .
                                "});" .
                            "</script>";

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Presupuestos_model->agregar_presupuesto_partida();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "La partida se ha creado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "La partida ya se encuentra registrada");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La partida no se pudo agregar");
            }
            if($redict)
            {
                
                $this->session->set_flashdata('tab_flag', "desglose");
                redirect('/tpoadminv1/capturista/presupuestos/editar_presupuesto/'. $this->input->post('id_presupuesto'));
            } 
        }
    }

    function editar_presupuesto_partida()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');

        $data['title'] = "Editar partida presupuestal";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/editar_presupuesto_partida';

        $data['conceptos'] = $this->Catalogos_model->dame_todos_presupuestos_active();
        $data['registro'] = $this->Presupuestos_model->dame_presupuestos_desglose_id($this->uri->segment(5));
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_presupuesto_desglose' => '',
            'id_presupuesto' => '',
            'id_presupesto_concepto' => 'Indica la clave de la partida presupuestal',
            'monto_asignado' => 'Monto asignado a la partida correspondiente.',
            'monto_modificacion' => 'Monto de modificaci&oacute;n, puede ser un n&uacute;mero negativo o positivo.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'denominacion' => '',
            'estatus' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'fuente_federal' => 'Son los que provienen de la Federaci&oacute;n, destinados a las Entidades Federativas y los Municipios, en t&eacute;rminos de la Ley Federal de Presupuesto y Responsabilidad Hacendaria y el Presupuesto de Egresos de la Federaci&oacute;n, que est&aacute;n destinados a un fin espec&iacute;fico por concepto de aportaciones, convenios de recursos federales etiquetados y fondos distintos de aportaciones.',
            'monto_fuente_federal' => 'Monto asignado a la fuente federal.',
            'fuente_local' => 'En el caso de los Municipios, son los que provienen del Gobierno Estatal y que cuentan con un destino espec&iacute;fico, en t&eacute;rminos de la Ley de Ingresos Estatal y del Presupuesto de Egresos Estatal.',
            'monto_fuente_local' => 'Monto asignado a la fuente local.',
            'sin_definir' => 'Sin definir'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"number\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_local\"]').on('input', function(){" .
                                        "monto_total();" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_federal\"]').change(function(){" .
                                        "monto_total();" .
                                    "});" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_presupuesto_partida()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_presupuesto_concepto', 'partida presupuestal', 'required');
        $this->form_validation->set_rules('monto_presupuesto', 'Monto asignado total', 'callback_monto_presupuesto_check');
        $this->form_validation->set_rules('monto_modificacion', 'Monto de modificaci&oacute;n', 'trim|required');
        $this->form_validation->set_rules('fuente_federal', 'fuente presupuestaria federal', 'trim|required');
        $this->form_validation->set_rules('monto_fuente_federal', 'Monto asignado federal', 'trim|required');
        $this->form_validation->set_rules('fuente_local', 'fuente presupuestaria local', 'trim|required');
        $this->form_validation->set_rules('monto_fuente_local', 'Monto asignado local', 'trim|required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar partida presupuestal";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'presupuestos'; // solo active 
        $data['subactive'] = 'busqueda_presupuestos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/presupuestos/editar_presupuesto_partida';
        
        $data['conceptos'] = $this->Catalogos_model->dame_todos_presupuestos_active();
        $data['registro'] = array(
            'id_presupuesto_desglose' => $this->input->post('id_presupuesto_desglose'),
            'id_presupuesto' => $this->input->post('id_presupuesto'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'fuente_federal' => $this->input->post('fuente_federal'),
            'monto_fuente_federal' => $this->input->post('monto_fuente_federal'),
            'fuente_local' => $this->input->post('fuente_local'),
            'monto_fuente_local' => $this->input->post('monto_fuente_local'),
            'monto_presupuesto' => $this->input->post('monto_presupuesto'),
            'monto_modificacion' => $this->input->post('monto_modificacion'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'denominacion' => $this->input->post('denominacion'),
            'fecha_publicacion' => $this->input->post('fecha_publicacion'),
            'active' => $this->input->post('active')
        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_presupuesto_desglose' => '',
            'id_presupuesto' => '',
            'id_presupesto_concepto' => 'Indica la clave de la partida presupuestal',
            'monto_asignado' => 'Monto asignado a la partida correspondiente.',
            'monto_modificacion' => 'Monto de modificaci&oacute;n, puede ser un n&uacute;mero negativo o positivo.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'denominacion' => '',
            'estatus' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'fuente_federal' => 'Son los que provienen de la Federaci&oacute;n, destinados a las Entidades Federativas y los Municipios, en t&eacute;rminos de la Ley Federal de Presupuesto y Responsabilidad Hacendaria y el Presupuesto de Egresos de la Federaci&oacute;n, que est&aacute;n destinados a un fin espec&iacute;fico por concepto de aportaciones, convenios de recursos federales etiquetados y fondos distintos de aportaciones.',
            'monto_fuente_federal' => 'Monto asignado a la fuente federal.',
            'fuente_local' => 'En el caso de los Municipios, son los que provienen del Gobierno Estatal y que cuentan con un destino espec&iacute;fico, en t&eacute;rminos de la Ley de Ingresos Estatal y del Presupuesto de Egresos Estatal.',
            'monto_fuente_local' => 'Monto asignado a la fuente local.',
            'sin_definir' => 'Sin definir'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_validacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_actualizacion\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"number\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_local\"]').on('input', function(){" .
                                        "monto_total();" .
                                    "});" .
                                    "$('input[name=\"monto_fuente_federal\"]').change(function(){" .
                                        "monto_total();" .
                                    "});" .
                                "});" .
                            "</script>";

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Presupuestos_model->editar_presupuesto_partida();
            if($editar == 1){
                $this->session->set_flashdata('exito', "La partida se ha editado correctamente");
            }else if($editar == 2){
                $this->session->set_flashdata('alert', "La partida ya se encuentra registrada");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La partida no se pudo editar");
            }
            if($redict)
            {
                $this->session->set_flashdata('tab_flag', "desglose");
                redirect('/tpoadminv1/capturista/presupuestos/editar_presupuesto/'.$this->input->post('id_presupuesto'));
            } 
        }
    }

    function eliminar_presupuesto_partida()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Presupuestos_model');

        $tieneFacturas = $this->Presupuestos_model->tiene_facturas_presupuesto_desglose($this->uri->segment(5));

        if($tieneFacturas){
            $this->session->set_flashdata('error', "Esta partida se encuentra asociada a facturas, será necesario eliminar primero las facturas.");
        }else{
            $eliminar = $this->Presupuestos_model->eliminar_presupuesto_desglose($this->uri->segment(5));

            if($eliminar == 1){
                $this->session->set_flashdata('exito', "Registro eliminado correctamente");
            }else {
                $this->session->set_flashdata('error', "Registro no se pudo eliminar");
            }
        }
        $this->session->set_flashdata('tab_flag', "desglose");
        redirect('/tpoadminv1/capturista/presupuestos/editar_presupuesto/' . $this->uri->segment(6));
    }

    function get_presupuesto_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $registro = $this->Presupuestos_model->dame_presupuestos_desglose_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function get_presupuesto_conceptos()
    {
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $id_ejercicio = $this->input->post('id_ejercicio');
        $id_so = $this->input->post('id_so');
        $tipo = $this->input->post('tipo');

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        //$presupuesto = $this->Presupuestos_model->dame_presupuestos_by_ejercicio_so_contratante($id_ejercicio, $id_so);
        $presupuesto = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($id_ejercicio, $id_so, $tipo);

        header('Content-type: application/json');
        
        echo json_encode( $presupuesto );
    }

    function preparar_exportacion_presupuestos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $path = $this->Presupuestos_model->descarga_presupuestos();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path);
    }

}

?>