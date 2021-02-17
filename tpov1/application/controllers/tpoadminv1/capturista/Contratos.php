<?php

/**
 * Description of Contratos
 *
 * Inai TPO
 */

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Contratos extends CI_Controller
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

    function fecha_celebracion_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_celebracion_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_celebracion_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_celebracion_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function busqueda_contratos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
                
        $data['title'] = "Contratos";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/busqueda_contratos';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_contratos";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['registros'] = $this->Contratos_model->dame_todos_contratos(false, $this->uri->segment(5),$this->uri->segment(6));

        $data['yearSelected'] = $this->uri->segment(5);
        if (is_array($data['registros'])){
            if (count($data['registros'])!=0){
                if($data['registros'][0]["selected"]!=""){
                    $data['yearSelected'] = $data['registros'][0]["selected"];
                }
            }
        }
        $data['statusSelected'] = $this->uri->segment(6);


        
        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/capturista/contratos/preparar_exportacion_contratos";
        $data['path_file_csv'] = '';//$this->Contratos_model->descarga_contratos();
        $data['name_file_csv'] = "contratos.csv";

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_procedimiento' => 'Indica el tipo de procedimiento administrativo  que se llev&oacute; acabo para la contrataci&oacute;n.',
            'id_proveedor' => 'Nombre o raz&oacute;n social del proveedor',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'objeto_contrato' => 'Indica las obligaciones creadas y la raz&oacute;n de ser del contrato.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de las razones que justifican la elecci&oacute;n de tal proveedor.',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios.',
            'fecha_fin' => 'Indica la fecha de finalizaci&oacute;n de los servicios.',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado_a_la_fecha' => 'Monto pagado al periodo publicado.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.',
            'cambiar_estatus' => 'Cambia el estatus de todos los registros de acuerdo al año seleccionado.',
            'select_ejercicio' => 'Periodo que muestra los registros del año seleccionado.',
            'select_estatus' => 'Condición del registro de acuerdo al periodo seleccionado.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                        
                                    "$('#contratos').dataTable({" .
                                        "'bPaginate': true," .
                                        "'bLengthChange': true," .
                                        "'bFilter': true," .
                                        "'bSort': true," .
                                        "'bInfo': true," .
                                        "'bAutoWidth': false," .
                                        "'columnDefs': [ " .
                                            "{ 'orderable': false, 'targets': [12,13,14] } " .
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

    function agregar_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $data['title'] = "Agregar contrato";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/agregar_contrato';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_contrato' => '',
            'id_procedimiento' => '',
            'id_proveedor' => '',
            'id_ejercicio' => '',
            'id_trimestre' => '',
            'id_so_contratante' => '',
            'id_so_solicitante' => '',
            'numero_contrato' => '',
            'objeto_contrato' => '',
            'descripcion_justificacion' => '',
            'fundamento_juridico' => '',
            'fecha_celebracion' => '',
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'monto_contrato' => '0.00',
            'url_contrato' => '',
            'file_contrato' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'name_file_contrato' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato' => '',
            'id_procedimiento' => 'Indica el tipo de procedimiento administrativo  que se llev&oacute; acabo para la contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'objeto_contrato' => 'Indica las obligaciones creadas y la raz&oacute;n de ser del contrato.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de las razones que justifican la elecci&oacute;n de tal proveedor.',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios.',
            'fecha_fin' => 'Indica la fecha de finalizaci&oacute;n de los servicios.',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado_a_la_fecha' => 'Monto pagado al periodo publicado.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formato permitido PDF.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_fin\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function editar_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $data['title'] = "Editar contrato";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/editar_contrato';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = $this->Contratos_model->dame_contrato_id($this->uri->segment(5));
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato' => '',
            'id_procedimiento' => 'Indica el tipo de procedimiento administrativo  que se llev&oacute; acabo para la contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'objeto_contrato' => 'Indica las obligaciones creadas y la raz&oacute;n de ser del contrato.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de las razones que justifican la elecci&oacute;n de tal proveedor.',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios.',
            'fecha_fin' => 'Indica la fecha de finalizaci&oacute;n de los servicios.',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado_a_la_fecha' => 'Monto pagado al periodo publicado.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.',
            'monto_convenio' => '',
            'numero_convenio' => ''
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_contrato']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

        /* Datos para tabla de convenios modificatorios  */
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_convenios_modificatorios/".$this->uri->segment(5);
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['registros'] = $this->Contratos_model->dame_todos_convenios_modificatorios($this->uri->segment(5));
        
        $data['path_file_csv'] = $this->Contratos_model->descarga_convenios_modificatorios($this->uri->segment(5));
        $data['name_file_csv'] = "convenios_modificatorios_" . $this->uri->segment(5) . ".csv";

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "$('#convenios').dataTable({" .
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
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_fin\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_procedimiento', 'procedimiento', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado contratante', 'required');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('numero_contrato', 'n&uacute;mero de contrato', 'required');
        $this->form_validation->set_rules('objeto_contrato', 'objeto del contrato', 'required');
        $this->form_validation->set_rules('descripcion_justificacion', 'descripci&oacute;n', 'required');
        $this->form_validation->set_rules('fundamento_juridico', 'fundamento jur&iacute;dico', 'required');
        $this->form_validation->set_rules('fecha_celebracion', 'fecha de celebraci&oacute;n', 'callback_fecha_celebracion_check');
        $this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
        $this->form_validation->set_rules('fecha_fin', 'fecha de t&eacute;rmino', 'required');
        $this->form_validation->set_rules('monto_contrato', 'monto original del contrato', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar contrato";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/agregar_contrato';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_contrato' => '',
            'id_procedimiento' => $this->input->post('id_procedimiento'),
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'numero_contrato' => $this->input->post('numero_contrato'),
            'objeto_contrato' => $this->input->post('objeto_contrato'),
            'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
            'fundamento_juridico' => $this->input->post('fundamento_juridico'),
            'fecha_celebracion' => $this->input->post('fecha_celebracion'),
            'fecha_inicio' => $this->input->post('fecha_inicio'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'monto_contrato' => $this->input->post('monto_contrato'),
            'url_contrato' => $this->input->post('url_contrato'),
            'file_contrato' => $this->input->post('file_contrato'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'name_file_contrato' => $this->input->post('name_file_contrato'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato' => '',
            'id_procedimiento' => 'Indica el tipo de procedimiento administrativo  que se llev&oacute; acabo para la contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'objeto_contrato' => 'Indica las obligaciones creadas y la raz&oacute;n de ser del contrato.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de las razones que justifican la elecci&oacute;n de tal proveedor.',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios.',
            'fecha_fin' => 'Indica la fecha de finalizaci&oacute;n de los servicios.',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado_a_la_fecha' => 'Monto pagado al periodo publicado.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_contrato']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');". 
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_fin\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Contratos_model->agregar_contrato();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "El contrato se ha creado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El contrato no se pudo agregar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/contratos/busqueda_contratos');
            } 
        }
    }

    function validate_editar_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_procedimiento', 'procedimiento', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado contratante', 'required');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('numero_contrato', 'n&uacute;mero de contrato', 'required');
        $this->form_validation->set_rules('objeto_contrato', 'objeto del contrato', 'required');
        $this->form_validation->set_rules('descripcion_justificacion', 'descripci&oacute;n', 'required');
        $this->form_validation->set_rules('fundamento_juridico', 'fundamento jur&iacute;dico', 'required');
        $this->form_validation->set_rules('fecha_celebracion', 'fecha de celebraci&oacute;n', 'callback_fecha_celebracion_check');
        $this->form_validation->set_rules('fecha_inicio', 'fecha de inicio', 'required');
        $this->form_validation->set_rules('fecha_fin', 'fecha de t&eacute;rmino', 'required');
        $this->form_validation->set_rules('monto_contrato', 'monto original del contrato', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar contrato";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/editar_contrato';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_contrato' => $this->input->post('id_contrato'),
            'id_procedimiento' => $this->input->post('id_procedimiento'),
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'numero_contrato' => $this->input->post('numero_contrato'),
            'objeto_contrato' => $this->input->post('objeto_contrato'),
            'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
            'fundamento_juridico' => $this->input->post('fundamento_juridico'),
            'fecha_celebracion' => $this->input->post('fecha_celebracion'),
            'fecha_inicio' => $this->input->post('fecha_inicio'),
            'fecha_fin' => $this->input->post('fecha_fin'),
            'monto_contrato' => $this->input->post('monto_contrato'),
            'url_contrato' => $this->input->post('url_contrato'),
            'file_contrato' => $this->input->post('file_contrato'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'name_file_contrato' => $this->input->post('name_file_contrato'),
            'nota' => $this->input->post('nota'),
            'monto_modificado' => $this->input->post('monto_modificado'),
            'monto_pagado' => $this->input->post('monto_pagado'),
            'monto_total' => $this->input->post('monto_total'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato' => '',
            'id_procedimiento' => 'Indica el tipo de procedimiento administrativo  que se llev&oacute; acabo para la contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_contrato' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato.',
            'objeto_contrato' => 'Indica las obligaciones creadas y la raz&oacute;n de ser del contrato.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de las razones que justifican la elecci&oacute;n de tal proveedor.',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Fecha de firma de contrato, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'fecha_inicio' => 'Indica la fecha de inicio de los servicios.',
            'fecha_fin' => 'Indica la fecha de finalizaci&oacute;n de los servicios.',
            'monto_contrato' => 'Monto total del contrato, con I.V.A. incluido.',
            'monto_modificado' => 'Suma de los  montos de los convenios modificatorios.',
            'monto_total' => 'Suma del monto original del contrato, más el monto modificado.',
            'monto_pagado_a_la_fecha' => 'Monto pagado al periodo publicado.',
            'url_contrato' => 'Hipervínculo al contrato firmado.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_contrato']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

        /* Datos para tabla de convenios modificatorios */
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_convenios_modificatorios/".$this->uri->segment(5);
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['registros'] = $this->Contratos_model->dame_todos_convenios_modificatorios($this->uri->segment(5));
        
        $data['path_file_csv'] = $this->Contratos_model->descarga_convenios_modificatorios($this->uri->segment(5));
        $data['name_file_csv'] = "convenios_modificatorios" . $this->uri->segment(5) . ".csv";

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea' });" .
                                    "jQuery.datetimepicker.setLocale('es');".
                                    "jQuery('input[name=\"fecha_inicio\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
                                    "jQuery('input[name=\"fecha_fin\"]').datetimepicker({ " .
                                        "timepicker:false," .
                                        "format:'d.m.Y'," .
                                        "scrollInput: false" .
                                    "});" .
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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Contratos_model->editar_contrato();
            if($editar == 1){
                $this->session->set_flashdata('exito', "El contrato se ha editado correctamente");
            }else if($editar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El contrato no se pudo editar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/contratos/busqueda_contratos');
                
            } 
        }
    }



function validate_editar_status_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');

        
        $redict = true;
        $editar = $this->Contratos_model->editar_status_contrato();
        if($editar == 1){
            $this->session->set_flashdata('exito', "Los contratos se han editado correctamente");
        }else{
            $this->session->set_flashdata('error', "Los contratos no se pudieron editar");
        }
        if($redict)
        {
            redirect('/tpoadminv1/capturista/contratos/busqueda_contratos'."/".$this->input->post('id_year_selected'));
        } 
        
    }


    function get_contrato()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $registro = $this->Contratos_model->dame_contrato_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function eliminar_contrato()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $dependencia = $this->Contratos_model->tiene_contratos_dependencia($this->uri->segment(5));
        if($dependencia[0] == true){
            $this->session->set_flashdata('alert', $dependencia[1].$dependencia[2]);
        }else{
            $eliminar = $this->Contratos_model->eliminar_contrato($this->uri->segment(5));

            if($eliminar == 1){
                $this->session->set_flashdata('exito', "Registro eliminado correctamente");
            }else {
                $this->session->set_flashdata('error', "Registro no se pudo eliminar");
            }
        }
        redirect('/tpoadminv1/capturista/contratos/busqueda_contratos');
    }

    function upload_file()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_contrato']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('pdf');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){

                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/contratos/', utf8_decode($name_file));

                    // se guarda el archivo
                    $config['upload_path'] = './data/contratos';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_contrato')){
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
        $clear_path = './data/contratos/' . $this->input->post('file_contrato');
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function agregar_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $data['title'] = "Agregar convenio modificatorio";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/agregar_convenio_modificatorio';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);

        $data['registro'] = array(
            'id_convenio_modificatorio' => '',
            'id_contrato' => $this->uri->segment(5),
            'id_ejercicio' => '',
            'id_trimestre' => '',
            'numero_convenio' => '',
            'objeto_convenio' => '',
            'fundamento_juridico' => '',
            'fecha_celebracion' => '',
            'monto_convenio' => '0.00',
            'url_convenio' => '',
            'file_convenio' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'name_file_convenio' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'numero_convenio' => 'Clave o número de identificación único del convenio.',
            'objeto_convenio' => 'Indica el objeto del contrato',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Indica la fecha del convenio, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'monto_convenio' => 'Indica el monto total del convenio modificatorio con I.V.A. incluido.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formato permitido PDF.'
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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('numero_convenio', 'convenio de modificaci&oacute;n', 'required');
        $this->form_validation->set_rules('objeto_convenio', 'objeto', 'required');
        $this->form_validation->set_rules('fundamento_juridico', 'fundamento jur&iacute;dico', 'required');
        $this->form_validation->set_rules('fecha_celebracion', 'fecha de celebraci&oacute;n', 'required');
        $this->form_validation->set_rules('monto_convenio', 'monto original del contrato', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar convenio modificatorio";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/agregar_convenio_modificatorio';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);

        $data['registro'] = array(
            'id_convenio_modificatorio' => '',
            'id_contrato' => $this->input->post('id_contrato'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'numero_convenio' => $this->input->post('numero_convenio'),
            'objeto_convenio' => $this->input->post('objeto_convenio'),
            'fundamento_juridico' => $this->input->post('fundamento_juridico'),
            'fecha_celebracion' => $this->input->post('fecha_celebracion'),
            'monto_convenio' => $this->input->post('monto_convenio'),
            'url_convenio' => $this->input->post('url_convenio'),
            'file_convenio' => $this->input->post('file_convenio'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'name_file_convenio' => $this->input->post('name_file_convenio'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'numero_convenio' => 'Clave o número de identificación único del convenio.',
            'objeto_convenio' => 'Indica el objeto del contrato',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Indica la fecha del convenio, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'monto_convenio' => 'Indica el monto total del convenio modificatorio con I.V.A. incluido.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_convenio']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Contratos_model->agregar_convenio_modificatorio();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "El convenio modificatorio se ha creado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El convenio modificatorio no se pudo agregar");
            }
            if($redict)
            {
                $this->session->set_flashdata('tab_flag', "convenios");
                redirect('/tpoadminv1/capturista/contratos/editar_contrato/'.$this->input->post('id_contrato'));
            } 
        }
    }

    function editar_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $data['title'] = "Editar convenio modificatorio";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/editar_convenio_modificatorio';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);

        $data['registro'] = $this->Contratos_model->dame_convenio_modificatorio_id($this->uri->segment(5)); 
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'numero_convenio' => 'Clave o número de identificación único del convenio.',
            'objeto_convenio' => 'Indica el objeto del contrato',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Indica la fecha del convenio, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'monto_convenio' => 'Indica el monto total del convenio modificatorio con I.V.A. incluido.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_convenio']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('numero_convenio', 'convenio de modificaci&oacute;n', 'required');
        $this->form_validation->set_rules('objeto_convenio', 'objeto', 'required');
        $this->form_validation->set_rules('fundamento_juridico', 'fundamento jur&iacute;dico', 'required');
        $this->form_validation->set_rules('fecha_celebracion', 'fecha de celebraci&oacute;n', 'required');
        $this->form_validation->set_rules('monto_convenio', 'monto original del contrato', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar convenio modificatorio";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'contratos'; // solo active 
        $data['subactive'] = 'busqueda_contratos'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/contratos/editar_convenio_modificatorio';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);

        $data['registro'] = array(
            'id_convenio_modificatorio' => $this->input->post('id_convenio_modificatorio'),
            'id_contrato' => $this->input->post('id_contrato'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'numero_convenio' => $this->input->post('numero_convenio'),
            'objeto_convenio' => $this->input->post('objeto_convenio'),
            'fundamento_juridico' => $this->input->post('fundamento_juridico'),
            'fecha_celebracion' => $this->input->post('fecha_celebracion'),
            'monto_convenio' => $this->input->post('monto_convenio'),
            'url_convenio' => $this->input->post('url_convenio'),
            'file_convenio' => $this->input->post('file_convenio'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'name_file_convenio' => $this->input->post('name_file_convenio'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'numero_convenio' => 'Clave o número de identificación único del convenio.',
            'objeto_convenio' => 'Indica el objeto del contrato',
            'fundamento_juridico' => 'Fundamento jur&iacute;dico del procedimiento de contrataci&oacute;n.',
            'fecha_celebracion' => 'Indica la fecha del convenio, con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'monto_convenio' => 'Indica el monto total del convenio modificatorio con I.V.A. incluido.',
            'file_contrato' => 'Archivo de la versi&oacute;n p&uacute;blica del contrato en formato PDF.',
            'url_convenio' => 'Hipervínculo al convenio modificatorio, en su caso',
            'file_convenio' => 'Archivo del convenio modificatorio en PDF',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_convenio']))
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
                "mensaje_file" => 'Formato permitido PDF.'
            );
        }

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
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                    "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "limitar_fecha_celebracion('#fecha_celebracion');" .
                                    "});" .
                                    "limitar_fecha_celebracion('#fecha_celebracion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Contratos_model->editar_convenio_modificatorio();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "El convenio modificatorio se ha editado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "El convenio modificatorio no se pudo editar");
            }
            if($redict)
            {
                $this->session->set_flashdata('tab_flag', "convenios");
                redirect('/tpoadminv1/capturista/contratos/editar_contrato/'.$this->input->post('id_contrato'));
            } 
        }
    }




function validate_editar_status_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->library('form_validation');
        
        $redict = true;
        $agregar = $this->Contratos_model->editar_status_convenio_modificatorio();
        if($agregar == 1){
            $this->session->set_flashdata('exito', "Los convenios modificatorios se han editado correctamente");
        }else{
            $this->session->set_flashdata('error', "Los convenios modificatorios no se pudieron editar");
        }
        if($redict)
        {
            $this->session->set_flashdata('tab_flag', "convenios");
            redirect('/tpoadminv1/capturista/contratos/editar_contrato/'.$this->input->post('id_contrato'));
        } 
        
    }



    function get_convenio_modificatorio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $registro = $this->Contratos_model->dame_convenio_modificatorio_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function eliminar_convenio_modificatorio()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Contratos_model');

        $eliminar = $this->Contratos_model->eliminar_convenio_modificatorio($this->uri->segment(5));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "Registro no se pudo eliminar");
        }

        $this->session->set_flashdata('tab_flag', "convenios");
        redirect('/tpoadminv1/capturista/contratos/editar_contrato/'. $this->uri->segment(6));
    }

    function get_contratos_filtro()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/capturista/Contratos_model');
       
        $id_ejercicio = $this->input->post('id_ejercicio');
        $id_proveedor = $this->input->post('id_proveedor');
        $registros = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($id_ejercicio, $id_proveedor);
        
        header('Content-type: application/json');
        
        echo json_encode($registros);
    }

    function upload_file_convenio()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_convenio']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('pdf');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){

                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/convenios/', utf8_decode($name_file));

                    // se guarda el archivo
                    $config['upload_path'] = './data/convenios';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_convenio')){
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

    function clear_file_convenio()
    {
        $clear_path = './data/convenios/' . $this->input->post('file_convenio');
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function preparar_exportacion_contratos()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $path = $this->Contratos_model->descarga_contratos();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path);
    }

}

?>