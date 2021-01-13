<?php

/**
 * Description of Contratos
 *
 * INAI TPO
 */

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Ordenes_compra extends CI_Controller
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

    function fecha_orden_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_orden_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_orden_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_orden_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function get_campanas_filtro()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
       
        $id_ejercicio = $this->input->post('id_ejercicio');
        $registros = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($id_ejercicio);
        
        header('Content-type: application/json');
        
        echo json_encode($registros);
    }

    function busqueda_ordenes_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
                
        $data['title'] = "&Oacute;rdenes de compra";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'ordenes_compra'; // solo active 
        $data['subactive'] = 'busqueda_ordenes_compra'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/ordenes_compra/busqueda_ordenes_compra';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_ordenes_compra";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['registros'] = $this->Ordenes_compra_model->dame_todos_ordenes_compra(false, $this->uri->segment(5),$this->uri->segment(6));

        $data['yearSelected'] = $this->uri->segment(5);

        if (is_array($data['registros'])){
            if (count($data['registros'])!=0){
                if($data['registros'][0]["selected"]!=""){
                    $data['yearSelected'] = $data['registros'][0]["selected"];
                }
            }
        }

        $data['statusSelected'] = $this->uri->segment(6);
        
        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/capturista/ordenes_compra/preparar_exportacion_ordenes_compra";
        $data['path_file_csv'] = ''; //$this->Ordenes_compra_model->descarga_ordenes_compra();
        $data['name_file_csv'] = "ordenes_compra.csv";

        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Motivo o razones que justifican la elecci&oacute;n del proveedor.',
            'motivo_adjudicacion' => '',
            'fecha_orden' => 'Fecha de la orden de compra en el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_orden' => 'Hipervínculo a la orden de compra',
            'file_orden' => 'Archivo electr&oacute;nico de la orden de compra en formato PDF.',
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
                                        
                                    "$('#ordenes_compra').dataTable({" .
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

    function get_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $registro = $this->Ordenes_compra_model->dame_orden_compra_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function agregar_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $data['title'] = "Agregar orden de compra";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'ordenes_compra'; // solo active 
        $data['subactive'] = 'busqueda_ordenes_compra'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/ordenes_compra/agregar_orden_compra';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_contrato' => '',
            'id_orden_compra' => '',
            'id_proveedor' => '',
            'id_procedimiento' => '',
            'id_ejercicio' => '',
            'id_trimestre' => '',
            'id_so_contratante' => '',
            'id_so_solicitante' => '',
            'numero_orden_compra' => '',
            'id_campana_aviso' => '',
            'descripcion_justificacion' => '',
            'motivo_adjudicacion' => '',
            'fecha_orden' => '',
            'fecha_validacion' => '',
            'url_orden' => '',
            'file_orden' => '',
            'name_file_orden' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Motivo o razones que justifican la elecci&oacute;n del proveedor.',
            'motivo_adjudicacion' => '',
            'fecha_orden' => 'Fecha de la orden de compra en el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_orden' => 'Hipervínculo a la orden de compra',
            'file_orden' => 'Archivo electr&oacute;nico de la orden de compra en formato PDF.',
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
                                    "jQuery('input[name=\"fecha_orden\"]').datetimepicker({ " .
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
                                        "get_contratos();  get_campanas();" .
                                        "limitar_fecha_orden('#fecha_orden');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();" .
                                     "});" .
                                     "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor();" .
                                     "});" .
                                    "limitar_fecha_orden('#fecha_orden');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function id_contrato_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_contrato_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function id_campana_aviso_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_campana_aviso_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function validate_agregar_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_contrato', 'contrato', 'callback_id_contrato_check');
        $this->form_validation->set_rules('id_campana_aviso', 'campa&ntilde;a o aviso institucional', 'callback_id_campana_aviso_check');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('id_procedimiento', 'procedimiento', 'required');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado ordenante', 'required');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('numero_orden_compra', 'orden de compra', 'trim|required');
        $this->form_validation->set_rules('descripcion_justificacion', 'justificac&oacute;n', 'trim|required');
        $this->form_validation->set_rules('motivo_adjudicacion', 'motivo adjudicac&iacute;n', 'trim|required');
        $this->form_validation->set_rules('fecha_orden', 'fecha de orden', 'callback_fecha_orden_check');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        //echo 'id_contrato: ' . $this->input->post('id_contrato') . ', id_campana_aviso: ' . $this->input->post('id_campana_aviso');
        $data['title'] = "Agregar orden de compra";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'ordenes_compra'; // solo active 
        $data['subactive'] = 'busqueda_ordenes_compra'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/ordenes_compra/agregar_orden_compra';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_orden_compra' => '',
            'id_contrato' => $this->input->post('id_contrato'),
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_procedimiento' => $this->input->post('id_procedimiento'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'numero_orden_compra' => $this->input->post('numero_orden_compra'),
            'id_campana_aviso' => $this->input->post('id_campana_aviso'),
            'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
            'motivo_adjudicacion' => $this->input->post('motivo_adjudicacion'),
            'fecha_orden' => $this->input->post('fecha_orden'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'url_orden' => $this->input->post('url_orden'),
            'file_orden' => $this->input->post('file_orden'),
            'name_file_orden' => $this->input->post('name_file_orden'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );

        if(isset($data['registro']) && !empty($data['registro'])){
            $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($data['registro']['id_ejercicio'], $data['registro']['id_proveedor']);
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($data['registro']['id_ejercicio']);
        }
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Motivo o razones que justifican la elecci&oacute;n del proveedor.',
            'motivo_adjudicacion' => '',
            'fecha_orden' => 'Fecha de la orden de compra en el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_orden' => 'Hipervínculo a la orden de compra',
            'file_orden' => 'Archivo electr&oacute;nico de la orden de compra en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_orden']))
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
                                    "jQuery('input[name=\"fecha_orden\"]').datetimepicker({ " .
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
                                        "get_contratos();  get_campanas();" .
                                        "limitar_fecha_orden('#fecha_orden');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();" .
                                     "});" .
                                     "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor();" .
                                     "});" .
                                     "limitar_fecha_orden('#fecha_orden');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Ordenes_compra_model->agregar_orden_compra();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "La orden de compra se ha creado correctamente");
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La orden de compra no se pudo agregar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra');
            } 
        }
    }

    function editar_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $data['title'] = "Editar orden de compra";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'ordenes_compra'; // solo active 
        $data['subactive'] = 'busqueda_ordenes_compra'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/ordenes_compra/editar_orden_compra';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['registro'] = $this->Ordenes_compra_model->dame_orden_compra_id($this->uri->segment(5));
        
        if(isset($data['registro']) && !empty($data['registro'])){
            $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($data['registro']['id_ejercicio'], $data['registro']['id_proveedor']);
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($data['registro']['id_ejercicio']);
        }
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Motivo o razones que justifican la elecci&oacute;n del proveedor.',
            'motivo_adjudicacion' => '',
            'fecha_orden' => 'Fecha de la orden de compra en el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_orden' => 'Hipervínculo a la orden de compra',
            'file_orden' => 'Archivo electr&oacute;nico de la orden de compra en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_orden']))
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
                                    "jQuery('input[name=\"fecha_orden\"]').datetimepicker({ " .
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
                                        "get_contratos();  get_campanas();" .
                                        "limitar_fecha_orden('#fecha_orden');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();" .
                                     "});" .
                                     "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor();" .
                                     "});" .
                                     "limitar_fecha_orden('#fecha_orden');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_contrato', 'contrato', 'callback_id_contrato_check');
        $this->form_validation->set_rules('id_campana_aviso', 'campa&ntilde;a o aviso institucional', 'callback_id_campana_aviso_check');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('id_procedimiento', 'procedimiento', 'required');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado ordenante', 'required');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('numero_orden_compra', 'orden de compra', 'trim|required');
        $this->form_validation->set_rules('descripcion_justificacion', 'justificac&oacute;n', 'trim|required');
        $this->form_validation->set_rules('motivo_adjudicacion', 'motivo adjudicac&iacute;n', 'trim|required');
        $this->form_validation->set_rules('fecha_orden', 'fecha de orden', 'callback_fecha_orden_check');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar orden de compra";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'ordenes_compra'; // solo active 
        $data['subactive'] = 'busqueda_ordenes_compra'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/ordenes_compra/editar_orden_compra';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        
        $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($this->input->post('id_ejercicio'), $this->input->post('id_proveedor'));
        $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($this->input->post('id_ejercicio'));
    

        $data['registro'] = array(
            'id_orden_compra' => $this->input->post('id_orden_compra'),
            'id_contrato' => $this->input->post('id_contrato'),
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_procedimiento' => $this->input->post('id_procedimiento'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'numero_orden_compra' => $this->input->post('numero_orden_compra'),
            'id_campana_aviso' => $this->input->post('id_campana_aviso'),
            'descripcion_justificacion' => $this->input->post('descripcion_justificacion'),
            'motivo_adjudicacion' => $this->input->post('motivo_adjudicacion'),
            'fecha_orden' => $this->input->post('fecha_orden'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'url_orden' => $this->input->post('url_orden'),
            'file_orden' => $this->input->post('file_orden'),
            'name_file_orden' => $this->input->post('name_file_orden'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n.',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'numero_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Motivo o razones que justifican la elecci&oacute;n del proveedor.',
            'motivo_adjudicacion' => '',
            'fecha_orden' => 'Fecha de la orden de compra en el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_orden' => 'Hipervínculo a la orden de compra',
            'file_orden' => 'Archivo electr&oacute;nico de la orden de compra en formato PDF.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa” o “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_orden']))
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
                                    "jQuery('input[name=\"fecha_orden\"]').datetimepicker({ " .
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
                                        "get_contratos();  get_campanas();" .
                                        "limitar_fecha_orden('#fecha_orden');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();" .
                                     "});" .
                                     "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor();" .
                                     "});" .
                                     "limitar_fecha_orden('#fecha_orden');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE || $data['file_error'] == true ) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Ordenes_compra_model->editar_orden_compra();
            if($editar == 1){
                $this->session->set_flashdata('exito', "La orden de compra se ha editado correctamente");
            }else if($editar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La orden de compra no se pudo editar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra');
            } 
        }
    }


function validate_editar_status_orden_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->library('form_validation');

        
        $redict = true;
        $editar = $this->Ordenes_compra_model->editar_status_orden_compra();
        if($editar == 1){
            $this->session->set_flashdata('exito', "Las ordenes de compra se han editado correctamente");
        }else{
            $this->session->set_flashdata('error', "La orden de compra no se pudo editar");
        }
        if($redict)
        {
            redirect('/tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra'."/".$this->input->post('id_year_selected'));
        } 
        
    }



    function eliminar_orden_compra()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');

        $eliminar = $this->Ordenes_compra_model->eliminar_orden_compra($this->uri->segment(5));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "Registro no se pudo eliminar");
        }

        redirect('/tpoadminv1/capturista/ordenes_compra/busqueda_ordenes_compra');
    }

    function get_ordenes_compra_filtro ()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
       
        $id_ejercicio = $this->input->post('id_ejercicio');
        $id_proveedor = $this->input->post('id_proveedor');
        $id_contrato = $this->input->post('id_contrato');
        $registros = $this->Ordenes_compra_model->dame_ordenes_by_ejercicio_proveedor_contrato($id_ejercicio, $id_proveedor, $id_contrato);
        $array_items[0]['id_contrato'] = $id_ejercicio;
        $array_items[0]['numero_contrato'] = $id_ejercicio;
        $array_items[1]['id_contrato'] = $id_proveedor;
        $array_items[1]['numero_contrato'] = $id_proveedor;
        
        header('Content-type: application/json');
        
        //echo json_encode( $array_items);
        echo json_encode($registros);
    }

    function upload_file()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file_orden']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('pdf');
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){

                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/ordenes/', utf8_decode($name_file));
                    
                    // se guarda el archivo
                    $config['upload_path'] = './data/ordenes';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file_orden')){
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
        $clear_path = './data/ordenes/' . $this->input->post('file_orden');
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function preparar_exportacion_ordenes_compra()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $path = $this->Ordenes_compra_model->descarga_ordenes_compra();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path);
    }
    
}

?>