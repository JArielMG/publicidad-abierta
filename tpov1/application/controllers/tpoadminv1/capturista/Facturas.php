<?php

/**
 * Description of Facturas
 *
 * INAI TPO
 */

if (!defined('BASEPATH')) 
{
    exit('No direct script access allowed');
}

class Facturas extends CI_Controller
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

    function id_contrato_check($str)
    {
        if(empty($str) || $str == '0' || $str == '-Selecione-')
        {
            $this->form_validation->set_message('id_contrato_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function id_orden_compra_check($str)
    {
        if(empty($str) || $str == '0' || $str == '-Selecione-')
        {
            $this->form_validation->set_message('id_orden_compra_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function fecha_erogacion_check($str)
    {
        if(empty($str))
        {
            $this->form_validation->set_message('fecha_erogacion_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else if(preg_match("/^(0[1-9]|[12][0-9]|3[01])[.](0[1-9]|1[012])[.](19|20|21)\d\d$/", $str) != 1)
        {
            $this->form_validation->set_message('fecha_erogacion_check', 'El formato del campo {field} es incorrecto, debe ser dd.mm.yyyy');
            return FALSE;
        }else{
            $aux = explode('.', $str);
            if(sizeof($aux) == 3 && $aux[2] == $this->input->post('valor_ejercicio')){
                return TRUE;
            }else{
                $this->form_validation->set_message('fecha_erogacion_check', 'El a&ntilde;o del campo {field} no corresponde con el ejercicio');
                return FALSE;
            }
        }
    }

    function facturas_paginacion(){
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        /* 
        * Paging
        */
        $iDisplayStart = 0;
        $iDisplayLength = 10;
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $iDisplayStart = $_GET['iDisplayStart'];
            $iDisplayLength = $_GET['iDisplayLength'];

            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
                intval( $_GET['iDisplayLength'] );
        }

        $data = $this->Facturas_model->dame_paginacion_facturas(false, $iDisplayStart, $iDisplayLength);
        

        header('Content-type: application/json');
        
        echo json_encode( $data );
    }

    function update_fecha_actualizacion($fecha, $numero_factura){
        $this->load->model('tpoadminv1/Generales_model');
        $this->load->model('tpoadminv1/logo/Logo_model');

        $format_date = $this->Generales_model->stringToDate($fecha);
        $mensaje = "Se actualizó de acuerdo a la fecha de erogación de la factura con número: " . $numero_factura;
        $this->Logo_model->actualizar_fecha_con_erogacion($format_date, $mensaje);
    }

    function lista_facturas($yearSelected = "",$statusSelected = ""){

        $yearSelected = $this->input->post('yearSelected');
        $statusSelected = $this->input->post('statusSelected');

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $data = $this->Facturas_model->dame_todas_facturas(false, $yearSelected, $statusSelected);
        
        header('Content-type: application/json');
        
        echo json_encode( $data );
    }

    function preparar_exportacion_facturas()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $path = $this->Facturas_model->descarga_facturas();

        header('Content-type: application/json');
        
        echo json_encode( base_url() . $path);
    }

    function busqueda_facturas()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
                
        $data['title'] = "Facturas";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/busqueda_facturas';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_facturas";
        $print_url_exp = base_url() . "index.php/tpoadminv1/print_ci/exportar_facturas";
        $data['link_descarga'] = base_url() . "index.php/tpoadminv1/capturista/facturas/preparar_exportacion_facturas";
        $data['link_edit_factura'] = base_url() . "index.php/tpoadminv1/capturista/facturas/editar_factura/";

        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        $data['print_onclick_exp'] = "onclick=\"window.open('" . $print_url_exp . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        
        $data['registros'] = '';//$this->Facturas_model->dame_todas_facturas(false);
        $data['yearSelected'] = $this->uri->segment(5);
        $data['statusSelected'] = $this->uri->segment(6);
        
        $data['path_file_csv'] = ''; //$this->Facturas_model->descarga_facturas();
        $data['name_file_csv'] = "facturas.csv";
        $serviceSide = base_url() . "index.php/tpoadminv1/capturista/facturas/lista_facturas";

        $data['serviceSide'] = $serviceSide;
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n  [licitaci&oacute;n p&uacute;blica, adjudicaci&oacute;n directa, invitaci&oacute;n restringida]',
            'id_proveedor' => 'Indica el nombre o raz&oacute;n social del proveedor',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_partida' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'id_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'motivo_adjudicacion' => '',
            'numero_factura' => 'Clave &uacute;nica o n&uacute;mero de erogaci&oacute;n o factura',
            'monto_factura' => 'Monto total de la factura, con I.V.A. incluido.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n de recursos,con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF',
            'file_factura_pdf' => 'Archivo de la factura en PDF',
            'url_factura_xml' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo de la factura en XML',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.',
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
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);

    }

    function get_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $registro = $this->Facturas_model->dame_factura_id($this->uri->segment(5));

        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function agregar_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $data['title'] = "Agregar factura";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/agregar_factura';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_factura' => '',
            'id_proveedor' => '',
            'id_contrato' => '',
            'id_orden_compra' => '',
            'id_ejercicio' => '',
            'id_trimestre' => '',
            'id_so_contratante' => '',
            'id_presupuesto_concepto' => '',
            'numero_factura' => '',
            'fecha_erogacion' => '',
            'url_factura_pdf' => '',
            'file_factura_pdf' => '',
            'url_factura_xml' => '',
            'file_factura_xml' => '',
            'name_file_factura_pdf' => '',
            'name_file_factura_xml' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n  [licitaci&oacute;n p&uacute;blica, adjudicaci&oacute;n directa, invitaci&oacute;n restringida]',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_partida' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'id_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'motivo_adjudicacion' => '',
            'numero_factura' => 'Clave o n&uacute;mero de erogaci&oacute;n o factura',
            'monto_factura' => 'Monto total de la factura, con I.V.A. incluido.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n de recursos,con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF', 
            'file_factura_pdf' => 'Archivo electr&oacute;nico de la factura en formato PDF',
            'url_factura_xml' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo electr&oacute;nico de la factura en formato XML',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
        );

        // poner true para ocultar los botones
        $data['control_update'] = array (
            'file_by_save' => false,
            'file_saved' => true,
            'file_see' => true,
            'file_load' => true, 
            "mensaje_file" => 'Formato permitido PDF.'
        );

        $data['control_update_2'] = array (
            'file_by_save_2' => false,
            'file_saved_2' => true,
            'file_see_2' => true,
            'file_load_2' => true, 
            "mensaje_file_2" => 'Formato permitido XML.'
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
                                        "if($('#type_file').val() == 'pdf'){ upload_file();" .
                                        "}else if($('#type_file').val() == 'xml'){ upload_file_2(); }" .
                                     "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "get_contratos();  get_ordenes(); limitar_fecha('#fecha_erogacion');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();  get_ordenes();" .
                                    "});" .
                                    "$('select[name=\"id_contrato\"]').change(function (){" .
                                        " set_proveedor_id($(this).find(':selected').data('proveedor')); get_ordenes();" .
                                    "});" .
                                    "limitar_fecha('#fecha_erogacion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_contrato', 'contrato', 'callback_id_contrato_check');
        $this->form_validation->set_rules('id_orden_compra', 'orden', 'callback_id_orden_compra_check');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('numero_factura', 'n&uacute;mero de factura', 'trim|required');
        $this->form_validation->set_rules('fecha_erogacion', 'Fecha de erogaci&oacute;n', 'callback_fecha_erogacion_check');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Agregar factura";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/agregar_factura';

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);

        $data['registro'] = array(
            'id_factura' => '',
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_contrato' => $this->input->post('id_contrato'),
            'id_orden_compra' => $this->input->post('id_orden_compra'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'numero_factura' => $this->input->post('numero_factura'),
            'fecha_erogacion' => $this->input->post('fecha_erogacion'),
            'url_factura_pdf' => $this->input->post('url_factura_pdf'),
            'file_factura_pdf' => $this->input->post('file_factura_pdf'),
            'url_factura_xml' => $this->input->post('url_factura_xml'),
            'file_factura_xml' => $this->input->post('file_factura_xml'),
            'name_file_factura_pdf' => $this->input->post('name_file_factura_pdf'),
            'name_file_factura_xml' => $this->input->post('name_file_factura_xml'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );

        if(isset($data['registro']) && !empty($data['registro'])){
            $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($data['registro']['id_ejercicio'], $data['registro']['id_proveedor']);
            $data['ordenes'] = $this->Ordenes_compra_model->dame_ordenes_by_ejercicio_proveedor_contrato($data['registro']['id_ejercicio'], $data['registro']['id_proveedor'], $data['registro']['id_contrato']);
        }
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n  [licitaci&oacute;n p&uacute;blica, adjudicaci&oacute;n directa, invitaci&oacute;n restringida]',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_partida' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'id_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'motivo_adjudicacion' => '',
            'numero_factura' => 'Clave o n&uacute;mero de erogaci&oacute;n o factura',
            'monto_factura' => 'Monto total de la factura, con I.V.A. incluido.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n de recursos,con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF',
            'file_factura_pdf' => 'Archivo electr&oacute;nico de la factura en formato PDF',
            'url_factura_XML' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo electr&oacute;nico de la factura en formato XML',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_factura_pdf']))
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

        if(!empty($data['registro']['name_file_factura_xml']))
        {
            $data['control_update_2'] = array(
                'file_by_save_2' => true,
                'file_saved_2' => false,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update_2'] = array(
                'file_by_save_2' => false,
                'file_saved_2' => true,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => 'Formato permitido XML.'
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
                                    "$('input:file').change(function (){" .
                                        "if($('#type_file').val() == 'pdf'){ upload_file();" .
                                        "}else if($('#type_file').val() == 'xml'){ upload_file_2(); }" .
                                     "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input:file').change(function (){" .
                                        "upload_file();" .
                                     "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "get_contratos();  get_ordenes(); limitar_fecha('#fecha_erogacion');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();  get_ordenes();" .
                                    "});" .
                                    "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor_id($(this).find(':selected').data('proveedor')); get_ordenes();" .
                                    "});" .
                                    "limitar_fecha('#fecha_erogacion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Facturas_model->agregar_factura();
            if($agregar == 1){
                $this->session->set_flashdata('exito', "La factura se ha creado correctamente");
                $this->update_fecha_actualizacion($this->input->post('fecha_erogacion'), $this->input->post('numero_factura'));
            }else if($agregar == 2){
                $this->session->set_flashdata('alert', "El n&uacute;mero de factura ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La factura no se pudo agregar");
            }
            if($redict)
            {
                $id = $this->Facturas_model->last_id_factura();
                if($id != 0){
                    $this->session->set_flashdata('tab_flag', "desglose");
                    redirect('/tpoadminv1/capturista/facturas/editar_factura/'.$id);
                }else{
                    redirect('/tpoadminv1/capturista/facturas/busqueda_facturas');
                }
            } 
        }
    }

    function editar_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $data['title'] = "Editar factura";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/editar_factura';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_factura_desglose/".$this->uri->segment(5);
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['registros'] = $this->Facturas_model->dame_todas_facturas_desglose($this->uri->segment(5), false);
        
        $data['path_file_csv'] = $this->Facturas_model->descarga_facturas_desglose($this->uri->segment(5));
        $data['name_file_csv'] = "detalle_facturas" . $this->uri->segment(5) . ".csv";

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['registro'] = $this->Facturas_model->dame_factura_id($this->uri->segment(5));
        
        if(isset($data['registro']) && !empty($data['registro'])){
            $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($data['registro']['id_ejercicio'], $data['registro']['id_proveedor']);
            $data['ordenes'] = $this->Ordenes_compra_model->dame_ordenes_by_ejercicio_proveedor_contrato($data['registro']['id_ejercicio'], $data['registro']['id_proveedor'], $data['registro']['id_contrato']);
        }
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n  [licitaci&oacute;n p&uacute;blica, adjudicaci&oacute;n directa, invitaci&oacute;n restringida]',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_partida' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'id_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la Campa&ntilde;a o Aviso Institucional.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'motivo_adjudicacion' => '',
            'numero_factura' => 'Clave o n&uacute;mero de erogaci&oacute;n o factura',
            'monto_factura' => 'Monto total de la factura, con I.V.A. incluido.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n de recursos,con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF',
            'file_factura_pdf' => 'Archivo electr&oacute;nico de la factura en formato PDF',
            'url_factura_xml' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo electr&oacute;nico de la factura en formato XML',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'monto_desglose' => 'Indica el monto correspondiente a cada subconcepto, calculado con la multiplicación de la cantidad por el precio unitario con IVA incluido del producto o servicio adquirido.', 
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_factura_pdf']))
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

        if(!empty($data['registro']['name_file_factura_xml']))
        {
            $data['control_update_2'] = array(
                'file_by_save_2' => true,
                'file_saved_2' => false,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update_2'] = array(
                'file_by_save_2' => false,
                'file_saved_2' => true,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => 'Formato permitido XML.'
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
                                    "$('#detalle_facturas').dataTable({" .
                                        "'bPaginate': true," .
                                        "'bLengthChange': true," .
                                        "'bFilter': true," .
                                        "'bSort': true," .
                                        "'bInfo': true," .
                                        "'bAutoWidth': false," .
                                        "'columnDefs': [ " .
                                            "{ 'orderable': false, 'targets': [4,5,6] } " .
                                        "],".
                                        "'aLengthMenu': [[10, 25, 50, 100], [10, 25, 50, 100]], " .   //Paginacion
                                        "'oLanguage': { " .
                                            "'sSearch': 'B&uacute;squeda '," .
                                            "'sInfoFiltered': '(filtrado de un total de _MAX_ registros)'," .
                                            "'sInfo': 'Mostrando registros del <b>_START_</b> al <b>_END_</b> de un total de <b>_TOTAL_</b> registros'," .
                                            "'sZeroRecords': 'No se encontraron resultados'," .
                                            "'EmptyTable': 'Ning&uacute;n dato disponible en esta tabla'," .
                                            "'sInfoEmpty': 'Mostrando registros del 0 al 0 de un total de 0 registros'," .
                                            "'sLoadingRecords': 'Cargando...',".
                                            "'sProcessing': 'Cargando...',".
                                            "'oPaginate': {" .
                                                "'sFirst': 'Primero'," .
                                                "'sLast': '&Uacute;ltimo'," .
                                                "'sNext': 'Siguiente'," .
                                                "'sPrevious': 'Anterior'" .
                                            "}," .
                                            "'sLengthMenu': '_MENU_ Registros por p&aacute;gina'" .
                                        "}" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input:file').change(function (){" .
                                        "if($('#type_file').val() == 'pdf'){ upload_file();" .
                                        "}else if($('#type_file').val() == 'xml'){ upload_file_2(); }" .
                                     "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "get_contratos();  get_ordenes(); limitar_fecha('#fecha_erogacion');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();  get_ordenes(); " .
                                    "});" .
                                    "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor_id($(this).find(':selected').data('proveedor')); get_ordenes();" .
                                    "});" .
                                    "limitar_fecha('#fecha_erogacion');" .
                                "});" .
                            "</script>";

        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_ejercicio', 'ejercicio', 'required');
        $this->form_validation->set_rules('id_proveedor', 'nombre o raz&oacute;n social del proveedor', 'required');
        $this->form_validation->set_rules('id_contrato', 'contrato', 'callback_id_contrato_check');
        $this->form_validation->set_rules('id_orden_compra', 'orden', 'callback_id_orden_compra_check');
        $this->form_validation->set_rules('id_trimestre', 'trimestre', 'required');
        $this->form_validation->set_rules('numero_factura', 'n&uacute;mero de factura', 'trim|required');
        $this->form_validation->set_rules('fecha_erogacion', 'Fecha de erogaci&oacute;n', 'callback_fecha_erogacion_check');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['title'] = "Editar factura";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/editar_factura';
        $print_url = base_url() . "index.php/tpoadminv1/print_ci/print_detalle_factura";
        $data['print_onclick'] = "onclick=\"window.open('" . $print_url . "', '_blank', 'location=yes,height=670,width=1020,scrollbars=yes,status=yes')\"";
        
        $data['registros'] = $this->Facturas_model->dame_todas_facturas_desglose($this->uri->segment(5), false);
        
        $data['path_file_csv'] = ''; //$this->Facturas_model->descarga_facturas();
        $data['name_file_csv'] = "detalle_facturas" . $this->uri->segment(5) . ".csv";

        $data['ejercicios'] = $this->Catalogos_model->dame_todos_ejercicios(true);
        $data['trimestres'] = $this->Catalogos_model->dame_todos_trimestres(true);
        $data['procedimientos'] = $this->Catalogos_model->dame_todos_procedimientos(true);
        $data['proveedores'] = $this->Proveedores_model->dame_todos_proveedores(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
      
        $data['registro'] = array(
            'id_factura' => $this->input->post('id_factura'),
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_contrato' => $this->input->post('id_contrato'),
            'id_orden_compra' => $this->input->post('id_orden_compra'),
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_trimestre' => $this->input->post('id_trimestre'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'numero_factura' => $this->input->post('numero_factura'),
            'fecha_erogacion' => $this->input->post('fecha_erogacion'),
            'url_factura_pdf' => $this->input->post('url_factura_pdf'),
            'file_factura_pdf' => $this->input->post('file_factura_pdf'),
            'url_factura_xml' => $this->input->post('url_factura_xml'),
            'file_factura_xml' => $this->input->post('file_factura_xml'),
            'name_file_factura_pdf' => $this->input->post('name_file_factura_pdf'),
            'name_file_factura_xml' => $this->input->post('name_file_factura_xml'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
            
        );
        
        if(isset($data['registro']) && !empty($data['registro'])){
            $data['contratos'] = $this->Contratos_model->dame_contrato_by_ejercicio_proveedor($data['registro']['id_ejercicio'], $data['registro']['id_proveedor']);
            $data['ordenes'] = $this->Ordenes_compra_model->dame_ordenes_by_ejercicio_proveedor_contrato($data['registro']['id_ejercicio'], $data['registro']['id_proveedor'], $data['registro']['id_contrato']);
        }
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_contrato'  => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico del contrato',
            'id_procedimiento' => 'Indica el tipo de procedimiento de contrataci&oacute;n  [licitaci&oacute;n p&uacute;blica, adjudicaci&oacute;n directa, invitaci&oacute;n restringida]',
            'id_proveedor' => 'Indica el nombre de la persona f&iacute;sica o moral proveedora del producto o servicio.',
            'id_ejercicio' => 'Indica el a&ntilde;o del ejercicio presupuestario.',
            'id_partida' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_trimestre' => 'Indica el trimestre que se reporta (enero – marzo, abril-junio, julio-septiembre,  octubre-diciembre ).',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el
             contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinación General de Comunicaci&oacute;n Social).',
            'id_orden_compra' => 'Clave o n&uacute;mero de identificaci&oacute;n &uacute;nico de la orden de compra.',
            'id_campana_aviso' => 'Indica el nombre de la Campa&ntilde;a o Aviso Institucional.',
            'descripcion_justificacion' => 'Descripci&oacute;n breve de los motivos que justifican la elecci&oacute;n del proveedor',
            'motivo_adjudicacion' => '',
            'numero_factura' => 'Clave o n&uacute;mero de erogaci&oacute;n o factura',
            'monto_factura' => 'Monto total de la factura, con I.V.A. incluido.',
            'fecha_erogacion' => 'Fecha de erogaci&oacute;n de recursos,con el formato dd/mm/aaaa (por ej. 31/03/2016)',
            'url_factura_pdf' => 'Hipervínculo a la factura en formato PDF',
            'file_factura_pdf' => 'Archivo electr&oacute;nico de la factura en formato PDF',
            'url_factura_xml' => 'Hipervínculo a la factura en formato XML',
            'file_factura_xml' => 'Archivo electr&oacute;nico de la factura en formato XML',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.'
        );

        // poner true para ocultar los botones
        if(!empty($data['registro']['name_file_factura_pdf']))
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

        if(!empty($data['registro']['name_file_factura_xml']))
        {
            $data['control_update_2'] = array(
                'file_by_save_2' => true,
                'file_saved_2' => false,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => '<span class="text-success">Archivo cargado correctamente</span>'
            );
        }else {
            $data['control_update_2'] = array(
                'file_by_save_2' => false,
                'file_saved_2' => true,
                'file_see_2' => true,
                'file_load_2' => true,
                "mensaje_file_2" => 'Formato permitido XML.'
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
                                        "if($('#type_file').val() == 'pdf'){ upload_file();" .
                                        "}else if($('#type_file').val() == 'xml'){ upload_file_2(); }" .
                                     "});" .
                                    "$('select[name=\"id_ejercicio\"]').change(function (){" .
                                        "get_contratos();  get_ordenes(); limitar_fecha('#fecha_erogacion');" .
                                     "});" .
                                    "$('select[name=\"id_proveedor\"]').change(function (){" .
                                        "get_contratos();  get_ordenes();" .
                                     "});" .
                                     "$('select[name=\"id_contrato\"]').change(function (){" .
                                        "set_proveedor_id($(this).find(':selected').data('proveedor')); get_ordenes();" .
                                     "});" .
                                     "limitar_fecha('#fecha_erogacion');" .
                                "});" .
                            "</script>";

        $data['file_error'] = false;

        if ($this->form_validation->run() == FALSE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Facturas_model->editar_factura();
            if($editar == 1){
                if($this->input->post('fecha_erogacion') != $this->input->post('fecha_erogacion_actual')){
                    $this->update_fecha_actualizacion($this->input->post('fecha_erogacion'), $this->input->post('numero_factura'));
                }
                $this->session->set_flashdata('exito', "La factura se ha editado correctamente");
            }else if($editar == 2){
                $this->session->set_flashdata('alert', "El valor ya se encuentra registrado");
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La factura no se pudo editar");
            }
            if($redict)
            {
                redirect('/tpoadminv1/capturista/facturas/busqueda_facturas');
            } 
        }
    }

    function validate_editar_status_factura()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Proveedores_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Ordenes_compra_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        
        $redict = true;
        $editar = $this->Facturas_model->editar_status_factura();
        if($editar == 1){
            if($this->input->post('fecha_erogacion') != $this->input->post('fecha_erogacion_actual')){
                $this->update_fecha_actualizacion($this->input->post('fecha_erogacion'), $this->input->post('numero_factura'));
            }
            $this->session->set_flashdata('exito', "Las facturas se han editado correctamente");
        }else{
            $this->session->set_flashdata('error', "Las facturas no se pudieron editar");
        }
        if($redict)
        {
            redirect('/tpoadminv1/capturista/facturas/busqueda_facturas');
        } 
        
    }

    function eliminar_factura()
    {

        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $facturas_desgloses = $this->Facturas_model->dame_todas_facturas_desglose($this->uri->segment(5), false);

        if(sizeof($facturas_desgloses) > 0)
        {
            $this->session->set_flashdata('error', "La factura tiene asociados desgloses, primero debe eliminar &eacute;stos.");
        }else{
            $eliminar = $this->Facturas_model->eliminar_factura($this->uri->segment(5));

            if($eliminar == 1){
                $this->session->set_flashdata('exito', "Registro eliminado correctamente");
            }else {
                $this->session->set_flashdata('error', "Registro no se pudo eliminar");
            }
        }

        redirect('/tpoadminv1/capturista/facturas/busqueda_facturas');
    }

    function upload_file()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
        $this->load->model('tpoadminv1/Generales_model');

        $name_file = $this->Generales_model->clean_file_name(basename($_FILES['file']['name']), false);
        $registro = array('error','<span class="text-danger">No fue posible subir el archivo, intentelo de nuevo.'. $name_file .'</span>');
        if(isset($name_file) && !empty($name_file))
        {
            $porciones = explode(".", $name_file);
            $size = sizeof($porciones);
            if($size >= 2){
                $extenciones = array('pdf');
                if($this->input->post('type') == 'file_factura_xml')
                {
                    $extenciones = array('xml', 'xmls');
                }
               
                $aux = strtolower($porciones[$size-1]); 
                if(in_array($aux, $extenciones)){

                    $name_file = $this->Generales_model->existe_nombre_archivo('./data/facturas/', utf8_decode($name_file));

                    // se guarda el archivo
                    $config['upload_path'] = './data/facturas';
                    $config['allowed_types']        = '*';
                    $config['detect_mime']          = false;
                    $config['max_size']	= '20000';
                    $config['max_width']  = '0';
                    $config['max_height']  = '0';
                    $config['overwrite']  = TRUE;
                    $config['file_name']  = $name_file;

                    $this->load->library('upload', $config);

                    if(!$this->upload->do_upload('file')){
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
        $clear_path = './data/facturas/' . $this->input->post('file');
        if(file_exists($clear_path))
            unlink($clear_path);

        $registro = array('exito','Eliminado');
        header('Content-type: application/json');
        
        echo json_encode( $registro );
    }

    function get_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();
                
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $registro = $this->Facturas_model->dame_factura_desglose_id($this->uri->segment(5));

        header('Content-type: application/json');

        echo json_encode( $registro );
    }

    function agregar_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        

        $data['title'] = "Agregar factura desglose";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/agregar_factura_desglose';

        $factura = $this->Facturas_model->dame_factura_id($this->uri->segment(5));
        $id_ejercicio = '';
        if(isset($factura) && !empty($factura))
        {
            $id_ejercicio = $factura['id_ejercicio'];
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($factura['id_ejercicio']);
        }
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['clasificaciones'] = $this->Catalogos_model->dame_clasificaciones_activas();
        
        $data['error_partida'] = FALSE;
        $data['mensaje_partida'] = '';
        $data['error_monto_contrato'] = FALSE;
        $data['mensaje_monto_contrato']  = '';

        $data['registro'] = array(
            'id_factura_desglose' => '',
            'id_ejercicio' => $id_ejercicio,
            'id_factura' => $this->uri->segment(5),
            'id_campana_aviso' => '',
            'id_servicio_clasificacion' => '',
            'id_servicio_categoria' => '',
            'id_servicio_subcategoria' => '',
            'id_servicio_unidad' => '',
            'id_so_contratante' => '',
            'id_presupuesto_concepto' => '',
            'id_so_solicitante' => '',
            'id_presupuesto_concepto_solicitante' => '',
            'numero_partida' => '',
            'descripcion_servicios' => '',
            'cantidad' => '1.00',
            'precio_unitarios' => '0.00',
            'monto_desglose' => '0.00',
            'area_administrativa' => '',
            'fecha_validacion' => '',
            'area_responsable' => '',
            'periodo' => '',
            'fecha_actualizacion' => '',
            'nota' => '',
            'active' => 'null'
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_factura_desglose' => '',
            'id_factura' => '',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
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
                                    "$('select[name=\"id_servicio_clasificacion\"]').change(function (){" .
                                        "get_categorias();" .
                                    "});" .
                                    "$('select[name=\"id_servicio_categoria\"]').change(function (){" .
                                        "get_subcategorias();" .
                                    "});" .
                                    "$('select[name=\"id_servicio_subcategoria\"]').change(function (){" .
                                        "get_unidades();" .
                                    "});" .
                                    "$('select[name=\"id_so_contratante\"]').change(function (){" .
                                        "get_partidas('contratante');" .
                                    "});" .
                                    "$('select[name=\"id_so_solicitante\"]').change(function (){" .
                                        "get_partidas('solicitante');" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_c').html(''); }else { $('#error_p_c').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto_solicitante\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_s').html(''); }else { $('#error_p_s').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_agregar_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_campana_aviso', 'campa&ntilde;a o aviso institucional', 'required');
        $this->form_validation->set_rules('id_servicio_clasificacion', 'clasificaci&oacute;n del servicio', 'required');
        $this->form_validation->set_rules('id_servicio_categoria', 'categor&iacute;a del servicio', 'callback_id_servicio_categoria_check');
        $this->form_validation->set_rules('id_servicio_subcategoria', 'subcategor&iacute;a del servicio', 'callback_id_servicio_subcategoria_check');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado contratante', 'required');
        $this->form_validation->set_rules('id_presupuesto_concepto', 'partida de contratante', 'callback_id_presupuesto_concepto_check');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('id_presupuesto_concepto_solicitante', 'partida de solicitante', 'callback_id_presupuesto_concepto_solicitante_check');
        $this->form_validation->set_rules('descripcion_servicios', 'descripci&oacute;n de servicios', 'required');
        $this->form_validation->set_rules('cantidad', 'cantidad', 'required');
        $this->form_validation->set_rules('precio_unitarios', 'precio unitario con I.V.A. incluido', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        
        $data['title'] = "Agregar factura desglose";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/agregar_factura_desglose';

        $factura = $this->Facturas_model->dame_factura_id($this->input->post('id_factura'));
        if(isset($factura) && !empty($factura))
        {
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($factura['id_ejercicio']);
            //$data['presupuestos'] = $this->Presupuestos_model->dame_presupuestos_by_ejercicio_so_contratante($factura['id_ejercicio'], $factura['id_so_contratante']);
        }
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['clasificaciones'] = $this->Catalogos_model->dame_clasificaciones_activas();

        if(!empty($this->input->post('id_servicio_clasificacion')))
        {
            $data['categorias'] = $this->Catalogos_model->get_categorias_filtro($this->input->post('id_servicio_clasificacion'));
        }

        if(!empty($this->input->post('id_servicio_categoria')))
        {
            $data['subcategorias'] = $this->Catalogos_model->get_subcategorias_filtro($this->input->post('id_servicio_categoria'));
        }

        if(!empty($this->input->post('id_servicio_subcategoria')))
        {
            $data['unidades'] = $this->Catalogos_model->get_unidades_filtro($this->input->post('id_servicio_subcategoria'));
        }

        if(!empty($this->input->post('id_so_contratante')))
        {
            $data['presupuestos'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($this->input->post('id_ejercicio'),
                    $this->input->post('id_so_contratante'), 'contratatante');
        }

        if(!empty($this->input->post('id_so_solicitante')))
        {
            $data['presupuestos_solicitantes'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($this->input->post('id_ejercicio'),
                    $this->input->post('id_so_solicitante'), 'solicitante');
        }

        $data['registro'] = array(
            'id_factura_desglose' => '',
            'id_ejercicio' => $this->input->post('id_ejercicio'),
            'id_factura' => $this->input->post('id_factura'),
            'id_campana_aviso' => $this->input->post('id_campana_aviso'),
            'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
            'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
            'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
            'id_servicio_unidad' => $this->input->post('id_servicio_unidad'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'id_presupuesto_concepto_solicitante' => $this->input->post('id_presupuesto_concepto_solicitante'),
            'numero_partida' => $this->input->post('numero_partida'),
            'descripcion_servicios' => $this->input->post('descripcion_servicios'),
            'cantidad' => $this->input->post('cantidad'),
            'precio_unitarios' => $this->input->post('precio_unitarios'),
            'monto_desglose' => $this->input->post('monto_desglose'),
            'area_administrativa' => $this->input->post('area_administrativa'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_factura_desglose' => '',
            'id_factura' => '',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea', setup: function(ed){ ed.on('change', function(e){ $('div').removeClass('has-error'); })} });" .
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
                                    "$('select[name=\"id_servicio_clasificacion\"]').change(function (){" .
                                        "get_categorias();" .
                                     "});" .
                                    "$('select[name=\"id_servicio_categoria\"]').change(function (){" .
                                        "get_subcategorias();" .
                                    "});" .
                                    "$('select[name=\"id_servicio_subcategoria\"]').change(function (){" .
                                        "get_unidades();" .
                                    "});" .
                                    "$('select[name=\"id_so_contratante\"]').change(function (){" .
                                        "get_partidas('contratante');" .
                                    "});" .
                                    "$('select[name=\"id_so_solicitante\"]').change(function (){" .
                                        "get_partidas('solicitante');" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_c').html(''); }else { $('#error_p_c').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto_solicitante\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_s').html(''); }else { $('#error_p_s').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                "});" .
                            "</script>";

        $data['error_partida'] = FALSE;
        $data['mensaje_partida'] = '';
        if($this->input->post('id_presupuesto_concepto') == '-1' &&
            $this->input->post('id_presupuesto_concepto_solicitante') == '-1' ){
            $data['error_partida'] = TRUE;
            $data['mensaje_partida'] = "<p>Es necesario seleccionar una partida de alguno de los sujetos obligados</p>";
        }else if($this->input->post('id_presupuesto_concepto') != '-1' &&
                    $this->input->post('id_presupuesto_concepto_solicitante') != '-1'){
            $data['error_partida'] = TRUE;
            $data['mensaje_partida'] = '<p>Solo se permite seleccionar una partida de alguno de los sujetos obligados</p>';
        }
        
        $data['error_monto_contrato'] = FALSE;
        $data['mensaje_monto_contrato']  = '';
        if($this->Facturas_model->revisar_invalides_monto_contrato($this->input->post('id_factura'),
                 $this->input->post('cantidad'), $this->input->post('precio_unitarios'), 0)){
            $data['error_monto_contrato'] = TRUE;
            $data['mensaje_monto_contrato'] = '<p>El monto de desglose (cantidad x precio unitario) es superior al monto total del contrato ligado a esta factura.</p>';
        }

        if ($this->form_validation->run() == FALSE || $data['error_partida'] == TRUE || $data['error_monto_contrato'] == TRUE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $agregar = $this->Facturas_model->agregar_factura_desglose();
            if($agregar[0] == 1){
                $this->session->set_flashdata('exito', "La factura desglose se ha creado correctamente");
            }else if($agregar[0] == 2){
                $this->session->set_flashdata('alert', $agregar[1]);
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La factura desglose no se pudo agregar");
            }
            if($redict)
            {
                $this->session->set_flashdata('tab_flag', "desglose");
                redirect('/tpoadminv1/capturista/facturas/editar_factura/'.$this->input->post('id_factura'));
            } 
        }
    }

    function editar_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        

        $data['title'] = "Editar factura desglose";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/editar_factura_desglose';

        $factura = $this->Facturas_model->dame_factura_id($this->uri->segment(6));
        $data['id_ejercicio'] = '';
        if(isset($factura) && !empty($factura))
        {
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($factura['id_ejercicio']);
            $data['id_ejercicio'] = $factura['id_ejercicio'];
            //$data['presupuestos'] = $this->Presupuestos_model->dame_presupuestos_by_ejercicio_so_contratante($factura['id_ejercicio'], $factura['id_so_contratante']);
        }
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['clasificaciones'] = $this->Catalogos_model->dame_clasificaciones_activas();
        $data['registro'] = $this->Facturas_model->dame_factura_desglose_id($this->uri->segment(5));

        if(!empty($data['registro']['id_servicio_clasificacion']))
        {
            $data['categorias'] = $this->Catalogos_model->get_categorias_filtro($data['registro']['id_servicio_clasificacion']);
        }

        if(!empty($data['registro']['id_servicio_categoria']))
        {
            $data['subcategorias'] = $this->Catalogos_model->get_subcategorias_filtro($data['registro']['id_servicio_categoria']);
        }

        if(!empty($data['registro']['id_servicio_subcategoria']))
        {
            $data['unidades'] = $this->Catalogos_model->get_unidades_filtro($data['registro']['id_servicio_subcategoria']);
        }
        
        if(!empty($data['registro']['id_so_contratante']))
        {
            $data['presupuestos'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($data['id_ejercicio'],
                $data['registro']['id_so_contratante'], 'contratatante');
        }

        if(!empty($data['registro']['id_so_solicitante']))
        {
            $data['presupuestos_solicitantes'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($data['id_ejercicio'],
                $data['registro']['id_so_solicitante'], 'solicitante');
        }

        $data['error_monto_contrato'] = FALSE;
        $data['mensaje_monto_contrato']  = '';

        $data['error_partida'] = FALSE;
        $data['mensaje_partida'] = '';
        
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_factura_desglose' => '',
            'id_factura' => '',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
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
                                    "$('select[name=\"id_servicio_clasificacion\"]').change(function (){" .
                                        "get_categorias();" .
                                     "});" .
                                    "$('select[name=\"id_servicio_categoria\"]').change(function (){" .
                                        "get_subcategorias();" .
                                     "});" .
                                     "$('select[name=\"id_servicio_subcategoria\"]').change(function (){" .
                                        "get_unidades();" .
                                     "});" .
                                    "$('select[name=\"id_so_contratante\"]').change(function (){" .
                                        "get_partidas('contratante');" .
                                    "});" .
                                    "$('select[name=\"id_so_solicitante\"]').change(function (){" .
                                        "get_partidas('solicitante');" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_c').html(''); }else { $('#error_p_c').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto_solicitante\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_s').html(''); }else { $('#error_p_s').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                "});" .
                            "</script>";
        
        $this->load->view('tpoadminv1/includes/template', $data);
    }

    function validate_editar_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_campana_aviso', 'campa&ntilde;a o aviso institucional', 'required');
        $this->form_validation->set_rules('id_servicio_clasificacion', 'clasificaci&oacute;n del servicio', 'required');
        $this->form_validation->set_rules('id_servicio_categoria', 'categor&iacute;a del servicio', 'callback_id_servicio_categoria_check');
        $this->form_validation->set_rules('id_servicio_subcategoria', 'subcategor&iacute;a del servicio', 'callback_id_servicio_subcategoria_check');
        $this->form_validation->set_rules('id_so_contratante', 'sujeto obligado contratante', 'required');
        $this->form_validation->set_rules('id_presupuesto_concepto', 'partida de contratante', 'callback_id_presupuesto_concepto_check');
        $this->form_validation->set_rules('id_so_solicitante', 'sujeto obligado solicitante', 'required');
        $this->form_validation->set_rules('id_presupuesto_concepto_solicitante', 'partida de solicitante', 'callback_id_presupuesto_concepto_solicitante_check');
        $this->form_validation->set_rules('descripcion_servicios', 'descripci&oacute;n de servicios', 'required');
        $this->form_validation->set_rules('cantidad', 'cantidad', 'required');
        $this->form_validation->set_rules('precio_unitarios', 'precio unitario con I.V.A. incluido', 'required');
        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        
        $data['title'] = "Editar factura desglose";
        $data['heading'] = $this->session->userdata('usuario_nombre');
        $data['mensaje'] = "";
        $data['job'] = $this->session->userdata('usuario_rol_nombre');
        $data['active'] = 'facturas'; // solo active 
        $data['subactive'] = 'busqueda_facturas'; // class="active"
        $data['body_class'] = 'skin-blue';
        $data['main_content'] = 'tpoadminv1/facturas/editar_factura_desglose';

        $data['id_ejercicio'] = '';
        $factura = $this->Facturas_model->dame_factura_id($this->input->post('id_factura'));
        if(isset($factura) && !empty($factura))
        {
            $data['campanas_avisos'] = $this->Ordenes_compra_model->dame_campanas_by_ejercicio($factura['id_ejercicio']);
            $data['id_ejercicio'] = $factura['id_ejercicio'];
            //$data['presupuestos'] = $this->Presupuestos_model->dame_presupuestos_by_ejercicio_so_contratante($factura['id_ejercicio'], $factura['id_so_contratante']);
        }
        $data['so_solicitantes'] = $this->Contratos_model->dame_todos_so_solicitantes(true);
        $data['so_contratantes'] = $this->Contratos_model->dame_todos_so_contratantes(true);
        $data['clasificaciones'] = $this->Catalogos_model->dame_clasificaciones_activas();

        if(!empty($this->input->post('id_servicio_clasificacion')))
        {
            $data['categorias'] = $this->Catalogos_model->get_categorias_filtro($this->input->post('id_servicio_clasificacion'));
        }

        if(!empty($this->input->post('id_servicio_categoria')))
        {
            $data['subcategorias'] = $this->Catalogos_model->get_subcategorias_filtro($this->input->post('id_servicio_categoria'));
        }

        if(!empty($this->input->post('id_servicio_subcategoria')))
        {
            $data['unidades'] = $this->Catalogos_model->get_unidades_filtro($this->input->post('id_servicio_subcategoria'));
        }

        if(!empty($this->input->post('id_so_contratante')))
        {
            $data['presupuestos'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($this->input->post('id_ejercicio'),
                    $this->input->post('id_so_contratante'), 'contratatante');
        }

        if(!empty($this->input->post('id_so_solicitante')))
        {
            $data['presupuestos_solicitantes'] = $this->Presupuestos_model->dame_nombres_partidas_presupuestos($this->input->post('id_ejercicio'),
                    $this->input->post('id_so_solicitante'), 'solicitante');
        }

        $data['registro'] = array(
            'id_factura_desglose' => $this->input->post('id_factura_desglose'),
            'id_factura' => $this->input->post('id_factura'),
            'id_campana_aviso' => $this->input->post('id_campana_aviso'),
            'id_servicio_clasificacion' => $this->input->post('id_servicio_clasificacion'),
            'id_servicio_categoria' => $this->input->post('id_servicio_categoria'),
            'id_servicio_subcategoria' => $this->input->post('id_servicio_subcategoria'),
            'id_servicio_unidad' => $this->input->post('id_servicio_unidad'),
            'id_so_contratante' => $this->input->post('id_so_contratante'),
            'id_presupuesto_concepto' => $this->input->post('id_presupuesto_concepto'),
            'id_so_solicitante' => $this->input->post('id_so_solicitante'),
            'id_presupuesto_concepto_solicitante' => $this->input->post('id_presupuesto_concepto_solicitante'),
            'numero_partida' => $this->input->post('numero_partida'),
            'descripcion_servicios' => $this->input->post('descripcion_servicios'),
            'cantidad' => $this->input->post('cantidad'),
            'precio_unitarios' => $this->input->post('precio_unitarios'),
            'monto_desglose' => $this->input->post('monto_desglose'),
            'area_administrativa' => $this->input->post('area_administrativa'),
            'fecha_validacion' => $this->input->post('fecha_validacion'),
            'area_responsable' => $this->input->post('area_responsable'),
            'periodo' => $this->input->post('periodo'),
            'fecha_actualizacion' => $this->input->post('fecha_actualizacion'),
            'nota' => $this->input->post('nota'),
            'active' => $this->input->post('active')
        );
        //texto para dialogos de ayuda
        $data['texto_ayuda'] = array(
            'id_factura_desglose' => '',
            'id_factura' => '',
            'id_campana_aviso' => 'Indica el nombre de la campa&ntilde;a o aviso institucional a la que pertenece.',
            'id_servicio_clasificacion' => 'Indica el nombre de la clasificaci&oacute;n general del servicio (Servicios de difusi&oacute;n en medios de comunicaci&oacute;n; Otros servicios asociados a la comunicaci&oacute;n).',
            'id_servicio_categoria' => 'Indica el nombre de la categor&iacute;a del servicio de acuerdo a su clasificaci&oacute;n (An&aacute;lisis, estudios y m&eacute;tricas, Cine, Impresiones, Internet, etc).',
            'id_servicio_subcategoria' => 'Indica el nombre de la subcategor&iacute;a del servicio (Art&iacute;culos promocionales, Cadenas radiof&oacute;nicas, Carteles o posters).',
            'id_servicio_unidad' => 'Indica la unidad de medida del producto o servicio asociado a la subcategor&iacute;a.',
            'id_so_contratante' => 'Indica el nombre del sujeto obligado que celebra el contrato u orden de compra con el proveedor.',
            'id_so_solicitante' => 'Indica el nombre del sujeto que solicit&oacute; el producto o servicio aunque &eacute;ste no sea quien celebra el contrato u orden de compra con el proveedor (Ej. Sujeto obligado solicitante: Secretar&iacute;a de Cultura; sujeto obligado contratante: Coordinaci&oacute;n General de Comunicaci&oacute;n Social).',
            'id_presupuesto_concepto' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'id_presupuesto_concepto_solicitante' => 'Indica la clave y el nombre del concepto o partida presupuestal.',
            'numero_partida' => '',
            'descripcion_servicios' => 'Breve descripci&oacute;n del servicio o producto adquirido.',
            'cantidad' => 'Indica la cantidad del servicio o producto adquirido.',
            'precio_unitarios' => 'Indica el precio unitario del producto o servicio, con I.V.A. incluido.',
            'area_administrativa' => '&Aacute;rea administrativa encargada de solicitar el servicio.',
            'fecha_validacion' => 'Fecha de validaci&oacute;n',
            'area_responsable' => '&Aacute;rea responsable de la informaci&oacute;n',
            'periodo' => 'A&ntilde;o',
            'fecha_actualizacion' => 'Fecha de actualizaci&oacute;n',
            'nota' => 'Nota',
            'active' => 'Indica el estado de la informaci&oacute;n correspondiente al registro, “Activa”, “Inactiva”.'
        );

        $data['scripts'] = "<script type='text/javascript'>" .
                                "$(function () {" .
                                    "tinymce.init({ selector:'textarea', setup: function(ed){ ed.on('change', function(e){ $('div').removeClass('has-error'); })} });" .
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
                                    "$('select[name=\"id_servicio_clasificacion\"]').change(function (){" .
                                        "get_categorias();" .
                                     "});" .
                                    "$('select[name=\"id_servicio_categoria\"]').change(function (){" .
                                        "get_subcategorias();" .
                                     "});" .
                                     "$('select[name=\"id_servicio_subcategoria\"]').change(function (){" .
                                        "get_unidades();" .
                                     "});" .
                                    "$('select[name=\"id_so_contratante\"]').change(function (){" .
                                        "get_partidas('contratante');" .
                                    "});" .
                                    "$('select[name=\"id_so_solicitante\"]').change(function (){" .
                                        "get_partidas('solicitante');" .
                                    "});" .
                                    "$('select').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('input[type=\"text\"]').change(function(){" .
                                        "$(this).removeClass('has-error');" .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_c').html(''); }else { $('#error_p_c').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                    "$('select[name=\"id_presupuesto_concepto_solicitante\"]').change(function(){".
                                        "var status = $(this).find(':selected').data(\"valido\"); " .
                                        "if(status == true){ $('#error_p_s').html(''); }else { $('#error_p_s').html('Esta partida no cuenta con mas presupuesto disponible.'); } " .
                                    "});" .
                                "});" .
                            "</script>";
        
        $data['error_partida'] = FALSE;
        $data['mensaje_partida'] = '';
        if($this->input->post('id_presupuesto_concepto') == '-1' &&
            $this->input->post('id_presupuesto_concepto_solicitante') == '-1' ){
            $data['error_partida'] = TRUE;
            $data['mensaje_partida'] = "<p>Es necesario seleccionar una partida de alguno de los sujetos obligado</p>";
        }else if($this->input->post('id_presupuesto_concepto') != '-1' &&
                    $this->input->post('id_presupuesto_concepto_solicitante') != '-1'){
            $data['error_partida'] = TRUE;
            $data['mensaje_partida'] = '<p>Solo se permite seleccionar una partida de alguno de los sujetos obligados</p>';
        }
        
        $data['error_monto_contrato'] = FALSE;
        $data['mensaje_monto_contrato']  = '';
        if($this->Facturas_model->revisar_invalides_monto_contrato($this->input->post('id_factura'),
                 $this->input->post('cantidad'), $this->input->post('precio_unitarios'), $this->input->post('id_factura_desglose'))){
            $data['error_monto_contrato'] = TRUE;
            $data['mensaje_monto_contrato'] = '<p>El monto de desglose (cantidad x precio unitario) es superior al monto total del contrato ligado a esta factura.</p>';
        }

        if ($this->form_validation->run() == FALSE || $data['error_partida'] == TRUE || $data['error_monto_contrato'] == TRUE) 
        {
            $this->load->view('tpoadminv1/includes/template', $data);
        }else
        {
            $redict = true;
            $editar = $this->Facturas_model->editar_factura_desglose();
            if($editar[0] == 1){
                $this->session->set_flashdata('exito', "La factura desglose se ha editado correctamente");
            }else if($editar[0] == 2){
                $this->session->set_flashdata('alert', $editar[1]);
                $this->load->view('tpoadminv1/includes/template', $data);
                $redict = false;
            }else{
                $this->session->set_flashdata('error', "La factura desglose no se pudo editar");
            }
            if($redict)
            {
                $this->session->set_flashdata('tab_flag', "desglose");
                redirect('/tpoadminv1/capturista/facturas/editar_factura/'.$this->input->post('id_factura'));
            } 
        }
    }

    function validate_editar_status_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/catalogos/Catalogos_model');
        $this->load->model('tpoadminv1/capturista/Presupuestos_model');
        $this->load->model('tpoadminv1/capturista/Contratos_model');
        $this->load->model('tpoadminv1/capturista/Facturas_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('active', 'estatus', 'required');
        $this->form_validation->set_error_delimiters('<p>','</p>');

        $data['registro'] = array(
            'active' => $this->input->post('active')
        );
        
        $redict = true;
        $editar = $this->Facturas_model->editar_status_factura_desglose($this->input->post('id_factura'));
        if($editar[0] == 1){
            $this->session->set_flashdata('exito', "La facturas desgloses se han editado correctamente");
        }else{
            $this->session->set_flashdata('error', "Las facturas desgloses no se pudieron editar");
        }
        if($redict)
        {
            $this->session->set_flashdata('tab_flag', "desglose");
            redirect('/tpoadminv1/capturista/facturas/editar_factura/'.$this->input->post('id_factura'));
        } 
        
    }

    function eliminar_factura_desglose()
    {
        //Validamos que el usuario tenga acceso
        $this->permiso_capturista();

        $this->load->model('tpoadminv1/capturista/Facturas_model');

        $eliminar = $this->Facturas_model->eliminar_factura_desglose($this->uri->segment(5));

        if($eliminar == 1){
            $this->session->set_flashdata('exito', "Registro eliminado correctamente");
        }else {
            $this->session->set_flashdata('error', "Registro no se pudo eliminar");
        }
        $this->session->set_flashdata('tab_flag', "desglose");
        redirect('/tpoadminv1/capturista/facturas/editar_factura/'. $this->uri->segment(6));
    }

    function id_presupuesto_concepto_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_presupuesto_concepto_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function id_presupuesto_concepto_solicitante_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_presupuesto_concepto_solicitante_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function id_servicio_categoria_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_servicio_categoria_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

    function id_servicio_subcategoria_check($str)
    {
        if($str == '0')
        {
            $this->form_validation->set_message('id_servicio_subcategoria_check', 'El campo {field} es obligatorio');
            return FALSE;
        }else{
            return TRUE;
        }
    }

}

?>