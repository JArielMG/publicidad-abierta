<?php

/*
INAI / Proveedores
*/

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Proveedores extends CI_Controller
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
        }else if($this->session->userdata('usuario_id_so_atribucion') != 0 && $this->session->userdata('usuario_id_so_atribucion') != 2 ){
            redirect('tpoadminv1/securecms/sin_permiso');
        }
    }

    function busqueda_proveedores()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Proveedores_model');
                
        $data['title'] = "Proveedores";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'proveedores'; // solo active 
        $data['subactive'] = 'busqueda_proveedores'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/proveedores/busqueda_proveedores';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_proveedores";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['registros'] = $this->Proveedores_model->dame_todos_proveedores(false);

        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/capturista/proveedores/preparar_exportacion_proveedores";
        $data['path_file_csv'] = ''; //$this->Proveedores_model->descarga_proveedores();
        $data['name_file_csv'] = "proveedores.csv";

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_personalidad_juridica' => 'Indica si el prestador de servicios es una persona f&iacute;sica o una persona moral.',
            'nombre_razon_social' => 'Nombre, en caso de persona f&iacute;sica [Nombre(s), primer apellido y segundo apellido], o raz&oacute;n social, en caso de persona moral, del prestador de servicios.',
            'nombre_comercial' => 'En caso de ser persona moral, el nombre comercial del prestador de servicios.',
            'rfc' => 'Registro Federal de Contribuyentes de la persona f&iacute;sica o moral  proveedora del producto o servicio',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'nombres' => 'Nombre',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'descripcion_servicios' => 'Descripci&oacute;n de sus servicios',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'cambiar_estatus' => 'Cambia el estatus de todos los registros.',
            'select_ejercicio' => 'Periodo que muestra los registros del año seleccionado.',
            'select_estatus' => 'Condición del registro de acuerdo al periodo seleccionado.'
        );

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
                                            "{ 'orderable': false, 'targets': [6,7,8] } " .
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

    function agregar_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');

        $data['title'] = "Agregar proveedor";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'proveedores'; // solo active 
        $data['subactive'] = 'busqueda_proveedores'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/proveedores/agregar_proveedor';

        $data['personalidades'] = $this->Catalogos_model->dame_todos_personalidades(true);
        $data['registro'] = array(
            'id_proveedor' => '',
            'id_personalidad_juridica' => '',
            'nombre_razon_social' => '',
            'nombre_comercial' => '',
            'rfc' => '',
            'primer_apellido' => '',
            'segundo_apellido' => '',
            'nombres' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'descripcion_servicios' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_personalidad_juridica' => 'Indica si el prestador de servicios es una persona f&iacute;sica o una persona moral.',
            'nombre_razon_social' => 'Nombre, en caso de persona f&iacute;sica [Nombre(s), primer apellido y segundo apellido], o raz&oacute;n social, en caso de persona moral, del prestador de servicios.',
            'nombre_comercial' => 'En caso de ser persona moral, el nombre comercial del prestador de servicios.',
            'rfc' => 'Registro Federal de Contribuyentes de la persona f&iacute;sica o moral  proveedora del producto o servicio',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'nombres' => 'Nombre(s)',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'descripcion_servicios' => 'Descripci&oacute;n de sus servicios',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.',
            'estatus' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.'
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
                                "});" .
                            "</script>";

        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_personalidad_juridica', 'personalidad jur&iacute;dica', 'required');
        $this->form_validation->set_rules('nombre_razon_social', 'Nombre o raz&oacute;n social', 'trim|required');
      //  $this->form_validation->set_rules('nombre_comercial', 'Nombre comercial', 'trim|required');
        $this->form_validation->set_rules('rfc', '', 'trim|required');
        $this->form_validation->set_rules('active', 'estatus', 'trim|required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar proveedor";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'proveedores'; // solo active 
        $data['subactive'] = 'busqueda_proveedores'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/proveedores/agregar_proveedor';
        
        $data['personalidades'] = $this->Catalogos_model->dame_todos_personalidades(true);
        $data['registro'] = array(
            'id_proveedor' => '',
            'id_personalidad_juridica' => $this->input->post('id_personalidad_juridica'),
            'nombre_razon_social' => $this->input->post('nombre_razon_social'),
            'nombre_comercial' => $this->input->post('nombre_comercial'),
            'rfc' => $this->input->post('rfc'),
            'primer_apellido' => $this->input->post('primer_apellido'),
            'segundo_apellido' => $this->input->post('segundo_apellido'),
            'nombres' => $this->input->post('nombres'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'descripcion_servicios' => $this->input->post('descripcion_servicios'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')

        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_personalidad_juridica' => 'Indica si el prestador de servicios es una persona f&iacute;sica o una persona moral.',
            'nombre_razon_social' => 'Nombre, en caso de persona f&iacute;sica [Nombre(s), primer apellido y segundo apellido], o raz&oacute;n social, en caso de persona moral, del prestador de servicios.',
            'nombre_comercial' => 'En caso de ser persona moral, el nombre comercial del prestador de servicios.',
            'rfc' => 'Registro Federal de Contribuyentes de la persona f&iacute;sica o moral  proveedora del producto o servicio',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'nombres' => 'Nombre(s)',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'descripcion_servicios' => 'Descripci&oacute;n de sus servicios',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.'
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
                                        "$(this).removeClass('validation-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('validation-error');" .
                                    "});" .
                                "});" .
                            "</script>";

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Proveedores_model->agregar_proveedor();
            if($agregar[0] == 1){
                $this->session->set_flashdata('exito', "El proveedor " . $this->input->post('nombre_razon_social') . " se ha creado correctamente");
            }else if($agregar[0] == 2){
                $mensaje = $agregar[1] == true ? "El nombre o raz&oacute;n social ya se encuentra registrado <br>" : "";
                $mensaje .= $agregar[2] == true ? "El R.F.C. ya se encuentra registrado <br>" : "";
                $this->session->set_flashdata('alert', $mensaje);
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El proveedor " . $this->input->post('nombre_razon_social') . " no se pudo agregar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/proveedores/busqueda_proveedores');
            } 
        }
    }

    function editar_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');

        $data['title'] = "Editar proveedor";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'proveedores'; // solo active 
        $data['subactive'] = 'busqueda_proveedores'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/proveedores/editar_proveedor';

        $data['personalidades'] = $this->Catalogos_model->dame_todos_personalidades(true);
        $data['registro'] = $this->Proveedores_model->dame_proveedor_id($this->uri->segment(5));
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_personalidad_juridica' => 'Indica si el prestador de servicios es una persona f&iacute;sica o una persona moral.',
            'nombre_razon_social' => 'Nombre, en caso de persona f&iacute;sica [Nombre(s), primer apellido y segundo apellido], o raz&oacute;n social, en caso de persona moral, del prestador de servicios.',
            'nombre_comercial' => 'En caso de ser persona moral, el nombre comercial del prestador de servicios.',
            'rfc' => 'Registro Federal de Contribuyentes de la persona f&iacute;sica o moral  proveedora del producto o servicio',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'nombres' => 'Nombre(s)',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'descripcion_servicios' => 'Descripci&oacute;n de sus servicios',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.'
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
                                "});" .
                            "</script>";

        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_personalidad_juridica', 'personalidad jur&iacute;dica', 'required');
        $this->form_validation->set_rules('nombre_razon_social', 'Nombre o raz&oacute;n social', 'trim|required');
       // $this->form_validation->set_rules('nombre_comercial', 'Nombre comercial', 'trim|required');
        $this->form_validation->set_rules('rfc', '', 'trim|required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar proveedor";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_job');
        $data['active'] = 'proveedores'; // solo active 
        $data['subactive'] = 'busqueda_proveedores'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/proveedores/editar_proveedor';
        
        $data['personalidades'] = $this->Catalogos_model->dame_todos_personalidades(true);
        $data['registro'] = array(
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_personalidad_juridica' => $this->input->post('id_personalidad_juridica'),
            'nombre_razon_social' => $this->input->post('nombre_razon_social'),
            'nombre_comercial' => $this->input->post('nombre_comercial'),
            'rfc' => $this->input->post('rfc'),
            'primer_apellido' => $this->input->post('primer_apellido'),
            'segundo_apellido' => $this->input->post('segundo_apellido'),
            'nombres' => $this->input->post('nombres'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'descripcion_servicios' => $this->input->post('descripcion_servicios'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_personalidad_juridica' => 'Indica si el prestador de servicios es una persona f&iacute;sica o una persona moral.',
            'nombre_razon_social' => 'Nombre, en caso de persona f&iacute;sica [Nombre(s), primer apellido y segundo apellido], o raz&oacute;n social, en caso de persona moral, del prestador de servicios.',
            'nombre_comercial' => 'En caso de ser persona moral, el nombre comercial del prestador de servicios.',
            'rfc' => 'Registro Federal de Contribuyentes de la persona f&iacute;sica o moral  proveedora del producto o servicio',
            'primer_apellido' => 'Primer apellido',
            'segundo_apellido' => 'Segundo apellido',
            'nombres' => 'Nombre(s)',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'descripcion_servicios' => 'Descripci&oacute;n de sus servicios',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n “Activa” o “Inactiva”.'
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
                                        "$(this).removeClass('validation-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('validation-error');" .
                                    "});" .
                                "});" .
                            "</script>";

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Proveedores_model->editar_proveedor();
            if($editar[0] == 1){
                $this->session->set_flashdata('exito', "El proveedor " . $this->input->post('nombre_razon_social') . " se ha editado correctamente");
            }else if($editar[0] == 2){
                $mensaje = $editar[1] == true ? "El nombre o raz&oacute;n social ya se encuentra registrado <br>" : "";
                $mensaje .= $editar[2] == true ? "El R.F.C. ya se encuentra registrado " : "";
                $this->session->set_flashdata('alert', $mensaje);
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El proveedor " . $this->input->post('nombre_razon_social') . " no se pudo editar");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/proveedores/busqueda_proveedores');
            } 
        }
    }

    function validate_editar_status_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->library('form_validation');

        $redict = true;
        $editar = $this->Proveedores_model->editar_status_proveedor();
        if($editar[0] == 1){
            $this->session->set_flashdata('exito', "Se han editado todos los registros");
        }else{
            $this->session->set_flashdata('error', "Ocurrio un error al editar los registros");
            $this->load->view('tpoadminv1/includes/template', $data);
            $redict = false;
        }
        if($redict)
        {
            redirect('/tpoadminv1/capturista/proveedores/busqueda_proveedores');
        } 
        
    }

    function eliminar_proveedor()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Proveedores_model');

        $eliminar = $this->Proveedores_model->eliminar_proveedor($this->uri->segment(5));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "Registro no se pudo eliminar");
        }

        redirect('/tpoadminv1/capturista/proveedores/busqueda_proveedores');
    }

    function get_proveedor()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $registro = $this->Proveedores_model->dame_proveedor_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function preparar_exportacion_proveedores()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $path = $this->Proveedores_model->descarga_proveedores();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path);
    }
}

?>